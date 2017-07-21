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

    public function getDaysTo() {
        return DataHora::daysBetween(date('Y-m-d'), DataHora::inverteDataIngles($this->getstartdate()), 'yyyy-mm-dd', 'yyyy-mm-dd');
    }

    public function getDaysToText() {
        $days = $this->getDaysTo();
        if (substr($days, 0,1) == '-') {
            if (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($post->enddate), '<', date('Y-m-d'))) {
                return 'in progress!';
            } else {
                return 'done!';
            }
        }
        return 'in '.$days.' days!';
    }

    public function getShortDescription() {
        return $this->getDescription();
    }

    public function getTripActivityLst() {
        if ($this->TripActivityLst == null) {
            $this->TripActivityLst = new TripActivity();
        }
        return $this->TripActivityLst;
    }

    public function getformatedstartdate() {
        return substr($this->getstartdate(),0,10);
    }

    public function getformatedenddate() {
        return substr($this->getenddate(),0,10);
    }

    public function setTripActivityLst($val) {
        $this->TripActivityLst = $val;
    }

    public function getTripplaceLst() {
        if ($this->TripplaceLst == null) {
            $this->TripplaceLst = new Tripplace();
        }
        return $this->TripplaceLst;
    }

    public function setTripplaceLst($val) {
        $this->TripplaceLst = $val;
    }

    public function getPicsLst() {
        $TripplaceLst = $this->getTripplaceLst();
        for ($i = 0; $i < $TripplaceLst->countItens(); $i++) {
            $Item = $TripplaceLst->getItem($i);
            $pics[]['src'] = $Item->getPhotoPath();
        }
        return $pics;
    }

    public function getFirstPhoto() {
        $pics = $this->getPicsLst();
        return $pics[0]['src'];
    }

    public function read($id = NULL, $modo = 'obj') {
        parent::read($id, $modo);

        $TripPlaceLst = $this->getTripplaceLst();
        $TripPlaceLst->where('id_trip', $this->getID());
        $TripPlaceLst->readLst();
        $this->setTripplaceLst($TripPlaceLst);

        $TripPlaceLst = $this->getTripActivityLst();
        $TripPlaceLst->where('tripactivity.id_trip', $this->getID());
        $TripPlaceLst->readLst();
        $this->setTripActivityLst($TripPlaceLst);
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
