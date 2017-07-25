<?php

/**
 * Modelo da classe TripUser
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
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as username,email');
        parent::readLst($modo);
    }

    public function setDataFromRequest($post) {

    }

}
