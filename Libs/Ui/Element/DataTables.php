<?php

class Ui_Element_DataTables extends Zend_Form_Element {

    public $helper = 'formDataTables';

    /**
     * Id do grid
     *
     * @var String
     */
    protected $_id;

    /**
     * Url de consulta ao banco
     *
     * @var String
     */
    protected $url;

    /**
     * Tipo de retorno a consulta ao banco
     *
     * @var String
     */
    protected $dataType = 'json';

    /**
     * Nome do formulario onde estara o grid
     *
     * @var String
     */
    protected $formName;

    /**
     * Array de colunas do Grid
     *
     * @var Array
     */
    protected $colModel = array();

    /**
     * Array de bot�es do Grid
     *
     * @var Array
     */
    protected $buttons;

    /**
     * Itens de procura no banco
     *
     * @var Array
     */
    protected $searchItens;

    /**
     * Campo de ordena��o no grid
     *
     * @var String
     */
    protected $sortName = null;

    /**
     * Tipo de ordenação no grid
     * Padr�o 'asc'
     *
     * @var String
     */
    protected $sortOrder = 'asc';

    /**
     * Se � usado pagina��o
     * valor padr�o e true
     *
     * @var Boolean
     */
    protected $paging = 'true';

    /**
     * Titulo do grid
     *
     * @var String
     */
    protected $title;

    /**
     * Se quer que apare�a a caixa de numero de linhas por pagina
     * valor padr�o e true
     *
     * @var Boolean
     */
    protected $useRp = 'true';

    /**
     * Quantidade de linhas por pagina
     * Valor padr�o 25
     *
     * @var Integer
     */
    protected $rp = 25;

    /**
     * Se o Grid pode ser minimizado
     * Valor padr�o e false
     *
     * @var Boolean
     */
    protected $showTableToggleBtn = 'false';

    /**
     * Comprimento do Grid
     * Valor padr�o 700
     *
     * @var Integer
     */
    protected $width;

    /**
     * Altura do Grid
     * Valor padr�o 255
     *
     * @var
     */
    protected $height;

    /**
     * Aceita ou não multi seleção
     * Valor padr�o true sendo true valor para single sele��o
     *
     * @var
     */
    protected $singleSelect = 'true';

    /**
     * Configura as op��es de exibição de numero de linhas
     * por pagina.
     * Valores padrões 10, 15, 20, 25, 40
     *
     * @var String
     */
    protected $rpOptions = '[10, 15, 20, 25, 40]';

    /**
     * Se o Grid pode ser redimencionado
     * Valor padrão false
     *
     * @var boolean
     */
    protected $resizable = 'false';

    /**
     * Evento de edição da linha no grid
     * @var String
     */
    protected $eventEdit = 'dblclik';

    /**
     * Controllador do grid
     */
    protected $controller;
    protected $model; //nome da classe que vai preencher o grid
    protected $readMethod; // método de leitura que será usado para preencher o grid
    protected $rowns;
    protected $visible = true;
//    protected $paging = 'true';
    protected $searching = 'true';
    protected $ordering = 'true';
    protected $lengthChange = 'true';
    protected $info = 'true';
    protected $filter;
    protected $templateID;

    public function init() {
        $this->addDecorator('ViewHelper');

//        <script src="{$baseUrl}Public/Js/plugins/dataTables/jquery.dataTables.js"></script>
//        <script src="{$baseUrl}Public/Js/plugins/dataTables/dataTables.bootstrap.js"></script>
//        Browser_Control::setScript('js', 'DataTables3',   '../../site/Public/Js/jquery-ui.min.js');
//        Browser_Control::setScript('js', 'DataTables',   '../../site/Public/Js/plugins/dataTables/jquery.dataTables.js');
//        Browser_Control::setScript('js', 'DataTables2',   '../../site/Public/Js/plugins/dataTables/dataTables.bootstrap.js');
//        Browser_Control::setScript('css', 'DataTables', 'DataTables/datatables.min.css');


        Browser_Control::setScript('js', 'jquery.dataTables', '../../site/Public/assets/plugins/dataTables/jquery.dataTables.min.js');
        Browser_Control::setScript('js', 'dataTables.bootstrap4', '../../site/Public/assets/plugins/dataTables/dataTables.bootstrap4.min.js');
        Browser_Control::setScript('js', 'dataTables.buttons', '../../site/Public/assets/plugins/dataTables/dataTables.buttons.min.js');
        Browser_Control::setScript('js', 'buttons.bootstrap4', '../../site/Public/assets/plugins/dataTables/buttons.bootstrap4.min.js');
        Browser_Control::setScript('js', 'dataTables.responsive', '../../site/Public/assets/plugins/dataTables/dataTables.responsive.min.js');
        Browser_Control::setScript('js', 'responsive.bootstrap4', '../../site/Public/assets/plugins/dataTables/responsive.bootstrap4.min.js');

        Browser_Control::setScript('css', 'dataTables.bootstrap4', '../../site/Public/assets/plugins/datatables/dataTables.bootstrap4.min.css');
        Browser_Control::setScript('css', 'buttons.bootstrap4', '../../site/Public/assets/plugins/datatables/buttons.bootstrap4.min.css');
        Browser_Control::setScript('css', 'responsive.bootstrap4', '../../site/Public/assets/plugins/datatables/responsive.bootstrap4.min.css');
    }

