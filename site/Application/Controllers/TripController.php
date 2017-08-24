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

        // We need to add this here because when we open a new task or budget that need dates and mask working, the script needs to be loaded
        Browser_Control::setScript('js', 'jquery.inputmask', '../../site/Public/assets/plugins/jquery-inputmask/jquery.inputmask.min.js');
        Browser_Control::setScript('css', 'datepicker3', '../../site/Public/assets/plugins/bootstrap-datepicker/css/datepicker3.css');
        Browser_Control::setScript('js', 'bootstrap-datepicker', '../../site/Public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');
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



        $column = new Ui_Element_DataTables_Column_Text('Trip Name', 'tripname');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Description', 'ShortDescription');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Date('Start', 'startdate');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Date('End', 'enddate');
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
        $post = Zend_Registry::get('post');
//        $br = new Browser_Control();

        $oldtrip = $post->oldtrip == 'show';
        $TripLst = new Trip();
        $TripLst->join('tripuser', 'tripuser.id_trip = trip.id_trip', '');
        $TripLst->where('tripuser.id_usuario', Usuario::getIdUsuarioLogado());
        if ($oldtrip) {
            $view->assign('btnOldTripHref', HTTP_REFERER . 'trip/dashboard/oldtrip/hide');
            $view->assign('btnOldTripText', 'Hide old trips');
        } else {
            $view->assign('btnOldTripHref', HTTP_REFERER . 'trip/dashboard/oldtrip/show');
            $view->assign('btnOldTripText', 'Show old trips');
            $TripLst->where('trip.enddate', date('Y-m-d'), '>=');
        }

        $TripLst->readLst();

        for ($i = 0; $i < $TripLst->countItens(); $i++) {
            $Item = $TripLst->getItem($i);
            $TripPlaceLst = new Tripplace();
            $TripPlaceLst->where('id_trip', $Item->getID());
            $TripPlaceLst->readLst();
            $Item->setTripplaceLst($TripPlaceLst);
        }
        $view->assign('tripLst', $TripLst->getItens());

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);
        $view->assign('body', $view->fetch('Trip/app/dashboard.tpl'));
        $view->output('index.tpl');
    }

    public function detailAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');
