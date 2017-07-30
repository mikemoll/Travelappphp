<?php

/**
 * Model for the class Triptask
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Triptask extends Db_Table {

    protected $_name = 'triptask';
    public $_primary = 'id_triptask';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function getTypeDesc() {
        return self::getTripTaskTipeList($this->getid_type());
    }

    function getresponsable() {
        if ($this->a_responsable == '') {
            $tripuser = new tripuser();
            $tripuser->read($this->getid_responsable());
            $user = new Usuario();
            $user->read($tripuser->getid_usuario());
            $this->a_responsable = $user->getNomeCompleto();
        }
        return $this->a_responsable;
    }

    public static function getTripTaskTipeList($i = '') {
        $list['1'] = 'Doctor';
        $list['2'] = 'Item Purchase';
        $list['3'] = 'Personal';
        $list['4'] = 'Visa';
        $list['5'] = 'Other';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    function readLst($modo = 'obj') {
        $this->join('tripuser', 'tripuser.id_tripuser = triptask.id_responsable', '');
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as responsable', 'left');
        parent::readLst($modo);
    }

    public function setDataFromRequest($post) {
        parent::setDataFromRequest($post);
        $this->setDone(($post->done == '') ? "N" : "S");
    }

}
