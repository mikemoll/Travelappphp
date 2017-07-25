<?php

/**
 * Modelo da classe Interest
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Interest extends Db_Table {

    protected $_name = 'interests';
    public $_primary = 'id_interests';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function setDataFromRequest($post) {
        $this->setDescription($post->description);
    }


    public static function makeimagelocalPath($id) {
        $path = RAIZ_DIRETORY . 'site/Public/Images/interests';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path .'/'. $id . '.png';
    }

    public static function makeimagePath($id) {
        $path = 'Public/Images/interests/' . $id . '.png';
        if (!file_exists(Interest::makeimagelocalPath($id))) {
            return HTTP_REFERER . 'Public/Images/interest.png';
        }
        return HTTP_REFERER . $path; //default image
    }

    public function getImagePath() {
        return Interest::makeimagePath($this->getID());
    }
}
