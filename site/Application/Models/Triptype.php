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
                $ttdata['icon'] = $tt->getImagePath($id);
                $list[$id] = $ttdata;
            }
        }
        return $list;
    }

    public static function makeimagelocalPath($id) {
        $path = RAIZ_DIRETORY . 'site/Public/Images/triptypes';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path .'/'. $id . '.png';
    }

    public static function makeimagePath($id) {
        $path = 'Public/Images/triptypes/' . $id . '.png';
        if (!file_exists(Triptype::makeimagelocalPath($id))) {
            return HTTP_REFERER . 'Public/Images/interest.png';
        }
        return HTTP_REFERER . $path; //default image
    }

    public function getImagePath() {
        return Triptype::makeimagePath($this->getID());
    }
}
