<?php

include_once 'AbstractController.php';

class TriptypeController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formTriptype';
        $this->Action = 'Triptype';
        $this->TituloLista = "Trip Type";
        $this->TituloEdicao = "Trip Type";
        $this->ItemEditInstanceName = 'TriptypeEdit';
        $this->ItemEditFormName = 'formTriptypeItemEdit';
        $this->Model = 'Triptype';
        $this->IdWindowEdit = 'EditTriptype';
        $this->TplIndex = 'Triptype/index.tpl';
        $this->TplEdit = 'Triptype/edit.tpl';
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
        $grid->setOrder('triptypename', 'asc');


        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_TRIPTYPE', 'edit');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttribs('msg = "Delete the selected trip type?"');
        $button->setVisible('PROC_TRIPTYPE', 'delete');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('Trip type name', 'triptypename');
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
        $button->setVisible('PROC_TRIPTYPE', 'insert');
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

        $element = new Ui_Element_Text('triptypename', "Trip type name");
        $element->setAttrib('maxlenght', 45);
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
        $cancelar->setHref(HTTP_REFERER . $this->Action );
        $form->addElement($cancelar);

        $form->setDataSession();

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
        $lObj = Triptype::getInstance($this->ItemEditInstanceName);
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
        $br->setBrowserUrl(BASE_URL . 'triptype');
        $br->send();

    }

}
