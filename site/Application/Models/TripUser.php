<?php

/**
 * Model TripUser class
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class TripUser extends Db_Table {

    protected $_name = 'tripuser';
    public $_primary = 'id_tripuser';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as username,email,birthdate,nationality,nationality2,photo'
                . ',passport,passport2,allergies,medicalissues,contactname,contactrelationship,'
                . ',contactnumber,contactemail,doctorname,doctornumber,doctoremail');
        parent::readLst($modo);
    }

    function read($id = NULL, $modo = 'obj') {
        $this->reset();
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as username,email,birthdate,nationality,nationality2,photo'
                . ',passport,passport2,allergies,medicalissues,contactname,contactrelationship'
                . ',contactnumber,contactemail,doctorname,doctornumber,doctoremail');
        parent::read($id, $modo);
    }

//    public function setDataFromRequest($post) {
//
//    }
}
