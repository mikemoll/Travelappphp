<?php

include_once 'AbstractController.php';

class ExampleFormController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formExampleForm';
        $this->Action = 'ExampleForm';
        $this->TituloLista = "Form Exemple";
        $this->TituloEdicao = "Form Exemple";
        $this->ItemEditInstanceName = 'ExampleFormEdit';
        $this->ItemEditFormName = 'formExampleFormItemEdit';
        $this->Model = 'Trip';
        $this->IdWindowEdit = 'EditExampleForm';
        $this->TplIndex = 'ExampleForm/index.tpl';
        $this->TplEdit = 'ExampleForm/edit.tpl';
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



        $column = new Ui_Element_DataTables_Column_Date('ExampleForm Name', 'activityname');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Start', 'start_at');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('End', 'end_at');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('address', 'address');
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

        $view = Zend_Registry::get('view');
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('text', "Simple Text");
        $form->addElement($element);

        $element = new Ui_Element_Text('maxlength', "Field with Maxlength");
        $element->setAttrib('maxlength', 45);
        $form->addElement($element);

        $element = new Ui_Element_Text('placeholder', "Simple Text Placeholder");
        $element->setPlaceholder('Call $element->setPlaceholder("This is the placeholder") to set the plaecholder');
        $form->addElement($element);

        $element = new Ui_Element_Text('textRequired', "Simple Text Required");
        $element->setAttrib('maxlength', 45);
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('pass', "Password Field");
        $element->setAttrib('maxlength', 45);
        $element->setAttrib('cript', '1');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('hotkey', "Field with HotKey!");
        $element->setPlaceholder('$element->setAttrib("hotkeys", "enter, btnLogin, click");');
        $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_TextMask('textmask', "textmask");
        $element->setMask('9999,99');
        $element->setPlaceholder('____,__');
        $form->addElement($element);

        $element = new Ui_Element_Date('date', "Simple Date");
        $form->addElement($element);


        $element = new Ui_Element_Select('select', 'Select2 - Searchable List!');
        $element->setAttrib('event', 'change');
        $element->addMultiOptions(Db_Table::getOptionList2('id_activitytype', 'activitytypename', 'activitytypename', 'activitytype'));
        $form->addElement($element);

        $element = new Ui_Element_Radio('radio', "Simple Radio");
        $element->addMultiOption('1', 'Opt 1');
        $element->addMultiOption('2', 'Opt 2');
        $element->addMultiOption('3', 'Opt 3');
        $form->addElement($element);


//        $obj = new $this->Model();
//        if (isset($post->id)) {
//            $obj->read($post->id);
//            $form->setDataForm($obj);
//        }
//        $obj->setInstance($this->ItemEditInstanceName);
        // ----------------------

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


        $column = new Ui_Element_DataTables_Column_Check('ID', 'id_trip');
        $grid->addColumn($column);


        $column = new Ui_Element_DataTables_Column_Date('ExampleForm Name', 'tripname');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Start', 'start');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('End', 'end');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('address', 'address');
        $column->setWidth('1');
        $grid->addColumn($column);



        $form->addElement($grid);

        // --------------

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
        $br = new Browser_Control();

        /* @var $lObj ExampleForm */
        $lObj = ExampleForm::getInstance($this->ItemEditInstanceName);

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
