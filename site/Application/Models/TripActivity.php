<?php

/**
 * Modelo da classe Activitytype
 * @filesource
 * @author      Loenardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  site.apllication.models
 * @version     1.0
 */
class TripActivity extends Db_Table {

    protected $_name = 'tripactivity';
    public $_primary = 'id_tripactivity';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getPhotoPath() {
        return Activity::makephotoPath($this->getid_activity(), $this->a_photo);
    }

    function readLst($modo = 'obj') {
        $this->join('trip', 'trip.id_trip = tripactivity.id_trip', 'id_trip,tripname');
        $this->join('activity', 'activity.id_activity = tripactivity.id_activity', 'id_activity', 'left');
        $this->join('usuario', 'usuario.id_usuario = tripactivity.id_usuario', ' id_usuario,nomecompleto,email', 'left');
        parent::readLst($modo);
    }

    public function setCopyFromActivity($activity) {
        $attrs = get_object_vars($activity);
        foreach ($attrs as $key => $value) {
            if (substr($key, 0, 2) == 'a_') {
                $s = "set" . substr($key, 2);
                $g = "get" . substr($key, 2);
                $this->$s($activity->$g());
            }
        }
    }

    public function setDataFromRequest($post) {
        parent::setDataFromRequest($post);
//        print'<pre>';
//        die(print_r($this));
    }

}
