<?php

/**
 * Modelo da classe Activitytype
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Activitytype extends Db_Table {

    protected $_name = 'activitytype';
    public $_primary = 'id_activitytype';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->setActivitytypename($post->activitytypename);
    }


    public function readLstWithActivity($modo = 'obj') {
        $this->join('activity', 'activity.id_activitytype = activitytype.id_activitytype', 'id_activitytype');
        $this->setDistinct();
        return parent::readLst($modo);
    }
}
