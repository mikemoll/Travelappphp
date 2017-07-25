<?php

/**
 * Modelo da classe Permissões
 * @filesource
 * @author 		Leonardo Danieli
 * @copyright 	Leonardo Danieli
 * @package		 system
 * @subpackage	system.application.models
 * @version		1.0
 */
class Permissao extends Db_Table {
	protected $_name = 'permissao';
	public $_primary = 'id_permissao';

	protected $_log_text = 'a permissão';

	public function read($id = null, $modo = 'obj'){
		$this->join('processo', 'permissao.id_processo = processo.id_processo', 'id_processo, nome, descricao, controladores');
		parent::read($id, $modo);
	}

	public function getPermissoes($idUser, $grupo){

		$perGrupo = array();
		$perUser = array();

		if($idUser != ''){
			$item = new Permissao();
			$item->join('processo', 'permissao.id_processo = processo.id_processo', 'id_processo, nome, descricao, controladores');
			$item->where('id_usuario', $idUser);
			$item->readLst();
			$perUser = $item->getItens() != '' ? $item->getItens() : array();
		}

		if($grupo != 0){
			$item = new Permissao();
			$item->join('processo', 'permissao.id_processo = processo.id_processo', 'id_processo, nome, descricao, controladores');
			$item->where('id_usuario', $grupo);

			$item->readLst();
			$perGrupo = $item->getItens() != '' ? $item->getItens() : array();
		}

		foreach($perGrupo as $key){
			$key->setTipo('permissao');
			$key->setOwner($idUser);
			$key->setGrupo('S');
			$key->setState('');
			$permissoes[strtolower($key->getNome())] = $key;

			$keyClone = clone $key;

			$controllers = explode(', ', $key->getControladores());
			foreach($controllers as $value){
				if($value != ''){
					$keyClone->setTipo('controlador');
					$permissoes[strtolower($value)] = $keyClone;
				}
			}
		}

		foreach($perUser as $key){
			$key->setTipo('permissao');
			$key->setOwner($idUser);
			$key->setGrupo('N');
			$key->setState('');
			$permissoes[strtolower($key->getNome())] = $key;

			$keyClone = clone $key;

			$controllers = explode(', ', $key->getControladores());
			foreach($controllers as $value){
				if($value != ''){
					$keyClone->setTipo('controlador');
					$permissoes[strtolower($value)] = $keyClone;
				}
			}
		}
		return $permissoes;
	}
}
