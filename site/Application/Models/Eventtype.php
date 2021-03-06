<?php

/**
 * Modelo da classe Eventtype
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Eventtype extends Db_Table {

    protected $_name = 'eventtype';
    public $_primary = 'id_eventtype';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function readLstWithEvent($modo = 'obj') {
        $this->join('event', 'event.id_eventtype = eventtype.id_eventtype', 'id_eventtype');
        $this->setDistinct();
        return parent::readLst($modo);
    }

}
