<?php

include_once 'AbstractController.php';

class TripController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formTrip';
        $this->Action = 'Trip';
        $this->TituloLista = "Trip";
        $this->TituloEdicao = "Edit";
        $this->ItemEditInstanceName = 'TripEdit';
        $this->ItemEditFormName = 'formTripItemEdit';
        $this->Model = 'Trip';
        $this->IdWindowEdit = 'EditTrip';
        $this->TplIndex = 'Trip/index.tpl';
        $this->TplEdit = 'Trip/edit.tpl';
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
        $grid->setParams('', BASE_URL . $this->Action . '/list');
//        $grid->setShowLengthChange(false);
//        $grid->setShowPager(false);
        $grid->setOrder('DataCadastro', 'desc');
//        $grid->setFillListOptions('FichaTecnica', 'readFichatecnicaLst');

        $button = new Ui_Element_DataTables_Button('btnEditar', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_MENSAGENS', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluir', 'Excluir');
        $button->setImg('trash');
        $button->setAttribs('msg = "Excluir o item selecionado?"');
        $button->setVisible('PROC_MENSAGENS', 'excluir');
        $grid->addButton($button);



        $column = new Ui_Element_DataTables_Column_Date('Trip Name', 'tripname');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Description', 'ShortDescription');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Start', 'startdate');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('End', 'enddate');
        $column->setWidth('1');
        $grid->addColumn($column);



        $form->addElement($grid);




        // =========================================================================
//
        $button = new Ui_Element_Btn('btnEditar');
        $button->setDisplay('New Item', 'plus');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setType('success');
        $button->setVisible('PROC_TRIP', 'inserir');
        $form->addElement($button);



        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);

        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function editAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
//        $id_indicador = $post->id;

        $view = Zend_Registry::get('view');
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('tripname', "Trip Name");
        $element->setAttrib('maxlenght', 30);
        $form->addElement($element);


        $element = new Ui_Element_Textarea('Description', "Description");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlenght', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('travelmethod', "travelmethod");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlenght', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('inventory', "inventory");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlenght', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('notes', "notes");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlenght', 500);
        $form->addElement($element);

        $element = new Ui_Element_Date('startdate', "Start Date");
        $form->addElement($element);

        $element = new Ui_Element_Date('enddate', "End Date");
        $form->addElement($element);

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);





        $button = new Ui_Element_Btn('btnSalvar');
        $button->setDisplay('Save', 'check');
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
        $cancelar->setDisplay('Cancel', 'times');
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
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

        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);

        $lObj->setDataFromRequest($post);
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


        $br->setBrowserUrl(BASE_URL . $this->Action);
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
            $view->assign('Trip', $obj->getTrip());
            $view->assign('Remetente', $obj->getNomeRemetente());
            $view->assign('DataCadastro', $obj->getDataCadastro());
            if (Usuario::verificaAcesso('PROC_MENSAGENS', 'inserir')) {
                $view->assign('visualizacoes', $obj->getListaVisualizacoes());
            }
        } else {

            $view->assign('titulo', 'Trip não encontrada');
            $view->assign('TituloPagina', 'Trip não encontrada');
            $view->assign('Assunto', 'Trip não encontrada');
            $view->assign('Remetente', 'Administrador');
            $view->assign('Trip', 'A mensagem que você está tentando acessar não está disponível.');
        }

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $view->fetch('Trip/view.tpl'));
        $view->output('index.tpl');
    }

}