    public function setTemplateID($val) {
        $this->templateID = $val;
    }

    public function setFormName($val) {
        $this->formName = $val;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAction($action) {
        $this->url = $action;
    }

    public function setSendFormValues($action = true) {
        if ($action) {
            $this->setAttrib('sendFormValues', 'sendFormValues');
        }
    }

    /**
     * 
     * @param type $title
     * @param type $action
     */
    public function setParams($title, $action) {
        $this->title = $title;
        $this->url = $action;
    }

    /** Configurações para o grid de recarregar de tempos em tempos
     *
     * @param type $intervalo
     * @param type $delay
     */
    public function setAutoUpdate($intervalo, $delay = '') {
        $this->autoUpdateInterval = $intervalo;
        if ($delay == '') {
            $delay = $intervalo;
        }
        $this->autoUpdateDelay = $delay;
    }

    /**
     * configura o campo e o tipo de ordenação do grid
     *
     * @param String $sortName nome da coluna
     * @param String $sortOrder tipo de ordenação
     */
    public function setOrder($sortName, $sortOrder = 'asc') {
        $this->sortName = $sortName;
        $this->sortOrder = $sortOrder;
    }

    /**
     * Habilita ou desabilita a paginação
     *
     * @param Boolean $val
     */
    public function setShowPager($val) {
        $this->paging = $val;
    }

    /**
     * Habilita ou desabilita a opção de manter a paginação, ordenação e filtragem da lista
     *
     * @param Boolean $val
     */
    public function setStateSave($val) {
        $this->StateSave = $val;
    }

    /**
     * Habilita ou desabilita a Busca
     *
     * @param Boolean $val
     */
    public function setShowSearching($val) {
        $this->searching = $val;
    }

    /**
     * Habilita ou desabilita a ORDENACAO
     *
     * @param Boolean $val
     */
    public function setShowOrdering($val) {
        $this->ordering = $val;
    }

    /**
     * Habilita ou desabilita a ORDENACAO Inicial (ao criar o Grid)
     *
     * @param Boolean $val
     */
    public function setInitialSort($val) {
        $this->initialSort = $val;
    }

    /**
     * Habilita ou desabilita a ComboBox com as quantidade de registro por página
     *
     * @param Boolean $val
     */
    public function setShowLengthChange($val) {
        $this->lengthChange = $val;
    }

    /**
     * Habilita ou desabilita as Informações abaixo do grid
     *
     * @param Boolean $val
     */
    public function setShowInfo($val) {
        $this->info = $val;
    }

    /**
     * configura o retorno dos dados das linhas do grid pode ser de dois tipo Json (default) e xml
     *
     * @param String $dataType
     */
    public function setDatatype($dataType) {
        $this->dataType = $dataType;
    }

    public function setDimension($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }

    public function setSingleSelect($singleSelect = false) {
        $this->singleSelect = $singleSelect;
    }

    public function setRpOptions($rpOptions = '10, 15, 20, 25, 40') {
        $this->rpOptions = '[' . $rpOptions . ']';
    }

    public function setResizable($resizable = false) {
        $this->resizable = $resizable;
    }

    public function addButton($button) {
        $this->buttons[] = $button;
    }

    public function setEventEdit($event) {
        $this->eventEdit = $event;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    /**
     * Adiciona um filtro ao grid, assim é possivel listar somente item que se encaixem à condição.
     *
     * EX: setFilter('Tipo','==','1') vai listar somente os itens do tipo 1
     * 
     * @param type $pProp
     * @param type $pOper
     * @param type $pVal
     */
    public function setFilter($pProp, $pOper, $pVal) {
        $f['prop'] = $pProp;
        $f['oper'] = $pOper;
        $f['val'] = $pVal;
        $this->filter = $f;
    }

    public function addSearch($search) {
        $this->searchItens[] = $search;
    }

    public function addColumn($column) {
        $this->colModel[] = $column;
    }

    public function getColumns() {
        return $this->colModel;
    }

    public function getButtons() {
        return $this->buttons;
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

    /**
     * 
     * @param type $model
     * @param type $readMethod
     */
    public function setFillListOptions($model, $readMethod) {
        $this->model = $model;
        $this->readMethod = $readMethod;
        $this->setRowns();
    }

    public function setFillListOptionsFromObj($model, $obj) {
        $this->model = $model;
        $this->rowns = $obj->getItens();
        $this->setRowns();
    }

    public function setRowns() {

//        if ($this->rowns == '') {
        $obj = new $this->model;
        if (!method_exists($obj, $this->readMethod)) {
            if ($this->readMethod != '') {
//                die("Nenhum metodo de letura foi  passado para montar o grid DataTables na classe <strong>$this->model</strong>." );
                die("Metodo <strong>{$this->readMethod}</strong> nao existe na classe <strong>$this->model</strong>.(" . __FILE__ . ' on line ' . __LINE__ . ")");
            }
        }


        if ($this->url == '') {
            //ele só faz o read da lista se não tiver o atributo URL, pois quer dizer que ele vai ser carregado via ajax
            $readMethod = $this->readMethod;
            $obj->$readMethod();
            $this->rowns = $obj->getItens();
        }
//        }
    }

    public function getOptions() {
        $attribs = get_object_vars($this);
        $id = $this->getId();
        $options = '{';
        $options .= '"sDom": ' . "'" . '<"top"f>rt<"bottom"pli><"clear">' . "',";
        if ($attribs['url']) {
            $options .= '"ajax": {
                                    "url": "' . $attribs['url'] . '",
                                        "type": "POST" ,
                                        "data": function ( d ) { return $("#' . $id . '").serialize()+"&idGrid=' . $id . '"; }

                                    },';
        }

        // ------- arrumando as coluna que são do tipo data para serem ordenadas certo! -----
        foreach ($attribs['colModel'] as $key => $value) {
            if (get_class($value) == 'Ui_Element_DataTables_Column_Date') {
                $numColDate[] = $key;
            }
            if ($value->getWidth() == 'hidden' or $value->getWidth() == '0' or ! $value->getVisible()) {
                $numColHidden[] = $key;
            }
        }
        if (count($numColDate) > 0 or count($numColHidden) > 0) {
            $options .= "
                columnDefs: [";
            if (count($numColDate) > 0) {
                $options .= "
                  { targets: [" . implode(',', $numColDate) . "],  type: 'date-br'},";
            }
            if (count($numColHidden) > 0) {
                $options .= "
                  { targets: [" . implode(',', $numColHidden) . "],  visible: false},";
            }
            $options .= "
                 ],
              ";
        }
        // ------- /end      Arrumando as coluna que são do tipo data para serem ordenadas certo! -----

        if ($attribs['sortName'] != '') {
            foreach ($attribs['colModel'] as $key => $value) {
                if ($value->getName() == $attribs['sortName']) {
                    $options .= '"order": [[ ' . $key . ' , "' . $attribs['sortOrder'] . '" ]],';
                }
            }
        }
        if ($attribs['height'] != '') {
            $options .= "
                scrollY: '{$attribs['height']}',
                scrollCollapse: true,
            ";
        }
//        if ($attribs['initialSort'] == false) {
//        $options .= "
//                bSort: false,
//            ";
//        }
        if ($attribs['searching'] == false) {
            $options .= "
                searching: false,
            ";
        }
        if ($attribs['ordering'] == false) {
            $options .= "
                ordering: false,
            ";
        }
        if ($attribs['paging'] == false) {
            $options .= "
                paging: false,
            ";
        }
        if ($attribs['StateSave'] == true) {
            $options .= "
                stateSave: true,
            ";
        }
        if ($attribs['lengthChange'] == false) {
            $options .= "
                lengthChange: false,
            ";
        }
        if ($attribs['info'] == false) {
            $options .= "
                info: false,
            ";
        }
        $options .= '
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Processando...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "Pesquisar",
    "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    }
            }
        ';
        $options .= ' }';
        return $options;
    }

}
