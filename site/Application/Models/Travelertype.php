<?php

/**
 * Modelo da classe Travelertype
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Travelertype extends Db_Table {

    protected $_name = 'travelertype';
    public $_primary = 'id_travelertype';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->setDescription($post->description);
    }

}
