<?php

include_once 'AbstractController.php';

/**
 *  Search and Dreamboard
 * 
 * @author Leonardo Danieli <leonardo.danieli@gmail.com>
 * @version 1.0
 * 
 */
class DreamboardController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formDreamboard';
        $this->Action = 'Dreamboard';
        $this->TituloLista = "Dreamboard";
        $this->TituloEdicao = "Dreamboard";
        $this->ItemEditInstanceName = 'DreamboardEdit';
        $this->ItemEditFormName = 'formDreamboardItemEdit';
        $this->Model = 'Dreamboard';
        $this->IdWindowEdit = 'EditDreamboard';
        $this->TplDreamboard = 'Dreamboard/index.tpl';
        $this->TplEdit = 'Dreamboard/edit.tpl';
    }

    public function btnbookmarkitclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setMsgAlert('Done!', 'Your dream is saved!');
        $br->send();
    }

    public function loadAction() {

    }

    public static function getMenu() {

        $mainMenu = new Ui_Element_MainMenu('menuPrincipal');
        $mainMenu->setParams('200');

        // =========== Menu  ==========
        // INDICADORES
        $menuItem = new Ui_Element_MenuItem('home', 'Dashboard', HTTP_REFERER . 'index', '', 'home');
        $mainMenu->addMenuItem($menuItem);


        $menu = new Ui_Element_MenuItem('trips', 'Trips', HTTP_REFERER . 'trip/dashboard', '', '', '10 new Trips');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('activities', 'Activities', HTTP_REFERER . 'activity', '', '');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('events', 'Dreamboards', HTTP_REFERER . 'event', '', '');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('Profile', 'Profile', HTTP_REFERER . 'usuario/profileedit', '', '');
        $mainMenu->addMenuItem($menu);
//
//        $menu2 = new Ui_Element_MenuItem('events', 'Dreamboards2', HTTP_REFERER . 'events', '', 'calendar');
////        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
//        $menu->addSubMenu($menu2);
        // -----------------------------------------------------------
        $menu = new Ui_Element_MenuItem('adm', 'Administration', HTTP_REFERER . '', '', 'settings');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        if (true) {

            $menu2 = new Ui_Element_MenuItem('activities', 'Activities', HTTP_REFERER . 'activity', '', '', '3 new Activities created!');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('Activitytype', 'Activity types', HTTP_REFERER . 'activitytype', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);


            $menu2 = new Ui_Element_MenuItem('Dreamboard', 'Dreamboard', HTTP_REFERER . 'event', '', 'event');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('Dreamboardtype', 'Dreamboard Types', HTTP_REFERER . 'eventtype', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('trips2', 'Trips', HTTP_REFERER . 'trip', '', '', '10 new Trips');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('Currency', 'Currencies', HTTP_REFERER . 'currency', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('Travelertype', 'Traveler types', HTTP_REFERER . 'travelertype', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('interest', 'Interest', HTTP_REFERER . 'interest', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);


            $menu2 = new Ui_Element_MenuItem('Triptype', 'Trip types', HTTP_REFERER . 'triptype', '', 'triptype');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            // -----------------------------------------------------------
        }
        $menu2 = new Ui_Element_MenuItem('Development', 'Development', '', '', '');
        $mainMenu->addMenuItem($menu2);
        if (true) {
            $menu3 = new Ui_Element_MenuItem('Users', 'Users', HTTP_REFERER . 'usuario/users', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu2->addSubMenu($menu3);

            $menu3 = new Ui_Element_MenuItem('groups', 'Groups of Users', HTTP_REFERER . 'usuario/grupos', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu2->addSubMenu($menu3);

            $menu3 = new Ui_Element_MenuItem('Proccess', 'Proccess', HTTP_REFERER . 'processo', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu2->addSubMenu($menu3);
            $menu3 = new Ui_Element_MenuItem('DatabaseUptates', 'Database Uptates', HTTP_REFERER . 'dbupdate', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu2->addSubMenu($menu3);

            $menu3 = new Ui_Element_MenuItem('ExampleForm', 'Form Exemple', HTTP_REFERER . 'exampleform/edit', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu2->addSubMenu($menu3);
        }
        return $mainMenu->render();
    }

}
