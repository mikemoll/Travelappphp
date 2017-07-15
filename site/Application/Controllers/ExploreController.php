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



        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);
        $form->setAttrib('onsubmit', 'return false;');



        $element = new Ui_Element_Text('search2');
        $element->setPlaceholder('Search for places, activities or events');
        $element->setAttrib('hotkeys', 'enter, btnSearch, click');
        $element->setValue($q);
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSearch');
        $button->setDisplay('', 'search');
//        $button->setType('success');
        $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
        $button->setAttrib('onclick', 'return false;');
        $form->addElement($button);

        $form->setDataSession();

        // ---- GOOGLE ----------
        $type = $post->type != '' ? $post->type : '(regions)';

        if ($q != '') {
            $ret = $this->callAPI(array('query' => $q, 'type' => $type));  // commneted to stop making requests
//        $ret->results = array();
//        print'<pre>';die(print_r( $ret ));
            foreach ($ret->results as $value) {
                $place['place_id'] = $value->place_id;
                $place['formatted_address'] = $value->formatted_address;
                $place['name'] = $value->name;
                $place['rating'] = $value->rating;
                $place['types'] = $value->types;
                foreach ($value->photos as $photo) {
                    $photo2['src'] = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=500&photoreference=' . $photo->photo_reference . '&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0';
                    $place['photos'][] = $photo2;
                }
                $places[] = $place;
                $place = array();
            }
            if (count($places) == 0) {
                $place['place_id'] = '21212';
                $place['formatted_address'] = 'Paris, France';
                $place['name'] = 'Paris';
                $place['rating'] = 4.5;
//            $place['types'] = $value->types;
                $photo2['src'] = 'http://www.ladyhattan.com/wp-content/uploads/2014/03/Eiffel-Tower-Paris-France.jpg';
                $place['photos'][] = $photo2;
                $places[] = $place;
                $place = array();
            }
//        print'<pre>';
//        die(print_r($places));
//        dr($places);
            $view->assign('places', $places);
            Db_Table::setSession('places', $places);
        }
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



//        $view->assign('url', $this->Action);
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

        if ($post->place_id) {
            $places = Db_Table::getSession('places');
            foreach ($places as $value) {
                if ($value['place_id'] == $post->place_id) {
                    break;
                }
            }

            $br->setHtml('itemTitle', $value['name']);
            $br->setHtml('itemCountry', $value['formatted_address']);
            $br->setHtml('itemDescription', '');
            $br->setHtmlByClass('itemPrice', '');
            $br->setAttrib('btnAddDream', 'params', 'place_id' . '=' . $value['place_id']);
            $itemGaleryImage .= '<div class="slide" data-image="' . $value['photos'][0]['src'] . '" ></div>';
        } else {


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
            $br->setHtml('itemCountry', $Item->getCountry());
            $br->setHtml('itemDescription', $Item->getDescription());
            $br->setHtmlByClass('itemPrice', '$' . $Item->getPrice());
            $br->setAttrib('btnAddDream', 'params', $idName . '=' . $Item->getID());

            $lP = $Item->getPicsLst();
            foreach ($lP as $value) {
//            $html .= '<img class="slide" src="' . $value['src'] . '">';
                $itemGaleryImage .= '<div class="slide" data-image="' . $value['src'] . '" ></div>';
                break;
            }
        }
        $br->setHtmlByClass('itemGalery', $itemGaleryImage);
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

        $dreamLts = new Dreamboard;
        $dreamLts->where('dreamboard.id_usuario', Usuario::getIdUsuarioLogado());
        $dreamLts->where('dreamboard.id_activity', $post->id_activity, '=', 'or', 'id');
        $dreamLts->where('dreamboard.id_event', $post->id_event, '=', 'or', 'id');
        $dreamLts->where('dreamboard.place_id', $post->place_id, '=', 'or', 'id');
        $dreamLts->readLst();
        if ($dreamLts->countItens() == 0) {
            $dream = new Dreamboard();
            $dream->setID_Usuario(Usuario::getIdUsuarioLogado());
            $dream->setID_activity($post->id_activity);
            $dream->setID_event($post->id_event);
            $dream->setplace_id($post->place_id);
            $dream->save();
            $br->setMsgAlert('Done!', 'Your dream is saved!');
        } else {

            $br->setMsgAlert('Done!', 'This place was already saved!');
        }

        $br->setClass("itemDetails", "dialog item-details dialog");
        $br->send();
    }

    public function btnremovedreamclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $dreamLts = new Dreamboard;
        $dreamLts->where('dreamboard.id_usuario', Usuario::getIdUsuarioLogado());
        $dreamLts->where('dreamboard.id_activity', $post->id_activity, '=', 'or', 'id');
        $dreamLts->where('dreamboard.id_event', $post->id_event, '=', 'or', 'id');
        $dreamLts->where('dreamboard.place_id', $post->place_id, '=', 'or', 'id');
        $dreamLts->readLst();
        if ($dreamLts->countItens() > 0) {
            $dreamLts->getItem(0)->setDeleted()->save();
            $br->setMsgAlert('Removed!', 'Your dream was removed!');
        }

        $br->setClass("itemDetails", "dialog item-details dialog");
        $br->send();
    }

    public function btnsearchclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(HTTP_HOST . BASE_URL . 'explore/index/q/' . $post->search2);
        $br->send();
    }

    public function btnaddtotripclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(HTTP_HOST . BASE_URL . 'trip/newtrip');
        $br->send();
    }

    public function loadAction() {
        
    }

}
