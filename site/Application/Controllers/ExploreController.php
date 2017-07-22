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
        $this->ItemEditFormName2 = 'formExploreItemEdit2';
        $this->Model = 'Explore';
        $this->IdWindowEdit = 'EditExplore';
        $this->TplExplore = 'Explore/index.tpl';
        $this->TplEdit = 'Explore/edit.tpl';
    }

    public function getLink($list, $not) {
        foreach ($list as $key => $value) {
            if ($key != $not) {
                $ret[] = "$key/$value";
            }
        }
        if ($ret != '') {
            return implode('/', $ret);
        }
        return '';
    }

    public function indexAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $q = $post->q;
//        $type = $post->type;

        $appliedFilters['q'] = $post->q;
        $appliedFilters['daterange'] = $post->daterange;
        list($etid, $etn) = explode('_', $post->eventtype);
        $appliedFilters['eventtype'] = $post->eventtype;
        list($atid, $atn) = explode('_', $post->activitytype);
        $appliedFilters['activitytype'] = $post->activitytype;
        $appliedFilters['rating'] = $post->rating;

//        print'<pre>';die(print_r( $appliedFilters ));

        foreach ($appliedFilters as $key => $value) {
            if ($value != '') {
                $appliedFilters2[$key] = $value;
            }
        }
        if (count($appliedFilters2) > 0) {
            foreach ($appliedFilters2 as $key => $value) {
                $links[$key] = $this->getLink($appliedFilters2, $key);
            }
            $links['base'] = $this->getLink($appliedFilters2, '');
            foreach ($appliedFilters2 as $key => $value) {
                if ($key == 'q') {
                    $names[$key] = $value;
                } elseif ($key == 'eventtype') {
                    $names[$key] = $etn;
                } elseif ($key == 'activitytype') {
                    $names[$key] = $atn;
                } elseif ($key == 'rating') {
                    $names[$key] = "$value stars";
                } else {
                    $names[$key] = $value;
                }
            }
        }
//        print'<pre>';
//        die(print_r($names));
//        print'<pre>';
//        die(print_r($appliedFilters2));
        $view->assign('appliedFilters', $appliedFilters2);
        $view->assign('links', $links);
        $view->assign('names', $names);



        $view->assign('title1', 'Tumbleweed');
        $view->assign('title2', 'go everywhere');

        // ================== form Search =====================
        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('search2');
        $element->setPlaceholder('Search for places, activities or events');
        $element->setAttrib('hotkeys', 'enter, btnSearch, click');
        $element->setValue($q);
        $form->addElement($element);

        list($StartDate, $EndDate) = explode('_', $post->daterange);
        $element = new Ui_Element_Date('startdate');
        $element->setAlternativeField('enddate');
        $element->setValue(DataHora::inverteDataIngles($StartDate));

        $form->addElement($element);

        $element = new Ui_Element_Date('enddate');
        $element->setValue(DataHora::inverteDataIngles($EndDate));
        $form->addElement($element);


        $view->assign('EventtypeLst', Db_Table::getOptionList2('id_eventtype', 'description', 'description', 'Eventtype', false));
        $view->assign('ActivitytypeLst', Db_Table::getOptionList2('id_activitytype', 'activitytypename', 'activitytypename', 'Activitytype', false));

        $view->assign('EventtypeSelected', $post->eventtype);
        $view->assign('ActivitytypeSelected', $post->activitytype);

        $view->assign('ratingSelected', $post->rating);

        $button = new Ui_Element_Btn('btnSearch');
        $button->setDisplay('Search', '');
        $button->setAttrib('class', 'btn btn-primary btn-animated from-left fa fa-search');
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

        $button = new Ui_Element_Btn('btnApplyDate');
        $button->setDisplay('Apply', '');
//        $button->setType('success');
        $button->setAttrib('params', $links['base']);
        $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $form->setDataSession();
        // ================== END form Search =====================
        // ---------------------- PLACES   - --------------
        // ---------------------- PLACES   - --------------
        // ---------------------- PLACES   - --------------
//        if ($post->activitytype == '' and $post->eventtype == '') {
        $ActivityLst = new Place();
        if ($q != '') {
            $ActivityLst->where('place.name', $q, 'like', 'or', 'q');
            $ActivityLst->where('place.country', $q, 'like', 'or', 'q');
            $ActivityLst->where('searchquery', $q, 'like', 'or', 'q');
        }
        if ($post->rating != '') {
            $ActivityLst->where('rating', $post->rating, '>=', 'or', 'q');
        }
        $ActivityLst->readLst();
//            print'<pre>';die(print_r( $ActivityLst ));
        $view->assign('placeLst', $ActivityLst->getItens());
