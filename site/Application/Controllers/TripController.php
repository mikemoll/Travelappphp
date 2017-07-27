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
        $view->assign('TripActivityLst', $Trip->getTripActivityLst()->getItens());
        $view->assign('TripplaceLst', $Trip->getTripplaceLst()->getItens());

        $Trip->setInstance($this->ItemEditInstanceName);

        $form = new Ui_Form();
        $form->setAction('Trip');
        $form->setName('formTripDetail');

        // ====== CREATE A TAB COMPONENT ========================
        $mainTab = new Ui_Element_TabMain('tripTabs');

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabOverview');
        $tab->setTitle('Overview');
        $tab->setTemplate('Trip/app/detail/tabs/overview.tpl');


        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabItinerary');
        $tab->setTitle('Itinerary');
        $tab->setTemplate('Trip/app/detail/tabs/itinerary.tpl');

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

        $button = new Ui_Element_DataTables_Button('btnEditTask', 'Edit');
        $button->setImg('edit');
        $button->setVisible('TRIP_TASK', 'editar');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelTask', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setVisible('TRIP_TASK', 'excluir');
        $grid->addButton($button);
        // ---- Columns -----
        $column = new Ui_Element_DataTables_Column_Text('Task', 'description');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Type', 'typedesc');
        $column->setWidth('1');
        $grid->addColumn($column);
//
        $column = new Ui_Element_DataTables_Column_Text('Due Date', 'duedate');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Resp', 'responsible', 'center');
        $column->setWidth('3');
        $grid->addColumn($column);

        // ---- add grid to the Form ----
        $tab->addElement($grid);



        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabPacking');
        $tab->setTitle('Packing List');
        $tab->setTemplate('Trip/app/detail/tabs/packing.tpl');

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

        $button = new Ui_Element_DataTables_Button('btnDelExpense', 'Delete');
        $button->setImg('trash-o');
        $button->setAttrib('msg', "Are you sure you want to delete this?");
        $button->setVisible('TRIP_BUDGET', 'excluir');
        $grid->addButton($button);
        // ---- Columns -----
        $column = new Ui_Element_DataTables_Column_Text('Description', 'description');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Amout', 'Amount');
        $column->setWidth('1');
        $grid->addColumn($column);

        // ---- add grid to the Form ----
        $tab->addElement($grid);

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabContact');
        $tab->setTitle('Contact');
        $tab->setTemplate('Trip/app/detail/tabs/contact.tpl');

        // -- Add tab to the main tab ---
        $mainTab->addTab($tab);

        // ====== NEW TAB ========================
        $tab = new Ui_Element_Tab('tabChat');
        $tab->setTitle('<span>Trip Chat <span title="3 new comments" class="label label-warning">3</span></span>');
        $tab->setTemplate('Trip/app/detail/tabs/chat.tpl');

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

    public function btnedittaskclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view'); /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Textarea('description', "Description");
        $element->setAttrib('rows', 2);
        $element->setAttrib('maxlength', 150);
        $form->addElement($element);


        $element = new Ui_Element_Date('duedate', "Due Date");
        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Select('type', 'Task Type');
        $element->addMultiOption('', '');
        $element->addMultiOption(1, 'Grau 1');
        $element->addMultiOption(2, 'Grau 2');
        $element->addMultiOption(3, 'Grau 3');
        $element->addMultiOption(4, 'Grau 4');
//        $element->setMultiSelect();
        $form->addElement($element);

        $element = new Ui_Element_Select('id_responsable', 'Responsable');
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
//        $br->setCommand('$("#duedate").datepicker()');
//        $br->setHtml('formNewTask', $form->displayTpl($view, 'Trip/app/detail/edit/task.tpl'));
//        $br->setScrollTo($this->ItemEditFormName);

        $br->setCommand('$(".datepicker").datepicker();');
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

    public function expenselistAction() {
        /* @var $lObj Trip */
        $lObj = Trip::getInstance($this->ItemEditInstanceName);
        Grid_ControlDataTables::setDataGrid($lObj->getTripexpenseLst(), false, false);
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
        Grid_ControlDataTables::deleteDataGrid('Tripexpense', '', 'gridExpense', $br);

        $br->setMsgAlert('Deleted', 'Item deleted!');
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
                $n->setid_usuario($id_usuario);
                $n->setstatus('i');
                $destLst->addItem($n);
                //        } else {
                //            $tt->setState(cUPDATE); //else update it
                //        }
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

    public function newtrip4Action() {

        $view = Zend_Registry::get('view');
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

        // $button = new Ui_Element_Btn('btnNext4');
        // $button->setDisplay('Next');
        // $button->setAttrib('sendFormFields', '1');
        // $button->setAttrib('validaObrig', '1');
        // $button->setAttrib('class', 'btn btn-primary  btn-cons m-t-10');
        // $form->addElement($button);

        $form->setDataSession('formNewtrip');

        $view = Zend_Registry::get('view');

        $view->assign('tripname', $obj->gettripname());
        $view->assign('id_trip', $post->id);

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('TituloPagina', 'New trip');
        $html = $form->displayTpl($view, 'Trip/app/newtrip4.tpl');
        $view->assign('body', $html);
        $view->output('index.tpl');
    }

    function defaultplacesloadAction() {
        $br = new Browser_Control();
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $q = $post->search2;

        // ------- PLACES   - --------------
        $PlacesList = new Place();
        $PlacesList->where('place.name', $q, 'like', 'or', 'q');
        $PlacesList->where('place.country', $q, 'like', 'or', 'q');
        $PlacesList->where('searchquery', $q, 'like', 'or', 'q');
//        $PlacesList->where('description', $q, 'like', 'or', 'q');
        $PlacesList->readLst();

        $items = $PlacesList->getItens();
        $view->assign('placeLst', $items);
        $view->assign('id_trip', $post->id_trip);

        // Dreamplaces view
        $view->assign('onlyDreamplaces', True);
        if ($q == '') {
            $view->assign('nothingfoundmsg', "You didn't add any places to your dreamboard yet...");
        } else {
            $view->assign('nothingfoundmsg', "No places found on your dreamboard with the term '$q'...");
        }

        $br->setHtml('dreamboarddiv', $view->fetch('Trip/app/searchPlaces.tpl'));

        // Explore view
        $view->assign('onlyDreamplaces', False);
        $view->assign('nothingfoundmsg', "No places found with the term '$q'... try again!");

        $br->setHtml('placesdiv', $view->fetch('Trip/app/searchPlaces.tpl'));

        $br->send();
    }

    public function btnsearchclickAction() {
        $this->defaultplacesloadAction();
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
        $br = new Browser_Control();
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
            $br->setBrowserUrl(BASE_URL . 'trip/dashboard');
        }
        $br->send();
    }

    public function btnaddmoreplacesclickAction() {

        $this->btnfinishclickAction(true);
    }

}
