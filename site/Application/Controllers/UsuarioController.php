<?php

include_once 'AbstractController.php';

class UsuarioController extends AbstractController {

    public function init() {
        parent::init();
        Browser_Control::setScript('js', 'Md5', 'md5.js');
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
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

        if ($tipo == 'user') {
            $button = new Ui_Element_DataTables_Button('btnEditDificuldade', 'Dificuldade');
            $button->setImg('star-o');
            $button->setVisible('CAD_USUARIO_DIFICULDADE', 'inserir');
            $grid->addButton($button);
        }

//        $column = new Ui_Element_DataTables_Column_Check('ID', 'id_usuario', '30', 'center');
//        $column->setCondicao('N', 'excluivel');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('ID', 'id_usuario', '20');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Nome', 'nomecompleto', '300');
        $grid->addColumn($column);

        // Grupo
        if ($tipo == 'user') {
            $column = new Ui_Element_DataTables_Column_Text('Login', 'loginUser', '120');
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
        $button->setDisplay('Novo Item', 'plus');
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

        $element = new Ui_Element_Checkbox('ativo', 'Ativo');
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $tabGeral->addElement($element);

        $element = new Ui_Element_Checkbox('recebecomunicacaointerna', 'Recebe Comunicação Interna por email?');
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $tabGeral->addElement($element);

        $element = new Ui_Element_Text('nomeCompleto', 'Nome Completo');
        $element->setAttrib('maxlength', '25');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setAttrib('size', 30);
        $tabGeral->addElement($element);


        if ($tipo == 'user') {
            $element = new Ui_Element_Text('loginUser', 'Usuário');
            $element->setAttrib('maxlength', '25');
            $element->setAttrib('obrig', 'obrig');
            $element->setRequired();
//            if ($post->id) {
//                $element->setReadOnly('true');
//            }
            $tabGeral->addElement($element);

//        $element = new Ui_Element_Text('idexterno');
//        $element->setAttrib('maxlength', '25');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
//        $element->setAttrib('size', 10);
//        $tabGeral->addElement($element);
//
            $element = new Ui_Element_Select('idexterno', 'Código de Técnico no sistema Antigo');
            $element->addMultiOptions(Fichatecnica::getTecnicoList());
            $tabGeral->addElement($element);


            $users = new Usuario;
            $users->where('tipo', 'grupo');
            $element = new Ui_Element_Select('grupo', 'Grupo de Usuário');
            $element->setAttrib('event', 'change');
            $element->addMultiOptions($users->getOptionList('id_usuario', 'nomecompleto', $users));
            $tabGeral->addElement($element);

            $element = new Ui_Element_Select('dificuldade', 'Dificuldade na produção dos Laudos');
//            $element->addMultiOption('', '');
            $element->addMultiOption(1, 'Grau 1');
            $element->addMultiOption(2, 'Grau 2');
            $element->addMultiOption(3, 'Grau 3');
            $element->addMultiOption(4, 'Grau 4');
            $element->setMultiSelect();
//            $element->setSelect2();
            $tabGeral->addElement($element);

            $element = new Ui_Element_Password('senha', 'Senha');
            $element->setAttrib('maxlength', 32);
            $element->setAttrib('cript', '1');
            $tabGeral->addElement($element);

            $element = new Ui_Element_Text('email', 'Email');
            $element->setAttrib('maxlength', 255);
            $element->setAttrib('obrig', 'obrig');
            $element->setRequired();
            $tabGeral->addElement($element);

            $element = new Ui_Element_Text('senhaEmail', 'Senha SMTP');
            $element->setAttrib('maxlength', 50);
            $tabGeral->addElement($element);

            $element = new Ui_Element_Text('smtp', 'SMTP');
            $element->setAttrib('maxlength', 255);
            $tabGeral->addElement($element);

            $element = new Ui_Element_TextMask('porta', 'Porta SMTP');
            $element->setMask('999');
            $element->setPlaceholder('587');
            $element->setAttrib('size', 1);
            $element->setAttrib('maxlength', 3);
            $tabGeral->addElement($element);
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
        $salvar->setDisplay('Salvar', PATH_IMAGES . 'Buttons/Ok.png');
        if ($tipo == 'user') {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=user');
        } else {
            $salvar->setAttrib('params', 'id=' . $post->id . '&tipo=grupo');
        }
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);

        $cancelar = new Ui_Element_Btn('btnCancelar');
        $cancelar->setDisplay('Cancelar', PATH_IMAGES . 'Buttons/Cancelar.png');
        $form->addElement($cancelar);

        $mainTab->addTab($tabGeral);

        // Tab permissões
        $tabPermissoes = new Ui_Element_Tab('tabPermissoes');
        $tabPermissoes->setTitle('Permissões');
        $tabPermissoes->setTemplate('Usuario/tabPermissoes.tpl');

        // Grid permissões
        $gridPermissoes = new Ui_Element_DataTables('gridPermissao');
        $gridPermissoes->setParams('', BASE_URL . 'Permissao/listapermissoes');
//        $gridPermissoes->setFillListOptionsFromObj('Permissao', $obj->permissoesLst);
//        $gridPermissoes->setFillListOptions('Permissao', 'readLst');
//        $gridPermissoes->setController('Permissao');
//        $gridPermissoes->setDimension('', '300');
//        
//        

        $button = new Ui_Element_DataTables_Button('btnExcluirPermissao', 'Excluir');
        $button->setImg('trash-o');
        $button->setAttribs('msg = "Excluir o item selecionado ?"');
        $button->setVisible('CAD_EMPRESA', 'excluir');
//        $button->setSendFormFields();
        $gridPermissoes->addButton($button);


        $button = new Ui_Element_DataTables_Button('btnEditar', 'Editar');
        $button->setImg('edit');
        $button->setUrl('Permissao');
        $button->setVisible('CAD_EMPRESA', 'inserir');
        $gridPermissoes->addButton($button);

//        $column = new Ui_Element_DataTables_Column_Check('id', 'id_permissao',    'center');
//        $column->setCondicao('S', 'grupo');
//        $gridPermissoes->addcolumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Processo', 'descricao');
        $column->setWidth('3');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Ver', 'ver', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);
//
        $column = new Ui_Element_DataTables_Column_Text('Inserir', 'inserir', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Excluir', 'excluir', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Editar', 'editar', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);
//
        $column = new Ui_Element_DataTables_Column_Text('Herdada', 'grupo', 'center');
        $column->setWidth('1');
        $gridPermissoes->addColumn($column);


        Session_Control::setDataSession($gridPermissoes->getId(), $gridPermissoes);

        $tabPermissoes->addElement($gridPermissoes);


        $button = new Ui_Element_Btn('btnInserir');
        $button->setDisplay('Inserir', 'plus');
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
        $tabLogs = new Ui_Element_Tab('tabLogs');
        $tabLogs->setTitle('Logs');

        $log = Log::gridLogs($post->id, 'Usuario');

        $tabLogs->addElement($log);

        $mainTab->addTab($tabLogs);

        $form->addElement($mainTab);

        $form->setDataSession();



        $form->setDataForm($obj);

        $form->setDataSession();

        Session_Control::setDataSession('userEdit', $obj);

        if ($tipo == 'user') {
            $label = 'Login do usúario';
            $descricao = 'Nome Completo';
        } else {
            $label = 'Nome do grupo';
            $descricao = 'Descrição';
        }

        $view = Zend_Registry::get('view');
        $view->assign('labelLogin', $label);
        $view->assign('descricao', $descricao);

        $w = new Ui_Window('EditUsers', 'Edição de usúarios', $form->displayTpl($view, 'Usuario/edit.tpl'));
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
        $br->setRemove('EditUsers');
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

}