//        $br = new Browser_Control();

        $Trip = new Trip();
        $Trip->read($post->id);



        $view->assign('trip', $Trip);

        $Trip->setInstance($this->ItemEditInstanceName);

        $form = new Ui_Form();
        $form->setAction('Trip');
        $form->setName('formTripDetail');



        $element = new Ui_Element_Timer('conversation4', '5000');
        $element->setAttrib('params', 'id_trip=' . $Trip->getID());
        $form->addElement($element);

        // ====== CREATE A TAB COMPONENT ========================
        $mainTab = new Ui_Element_TabMain('tripTabs');

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabOverview');
        $tab->setTitle('Overview');
        $tab->setTemplate('Trip/app/detail/tabs/overview.tpl');

        $view->assign('TripActivityLst', $Trip->getTripActivityLst()->getItens());
        $view->assign('TripplaceLst', $Trip->getTripplaceLst()->getItens());

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabItinerary');
        $tab->setTitle('Itinerary');
        $tab->setTemplate('Trip/app/detail/tabs/itinerary.tpl');

        $itinerary = $Trip->getTripItinerary();



        $button = new Ui_Element_Btn('btnSendMsg4');
        $button->setDisplay('', 'paper-plane-o');
        $button->setAttrib('params', 'id_trip=' . $Trip->getID() . '&id_chat=4');
        $button->setType('');
        $button->setSendFormFiends('true');
        $tab->addElement($button);

        $view->assign('itinerary', $itinerary);

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabToDo');
        $tab->setTitle('To-Do List');
        $tab->setTemplate('Trip/app/detail/tabs/todo.tpl');

        $button = new Ui_Element_Btn('btnEditTask');
        $button->setDisplay('New Task', 'plus');
        $button->setType('success');
        $tab->addElement($button);

        // ---- Create Grid ----
        $grid = new Ui_Element_DataTables('gridTask');
        $grid->setParams('', BASE_URL . $this->Action . '/tasklist');
        $grid->setShowInfo(false);
        $grid->setShowLengthChange(false);
        $grid->setShowPager(false);
        $grid->setShowSearching(false);

        // ---- Buttons -----
        $button = new Ui_Element_DataTables_Button('btnDoneTask', 'Done');
        $button->setImg('check');
        $button->setAttrib('class', 'btn btn-sm btn-success');
        $button->setVisible('TRIP_TASK', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnEditTask', 'Edit');
        $button->setImg('edit');
        $button->setAttrib('class', 'btn btn-sm btn-default');
        $button->setVisible('TRIP_TASK', 'editar');
        $grid->addButton($button);


        $button = new Ui_Element_DataTables_Button('btnDelTask', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setAttrib('class', 'btn btn-sm btn-default');
        $button->setVisible('TRIP_TASK', 'excluir');
        $grid->addButton($button);


        // ---- Columns -----

        $column = new Ui_Element_DataTables_Column_Text('Task', 'description');
        $column->setWidth('8');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Due Date', 'duedate');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Type', 'TypeDesc');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Resp', 'responsable', 'center');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_ImageCond('Done?', 'Done', 'center');
        $column->setCondicao('S', 'done', '==');
        $column->setImages('check', '');
        $column->setWidth('1');
        $grid->addColumn($column);
        // ---- add grid to the Form ----
        $tab->addElement($grid);



        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabPacking');
        $tab->setTitle('Packing List');
        $tab->setTemplate('Trip/app/detail/tabs/packing.tpl');



        $button = new Ui_Element_Btn('btnEditPackingItem');
        $button->setDisplay('New Item', 'plus');
        $button->setType('success');
        $tab->addElement($button);

        // ---- Create Grid ----
        $grid = new Ui_Element_DataTables('gridPacking');
        $grid->setParams('', BASE_URL . $this->Action . '/packinglist');
        $grid->setShowInfo(false);
        $grid->setShowLengthChange(false);
        $grid->setShowPager(false);
        $grid->setShowSearching(false);

        // ---- Buttons -----
        $button = new Ui_Element_DataTables_Button('btnDonePackingItem', 'Done');
        $button->setImg('check');
        $button->setAttrib('class', 'btn btn-sm btn-success');
        $button->setVisible('TRIP_TASK', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnEditPackingItem', 'Edit');
        $button->setImg('edit');
        $button->setAttrib('class', 'btn btn-sm btn-default');
        $button->setVisible('TRIP_TASK', 'editar');
        $grid->addButton($button);


        $button = new Ui_Element_DataTables_Button('btnDelPackingItem', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setAttrib('class', 'btn btn-sm btn-default');
        $button->setVisible('TRIP_TASK', 'excluir');
        $grid->addButton($button);


        // ---- Columns -----

        $column = new Ui_Element_DataTables_Column_Text('Type', 'TypeDesc');
        $column->setWidth('2');
        $grid->addColumn($column);


        $column = new Ui_Element_DataTables_Column_Text('Item', 'description');
        $column->setWidth('7');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Responsable', 'responsable', 'center');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_ImageCond('Done?', 'Done', 'center');
        $column->setWidth('1');
        $column->setImages('check', '');
        $column->setCondicao('S', 'done', '==');
        $grid->addColumn($column);
        // ---- add grid to the Form ----
        $tab->addElement($grid);



        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabTransportation');
        $tab->setTitle('Transportation');
        $tab->setTemplate('Trip/app/detail/tabs/transportation.tpl');

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabBudget');
        $tab->setTitle('Budget');
        $tab->setTemplate('Trip/app/detail/tabs/budget.tpl');

        $view->assign('totalBudget', $Trip->getTotalBudget());

        $button = new Ui_Element_Btn('btnEditExpense');
        $button->setDisplay('New Expense', 'plus');
        $button->setType('success');
        $button->setVisible('TRIP_BUDGET', 'inserir');
        $tab->addElement($button);

        // ---- Create Grid ----
        $grid = new Ui_Element_DataTables('gridExpense');
        $grid->setParams('', BASE_URL . $this->Action . '/expenselist');
        $grid->setShowInfo(false);
        $grid->setShowLengthChange(false);
        $grid->setShowPager(false);
        $grid->setShowSearching(false);

        // ---- Buttons -----

        $button = new Ui_Element_DataTables_Button('btnEditExpense', 'Edit');
        $button->setImg('edit');
        $button->setVisible('TRIP_BUDGET', 'editar');
        $grid->addButton($button);
//
        $button = new Ui_Element_DataTables_Button('btnDelExpense', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setVisible('TRIP_BUDGET', 'excluir');
        $grid->addButton($button);
        // ---- Columns -----
        $column = new Ui_Element_DataTables_Column_Text('Description', 'description');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Amount', 'Amount');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_ImageCond('Per Person', 'totalorperson');
        $column->setCondicao('P', 'totalorperson', '==');
        $column->setImages('check', 'times');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Covered by', 'coveredby');
        $column->setWidth('2');
        $grid->addColumn($column);

        // ---- add grid to the Form ----
        $tab->addElement($grid);

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabContact');
        $tab->setTitle('Contact');
        $tab->setTemplate('Trip/app/detail/tabs/contact.tpl');

        $button = new Ui_Element_Btn('btnEditContactInfo');
        $button->setDisplay('New Contact Info', 'plus');
        $button->setType('success');
        $button->setVisible('TRIP_BUDGET', 'inserir');
        $tab->addElement($button);

        // ---- Create Grid ----
        $grid = new Ui_Element_DataTables('gridContactInfo');
        $grid->setParams('', BASE_URL . $this->Action . '/travelerlist');
        $grid->setShowInfo(false);
        $grid->setShowLengthChange(false);
        $grid->setShowPager(false);
        $grid->setShowSearching(false);

        // ---- Buttons -----
        $button = new Ui_Element_DataTables_Button('btnEditContactInfo', 'Edit');
        $button->setImg('edit');
        $button->setVisible('TRIP_BUDGET', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelContactInfo', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setVisible('TRIP_BUDGET', 'excluir');
        $grid->addButton($button);

        // ---- Columns -----
        $column = new Ui_Element_DataTables_Column_Text('Name', 'username');
        $column->setWidth('7');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Passport', 'passport');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Contact Name', 'contactname');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Doctor Name', 'doctorname');
        $column->setWidth('1');
        $grid->addColumn($column);

        // ---- add grid to the Form ----
        $tab->addElement($grid);


        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabTravelers');
        $tab->setTitle('Travelers');
        $tab->setTemplate('Trip/app/detail/tabs/travelers.tpl');

        $button = new Ui_Element_Btn('btnEditTraveler');
        $button->setDisplay('New Traveler', 'plus');
        $button->setType('success');
        $button->setVisible('TRIP_BUDGET', 'inserir');
        $tab->addElement($button);

        // ---- Create Grid ----
        $grid = new Ui_Element_DataTables('gridTraveler');
        $grid->setParams('', BASE_URL . $this->Action . '/travelerlist');
        $grid->setShowInfo(false);
        $grid->setShowLengthChange(false);
        $grid->setShowPager(false);
        $grid->setShowSearching(false);

        // ---- Buttons -----
//
//        $button = new Ui_Element_DataTables_Button('btnEditTraveler', 'Edit');
//        $button->setImg('edit');
//        $button->setVisible('TRIP_BUDGET', 'editar');
//        $grid->addButton($button);
////
        $button = new Ui_Element_DataTables_Button('btnDelTraveler', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setVisible('TRIP_BUDGET', 'excluir');
        $grid->addButton($button);
        // ---- Columns -----
        $column = new Ui_Element_DataTables_Column_Text('Name', 'username');
        $column->setWidth('11');
        $grid->addColumn($column);

        // ---- add grid to the Form ----
        $tab->addElement($grid);

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabChat');
        $tab->setTitle('<span>Trip Chat <span title="3 new comments" class="label label-warning">3</span></span>');
        $tab->setTemplate('Trip/app/detail/tabs/chat.tpl');

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabRecommendations');
        $tab->setTitle('Recommendations');
        $tab->setTemplate('Trip/app/detail/tabs/recommendation.tpl');
        $lst = $Trip->getTripRecommendationLst()->getItens();
        $view->assign('RecommendationLst',$lst);
        $view->assign('public', false);

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);


        // --------- Add tab Component to the Form ---------
        $form->addElement($mainTab);



        $form->setDataSession();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);
        $view->assign('body', $form->displayTpl($view, 'Trip/app/detail/index.tpl'));
        $view->output('index.tpl');
    }

    public function btnaddactivityclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);

        $obj = new TripActivity();
        if (isset($post->id)) {
            $lLst = $lObj->getTripActivityLst();
            $obj = $lLst->getItemByID($post->id);
//            // if some field needs to be readonly on the item edition, use this variable;
////            $readOnly = true;
        } else {
            $placeLst = $lObj->getTripplaceLst();
            $place = $placeLst->getItemByID($post->id_place);
            $obj->setStart_at(substr($place->getStartDate(), 0, 10));
            $obj->setid_tripplace($post->id_place);
            $view->assign('start_at', substr($place->getStartDate(), 0, 10));
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        // ====== CREATE A TAB COMPONENT ========================
        $mainTab = new Ui_Element_TabMain('tabsTripActivity');

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabAddActivity');
        $tab->setTitle('Your Activity');
        $tab->setTemplate('Trip/app/detail/edit/activity/tab_activity.tpl');



        $element = new Ui_Element_Hidden('id_tripplace');
        $form->addElement($element);


        $element = new Ui_Element_Text('activityname', "Activity Name");
        $element->setAttrib('maxlength', 45);
        $form->addElement($element);

        $element = new Ui_Element_Date('start_at', "Date");
        $element->setRequired();
        $element->setValue($date);
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

        $element = new Ui_Element_Select('id_activitytype', 'activity type');
        $element->addMultiOptions(Db_Table::getOptionList2('id_activitytype', 'activitytypename', 'activitytypename', 'Activitytype'));
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

        $element = new Ui_Element_Textarea('activitysupply', "activitysupply");
//        $element->setTinyMce();
        $element->setAttrib('rows', 4);
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



        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

// ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabDreamboard');
        $tab->setTitle('Dreamboeard');
        $tab->setVisible(!isset($post->id)); // shows only if it is a new activity, otherwise the tab is shown
        $tab->setTemplate('Trip/app/detail/edit/activity/tab_dreamboard.tpl');

        if (!isset($post->id)) {
//// ------ list of Dreams ----------
//        $button = new Ui_Element_Btn('btnShowDreamBoard');
//        $button->setDisplay('Choose one from your DreamBoard', '');
//        $button->setType('info');
//        $button->setHref('#dreamboard');
//        $button->setAttrib('data-togle', 'collapse');
//        $form->addElement($button);

            $dreamLts = new Dreamboard;
            $dreamLts->where('dreamboard.id_usuario', Usuario::getIdUsuarioLogado());
            $dreamLts->readLst();
            if ($dreamLts->countItens() > 0) {
                $ActivityLst = new Activity();
                for ($i = 0; $i < $dreamLts->countItens(); $i++) {
                    $dream = $dreamLts->getItem($i);
                    // ---- Activities ----------
                    $ActivityLst->where('activity.id_activity', $dream->getId_Activity(), '=', 'or', 'id');
                }
                $ActivityLst->readLst();
                $view->assign('activityLst', $ActivityLst->getItens());
                $view->assign('activityLstHtml', $view->fetch('Trip/app/detail/edit/activity/add_activity_favorite_active_list.tpl'));
            }
        }



        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);


        // --------- Add tab Component to the Form ---------
        $form->addElement($mainTab);

        $form->setDataForm($obj);
        $obj->setInstance('TripActivityEdit');

        $button = new Ui_Element_Btn('btnSaveTripActivity');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnClose');
        $button->setAttrib('params', 'IdWindowEdit=' . 'EditTask');
        $button->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($button);

        $form->setDataSession();

        $w = new Ui_Window('EditTripActivity', 'Adding an Activity', $form->displayTpl($view, 'Trip/app/detail/edit/activity/index.tpl'));
        $w->setDimension('lg');
        $w->setCloseOnEscape();
        $br->newWindow($w);
        $br->send();
    }

    public function idtripplacechangeAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        $placeLst = $lObj->getTripplaceLst();
        $place = $placeLst->getItemByID($post->controlValue);

        $br->addFieldValue('start_at', substr($place->getStartDate(), 0, 10));
        $br->setDataForm();
        $br->send();
    }

    public function btnedittaskclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('description', "Description");
