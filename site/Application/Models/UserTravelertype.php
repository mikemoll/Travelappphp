<?php
class UserTravelertype extends Db_Table {
    protected $_name = 'usertravelertype';
    public $_primary = 'id_usertravelertype';

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }

}