<?php

/**
 * Modelo da classe Usuario
 * @filesource
 * @author 		Leonardo Danieli
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Usuario extends Db_Table {

    protected $_name = 'usuario';
    public $_primary = 'id_usuario';
    protected $_classList = array(array('nome' => 'Permissao', 'campo' => 'id_usuario'));
    protected $_log_ativo = false;
    protected $_log_text = 'Usuário';
    protected $_log_info = 'a_nomecompleto';

    public static function getIdExternoLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        return $usuario->a_idexterno;
    }

    public static function getNomeUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getNomeCompleto();
    }

    public static function getDadosSmtpUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario)) {
            $config = array(
                'ssl' => 'tls',
                'auth' => 'login',
                'port' => $usuario->getPorta(),
                'username' => $usuario->getEmail(),
                'password' => $usuario->getSenhaEmail(),
                'smtp' => $usuario->getSmtp()
            );
//            print'<pre>';die(print_r( $config ));
            return $config;
        }
    }

    public static function getEmailUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getEmail();
    }

    public static function getIdUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getID();
    }

    public static function getIdExternoUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getIDExterno();
    }

    function getNomeUsuarioIdExterno() {
        return Fichatecnica::getTecnicoList($this->getid_externo());
    }

    function getDificuldade() {
        return json_decode($this->a_dificuldade);
    }

    function setDificuldade($param) {
        $this->a_dificuldade = json_encode($param);
    }

    /**
     * Retorna a lista de Tecnicos do sistema de OS
     *
     * @return array
     */
    static function getUsuarioGilneiList($i = '') {

//        if (!isset($_SESSION['getTecnicoList'])) {
        $lObjLst = new Db_Sinigaglia();
        $lObjLst->query("SELECT Usuarios.Tecnico as CodigoTecnico,"
                . " Usuarios.Nome as Apelido  "
                . "FROM Usuarios "
                . "ORDER BY Usuarios.Nome;"
        );
        $rows = $lObjLst->fetchAll();

        $list = array();
        $list[""] = "";
        foreach ($rows as $row) {
            $list[$row["CodigoTecnico"]] = utf8_encode($row["Apelido"]);
        }
        $_SESSION['getTecnicoList'] = $list;
//        } else {
//            $list = $_SESSION['getTecnicoList'];
//        }
//        print'<pre>';
//        die(print_r($list));
        if (intval($i) != 0) {
//            print'<pre>';(print_r(str_pad($i, 3, '0', STR_PAD_LEFT)  ));
            return $list[str_pad($i, 3, '0', STR_PAD_LEFT)];
        }
        return $list;
    }

    /**
     * Retorna a lista de Tecnicos do sistema de OS
     *
     * @return array
     */
    static function getUsuarioList($indice = '') {

        if (!isset($_SESSION['getUsuarioList'])) {
            $lObjLst = new Usuario();
            $lObjLst->where('ativo', 'S');
            $lObjLst->where('tipo', 'user');
            $lObjLst->readLst();
            $list = array();
            $list[""] = "";
            for ($i = 0; $i < $lObjLst->countItens(); $i++) {
                $User = $lObjLst->getItem($i);
                $list[$User->getID()] = $User->getNomeCompleto();
            }
            $_SESSION['getUsuarioList'] = $list;
        } else {
            $list = $_SESSION['getUsuarioList'];
        }
//        print'<pre>';
//        die(print_r($list));
        if (intval($indice) != 0) {
//            print'<pre>';(print_r(str_pad($i, 3, '0', STR_PAD_LEFT)  ));
            return $list[$indice];
        }
        return $list;
    }

    public function setDataFromRequestDificuldade($post) {
        $this->setDificuldade($post->dificuldade);
    }

    public function setDataFromRequest($post) {
        $this->setDificuldade($post->dificuldade);
        $this->setNomeCompleto($post->nomeCompleto);
        $this->setLoginUser($post->loginUser);
        $this->setTipo($post->tipo);
        $this->setGrupo($post->grupo);
        $this->setEmail($post->email);
        $this->setrecebecomunicacaointerna($post->recebecomunicacaointerna);
        $this->setSmtp($post->smtp);
        $this->setPorta($post->porta);
        $this->setAssinaturaEmail($post->assinaturaEmail);
        $this->setAtivo($post->ativo);
        $this->setIdExterno($post->idexterno);
        $this->setExcluivel(cTRUE);
        $this->setEditavel(cTRUE);
        if ($post->senha != '') {
            $this->setSenha(Format_Crypt::encryptPass($post->senha));
//            $this->setDataSenha(date('Y-m-d'));
        }
        if ($post->senhaEmail != '') {
            $this->setSenhaEmail($post->senhaEmail);
        }
        $this->setId_Empresa($post->id_empresa);
    }

    public function getNomeGrupo() {
        if ($this->getGrupo() != 0 && $this->getGrupo() != '') {
            $user = new Usuario();
            $user->read($this->getGrupo());
            return $user->getNomeCompleto();
        }
    }

    public function getPermissoesLst() {
        return $this->permissoesLst;
    }

    public function readLst($modo = 'obj') {
        if ($modo == 'obj') {
            parent::readLst($modo);
            for ($i = 0; $i < $this->countItens(); $i++) {
                $item = $this->getItem($i);
                $item->read();
            }
            return $this;
        } else {
            return parent::readLst($modo);
        }
    }

    public function classList() {

        $perGrupo = array();
        $perUser = array();

        if ($this->getID() != '') {
            $item = new Permissao();
            $item->join('processo', 'permissao.id_processo = processo.id_processo', 'id_processo, nome, descricao, controladores');
            $item->where('id_usuario', $this->getID());
            $item->readLst();
            $perUser = $item->getItens() != '' ? $item->getItens() : array();
        }

        if ($this->getGrupo() != 0) {
            $item = new Permissao();
            $item->join('processo', 'permissao.id_processo = processo.id_processo', 'id_processo, nome, descricao, controladores');
            $item->where('id_usuario', $this->getGrupo());
            $item->readLst();
            $perGrupo = $item->getItens() != '' ? $item->getItens() : array();
        }

        foreach ($perGrupo as $key) {
            $key->setTipo('permissao');
//			$key->setOwner($idUser);
            $key->setGrupo('S');
            $key->setState('');
            $permissoes[strtolower($key->getNome())] = $key;

            $keyClone = clone $key;

            $controllers = explode(', ', $key->getControladores());
            foreach ($controllers as $value) {
                if ($value != '') {
                    $keyClone->setTipo('controlador');
                    $permissoes[strtolower($value)] = $keyClone;
                }
            }
        }

        foreach ($perUser as $key) {
            $key->setTipo('permissao');
            $key->setOwner($idUser);
            $key->setGrupo('N');
            $key->setState('');
            $permissoes[strtolower($key->getNome())] = $key;

            $keyClone = clone $key;

            $controllers = explode(', ', $key->getControladores());
            foreach ($controllers as $value) {
                if ($value != '') {
                    $keyClone->setTipo('controlador');
                    $permissoes[strtolower($value)] = $keyClone;
                }
            }
        }

        $this->permissoesLst = $permissoes;
    }

    /**
     * Verifica se o usuario pode acessar uma determinada area do sistema ou executar uma determinada ação.
     *
     * @param $controlador or $processo
     * @param $acao
     * @return boolean
     */
    public static function verificaAcesso($controlador, $acao = 'ver') {

        if (is_bool($controlador)) {
            return $controlador;
        }

        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;

        $permissoes = $usuario->permissoesLst;
        if ($permissoes != '') {
            if (array_key_exists('all', $permissoes)) {
                return true;
            } else if (array_key_exists(strtolower($controlador), $permissoes)) {
                $get = "get$acao";
                if ($permissoes[strtolower($controlador)]->$get() == cTRUE) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    public static function getListaProcessos() {
        $processo = new Processo();
        $processos = $processo->readLst('array');

        $user = Usuario::getInstance('userEdit');

        $permissoesUser = $user->permissoesLst;

        if ($permissoesUser == '') {
            $permissoesUser = array();
        }

        $return = '';

        $primary = $processo->getPrimaryName();
        foreach ($processos as $item) {
            $flag = false;
            foreach ($permissoesUser as $permissaoUser) {
                if ($item['nome'] == $permissaoUser->getNome() && $permissaoUser->getState() != cDELETE && $permissaoUser->getGrupo() == 'N') {
                    $flag = true;
                }
            }
            if (!$flag) {
                $return[] = array('key' => $item[$primary], 'value' => $item['descricao']);
            }
        }
        return $return;
    }

    public function save() {

        //print_r($this);die('<br><br>\n\n' . ' Linha: ' . __LINE__ . ' Arquivo: ' . __FILE__);

        switch ($this->getState()) {

            case cDELETE:

                $permissoes = new Permissao;
                $permissoes->where('id_usuario', $this->getID());
                $permissoes->readLst();
                $permissoes->setDeleted();
                $permissoes->save();

                parent::save();
                break;

            case cCREATE:
            case cUPDATE:

                //	print_r($this);die('<br><br>\n\n' . ' Linha: ' . __LINE__ . ' Arquivo: ' . __FILE__);

                parent::save();
                $permissoesLst = $this->permissoesLst;


                if ($permissoesLst == '') {
                    $permissoesLst = array();
                }

                foreach ($permissoesLst as $permissao) {
                    if ($permissao->getTipo() == 'permissao' && $permissao->getGrupo() == 'N') {
                        $permissoes = new Permissao;
                        $permissoes->setID($permissao->getId_permissao());
                        $permissoes->setID_Usuario($this->getID());
                        $permissoes->setID_Processo($permissao->getId_Processo());
                        $permissoes->setOwner($this->getID());
                        $permissoes->setState($permissao->getState());
                        $permissoes->setVer($permissao->getVer());
                        $permissoes->setInserir($permissao->getInserir());
                        $permissoes->setExcluir($permissao->getExcluir());
                        $permissoes->setEditar($permissao->getEditar());
                        $permissoes->save();
                    }
                }
                break;
        }
    }

}