//        }
        // -------------------- Activities ----------
        // -------------------- Activities ----------
        // -------------------- Activities ----------
        if ($post->eventtype == '' or $post->activitytype != '') {
            $ActivityLst = new Activity();
            if ($q != '') {
                $ActivityLst->where('activityname', $q, 'like', 'or', 'q');
            }
////        $ActivityLst->where('location', $q, 'like', 'or', 'q');
//        if ($post->rating != '') {
//            $ActivityLst->where('rating', $post->rating, '>', 'or', 'q');
//        }
            if ($post->activitytype != '') {
                $ActivityLst->where('activity.id_activitytype', $atid, '=', 'or', 'q');
            }
            $ActivityLst->readLst();
            $view->assign('activityLst', $ActivityLst->getItens());
        }


        // ---- Events ----------
        if ($post->activitytype == '' or $post->eventtype != '') {
            $ActivityLst = new Event();
            if ($q != '') {
                $ActivityLst->where('eventname', $q, 'like', 'or', 'q');
            }

            if ($StartDate != '') {
//                print'<pre>';die(print_r(  $post->startdate));
                $ActivityLst->where('start_at', $EndDate, '<=', 'and', 'date');
                $ActivityLst->where('end_at', $StartDate, '>=', 'and', 'date');
            }
////        $ActivityLst->where('location', $q, 'like', 'or', 'q');
//        if ($post->rating != '') {
//            $ActivityLst->where('rating', $post->rating, '>', 'or', 'q');
//        }
            if ($post->eventtype != '') {
                $ActivityLst->where('event.id_eventtype', $etid, '=', 'or', 'q');
            }
            $ActivityLst->readLst();
//            print'<pre>';die(print_r(  $ActivityLst   ));
            $view->assign('eventLst', $ActivityLst->getItens());
        }


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

        $br->setAttrib('btnAddToTrip', 'params', 'id_place=' . $id . '&id_trip=' . $post->id_trip);

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

    public function btnaddtotripclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $Item = new Place();
        $id = $post->id_place;

        $Item->read($id);

        // set titles
        $br->setHtml('itemTitleNewTrip', 'Add ' . $Item->getName() . ' to the trip:');
        // if ($Item->getFormatted_Address() != '') {
        //     $br->setHtml('itemFormattedAddressNewTrip', $Item->getFormatted_Address());
        // } else {
        //     $br->setHtml('itemFormattedAddressNewTrip', $Item->getCountry());
        // }
        // set trips list
        $TripLst = new Trip();
        $TripLst->join('tripuser', 'tripuser.id_trip = trip.id_trip', '');
        $TripLst->where('tripuser.id_usuario', Usuario::getIdUsuarioLogado());
        $TripLst->where('trip.enddate', date('Y-m-d'), '>=');
        $TripLst->readLst();
        $tripTable = '';
        for ($i = 0; $i < $TripLst->countItens(); $i++) {
            $trip = $TripLst->getItem($i);
            $tripTable .= '<tr><td class="font-montserrat all-caps fs-12 col-lg-6" name="btnaddtospecifictrip" event="click" params="id_place=' . $id . '&id_trip=' . $trip->getID() . '">' . $trip->gettripname() . '</td></tr>';
        }
        $br->setHtml('tripTable', $tripTable);



        // loading the place photo
        $lP = $Item->getPicsLst();
        foreach ($lP as $value) {
            $itemGaleryImage .= '<div class="slide" data-image="' . $value['src'] . '" ></div>';
            break;
        }
        $br->setHtmlByClass('itemGaleryNewTrip', $itemGaleryImage);
        $br->setCommand("
                        $('.item-slideshow > div').each(function () {
                            var img = $(this).data('image');
                            $(this).css({
                                'background-image': 'url(' + img + ')',
                                'background-size': 'cover'
                            })
                        });");
        $br->setAttrib('itemDetailGaleryNewtrip', 'class', 'item-slideshow full-height itemGaleryNewTrip');


        //dafine the add to new trip action
        $br->setAttrib('btnAddToNewTrip', 'params', 'id_place=' . $id . '&placename=' . $Item->getName());

        $br->setAttrib('itemDetails', 'class', 'dialog item-details');
        $br->setAttrib('addToTripDialog', 'class', 'dialog item-details dialog dialog--open');


        $br->send();
    }

    public function btnaddtonewtripclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(HTTP_HOST . BASE_URL . 'trip/newtrip/id_place/' . $post->id_place . '/placename/'.$post->placename);
        $br->send();
    }

    public function btnaddtospecifictripclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(HTTP_HOST . BASE_URL . 'trip/newtrip5/id_trip/' . $post->id_trip . '/id_place/' . $post->id_place);
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
        } else {
//            $br->setMsgAlert('Done!', 'This place was already saved!');
        }
        $view->assign('cardName', $post->cardname);
        $br->setAlert('Great Choice ' . Usuario::getNomeUsuarioLogado(), $view->fetch('Explore/msg_add_dream.tpl'));

        $br->setClass("itemDetails", "dialog item-details");
        $br->send();
    }

    public function btncloseaddtripclickAction() {
        $br = new Browser_Control();
        $br->setClass("addToTripDialog", "dialog item-details");
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

    public function btnapplydateclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setBrowserUrl(HTTP_HOST . BASE_URL . 'explore/index/daterange/' . DataHora::inverteDataIngles($post->startdate) . '_' . DataHora::inverteDataIngles($post->enddate));
        $br->send();
    }

    public function loadAction() {
        
    }

}
