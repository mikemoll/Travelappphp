<?php

include_once 'AbstractController.php';

class ActivitytypeController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formActivitytype';
        $this->Action = 'Activitytype';
        $this->TituloLista = "Activity Type";
        $this->TituloEdicao = "Activity Type";
        $this->ItemEditInstanceName = 'ActivitytypeEdit';
        $this->ItemEditFormName = 'formActivitytypeItemEdit';
        $this->Model = 'Activitytype';
        $this->IdWindowEdit = 'EditActivitytype';
        $this->TplIndex = 'Activitytype/index.tpl';
        $this->TplEdit = 'Activitytype/edit.tpl';
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
        $grid->setOrder('activitytypename', 'asc');


        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_ACTIVITYTYPE', 'edit');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttribs('msg = "Delete the selected traveler type?"');
        $button->setVisible('PROC_ACTIVITYTYPE', 'delete');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('Activity type name', 'activitytypename');
        $column->setWidth('1');
        $grid->addColumn($column);

        Session_Control::setDataSession($grid->getId(), $grid);
        $form->addElement($grid);

        // =========================================================================
//
        $button = new Ui_Element_Btn('btnNew');
        $button->setDisplay('New Item', 'plus');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setType('success');
        $button->setVisible('PROC_ACTIVITYTYPE', 'insert');
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

        $element = new Ui_Element_Text('activitytypename', "Activity type name");
        $element->setAttrib('maxlength', 45);
        $element->setRequired();
        $form->addElement($element);

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);

        $button = new Ui_Element_Btn('btnSave');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . $this->IdWindowEdit);
        $cancelar->setDisplay('Cancel', 'times');
        $cancelar->setHref(HTTP_REFERER . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession($this->ItemEditFormName);

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    public function btnnewclickAction() {
        $this->edit();
    }

    public function btnsaveclickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();

        /* @var $lObj */
        $lObj = Activitytype::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

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
        $msg = 'Changes saved!';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . 'activitytype');
        $br->send();
    }

}