//        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 150);
        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Checkbox('done', "Task Done!");
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $element->setAttrib('switchery', 'switchery');
        $form->addElement($element);

        $element = new Ui_Element_Date('duedate', "Due Date");
//        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Select('id_type', 'Task Type');
        $element->addMultiOptions(Triptask::getTripTaskTypeList());
        $form->addElement($element);

        $element = new Ui_Element_Select('id_responsable', 'Responsible');
        $element->addMultiOptions($lObj->getTripUserList()); //@TODO get only the trip-mates
        $form->addElement($element);



        $obj = new Triptask();
        if (isset($post->id)) {
            $lLst = $lObj->getTriptaskLst();
            $obj = $lLst->getItem($post->id);
        }
        $form->setDataForm($obj);
        $obj->setInstance('TriptaskEdit');

        $button = new Ui_Element_Btn('btnSaveTask');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . 'EditTask');
        $cancelar->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditTask', 'Editing', $form->displayTpl($view, 'Trip/app/detail/edit/task.tpl'));
        $w->setCloseOnEscape();
        $br->newWindow($w);
        $br->send();
    }

    public function btneditpackingitemclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the packingitem edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('description', "Description");
//        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 150);
        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Checkbox('done', "Packed!");
        $element->setCheckedValue('S');
        $element->setUncheckedValue('N');
        $element->setAttrib('switchery', 'switchery');
        $form->addElement($element);


        $element = new Ui_Element_Select('id_type', 'Category');
        $element->addMultiOptions(Trippackingitem::getTripPackingItemTypeList());
        $form->addElement($element);

        $element = new Ui_Element_Select('id_responsable', 'Responsible');
        $element->addMultiOptions($lObj->getTripUserList()); //@TODO get only the trip-mates
        $form->addElement($element);



        $obj = new Trippackingitem();
        if (isset($post->id)) {
            $lLst = $lObj->getTrippackingitemLst();
            $obj = $lLst->getItem($post->id);
        }
        $form->setDataForm($obj);
        $obj->setInstance('TrippackingitemEdit');

        $button = new Ui_Element_Btn('btnSavePackingItem');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . 'EditPackingItem');
        $cancelar->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditPackingItem', 'Editing', $form->displayTpl($view, 'Trip/app/detail/edit/packingitem.tpl'));
        $w->setCloseOnEscape();
        $br->newWindow($w);
        $br->send();
    }

    public function btneditcontactinfoclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }
        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Select('id_usuario', 'Select the Friend');
        $element->addMultiOptions(Usuario::getFriendsList());
        $element->setReadOnly($readOnly);
        $form->addElement($element);

        $element = new Ui_Element_Date('birthdate', 'd.o.b');
        $form->addElement($element);

        $element = new Ui_Element_Text('nationality', 'NATIONALITY #1');
        $element->setMaxLength(50);
        $form->addElement($element);

        $element = new Ui_Element_Text('nationality2', 'NATIONALITY #2');
        $element->setMaxLength(50);
        $form->addElement($element);

        $element = new Ui_Element_Text('passport', 'PASSPORT  #1');
        $element->setMaxLength(50);
        $form->addElement($element);

        $element = new Ui_Element_Text('passport2', ' PASSPORT #2');
        $element->setMaxLength(50);
        $form->addElement($element);

        $element = new Ui_Element_Text('allergies', 'ALLERGIES');
        $element->setMaxLength(100);
        $form->addElement($element);

        $element = new Ui_Element_Text('medicalissues', 'MEDICAL ISSUES');
        $element->setMaxLength(200);
        $form->addElement($element);

        $element = new Ui_Element_Text('contactname', 'Contact NAME');
        $element->setMaxLength(100);
        $form->addElement($element);

        $element = new Ui_Element_Text('contactrelationship', 'Contact RELATIONSHIP');
        $element->setMaxLength(50);
        $form->addElement($element);

        $element = new Ui_Element_Text('contactnumber', 'Contact NUMBER');
        $element->setMaxLength(20);
        $form->addElement($element);

        $element = new Ui_Element_Text('contactemail', 'Contact EMAIL');
        $element->setMaxLength(100);
        $form->addElement($element);

        $element = new Ui_Element_Text('doctorname', "Doctor's Name");
        $element->setMaxLength(100);
        $form->addElement($element);

        $element = new Ui_Element_Text('doctornumber', "Doctor's NUMBER");
        $element->setMaxLength(20);
        $form->addElement($element);

        $element = new Ui_Element_Text('doctoremail', "Doctor's EMAIL");
        $element->setMaxLength(100);
        $form->addElement($element);



        $obj = new TripUser();
        if (isset($post->id)) {
            $lLst = $lObj->getTripUserLst();
            $obj = $lLst->getItem($post->id);
        }
        $form->setDataForm($obj);
        $obj->setInstance('TripUserEdit');

        $button = new Ui_Element_Btn('btnSaveContactInfo');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . 'EditContactInfo');
        $cancelar->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditContactInfo', 'Add your Contact Info', $form->displayTpl($view, 'Trip/app/detail/edit/contact_info.tpl'));
        $w->setCloseOnEscape();
        $br->newWindow($w);
        $br->send();
    }

    public function btnedittravelerclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
            $readOnly = true;
        }
        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Select('id_usuario', 'Select the Friend');
        $element->addMultiOptions(Usuario::getFriendsList());
        $element->setReadOnly($readOnly);
        $form->addElement($element);

        $element = new Ui_Element_Text('friendname', 'Friend Name');
        $element->setReadOnly();
        $form->addElement($element);

        $element = new Ui_Element_Text('friendemail', 'Friend Email');
        $element->setReadOnly();
        $form->addElement($element);


        $obj = new TripUser();
        if (isset($post->id)) {
            $lLst = $lObj->getTripUserLst();
            $obj = $lLst->getItem($post->id);
        }
        $form->setDataForm($obj);
        $obj->setInstance('TripUserEdit');

        $button = new Ui_Element_Btn('btnSaveTraveler');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . 'EditTraveler');
        $cancelar->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditTraveler', 'Editing', $form->displayTpl($view, 'Trip/app/detail/edit/traveler.tpl'));
        $w->setCloseOnEscape();
        $br->newWindow($w);
        $br->send();
    }

    public function btneditexpenseclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formTripexpense');

        $element = new Ui_Element_Textarea('description', "Description");
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);


        $element = new Ui_Element_Select('id_usuario', "Who's covering this?");
        $element->addMultiOptions($lObj->getTripUserList()); //@TODO get only the trip-mates
        $form->addElement($element);

        $element = new Ui_Element_Select('id_currency', "");
        $element->addMultiOptions(Db_Table::getOptionList2('id_currency', 'symbol', 'symbol', 'Currency', false));
        $form->addElement($element);

        $element = new Ui_Element_Text('amount', "");
        $element->setAttrib('maxlength', 11);
        $element->setAttrib('placehold', '0.00');
        $form->addElement($element);

        $element = new Ui_Element_Radio('totalorperson', "");
        $element->addMultiOption('T', 'Total');
        $element->addMultiOption('P', 'Per Person');
        $form->addElement($element);

        $element = new Ui_Element_Radio('split', "");
        $element->addMultiOption('E', 'Split Evenly');
        $element->addMultiOption('M', 'Split Manually');
        $form->addElement($element);


        $obj = new Tripexpense();
        if (isset($post->id)) {
            $lLst = $lObj->getTripexpenseLst();
            $obj = $lLst->getItem($post->id);
        }
        $form->setDataForm($obj);
        $obj->setInstance('TripexpenseEdit');



        $button = new Ui_Element_Btn('btnSaveExpense');
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
        $cancelar->setAttrib('params', 'IdWindowEdit=' . 'EditExpense');
        $cancelar->setDisplay('Cancel', 'times');
