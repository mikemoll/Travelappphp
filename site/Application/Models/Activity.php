<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Activity extends Db_Table {

    protected $_name = 'activity';
    public $_primary = 'id_activity';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getPicsLst() {
        $pics[]['src'] = $this->getPhotoPath();
//        $pics[]['src'] = 'https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg';
        return $pics;
    }

    public static function makephotoPath($id, $photo) {
        if ($photo) {
            return HTTP_REFERER . 'Public/Images/Activity/' . $id . '_' . $photo;
        } else {
            return HTTP_REFERER . 'Public/Images/people.png'; //default image
        }
    }

    public function getPhotoPath() {
        return self::makephotoPath($this->getID(), $this->a_photo);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

}
