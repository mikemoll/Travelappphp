<?php

/**
 * Modelo da classe Triptype
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Triptype extends Db_Table {

    protected $_name = 'triptype';
    public $_primary = 'id_triptype';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->setTriptypename($post->triptypename);
    }

}
