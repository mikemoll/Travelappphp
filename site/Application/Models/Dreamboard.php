<?php

/**
 * Modelo da classe Dreamboard
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Dreamboard extends Db_Table {

    protected $_name = 'dreamboard';
    public $_primary = 'id_dreamboard';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_created_at = date('m/d/Y H:i:s');
    }

    function readLst($modo = 'obj') {
        $this->join('activity', 'activity.id_activity = dreamboard.id_activity', 'activityname', 'left');
        $this->join('event', 'event.id_event = dreamboard.id_event', 'eventname', 'left');
        parent::readLst($modo);
    }

}
