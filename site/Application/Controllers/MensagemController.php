<?php

include_once 'AbstractController.php';

class MensagemController extends AbstractController {

    public function init() {
        parent::init();
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->IdGrid = 'gridMensagem';
        $this->FormName = 'formMensagem';
        $this->Action = 'Mensagem';
        $this->TituloLista = "Mensagem";
        $this->TituloEdicao = "Edição";
        $this->ItemEditInstanceName = 'MensagemEdit';
        $this->ItemEditFormName = 'formMensagemItemEdit';
        $this->Model = 'Mensagem';
        $this->IdWindowEdit = 'EditMensagem';
        $this->TplIndex = 'Mensagem/index.tpl';
        $this->TplEdit = 'Mensagem/edit.tpl';
//        set_time_limit(60);
    }

    public function indexAction() {
        $post = Zend_Registry::get('post');
        $form = new Ui_Form();
        $form->setName($this->FormName);
        $form->setAction($this->Action);

        ////-------- Grid   --------------------------------------------------------------
        $form = new Ui_Form();
        $form->setName($this->FormName);
        $form->setAction($this->Action);

        $idGrid = $this->IdGrid;
        $grid = new Ui_Element_DataTables($idGrid);
        $grid->setParams('', BASE_URL . $this->Action . '/lista');
//        $grid->setShowLengthChange(false);
//        $grid->setShowPager(false);
        $grid->setOrder('DataCadastro', 'desc');
//        $grid->setFillListOptions('FichaTecnica', 'readFichatecnicaLst');

        $button = new Ui_Element_DataTables_Button('btnEditar', 'Modificar');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_MENSAGENS', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluir', 'Excluir');
        $button->setImg('trash');
        $button->setAttribs('msg = "Excluir o item selecionado?"');
        $button->setVisible('PROC_MENSAGENS', 'excluir');
        $grid->addButton($button);

        $column = new Ui_Element_DataTables_Column_Date('Data', 'DataCadastro');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Remetente', 'NomeRemetente');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Assunto', 'AssuntoComResumo');
        $column->setWidth('5');
        $grid->addColumn($column);



        $form->addElement($grid);




        // =========================================================================
//
        $button = new Ui_Element_Btn('btnEditar');
        $button->setDisplay('Novo', 'plus');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setType('success');
        $button->setVisible('PROC_MENSAGENS', 'inserir');
//        $button->setAttrib('click', '');
        $form->addElement($button);



        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);

//        $view->assign('descricao', "As Informações aparecerão no menu do site, a baixo do item Informações.");
        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function listaAction() {

        $post = Zend_Registry::get('post');

        $obj = new $this->Model();

        if (Usuario::verificaAcesso('PROC_MENSAGENS', 'inserir') == '') {
//        if (Usuario::verificaAcesso('ALL') != '') {
            $obj->join('mensagemdestinatario', 'mensagemdestinatario.id_mensagem = mensagem.id_mensagem  and mensagemdestinatario.id_usuario = ' . Usuario::getIdUsuarioLogado(), 'id_usuario');
        }
        $obj->readLst();
        Grid_ControlDataTables::setDataGrid($obj, false, true);
    }

    public function editAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
//        $id_indicador = $post->id;

        $view = Zend_Registry::get('view');
        if (isset($post->id)) {
            $readOnly = true;
        }

        //temporariamente estou desativando o readonly para poder cadastrar as acoes antigas
        $readOnly = false;

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $users = new Usuario;
        $users->where('tipo', 'grupo');
        $element = new Ui_Element_Select('grupo', 'Grupo de Usuário');
        $element->setAttrib('event', 'change');
        $element->addMultiOptions($users->getOptionList('id_usuario', 'nomecompleto', $users));
        $element->addMultiOption('T', 'Todos');
        $form->addElement($element);

        $element = new Ui_Element_Select('DestinatarioLst', "Destinatario");
        $element->addMultiOptions(Usuario::getUsuarioList());
