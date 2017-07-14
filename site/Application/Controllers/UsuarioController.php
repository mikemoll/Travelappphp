<?php

include_once 'AbstractController.php';

class UsuarioController extends AbstractController {

    public function init() {
        parent::init();
        Browser_Control::setScript('js', 'Md5', 'md5.js');
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->Action = 'Usuario';
        $this->Model = 'Usuario';
    }

    private function gridsAction($tipo) {
        $session = Zend_Registry::get('session');

        $form = new Ui_Form();
        $form->setName('formUsers');
        $form->setAction('Usuario');

        if ($tipo == 'user') {
            $idGrid = 'gridUsers';
        } else {
            $idGrid = 'gridGrupos';
        }

//        $accordion = new Ui_Element_Accordion('filtros');
//
//        $section = new Ui_Element_Section('section1');
//        $section->setTitle('Filtros');
//        $section->setTemplate('Usuario/filtros.tpl');
//
//        $element = new Ui_Element_Checkbox('ativoFiltro');
//        $element->setAttrib('grid', $idGrid);
//        $element->setChecked(cTRUE);
//        $element->setCheckedValue(cTRUE);
//        $element->setUncheckedValue(cFALSE);
//        $section->addElement($element);
//
//        $element = new Ui_Element_Text('loginUserFiltro');
//        $element->setAttrib('grid', $idGrid);
//        $section->addElement($element);
//
//        $element = new Ui_Element_Text('nomeCompletoFiltro');
//        $element->setAttrib('grid', $idGrid);
//        $section->addElement($element);
//
//        $element = new Ui_Element_Btn('btnFiltrar');
//        $element->setDisplay('Filtrar', PATH_IMAGES . 'Buttons/Find.png');
//        $element->setAttrib('event', '');
//        $element->setAttrib('updateGrid', $idGrid);
//        $section->addElement($element);
//
//        $element = new Ui_Element_Btn('btnLimparFiltros');
//        $element->setDisplay('Limpar', PATH_IMAGES . 'Buttons/Clear.png');
//        $section->addElement($element);
//        $accordion->addSection($section);
//
//        $form->addElement($accordion);

        $grid = new Ui_Element_DataTables($idGrid);
        if ($tipo == 'user') {
            $grid->setParams('', 'listaUsers');
        } else {

            $grid->setParams('', 'listaGrupos');
        }
        $grid->setFillListOptions('Usuario', 'readLst');


        if ($tipo == 'user') {
            $button = new Ui_Element_DataTables_Button('btnEditar', 'Modificar Usuário');
        } else {
            $button = new Ui_Element_DataTables_Button('btnEditarGrupo', 'Modificar Grupo');
        }
        $button->setImg('edit');
        $button->setVisible('CAD_EMPRESA', 'inserir');
        $grid->addButton($button);

//        if ($tipo == 'user') {
//            $button = new Ui_Element_DataTables_Button('btnEditDificuldade', 'Dificuldade');
//            $button->setImg('star-o');
//            $button->setVisible('CAD_USUARIO_DIFICULDADE', 'inserir');
//            $grid->addButton($button);
//        }
//        $column = new Ui_Element_DataTables_Column_Check('ID', 'id_usuario', '30', 'center');
//        $column->setCondicao('N', 'excluivel');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('ID', 'id_usuario', '20');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Nome', 'nomecompleto', '300');
        $grid->addColumn($column);

        // Grupo
        if ($tipo == 'user') {
            $column = new Ui_Element_DataTables_Column_Text('Email', 'email', '120');
            $grid->addColumn($column);

            $column = new Ui_Element_DataTables_Column_Text('Grupo', 'nomeGrupo', '120');
            $grid->addColumn($column);
        }

//        $column = new Ui_Element_DataTables_Column_Image('Ativo', 'ativo', '30', 'center');
//        $column->setCondicao('S', 'ativo');
//        $column->setImages(PATH_IMAGES . 'Buttons/Ok.png', PATH_IMAGES . 'Buttons/Cancelar.png');
//        $grid->addColumn($column);

        Session_Control::setDataSession($grid->getId(), $grid);
        $form->addElement($grid);


        $button = new Ui_Element_Btn('btnNovo');
        $button->setDisplay('New Item', 'plus');
        $button->setType('success');
        $button->setAttrib('params', 'tipo=' . $tipo . '');
        $button->setVisible('CAD_USER', 'inserir');
//        $button->setAttrib('link', HTTP_REFERER . 'FichaTecnica/edit/tipo/' . $post->tipo);
        $form->addElement($button);

        $view = Zend_Registry::get('view');
        if ($tipo == 'user')
            $view->assign('titulo', "Usuários");
        else
            $view->assign('titulo', "Grupos");
        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $form->displayTpl($view, 'Usuario/index.tpl'));
        $view->output('index.tpl');
    }

    public function edit($tipo) {

        $post = Zend_Registry::get('post');

        $br = new Browser_Control;

        $obj = new Usuario();
        $obj->setAtivo('S');
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction('Usuario');
        $form->setName('formUsersEdit');

        $mainTab = new Ui_Element_TabMain('editUserTab');

        $tabGeral = new Ui_Element_Tab('tabGeral');
        $tabGeral->setTitle('Geral');
        $tabGeral->setTemplate('Usuario/tabGeral.tpl');

        $element = new Ui_Element_Checkbox('ativo', 'Active');
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $tabGeral->addElement($element);

        $element = new Ui_Element_Text('nomeCompleto', 'Full Name');
        $element->setAttrib('maxlength', '25');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', 30);
        $tabGeral->addElement($element);


        if ($tipo == 'user') {
//            $element = new Ui_Element_Text('loginUser', 'Usuário');
//            $element->setAttrib('maxlength', '25');
//            $element->setAttrib('obrig', 'obrig');
//            $element->setRequired();
//            if ($post->id) {
//                $element->setReadOnly('true');
//            }
//            $tabGeral->addElement($element);


            $users = new Usuario;
            $users->where('tipo', 'grupo');
            $element = new Ui_Element_Select('grupo', 'User Group');
            $element->setAttrib('event', 'change');
            $element->addMultiOptions($users->getOptionList('id_usuario', 'nomecompleto', $users));
            $tabGeral->addElement($element);

            $element = new Ui_Element_Password('senha', 'Password');
            $element->setAttrib('placeholder', "Leave it blank if you don't want to change it");
            $element->setAttrib('maxlength', 32);
            $element->setAttrib('cript', '1');
            $tabGeral->addElement($element);

            $element = new Ui_Element_Text('email', 'E-Mail');
            $element->setAttrib('maxlength', 255);
            $element->setAttrib('obrig', 'obrig');
            $element->setRequired();
            $tabGeral->addElement($element);

//            $element = new Ui_Element_Password('senhaEmail');
//            $element->setAttrib('maxlength', 50);
//            $tabGeral->addElement($element);
//
//            $element = new Ui_Element_Text('smtp');
//            $element->setAttrib('maxlength', 25);
//            $tabGeral->addElement($element);
//
//            $element = new Ui_Element_TextMask('porta');
//            $element->setMask('999');
//            $element->setAttrib('size', 1);
//            $tabGeral->addElement($element);
        }

//        $empresa = new Empresa();
//        $empresa->where('editavel', cTRUE);
//
//        $element = new Ui_Element_Select('id_empresa');
//        $element->addMultiOptions(Empresa::getOptionList('id_empresa', 'razaosocial', $empresa, false));
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
//        $tabGeral->addElement($element);

        $salvar = new Ui_Element_Btn('btnSalvar');
        $salvar->setDisplay('Save', PATH_IMAGES . 'Buttons/Ok.png');
        if ($tipo == 'user') {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=user');
        } else {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=grupo');
        }
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);

        $cancelar = new Ui_Element_Btn('btnCancelar');
        $cancelar->setDisplay('Close', PATH_IMAGES . 'Buttons/Cancelar.png');
        $form->addElement($cancelar);

        $mainTab->addTab($tabGeral);

        // Tab permissões
        $tabPermissoes = new Ui_Element_Tab('tabPermissoes');
        $tabPermissoes->setTitle('Permissions');
        $tabPermissoes->setTemplate('Usuario/tabPermissoes.tpl');

        // Grid permissões
        $gridPermissoes = new Ui_Element_DataTables('gridPermissao');
        $gridPermissoes->setParams('', BASE_URL . 'Permissao/listapermissoes');
