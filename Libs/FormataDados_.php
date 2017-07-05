<?

define("cDIR",0);
define("cESQ",1);


/**
 * ValidaDados Classe gen�rica para Formata��o de Dados
 *
 * Criado em: 06/05/2005
 * �ltima Altera��o: 06/05/2005
 *
 */

class FormataDados{
		
	/**
	 * Formata para Cep
	 *
	 * @param	string	$str   string com o e-mail informado
	 * @return	string  - Campo formatado ( xxxxx-xxx )
	 */
	function toCep($str){
	
	 	if ($str == '')
		  return ''; 
		  
  	   $p1 = substr($str, 0, 5);
   	   $p2 = substr($str, 5, 3);
	   
	   return $p1 . '-' . $p2;	
	}
	
	function toCNPJ($str){
	
	 	if ($str == '')
		  return ''; 
		  
  	   $p1 = substr($str, 0, 2);
   	   $p2 = substr($str, 2, 3);
   	   $p3 = substr($str, 5, 3);
   	   $p4 = substr($str, 8, 4);
   	   $p5 = substr($str, 12, 2);

	   return $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4 . '-' . $p5;	
	}	

	function toURL($str){
	
	 	if (strstr($str,'http://'))
		  return $str; 

	 	if (strstr($str,'HTTP://'))
		  return $str; 

	 	if (strstr($str,'Http://'))
		  return $str; 

		return 'http://' . $str;
		  
	}	

	function toData($str){
	
	 	if ($str == '')
		  return ''; 
		  
  	   $p1 = substr($str, 0, 2);
   	   $p2 = substr($str, 2, 2);
   	   $p3 = substr($str, 4, 4);

	   return $p1 . '/' . $p2 . '/' . $p3;	
	}		
	
	function toCPF($str){
	
	 	if ($str == '')
		  return ''; 
		  
  	   $p1 = substr($str, 0, 3);
   	   $p2 = substr($str, 3, 3);
   	   $p3 = substr($str, 6, 3);
   	   $p4 = substr($str, 9, 2);

	   return $p1 . '.' . $p2 . '.' . $p3 . '/' . $p4;	
	}		
	
	function toFloat2($str){
	
		$str = str_replace('.',',',$str);
		$vl = split(',',$str);

		$inteiro = $vl[0];

			
		//Monta os separadores de milhar
		if ( strlen( $inteiro ) > 3 ){
				$restante = $inteiro;
				while( strlen( $restante ) > 3 ){
					$milhar = substr($restante, strlen($restante) - 3 , 3);
					$restante = substr($restante, 0, strlen($restante) - 3);
				 	$milharacum .= '.' . $milhar;
				}
	
			$inteiro = $restante . $milharacum;
		}

		
		if( count($vl) > 1){
		 
			$frac = $vl[1];
			if( strlen($frac) == 1)
			 $frac = $frac . '0';
			 
			return $inteiro . ',' . $frac; 
			 
		
		}else{
			
			return $inteiro . ',' .  '00';
		}

	}

	function toReal2($str,$moeda='R$ '){
        
        $valMonetario = $moeda . number_format($str, 2, ',', '.');
        return $valMonetario;

	}

	function toMoedaReal($str=0,$moeda='R$ '){
                
                if ($str != 0)
		return $moeda . FormataDados::toFloat2( $str );
	else
		return $moeda. '0.00';

	}
	
	function toValorNominal($str){
	
		$str = str_replace('.',',',$str);
		$vl = split(',',$str);
		if( count($vl) > 1){
		 
		 	$inteiro = $vl[0];
			$frac = $vl[1];
			if( strlen($frac) == 1)
			 $frac = $frac . '0';
			 
			return $inteiro . $frac;

		}else{
			
			return $vl[0] . '00';
		}
	}	
	
	function pontoToVirg($str){
	
		$str = str_replace('.',',',$str);
	    return $str;	
	}			
	
	function virgToPonto($str){
	
		$str = str_replace(',','.',$str);
	    return $str;	
	}				
	
	function tiraFormat($str){
	
		$str = str_replace('.','',$str);
		$str = str_replace('-','',$str);
		$str = str_replace('/','',$str);
		$str = str_replace('(','',$str);
		$str = str_replace(')','',$str);
		$str = str_replace(':','',$str);
	    return $str;	
	}
	
	
	function formataMask($pValor,$pMask){
	
		if(trim($pValor=='') ) return '';
		
		$lValorSemMask = FormataDados::tiraFormat( $pValor );
		$lValueFormatado = '';	
		
		$lIndStr = 0;
		for ($lIndMask=0; $lIndMask < strlen( $pMask );$lIndMask++){

			if($lIndStr <  strlen( $lValorSemMask ) ){
				$lCharMask = substr($pMask,$lIndMask,1);
				
				if( ($lCharMask=='9') || ($lCharMask=='#') ){ 
		
					$lCharEdt = substr($lValorSemMask,$lIndStr,1);
	
					if($lCharMask=='9'){ 
						if (is_numeric($lCharEdt)) {
							$lValueFormatado = $lValueFormatado . $lCharEdt;
						}
					}else
						$lValueFormatado = $lValueFormatado . $lCharEdt;
					$lIndStr++;
	
				}else
					$lValueFormatado = $lValueFormatado . $lCharMask;
			}else
				break;
	
		} 
	
		return $lValueFormatado;
	}
	
	
	static function fillChar($str,$pPos,$pFillChar,$pTamanhoTotal){
	
		$tamAtu = strlen( $str );
		$tamToFill = $pTamanhoTotal - $tamAtu;

		if($tamToFill <=0 ) 
			return $str; 	


		for($i=0;$i<$tamToFill;$i++){
		
			if($pPos == cESQ)
				$str = $pFillChar . $str;
			else
				$str = $str . $pFillChar;
		}
										
	    return $str;	
	}								

	function clearCharEsq($str,$pClearChar){

		$tamAtu = strlen( $str );

		for($i=0;$i<$tamAtu;$i++)
			if( substr($str,$i,1) != $pClearChar){
				$str = substr($str,$i);
				return $str;
		}
	    return $str;
	}

	function trataApostrofe($str){

		// Substitui ' por \' para inserir no banco... 
		$result_subst = str_replace("\'", "'", $str);
		$result_subst = str_replace("'", "\'", $result_subst);
		return $result_subst;
	}

	function trataApostrofeToBD($str){

		// Substitui ' por \' para inserir no banco... 
		$result_subst = str_replace("\'", "'", $str);						
		$result_subst = str_replace("'", "\'", $result_subst);
		return $result_subst;
	}

	function trataApostrofeFromBD($str){
	
		// Substitui \' por ' para inserir no banco... 
		$result_subst = str_replace("\'", "'", $str);						
		return $result_subst;
	}
}
?>