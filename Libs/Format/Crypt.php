<?php
class Format_Crypt{
	/**
	 * Função de criptografia do sistema usado para senhas de acesso ao sistema
	 * não existe função reversa apenas criptografia MD5
	 * @param $val
	 * @return valor criptografado
	 */
	public static function encryptPass($val){
		$p1 = '';
		$p2 = '';
		$senha = str_split($val);
		$tam = count($senha);
		for($i = 0; $i < ($tam / 2); $i++) {
			$p1 .= $senha[$i];
		}
		for($i = ($tam / 2); $i < $tam; $i++) {
			$p2 .= $senha[$i];
		}
		return md5(md5($p2) . md5($p1));
	}
}