//        $gridPermissoes->setFillListOptionsFromObj('Permissao', $obj->permissoesLst);
//        $gridPermissoes->setFillListOptions('Permissao', 'readLst');
//        $gridPermissoes->setController('Permissao');
//        $gridPermissoes->setDimension('', '300');


        $button = new Ui_Element_DataTables_Button('btnExcluirPermissao', 'Delete');
        $button->setImg('trash-o');
        $button->setAttribs('msg = "Are you sure ou want to delete it?"');
        $button->setVisible('CAD_EMPRESA', 'excluir');
//        $button->setSendFormFields();
        $gridPermissoes->addButton($button);


        $button = new Ui_Element_DataTables_Button('btnEditar', 'Edit');
        $button->setImg('edit');
        $button->setUrl('Permissao');
        $button->setVisible('CAD_EMPRESA', 'inserir');
        $gridPermissoes->addButton($button);

//        $column = new Ui_Element_DataTables_Column_Check('id', 'id_permissao',    'center');
//        $column->setCondicao('S', 'grupo');
//        $gridPermissoes->addcolumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Name', 'descricao');
        $column->setWidth('3');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('See', 'ver', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);
//
        $column = new Ui_Element_DataTables_Column_Text('Create', 'inserir', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Delete', 'excluir', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Edit', 'editar', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);
