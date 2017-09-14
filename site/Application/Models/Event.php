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

    public function getFirstPhoto() {
        $pics = $this->getPicsLst();
        return $pics[0]['src'];
    }

    public static function makephotoPath($id, $photo) {
        if ($photo) {
            $path = 'Public/Images/Event/' . $id . '_' . $photo;
            if (USE_AWS) {
                return Aws::BASE_AWS_URL . $path;
            } else  {
                return HTTP_REFERER . $path;
            }
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


    public function getPriceOrFree() {
        $p = $this->getPrice() == 0 ? 'free' : '$' . $this->getPrice();
        return $p;
    }

    public function getFormattedDate() {
        $d = new DateTime(DataHora::inverteDataIngles($this->getstart_at()));
//        print'<pre>';
//        die(print_r($d));
        return $d->format("D, M dS Y");
    }

    function readLst($modo = 'obj') {
        $this->join('dreamboard', 'dreamboard.id_event = event.id_event and id_usuario = ' . Usuario::getIdUsuarioLogado(), 'id_event as favorite', 'left');
        $this->join('eventtype', 'eventtype.id_eventtype = event.id_eventtype', 'description as eventtypename', 'left');
        parent::readLst($modo);
    }

}
