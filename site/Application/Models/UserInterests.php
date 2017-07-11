<?php
class UserInterests extends Db_Table {
    protected $_name = 'userinterests';
    public $_primary = 'id_userinterests';

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }
}