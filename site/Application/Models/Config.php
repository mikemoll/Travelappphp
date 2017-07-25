<?php

/**
 * Modelo da classe Config
 * @filesource
 * @author 		Leonardo Danieli
 * @copyright 	Leonardo Danieli
 * @package		 system
 * @subpackage	system.application.models
 * @version		1.0
 */
class Config extends Db_Table {

    protected $_name = 'config';
    public $_primary = 'id_config';
    protected $_log_text = 'Configuração';

    public function setDataFromRequest($post) {
        $this->setDescricao($post->descricao);
        $this->setTrocaSenhaTempo($post->trocasenhatempo);
    }

}
