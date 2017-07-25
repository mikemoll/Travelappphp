<?php

/**
 * Model for the class tripexpense
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Tripexpense extends Db_Table {

    protected $_name = 'tripexpense';
    public $_primary = 'id_tripexpense';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getNomeResc() {
        return $this->getnomecompleto();
    }

    public function getPhotoPath() {
        return Place::makephotoPath($this->getid_place(), $this->a_photo);
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = tripexpense.id_usuario', 'nomecompleto ');
        parent::readLst($modo);
    }

}