//        $cancelar->setHref(BASE_URL . $this->Action);
        $form->addElement($cancelar);

        $form->setDataSession();

        $w = new Ui_Window('EditExpense', 'Editing', $form->displayTpl($view, 'Trip/app/detail/edit/expense.tpl'));
        $w->setCloseOnEscape();
        $br->newWindow($w);

        $br->send();
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
//        $beutton->setVisible('PROC_MENSAGENS', 'editar');
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
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancel');
        $cancelar->setAttrib('params', 'IdWindowEdit=' . $this->IdWindowEdit);
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

    public function tasklistAction() {
//        $post = Zend_Registry::get('post');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::setDataGrid($lObj->getTriptaskLst(), false, false);
    }

    public function packinglistAction() {
//        $post = Zend_Registry::get('post');
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::setDataGrid($lObj->getTrippackingitemLst(), false, false);
    }

    public function expenselistAction() {
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::setDataGrid($lObj->getTripexpenseLst(), false, false);
    }

    public function travelerlistAction() {
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::setDataGrid($lObj->getTripUserLst(), false, false);
    }

    public function listactivityAction() {
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        $obj = new TripActivity();
        $obj->where('tripactivity.id_trip', $lObj->getid_trip());
        $obj->readLst();
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

    public function btnsavetripactivityclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);

        // ---- FORM VALIDATION ------------------
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // -----/end FORM VALIDATION -----------------


        if (isset($post->id)) {
            /* @var $lObj TripActivity */
            $lObj = TripActivity::getInstance('TripActivityEdit');
        } else {
            /* @var $lObj TripActivity */
            $lObj = new TripActivity();
        }

        $lObj->setDataFromRequest($post);
        $lObj->setid_trip($lTrip->getID());
        $lObj->setid_place($post->id_place);

        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $lLst = $lTrip->getTripActivityLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $br->setBrowserUrl('');


        $br->send();
    }

    public function addactivityclickAction() {
        $post = Zend_Registry::get('post');
//        print'<pre>';die(print_r( $post ));
        $br = new Browser_Control();
        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);

        // ---- FORM VALIDATION ------------------
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // -----/end FORM VALIDATION -----------------


        if (isset($post->id)) {
            /* @var $lObj TripActivity */
            $lObj = TripActivity::getInstance('TripActivityEdit');
        } else {
            /* @var $lObj TripActivity */
            $lObj = new TripActivity();
        }

        $Activity = new Activity();
        $Activity->read($post->id_activity);

        $lObj->setCopyFromActivity($Activity);
