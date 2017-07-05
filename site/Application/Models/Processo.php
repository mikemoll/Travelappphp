<?php

class Processo extends Db_Table {

    protected $_name = 'processo';
    public $_primary = 'id_processo';

    public function setDataFromRequest($post) {
        $this->setNome($post->Nome);
        $this->setDescricao($post->Descricao);
        $this->setControladores($post->Controladores);
    }

}
