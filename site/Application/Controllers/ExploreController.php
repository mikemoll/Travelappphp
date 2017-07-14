<?php

include_once 'AbstractController.php';

/**
 *  Search and Explore
 * 
 * @author Leonardo Danieli <leonardo.danieli@gmail.com>
 * @version 1.0
 * 
 */
class ExploreController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formExplore';
        $this->Action = 'Explore';
        $this->TituloLista = "Explore";
        $this->TituloEdicao = "Explore";
        $this->ItemEditInstanceName = 'ExploreEdit';
        $this->ItemEditFormName = 'formExploreItemEdit';
        $this->Model = 'Explore';
        $this->IdWindowEdit = 'EditExplore';
        $this->TplExplore = 'Explore/index.tpl';
        $this->TplEdit = 'Explore/edit.tpl';
    }

    public function indexAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $q = $post->q;
        $type = $post->type != '' ? $post->type : '(regions)';



        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);



        $element = new Ui_Element_Text('search');
        $element->setPlaceholder('Search for places, activities or events');
        $element->setAttrib('hotkeys', 'enter, btnSearch, click');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSearch');
        $button->setDisplay('', 'search');
//        $button->setType('success');
        $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $form->setDataSession();

        // ---- GOOGLE ----------
//        $ret = $this->callAPI('GET', array('query' => $q));
//        $ret = $this->callAPI(array('query' => $q, 'type' => 'airport'));
        $ret = $this->callAPI(array('query' => $q, 'type' => $type));
//        print'<pre>';die(print_r( $ret ));
        foreach ($ret->results as $value) {
            $place['place_id'] = $value->place_id;
            $place['formatted_address'] = $value->formatted_address;
            $place['name'] = $value->name;
            $place['rating'] = $value->rating;
            $place['types'] = $value->types;
            foreach ($value->photos as $photo) {
//                $photo2['src'] = '<a href="https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference=' . $photo->photo_reference . '&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0">photo</a>';
                $photo2['src'] = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference=' . $photo->photo_reference . '&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0';
                $place['photos'][] = $photo2;
            }
            $places[] = $place;
            $place = array();
        }
//        print'<pre>';die(print_r( $places ));
//        dr( $places );
        $view->assign('places', $places);
//        $ActivityLst = new Activity();
//        $ActivityLst->where('activityname', $q, 'like', 'or', 'q');
////        $ActivityLst->where('location', $q, 'like', 'or', 'q');
//        $ActivityLst->where('description', $q, 'like', 'or', 'q');
//        $ActivityLst->readLst();
//
//        for ($i = 0; $i < $ActivityLst->countItens(); $i++) {
//            $Activity = $ActivityLst->getItem($i);
//
//            $view->assign('item', $Activity);
//            $activityHtml .= $view->fetch('Explore/activityCard.tpl');
//        }
        // ---- Activities ----------
        $ActivityLst = new Activity();
//        $ActivityLst->where('activityname', $q, 'like', 'or', 'q');
////        $ActivityLst->where('location', $q, 'like', 'or', 'q');
//        $ActivityLst->where('description', $q, 'like', 'or', 'q');
        $ActivityLst->readLst();
        $view->assign('activityLst', $ActivityLst->getItens());


        // ---- Events ----------
        $ActivityLst = new Event();
//        $ActivityLst->where('eventname', $q, 'like', 'or', 'q');
////        $ActivityLst->where('location', $q, 'like', 'or', 'q');
//        $ActivityLst->where('description', $q, 'like', 'or', 'q');
        $ActivityLst->readLst();
        $view->assign('eventLst', $ActivityLst->getItens());



        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
//        $view->assign('body', $form->displayTpl($view, 'Explore/index.tpl'));
        $view->assign('body', $form->displayTpl($view, 'Explore/index.tpl'));
//        $view->assign('body', $view->fetch('Explore/index.tpl'));
        $view->output('index.tpl');
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

    public function galeryitemclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        if ($post->id_activity) {
            $Item = new Activity();
            $id = $post->id_activity;
            $idName = 'id_activity';
        } else
        if ($post->id_event) {
            $Item = new Event();
            $id = $post->id_event;
            $idName = 'id_event';
        }
        $Item->read($id);

        if ($Item->getActivityName() == '') {
            $br->setHtml('itemTitle', $Item->getEventName());
        } else {
            $br->setHtml('itemTitle', $Item->getActivityName());
        }
        $br->setHtml('itemDescription', $Item->getDescription());
        $br->setHtmlByClass('itemPrice', '$' . $Item->getPrice());
        $br->setAttrib('btnAddDream', 'params', $idName . '=' . $Item->getID());

        $lP = $Item->getPicsLst();
        foreach ($lP as $value) {
//            $html .= '<img class="slide" src="' . $value['src'] . '">';
            $html .= '<div class="slide" data-image="' . $value['src'] . '" ></div>';
            break;
        }
        $br->setHtmlByClass('itemGalery', $html);
        $br->setCommand("
                        $('.item-slideshow > div').each(function () {
                            var img = $(this).data('image');
                            $(this).css({
                                'background-image': 'url(' + img + ')',
                                'background-size': 'cover'
                            })
                        });");
        $br->setAttrib('itemDetailGalery', 'class', 'item-slideshow full-height itemGalery');
//        $br->setCommand('
//            alert("sdav" );
//                         $("#itemDetailGalery").owlCarousel({
//        items: 1,
//        nav: true,
//        navText: [' . "'" . '<i class="fa fa-chevron-left"></i>' . "'" . ', ' . "'" . '<i class="fa fa-chevron-right"></i>' . "'" . '],
//        dots: true
//    });');



        $br->send();
    }

    public function btnadddreamclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setClass("itemDetails", "dialog item-details dialog");
        $br->setMsgAlert('Done!', 'Your dream is saved!');
        $br->send();
    }

    public function btnsearchclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . 'explore/index/q/' . $post->search);
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

        $menu = new Ui_Element_MenuItem('events', 'Explores', HTTP_REFERER . 'event', '', '');
//        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu = new Ui_Element_MenuItem('Profile', 'Profile', HTTP_REFERER . 'usuario/profileedit', '', '');
        $mainMenu->addMenuItem($menu);
//
//        $menu2 = new Ui_Element_MenuItem('events', 'Explores2', HTTP_REFERER . 'events', '', 'calendar');
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


            $menu2 = new Ui_Element_MenuItem('Explore', 'Explore', HTTP_REFERER . 'event', '', 'event');
//        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
            $menu->addSubMenu($menu2);

            $menu2 = new Ui_Element_MenuItem('Exploretype', 'Explore Types', HTTP_REFERER . 'eventtype', '', '');
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
