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

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttrib('msg', "Are you sure that you want to delete this?");
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

    public function dashboardAction() {
        $view = Zend_Registry::get('view');
//        $post = Zend_Registry::get('post');
//        $br = new Browser_Control();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);
        $view->assign('body', $view->fetch('Trip/app/dashboard.tpl'));
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
        $element->setAttrib('maxlength', 30);
        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Textarea('Description', "Description");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('travelmethod', "travelmethod");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('inventory', "inventory");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('notes', "notes");
//        $element->setTinyMce();
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Date('startdate', "Start Date");
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Date('enddate', "End Date");
        $element->setRequired();
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
            $button->setAttrib('params', 'id = ' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancel');
        $cancelar->setAttrib('params', 'IdWindowEdit = ' . $this->IdWindowEdit);
        $cancelar->setDisplay('Cancel', 'times');
        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    public function btnsalvarclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
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
        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . $this->Action);
        $br->send();
    }

}
