<?php

/**
 * Modelo da classe Dreamboard
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Dreamboard extends Db_Table {

    protected $_name = 'dreamboard';
    public $_primary = 'id_dreamboard';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_created_at = date('m/d/Y H:i:s');
    }

    public function getPhotoPath() {
        if ($this->getId_Activity() != '') {
            return Activity::makephotoPath($this->getId_Activity(), $this->a_a_photo);
        } elseif ($this->getId_Event() != '') {
            return Event::makephotoPath($this->getId_Event(), $this->a_e_photo);
        } elseif ($this->getId_Place() != '') {
            return Place::makephotoPath($this->getId_Place(), $this->a_p_photo);
        }
    }

    public function getType() {
        $r = ($this->getId_Activity() != '') ? "Activity" : '';
        $r .= ($this->getId_Event() != '') ? "Event" : '';
        $r .= ($this->getId_Place() != '') ? "Place" : '';
        return $r;
    }

    public function getName() {
        $r = ($this->getId_Activity() != '') ? $this->getActivityname() : '';
        $r .= ($this->getid_event() != '') ? $this->geteventname() : '';
        $r .= ($this->getId_Place() != '') ? $this->getpname() : '';
        return $r;
    }

    function readLst($modo = 'obj') {
        $this->join('activity', 'activity.id_activity = dreamboard.id_activity', 'activityname , photo as a_photo, country as address', 'left');
        $this->join('event', 'event.id_event = dreamboard.id_event', 'eventname, photo as e_photo, address', 'left');
        $this->join('place', 'place.id_place = dreamboard.id_place', 'name as pname, photo as p_photo, formatted_address as address', 'left');
        parent::readLst($modo);
    }

}