//        print'<pre>';die(print_r( $lObj ));
        $lObj->setid_trip($lTrip->getID());
        $lObj->setid_place($post->id_place);
        $lObj->setstart_at($post->start_at);
        $lObj->setend_at($post->start_at);

        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }

        $lLst = $lTrip->getTripActivityLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $br->setBrowserUrl('');


        $br->send();
    }

    public function btnsavetaskclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        $post = Zend_Registry::get('post');
        if (isset($post->id)) {
            /* @var $lObj Trip */
            $lObj = Triptask::getInstance('TriptaskEdit');
        } else {
            /* @var $lObj Trip */
            $lObj = new Triptask();
        }

        $lObj->setDataFromRequest($post);
        $lObj->setid_trip($lTrip->getID());

        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $lLst = $lTrip->getTriptaskLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow('EditTask');
        $br->setUpdateDataTables('gridTask');
        $br->send();
    }

    public function btndonetaskclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        // ----------------------

        /* @var $lTrip Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);

        // ----------------------
        $lLst = $lTrip->getTriptaskLst();
        $lObj = $lLst->getItem($post->id);
        if ($lObj->getDone() == 'S') {
            $lObj->setDone("N");
        } else {
            $lObj->setDone("S");
        }

        try {
            $lTrip->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setUpdateDataTables('gridTask');
        $br->send();
    }

    public function btnsavepackingitemclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        $post = Zend_Registry::get('post');
        if (isset($post->id)) {
            /* @var $lObj Trip */
            $lObj = Trippackingitem::getInstance('TrippackingitemEdit');
        } else {
            /* @var $lObj Trip */
            $lObj = new Trippackingitem();
        }

        $lObj->setDataFromRequest($post);
        $lObj->setid_trip($lTrip->getID());

        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $lLst = $lTrip->getTrippackingitemLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow('EditPackingItem');
        $br->setUpdateDataTables('gridPacking');
        $br->send();
    }

    public function btndonepackingitemclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        // ----------------------

        /* @var $lTrip Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);

        // ----------------------
        $lLst = $lTrip->getTrippackingitemLst();
        $lObj = $lLst->getItem($post->id);
        if ($lObj->getDone() == 'S') {
            $lObj->setDone("N");
        } else {
            $lObj->setDone("S");
        }

        try {
            $lTrip->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setUpdateDataTables('gridPacking');
        $br->send();
    }

    public function btnsavetravelerclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        $post = Zend_Registry::get('post');
        if (isset($post->id)) {
            /* @var $lObj TripUser */
            $lObj = TripUser::getInstance('TripUserEdit');
        } else {
            /* @var $lObj TripUser */
            $lObj = new TripUser();
        }


