<?php

include_once 'AbstractController.php';

/**
 *  Classe de cria��o e controle da tela inicial do sistema
 * 
 * @author Leonardo Danieli <leonardo.danieli@gmail.com>
 * @version 1.0
 * 
 */
class IndexController extends AbstractController {

    public function init() {
        parent::init();
//        $view = Zend_Registry::get('view');
    }

    public function indexAction() {
        $view = Zend_Registry::get('view');
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;


//        // Page specific js -->


        $view->assign('titulo', "Index");
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $view->fetch('Index/index.tpl'));
        $view->output('index.tpl');
    }

    public static function getMenu() {

        $mainMenu = new Ui_Element_MainMenu('menuPrincipal');
        $mainMenu->setParams('200');

        // =========== Menu  ==========
        // INDICADORES
        $menuItem = new Ui_Element_MenuItem('home', 'Dashboard', HTTP_REFERER . 'index', '', 'home');
        $mainMenu->addMenuItem($menuItem);


        $menu = new Ui_Element_MenuItem('trips', 'Trips', HTTP_REFERER . 'trip', '', '', '10 new Trips');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('activities', 'Activities', HTTP_REFERER . 'activity', '', '');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('events', 'Events', HTTP_REFERER . 'event', '', '');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);
//
//        $menu2 = new Ui_Element_MenuItem('events', 'Events2', HTTP_REFERER . 'events', '', 'calendar');
////        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
//        $menu->addSubMenu($menu2);

        $menu = new Ui_Element_MenuItem('adm', 'Administration', HTTP_REFERER . '', '', 'settings');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);
//
        $menu2 = new Ui_Element_MenuItem('Users', 'Users', HTTP_REFERER . 'usuario/users', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);
//
        $menu2 = new Ui_Element_MenuItem('groups', 'Groups of Users', HTTP_REFERER . 'usuario/grupos', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);
        $menu2 = new Ui_Element_MenuItem('Proccess', 'Proccess', HTTP_REFERER . 'processo', '', '');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);
        $menu2 = new Ui_Element_MenuItem('DatabaseUptates', 'Database Uptates', HTTP_REFERER . 'dbupdate', '', 'database');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);

        $menu2 = new Ui_Element_MenuItem('Currency', 'Currencies', HTTP_REFERER . 'currency', '', 'currency');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);

        $menu2 = new Ui_Element_MenuItem('Travelertype', 'Traveler types', HTTP_REFERER . 'travelertype', '', 'travelertype');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);

        $menu2 = new Ui_Element_MenuItem('Activitytype', 'Activity types', HTTP_REFERER . 'activitytype', '', 'activitytype');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);

        return $mainMenu->render();
    }

    public function loadAction() {
        
    }

    public function sessionAction() {
//		echo date('h-i-s');
    }

}
