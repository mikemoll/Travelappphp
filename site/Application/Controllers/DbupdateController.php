<?php

include_once 'AbstractController.php';

class DbupdateController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formDBUpdate';
        $this->Action = 'DBUpdate';
        $this->TituloLista = "DBUpdate";
        $this->TituloEdicao = "Edit";
        $this->ItemEditInstanceName = 'DBUpdateEdit';
        $this->ItemEditFormName = 'formDBUpdateItemEdit';
        $this->Model = 'DBUpdate';
        $this->IdWindowEdit = 'EditDBUpdate';
        $this->TplIndex = 'DBUpdate/index.tpl';
        $this->TplEdit = 'DBUpdate/edit.tpl';
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
        $grid->setOrder('filetime', 'desc');

        $button = new Ui_Element_DataTables_Button('btnEditar', 'Edit');
        $button->setImg('edit');
//        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_MENSAGENS', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnRun', 'run');
        $button->setImg('play');
        $button->setAttribs('msg = "Run this item?"');
        $button->setVisible('PROC_MENSAGENS', 'excluir');
        $grid->addButton($button);



        $column = new Ui_Element_DataTables_Column_Date('File Name', 'filename');
        $column->setWidth('8');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Date', 'date');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('File Time', 'filetime');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Last Update', 'UpdatedOn');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Is New', 'isnew');
        $column->setWidth('1');
        $grid->addColumn($column);



        $form->addElement($grid);




        // =========================================================================
//
        $button = new Ui_Element_Btn('btnEditar');
        $button->setDisplay('New Item', 'plus');
//        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
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

    public function listAction() {

        $post = Zend_Registry::get('post');

        $obj = new $this->Model();
        $obj->readLst();
        Grid_ControlDataTables::setDataGrid($obj, false, '');
    }

    public function btnrunclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $obj = new $this->Model();
        $obj->read($post->id);
        $filename = $obj->filename;
        $homepage = file_get_contents($obj->sqlFolder . "/$filename");
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = $homepage;
        $db->query($sql);

        $obj->setUpdatedOn($obj->filetime);
        $obj->save();

        $br->setAlert('Run Result', "It's all Good!<br><h3>query: </h3><pre>$homepage</pre>");
        $br->setUpdateDataTables($this->IdGrid);
        $br->send();
    }

    public function btneditarclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('filename', "File Name");
        $element->setAttrib('maxlength', 30);
        $element->setValue($obj->filename);
        $element->setReadOnly($obj->filename != '');
        $form->addElement($element);


        $element = new Ui_Element_Textarea('content', "Content");
//        $element->setTinyMce();
        $element->setValue($obj->content);
        $element->setAttrib('rows', 20);
//        $element->setAttrib('maxlength', 500);
        $form->addElement($element);




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

        $cancelar = new Ui_Element_Btn('btnClose');
        $cancelar->setAttrib('params', 'IdWindowEdit=' . $this->IdWindowEdit);
        $cancelar->setDisplay('Cancel', 'times');
        $form->addElement($cancelar);

        $form->setDataSession();


        $w = new Ui_Window($this->IdWindowEdit, $this->TituloEdicao, $form->displayTpl($view, $this->TplEdit));
        $w->setDimension('600', '300');
        $w->setCloseOnEscape(true);
        $br->newWindow($w);
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

        /* @var  $lObj DBUpdate */
        $lObj = new DBUpdate();
        $lObj->setDataFromRequest($post);


        //if it's not set, is because it's a new file!
        if (!isset($post->id)) {
            $lObj->filename .= '-' . date('Y-m-d-H\h i\m') . '.sql';
        }


        try {
            $lObj->createFile();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = 'Saved!';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow($this->IdWindowEdit);
        $br->setUpdateDataTables($this->IdGrid);
        $br->send();
    }

}