//        if ($post->id_usuario == '') {
//
//            $msg = 'Friend added to your trip';
//            $br->setMsgAlert('Done', $msg);
//            $br->setRemoveWindow('Edittraveler');
//            $br->setUpdateDataTables('gridtraveler');
//            $br->send();
//        }



        $lObj->setDataFromRequest($post);
        $lObj->setid_trip($lTrip->getID());

        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $lLst = $lTrip->getTripUserLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow('Edittraveler');
        $br->setUpdateDataTables('gridtraveler');
        $br->send();
    }

    public function btnsavecontactinfoclickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        $post = Zend_Registry::get('post');
        if (isset($post->id)) {
            /* @var $lObj TripUser */
            $lObj = TripUser::getInstance('TripUserEdit');
        } else {
            /* @var $lObj TripUser */
            $lObj = new TripUser();
        }


//        if ($post->id_usuario == '') {
//
//            $msg = 'Friend added to your trip';
//            $br->setMsgAlert('Done', $msg);
//            $br->setRemoveWindow('Edittraveler');
//            $br->setUpdateDataTables('gridtraveler');
//            $br->send();
//        }

        $user = new Usuario();
        $user->read($post->id_usuario);
        $user->setDataFromRequestContactInfo($post);

//        print'<pre>';die(print_r($user  ));

        try {
            $user->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $lLst = $lTrip->getTripUserLst();

        $lObj->read();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);


        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow('EditContactInfo');
        $br->setUpdateDataTables('gridContactInfo');
        $br->send();
    }

    public function btnsaveexpenseclickAction() {
        $post = Zend_Registry::get('post');
//        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();
        // ----------------------

        /* @var $lObj Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession('formTripexpense');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }
        // ----------------------
        $post = Zend_Registry::get('post');
        if (isset($post->id)) {
            /* @var $lObj Trip */
            $lObj = Tripexpense::getInstance('TripexpenseEdit');
        } else {
            /* @var $lObj Trip */
            $lObj = new Tripexpense();
        }

        $lObj->setDataFromRequest($post);
        $lObj->setid_trip($lTrip->getID());
        try {
            $lObj->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $lLst = $lTrip->getTripexpenseLst();

        $lLst->addItem($lObj, $post->id);
        $lTrip->setInstance($this->ItemEditInstanceName);




        $br->setHtml('totalBudget', $lTrip->getTotalBudget());



        $msg = '';
        $br->setMsgAlert('Saved!', $msg);
        $br->setRemoveWindow('EditExpense');
        $br->setUpdateDataTables('gridExpense');
        $br->send();
    }

    public function btndelexpenseclickAction() {
        $br = new Browser_Control();
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::deleteDataGrid($this->ItemEditInstanceName, 'TripexpenseLst', 'gridExpense', $br);


        // save the Trip to save the deletion of the Item
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $br->setHtml('totalBudget', $lObj->getTotalBudget());
        $br->setMsgAlert('Deleted', 'Item deleted!');
//        $br->setMsgAlert('Coming soon!', '');
        $br->send();
    }

    public function btndeltaskclickAction() {
        $br = new Browser_Control();
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::deleteDataGrid($this->ItemEditInstanceName, 'TriptaskLst', 'gridTask', $br);


        // save the Trip to save the deletion of the Item
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $br->setHtml('totalBudget', $lObj->getTotalBudget());
        $br->setMsgAlert('Deleted', 'Item deleted!');
//        $br->setMsgAlert('Coming soon!', '');
        $br->send();
    }

    public function btndelpackingitemclickAction() {
        $br = new Browser_Control();
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::deleteDataGrid($this->ItemEditInstanceName, 'TrippackingitemLst', 'gridPacking', $br);


        // save the Trip to save the deletion of the Item
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $br->setHtml('totalBudget', $lObj->getTotalBudget());
        $br->setMsgAlert('Deleted', 'Item deleted!');
//        $br->setMsgAlert('Coming soon!', '');
        $br->send();
    }

    public function btndelactivityclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        /* @var $lTrip Trip */
        $lTrip = Trip::getInstance($this->ItemEditInstanceName);


        $lLst = $lTrip->getTripActivityLst();

        $lObj = $lLst->getItemByID($post->id);
        $lObj->setDeleted();
        try {
            $lObj->save();
//            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }


        $br->setMsgAlert('Deleted', 'Item deleted!');
        $br->setBrowserUrl('');
//        $br->setMsgAlert('Coming soon!', '');
        $br->send();
    }

    // ===========================================================================================
    // ===========================================================================================
    // =================  NEW TRIP    ============================================================
    // ===========================================================================================
    // ===========================================================================================

    public function newtripAction() {
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('trip');

        $obj = new Trip;
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

        if ($post->placename && $post->id_place) {
            $obj->settripname($post->placename);
            $form->setDataForm($obj);
            $element = new Ui_Element_Hidden('id_place');
            $element->setValue($post->id_place);
            $form->addElement($element);
        }

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
        $br = new Browser_Control();
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

        // add trip owner
        $tripuser = new TripUser();
        $tripuser->setid_usuario(Usuario::getIdUsuarioLogado());
        $tripuser->setstatus('o');
        $tripuser->setjoined_at(date('m/d/Y'));
        $users = $lObj->getTripUserLst();
        $users->addItem($tripuser);
        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        $params = '';
        if ($post->id_place) {
            $params = '/id_place/' . $post->id_place;
        }

        $br->setBrowserUrl(BASE_URL . 'trip/newtrip2/id/' . $lObj->getID() . $params);
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

        if ($post->id_place) {
            $element = new Ui_Element_Hidden('id_place');
            $element->setValue($post->id_place);
            $form->addElement($element);
        }

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
        $lObj = new Trip();
        $lObj->read($post->id_trip);

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
        //$lObj->setDataFromRequest($post);

        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        $params = '';
        if ($post->id_place) {
            $params = '/id_place/' . $post->id_place;
        }
        $br->setBrowserUrl(BASE_URL . 'trip/newtrip3/id/' . $lObj->getID() . $params);
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


        $obj = new Trip;
        $obj->read($post->id);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id);
        $form->addElement($element);

        if ($post->id_place) {
            $element = new Ui_Element_Hidden('id_place');
            $element->setValue($post->id_place);
            $form->addElement($element);
        }

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

        $view->assign('tripname', $obj->gettripname());
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
        $lObj = new Trip();
        $lObj->read($post->id_trip);

        // save the trip types

        if (is_array($list)) {

            $destLst = $lObj->getTripUserLst();

            foreach ($list as $id_usuario) { //for each item selected by the trip
                $n = new TripUser();
                $n->setid_trip($lObj->getID());
                $n->setid_usuario($id_usuario);
                $n->setstatus('i');
                $destLst->addItem($n);
            }
        }
        // }
        // for a while I'm not saving the name/ e-mail
        //$lObj->setDataFromRequest($post);
        try {
            $lObj->save();
            $lObj->setInstance('newTrip');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        $params = '';
        if ($post->id_place) {
            $br->setBrowserUrl(BASE_URL . 'trip/newtrip5/id_trip/' . $lObj->getID() . '/id_place/' . $post->id_place);
        } else {
            $br->setBrowserUrl(BASE_URL . 'trip/newtrip4/id/' . $lObj->getID());
        }

        $br->send();
    }

    public function doSearchPlaces($id_trip, $q, $ajax = true) {
        $br = new Browser_Control();
        $view = Zend_Registry::get('view');

        // ------- PLACES   - --------------
        $PlacesList = new Place();
        $PlacesList->where('place.name', $q, 'like', 'or', 'q');
        $PlacesList->where('place.country', $q, 'like', 'or', 'q');
        $PlacesList->where('searchquery', $q, 'like', 'or', 'q');
//        $PlacesList->where('description', $q, 'like', 'or', 'q');
        $PlacesList->readLst();

        $items = $PlacesList->getItens();
        $view->assign('placeLst', $items);
        $view->assign('id_trip', $id_trip);

        $dreamplacesempty = true;
        foreach ($items as $item) {
            if ($item->getFavorite() != '') {
                $dreamplacesempty = false;
                break;
            }
        }
        $view->assign('dreamplacesempty', $dreamplacesempty);

        // Dreamplaces view
        $view->assign('onlyDreamplaces', True);
        if ($q == '') {
            $view->assign('nothingfoundmsg', "You didn't add any places to your dreamboard yet...");
        } else {
            $view->assign('nothingfoundmsg', "No places found on your dreamboard with the term '$q'...");
        }

        $dreamboard = $view->fetch('Trip/app/searchPlaces.tpl');
        if ($ajax) {
            if ($dreamplacesempty) {
                $br->setAttrib('dreamboardtabcontrol', 'class', '');
                $br->setAttrib('exploretabcontrol', 'class', 'active');
                $br->setAttrib('dreamboardtab', 'class', 'tab-pane ');
                $br->setAttrib('exploretab', 'class', 'tab-pane active');
            }

            $br->setHtml('dreamboarddiv', $dreamboard);
        }

        // Explore view
        $view->assign('onlyDreamplaces', False);
        $view->assign('nothingfoundmsg', "No places found with the term '$q'... try again!");

        $places = $view->fetch('Trip/app/searchPlaces.tpl');
        if ($ajax) {
            $br->setHtml('placesdiv', $places);
            $br->send();
        } else {
            return array('dreamboard' => $dreamboard, 'places' => $places);
        }
    }

    public function newtrip4Action() {

        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewtrip');
        $form->setAction('Trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $obj = new Trip;
        $obj->read($post->id);
        $obj->setInstance('newTrip');

        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id);
        $form->addElement($element);

        $element = new Ui_Element_Text('search2');
        $element->setPlaceholder("Search for places and click on the place that you're going to");
        $element->setAttrib('hotkeys', 'enter, btnSearch, click');
        $element->setValue($q);
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSearch');
        $button->setDisplay('Search', '');
//        $button->setType('success');
        $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnFeelingLucky');
        $button->setDisplay('Feeling lucky', '');
//        $button->setType('success');
        $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $form->setDataSession();

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');
        $tabs = $this->doSearchPlaces($post->id, $post->q, false);
        $view->assign('dreamboarddiv', $tabs['dreamboard']);
        $view->assign('placesdiv', $tabs['places']);

        $view->assign('tripname', $obj->gettripname());
        $view->assign('id_trip', $post->id);

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip4.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnsearchclickAction() {
        $post = Zend_Registry::get('post');
        $this->doSearchPlaces($post->id_trip, $post->search2);
    }

    public function newtripcityclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $url = BASE_URL . 'trip/newtrip5/id_trip/' . $post->id_trip . "/id_place/" . $post->id_place;
        $br->setBrowserUrl($url);
        $br->send();
    }

    public function newtrip5Action() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewTripPlace');
        $form->setAction('trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $trip = new Trip;
        $trip->read($post->id_trip);

        $place = new Place;
        $place->read($post->id_place);

        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id_trip);
        $form->addElement($element);

        $element = new Ui_Element_Hidden('id_place');
        $element->setValue($post->id_place);
        $form->addElement($element);

        $element = new Ui_Element_Date('startdate', 'ARRIVAL');
        $element->setRequired();
        $element->setAlternativeField('enddate');
        $form->addElement($element);

        $element = new Ui_Element_Date('enddate', 'DEPARTURE');
        $element->setRequired();
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnNext5');
        $button->setDisplay('Next');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewTripPlace');

        $view = Zend_Registry::get('view');

        $view->assign('tripname', $trip->gettripname());
        $view->assign('placename', $place->getname());
        $view->assign('formatted_address', $place->getformatted_address());
        $view->assign('placephotopath', $place->getPhotoPath());


        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip5.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnnext5clickAction() {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        // ----------------------

        $form = Session_Control::getDataSession('formNewTripPlace');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
            // Date must be in the future
        } else if (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($post->startdate), '<', date('Y-m-d'))) {
            $br->setAlert("Warning!", "Start date cannot be in the past!");
            $br->send();
            exit;
        } else if (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($post->enddate), '<', date('Y-m-d'))) {
            $br->setAlert("Warning!", "End date cannot be in the past!");
            $br->send();
            exit;
            // startDate must be less than end date
        } else if (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($post->enddate), '<', DataHora::inverteDataIngles($post->startdate))) {
            $br->setAlert("Warning!", "End date cannot de before the start date!");
            $br->send();
            exit;
        }


        $tripplace = new Tripplace();
        $tripplace->setDataFromRequest1($post);

        $trip = new Trip();
        $trip->read($post->id_trip);
        if (($trip->getstartdate() == NULL) || (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($tripplace->getstartdate()), '<', DataHora::inverteDataIngles($trip->getstartdate())))) {
            $trip->setstartdate($tripplace->getstartdate());
        }
        if (($trip->getenddate() == NULL) || (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($tripplace->getenddate()), '>', DataHora::inverteDataIngles($trip->getenddate())))) {
            $trip->setenddate($tripplace->getenddate());
        }
        try {
            $tripplace->save();
            $trip->save();
            $tripplace->setInstance('newTripPlace');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        $br->setBrowserUrl(BASE_URL . 'trip/newtrip6/id_trip/' . $post->id_trip . '/id_tripplace/' . $tripplace->getID());
        $br->send();
    }

    public function newtrip6Action() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formNewTripPlace');
        $form->setAction('trip');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $trip = new Trip;
        $trip->read($post->id_trip);

        $tripplace = new Tripplace();
        $tripplace->read($post->id_tripplace);

        $place = new Place;
        $place->read($tripplace->getid_place());


        $element = new Ui_Element_Hidden('id_trip');
        $element->setValue($post->id_trip);
        $form->addElement($element);

        $element = new Ui_Element_Hidden('id_tripplace');
        $element->setValue($post->id_tripplace);
        $form->addElement($element);

        $element = new Ui_Element_Text('accomodation');
        $element->setAttrib('maxlength', '100');
        $element->setAttrib('placeholder', 'Know where are you staying?');
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('accomodationnotsure');
        $element->setAttrib('label', 'Not sure yet!');
        $element->setValue("N");
        $element->setCheckedValue("Y");
        $element->setUncheckedValue("N");
        $form->addElement($element);

        $element = new Ui_Element_Text('budget');
        $element->setAttrib('maxlength', '100');
        $element->setAttrib('placeholder', 'What will be the costs?');
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('budgetnotsure');
        $element->setAttrib('label', 'Not sure yet!');
        $element->setValue("N");
        $element->setCheckedValue("Y");
        $element->setUncheckedValue("N");
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnFinish');
        $button->setDisplay('Finish');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnAddMorePlaces');
        $button->setDisplay('Add more places');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('class', 'btn btn-success  btn-cons m-t-10');
        $form->addElement($button);

        $form->setDataSession('formNewtripCity');

        $view = Zend_Registry::get('view');

        $view->assign('tripname', $trip->gettripname());
        $view->assign('placename', $place->getname());
        $view->assign('formatted_address', $place->getformatted_address());
        $view->assign('placephotopath', $place->getPhotoPath());


        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip6.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    public function btnfinishclickAction($addMorePlaces = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
        $br = new Browser_Control();

        $form = Session_Control::getDataSession('formNewTripPlace');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        // ----------------------
        /* @var $trip Trip */
        $tripplace = new Tripplace();
        $tripplace->read($post->id_tripplace);
        $tripplace->setDataFromRequest2($post);

        try {
            $tripplace->save();
            $tripplace->setInstance('newTripPlace');
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = '';

        if ($addMorePlaces) {
            $br->setBrowserUrl(BASE_URL . 'trip/newtrip4/id/' . $post->id_trip);
        } else {
            $br->setBrowserUrl(BASE_URL . 'trip/newtripend/id/' . $post->id_trip . '/id_tripplace/' . $tripplace->getID());
        }
        $br->send();
    }

    public function btnaddmoreplacesclickAction() {

        $this->btnfinishclickAction(true);
    }

    public function newtripendAction() {

        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');


        $trip = new Trip;
        $trip->read($post->id);

        $tripplace = new Tripplace();
        $tripplace->read($post->id_tripplace);

        $place = new Place;
        $place->read($tripplace->getid_place());
        foreach ($trip->TripUserLst as $user) {
            $friends[] = array(
                'id' => $user->id_usuario,
                'username' => $user->username,
                'photourl' => Usuario::makephotoPath($user->id_usuario, $user->photo));
        }

        $view = Zend_Registry::get('view');

        $view->assign('id_trip', $post->id);
        $view->assign('tripname', $trip->gettripname());
        $view->assign('placename', $place->getname());
        $view->assign('startdate', date_format(date_create($trip->getstartdate()), 'F d, Y'));
        $view->assign('enddate', date_format(date_create($trip->getenddate()), 'F d, Y'));
        $view->assign('friends', $friends);
        //$view->assign('formatted_address', $place->getformatted_address());
        $view->assign('placephotopath', $place->getPhotoPath());
        $view->assign('recommendationUrl', urlencode(HTTP_HOST . BASE_URL . 'trip/detail/id/' . $post->id_trip ));

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $view->fetch('Trip/app/newtripend.tpl');
        $view->assign('body', $html);
        $view->output('index_clear.tpl');
    }

    public function btnsendmsg4clickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');


        if ($post->message4 == '') {
            $br->executeAjaxRequest('conversation4', 'load', '');
            $br->send();
            die();
        }
        $msg = new Chatmsg();
        $msg->setMessage($post->message4);
        $msg->setid_usuario(Usuario::getIdUsuarioLogado());
        $msg->setid_trip($post->id_trip);

        try {
            $msg->save();
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $br->addFieldValue('message4', '');
        $br->setDataForm();
        $br->executeAjaxRequest('conversation4', 'load', '');
        $br->send();
    }

    function conversation4loadAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $msg = new Chatmsg();
        $msg->where('id_trip', $post->id_trip);
        $msg->sortOrder('sentdate', 'asc');
        $msg->readLst();
        $br->setHtml('messages4', $msg->getFullConversation());
        $br->setCommand("$('#messages4').scrollTop($('#messages4')[0].scrollHeight);");
        $br->send();
    }

}
