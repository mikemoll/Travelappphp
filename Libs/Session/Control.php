<?php
class Session_Control{
	/**
	 * Retorna uma valor do objeto do usuario que se encontra logado no sistema
	 * @param string $prop
	 */
	public static function getPropertyUserLogado($prop) {
		$session = Zend_Registry::get('session');
		$attr = 'get'.$prop;
		if(isset($session->usuario)){
			return $session->usuario->$attr();
		}else{
			return '';
		}
	}
	/**
	 * Adiciona valores ou objetos na sessão da aplicação
	 * @param String $nome nome de referencia do valor igual ao OID
	 * @param String or Object $val valor que será guardado na memoria
	 */
	public static function setDataSession($nome, $val){
		$session = Zend_Registry::get('session');
		$session->$nome = serialize($val);
		Zend_Registry::set('session', $session);
	}
	/**
	 * Retorna um valor que esta guardado na sessão da aplicação
	 * @param String $nome nome que foi salvo na memoria
	 */
	public static function getDataSession($nome){
        $session = Zend_Registry::get('session');
        return unserialize($session->$nome);
	}
}