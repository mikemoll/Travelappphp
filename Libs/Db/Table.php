<?php

/**
 * Classe para manipulação dos objetos
 * 
 * @version 19/03/2013
 * @author Ismael Sleifer <ismael@gmail.com.br>
 * @author Leonardo Danieli <leonardo@4coffee.com.br>
 * 
 */
class Db_Table extends Zend_Db_Table {

    /**
     * Colunas a serem buscadas na consulta sql
     */
    protected $_columns = '';

    /**
     * Adiciona a consulta a uma view em vez de uma tabela mas pode ser passado uma outra tabela
     */
    protected $_view;

    /**
     * Lista de filtros "where" da consulta
     */
    protected $_whereSelect = array();
    protected $_filters = array();

    /**
     * Lista de junções "joins" da consulta
     */
    protected $_joins = array();
    protected $_havings = array();

    /**
     * Agrupamaneto das linhas
     */
    protected $_group = false;

    /**
     * Lista de ordenação ASC/DESC
     */
    protected $_sortOrder;
    /*
     * numero de linhas a serem retornadas na consulta
     */
    protected $_limit = 0;

    /**
     * numero da pagina para consulta
     */
    protected $_offset = 0;

    /**
     * Lista de classes buscadas na consulta
     */
    protected $_list;

    /**
     * Lista de classes que sera incluida no leitura do objeto pai,
     * deve ser passado um array com o nome da classe e campo do id que serão listadas,
     * para cada classe será executada a função classList, buscando todos os campos da classe
     * caso queira uma consulta especifica, implementar a função classList no modelo
     *
     * ex: array(array('name'=>User, 'id'=>id_user))
     */
    protected $_classList = array();

    /**
     * Ativa ou desativa a leitura da lista de objetos dependentes.
     * Usados para a leitura dos dados aprensados no grid para evitar a demora na apresentação.
     * o proprio grid ja seta para false esta opção
     */
    protected $_readList = true;

    /**
     * estado do objeto se e cCREATE, cUPDATE ou cDELETE
     */
    protected $_state = cCREATE;

    /**
     * id do objeto pai da classe
     */
    protected $_owner = '';

    /**
     * ativa o log para todas as classes filhas
     */
    protected $_log_ativo = cLOG_ATIVA;

    /**
     * Habilita ou desabilita a formatação dos valores lidos do banco,
     * no banco de dados os valores estão salvos no formato html, mas quando e lido os valores para colocar no campos de texto aparece os
     * valores em html e usado para corrigir isso a função Format_String::htmlToString();, mas na comparação dos dados do log ela não pode
     * ser usada, pois quando os dados vem pelo post o sistema trata os dados para evitar SQL Injection ou funções javaScript
     */
    protected $_formatData = true;

    /**
     * Nome do campo de que sera pego o texto para gravar o log
     *
     * obs: sempre informar este campo nos modelos, so não e preciso se for a_descricao
     * ex: a_descricao
     */
    protected $_log_info = 'a_descricao';

    /**
     * texto utilizado no log para delete ou insert
     * ex: $_log_text = 'Usúario' - log: Deletado Usúario Ismael.....
     */
    protected $_log_text = '';

    /**
     * Atributo que contem o texto que será usado na criação do log.
     * Este atributo e preenchido com um dos campos do banco de dados na função read, usando junto o atributo $_log_info
     * para saber qual campos pegar o texto.
     * @var String
     */
    protected $_text_log = '';

    /**
     * configura a leitura do total de itens da tabela
     * por padrão ele não busca o total de linhas da tabela
     * @var Bool;
     */
    protected $_readCount = false;
    protected $_removeJoin = false;

    /**
     * Se é pra colocar no INSERT os valores da(s) PK
     * @var boolean
     */
    protected $_store_primary = false;

    /**
     * Guarda no Item da lista "_list" a sua própria posição nela, para ser utilizado no addItem(), quando não se tem a posição que ele estava
     * @var type
     */
    protected $_listPosition = 0;

    public function setTextLog($text) {
        $this->_text_log = $text;
    }

    public function getTextLog() {
        return $this->_text_log;
    }

    public function setRemoveJoin() {
        $this->_removeJoin = true;
    }

    public function setReadCount() {
        $this->_readCount = true;
    }

    public function setDataFromRequest($post) {
        $campos = $post->getEscaped();
        $info = $this->info();
        foreach ($campos as $key => $value) {
            if (array_key_exists($key, $info['metadata'])) {
                $key = "a_$key";
                $this->$key = $value;
            }
        }
    }

    /*
     *
     * === Metodo que implementa todos os GET/SET da classe =====
     *
     * @author Leonardo
     * @date 20-09-2009
     *
     */

