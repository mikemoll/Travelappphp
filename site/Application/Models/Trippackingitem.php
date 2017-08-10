<?php

/**
 * Model for the class Trippackingitem
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Trippackingitem extends Db_Table {

    protected $_name = 'trippackingitem';
    public $_primary = 'id_trippackingitem';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function getTypeDesc() {
        return self::getTripPackingItemTypeList($this->getid_type());
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

    public static function getTripPackingItemTypeList($i = '') {
        $list[''] = 'Select a category';
        $list['1'] = 'Clothes';
        $list['2'] = 'Toiletries';
        $list['3'] = 'Electronics';
        $list['4'] = 'Documents + Money';
        $list['5'] = 'Medication + Health';
        $list['6'] = 'Other';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    function readLst($modo = 'obj') {
        $this->join('tripuser', 'tripuser.id_tripuser = trippackingitem.id_responsable', '');
        $this->join('usuario', 'usuario.id_usuario = tripuser.id_usuario', 'nomecompleto as responsable', 'left');
        parent::readLst($modo);
    }

    public function setDataFromRequest($post) {
        parent::setDataFromRequest($post);
        $this->setDone(($post->done == '') ? "N" : "S");
    }

}
