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

    public function searchcityclickAction() {
        $br = new Browser_Control();
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $q = $post->q;

        // ---- GOOGLE ----------
        $places = array();
        if ($q != '') {
            $ret = $this->callAPI(array('query' => $q, 'type' => '(regions)'));  // commneted to stop making requests

            $res = $ret->results;
            foreach ($res as $value) {
                var_dump($value); die();
                $place['place_id'] = $value->place_id;
                $place['formatted_address'] = $value->formatted_address;
                $place['name'] = $value->name;
                $place['rating'] = $value->rating;
                $place['types'] = $value->types;

                $ph = $value->photos;
                if (is_array($ph)) {
                    foreach ($ph as $photo) {
                        $photo2['src'] = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference=' . $photo->photo_reference . '&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0';
                        $place['photos'][] = $photo2;
                    }
                } else {
                    $place['photos'] = array();
                }
                $places[] = $place;
                $place = array();
            }
//             if (count($places) == 0) {
//                 $place['place_id'] = '21212';
//                 $place['formatted_address'] = 'Paris, France';
//                 $place['name'] = 'Paris';
//                 $place['rating'] = 4.5;
// //            $place['types'] = $value->types;
//                 $photo2['src'] = 'http://www.ladyhattan.com/wp-content/uploads/2014/03/Eiffel-Tower-Paris-France.jpg';
//                 $place['photos'][] = $photo2;
//                 $places[] = $place;
//                 $place = array();
//             }
        }

        $view->assign('places', $places);
        Db_Table::setSession('places', $places);


        $br->setHtml('placesdiv',$view->fetch('Trip/app/searchCity.tpl'));
        $br->send();
    }

    /**
     * Method: POST, PUT, GET etc
     * Data: array("param" => "value") ==> index.php?param=value
     *
     * @param type $method
     * @param type $url
     * @param type $data
     * @return type
     */
    function callAPI($data = false) {
//        https://maps.googleapis.com/maps/api/place/textsearch/json?query=paris&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json';
        $data['key'] = 'AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0';
        $url = sprintf("%s?%s", $url, http_build_query($data));


        $result = file_get_contents($url);


        $result = json_decode($result);
        return $result;
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
        $element->setAttrib('rows', 3);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('travelmethod', "travelmethod");
//        $element->setTinyMce();
        $element->setAttrib('rows', 3);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('inventory', "inventory");
//        $element->setTinyMce();
        $element->setAttrib('rows', 3);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Textarea('notes', "notes");
//        $element->setTinyMce();
        $element->setAttrib('rows', 3);
        $element->setAttrib('maxlength', 500);
        $form->addElement($element);

        $element = new Ui_Element_Date('startdate', "Start Date");
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Date('enddate', "End Date");
        $element->setRequired();
        $form->addElement($element);




        ////-------- Grid   Trip Activity --------------------------------------------------------------

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
//        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
//        $button->setImg('trash');
//        $button->setAttrib('msg', "Are you sure that you want to delete this?");
//        $button->setVisible('PROC_MENSAGENS', 'excluir');
//        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('User Name', 'username');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('email', 'email');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('joined_at', 'joined_at');
        $column->setWidth('2');
        $grid->addColumn($column);


        $form->addElement($grid);

        // =========================================================================
        ////-------- Grid   Trip Activity --------------------------------------------------------------

        $grid = new Ui_Element_DataTables('gridActivity');
        $grid->setParams('', BASE_URL . $this->Action . '/listactivity');
        $grid->setShowLengthChange(false);
        $grid->setShowSearching(false);
        $grid->setShowPager(false);
//        $grid->setOrder('DataCadastro', 'desc');
//        
//        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
//        $button->setImg('edit');
//        $button->setVisible('PROC_MENSAGENS', 'editar');
//        $grid->addButton($button);
//
//        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
//        $button->setImg('trash');
//        $button->setAttrib('msg', "Are you sure that you want to delete this?");
//        $button->setVisible('PROC_MENSAGENS', 'excluir');
//        $grid->addButton($button);

        $column = new Ui_Element_DataTables_Column_Date('Activity Name', 'activityname');
        $column->setWidth('4');
        $grid->addColumn($column);

//        $column = new Ui_Element_DataTables_Column_Text('Trip Name', 'tripname');
//        $column->setWidth('4');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Sueggested by', 'nomecompleto');
        $column->setWidth('3');
        $grid->addColumn($column);

        $form->addElement($grid);

        // =========================================================================
        // ------read model from DB and set on form --------------

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

    public function listuserAction() {
//        $post = Zend_Registry::get('post');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        $obj = new TripUser();
        $obj->where('id_trip', $lObj->getid_trip());
        $obj->readLst();
        Grid_ControlDataTables::setDataGrid($obj, false, true);
    }

    public function listactivityAction() {
//        $post = Zend_Registry::get('post');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        $obj = new TripActivity();
//        $TripUserLst = new TripUser();
//        $TripUserLst->where('id_trip', $lObj->getid_trip());
//        $TripUserLst->readLst();
//        for ($i = 0; $i < $TripUserLst->countItens(); $i++) {
//            $Item = $TripUserLst->getItem($i);
//            $obj->where('tripactivity.id_usuario', $Item->getid_usuario(), '=', 'or', 'users');
//        }
        $obj->where('tripactivity.id_trip', $lObj->getid_trip());
        $obj->readLst();
//        print'<pre>';
//        die(print_r($obj->getSql()));
        Grid_ControlDataTables::setDataGrid($obj, false, true);
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

    public function newtripAction() {
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('trip');
        //$form->setAttrib('role', 'form');


        $form->setDataForm($obj);
        $obj = new Trip;
        //$obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Text('tripname');
        $element->setAttrib('maxlength', 30);
        $element->setRequired();
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnNextone');
        $button->setDisplay('Next');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip1.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnnextoneclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        $form = Session_Control::getDataSession('formNewtrip');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        /* @var $lObj Trip */
        $lObj = Trip::getInstance('newTrip');

        $lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        $br->setBrowserUrl(BASE_URL . 'trip/newtrip2/id/'.$lObj->getID());
        $br->send();
    }

   public function newtrip2Action() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('Trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');


        $form->setDataForm($obj);
        $obj = new Trip;
        $obj->read($post->id);
        $form->setDataForm($obj);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id);
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnNext2');
        $button->setDisplay('Next');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');

        $view->assign('tripname', $obj->gettripname());
        $view->assign('triptypes', Triptype::getAllTripTypesLst());

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip2.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnnext2clickAction() {
        $post = Zend_Registry::get('post');
        $list = $post->triptypes;
        $session = Zend_Registry::get('session');
        $form = Session_Control::getDataSession('formNewtrip');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        } else if ((!is_array($list)) || (count($list) == 0)) {
            $br->setAlert("Please,", "Select at least one trip type.");
            $br->send();
            exit;
        }

        // ----------------------
        /* @var $lObj Trip */
        $lObj = Trip::getInstance('newTrip');

        // save the trip types

        $destLst = $lObj->getTripTriptypesLst();

        // for ($i = 0; $i < $destLst->countItens(); $i++) { // mark all to delete
        //     $Item = $destLst->getItem($i);
        //     $Item->setState(cDELETE);
        // }
        // if (count($list) > 0) {
            foreach ($list as $idTriptype) { //for each item selected by the trip
        //         if ($idTriptype == '') {
        //             continue;
        //         }
        //         $tt = '';
        //         for ($i = 0; $i < $destLst->countItens(); $i++) { // find the tt on the trip type on database
        //             $Item = $destLst->getItem($i);
        //             if ($Item->getid_triptype() == $idTriptype) {
        //                 $tt = $Item;
        //                 break;
        //             } else {
        //                 $tt = '';
        //             }
        //         }

        //        if ($tt == '') { // if the tt doesn't exist on trip type, add it.
                    $n = new TripTriptype();
                    $n->setid_triptype($idTriptype);
                    $n->setid_trip($lObj->getID());
                    $destLst->addItem($n);
        //        } else {
        //            $tt->setState(cUPDATE); //else update it
        //        }
            }
        // }

        $lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';
        $br->setBrowserUrl(BASE_URL . 'trip/newtrip3/id/'.$lObj->getID());
        $br->send();
    }

    public function newtrip3Action() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');


        $form->setDataForm($obj);
        $obj = new Trip;
        //$obj->read($id);
        $form->setDataForm($obj);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Text('friendname1');
        $element->setAttrib('maxlength', 35);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail1');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendname2');
        $element->setAttrib('maxlength', 35);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail2');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendname3');
        $element->setAttrib('maxlength', 35);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail3');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendname4');
        $element->setAttrib('maxlength', 35);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail4');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendname5');
        $element->setAttrib('maxlength', 35);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail5');
        $element->setAttrib('maxlength', 255);
        $element->setHideRemainingCharacters();
        //$element->setAttrib('placeholder', '');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnNext3');
        $button->setDisplay('Next');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip3.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnnext3clickAction() {
        $post = Zend_Registry::get('post');
        $list = $post->id_usuario_friend;
        $session = Zend_Registry::get('session');
        $form = Session_Control::getDataSession('formNewtrip');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        // ----------------------
        /* @var $lObj Trip */
        $lObj = Trip::getInstance('newTrip');

        // save the trip types

        if (is_array($list)) {

            $destLst = $lObj->getTripUserLst();

            // for ($i = 0; $i < $destLst->countItens(); $i++) { // mark all to delete
            //     $Item = $destLst->getItem($i);
            //     $Item->setState(cDELETE);
            // }
            // if (count($list) > 0) {
                foreach ($list as $id_usuario) { //for each item selected by the trip
            //         if ($idTriptype == '') {
            //             continue;
            //         }
            //         $tt = '';
            //         for ($i = 0; $i < $destLst->countItens(); $i++) { // find the tt on the trip type on database
            //             $Item = $destLst->getItem($i);
            //             if ($Item->getid_triptype() == $idTriptype) {
            //                 $tt = $Item;
            //                 break;
            //             } else {
            //                 $tt = '';
            //             }
            //         }

            //        if ($tt == '') { // if the tt doesn't exist on trip type, add it.
                        $n = new TripUser();
                        $n->setid_trip($lObj->getID());
                        $n->setid_usuario($idTriptype);
                        $n->setstatus('i');
                        $destLst->addItem($n);
            //        } else {
            //            $tt->setState(cUPDATE); //else update it
            //        }
                }
        }
        // }
        
        // for a while I'm not saving the name/ e-mail

        $lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';
        $br->setBrowserUrl(BASE_URL . 'trip/newtrip4/id/'.$lObj->getID());
        $br->send();
    }

    public function newtrip4Action() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('Trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');


        $form->setDataForm($obj);
        $obj = new Trip;
        $obj->read($post->id);
        $form->setDataForm($obj);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id);
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnNext4');
        $button->setDisplay('Next');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');

        $view->assign('tripname', $obj->gettripname());

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip4.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }
}