    public function __call($metodo, $parametros) {

        // se for set*, "seta" um valor para a propriedade
        if (substr($metodo, 0, 3) == 'set') {
            $var1 = strtolower(substr($metodo, 3));
            $var = 'a_' . $var1;
            //            if (!property_exists($this, $var)) {
            //               die('Método--> set' . $var1 . '() não existe em ' . get_class($this));
            //            }else
            if (!is_array($parametros[0])) {
                $this->$var = Format_String::htmlToString(trim($parametros[0]));
            } else {
                foreach ($parametros[0] as $key => $value) {
                    $parametros[0][$key] = Format_String::htmlToString(trim($value));
                }
                $this->$var = $parametros[0];
            }
        }
        // se for get*, retorna o valor da propriedade
        elseif (substr($metodo, 0, 3) == 'get') {
            $var1 = strtolower(substr($metodo, 3));
            $var = 'a_' . $var1;
            if (!property_exists($this, $var)) {
                //                        die('Método--> get' . $var1 . '() não existe em ' . get_class($this));
                //				throw new Zend_Db_Table_Exception("Há propriedade \"$var\" não existe ou não foi setada na classe ".get_class($this));
            } else {
                return $this->$var;
            }
        }
    }

    /**
     * Função chamada quando um item é clonado.
     *
     * Ele muda o state do objeto para cCREATE e apaga o ID para que seja criado um novo ao salva-lo no DB
     */
    function __clone() {
        $this->setID('');
        $this->setState(cCREATE);
    }

    /**
     * Adiciona um objeto na memoria
     *
     * @param type $nome
     * @param type $group
     */
    public function setInstance($nome, $group = '') {
        $session = Zend_Registry::get('session');
        if ($group != '') {
            if (!isset($session->$group)) {
                $session->$group = array();
            }
            $a = $session->$group;
            $a[$nome] = serialize($this);
            $session->$group = $a;
        } else {
            $session->$nome = serialize($this);
        }
        Zend_Registry::set('session', $session);
    }

    /**
     * Retorna um objeto da memoria
     *
     * @param type $nome
     * @param type $group
     * @return type
     */
    static function getInstance($nome, $group = '') {
        $session = Zend_Registry::get('session');
        if ($group != '') {
            $a = $session->$group;
            return unserialize($a[$nome]);
        } else {
            return unserialize($session->$nome);
        }
    }

    /**
     * Seta a id no proprio o objeto na propriedade a_id ....
     * @param $id
     */
    public function setID($id) {
        $primary = 'a_' . $this->getPrimaryName();
        $this->$primary = $id;
    }

    public function getID() {
        $primary = 'a_' . $this->getPrimaryName();
        if (isset($this->$primary)) {
            return $this->$primary;
        }
    }

    public function setOwner($id) {
        $this->_owner = $id;
    }

    public function getOwner() {
        return $this->_owner;
    }

    /**
     * 
     * @param string $keyName é possivel passar o nome de uma coluna ou o nome de um método para ser o Key da lista
     *                          (EX: "ID" dessa forma o Key será pegada pelo metodo getID())
     * @param string $valueName é possivel passar o nome de uma coluna ou o nome de um método para ser o Value da lista
     *                          (EX: "DescricaoFormatado" dessa forma a descricao será pegada pelo metodo getDescricaoFormatado())
     * @param mix $class [objeto|string] pode ser o nome da classe ou um objeto para ser uilizado na listagem
     * @param boolean $firstEmpty define se deve ou não deixar a primeira opção da lista em branco
     * @return array
     * @throws Zend_Db_Table_Exception
     */
    public static function getOptionList($keyName, $valueName, $class, $firstEmpty = true) {
        if ($firstEmpty) {
            $return[] = array('key' => '', 'value' => '---');
        }

        if (is_object($class)) {
            $lista = $class->readLst('array');
        } else if ($class != '') {
            $item = new $class;
            if (!method_exists($item, 'get' . $valueName)) {
                $item->sortOrder($valueName);
                $lista = $item->readLst('array');
            } else {
                $lista = $item->readLst();
            }
        } else {
            throw new Zend_Db_Table_Exception('Deve ser passado um objeto ou um nome de modelo');
        }

        if (is_object($lista)) {
            $itens = $lista->getItens();
            $getKey = 'get' . $keyName;
            $getValue = 'get' . $valueName;
            foreach ($itens as $litem) {
                $return[] = array('key' => $litem->$getKey(), 'value' => $litem->$getValue());
            }
        } else if ($lista !== false) {
            unset($lista['totalItens']);
            if (count($lista) > 0) {
                foreach ($lista as $litem) {
                    $return[] = array('key' => $litem[$keyName], 'value' => $litem[$valueName]);
                }
            }
        }
        if ($return == '') {
            $return = array();
        }
        return $return;
    }

