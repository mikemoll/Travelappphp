<?php
class Format_Number{
	public static function createMask($val, $mask){
		$arrayMask = str_split($mask);
		$arrayValue = str_split($val);
		$string = '';
		$y = 0;
		if($val != ''){
			for($i = 0; $i <= count($arrayMask); $i++){
				if($arrayMask[$i] != '#'){
					$string .= $arrayMask[$i];
				}else{
					$string .= $arrayValue[$y];
					$y++;
				}
			}
		}
		
		//print_r($string);die('<br><br>' .  __LINE__);
		return $string;
	}
}