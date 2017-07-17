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

    public static function getTripTypeIcon($id) {
        return BASE_URL . 'Public/Images/triptype/' . $id .'.png';
    }

    public static function getAllTripTypesLst() {

        $triptypes = new Triptype();
        $triptypes->readLst();
        $list = array();
        if ($triptypes->countItens() > 0) {
            for ($i = 0; $i < $triptypes->countItens(); $i++) {
                $tt = $triptypes->getItem($i);
                $id = $tt->getid_triptype();
                $ttdata = array();
                $ttdata['description'] = $tt->gettriptypename();
                $ttdata['icon'] = Triptype::getTripTypeIcon($id);
                $list[$id] = $ttdata;
            }
        }
        return $list;
    }

}
