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
//        $this->setDataCadastro($post->DataCadastro);
//        $this->setDataCadastro($post->DataCadastro);
        $this->setAssunto($post->Assunto);
        $this->setMensagem($post->getUnescaped('Mensagem'));
    }

}
