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
class Event extends Db_Table {

    protected $_name = 'event';
    public $_primary = 'id_event';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_public = 'N';
        $this->a_id_owner = Usuario::getIdUsuarioLogado();
    }

    public function getPicsLst() {
        $pics[]['src'] = $this->getPhotoPath();
//        $pics[]['src'] = 'https://media-cdn.tripadvisor.com/media/photo-s/0e/85/48/e6/seven-mile-beach-grand.jpg';
        return $pics;
    }

    public static function makephotoPath($id, $photo) {
        if ($photo) {
            return HTTP_REFERER . 'Public/Images/Event/' . $id . '_' . $photo;
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

    function readLst($modo = 'obj') {
        $this->join('dreamboard', 'dreamboard.id_event = event.id_event and id_usuario = ' . Usuario::getIdUsuarioLogado(), 'id_event as favorite', 'left');
        parent::readLst($modo);
    }

}
