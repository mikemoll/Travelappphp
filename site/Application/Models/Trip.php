<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		 system
 * @subpackage	system.application.models
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
        if (substr($days, 0, 1) == '-') {
            if (DataHora::compareDateYYYYMMDD(DataHora::inverteDataIngles($post->enddate), '<', date('Y-m-d'))) {
                return 'in progress!';
            } else {
                return 'done!';
            }
        }
        return 'in ' . $days . ' days!';
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

    public function getTripexpenseLst() {
        if ($this->TripexpenseLst == null) {
            $this->TripexpenseLst = new Tripexpense();
        }
        return $this->TripexpenseLst;
    }

    public function getformatedstartdate() {
        return substr($this->getstartdate(), 0, 10);
    }

    public function getformatedenddate() {
        return substr($this->getenddate(), 0, 10);
    }

    public function setTripActivityLst($val) {
        $this->TripActivityLst = $val;
    }

    public function setTripexpenseLst($val) {
        $this->TripexpenseLst = $val;
    }

    public function setTriptaskLst($val) {
        $this->TriptaskLst = $val;
    }

    public function getTripplaceLst() {
        if ($this->TripplaceLst == null) {
            $this->TripplaceLst = new Tripplace();
        }
        return $this->TripplaceLst;
    }

    public function getTotalBudget() {
        for ($i = 0; $i < $this->getTripexpenseLst()->countItens(); $i++) {
            $Item = $this->getTripexpenseLst()->getItem($i);
            if (!$Item->deleted()) {
                if ($Item->getTotalorPerson() == 'P') {
                    $times = $this->getTripUserLst()->countItens();
                } else {
                    $times = 1;
                }
                $sum += $Item->getAmount() * $times;
            }
        }
        return number_format($sum, 2);
    }

    public function getTripPlaceList($id = '') {
        $ret = array();
        for ($i = 0; $i < $this->getTripplaceLst()->countItens(); $i++) {
            $Item = $this->getTripplaceLst()->getItem($i);
            $ret[$Item->getID()] = $Item->getName();
        }
        if ($id != '') {
            return $ret[$id];
        }
        return $ret;
    }

    public function getTripUserList() {
        $ret = array();
        for ($i = 0; $i < $this->getTripUserLst()->countItens(); $i++) {
            $Item = $this->getTripUserLst()->getItem($i);
            $ret[$Item->getID()] = $Item->getusername();
        }
        return $ret;
    }

    public function setTripplaceLst($val) {
        $this->TripplaceLst = $val;
    }

    public function getTripItinerary() {
        $ret = array();

//        $event['pic'] = 'https://media.licdn.com/mpr/mpr/shrinknp_800_800/p/5/005/0b8/3f7/047eea7.jpg';
//        $event['title'] = 'Arriving';
//        $event['desc'] = 'San Francisco(SFO) to Vancouver';
//        $d = new DateTime(DataHora::inverteDataIngles($this->getStartDate()));
//        $event['day'] = $d->format("d");
//        $event['month'] = $d->format("M");
//        $event['startdate'] = $this->getStartDate();
//
//        $ret[$d->format("Ymd"). count($ret)] = $event;


        $lst = $this->getTripplaceLst();
        for ($i = 0; $i < $lst->countItens(); $i++) {
            $Item = $lst->getItem($i);
            // ------ start place -----
            $event['id'] = $Item->getID();
            $event['id_place'] = $Item->getID();
            $event['pic'] = $Item->getPhotoPath();
            $event['title'] = $Item->getName();
            $event['desc'] = $Item->getDescription();
            $d = new DateTime(DataHora::inverteDataIngles($Item->getStartDate()));
            $event['day'] = $d->format("d");
            $event['month'] = $d->format("M");
            $event['startdate'] = $Item->getStartDate();
            $ret[$d->format("Ymd") . count($ret)] = $event;
//            // ------ end place -----
//            $event['pic'] = $Item->getFistPhoto();
//            $event['title'] = $Item->getName();
//            $event['desc'] = $Item->getDescription();
//            $d = new DateTime(DataHora::inverteDataIngles($Item->getEndDate()));
//            $event['day'] = $d->format("d");
//            $event['month'] = $d->format("M");
//            $event['startdate'] = $Item->getEndDate();
//            $ret[$d->format("Ymd")] = $event;
        }

        $lst = $this->getTripActivityLst();
        for ($i = 0; $i < $lst->countItens(); $i++) {
            $Item = $lst->getItem($i);
            $event['id'] = $Item->getID();
            $event['type'] = 'activity';
            $event['pic'] = $Item->getFistPhoto();
            $event['title'] = $Item->getActivityName();
            $event['desc'] = $Item->getDescription();
            $d = new DateTime(DataHora::inverteDataIngles($Item->getStart_at()));
            $event['day'] = $d->format("d");
            $event['month'] = $d->format("M");
            $event['startdate'] = $Item->getStart_at();
            $ret[$d->format("Ymd") . count($ret)] = $event;
        }
//        $event['pic'] = 'https://www.kcet.org/sites/kl/files/styles/kl_image_large/public/thumbnails/image/flight-departure.jpg?itok=RbmwaVZ0';
//        $event['title'] = 'Bye Bye...';
//        $event['desc'] = 'Time to say Good Bye!';
//        $d = new DateTime(DataHora::inverteDataIngles($this->getEndDate()));
//        $event['day'] = $d->format("d");
//        $event['month'] = $d->format("M");
//        $event['startdate'] = $this->getEndDate();
//        $ret[$d->format("Ymd"). count($ret)] = $event;

        ksort($ret);
        return $ret;
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

    public function setTripUserLst($val) {
        $this->TripUserLst = $val;
    }

    public function getTriptaskLst() {
        if ($this->TriptaskLst == null) {
            $this->TriptaskLst = new Triptask();
        }
        return $this->TriptaskLst;
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

        $TripPlaceLst = $this->getTripexpenseLst();
        $TripPlaceLst->where('tripexpense.id_trip', $this->getID());
        $TripPlaceLst->readLst();
        $this->setTripexpenseLst($TripPlaceLst);

        $TripPlaceLst = $this->getTripUserLst();
        $TripPlaceLst->where('tripuser.id_trip', $this->getID());
        $TripPlaceLst->readLst();
        $this->setTripUserLst($TripPlaceLst);

        $TripPlaceLst = $this->getTriptaskLst();
        $TripPlaceLst->where('triptask.id_trip', $this->getID());
        $TripPlaceLst->readLst();
        $this->setTriptaskLst($TripPlaceLst);
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
                $lLst = $this->getTripexpenseLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }
                $lLst = $this->getTriptaskLst();
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

                $lLst = $this->getTripexpenseLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setid_trip($this->getID());
                        $Item->save();
                    }
                }
                $lLst = $this->getTriptaskLst();
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
