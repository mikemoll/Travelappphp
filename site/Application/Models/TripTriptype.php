<?php
class TripTriptype extends Db_Table {
    protected $_name = 'triptriptype';
    public $_primary = 'id_triptriptype';

    function readLst($modo = 'obj') {
        $this->join('triptype', 'triptype.id_triptype = triptypename.id_triptype', 'triptypename');
        parent::readLst($modo);
    }
}