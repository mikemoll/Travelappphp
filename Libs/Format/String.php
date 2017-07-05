<?php
class Format_String{
	/**
	 * Converte todos os os caracteres convertidos para html para caracteres normais.
	 *
	 * Ex: &lt br &gt retorna <br>
	 * por padrão converte os caracteres html para formato acentuados normal
	 */

	protected static function converteString($string, $invert = false){
		$ret = '';
		$acento = array('Á', 'á', 'Â', 'â', 'À', 'à', 'Ã', 'ã', 'É', 'é', 'Ê', 'ê', 'È', 'è', 'Ó', 'ó', 'Ô', 'ô', 'Ò', 'ò', 'Õ', 'õ', 'Í', 'í',
						'Î', 'î', 'Ì', 'ì', 'Ú', 'ú', 'Û', 'û', 'Ù', 'ù', 'Ç', 'ç', '<', '>', 'º');

		$html = array('&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Agrave;', '&agrave;', '&Atilde;', '&atilde;', '&Eacute;', '&eacute;',
            		  '&Ecirc;', '&ecirc;', '&Egrave;', '&egrave;', '&Oacute;', '&oacute;', '&Ocirc;', '&ocirc;', '&Ograve;', '&ograve;',
            		  '&Otilde;', '&otilde;', '&Iacute;', '&iacute;', '&Icirc;', '&icirc;', '&Igrave;', '&igrave;', '&Uacute;', '&uacute;',
            		  '&Ucirc;', '&ucirc;', '&Ugrave;', '&ugrave;', '&Ccedil;', '&ccedil;', '&lt;', '&gt;', '&ordm;');

		if (is_array($string)) {
			foreach ($string as $key => $value) {
				if(is_array($value)){
					FormataDados::htmlToString($value);
				}else{
					if(!$invert){
						$ret[$key] = str_replace($html, $acento, $value);
					}else{
						$ret[$key] = str_replace($acento, $html, $value);
					}
				}
			}
		}else{
			if(!$invert){
				$ret = str_replace($html, $acento, $string);
			}else{
				$ret = str_replace($acento, $html, $string);
			}
		}
		return $ret;
	}

	public static function htmlToString($string) {
		return Format_String::converteString($string);
	}
	public static function stringToHtml($string){
		return Format_String::converteString($string, true);
	}
	
	public static function jqueryParams($params){
		$sep = '';
		$json = '{';
		foreach ($params as $key => $value){
			if($value != ''){
				if(is_array($value)){
					Format_String::jqueryParams($value);
				}else if(is_string($value) && $key != 'select' && $key != 'colModel' && $key != 'buttons'){
					$json .= $sep.$key . ':"' . $value . '"';
				}else{
					$json .= $sep.$key . ':' .$value;
				}
				$sep = ', ';
			}
		}
		$json .= '}';
		//print_r($json);die('<br><br>' .  __LINE__);
		return $json;
	}
}