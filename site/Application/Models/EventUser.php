<?php

/**
 * Modelo da classe EventUser
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class EventUser extends Db_Table {

    protected $_name = 'eventuser';
    public $_primary = 'id_eventuser';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public static function getStatusList($i = '') {
//        'i', 'w', 'o', 'c', 'b'
        $list['i'] = 'invited';
        $list['w'] = 'wishlist';
        $list['o'] = 'owner';
        $list['c'] = 'confirm';
        $list['b'] = 'blocked';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    public function getDescSatus() {
        return $this->getStatusList($this->getStatus());
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = eventuser.id_usuario', 'nomecompleto as username,email');
        parent::readLst($modo);
    }

}
