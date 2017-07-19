<?php
class TripPlace extends Db_Table {
    protected $_name = 'tripplace';
    public $_primary = 'id_tripplace';

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }


    function readLst($modo = 'obj') {
        $this->join('place', 'tripplace.id_place = place.id_place', 'name');
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
