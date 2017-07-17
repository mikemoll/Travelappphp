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
        $type = $post->type;


        $view->assign('title1', 'Tumbleweed');
        $view->assign('title2', 'go everywhere');

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

        // ------- PLACES   - --------------
        $ActivityLst = new Place();
        $ActivityLst->where('place.name', $q, 'like', 'or', 'q');
        $ActivityLst->where('place.country', $q, 'like', 'or', 'q');
        $ActivityLst->where('searchquery', $q, 'like', 'or', 'q');
//        $ActivityLst->where('description', $q, 'like', 'or', 'q');
        $ActivityLst->readLst();
        $view->assign('placeLst', $ActivityLst->getItens());
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

    public function galeryitemclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        if ($post->gplace_id) {
            $places = Db_Table::getSession('places');
            foreach ($places as $value) {
                if ($value['place_id'] == $post->gplace_id) {
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
            } else
            if ($post->id_place) {
                $Item = new Place();
                $id = $post->id_place;
                $idName = 'id_place';
            }

            $Item->read($id);

            if ($Item->getActivityName() != '') {
                $br->setHtml('itemTitle', $Item->getActivityName());
            } elseif ($Item->getName() != '') {
                $br->setHtml('itemTitle', $Item->getName());
            } else {
                $br->setHtml('itemTitle', $Item->getEventName());
            }
            $br->setHtml('itemCountry', $Item->getCountry());
            if ($Item->getFormatted_Address() != '') {
                $br->setHtml('itemFormattedAddress', $Item->getFormatted_Address());
            } else {
                $br->setHtml('itemFormattedAddress', $Item->getCountry());
            }
            $br->setHtml('itemRating', $Item->getRatingHtml());
            $br->setHtml('itemDescription', $Item->getDescription());
            if ($Item->getPrice() != '') {
                $br->setShow('itemPriceLine');
                $br->setHtmlByClass('itemPrice', '$' . $Item->getPrice());
            } else {
                $br->setHtmlByClass('itemPrice', '');
                $br->setHide('itemPriceLine');
            }
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

        $br->setAttrib('btnAddToTrip', 'params', 'id_trip='.$post->id_trip.'&id_place='.$id);

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
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $dreamLts = new Dreamboard;
        $dreamLts->where('dreamboard.id_usuario', Usuario::getIdUsuarioLogado());
        $dreamLts->where('dreamboard.id_activity', $post->id_activity, '=', 'or', 'id');
        $dreamLts->where('dreamboard.id_event', $post->id_event, '=', 'or', 'id');
        $dreamLts->where('dreamboard.id_place', $post->id_place, '=', 'or', 'id');
        $dreamLts->readLst();
        if ($dreamLts->countItens() == 0) {
            $dream = new Dreamboard();
            $dream->setID_Usuario(Usuario::getIdUsuarioLogado());
            $dream->setID_activity($post->id_activity);
            $dream->setID_event($post->id_event);
            $dream->setid_place($post->id_place);
//            print'<pre>';die(print_r( $dream ));
            $dream->save();
            $view->assign('cardName', $post->cardname);
            $br->setAlert('Great Choice ' . Usuario::getNomeUsuarioLogado(), $view->fetch('Explore/msg_add_dream.tpl'));
        } else {
            $view->assign('cardName', $post->cardname);
            $br->setAlert('Great Choice ' . Usuario::getNomeUsuarioLogado(), $view->fetch('Explore/msg_add_dream.tpl'));
//            $br->setMsgAlert('Done!', 'This place was already saved!');
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
        $dreamLts->where('dreamboard.id_place', $post->id_place, '=', 'or', 'id');
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
