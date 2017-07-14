<?php
class UserTravelertype extends Db_Table {
    protected $_name = 'usertravelertype';
    public $_primary = 'id_usertravelertype';

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }

    function readLst($modo = 'obj') {
        $this->join('travelertype', 'travelertype.id_travelertype = usertravelertype.id_travelertype', 'description');
        parent::readLst($modo);
    }

}