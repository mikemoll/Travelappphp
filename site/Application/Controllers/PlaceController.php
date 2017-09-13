<?php

include_once 'AbstractController.php';

class PlaceController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formPlace';
        $this->Action = 'Place';
        $this->TituloLista = "Place";
        $this->TituloEdicao = "Place";
        $this->ItemEditInstanceName = 'PlaceEdit';
        $this->ItemEditFormName = 'formPlaceItemEdit';
        $this->Model = 'Place';
        $this->IdWindowEdit = 'EditPlace';
        $this->TplIndex = 'Place/index.tpl';
        $this->TplEdit = 'Place/edit.tpl';
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

        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_MENSAGENS', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttrib('msg', "Are you sure that you want to delete this?");
        $button->setVisible('PROC_MENSAGENS', 'excluir');
        $grid->addButton($button);



        $column = new Ui_Element_DataTables_Column_Date('Place Name', 'name');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Country', 'Country');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Address', 'formatted_address');
        $column->setWidth('3');
        $grid->addColumn($column);




        $form->addElement($grid);




        // =========================================================================
//
        $button = new Ui_Element_Btn('btnEdit');
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
        $view->assign('body', $view->fetch('Place/app/dashboard.tpl'));
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
        $form->setAttrib('enctype', 'multipart/form-data');

        $element = new Ui_Element_Text('name', "Place Name");
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);


        $element = new Ui_Element_File("Photo", 'Photo');
        $form->addElement($element);

        $element = new Ui_Element_Text('country', "Country");
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);

        $element = new Ui_Element_Text('formatted_address', "Formatted Address");
        $element->setAttrib('maxlength', 100);
        $element->setPlaceholder('Eg: "Railay, Thailand"');
        $form->addElement($element);

        $element = new Ui_Element_Text('google_place_id', "Google Place ID");
        $element->setAttrib('maxlength', 100);
        $form->addElement($element);

        $element = new Ui_Element_Text('rating', "Rating");
        $element->setAttrib('maxlength', 4);
        $form->addElement($element);

        $element = new Ui_Element_Text("googletypes", 'Google Location Types');
        $form->addElement($element);


        $element = new Ui_Element_Textarea('description', "Description");
//        $element->setTinyMce();
        $element->setAttrib('rows', 15);
        $element->setAttrib('maxlength', 4000);
        $form->addElement($element);


        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);

        $view->assign('PhotoPath', $obj->getPhotoPath());


        $button = new Ui_Element_Btn('btnSave');
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

    public function btnsaveclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        /* @var $lObj Place */
        $lObj = Place::getInstance($this->ItemEditInstanceName);
        $photo = $post->Photo;
        if ($photo['name'] != '') {
            $lObj->setPhoto(Format_String::normalizeString($photo['name']));
        }

        $lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        //Put the uploaded file in the proper folder
        if ($photo['name'] != '') {
            $path = RAIZ_DIRETORY . 'site/Public/Images/Place';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $path .= '/' . $lObj->getID() . '_' . $lObj->getPhoto();
            move_uploaded_file($photo['tmp_name'], $path );
            if (USE_AWS) {
                $result = Aws::moveToAWS($path);
                if (!$result->success) {
                    $br->setAlert('Error!', '<pre>' . print_r($result->message, true) . '</pre>', '100%', '600');
                    $br->send();
                    die();
                }
            }

            $br->setAttrib('PhotoPath', 'src', $lObj->getPhotoPath());
        }

        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . $this->Action);
        $br->send();
    }

}
