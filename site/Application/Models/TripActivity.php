<?php

/**
 * Modelo da classe Activitytype
 * @filesource
 * @author      Loenardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  site.apllication.models
 * @version     1.0
 */
class TripActivity extends Db_Table {

    protected $_name = 'tripactivity';
    public $_primary = 'id_tripactivity';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj') {
        $this->join('trip', 'trip.id_trip = tripactivity.id_trip', 'id_trip,tripname');
        $this->join('activity', 'activity.id_activity = tripactivity.id_activity', 'id_activity, activityname');
        $this->join('usuario', 'usuario.id_usuario = tripactivity.id_usuario', ' id_usuario,nomecompleto,email');
        parent::readLst($modo);
    }

    public function setDataFromRequest($post) {

    }

}
