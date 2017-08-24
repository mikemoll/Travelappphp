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
    // 
    public function formattedCost() {
        if($this->Isfree()) {
            return 'Free';
        } else {
            $currency = new Currency();
            $currency->read($this->getId_currency());

            return $currency->getSymbol() . $this->getCost() . ' ' . $currency->getName();
        }
    }

    public function getDecodedType() {
        switch ($this->getType()) {
            case 'P': return 'Place';
            case 'A': return 'Activity';
            case 'E': return 'Event';
        }
    }

    public function activityOrEventTypeName() {
        switch ($this->getType()) {
            case 'A': return $this->getActivitytypename();
            case 'E': return $this->getEventdescription();
            default: return '';
        }
    }

    function readLst($modo = 'obj') {
        // join with triptype and event type
        $this->join('activitytype', 'triprecommendation.id_activitytype = activitytype.id_activitytype', 'activitytypename','left');
        $this->join('eventtype',    'triprecommendation.id_eventtype    = eventtype.id_eventtype', 'description as eventdescription ','left');

        parent::readLst($modo);
    }

}
