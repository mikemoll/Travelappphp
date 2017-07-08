<?php

/**
 * Modelo da classe Interest
 * @filesource
 * @author      Rômulo Berri
 * @copyright   Rômulo Berri
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Interest extends Db_Table {

    protected $_name = 'interests';
    public $_primary = 'id_interests';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function setDataFromRequest($post) {
        $this->setDescription($post->description);
    }

}