//
        $column = new Ui_Element_DataTables_Column_Text('Enherited', 'grupo', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);


        Session_Control::setDataSession($gridPermissoes->getId(), $gridPermissoes);

        $tabPermissoes->addElement($gridPermissoes);


        $button = new Ui_Element_Btn('btnInserir');
        $button->setDisplay('New', 'plus');
        $button->setAttrib('click', '');
        $button->setAttrib('url', 'Permissao');
        $button->setType('success');
        $button->setAttrib('params', 'tipo=' . $tipo . '');
        $tabPermissoes->addElement($button);

        $mainTab->addTab($tabPermissoes);

//        if ($tipo == 'user') {
//            $tab = new Ui_Element_Tab('tabAssinatura');
//            $tab->setTitle('Assinatura do e-mail');
//            $tab->setTemplate('Usuario/tabAssinaturaEmail.tpl');
//
//            $element = new Ui_Element_Textarea('assinaturaEmail');
//            $element->setAttrib('cols', '70');
//            $element->setAttrib('rows', '15');
//            $tab->addElement($element);
//            $mainTab->addTab($tab);
//        }
        // Tab Logs
//        $tabLogs = new Ui_Element_Tab('tabLogs');
//        $tabLogs->setTitle('Logs');
//
//        $log = Log::gridLogs($post->id, 'Usuario');
//
//        $tabLogs->addElement($log);
//
//        $mainTab->addTab($tabLogs);

        $form->addElement($mainTab);

        $form->setDataSession();



        $form->setDataForm($obj);

        $form->setDataSession();

        Session_Control::setDataSession('userEdit', $obj);

        if ($tipo == 'user') {
            $label = 'User Login';
            $descricao = 'Full Name';
        } else {
            $label = 'Group Name';
            $descricao = 'Description';
        }

        $view = Zend_Registry::get('view');
        $view->assign('labelLogin', $label);
        $view->assign('descricao', $descricao);

        $w = new Ui_Window('EditUsers', 'Editing', $form->displayTpl($view, 'Usuario/edit.tpl'));
        $w->setDimension('795', '620');
        $w->setCloseOnEscape();

        $br->newWindow($w);
        $br->setCommand('var tablegridPermissao = $("#gridPermissao").dataTable({"ajax": {
"url": "' . BASE_URL . 'Permissao/listapermissoesuser",
"type": "POST" ,
"language": {"url": "//cdn.datatables.net/plug-ins/f2c75b7247b/i18n/Portuguese-Brasil.json"} ,
"data": function ( d ) { return $("#gridPermissao").serialize()+"&idGrid=gridPermissao"; }
}});');
        $br->send();
    }

    public function btneditdificuldadeclickAction() {

        $post = Zend_Registry::get('post');

        $br = new Browser_Control;

        $obj = new Usuario();
        $obj->setAtivo('S');
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction('Usuario');
        $form->setName('formUsersEdit');

        $element = new Ui_Element_Text('nomeCompleto', 'Nome Completo');
        $element->setAttrib('maxlength', '25');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setReadOnly(true);
        $element->setAttrib('size', 30);
        $form->addElement($element);

        $element = new Ui_Element_Select('dificuldade', 'Dificuldade na produção dos Laudos');
//            $element->addMultiOption('', '');
        $element->addMultiOption(1, 'Grau 1');
        $element->addMultiOption(2, 'Grau 2');
        $element->addMultiOption(3, 'Grau 3');
        $element->addMultiOption(4, 'Grau 4');
        $element->setMultiSelect();
//            $element->setSelect2();
        $form->addElement($element);

        $salvar = new Ui_Element_Btn('btnSalvarDificuldade');
        $salvar->setDisplay('Salvar', PATH_IMAGES . 'Buttons/Ok.png');
        if ($tipo == 'user') {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=user');
        } else {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=grupo');
        }
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);

        $form->setDataForm($obj);

        $form->setDataSession();

        Session_Control::setDataSession('userEdit', $obj);


        $view = Zend_Registry::get('view');

        $w = new Ui_Window('EditUsers', 'Edição de usúarios', $form->displayTpl($view, 'Usuario/editDificuldade.tpl'));
        $w->setDimension('600', '');
        $w->setCloseOnEscape(true);

        $br->newWindow($w);
        $br->send();
    }

    public function btnnovoclickAction() {
        $post = Zend_Registry::get('post');
        $this->edit($post->tipo);
    }

    public function btnsalvarclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $form = Session_Control::getDataSession('formUsersEdit');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $user = Usuario::getInstance('userEdit');
        $user->setDataFromRequest($post);
        $user->save();


