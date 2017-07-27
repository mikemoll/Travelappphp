<?php

/**
 * Model for the class Triptask
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Triptask extends Db_Table {

    protected $_name = 'triptask';
    public $_primary = 'id_triptask';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj') {
        $this->join('tripuser', 'tripuser.id_tripuser = triptask.id_responsable', '');
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as responsable', 'left');
        parent::readLst($modo);
    }

}
