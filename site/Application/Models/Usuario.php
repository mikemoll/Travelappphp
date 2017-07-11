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
    protected $_log_text = 'User';
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

    public static function getIdUsuarioLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getID();
    }

    public static function getGroupUserLogado() {
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;
        if (is_object($usuario))
            return $usuario->getGrupo();
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

    public function getPhotoPath() {
        if ($this->a_Photo) {
            return HTTP_REFERER . 'Public/Images/Profile/' . $this->getID() . '_' . $this->a_Photo;
        } else {
            return HTTP_REFERER . 'Public/Images/people.png';//default image
        }
    }

    public function getAvarageStarsNumber() {
        $l = new Review();
        $l->join('bookedcourse', 'bookedcourse.id_bookedcourse = review.id_bookedcourse ', '');
        $l->join('course', ' course.id_course = bookedcourse.id_course and course.id_educator = ' . $this->getID(), '');
        $l->readLst();
        if ($l->countItens() > 0) {
            for ($i = 0; $i < $l->countItens(); $i++) {
                $lReview = $l->getItem($i);
                $countStars += $lReview->getStars();
            }
            $avg = $countStars / $l->countItens();
        }
        return $avg;
    }

    public function getAvarageStars() {
        $avg = $this->getAvarageStarsNumber();
        for ($i = 0; $i < $avg; $i++) {
            $ret .= "<i class='fa fa-star'></i>";
//            $ret .= '* ';
        }
        return $ret;
    }

    public function getCountEventHosted() {
        $l = new BookedCourse();
        $l->join('course', ' course.id_course = bookedcourse.id_course and course.id_educator = ' . $this->getID(), '');
        $l->readLst('array');
        return $l->countItens();
    }

    public function getCountReviews() {
        $l = new Review();
        $l->join('bookedcourse', 'bookedcourse.id_bookedcourse = review.id_bookedcourse ', '');
        $l->join('course', ' course.id_course = bookedcourse.id_course and course.id_educator = ' . $this->getID(), '');
        $l->readLst('array');
        return $l->countItens();
    }

    /**
     * Retorna a lista de Tecnicos do sistema de OS
     *
     * @return array
     */
    static function getUsuarioList($i = '') {

        if (!isset($_SESSION['getUsuarioList'])) {
            $lObjLst = new Usuario();
            $lObjLst->readLst('array');
            $rows = $lObjLst->fetchAll();
            $list = array();
            $list[""] = "";
            foreach ($rows as $row) {
                $list[$row["id_usuario"]] = utf8_encode($row["nomecompleto"]);
            }
            $_SESSION['getUsuarioList'] = $list;
        } else {
            $list = $_SESSION['getUsuarioList'];
        }
//        print'<pre>';
//        die(print_r($list));
        if (intval($i) != 0) {
//            print'<pre>';(print_r(str_pad($i, 3, '0', STR_PAD_LEFT)  ));
            return $list[$i];
        }
        return $list;
    }

    /**
     * Return a list of Users that are Companies
     *
     * @return array
     */
    static function getCompanyList($i = '') {

        $lObjLst = new Usuario();
        $lObjLst->where('grupo', '4'); // the group of Companyes
        $lObjLst->where('tipo', 'user'); // Just the users 
        $lObjLst->readLst('array');
        $rows = $lObjLst->getItens();
//        $rows = $lObjLst->fetchAll();
        $list = array();
        $list[""] = "";
        foreach ($rows as $row) {
            $list[$row["id_usuario"]] = utf8_encode($row["nomecompleto"]);
        }
        if (intval($i) != 0) {
            return $list[$i];
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
        $this->setSmtp($post->smtp);
        $this->setPorta($post->porta);
        $this->setAssinaturaEmail($post->assinaturaEmail);
        $this->setAtivo($post->ativo);
        $this->setIdExterno($post->idexterno);
        $this->setTelephone($post->telephone);
        $this->setExcluivel(cTRUE);
        $this->setEditavel(cTRUE);
        $this->setLastname($post->lastname);
        $this->setBirthdate($post->birthdate);
        $this->setGender($post->gender);
        $this->setEducation($post->education);
        $this->setHometowncity($post->hometowncity);
        $this->setHometowncountry($post->hometowncountry);

        $this->setActualcity($post->actualcity);
        $this->setActualcountry($post->actualcountry);
        $this->setLiveincity($post->liveincity);
        $this->setLiveincountry($post->liveincountry);
        $this->setRelationship($post->relationship);
        $this->setBio($post->bio);
        $this->setInstagram($post->instagram);
        $this->setTwitter($post->twitter);
        $this->setFacebook($post->facebook);
        $this->setOccupation($post->occupation);
        $this->setDreamjob($post->dreamjob);
        $this->setCalendartype($post->calendartype);
        $this->setTraveledto($post->traveledto);

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
     * @param $acao ['ver'|'inserir'|'excluir'|'editar']
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

                $lLst = $this->getUserInterestsLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }

                $lLst = $this->getUserTravelertypesLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }

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

                $lInterestLst = $this->getUserInterestsLst();

                if ($lInterestLst->countItens() > 0) {
                    for ($i = 0; $i < $lInterestLst->countItens(); $i++) {
                        $Item = $lInterestLst->getItem($i);
                        $Item->setid_usuario($this->getID());
                        $Item->save();
                    }
                }

                $TtLst = $this->getUserTravelertypesLst();

                if ($TtLst->countItens() > 0) {
                    for ($i = 0; $i < $TtLst->countItens(); $i++) {
                        $Item = $TtLst->getItem($i);
                        $Item->setid_usuario($this->getID());
                        $Item->save();
                    }
                }
                break;
        }

    }


    public function setDataFromProfileRequest($post) {
        $this->setNomeCompleto($post->nomecompleto);
        $this->setLastname($post->lastname);
        $this->setEmail($post->email);
        $this->setTelephone($post->telephone);

        $this->setNomeCompleto($post->nomeCompleto);
        $this->setEmail($post->email);
        $this->setTelephone($post->telephone);
        $this->setBirthdate($post->birthdate);
        $this->setGender($post->gender);
        $this->setEducation($post->education);
        $this->setHometowncity($post->hometowncity);
        $this->setHometowncountry($post->hometowncountry);

        $this->setActualcity($post->actualcity);
        $this->setActualcountry($post->actualcountry);
        $this->setLiveincity($post->liveincity);
        $this->setLiveincountry($post->liveincountry);
        $this->setRelationship($post->relationship);
        $this->setBio($post->bio);
        $this->setInstagram($post->instagram);
        $this->setTwitter($post->twitter);
        $this->setFacebook($post->facebook);
        $this->setOccupation($post->occupation);
        $this->setDreamjob($post->dreamjob);
        $this->setCalendartype($post->calendartype);
        $this->setTraveledto($post->traveledto);

        if ( ($post->senha != '') && ($post->senha == $post->confirmpassword) ) {
            $this->setSenha(Format_Crypt::encryptPass($post->senha));
            //$this->setDataSenha(date('Y-m-d'));
        }
    }

    public static function getGroupsList($i = '') {
        $list[''] = ' - ';
        $list['3'] = 'I am an Educator';
        $list['4'] = 'I am a Company';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    public function setDataFromRegisterRequest($post) {
        $this->setNomeCompleto($post->nomecompleto);
        $this->setEmail($post->email);
        $this->setTelephone($post->telephone);
        $this->setGrupo($post->grupo);
        $this->setAtivo(cTRUE);
        $this->setExcluivel(cTRUE);
        $this->setEditavel(cTRUE);
        $this->setTipo('user');
        $this->setDificuldade('null');

        $this->setSenha(Format_Crypt::encryptPass($post->senha));
        $this->setDatasenha(date('d/m/Y'));
    }

    public function getApproved_decoded() {
        return ($this->getApproved() == 'S')?'Yes':'No';
    }

    public function getUserInterestsLst() {
        if ($this->UserInterestsLst == null) {
            $this->UserInterestsLst = new UserInterests();
        }
        return $this->UserInterestsLst;
    }

    public function getAllInterestsLst() {
        $objLst = new Interest();
        $objLst->readLst();
        if ($objLst->countItens() > 0) {
            for ($i = 0; $i < $objLst->countItens(); $i++) {
                $interest = $objLst->getItem($i);
                $list[$interest->getid_interests()] = $interest->getdescription();
            }
        } else {
            $list= array();
        }
        return $list;
    }

    public function getInterests() {
        $lLst = $this->getUserInterestsLst();
        if ($lLst->countItens() > 0) {
            for ($i = 0; $i < $lLst->countItens(); $i++) {
                $User = $lLst->getItem($i);
                $list[] = $User->getid_interest();
            }
        }
        return $list;
    }

    public function setUserInterestsLst($val) {
        $this->UserInterestsLst = $val;
    }

    function read($id = null, $modo = 'obj') {
        parent::read($id, $modo);

        $itemLst = new UserInterests();
        $itemLst->where('id_usuario', $this->getID());
        $itemLst->readLst();
        $this->setUserInterestsLst($itemLst);

        $itemLst = new UserTravelertype();
        $itemLst->where('id_usuario', $this->getID());
        $itemLst->readLst();
        $this->setUserTravelertypesLst($itemLst);

        return $this;
    }

    public function getAllTravelerTypesLst() {
        $objLst = new Travelertype();
        $objLst->readLst();
        if ($objLst->countItens() > 0) {
            for ($i = 0; $i < $objLst->countItens(); $i++) {
                $tt = $objLst->getItem($i);
                $list[$tt->getid_travelertype()] = $tt->getdescription();
            }
        } else {
            $list= array();
        }
        return $list;
    }

    public function getUserTravelertypesLst() {
        if ($this->UserTravelertypesLst == null) {
            $this->UserTravelertypesLst = new UserInterests();
        }
        return $this->UserTravelertypesLst;
    }

    public function gettravelertypes() {
        $objLst = $this->getUserTravelertypesLst();

        if ($objLst->countItens() > 0) {
            for ($i = 0; $i < $objLst->countItens(); $i++) {
                $User = $objLst->getItem($i);
                $list[] = $User->getid_travelertype();
            }
        } else {
            $list= array();
        }
        return $list;
    }

    public function setUserTravelertypesLst($val) {
        $this->UserTravelertypesLst = $val;
    }

}