//        $br->setBrowserUrl(BASE_URL);
        $br->setRemoveWindow('EditUsers');
        $br->setUpdateDataTables('gridUsers');
        $br->setUpdateDataTables('gridGrupos');
        $br->send();

        Session_Control::setDataSession('formUsersEdit', '');
    }

    public function btnsalvardificuldadeclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $form = Session_Control::getDataSession('formUsersEdit');

//        $valid = $form->processAjax($_POST);
//
//        $br = new Browser_Control();
//        if ($valid != 'true') {
//            $br->validaForm($valid);
//            $br->send();
//            exit;
//        }

        $user = Usuario::getInstance('userEdit');
        $user->setDataFromRequestDificuldade($post);
        $user->save();


        $br->setRemoveWindow('EditUsers');
        $br->setUpdateDataTables('gridUsers');
        $br->setUpdateDataTables('gridGrupos');
        $br->send();

        Session_Control::setDataSession('formUsersEdit', '');
    }

    public function btnfavoritapaginaclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $IDuser = Usuario::getIDUsuarioLogado();
        $user = new Usuario();
        $user->read($IDuser);
        $user->setPaginaInicial(str_replace(HTTP_REFERER, '', $_SERVER['HTTP_REFERER']));
        $user->save();


        $br->setMsgAlert('Agora sim!', 'Sempre que o sistema for aberto por você,   será redirecionado para essa página!');
        $br->send();

        Session_Control::setDataSession('formUsersEdit', '');
    }

