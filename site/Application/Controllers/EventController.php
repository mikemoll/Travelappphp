<?php

include_once 'AbstractController.php';

class EventController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formEvent';
        $this->Action = 'Event';
        $this->TituloLista = "Event";
        $this->TituloEdicao = "Event";
        $this->ItemEditInstanceName = 'EventEdit';
        $this->ItemEditFormName = 'formEventItemEdit';
        $this->Model = 'Event';
        $this->IdWindowEdit = 'EditEvent';
        $this->TplIndex = 'Event/index.tpl';
        $this->TplEdit = 'Event/edit.tpl';
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



        $column = new Ui_Element_DataTables_Column_Date('Event Name', 'eventname');
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
        $button->setVisible('PROC_Event', 'inserir');
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
        $view->assign('body', $view->fetch('Event/app/dashboard.tpl'));
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

        $element = new Ui_Element_Checkbox('public', 'Public Event <small>(Is this event a public event for every user of Travel Track?)</small>');
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $element->setAttrib('switchery', 'switchery');
        $form->addElement($element);

        $element = new Ui_Element_File("Photo", 'Photo');
        $form->addElement($element);

        $element = new Ui_Element_Text('eventname', "Event Name");
        $element->setAttrib('maxlength', 45);
        $form->addElement($element);

        $element = new Ui_Element_Date('start_at', "Starting");
        $form->addElement($element);

        $element = new Ui_Element_Date('end_at', "Ending");
        $form->addElement($element);


        $element = new Ui_Element_Text('address', "address");
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);
        $element = new Ui_Element_Text('city', "city");
        $element->setAttrib('maxlength', 50);
        $form->addElement($element);
        $element = new Ui_Element_Text('country', "country");
        $element->setAttrib('maxlength', 50);
        $form->addElement($element);
        $element = new Ui_Element_Text('dresscode', "dresscode");
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);

        $element = new Ui_Element_Select('id_eventtype', 'event type');
        $element->addMultiOptions(Db_Table::getOptionList2('id_eventtype', 'description', 'description', 'Eventtype'));
        $form->addElement($element);

        $element = new Ui_Element_Select('id_currency', 'Currency');
        $element->addMultiOptions(Db_Table::getOptionList2('id_currency', 'name', 'name', 'Currency'));
        $form->addElement($element);


        $element = new Ui_Element_Text('lat', "lat");
        $element->setAttrib('maxlength', 10);
        $form->addElement($element);

        $element = new Ui_Element_Text('lng', "lng");
        $element->setAttrib('maxlength', 10);
        $form->addElement($element);

        $element = new Ui_Element_Text('geoloc', "geoloc");
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);

//        $element = new Ui_Element_TextMask('price', "price");
        $element = new Ui_Element_Text('price', "price");
//        $element->setMask('9999,99');
        $element->setAttrib('maxlength', 14);
        $form->addElement($element);


        $element = new Ui_Element_Textarea('description', "Description");
//        $element->setTinyMce();
        $element->setAttrib('rows', 4);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('eventsupply', "eventsupply");
//        $element->setTinyMce();
        $element->setAttrib('rows', 3);
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


        ////-------- Grid   Event Activity --------------------------------------------------------------


        $element = new Ui_Element_Select('friends', 'event type');
        $friends = new Friend();
        $friends->where('friend.id_usuario', Usuario::getIdUsuarioLogado());
        $friends->join('eventuser', 'eventuser.id_usuario != friend.id_friend', 'eventuser.id_usuario', 'left');
        $element->addMultiOptions(Db_Table::getOptionList2('id_friend', 'nomecompleto', 'nomecompleto', $friends, false));
        $element->setMultiSelect();
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnAddFriend');
        $button->setDisplay('Invite a Friend to your Event', 'plus');
        $button->setType('success');
        $button->setSendFormFiends();
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);


        $grid = new Ui_Element_DataTables('gridUser');
        $grid->setParams('', BASE_URL . $this->Action . '/listuser');
        $grid->setShowLengthChange(false);
        $grid->setShowSearching(false);
        $grid->setShowPager(false);
//        $grid->setOrder('DataCadastro', 'desc');
//
//
//        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
//        $button->setImg('edit');
//        $button->setVisible('PROC_MENSAGENS', 'editar');
//        $grid->addButton($button);
//
        $button = new Ui_Element_DataTables_Button('btnDeleteEventUser', 'Delete Invitation');
        $button->setImg('trash');
        $button->setAttrib('msg', "Are you sure that you want to delete this?");
        $button->setVisible('PROC_MENSAGENS', 'excluir');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('User Name', 'username');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('email', 'email');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Satus', 'DescSatus');
        $column->setWidth('2');
        $grid->addColumn($column);


        $form->addElement($grid);

        // =========================================================================


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

    public function listuserAction() {
//        $post = Zend_Registry::get('post');
        /* @var $lObj Event */
        $lObj = Event::getInstance($this->ItemEditInstanceName);
        $obj = new EventUser();
        $obj->where('id_event', $lObj->getid_Event());
        $obj->readLst();
        Grid_ControlDataTables::setDataGrid($obj, false, true);
    }

    public function btninviteclickAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        /* @var $lObj Event */
        $lObj = Event::getInstance($this->ItemEditInstanceName);

        if ($lObj->getState() == cCREATE) {
            $br->setMsgAlert('Ops!', 'First You need to save de Event!');
            $br->send();
            return;
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('Invite');

        $element = new Ui_Element_Text('firstname', "Friend's Name");
        $element->setAttrib('maxlength', 35);
        $element->setRequired();
        $element->setAttrib('event', 'blur');
        $element->setAttrib('class', 'form-control');
        $form->addElement($element);
//        $element = new Ui_Element_Select('firstname', "Friend's Name");
//        $element->setSelect2(true);
//        $element->setSelect2AjaxLoad($this->Action);
//        $element->setAttrib('data-allow-clear', 'true');
//        $element->setAttrib('data-placeholder', '');
//        $form->addElement($element);

        $element = new Ui_Element_Text('email', "Email");
        $element->setAttrib('maxlength', 255);
        $form->addElement($element);

//        $obj = new $this->Model();
//        if (isset($post->id)) {
//            $obj->read($post->id);
//            $form->setDataForm($obj);
//        }
//        $obj->setInstance($this->ItemEditInstanceName);

        $button = new Ui_Element_Btn('btnSendInvitation');
        $button->setDisplay('Send', 'send');
        $button->setType('success');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnClose');
        $cancelar->setAttrib('params', 'IdWindowEdit=EditInvite');
        $cancelar->setDisplay('Close', 'times');
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditInvite', 'Invite your Friends', $form->displayTpl($view, 'Event/invite.tpl'));

        $br->newWindow($w);
        $br->send();
    }

