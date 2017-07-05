<?php
class Format_Date{
	/**
	 * retorna a diferença de dia entre duas datas
	 *
	 * @param date $dataInicial
	 * @param date $dataFinal
	 */
	public static function comparaData($dataInicial, $dataFinal = ''){

		$dias = 0;

		$dInicial = explode('-', $dataInicial);
		if($dataFinal != ''){
			$dFinal = explode('-', $dataFinal);
		}else{
			$dFinal = explode('-', date('Y-m-d'));
		}
		$dInicialAno = $dInicial[0];
		$dInicialMes = $dInicial[1];
		$dInicialDia = $dInicial[2];

		$dFinalAno = $dFinal[0];
		$dFinalMes = $dFinal[1];
		$dFinalDia = $dFinal[2];

		$ano = $dFinalAno - $dInicialAno;
		$mes = $dFinalMes - $dInicialMes;
		$dia = $dFinalDia - $dInicialDia;

		for($i = 0; $i < $ano; $i++){
			if(Format_Date::is_bisexto($dInicialAno + $i)){
				$dias += 366;
			}else{
				$dias += 365;
			}
		}

		for($i = 0; $i < $mes; $i++){
			$dias += Format_Date::numDiasMes($mes +$i, $dFinalAno);
		}

		return ($dias + $dia);
	}
	/**
	 * Verifica se o ano e bisexto
	 *
	 * @param integer $ano
	 */
	public static function is_bisexto($ano) {
		if($ano % 4 == 0){
			return true;
		}else {
			return false;
		}
	}
   	/**
   	 * Retorna o numero de dias do mes
   	 *
   	 * @param integer $mes
   	 * @param integer $ano
   	 */
	public static function numDiasMes($mes, $ano){
		if($mes == 1 && $mes == 3 && $mes == 5 && $mes == 7 && $mes == 8 && $mes == 10 && $mes == 12){
			return 31;
		}else if($mes == 2){
			if(Format_Date::is_bisexto($ano)){
				return 29;
			}else{
				return 28;
			}
		}else {
			return 30;
		}
	}
}