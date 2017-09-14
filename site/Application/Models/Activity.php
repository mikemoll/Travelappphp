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

    public function getFirstPhoto() {
        $pics = $this->getPicsLst();
        return $pics[0]['src'];
    }

    public function getPriceOrFree() {
        $p = $this->getPrice() == 0 ? 'free' : '$' . $this->getPrice();
        return $p;
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    function readLst($modo = 'obj') {
        $this->join('dreamboard', 'dreamboard.id_activity = activity.id_activity and id_usuario = ' . Usuario::getIdUsuarioLogado(), 'id_activity as favorite', 'left');
        $this->join('activitytype', 'activitytype.id_activitytype = activity.id_activitytype', 'activitytypename', 'left');
        parent::readLst($modo);
    }

}
