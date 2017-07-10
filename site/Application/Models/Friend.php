<?php

/**
 * Modelo da classe Friend
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Friend extends Db_Table {

    protected $_name = 'friend';
    public $_primary = array('id_friend', 'id_usuario');

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = friend.id_usuario', 'nomecompleto , email, lastname');
        parent::readLst($modo);
    }

}
