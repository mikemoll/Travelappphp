<?php

/**
 * Model for the class Triprecommendation
 * @filesource
 * @author      Rômulo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Triprecommendation extends Db_Table {

    protected $_name = 'triprecommendation';
    public $_primary = 'id_triprecommendation';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    // public function getNomeResc() {
    //     return $this->getnomecompleto();
    // }

    // public function getPhotoPath() {
    //     return Place::makephotoPath($this->getid_place(), $this->a_photo);
    // }

    function readLst($modo = 'obj') {
        // TODO: join with triptype and event type
        // $this->join('tripuser', 'tripuser.id_tripuser = tripexpense.id_usuario', '');
        // $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as coveredby ');
        parent::readLst($modo);
    }

}