//    public function btnexcluirclickAction() {
//        Grid_Control::deleteDataGrid('Usuario', '', array('gridUsers', 'gridGrupos'));
//    }
    public function btnexcluirpermissaoclickAction() {
        Grid_ControlDataTables::deleteDataGrid('userEdit', 'permissoesLst', 'gridPermissao');
    }

    public function btncancelarclickAction() {
        $br = new Browser_Control;
        $br->setRemoveWindow('EditUsers');
        $br->send();
    }

    public function btneditarclickAction() {
        $this->edit('user');
    }

    public function btneditargrupoclickAction() {
        $this->edit('grupo');
    }

    public function gridgruposdblclickAction() {
        $this->edit('grupo');
    }

    public function btnlimparfiltrosclickAction() {
        $br = new Browser_Control();
        $br->addFieldValue('ativoFiltro', 'S');
        $br->addFieldValue('loginUserFiltro', '');
        $br->addFieldValue('nomeCompletoFiltro', '');
        $br->setDataForm();
        $br->setUpdateDataTables('gridUsers');
        $br->setUpdateDataTables('gridGrupos');
        $br->send();
    }

    public function listausersAction($tipo = 'user') {
        $post = Zend_Registry::get('post');

        $users = new Usuario();
//        $users->where('ativo', $post->ativoFiltro);
        if ($post->loginUserFiltro != '') {
            $users->where('loginuser', $post->loginUserFiltro, 'ilike');
        }
        if ($post->nomeCompletoFiltro != '') {
            $users->where('nomecompleto', $post->nomeCompletoFiltro, 'ilike');
        }
        $users->where('editavel', cTRUE);
        $users->where('tipo', $tipo);
        $users->readLst();
        Grid_ControlDataTables::setDataGrid($users);
    }

    public function listagruposAction() {
        $this->listausersAction('grupo');
    }

    public function usersAction() {
        $this->gridsAction('user');
    }

    public function gruposAction() {
        $this->gridsAction('grupo');
    }

    public function btntrocasenhaclickAction() {
        $post = Zend_Registry::get('post');

        $user = new Usuario;
        if ($post->id != '') {
            $user->read($post->id);
        }
        if ($post->senhaCrip != '') {
            $user->setSenhaAtual($user->getCriptPass($post->senhaCrip));
        }
        $user->save();

        $br = new Browser_Control();
        $br->setRemoveWindow('EditUsers');
        $br->setUpdateDataTables('gridUsers');
        $br->send();
    }

    public function grupochangeAction() {
        $user = Usuario::getInstance('userEdit');
        if ($user->getId() != '') {
            $id = $user->getId();
        } else {
            $id = '';
        }

        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $permissao = new Permissao;
        $user->permissoesLst = $permissao->getPermissoes($id, $post->controlValue);

        Session_Control::setDataSession('userEdit', $user);

        $br->setUpdateDataTables('gridPermissao');
        $br->send();
    }

    public function btnEditarPermissao() {
        
    }

    public function btncancelarprofileclickAction() {
        $br = new Browser_Control;
        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function educatorsindexAction() {
        $post = Zend_Registry::get('post');
        $form = new Ui_Form();
        $form->setName('formEducators');
        $form->setAction($this->Action);


        /*
         *  --------- Grid das ACOES ------------
         */
        $grid = new Ui_Element_DataTables('educatorsGrid');
        $grid->setParams('', BASE_URL . $this->Action . '/educatorslist');
//        $grid->setTemplateID('grid');
        $grid->setStateSave(true);
//        $grid->setShowSearching(false);
//        $grid->setShowOrdering(false);
//        $grid->setShowLengthChange(false);
//        $grid->setShowInfo(false);


        $button = new Ui_Element_DataTables_Button('btnApprove', 'Approve');
        $button->setImg('check-square-o');
        $button->setAttrib('msg', "Do you confirm approving this educator?");
        $button->setVisible('PROC_CAD_APPROVE_EDU', 'inserir');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDeny', 'Deny');
        $button->setImg('ban');
        $button->setAttrib('msg', "Do you confirm hiding this educator content from the site?");
        $button->setVisible('PROC_CAD_APPROVE_EDU', 'excluir');
        $grid->addButton($button);

        $column = new Ui_Element_DataTables_Column_Text('Name', 'nomecompleto');
        $column->setWidth('7');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Approved', 'approved_decoded');
        $column->setWidth('3');
        $grid->addColumn($column);

        $form->addElement($grid);
        Session_Control::setDataSession($grid->getId(), $grid);

        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', 'Approved Educators');

        $view->assign('body', $form->displayTpl($view, 'Usuario/approveEducators.tpl'));
        $view->output('index.tpl');
    }

    public function educatorslistAction() {
        $post = Zend_Registry::get('post');

        $post->id_indicador;
        $lLst = new $this->Model;
        $lLst->where('grupo', 3);
        $lLst->readLst();

        Grid_ControlDataTables::setDataGrid($lLst, false, true);
    }

    public function btnapproveclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $obj = new Usuario();
        if (isset($post->id)) {
            $obj->read($post->id);
        }
        $obj->setApproved('S');

        try {
            $obj->save();
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setMsgAlert($obj->getNomecompleto() . ' was approved!', 'Now all lunch n\' learn registered by him/her will be visible on the site');

        $br->setUpdateDatatables('educatorsGrid');
        $br->send();
    }

    public function btndenyclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $obj = new Usuario();
        if (isset($post->id)) {
            $obj->read($post->id);
        }
        $obj->setApproved('N');

        try {
            $obj->save();
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $br->setMsgAlert($obj->getNomecompleto() . ' has his/her content hidden!', 'Now all lunch n\' learn registered by him/her will NOT be visible on the site');

        $br->setUpdateDatatables('educatorsGrid');
        $br->send();
    }

    public function profileeditAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $view = Zend_Registry::get('view');
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }

        $obj = new Usuario;
        $obj->read(Usuario::getIdUsuarioLogado());

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formProfileEdit');
        $form->setAttrib('enctype', 'multipart/form-data');

        $element = new Ui_Element_File("Photo", 'Photo');
        $form->addElement($element);

        $view->assign('PhotoPath', $obj->getPhotoPath());

        $element = new Ui_Element_Text('nomeCompleto');
        $element->setAttrib('maxlength', 35);
        $element->setRequired();
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'First name');
        $element->setAttrib('autofocus', '');
        $form->addElement($element);


        $element = new Ui_Element_Text('lastname');
        $element->setAttrib('maxlength', 35);
        $element->setRequired();
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'Last name');
        $form->addElement($element);


        $element = new Ui_Element_Text('email');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        $element->setAttrib('type', 'email');
        $element->setRequired();
        $element->setAttrib('placeholder', 'your@email.com');
        $form->addElement($element);

        $element = new Ui_Element_Date('birthdate', 'Birthdate');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Select('gender');
        $element->setRequired();
        $element->addMultiOption('', '- Select -');
        $element->addMultiOption('F', 'Female');
        $element->addMultiOption('M', 'Male');
        $element->addMultiOption('O', 'Other');
        $form->addElement($element);

        $element = new Ui_Element_Text('education');
        $element->setAttrib('maxlength', 100);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'Some University');
        $form->addElement($element);

        $element = new Ui_Element_Text('hometowncity');
        $element->setAttrib('maxlength', 50);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'City where you were raised');
        $form->addElement($element);

        $element = new Ui_Element_Text('hometowncountry');
        $element->setAttrib('maxlength', 50);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'Country where you were raised');
        $form->addElement($element);


        $element = new Ui_Element_Text('loginUser');
        $element->setAttrib('maxlength', 30);
        $element->setHideRemainingCharacters();
        $element->setRequired();
        $element->setAttrib('placeholder', 'User name');
        $form->addElement($element);

        $element = new Ui_Element_Password('senha');
        $element->setAttrib('maxlength', 30);
        $element->setAttrib('cript', '1');
        $element->setAttrib('placeholder', 'Fill in to change your password');
        $form->addElement($element);

        $element = new Ui_Element_Password('confirmpassword');
        $element->setAttrib('maxlength', 30);
        $element->setAttrib('cript', '1');
        $element->setAttrib('placeholder', 'Fill in to confirm changing your password');
        $form->addElement($element);


        $element = new Ui_Element_Text('liveincity');
        $element->setAttrib('maxlength', 50);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', "Don't miss out on local events and when friends are in town");
        $form->addElement($element);

        $element = new Ui_Element_Text('liveincountry');
        $element->setAttrib('maxlength', 50);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'The country you currently live in');
        $form->addElement($element);

        $element = new Ui_Element_Text('telephone');
        $element->setAttrib('maxlength', 25);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', '+1 999 999 9999');
        $form->addElement($element);

        $element = new Ui_Element_Select('relationship');
        $element->addMultiOption('', '- Select -');
        $element->addMultiOption('s', 'single');
        $element->addMultiOption('m', 'married');
        $element->addMultiOption('ir', 'in a relationship');
        $element->addMultiOption('e', 'engaged');
        $element->addMultiOption('cu', 'in a civil union');
        $element->addMultiOption('dp', 'in a domestic partnership');
        $element->addMultiOption('or', 'in an open relationship');
        $element->addMultiOption('ic', 'it is complicated');
        $element->addMultiOption('sp', 'separated');
        $element->addMultiOption('d', 'divorced');
        $element->addMultiOption('w', 'widowed');
        $form->addElement($element);

        $element = new Ui_Element_Textarea('bio');
        $element->setAttrib('rows', 4);
        $element->setAttrib('maxlength', 140);
        $element->setAttrib('placeholder', 'Tell us how awesome you are, your favourite quote etc.');
        $form->addElement($element);

        $element = new Ui_Element_Text('instagram');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', '@instagram_username');
        $form->addElement($element);

        $element = new Ui_Element_Text('twitter');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', '@twitter_username');
        $form->addElement($element);

        $element = new Ui_Element_Text('facebook');
        $element->setAttrib('maxlength', 45);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'your.facebook.profile');
        $form->addElement($element);

        $element = new Ui_Element_Text('occupation');
        $element->setAttrib('maxlength', 60);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'We all got bills to pay');
        $form->addElement($element);

        $element = new Ui_Element_Text('dreamjob');
        $element->setAttrib('maxlength', 60);
        $element->setHideRemainingCharacters();
        $element->setAttrib('placeholder', 'bungee jumping instuctor, panda cuddler, self-made millionaire');
        $form->addElement($element);

        $element = new Ui_Element_Textarea('traveledto');
        $element->setAttrib('rows', 4);
        $element->setAttrib('maxlength', 255);
        $element->setAttrib('placeholder', 'Let your friends know the awesome places you traveled to!');
        $form->addElement($element);

        $element = new Ui_Element_Text('calendartype');
        $element->setAttrib('maxlength', 1);
        $element->setHideRemainingCharacters();
        //$element->setRequired();
        $element->setAttrib('placeholder', 'change this to choose from pictures');
        $form->addElement($element);

        $element = new Ui_Element_Select('interests');
        $element->addMultiOptions($obj->getAllInterestsLst());
        $element->setAttrib('placeholder', 'What are your interests?');
        $element->setAttrib('data-allow-clear', 'true');
        $element->setSelect2(true);
        $element->setAttrib('multiple', 'multiple');
        $form->addElement($element);

        $element = new Ui_Element_Select('travelertypes');
        $element->addMultiOptions($obj->getAllTravelerTypesLst());
        $element->setAttrib('placeholder', "What's your traveler type?");
        $element->setAttrib('data-allow-clear', 'true');
        $element->setSelect2(true);
        $element->setAttrib('multiple', 'multiple');
        $form->addElement($element);

        // LOADS THE FORM WITH THE USER DATA
        $form->setDataForm($obj);
        $obj->setInstance('profileEdit');

        $button = new Ui_Element_Btn('btnSaveProfile');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancel');
        $cancelar->setAttrib('params', 'IdWindowEdit=EditUserProfile');
        $cancelar->setDisplay('Cancel', 'times');
        $cancelar->setHref(HTTP_REFERER . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession('formProfileEdit');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', 'My profile');
        $view->assign('TituloPagina', 'My profile');
        $view->assign('body', $form->displayTpl($view, 'Usuario/editProfile.tpl'));
        $view->output('index.tpl');
    }

    public function btnsaveprofileclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $form = Session_Control::getDataSession('formProfileEdit');
        $photo = $post->Photo;

        $br = new Browser_Control();

        // Validations:
        // $valid = $form->processAjax($_POST);
        // if ($valid != 'true') {
        //     $br->validaForm($valid);
        //     $br->send();
        //     return;
        // } else
        if (($post->senha != '') && ($post->senha != $post->confirmpassword)) {
            $br->setAlert("Error", "The password informed doesn't match the confirm password.");
            $br->send();
            return;
        } else if (!filter_var($post->email, FILTER_VALIDATE_EMAIL)) {
            $br->setAlert("Error", "The email informed is not valid.");
            $br->send();
            return;
        }

        $user = Usuario::getInstance('profileEdit');

        if ($photo['name'] != '') {
            $user->setPhoto($photo['name']);
        }

        $user->setDataFromProfileRequest($post);

        //Put the uploaded file in the proper folder
        if ($photo['name'] != '') {
            $path = RAIZ_DIRETORY . 'site/Public/Images/Profile';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            move_uploaded_file($photo['tmp_name'], $path . '/' . $user->getID() . '_' . $photo['name']);
            $br->setAttrib('PhotoPath', 'src', $user->getPhotoPath());
        }

        // save the interests
        $list = $post->interests;
        $destLst = $user->getUserInterestsLst();

        for ($i = 0; $i < $destLst->countItens(); $i++) { // mark all to delete
            $Item = $destLst->getItem($i);
            $Item->setState(cDELETE);
        }
        if (count($list) > 0) {
            foreach ($list as $idInterest) { //for each item selected by the user
                if ($idInterest == '') {
                    continue;
                }
                $interest = '';
                for ($i = 0; $i < $destLst->countItens(); $i++) { // find the interest on the user interests on database
                    $Item = $destLst->getItem($i);
                    if ($Item->getid_interest() == $idInterest) {
                        $interest = $Item;
                        break;
                    } else {
                        $interest = '';
                    }
                }

                if ($interest == '') { // if the interest doesn't exist on user interests, add it.
                    $n = new UserInterests();
                    $n->setid_interest($idInterest);
                    $n->setid_usuario($user->getID());
                    $destLst->addItem($n);
                } else {
                    $interest->setState(cUPDATE); //else update it
                }
            }
        }

        // save the traveler types
        $list = $post->travelertypes;
        $destLst = $user->getUserTravelertypesLst();

        for ($i = 0; $i < $destLst->countItens(); $i++) { // mark all to delete
            $Item = $destLst->getItem($i);
            $Item->setState(cDELETE);
        }
        if (count($list) > 0) {
            foreach ($list as $idTravelertype) { //for each item selected by the user
                if ($idTravelertype == '') {
                    continue;
                }
                $tt = '';
                for ($i = 0; $i < $destLst->countItens(); $i++) { // find the tt on the user interests on database
                    $Item = $destLst->getItem($i);
                    if ($Item->getid_travelertype() == $idTravelertype) {
                        $tt = $Item;
                        break;
                    } else {
                        $tt = '';
                    }
                }

                if ($tt == '') { // if the tt doesn't exist on user interests, add it.
                    $n = new UserTravelertype();
                    $n->setid_travelertype($idTravelertype);
                    $n->setid_usuario($user->getID());
                    $destLst->addItem($n);
                } else {
                    $tt->setState(cUPDATE); //else update it
                }
            }
        }


        //$user->setUserInterestsLst($destLst);
        // save everything on database
        try {
            $user->save();
            $user->setInstance('profileEdit');
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }



        //Update the session user data
        $session = Zend_Registry::get('session');
        $session->usuario = $user;
        Zend_Registry::set('session', $session);

        // redirect to the dashboard with a message
        $msg = 'Changes saved!!';
        $br->setMsgAlert('Saved!!', $msg);
        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function friendslistloadAction() {
        $br = new Browser_Control();
        $view = Zend_Registry::get('view');


        $view->assign('friends', Friend::getFriendsLst(Usuario::getIDUsuarioLogado()));

        $br->setHtml('friendslist', $view->fetch('Usuario/friendsList.tpl'));
        $br->send();
    }

}