    /**
     *
     * @param type $keyName
     * @param type $valueName
     * @param type $orderName
     * @param type $class
     * @param type $firstEmpty
     * @return array
     * @throws Zend_Db_Table_Exception
     */
    public static function getOptionList2($keyName, $valueName, $orderName, $class, $firstEmpty = true) {
        if ($firstEmpty) {
//            $return[] = array('key' => '', 'value' => '---');
            $return[] = '---';
        }

        if (is_object($class)) {
            $lista = $class->readLst();
        } else if ($class != '') {
            $item = new $class;
            $item->sortOrder($orderName);
            $lista = $item->readLst();
        } else {
            throw new Zend_Db_Table_Exception('Deve ser passado um objeto ou um nome de modelo');
        }

        for ($i = 0; $i < $lista->countItens(); $i++) {
            $Item = $lista->getItem($i);
            $getKey = "get$keyName";
            $getValue = "get$valueName";
//            $return[] = array('key' => $Item->$getKey(), 'value' => $Item->$getValue());
            $return[$Item->$getKey()] = $Item->$getValue();
        }
        if ($return == '') {
            $return = array();
        }
        return $return;
    }

    /**
     * Retorna os nomes das chaves primarias da tabela
     *
     * @return array
     */
    public function getPrimaryNameList() {
        if (is_array($this->_primary)) {
            $PrimaryKey = $this->_primary;
        } else {
            $PrimaryKey = array($this->_primary);
        }
        return $PrimaryKey;
    }

    /**
     * Retorna o nome da chave primaria da tabela
     *
     * @return string
     */
    public function getPrimaryName() {
        if (is_array($this->_primary)) {
            $PrimaryKey = $this->_primary[1];
        } else {
            $PrimaryKey = $this->_primary;
        }
        return $PrimaryKey;
    }

    /**
     * Muda o estado do objeto para novo, atualizar ou deletar
     * @param $state  cCREATE, cUPDATE ou cDELETE 
     */
    public function setState($state) {
        $this->_state = $state;
    }

    /**
     * Retorna o estado do objeto se ele e para novo, atualizar ou deletar
     * @return integer
     */
    public function getState() {
        return $this->_state;
    }

    /**
     * seta o objeto como deletado para ser deletado no save do objeto
     */
    public function setDeleted() {
        $this->_state = cDELETE;
    }

    /**
     * Retorna se o objeto foi marcado para ser deletado
     * @return unknown_type
     */
    public function deleted() {
        if ($this->_state == cDELETE) {
            return true;
        } else
            return false;
    }

    /**
     * Desabilita a formatação dos dados na leitura do objeto.
     * retornando os dados no
     */
    public function notFormatData() {
        $this->_formatData = false;
    }

    /**
     * Retorna o numeto total de itens da lista mesmo eles estando marcados para deletados
     * @return int
     */
    public function countItens() {
        return count($this->_list);
    }

