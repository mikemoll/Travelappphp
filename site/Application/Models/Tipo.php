<?php
/**
 * Modelo da classe Tipoproduto
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Tipo extends Db_Table {
	protected $_name = 'tipo';
	public $_primary = 'id_tipo';
	public $_log_ativo = true;

	public function setDataFromRequest($post) {
		$this->setDescricao($post->descricao);
		$this->setId_Owner($post->id_owner);
	}

	 

}