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
class Trip extends Db_Table {

    protected $_name = 'trip';
    public $_primary = 'id_trip';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function setDataFromRequest($post) {
        $this->settripname($post->tripname);
        $this->setDescription($post->getUnescaped('Description'));
        $this->settravelmethod($post->getUnescaped('travelmethod'));
        $this->setinventory($post->getUnescaped('inventory'));
        $this->setnotes($post->getUnescaped('notes'));
        $this->setstartdate($post->getUnescaped('startdate'));
        $this->setenddate($post->getUnescaped('enddate'));
    }


    public function getTripTriptypesLst() {
        if ($this->TripTriptypesLst == null) {
            $this->TripTriptypesLst = new TripTriptype();
        }
        return $this->TripTriptypesLst;
    }

    public function getTripUserLst() {
        if ($this->TripUserLst == null) {
            $this->TripUserLst = new TripUser();
        }
        return $this->TripUserLst;
    }


    public function save() {

        //print_r($this);die('<br><br>\n\n' . ' Linha: ' . __LINE__ . ' Arquivo: ' . __FILE__);

        switch ($this->getState()) {

            case cDELETE:


                $lLst = $this->getTripTriptypesLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }

                $lLst = $this->getTripUserLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }


                parent::save();
                break;

            case cCREATE:
            case cUPDATE:

                //  print_r($this);die('<br><br>\n\n' . ' Linha: ' . __LINE__ . ' Arquivo: ' . __FILE__);

                parent::save();

                $lLst = $this->getTripTriptypesLst();

                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setid_trip($this->getID());
                        $Item->save();
                    }
                }

                $lLst = $this->getTripUserLst();

                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setid_trip($this->getID());
                        $Item->save();
                    }
                }

                break;
        }
    }

}