//
//    public function firstnamechangeAction() {
//        $br = new Browser_Control();
//        $post = Zend_Registry::get('post');
//        $query = substr($post->controlValue, 1);
//        $query = html_entity_decode($query);
//
//        $friends = new Friend();
//        $friends->where('friend.id_usuario', Usuario::getIdUsuarioLogado());
////        $q = explode(' ', $query);
////        foreach ($l as $nomeCliente) {
////            $friends->where('usuario.nomecompleto', $nomeCliente, 'like', 'or', 'username');
////            $friends->where('usuario.last', $nomeCliente, 'like', 'or', 'username');
////        }
//        $friends->readLst();
////        print'<pre>';
////        die(print_r($friends));
//        $itens = array();
//        if ($friends->countItens() > 0) {
//            for ($i = 0; $i < $friends->countItens(); $i++) {
//                $Item = $friends->getItem($i);
//                $itens[] = $Item->getNomeCompleto() . ' - ' . $Item->getEmail();
//            }
//        }
//        die(json_encode($itens));
//    }

    public function firstnameblurAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $friends = new Friend();
        $friends->where('friend.id_usuario', Usuario::getIdUsuarioLogado());
        $friends->where('usuario.nomecompleto', $post->controlValue, 'like', 'or', 'username');
        $friends->readLst();
        if ($friends->countItens() > 0) {
            $Item = $friends->getItem(0);
            $br->addFieldValue('email', $Item->getEmail());
            $br->setDataForm();
        }
        $br->send();
    }

    public function btnaddfriendclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        /* @var $lObj Event */
        $lObj = Event::getInstance($this->ItemEditInstanceName);

        if ($lObj->getState() == cCREATE) {
            $br->setMsgAlert('Ops!', 'First You need to save de Event!');
            $br->send();
            return;
        }

        foreach ($post->friends as $key => $value) {
//            print'<pre>';die(print_r("$key => $value"  ));
            $eventUser = new EventUser();
            $eventUser->setid_event($lObj->getID());
            $eventUser->setid_usuario($value);
            $eventUser->setstatus('i');
            $eventUser->setid_invitation(0);
            try {
                $eventUser->save();
//                $this->sendInviteToEvent(); // @TODO Implement this method
            } catch (Exception $exc) {
                $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
                $br->send();
                die();
            }
        }

        $lObj->setInstance($this->ItemEditInstanceName);




        $br->setMsgAlert('Sent!', 'Your Invitation was sent!');
//        $br->setRemoveWindow('EditInvite');
        $friends = new Friend();
        $friends->where('friend.id_usuario', Usuario::getIdUsuarioLogado());
        $friends->join('eventuser', 'eventuser.id_usuario != friend.id_friend', 'eventuser.id_usuario');
        $br->addFieldValue('friends', array(), 'select');
        $br->addFieldValue('friends', Db_Table::getOptionList2('id_friend', 'nomecompleto', 'nomecompleto', $friends, false), 'select');
        $br->setDataForm();
        $br->setUpdateDataTables('gridUser');
        $br->send();
    }

    public function btnsaveclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        /* @var $lObj Event */
        $lObj = Event::getInstance($this->ItemEditInstanceName);
        $photo = $post->Photo;
        if ($photo['name'] != '') {
            $lObj->setPhoto(Format_String::normalizeString($photo['name']));
        }
//        print'<pre>';die(print_r( $photo ));
        //Put the uploaded file in the proper folder
        if ($photo['name'] != '') {
            $path = RAIZ_DIRETORY . 'site/Public/Images/Event';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            move_uploaded_file($photo['tmp_name'], $path . '/' . $lObj->getID() . '_' . $lObj->getPhoto());
            $br->setAttrib('PhotoPath', 'src', $lObj->getPhotoPath());
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
        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . $this->Action);
        $br->send();
    }

    public function btndeleteeventuserclickAction() {
        $br = new Browser_Control();
        Grid_ControlDataTables::deleteDataGrid('EventUser', '', 'gridUser', $br);

//        $friends = new Friend();
//        $friends->where('friend.id_usuario', Usuario::getIdUsuarioLogado());
//        $friends->join('eventuser', 'eventuser.id_usuario != friend.id_friend', 'eventuser.id_usuario', 'left');
//        $br->addFieldValue(Db_Table::getOptionList2('id_friend', 'nomecompleto', 'nomecompleto', $friends, false), 'select');
//        $br->setDataForm();


        $br->setMsgAlert('Deleted', 'Item deleted!');
        $br->send();
    }

}
