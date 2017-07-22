<?php
class UserInterests extends Db_Table {
    protected $_name = 'userinterests';
    public $_primary = 'id_userinterests';

    public function getNomeUsuario() {
        if ($this->getid_usuario() != '0') {
            return Usuario::getUsuarioList($this->getid_usuario());
        }
    }


    public function readLst($modo = 'obj') {
        $this->join('interests', 'interests.id_interests = userinterests.id_interest', 'description');
        parent::readLst($modo);
    }

    public function getImagePath() {
        return Interest::makeimagePath($this->getid_interest());
    }
}