    /**
     * Retorna o numero de itens NÂO deletados na lista
     * @return int
     */
    public function countItensNotDeleted() {
        $count = 0;
        for ($i = 0; $i < $this->countItens(); $i++) {
            $Item = $this->getItem($i);
            if (!$Item->deleted()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Retorna um item da lista
     * @param int $index
     * @return object
     */
    public function getItem($index) {
        return $this->_list[$index];
    }

    /**
     * Busca um item na lista procurando pelo id passado e retorna esse item
     * @param int $id id do item procurado
     * @return object
     */
    public function getItemById($id) {
        if ($this->countItens() > 0)
            foreach ($this->_list as $key => $item) {
                if ($item->getID() == $id)
                    return $this->_list[$key];
            }
    }

    /**
     * Adiciona ou substitui (se passado o index) um item na lista
     *
     * @param string $value
     * @param int $index
     */
    public function addItem($value, $index = '') {
        if (trim($index) == '') {
            $value->_listPosition = count($this->_list);
            $this->_list[] = $value;
        } else {
            $value->_listPosition = $index;
            $this->_list[$index] = $value;
        }
    }

    /**
     * Adiciona ou substitui (se passado o index) um item na lista
     *
     * @param string $value
     * @param int $index
     */
    public function add($value, $index = '') {
        $this->addItem($value, $index);
    }

    public function getListPosition() {
        return $this->_listPosition;
    }

    /**
     * Retorna dos os itens da lista
     * @return objects
     */
    public function getItens() {
        return $this->_list;
    }

    /**
     * Função que retorna a lista de classes
     * O parametro $array e usado para passar parametro para a função.
     */
    public function classList() {
        foreach ($this->_classList as $class) {
            $nameClass = $class['nome'];
            $obj = new $nameClass();
            $obj->where($class['campo'], $this->getID());
            $obj->readLst();
            $name = strtolower($class['nome']) . 'Lst';
            $this->$name = $obj->getItens();
        }
    }

    /**
     * Desativa a leitura das listas do objeto.
     */
    public function setNoReadList() {
        $this->_readList = false;
    }

    /**
     * Adiciona as colunas a serem buscadas na consulta
     * obs: colunas separadas por "ponto-e-virgula"
     *
     * @param string $columns ex: coluna1; coluna2; coluna3
     */
    public function columns($columns) {
        if (!is_array($columns)) {
            $colunas = explode(';', $columns);
        } else {
            $colunas = $columns;
        }
        foreach ($colunas as $nome) {
            $array[] = trim($nome);
        }
//        print'<pre>';die(print_r( $colunas ));
        $this->_columns = $array;
        return $this;
    }

    /**
     * Adiciona uma view ou outra tabela na consulta.
     * obj: será removido qualquer outro valor do from e adicionado o valor da view
     *
     * @param String $view
     */
    public function addView($view) {
        $this->_view = $view;
    }

    /**
     * condições para clausula where
     * <br><br>
     * com o parametro $group é possivel agrupar as condicoes.<br>
     * EX: <pre>( ... where (nome = 'foo' or nome = 'bar') and ativo = 'S' ...)</pre>
     * Nesse exemplo o campo 'nome' estava em um grupo (que pode ser qualquer nome) e o campo 'ativo' estava sem grupo.<br>
     * Isso é feito assim:<br>
     * <pre>
     *  $Lst->where('ativo', 'S', '=', 'and');
     *  $Lst->where('nome', 'foo', 'like', 'or', 'grupoNome'); // o parametro $group pode ser qualquer nome
     *  $Lst->where('nome', 'bar', 'like', 'or', 'grupoNome');
     * </pre>
     *
     * @param string $campo
     * @param string $valor
     * @param string $oper
     * @param string $glue [AND|OR]
     * @param string $group parametro usado para agrupar as condicoes
     * @return \Db_Table
     */
    public function where($campo, $valor, $oper = '=', $glue = 'and', $group = '') {
        if ($campo != '') {
            if (strpos(strtoupper($valor), 'NULL') !== FALSE) {
                $where['campo'] = "$campo $valor";
            } elseif ($oper == 'like' || $oper == 'ilike') {
                $where['campo'] = "UPPER($campo) " . $oper . ' ? ';
                $where['valor'] = '%' . strtoupper(Format_String::htmlToString($valor)) . '%';
            } else {
                $where['campo'] = $campo . ' ' . $oper . ' ? ';
                $where['valor'] = Format_String::htmlToString($valor);
            }
            $where['glue'] = $glue;
            $where['group'] = $group;
            $this->_whereSelect[$group][] = $where;
        }
        return $this;
    }

    public function getWhere() {
        return $this->_whereSelect;
    }

    /**
     * Parametros da junção "join"
     *
     * @param $table tabela de consulta
     * @param $cond condição da consulta ex: table.id_exemplo = table2.id_exemplo
     * @param $col colunas a serem retornadas
     * @param $type tipo de junção, inner [padrão], left, right, full, cross, natural
     * @param $schema esquema do banco de dados
     */
    public function join($table, $cond, $cols, $type = 'inner', $schema = null) {
        $arrayCols = explode(',', $cols);
        foreach ($arrayCols as $key) {
            $array[] = trim($key);
        }
        $this->_joins[] = array('table' => $table, 'cond' => $cond, 'col' => $array, 'type' => $type, 'schema' => $schema);
        return $this;
    }

    /**
     * condições de retorno de consulta
     *
     * @param $cond
     * @param $glue
     */
    public function having($cond, $glue = 'and') {
        $this->_havings[] = array('cond' => $cond, 'glue' => $glue);
        return $this;
    }

    /**
     * Agrupamento das linhas na consulta
     *
     * @param $flag true/false
     */
    public function groupBy($flag = true) {
        $this->_group = $flag;
        return $this;
    }

    /**
     * Agrupamento das linhas na consulta pelas colunas passadas
     *
     * @param $columns true/false
     */
    public function groupByColumn($columns) {
        $this->groupBy();
        $this->_groupByColumns = $columns;
        return $this;
    }

    /**
     * Ordenação do consulta adicionar a colunas e modo de ordenação separados por virgula.
     * Ex: coluna1 asc, colunas2 desc
     * @param string $column
     * @param string $order ordenacao do resultado
     */
    public function sortOrder($column, $order = 'asc') {
        if ($column != '') {
            $this->_sortOrder[] = $column . ' ' . $order;
        }
        return $this;
    }

    /**
     * Adiciona limites de linhas no retorno da consulta
     *
     * @param $limit numero de linhas a serem retornadas na consulta
     * @param $offset numero da pagina para consulta
     */
    public function limit($limit, $offset = 0) {
        $this->_limit = $limit;
        $this->_offset = $offset;
        return $this;
    }

    public function setNoFormatData() {
        $this->_formatData = false;
    }

    /**
     * Retorna todos os filtros para a consulta sql.
     * @return Zend_Db_Table_Select
     */
    protected function getSelect() {

        $select = $this->select();

        if ($this->_view != '') {
            if ($this->_columns != '') {
                $select->from(strtolower($this->_view), $this->_columns);
            } else {
                $select->from(strtolower($this->_view));
            }
        } else {
            if ($this->_columns != '') {
                $select->from($this->_name, $this->_columns);
            } else {
                $select->from(strtolower($this->_name));
            }
        }
//       6/7/16 - foi tirado daqui para colocar ali em cima no "if ($this->_columns != '')" then "$select->from($this->_name, $this->_columns);"
//        if ($this->_columns != '') {
//            $select->columns($this->_columns);
//        }

        foreach ($this->_joins as $key) {
            $select->setIntegrityCheck(false);
            if ($key['type'] == 'inner') {
                $select->join($key['table'], $key['cond'], $key['col'], $key['schema']);
            } else if ($key['type'] == 'left') {
                $select->joinLeft($key['table'], $key['cond'], $key['col'], $key['schema']);
            } else if ($key['type'] == 'right') {
                $select->joinRight($key['table'], $key['cond'], $key['col'], $key['schema']);
            } else if ($key['type'] == 'full') {
                $select->joinFull($key['table'], $key['cond'], $key['col'], $key['schema']);
            } else if ($key['type'] == 'cross') {
                $select->joinCross($key['table'], $key['col'], $key['schema']);
            } else {
                $select->joinNatural($key['table'], $key['col'], $key['schema']);
            }
        }

        foreach ($this->_whereSelect as $group => $condicoes) {
            if ($group != '') {
                $glue = '';
                $txtCond = '';
                foreach ($condicoes as $condicao) {
                    $txtCond .= strtoupper($glue) . " (" . str_replace('?', "'" . $condicao['valor'] . "'", $condicao['campo']) . ") ";
                    $glue = $condicao['glue'];
                }
                $select->where($txtCond);
            } else {
                foreach ($condicoes as $condicao) {
                    if ($condicao['glue'] == 'and') {
                        $select->where($condicao['campo'], $condicao['valor']);
                    } else {
                        $select->orWhere($condicao['campo'], $condicao['valor']);
                    }
                }
            }
        }
//        print'<pre>';
//        die(print_r($select->__toString()));

        foreach ($this->_havings as $key) {
            $this->_group = true;
            if ($key['glue'] == 'and') {
                $select->having($key['cond']);
            } else {
                $select->orHaving($key['cond']);
            }
        }

        if ($this->_group and ! empty($this->_groupByColumns)) {
            $columns = explode(';', $this->_groupByColumns);
            $nomeTable = strtolower(get_class($this));
            foreach ($columns as $nome) {
                $group[] = $nome;
            }
            $select->group($group);
        } else
        if ($this->_group) {
            $nomeTable = strtolower(get_class($this));
            foreach ($this->_columns as $nome) {
                $group[] = $nomeTable . '.' . $nome;
            }
            foreach ($this->_joins as $key) {
                $group[] = $key['table'] . '.' . $key['col'];
            }
            $select->group($group);
        }

        if ($this->_sortOrder != '') {
            $select->order($this->_sortOrder);
        }
        if ($this->_limit != '' && $this->_offset >= 0) {
            $select->limitPage($this->_offset, $this->_limit);
        }

        return $select;
    }

    public function getSql() {

        $select = $this->getSelect();
        return $select->__toString();
    }

    /**
     *
     * @param type $campo
     * @param type $valor
     * @param type $oper
     * @param type $glue 
     */
    public function addFilters($campo, $valor, $oper = '=', $glue = 'and') {
        if (is_array($campo)) {
            $campos = $campo;
        } else {
            $campos = array($campo);
        }
        foreach ($campos as $value) {
            if ($oper == 'like' || $oper == 'ilike') {
                $this->_filters[] = array('campo' => ' ' . $glue . ' ' . $value . ' ' . $oper . ' ? ', 'valor' => '%' . $valor . '%');
            } else {
                $this->_filters[] = array('campo' => ' ' . $glue . ' ' . $value . ' ' . $oper . ' ? ', 'valor' => $valor);
            }
        }
    }

    function getFilters() {
        if ($this->_filters != '') {
            $where = '1=1 ';
            foreach ($this->_filters as $val) {
                $where .= $this->getAdapter()->quoteInto($val['campo'], $val['valor']);
            }
            $this->_filters = '';
            return $where;
        }
    }

    /**
     *  efetua a contagem de quantas linhas a no banco de dados
     *  com os filtros passados retirando o a clausula limite
     */
    public function count() {

        $col = $this->getPrimaryName();
        $class = get_class($this);
        $item = new $class;
        $item->columns('count(' . $col . ') as count');
        $item->_joins = array();
        $item->_whereSelect = $this->_whereSelect;
        $count = $item->fetchAll($item->getSelect())->toArray();

        return $count[0]['count'];
    }

    public function found() {
        return $this->error == '' ? true : false;
    }

    /**
     * Faz uma leitura no banco de dados de apenas uma linha
     *
     * @param int $id
     * @param string $modo
     * @param $dataConection instance of Zend_Config_Ini
     * @return array or class
     */
    public function read($id = null, $modo = 'obj') {

        if ($id != null) {
            $this->setID($id);
        }
        if ($this->getID() == '') {
            throw new Zend_Db_Table_Exception('O ID do objeto não foi passado ou não está setado no objeto on line ' . __LINE__ . ' at ' . __FILE__);
        }

        $this->where($this->_name . '.' . $this->getPrimaryName(), $this->getID());

        if ($this->_removeJoin) {
            $this->_joins = array();
        }

        $filtros = $this->getSelect();
        $rows = $this->fetchAll($filtros)->toArray();
        if (count($rows) == 0) {
            $this->error = 'Item não Encontrado!';
            return false;
        }

        if ($modo == 'array' and ! $this->_formatData) {
            //se o modo de leitura é array e não é pra formatar os dados, retorna o array como veio
            return $rows;
        }



        foreach ($rows as $numLinha => $row) {
            foreach ($row as $key => $value) {
                if ($this->_formatData) {
                    $value = FormataDados::formataDadosRead($value);
                }
                if ($modo == 'array') {
                    $rows[$numLinha][$key] = $value;
                } else {
                    $key = 'a_' . $key;
                    $this->$key = $value;
                }
            }
        }
        if ($modo == 'array') {
            //se o modo de leitura é array e é pra formatar os dados, retorna o array apos formatá-lo
            return $rows;
        }

        $key = $this->_log_info;
        $this->setTextLog($this->$key);
        if ($this->_readList) {
            $this->classList();
        }

        $this->setState(cUPDATE);

        return $this;
    }

    /**
     * Faz uma leitura no banco de dados de retornando varias linhas
     *
     * @param string $modo
     * @return array or class
     */
    public function readLst($modo = 'obj') {

        if ($this->_removeJoin) {
            $this->_joins = array();
        }
        $this->sql = $this->getSql();
        $filtros = $this->getSelect();
//        print'<pre>';die(print_r( $filtros->__toString() ));
        $rows = $this->fetchAll($filtros)->toArray();
        if (count($rows) == 0) {
            $this->error = 'Nenhum foi item não encontrado!';
            return $this;
        }

        if ($modo == 'array') {
//            isso foi desativado pois tem um monte de readLst(array) onde eu estou tratando os dadso manualmente,
//            se eu fizer o tratamento dos dados aqui, vai dar pau quando eu fizer o tratamento no código que
//            eu já fiz... sim, é uma merda, mas....
//            O ideal seria ir no codigo fonte inteiro e desfazer o tratamento para que tudo seja feito aqui.
//            Um dia... hoje é 31/05/17, vamos ver até quando!
//            ATIVADO EM 08/07/2017 para o projeto TravelTrack
            if ($this->_formatData) {
                foreach ($rows as $numLinha => $row) {
                    foreach ($row as $key => $value) {
                        $value = FormataDados::formataDadosRead($value);
                        $rows[$numLinha][$key] = $value;
                    }
                }
            }
            $this->_list = $rows;
            return $rows;
        }



        if ($this->_readCount) {
            $this->totalitens = $this->count();
        }

        foreach ($rows as $numLinha => $row) {
            $nome = get_class($this);
            $item = new $nome;
            $item->setState(cUPDATE);
            foreach ($row as $key => $value) {
                $key = 'a_' . $key;
                if ($this->_formatData) {
                    $item->$key = FormataDados::formataDadosRead($value);
                } else {
                    $item->$key = $value;
                }
            }
            $key = $this->_log_info;
            $item->setTextLog($item->$key);
            $this->addItem($item, $numLinha);
        }
        return $this;
    }

    /**
     * Faz uma leitura SIMPLIFICADA no banco de dados para ser mostrado no grid
     *
     * a idéia é ela ser sobreescrita na classe filha.
     *
     * @param string $modo
     * @return array or class
     */
    public function readGrid($modo = 'obj') {
        return $this->readLst($modo);
    }

    public function save() {
        if ($this->countItens() > 0) {
            for ($i = 0; $i < $this->countItens(); $i++) {
                $item = $this->getItem($i);
                if ($this->deleted()) { //se o item esta marcado para delecao
                    $item->setDeleted();
                    $item->save();
                } else {
                    $item->save();
                }
            }
        } else {
            if ($this->deleted()) { // primeiro ele testa se o item esta setado para delecao, se sim, deleta!
                if ($this->getID() != '') { //so deleta do banco de dados se tiver um id setado, senao da erro no sql
                    $nameClass = get_class($this);
                    $class = new $nameClass;
                    $class->read($this->getID());
                    $this->addFilters($this->getPrimaryName(), $this->getID());
                    $this->delete($this->getFilters());

                    if ($this->_log_ativo) {

                        $text = $this->_log_info;

                        if ($this->getOwner() != '') {
                            //							Log::createLogSql($this, $this->getID(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLog($this->getOwner(), 'Deletado ' . $this->_log_text . ' ' . $class->getTextLog(), cLOG_DELETE, cLOG_ACAO_DELETE);
                        } else {
                            Log::createLogSql($this, $this->getID(), cLOG_SQL, cLOG_ACAO_DELETE);
                            Log::createLog($this->getID(), 'Deletado ' . $this->_log_text . ' ' . $class->getTextLog(), cLOG_DELETE, cLOG_ACAO_DELETE);
                        }
                    }
                }
                return $this;
            }

            $data = '';
            $atribs = get_object_vars($this);
            $idList = array();
            $names = $this->getPrimaryNameList();
            foreach ($names as $id) {
                if (key_exists('a_' . $id, $atribs)) {
                    $get = "get$id";
                    $idList[$id] = $this->$get();
                    if (!$this->_store_primary) {
                        unset($atribs['a_' . $id]);
                    }
                }
            }

            // percorre todos os atributos da classe para gerar o array dada
            foreach ($atribs as $key => $value) {
                $pos = strpos($key, 'a_');
                if ($pos !== false) {
                    $atrib = substr($key, 2);
                    $data[$atrib] = FormataDados::formataDadosSave($this, $atrib);
                }
            }
            if (is_array($data)) {
                if ($this->getState() == cUPDATE) {
                    foreach ($idList as $name => $valor) {
                        $this->addFilters($name, $valor);
                    }
                    if ($this->_log_ativo) {
                        $this->_log_ativo = Log::createLogCampos($this);
                    }
                    $this->update($data, $this->getFilters());
                    foreach ($idList as $name => $valor) {
                        $set = "set$name";
                        $this->$set($valor);
                    }

                    if ($this->_log_ativo) {
                        if ($this->getOwner() != '') {
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_UPDATE);
                        } else {
                            Log::createLogSql($this, $this->getId(), cLOG_SQL, cLOG_ACAO_UPDATE);
                        }
                    }
                } else if ($this->getState() == cCREATE) {
                    $id = $this->insert($data); //o insert e devolve o id do novo item do db
                    if (is_array($id)) {
                        foreach ($id as $name => $valor) {
                            $set = "set$name";
                            $this->$set($valor);
                        }
                    } else {
                        $this->setID($id);
                    }
                    $this->setState(cUPDATE);
                    if ($this->_log_ativo) {
                        $nomeClass = get_class($this);
                        $item = new $nomeClass;

                        if ($this->getOwner() != '') {
                            Log::createLogSql($this, $this->getOwner(), cLOG_SQL, cLOG_ACAO_INSERT);
                            $item->read($this->getID());
                            Log::createLog($this->getOwner(), 'Inserido ' . $this->_log_text . '<b> ' . $item->getTextLog() . '</b>', cLOG_INSERT, cLOG_ACAO_INSERT);
                        } else {
                            Log::createLogSql($this, $id, cLOG_SQL, cLOG_ACAO_INSERT);
                            $item->read($this->getID());
                            Log::createLog($this->getID(), 'Inserido ' . $this->_log_text . '<b> ' . $item->getTextLog() . '</b>', cLOG_INSERT, cLOG_ACAO_INSERT);
                        }
                    }
                }
            }
        }
        return $this;
    }

    /** retorna o tipo da coluna no banoc de dados.
     * 
     * @param String $nomeColuna
     * @return String
     */
    public function getTipoColuna($nomeColuna) {
        $info = $this->info('metadata');
        return $info[$nomeColuna]['DATA_TYPE'];
    }

    /** Retorna somente os tributos que iniciam com "a_" do Objeto em um array
     *
     * Essa função é util quando é necessario passar o objeto para o tamplate, mas somente os atributos vindos do DB
     *
     * @see Db_Sinigaglia;
     * @example FichaTecnicaController::visualizarAction();
     * @since 02/05/16
     * @author Leonardo Danieli <leonardo@4coffee.com.br>
     *
     * @return array
     */
    public function _toArray() {
        $vars = get_object_vars($this);
        foreach ($vars as $attr => $val) {
            if (strpos($attr, 'a_') !== false) {
                if (is_object($val) and substr(class_parents($val), 0, 3) == 'Db_') {
                    //caso atributo em questão seja um objeto, verifica se ele é do tipo Db_Tables, por exemplo.
                    // chama a função _toArray() recursivamente para ir transformando tudo em array.
                    $val = $val->_toArray();
                }
                $ret[substr($attr, 2)] = $val;
            }
        }
        return $ret;
    }

    /** Retorna os filtros utilizados para a lista formatado para mostrar no Relatório
     *
     * @since 21/07/16
     * @author Leonardo Danieli <leonardo@4coffee.com.br>

     * @return array
     */
    public function getFiltrosToRelatorio() {
        $filtros = $this->_whereSelect;

        foreach ($filtros as $filtro) {
            $re[] = str_replace('?', $filtro['valor'], $filtro['campo']);
        }
        if ($re)
            return implode(' | ', $re);
    }

    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    // ================ GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    /**
     *
     * @return boolean TRUE se foi bloqueado para esse usuario | FALSE se é somente leitura
     */
//    public function bloqueia() {
//        $BloqSessao = $this->getBloqueioSessao();
//        if (!$BloqSessao->bloqueado()) {
//            $BloqSessao->setID_Owner($this->getID());
//            $BloqSessao->bloqueia();
//            return true; //se ele foi bloqueado por esse usuário, retorna TRUE
//        }
//        return false;  // o item já estava bloqueado por outro usuario, ele retorna FALSE para saber que nao foi bloqueado para o usuario que chamou!
//    }
//
//    public function getBloqueadoPor() {
//        $BloqSessao = $this->getBloqueioSessao();
//        return $BloqSessao->getBloqueadoPor();
//    }
//
//    public function getBloqueadoPorNome() {
//        $BloqSessao = $this->getBloqueioSessao();
//        $user = new Usuario();
//        $user->read($BloqSessao->getBloqueadoPor());
//        return $user->getNomeCompleto();
//    }
//
//    public function getTempoBloqueado() {
//        $BloqSessao = $this->getBloqueioSessao();
//        return $BloqSessao->getTempoBloqueado();
//    }
//
//    public function bloqueado() {
//        $BloqSessao = $this->getBloqueioSessao();
//        $BloqSessao->setID_Owner($this->getID());
//        return $BloqSessao->bloqueado();
//    }
//
//    /**
//     *
//     * @return BloqueioSessao
//     */
//    public function getBloqueioSessao() {
//        if (!$this->BloqueioSessao) {
//            $this->BloqueioSessao = new BloqueioSessao();
//            $this->BloqueioSessao->setNameOwner($this->_name);
//            $this->BloqueioSessao->setID_Owner($this->getID());
//            $this->BloqueioSessao->setID_Usuario(Usuario::getIdUsuarioLogado());
//        }
//        return $this->BloqueioSessao;
//    }
    // ==== /END ========= GERENCIAMENTO DE ITEM ABERTO NA TELA PARA EDIÇÃO =====================
    /** Limpa o objeto para ser enviado para o cliente.
     *
     * @param object $this
     * @return object retorna o objeto limpo
     */
    public function limpaObjeto() {
        unset($this->_db);
        unset($this->_name);
        unset($this->_primary);
        unset($this->_column);
        unset($this->_columns);
        unset($this->_view);
        unset($this->_whereSelect);
        unset($this->_filters);
        unset($this->_joins);
        unset($this->_havings);
        unset($this->_group);
        unset($this->_sortOrder);
        unset($this->_limit);
        unset($this->_offset);
        unset($this->_cols);
        unset($this->_schema);
        unset($this->_definitionConfigName);
        unset($this->_definition);
        unset($this->_store_primary);
        unset($this->_readList);
        unset($this->_classList);
        unset($this->_metadata);
        unset($this->_identity);
        unset($this->_sequence);
        unset($this->_log_ativo);
        unset($this->_owner);
        unset($this->_log_info);
        unset($this->_rowClass);
        unset($this->_rowsetClass);
        unset($this->_referenceMap);
        unset($this->_dependentTables);
        unset($this->_defaultSource);
        unset($this->_defaultValues);
        unset($this->_log_text);
        unset($this->_state);
        unset($this->_formatData);
        unset($this->_text_log);
        unset($this->_readCount);
        unset($this->_removeJoin);
        unset($this->_metadataCache);
        unset($this->_metadataCacheInClass);
//        unset($this->_dependentTables);

        $attrs = get_object_vars($this);
        foreach ($attrs as $attr => $value) {
            if (is_object($value)) {
                $this->$attr = $value->limpaObjeto();
//                print'<pre>';die(print_r($value  ));
            } else if ($attr == '_list') {
                $lista = $this->_list;
                if ($lista == '') {
                    unset($this->_list);
                } else if (count($lista) > 0) {
                    foreach ($lista as $attr2 => $value) {
                        if (is_object($lista[$attr2])) {
                            $o = $lista[$attr2];
                            $lista[$attr2] = $o->limpaObjeto();
                        }
                    }
                    $this->_list = $lista;
                }
            }
        }
        return $this;
    }

}
