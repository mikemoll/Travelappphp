<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		 system
 * @subpackage	system.application.models
 * @version		1.0
 */
class Place extends Db_Table {

    protected $_name = 'place';
    public $_primary = 'id_place';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->google_api_key = 'AIzaSyArhHndCQEIzE8i1zZzluSmZPnv-AGzrWI'; // from Mike
    }

    public function getPicsLst() {
        $pics[]['src'] = $this->getPhotoPath();
//        $pics[]['src'] = 'https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg';
        return $pics;
    }

    public static function makephotoPath($id, $photo) {

        if ($photo) {
            $path = 'Public/Images/Place/' . $id . '_' . $photo;
            if (USE_AWS) {
                return Aws::BASE_AWS_URL . $path;
            } else  {
                return HTTP_REFERER . $path;
            }
        } else {
//            return HTTP_REFERER . 'Public/Images/place.png'; //default image
        }
    }

    public function getPhotoPath() {
        return self::makephotoPath($this->getID(), $this->a_photo);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function getRatingHtml() {
        $r = intval($this->getRating());
        $ret = str_repeat('<i class="fa fa-star "></i>', $r);
        $ret .= str_repeat('<i class="fa fa-star-o "></i>', 5 - $r);
        return $ret;
//                    <p class="rating fs-12 m-t-5">
//                        <i class="fa fa-star "></i>
//                        <i class="fa fa-star "></i>
//                        <i class="fa fa-star "></i>
//                        <i class="fa fa-star-o"></i>
//                        <i class="fa fa-star-o"></i>
//                    </p>
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
    function callGoogleAPI($data = false) {
//        https://maps.googleapis.com/maps/api/place/textsearch/json?query=paris&key=AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json';
        $data['key'] = $this->google_api_key; //'AIzaSyDsL2HI8bxi78DT4oHVw1XTOT4qKjksPi0';
        $url = sprintf("%s?%s", $url, http_build_query($data));


        $result = file_get_contents($url);


        $result = json_decode($result);
        return $result;
    }

    public function storeGoogleSearch() {
        $Where = $this->getWhere();
        foreach ($Where as $key => $filters) {
            foreach ($filters as $filter) {
                if ($filter) {
                    if (strpos($filter['campo'], 'name') !== false) {
                        $q = str_replace('%', '', $filter['valor']);
                    }
                }
            }
        }
        // ---- GOOGLE ----------
//        $type = 'geocode';
        $type = '(regions)';
        if ($q != '') {
            $ret = $this->callGoogleAPI(array('query' => $q, 'type' => $type));  // commneted to stop making requests
//        $ret->results = array();
//            print'<pre>';
//            die(print_r($ret));
            foreach ($ret->results as $value) {
                $placeLst = new Place();
                $placeLst->where('google_place_id', $value->place_id);
                $placeLst->readLst2();
                if ($placeLst->countItens() > 0) {
                    continue;
                }
                $place = new Place();
                $place->setgoogle_place_id($value->place_id);
                $place->setformatted_address($value->formatted_address);
                $place->setname($value->name);
                $place->setrating($value->rating);
                $place->setSearchQuery($q);
                $place->setgoogletypes(json_encode($value->types));
                $place->save();
                $url = '';
                if (is_array($value->photos) and count($value->photos) > 0){
                    foreach ($value->photos as $photo) {
                        $url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=1000&photoreference=' . $photo->photo_reference . '&key=' . $this->google_api_key;
                        break;
                    }
                }

                if ($url != '') {
                    $img = RAIZ_DIRETORY . 'site/Public/Images/Place/' . $place->getID() . '_' . md5($photo->photo_reference) . '.jpg';
                    copy($url, $img);
                    $place->setPhoto(md5($photo->photo_reference) . '.jpg');
                    $place->save();

                    if (USE_AWS) {
                        Aws::moveToAWS($img);
                    }
                }
            }
//        print'<pre>';
//        die(print_r($places));
//        dr($places);
        }
        return $places;
    }

    function readLst($modo = 'obj') {
// ---- first I read all the places using the query -------
        $this->join('dreamboard', 'dreamboard.id_place = place.id_place and dreamboard.id_usuario = ' . Usuario::getIdUsuarioLogado(), 'id_place as favorite', 'left');
        parent::readLst($modo);

        // if we got no results, We have to search on google and save on Places ;
        if ($this->countItens() == 0) {
            $this->storeGoogleSearch();
        }

        parent::readLst();
    }

    function readLst2($modo = 'obj') {
        parent::readLst($modo);
    }

}
