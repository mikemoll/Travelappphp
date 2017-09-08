<?php

/**
 * Modelo da classe Travelertype
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Travelertype extends Db_Table {

    protected $_name = 'travelertype';
    public $_primary = 'id_travelertype';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->setDescription($post->description);
    }

    public static function makeimagelocalPath($id) {
        $path = RAIZ_DIRETORY . 'site/Public/Images/travelertypes';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path .'/'. $id . '.png';
    }    

    public static function makeAWSimagePath($id) {
        $path = 'images/travelertypes';
        return $path .'/'. $id . '.png';
    }

    public static function makeimagePath($id) {
        $path = 'Public/Images/travelertypes/' . $id . '.png';
        if (!file_exists(Travelertype::makeimagelocalPath($id))) {
            return HTTP_REFERER . 'Public/Images/people.png';
        }
        return HTTP_REFERER . $path; //default image
    }

    public function getImagePath() {
        return Travelertype::makeimagePath($this->getID());
    }
}
