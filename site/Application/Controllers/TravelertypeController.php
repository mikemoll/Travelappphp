<?php

include_once 'AbstractController.php';

class TravelertypeController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formTravelertype';
        $this->Action = 'Travelertype';
        $this->TituloLista = "Traveler Type";
        $this->TituloEdicao = "Traveler Type";
        $this->ItemEditInstanceName = 'TravelertypeEdit';
        $this->ItemEditFormName = 'formTravelertypeItemEdit';
        $this->Model = 'Travelertype';
        $this->IdWindowEdit = 'EditTravelertype';
        $this->TplIndex = 'Travelertype/index.tpl';
        $this->TplEdit = 'Travelertype/edit.tpl';
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
        $grid->setOrder('name', 'desc');


        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_TRAVELERTYPE', 'edit');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttribs('msg = "Delete the selected traveler type?"');
        $button->setVisible('PROC_TRAVELERTYPE', 'delete');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('Traveler type description', 'description');
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
        $button->setVisible('PROC_TRAVELERTYPE', 'insert');
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
        $form->setAttrib('enctype', 'multipart/form-data');

        $element = new Ui_Element_Text('description', "Traveler type description");
        $element->setAttrib('maxlength', 45);
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

        $view->assign('imgPath', $obj->getImagePath());
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
        $lObj = Travelertype::getInstance($this->ItemEditInstanceName);
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

        $image = $post->image;
        //Put the uploaded file in the proper folder
        if ($image['tmp_name'] != '') {
            $dest = Travelertype::makeimagelocalPath($lObj->GetID());

            move_uploaded_file($image['tmp_name'], $dest );
            if (USE_AWS) {
                $url = HTTP_HOST.'/aws/aws_upload_api.php' .
                                 '?tempfile=' . urlencode($dest) .
                                 '&destfolder=' . urlencode($dest) .
                                 '&callback=' . urlencode(BASE_URL . 'travelertype');
                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $url); 
                curl_setopt($ch, CURLOPT_HEADER, TRUE); 
                curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
                $head = curl_exec($ch); 
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
                curl_close($ch);


                var_dump($url, $head, $httpCode);die();
                die();
                // $result = file_get_contents($url);
                // var_dump($result);die();
            }
        }

        $msg = 'Changes saved!';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . 'travelertype');
        $br->send();

    }

}
