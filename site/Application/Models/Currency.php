<?php

/**
 * Modelo da classe Currency
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Currency extends Db_Table {

    protected $_name = 'currency';
    public $_primary = 'id_currency';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->setSymbol($post->symbol);
        $this->setName($post->name);
    }

}