//        $element->setAttrib('placeholder', 'Selecione um ou mais Destinatarios');
        $element->setAttrib('data-allow-clear', 'true');
        $element->setSelect2(true);
        $element->setAttrib('multiple', 'multiple');
        $form->addElement($element);



        $element = new Ui_Element_Date('DataCadastro', "Data");
        $element->setAttrib('placeholder', 'dd/mm/aaaa');
        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Text('Assunto', "Assunto");
        $element->setAttrib('maxlenght', 1000);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('Mensagem', "Mensagem");
        $element->setTinyMce();
        $element->setAttrib('rows', 15);
        $element->setAttrib('maxlenght', 5000);
        $form->addElement($element);

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        } else {
            $obj->setID_Remetente(Usuario::getIdUsuarioLogado());
        }
        $obj->setInstance($this->ItemEditInstanceName);





        $button = new Ui_Element_Btn('btnSalvar');
        $button->setDisplay('Salvar', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnSalvarEnviar');
        $button->setDisplay('Salvar e Enviar', 'send');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancelar');
        $cancelar->setAttrib('params', 'IdWindowEdit=' . $this->IdWindowEdit);
        $cancelar->setDisplay('Cancelar', 'times');
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    public function grupochangeAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        if ($post->controlValue != '') {
            $lObjLst = new Usuario();
            $lObjLst->where('ativo', 'S');
            if ($post->controlValue != 'T') {
                $lObjLst->where('grupo', $post->controlValue);
            }
            $lObjLst->readLst();
//        print'<pre>';die(print_r( $lObjLst->getItens() ));
            for ($i = 0; $i < $lObjLst->countItens(); $i++) {
                $User = $lObjLst->getItem($i);
                $list[] = $User->getID();
            }
            if (count($list)) {
                //        print'<pre>';die(print_r( $list ));
                $br->addFieldValue('DestinatarioLst', $list, 'select-one');
                $br->setDataForm();
                //        $br->setCommand('$("[select2]").trigger("change");');
            }
        }
        $br->send();
    }

    public function btnsalvarenviarclickAction() {
        $this->btnsalvarclickAction(true);
    }

    public function btnsalvarclickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();

        /* @var $lObj  */
        $lObj = Mensagem::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);


        /*
         * Valida os dados do formulário
         */
//        $valid = $form->processAjax($_POST);
//        if ($valid != 'true') {
//            $br->validaForm($valid);
//            $br->send();
//            exit;
//        }

        $list = $post->DestinatarioLst;

        $destLst = $lObj->getMensagemDestinatarioLst();
        for ($i = 0; $i < $destLst->countItens(); $i++) {
            $Item = $destLst->getItem($i);
            $Item->setState(cDELETE);
        }
        if (count($list) > 0)
            foreach ($list as $idUser) {
                if ($idUser == '') {
                    continue;
                }
                for ($i = 0; $i < $destLst->countItens(); $i++) {
                    $Item = $destLst->getItem($i);
                    if ($Item->getid_usuario() == $idUser) {
                        $user = $Item;
                        break;
                    } else {
                        $user = '';
                    }
                }
                if ($user == '') {
                    $n = new MensagemDestinatario();
                    $n->setid_usuario($idUser);
                    $destLst->addItem($n);
                } else {
                    $user->setState(cUPDATE);
                }
            }


        $lObj->setDataFromRequest($post);
//        print'<pre>';die(print_r( $lObj ));
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = 'Suas alterações foram Salvas com sucesso!';
        $br->setMsgAlert('Salvo!', $msg);

        if ($enviar) {
            $retEnvio = $lObj->enviaPorEmail();
            if ($retEnvio !== true) {
                $msg = $retEnvio;
                $br->setAlert('Erro ao enviar email!', $msg, '600', '600');
            } else {
                $msg = 'Email enviado para:<strong>';
                $msg .= implode('</strong><br> <strong>', $lObj->listaEmailDestinatarios) . '</strong>';

                $br->setMsgAlert('Enviado!', $msg);
            }
        }

        $br->send();
    }

    public function viewAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        $idUsuario = Usuario::getIdUsuarioLogado();

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
        }
        $obj->setInstance($this->ItemEditInstanceName);
        if ($obj->found() and ( Usuario::verificaAcesso('PROC_MENSAGENS', 'inserir') or $obj->getUsuarioTemAcesso($idUsuario) )) {
            $obj->setVisualizada($idUsuario);

            $view->assign('titulo', 'Cominicação Interna');

            if (Usuario::verificaAcesso('PROC_MENSAGEM', 'editar')) {
                $view->assign('id_mensagem', $obj->getID());
            }
            $view->assign('TituloPagina', $obj->getAssunto());
            $view->assign('Assunto', $obj->getAssunto());
            $view->assign('Mensagem', $obj->getMensagem());
            $view->assign('Remetente', $obj->getNomeRemetente());
            $view->assign('DataCadastro', $obj->getDataCadastro());
            if (Usuario::verificaAcesso('PROC_MENSAGENS', 'inserir')) {
                $view->assign('visualizacoes', $obj->getListaVisualizacoes());
            }
        } else {

            $view->assign('titulo', 'Mensagem não encontrada');
            $view->assign('TituloPagina', 'Mensagem não encontrada');
            $view->assign('Assunto', 'Mensagem não encontrada');
            $view->assign('Remetente', 'Administrador');
            $view->assign('Mensagem', 'A mensagem que você está tentando acessar não está disponível.');
        }

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('body', $view->fetch('Mensagem/view.tpl'));
        $view->output('index.tpl');
    }

}
