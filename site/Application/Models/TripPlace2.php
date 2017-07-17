<?php

/**
 * Modelo da classe tripplace
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Tripplace extends Db_Table {

    protected $_name = 'tripplace';
    public $_primary = 'id_tripplace';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getPhotoPath() {
        return Place::makephotoPath($this->getid_place(), $this->a_photo);
    }

    function readLst($modo = 'obj') {
        $this->join('place', 'place.id_place = tripplace.id_place', 'name,photo ');
        parent::readLst($modo);
    }

    public function setDataFromRequest($post) {

    }

}
