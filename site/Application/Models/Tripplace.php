<?php

/**
 * Modelo da classe tripplace
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Tripplace extends Db_Table {

    protected $_name = 'tripplace';
    public $_primary = 'id_tripplace';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }

    public function getPhotoPath() {
        return Place::makephotoPath($this->getid_place(), $this->a_photo);
    }

    function readLst($modo = 'obj') {
        $this->join('place', 'place.id_place = tripplace.id_place', 'name,photo ');
        parent::readLst($modo);
    }

   public function setDataFromRequest($post) {
        $this->setid_trip($post->id_trip);
        $this->setid_place($post->id_place);

        $this->setstartdate($post->startdate);
        $this->setenddate   ($post->enddate);
        $this->setaccomodation($post->accomodation);
        $this->setbudget($post->budget);
        $this->setaccomodationnotsure($post->accomodationnotsure);
        $this->setbudgetnotsure($post->budgetnotsure);
        $this->settransportationinfo($post->transportationinfo);

    }

    public function setDataFromRequest1($post) {
        $this->setid_trip($post->id_trip);
        $this->setid_place($post->id_place);

        $this->setstartdate($post->startdate);
        $this->setenddate($post->enddate);
    }

    public function setDataFromRequest2($post) {
        $this->setaccomodation($post->accomodation);
        $this->setbudget($post->budget);
        $this->setaccomodationnotsure($post->accomodationnotsure);
        $this->setbudgetnotsure($post->budgetnotsure);
        $this->settransportationinfo($post->transportationinfo);
    }

}
