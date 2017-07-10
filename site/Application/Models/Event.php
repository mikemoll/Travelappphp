<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Event extends Db_Table {

    protected $_name = 'event';
    public $_primary = 'id_event';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_public = 'N';
        $this->a_id_owner = Usuario::getIdUsuarioLogado();
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

}
