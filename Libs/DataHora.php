<?php

/**
 * dataHora Classe para manipula��o de Datas e horas
 *
 * Criado em: 14/11/20013
 * �ltima Altera��o: 14/11/2003
 *
 */
class DataHora {

    /**
     * Retorna o nome do mes
     *
     * @param type $pNum  numero do mes
     * @param type $pUpper
     * @param type $pResumido
     * @return string nome do mes
     */
    static function nomeMes($pNum, $pUpper = false, $pResumido = false) {


        if (($pNum == 1) || ($pNum == '01'))
            $lRet = $pResumido ? 'Jan' : 'Janeiro';
        if (($pNum == 2) || ($pNum == '02'))
            $lRet = $pResumido ? 'Fev' : 'Fevereiro';
        if (($pNum == 3) || ($pNum == '03'))
            $lRet = $pResumido ? 'Mar' : 'Março';
        if (($pNum == 4) || ($pNum == '04'))
            $lRet = $pResumido ? 'Abr' : 'Abril';
        if (($pNum == 5) || ($pNum == '05'))
            $lRet = $pResumido ? 'Mai' : 'Maio';
        if (($pNum == 6) || ($pNum == '06'))
            $lRet = $pResumido ? 'Jun' : 'Junho';
        if (($pNum == 7) || ($pNum == '07'))
            $lRet = $pResumido ? 'Jul' : 'Julho';
        if (($pNum == 8) || ($pNum == '08'))
            $lRet = $pResumido ? 'Ago' : 'Agosto';
        if (($pNum == 9) || ($pNum == '09'))
            $lRet = $pResumido ? 'Set' : 'Setembro';
        if ($pNum == 10)
            $lRet = $pResumido ? 'Out' : 'Outubro';
        if ($pNum == 11)
            $lRet = $pResumido ? 'Nov' : 'Novembro';
        if ($pNum == 12)
            $lRet = $pResumido ? 'Dez' : 'Dezembro';


        if ($pUpper) {
            $lRet = strtoupper($lRet);
        }

        return $lRet;
    }

    static function getDiaSemanaFromDate($pData, $pDtFormato = 'dd/mm/yyyy') {

        $lDia = '';
        $lMes = '';
        $lAno = '';

        DataHora::getDayMonthYearFromFormat($pData, $pDtFormato, $lDia, $lMes, $lAno);
        $lDiaSem = date("l", mktime(0, 0, 0, $lMes, $lDia, $lAno));

        switch ($lDiaSem) {

            case 'Monday': return 'Segunda-feira';
            case 'Tuesday': return 'Terça-feira';
            case 'Wednesday': return 'Quarta-feira';
            case 'Thursday': return 'Quinta-feira';
            case 'Friday': return 'Sexta-feira';
            case 'Saturday': return 'Sábado';
            case 'Sunday': return 'Domingo';
        }
    }

    /**
     *
     * @param type $ano
     * @return type
     */
    static public function dias_feriados($ano = null) {
        if ($ano === null) {
            $ano = intval(date('Y'));
        }

        $pascoa = easter_date($ano); // Limite de 1970 ou apуs 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
        $dia_pascoa = date('j', $pascoa);
        $mes_pascoa = date('n', $pascoa);
        $ano_pascoa = date('Y', $pascoa);

        $feriados = array(
// Datas Fixas dos feriados Nacionail Basileiras
            mktime(0, 0, 0, 1, 1, $ano), // Confraternizaзгo Universal - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 2, 2, $ano), // Nossa Senhora dos Navegantes
//mktime(0, 0, 0, 3, 26, $ano), // Aniversбrio de Porto Alegre
            mktime(0, 0, 0, 4, 21, $ano), // Tiradentes - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 5, 1, $ano), // Dia do Trabalhador - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 9, 7, $ano), // Dia da Independкncia - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 9, 20, $ano), // Revoluзгo Farroupilha
            mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida - Lei nє 6802, de 30/06/80
            mktime(0, 0, 0, 11, 2, $ano), // Todos os santos - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 11, 15, $ano), // Proclamaзгo da republica - Lei nє 662, de 06/04/49
            mktime(0, 0, 0, 12, 25, $ano), // Natal - Lei nє 662, de 06/04/49
// These days have a date depending on easter
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48, $ano_pascoa), //2єferia Carnaval
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47, $ano_pascoa), //3єferia Carnaval
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2, $ano_pascoa), //6єfeira Santa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa, $ano_pascoa), //Pascoa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60, $ano_pascoa), //Corpus Cirist
        );

        sort($feriados);

        return $feriados;
    }

    /**
     * a data deve ser no formato padrão 'dd/mm/yyyy'
     *
     * @param string $data se não passar nenhuma data, pega o dia de hoje
     * @param string $pDtFormato padrão 'dd/mm/yyyy'
     * @return boolean
     */
    static function isFeriado($data = null, $pDtFormato = 'dd/mm/yyyy') {

        list($data, $hora) = explode(' ', $data);
//se a daa vem vazia:
        $data == null ? $data = date('d/m/Y') : $data = $data;

//divide a data em dia, mes e ano
        DataHora::getDayMonthYearFromFormat($data, $pDtFormato, $dia, $mes, $ano);

        $feriados = self::dias_feriados($ano);

        foreach ($feriados as $a) {
            if (date("d/m/Y", $a) == $data) {
                return true;
            }
        }
        return false;
    }

    static function isFinalSemana($pData, $pDtFormato = 'dd/mm/yyyy', $iniFindi = 'Sábado') {

        if ($iniFindi == 'Sábado') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Sexta-feira') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sexta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Quinta-feira') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quinta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sexta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Quarta-feira') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quarta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quinta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sexta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Terça-feira') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Terça-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quarta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quinta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sexta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Segunda-feira') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Segunda-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Terça-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quarta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Quinta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sexta-feira' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Sábado' or DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        } elseif ($iniFindi == 'Domingo') {
            if (DataHora::getDiaSemanaFromDate($pData, $pDtFormato) == 'Domingo') {
                return true;
            }
        }
    }

    static function getNextWorkingDay($pData = '', $pDtFormato = 'dd/mm/yyyy') {
        if ($pDtFormato != 'dd/mm/yyyy') {
            print'<pre>';
            die(print_r('O formato da data em [DataHora::getNextWorkDay()]só pode ser "dd/mm/yyyy" por enquanto.'));
        }
        if ($pData == '') {
            $pData = date('d/m/Y');
        }
        do {
            $pData = self::operations($pData, 'sum', 'day', '1');
        } while (self::isFinalSemana($pData, $pDtFormato) or self::isFeriado($pData, $pDtFormato));
        return $pData;
    }

    static function getDataExtensoFromDate($pData = '', $pDtFormato = 'dd/mm/yyyy', $pMostraDiaSemana = true) {

        $lDia = '';
        $lMes = '';
        $lAno = '';
        if ($pData == '') {
            $pData = date('d/m/Y');
        }
        DataHora::getDayMonthYearFromFormat($pData, $pDtFormato, $lDia, $lMes, $lAno);

        if ($pMostraDiaSemana == false) {
            $lDiaSem = '';
        } else {
            $lDiaSem = DataHora::getDiaSemanaFromDate($pData, $pDtFormato);
        }

        $lDataExt = $lDiaSem . ' ' . $lDia . ' de ' . DataHora::nomeMes($lMes) . ' de ' . $lAno;

        return $lDataExt;
    }

    /**
     * Testa se a data � vazia
     * @deprecated Since 1
     * @param	string	$v   valor no formato dd-mm-yyyy ou dd/mm/yyyy
     * @return	0 , 1
     */
    static function isEmptyDate($v) {

        $lDtH = trim($v);

        if (strlen($lDtH) > 10) {
            $lTm = substr($lDtH, 11, 8);
            if (!DataHora::isEmptyTime($lTm))
                return 0;
        }

        $lDt = substr($lDtH, 0, 10);


        if (( $lDt == '') ||
                ( $lDt == '00/00/0000') ||
                ( $lDt == '00-00-0000') ||
                ( $lDt == '0000/00/00') ||
                ( $lDt == '0000-00-00'))
            return 1;

        return 0;
    }

    /**
     * Testa se a data � vazia
     *
     * @param	string	$v   valor no formato dd-mm-yyyy ou dd/mm/yyyy
     * @return	0 , 1
     */
    static function isEmptyTime($v) {

        if (( trim($v) == '') ||
                ( trim($v) == '00:00:00') ||
                ( trim($v) == '00:00'))
            return 1;

        return 0;
    }

    static function mkTime($pDt, $pTime, $pDtFormato) {

        $lDia = '';
        $lMes = '';
        $lAno = '';

        if ($pTime == '') {
            $lHora = 0;
            $lMin = 0;
            $lSeg = 0;
        } else {
            $l = explode(':', $pTime);
            $lHora = $l[0];
            $lMin = $l[1];
            $lSeg = 0;
        }

        DataHora::getDayMonthYearFromFormat($pDt, $pDtFormato, $lDia, $lMes, $lAno);

        return mktime($lHora, $lMin, $lSeg, $lMes, $lDia, $lAno);
    }

    static function convertHoursToDecimal($time) {
        list($h, $m, $s) = explode(":", $time);
        return ($h + ($m / 60) + ($s / 3600));
    }

    public static function convertTimeDecToHours($dec) {
        if ($dec < 0) {
            $sinal = '-';
        }
        $dec = abs($dec);
// start by converting to seconds
        $seconds = ($dec * 3600);
// we're given hours, so let's get those the easy way
        $hours = floor($dec);
// since we've "calculated" hours, let's remove them from the seconds variable
        $seconds -= (($hours) * 3600 );
// calculate minutes left
        $minutes = floor($seconds / 60);
// remove those from seconds as well
        $seconds = floor($seconds - ($minutes * 60));
// return the time formatted HH:MM:SS
        return $sinal . str_pad($hours, '2', '0', STR_PAD_LEFT) . ":" . str_pad($minutes, '2', '0', STR_PAD_LEFT) . ":" . str_pad($seconds, '2', '0', STR_PAD_LEFT);
    }

    static function convertDecimalToHours($dec, $withSeconds = false) {
        if ($dec < 0) {
            $sinal = '-';
        }
//        print'<pre>';die(print_r( $dec ));
// start by converting to seconds
        $seconds = ($dec * 3600);
// we're given hours, so let's get those the easy way
        $hours = floor($dec);
// since we've "calculated" hours, let's remove them from the seconds variable
        $seconds -= $hours * 3600;
// calculate minutes left
        $minutes = floor($seconds / 60);
// remove those from seconds as well
        $seconds -= $minutes * 60;
//truncate de seconds into two digits
        $seconds = substr($seconds, 0, 2);
// return the time formatted HH:MM:SS
        return $sinal . str_pad($hours, 2, 0, STR_PAD_LEFT) . ":" . str_pad($minutes, 2, 0, STR_PAD_LEFT) . ($withSeconds ? ":" . str_pad($seconds, 2, 0, STR_PAD_LEFT) : '');
    }

    static function convertHoraDecimalToMinutos($dec) {
//        print'<pre>';die(print_r( $dec ));
// we're given hours, so let's get those the easy way
        $hours = $dec;
        $minutes = $hours * 60;
        return $minutes;
    }

    /**
     * Devolve dia,m�s e ano, independente do formato da data
     *
     * @param	string	$pDt   data em qualquer
     * @param	string	$pDtFormato formato da data
     * @param	string	$pDia
     * @param	string	$pMes
     * @param	string	$pAno
     * @return	void
     */
    static function getDayMonthYearFromFormat($pDt, $pDtFormato, &$pDia, &$pMes, &$pAno) {

//        LogNaxus::insere("=========ANTES===========$pDt, $pDtFormato, $pDia, $pMes, $pAno");

        if (($pDtFormato == 'yyyy-mm-dd') || ($pDtFormato == 'yyyy/mm/dd') || ($pDtFormato == 'aaaa/mm/dd')) {

            $pAno = substr($pDt, 0, 4);
            $pMes = substr($pDt, 5, 2);
            $pDia = substr($pDt, 8, 2);
//            LogNaxus::insere("1------------- $pDt, $pDtFormato, $pDia, $pMes, $pAno");
            return;
        }

        if (($pDtFormato == 'dd-mm-yyyy') || ($pDtFormato == 'dd/mm/yyyy') || ($pDtFormato == 'dd/mm/aaaa')) {

            $pAno = substr($pDt, 6, 4);
            $pMes = substr($pDt, 3, 2);
            $pDia = substr($pDt, 0, 2);
//            LogNaxus::insere("2------------- $pDt, $pDtFormato, $pDia, $pMes, $pAno");
            return;
        }

        if (($pDtFormato == 'mm-dd-yyyy') || ($pDtFormato == 'mm/dd/yyyy') || ($pDtFormato == 'mm/dd/aaaa')) {

            $pAno = substr($pDt, 6, 4);
            $pMes = substr($pDt, 0, 2);
            $pDia = substr($pDt, 3, 2);
//            LogNaxus::insere("3------------- $pDt, $pDtFormato, $pDia, $pMes, $pAno");
            return;
        }
    }

    /**
     * Compara 2 datas no formato dd-mm-yyyy.
     *
     * @param	string	$dt1   data 1
     * @param	string	$operador   >  <  >=  < <=
     * @param	string	$dt2   data 2
     * @return	1 se true, 0 se false
     */
    static function compareDateDDMMYYYY($dt1, $pOper, $dt2) {

        $lS = explode('-', $dt1);
        if (count($lS) == 1)
            $lS = explode('/', $dt1);


        $ano1 = $lS[2];
        $mes1 = $lS[1];
        $dia1 = $lS[0];

        if (intval($mes1) < 10)
            $mes1 = '0' . intval($mes1);

        if (intval($dia1) < 10)
            $dia1 = '0' . intval($dia1);

        $lS = explode('-', $dt2);
        if (count($lS) == 1)
            $lS = explode('/', $dt2);


        $ano2 = $lS[2];
        $mes2 = $lS[1];
        $dia2 = $lS[0];

        if (intval($mes2) < 10)
            $mes2 = '0' . intval($mes2);

        if (intval($dia2) < 10)
            $dia2 = '0' . intval($dia2);

        $ndt1 = $ano1 . $mes1 . $dia1;
        $ndt2 = $ano2 . $mes2 . $dia2;

        $str = '(  $ndt1 ' . $pOper . ' $ndt2 ) ? 1 : 0';

        eval("\$l = $str;");
        return $l;
    }

    /**
     * Compara 2 datas no formato yyyy-mm-dd.
     *
     * @param	string	$dt1   data 1
     * @param	string	$operador   >  <  >=  < <=
     * @param	string	$dt2   data 2
     * @return	1 se true, 0 se false
     */
    static function compareDateYYYYMMDD($dt1, $pOper, $dt2) {

        $lS = explode('-', $dt1);
        if (count($lS) == 1)
            $lS = explode('/', $dt1);


        $ano1 = $lS[0];
        $mes1 = $lS[1];
        $dia1 = $lS[2];

        if (intval($mes1) < 10)
            $mes1 = '0' . intval($mes1);

        if (intval($dia1) < 10)
            $dia1 = '0' . intval($dia1);

        $lS = explode('-', $dt2);
        if (count($lS) == 1)
            $lS = explode('/', $dt2);


        $ano2 = $lS[0];
        $mes2 = $lS[1];
        $dia2 = $lS[2];

        if (intval($mes2) < 10)
            $mes2 = '0' . intval($mes2);

        if (intval($dia2) < 10)
            $dia2 = '0' . intval($dia2);

        $ndt1 = $ano1 . $mes1 . $dia1;
        $ndt2 = $ano2 . $mes2 . $dia2;

        $str = '(  $ndt1 ' . $pOper . ' $ndt2 ) ? 1 : 0';

        eval("\$l = $str;");
        return $l;
    }

    /**
     * Compara 2 datas.
     *
     * @param	string	$dt1   data 1
     * @param	string	$dt2   data 2
     * @param	string	$dt1Formato formato da data 1 ['yyyy-mm-dd']
     * @param	string	$dt2Formato formato da data 2 ['yyyy-mm-dd']
     * @return	int 1 se true, 0 se false
     */
    static function compareDate($dt1, $dt2, $dt1Formato = 'yyyy-mm-dd', $dt2Formato = 'yyyy-mm-dd') {

        $ano1 = '';
        $mes1 = '';
        $dia1 = '';
        $ano2 = '';
        $mes2 = '';
        $dia2 = '';

        DataHora::getDayMonthYearFromFormat($dt1, $dt1Formato, $dia1, $mes1, $ano1);
        DataHora::getDayMonthYearFromFormat($dt2, $dt2Formato, $dia2, $mes2, $ano2);

        $ndt1 = $ano1 . $mes1 . $dia1;
        $ndt2 = $ano2 . $mes2 . $dia2;

        if ($ndt1 > $ndt2) {
            return 1;
        }

        if ($ndt1 == $ndt2)
            return 0;

        return -1;
    }

    /**
     * Compara 2 datas.
     *
     * @param	string	$pData1   data 1
     * @param	string	$pOper   operador para comparação
     * @param	string	$pData2   data 2
     * @param	string	$pDataFormato1 formato da data 1
     * @param	string	$pDataFormato2 formato da data 2
     * @return	1 se data1 > data2    0 se data1 = data2   e   -1 se data1 < data2
     */
    static function compareDate2($pData1, $pOper, $pData2, $pDataFormato1 = 'dd/mm/yyyy', $pDataFormato2 = 'dd/mm/yyyy') {

        $ano1 = '';
        $mes1 = '';
        $dia1 = '';
        $ano2 = '';
        $mes2 = '';
        $dia2 = '';

        DataHora::getDayMonthYearFromFormat($pData1, $pDataFormato1, $dia1, $mes1, $ano1);
        DataHora::getDayMonthYearFromFormat($pData2, $pDataFormato2, $dia2, $mes2, $ano2);

        $ndt1 = $ano1 . $mes1 . $dia1;
        $ndt2 = $ano2 . $mes2 . $dia2;

        $pOper == '=' ? $pOper = '==' : '';

        $str = '(  $ndt1 ' . $pOper . ' $ndt2 ) ? 1 : 0';

        eval("\$l = $str;");
        return $l;

//
//        if ($ndt1 > $ndt2){
//			return 1;
//		}
//
//		if ($ndt1 == $ndt2)
//			return 0;
//
//		return -1;
    }

    /**
     * Compara 2 datas.
     *
     * @param	string	$pHora1   hora 1
     * @param	string	$pHora2   hora 2
     *
     * @return	1 se data1 > data2    0 se data1 = data2   e   -1 se data1 < data2
     */
    static function compareHora($pHora1, $pHora2) {

        $horario1 = explode(':', $pHora1);
        $horario2 = explode(':', $pHora2);

        $hora1 = $horario1[0];
        $min1 = $horario1[1];
        $hora2 = $horario2[0];
        $min2 = $horario2[1];

        if (($hora1 - $hora2) > 0)
            return 1;
        if (($hora1 - $hora2) == 0)
            if (($min1 - $min2) > 0)
                return 1;
        if (($min1 - $min2) == 0)
            return 0;
        if (($min1 - $min2) < 0)
            return -1;
        if (($hora1 - $hora2) < 0)
            return -1;
    }

    /**
     * Calcula o n�mero de dias entre 2 datas
     *
     * @param	string	$dt1   data 1
     * @param	string	$dt2   data 2
     * @param	string	$dt1Formato formato da data 1.  'dd/mm/yyyy'
     * @param	string	$dt2Formato formato da data 2.  'dd/mm/yyyy'
     * @param bool $contaFinalFeriado se eh para contar o final de semana ou nao
     * @return int
     */
    static function daysBetween($dt1, $dt2, $dt1Formato = 'dd/mm/yyyy', $dt2Formato = 'dd/mm/yyyy', $contaFinalFeriado = true) {

        $ano1 = '';
        $mes1 = '';
        $dia1 = '';
        $ano2 = '';
        $mes2 = '';
        $dia2 = '';



//  		DataHora::getDayMonthYearFromFormat($dt1,$dt1Formato,&$dia1,&$mes1,&$ano1);
//  		DataHora::getDayMonthYearFromFormat($dt2,$dt2Formato,&$dia2,&$mes2,&$ano2);
        DataHora::getDayMonthYearFromFormat($dt1, $dt1Formato, $dia1, $mes1, $ano1);
        DataHora::getDayMonthYearFromFormat($dt2, $dt2Formato, $dia2, $mes2, $ano2);

//                print("$mes1, $dia1, $ano1");
//                print("$mes2, $dia2, $ano2");
        $dtIni = gregoriantojd($mes1, $dia1, $ano1);
        $dtFim = gregoriantojd($mes2, $dia2, $ano2);
        $dias = $dtFim - $dtIni;
        if ($contaFinalFeriado) {
            return $dias;
        }
        $diaFDS = 0;
        $dt1 = DataHora::dateTostr($dt1, '/');
        $dt2 = DataHora::dateTostr($dt2, '/');
        while ($dt1 < $dt2) {
//            print'<pre>';die(print_r($dt1.','. $dt1Formato ));
            if (DataHora::isFinalSemana($dt1) == true or DataHora::isFeriado($dt1) == true) {
//se SABADO OU DOMINGO ou FERIADO, SOMA 01
                $diaFDS++;
            }
//            $dt1 = Soma1dia($dt1); //dia + 1
            $dt1 = DataHora::operations($dt1, 'sum', 'day', '1', false, false); //dia + 1
        }
        return $dias - $diaFDS;
    }

    /**
     * Troca o separador
     *
     * @param	string	$v   data
     * @param	string	$sepAtu caractere separador atual
     * @param	string	$sepNovo caractere separador novo
     * @return	data trocada
     */
    static function trocaSeparador($v, $sepAtu, $sepNovo) {

        return str_replace($sepAtu, $sepNovo, $v);
    }

    /**
     * Troca o separador
     *
     * @param	string	$v   data
     * @param	string	$sepAtu caractere separador atual
     * @param	string	$sepNovo caractere separador novo
     * @return	data trocada
     */
    static function mesesBetween($dt1, $dt2, $dt1Formato = 'dd/mm/yyyy', $dt2Formato = 'dd/mm/yyyy', $contaFinalFeriado = true) {

        $dias = self::daysBetween($dt1, $dt2, $dt1Formato, $dt2Formato, $contaFinalFeriado);

        return intval($dias / 30);
    }

    /**
     * formata uma string  no formato yyyy-mm-dd
     *
     * @param	string	$v   valor no formato dd-mm-yyyy ou dd/mm/yyyy
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function strToDate($v, $sep = '-') {

        $lS = explode('-', $v);
        if (count($lS) == 1)
            $lS = explode('/', $v);


        $ano = $lS[2];
        $mes = $lS[1];
        $dia = $lS[0];

        if (intval($mes) < 10)
            $mes = '0' . intval($mes);

        if (intval($dia) < 10)
            $dia = '0' . intval($dia);


// monta data no formato yyyy-mm-dd
        return $ano . $sep . $mes . $sep . $dia;

        /*
          if( strlen($v) < 10 ){
          $ano = substr($v,4,4);
          $mes = substr($v,2,2);
          $dia = substr($v,0,2);
          }else{
          $ano = substr($v,6,4);
          $mes = substr($v,3,2);
          $dia = substr($v,0,2);
          }

          if ( is_numeric($ano) && is_numeric($mes) && is_numeric($dia) ){

          // monta data no formato yyyy-mm-dd
          return $ano . $sep . $mes . $sep . $dia;
          }

          //Se n�o s�o num�ricos, ent�o considera que j� foi formatado
          return $v;
         */
    }

    /**
     * formata uma string  no formato yyyy-mm-dd
     *
     * @param	string	$v   valor no formato dd-mm-yyyy ou dd/mm/yyyy
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function strToDate2($pDia, $pMes, $pAno, $sep = '-') {

        $ano = $pAno;

        if ($pMes < 10)
            $mes = '0' . $pMes;
        else
            $mes = $pMes;

        if ($pDia < 10)
            $dia = '0' . $pDia;
        else
            $dia = $pDia;

        if (is_numeric($ano) && is_numeric($mes) && is_numeric($dia)) {

// monta data no formato yyyy-mm-dd
            return $ano . $sep . $mes . $sep . $dia;
        }

//Se n�o s�o num�ricos, ent�o considera que j� foi formatado
        return $v;
    }

    /**
     * retorna o �ltimo dia do m�s com base no m�s / ano
     *
     * @param	string	$mes
     * @param	string	$ano
     * @return	void
     */
    static function lastDayOfMonth($pMes, $pAno) {
        if (checkdate($pMes, 31, $pAno))
            return 31;

        if (checkdate($pMes, 30, $pAno))
            return 30;

        if (checkdate($pMes, 29, $pAno))
            return 29;

        if (checkdate($pMes, 28, $pAno))
            return 28;
    }

    /**
     * formata uma string  no formato dd-mm-yyyy
     *
     * @param	string	$v   valor no formato yyyy-mm-dd ou yyyy/mm/dd
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function dateTostr($v, $sep = '-') {

        $ano = substr($v, 0, 4);
        $mes = substr($v, 5, 2);
        $dia = substr($v, 8, 2);

        if (is_numeric($ano) && is_numeric($mes) && is_numeric($dia)) {

// monta data no formato yyyy-mm-dd
            return $dia . $sep . $mes . $sep . $ano;
        }

//Se n�o s�o num�ricos, ent�o considera que j� foi formatado
        return $v;
    }

    /*

      class Idade {
      public static function Calcular ($dia, $mes, $ano)
      {
      if (!checkdate($mes, $dia, $ano)) {
      echo "A data que vc informou est� errada <b>[ $dia/$mes/$ano ]</b>";
      exit;
      }
      $dia_atual = date("d");
      $mes_atual = date("m");
      $ano_atual = date("Y");
      $idade = $ano_atual - $ano;
      if ($mes > $mes_atual) {
      $idade--;
      }
      if ($mes == $mes_atual and $dia_atual < $dia) {
      $idade--;
      }
      return $idade;
      }
      }
      $calcula = new Idade();
      $idade = $calcula->Calcular("18", "05", "1977");
      echo "Voc� tem $idade anos";
     */

    /**
     * formata uma string  no formato dd-mm-yyyy hh:mm:ss
     *
     * @param	string	$v   valor no formato yyyy-mm-dd hh:mm:ss ou yyyy/mm/dd hh:mm:ss
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function dateTimeTostr($v, $sep = '-') {

        $ano = substr($v, 0, 4);
        $mes = substr($v, 5, 2);
        $dia = substr($v, 8, 2);
        $hora = substr($v, 10);

        if (is_numeric($ano) && is_numeric($mes) && is_numeric($dia)) {

// monta data no formato dd-mm-yyyy hh:mm:ss
            return $dia . $sep . $mes . $sep . $ano . $hora;
        }

//Se n�o s�o num�ricos, ent�o considera que j� foi formatado
        return $v;
    }

    /**
     * formata uma string  no formato yyyy-mm-dd hh:mm:ss
     *
     * @param	string	$v   valor no formato dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function strToDateTime($v, $sep = '-') {

        $ano = substr($v, 6, 4);
        $mes = substr($v, 3, 2);
        $dia = substr($v, 0, 2);
        $hora = substr($v, 10);

        if (is_numeric($ano) && is_numeric($mes) && is_numeric($dia)) {

// monta data no formato dd-mm-yyyy hh:mm:ss
            return $ano . $sep . $mes . $sep . $dia . $hora;
        }

//Se n�o s�o num�ricos, ent�o considera que j� foi formatado
        return $v;
    }

    /**
     * formata pega a Data em um DateTime
     *
     * @param	string	$v   valor no formato dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function getDateFromStrDateTime($v, $sep = '-') {

        if (DataHora::isEmptyDate($v))
            return '';

        $ano = substr($v, 6, 4);
        $mes = substr($v, 3, 2);
        $dia = substr($v, 0, 2);

        return $dia . $sep . $mes . $sep . $ano;
    }

    /**
     * formata pega a Hora em um DateTime
     *
     * @param	string	$v   valor no formato dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
     * @param	string	$sep caractere separador de data
     * @return	void
     */
    static function getTimeFromStrDateTime($v) {

        if (DataHora::isEmptyTime($v))
            return '';


        return substr($v, 11, 5);
    }

    /**
     * seta a Data em um DateTime no formato string
     *
     * @param	string	$v   data no formato dd-mm-yyyy ou dd/mm/yyyy
     * @param	string	$pDataHora campo a setar no formato dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
     * @return	void
     */
    static function setDateToStrDateTime($v, &$pDataHora) {

        $pNovo = $v . ' ' . DataHora::getTimeFromStrDateTime($pDataHora);

        $pDataHora = $pNovo;
    }

    /**
     * seta a Hora em um DateTime no formato string
     *
     * @param	string	$v   hora no formato hh:mm
     * @param	string	$pDataHora campo a setar no formato dd-mm-yyyy hh:mm:ss ou dd/mm/yyyy hh:mm:ss
     * @return	void
     */
    static function setTimeToStrDateTime($v, &$pDataHora) {

        $pNovo = DataHora::getDateFromStrDateTime($pDataHora) . ' ' . $v;
        $pDataHora = $pNovo;
    }

    /**
     * Ano Atual
     *
     * @return	dataAtual
     */
    static function anoAtual() {
        return date("Y");
    }

    /**
     * Mes Atual
     *
     * @return	mesAtual
     */
    static function mesAtual() {
        return date("m");
    }

    static function mesAtual2() {
        return date("n");
    }

    static function mesAnterior() {
//$lMesAtual =  ;
        $lMesAnterior = DataHora::mesAtual() - 1;
        if ($lMesAnterior == 0)
            return 12;

        return $lMesAnterior;
    }

    /**
     * Dia Atual
     *
     * @return	DiaAtual
     */
    static function diaAtual() {
        return date("d");
    }

    /**
     * Data Atual
     *
     * @return	dataAtual
     */
    static function dataAtual($sep = '/') {

        if ($sep == '-')
            return date("d-m-Y");
        else
            return date("d/m/Y");
    }

    /**
     * Hora Atual
     *
     * @return	dataAtual
     */
    static function horaAtual() {

        return date("H:i");
    }

    /**
     * Retorna o �ltimo dia do m�s para um mes/ano
     *
     * @param	string	$mes,$ano
     * @return	n�mero do dia
     */
    static function getLastDayOfMonth($mes, $ano) {
        $mes++;
        $lastday = mktime(0, 0, 0, $mes, 0, $ano);
        return strftime("%d", $lastday);
    }

    /**
     * Retorna a data completa com o 1 dia do  m�s corrente no formato mm/dd/aaaa
     *
     * @return	data completa
     */
    static function getFirstDateOfMonth() {

        $mes = date("m");
        $ano = date("Y");

        return ('01/' . $mes . '/' . $ano);
    }

    /**
     * Retorna a data completa com o �ltimo dia do  m�s corrente no formato mm/dd/aaaa
     *
     * @return	data completa
     */
    static function getLastDateOfMonth() {


        $mes = date("m");
        $ano = date("Y");
        return ( dataHora::getLastDayOfMonth($mes, $ano) . '/' . $mes . '/' . $ano);
    }

    /**
     * Valida uma data informada
     *
     * @param	string	$v   valor no formato dd-mm-yyyy ou dd/mm/yyyy ou yyyy-mm-dd ou yyyy/mm/dd
     * @return	int 1 se v�lido, 0 se inv�lido
     */
    static function isValidDate($v) {
        if ($v == '') {
//se vem vazia a data, não é valida
            return false;
        }

        $ano = substr($v, 0, 4);
        $mes = substr($v, 5, 2);
        $dia = substr($v, 8, 2);

        if (!is_numeric($ano) || !is_numeric($mes) || !is_numeric($dia)) {
            $ano = substr($v, 6, 4);
            $mes = substr($v, 3, 2);
            $dia = substr($v, 0, 2);
        }
        if (!is_numeric($ano) || !is_numeric($mes) || !is_numeric($dia)) {
//se um dos campos está vazio não é valida
            return false;
        }

        if (checkdate($mes, $dia, $ano))
            return true;
        else
            return false;
    }

    static function formataDataDDMMYY($pData) {

        $lData = explode('/', $pData);
        $lData{2} = substr($lData{2}, 2, 2);

        return implode('/', $lData);
    }

    /**
     *  inverte a data de entrada.
     *
     * Se entra 2010-09-07 saida 07/09/2010
     * Se entra 07/09/2010 saida 2010-09-07
     *
     * @param string $pData
     * @return string
     */
    static function inverteData($pData) {

        if ($pData != '') {
//        print($pData);
            list($pData, $lHoras) = explode(' ', $pData);
            $lData = explode('/', $pData);

            if (count($lData) == 1) {
                $lData = explode('-', $pData);
                $sep = '/';
            } else {
                $sep = '-';
            }

            $var[0] = $lData[2];
            $var[1] = str_pad($lData[1], '2', '0', STR_PAD_LEFT);
            $var[2] = str_pad($lData[0], '2', '0', STR_PAD_LEFT);

            return implode($sep, $var) . ($lHoras != '' ? ' ' . $lHoras : '');
        }
    }

    /**
     *  Função que soma ou subtrai, dias, meses ou anos de uma data qualquer no formato dd-mm-yyyy
     *
     * $date = $dt->operations("06/01/2003", "sum", "day", "4")   // Return 10/01/2003<br>
     * $date = $dt->operations("06/01/2003", "sub", "day", "4")   // Return 02/01/2003<br>
     * $date = $dt->operations("06/01/2003", "sum", "month", "4") // Return 10/05/2003<br>
     * $date = $dt->operations("06/01/2003 22:30", "sum", "min", "4") // Return 06/01/2003 22:34<br>
     * $date = $dt->operations("06/01/2003 22:30", "sum", "hour", "2") // Return 07/01/2003 00:30
     *
     * @param string $date
     * @param string $operation
     * @param string $where
     * @param string $quant
     * @param string $return_format
     * @return	string
     */
    static function operations($date, $operation, $where = FALSE, $quant, $return_format = FALSE) {
// Verifica erros
        $warning = "<br>Warning! Date Operations Fail... ";
        if (!$date || !$operation) {
            return "$warning invalid ou inexistent arguments<br>";
        } else {
            if (!($operation == "sub" || $operation == "-" || $operation == "sum" || $operation == "+"))
                return "<br>$warning Invalid Operation...<br>";
            else {
                $hour = 0;
                $min = 0;
                if (($where == "hour") || ($where == "min")) {

                    list($data, $hora) = explode(" ", $date);

                    if ($hora != '')
                        list($hour, $min) = explode(":", $hora);
                }
// Separa dia, m�s e ano
                list($day, $month, $year) = explode("/", $date);

// Determina a opera��o (Soma ou Subtra��o)
                ($operation == "sub" || $operation == "-") ? $op = "-" : $op = '';

// inicia variaveis
                $sum_day = '';
                $sum_month = '';
                $sum_year = '';
                $sum_hour = '';
                $sum_min = '';
// Determina aonde ser� efetuada a opera��o (dia, m�s, ano)
                if ($where == "day")
                    $sum_day = $op . "$quant";
                if ($where == "month")
                    $sum_month = $op . "$quant";
                if ($where == "year")
                    $sum_year = $op . "$quant";
                if ($where == "hour")
                    $sum_hour = $op . "$quant";
                if ($where == "min")
                    $sum_min = $op . "$quant";

// Gera o timestamp
                $date = mktime($hour + $sum_hour, $min + $sum_min, 0, $month + $sum_month, $day + $sum_day, $year + $sum_year);

                if (($where == "hour") || ($where == "min"))
// Retorna o timestamp ou extended
                    ($return_format == "timestamp" || $return_format == "ts") ? $date = $date : $date = date("d/m/Y H:i", $date);
                else
// Retorna o timestamp ou extended
                    ($return_format == "timestamp" || $return_format == "ts") ? $date = $date : $date = date("d/m/Y", $date);


// Retorna a data
                return $date;
            }
        }
    }

    static function timeBetween($hora1, $hora2) {

        list($data, $hora) = explode(" ", $hora1);
        if ($hora != '') {
            $hora1 = $hora;
        }
        list($data, $hora) = explode(" ", $hora2);
        if ($hora != '') {
            $hora2 = $hora;
        }

        list($hour1, $min1) = explode(":", $hora1);

        list($hour2, $min2) = explode(":", $hora2);

        $date = mktime($hour2 - $hour1, $min2 - $min1, 0);

        return date("H:i", "$date");
    }

    static function somaHoras($hora1, $hora2) {
        list($hour1, $min1, $mili1) = explode(":", $hora1);

        list($hour2, $min2, $mili2) = explode(":", $hora2);

        $date = mktime($hour2 + $hour1, $min2 + $min1, 0);

        return date("H:i", "$date");
    }

    static function getTurno() {
        $hora = date('H');
        if ($hora > 0 && $hora < 12)
            return 1;
        else if ($hora > 12 && $hora < 18)
            return 2;
        else if ($hora > 18 && $hora < 24)
            return 3;
        else
            return 4;
    }

    /**
     * returna true ou false de o dado eh ou nao uma data
     *
     * @param string $string
     * @param string $sep
     * @return bool true ou false
     */
    static function isDate($string, $sep = '-') {

        if ($string != '' and is_string($string)) {
            list($date) = explode(' ', $string);
            $array = explode($sep, $date);

            if (count($array) == 3) {
                if ($sep == '-')
                    if (strlen($array[0]) == 4 && strlen($array[1]) == 2 && strlen($array[2]) == 2)
                        return true;
                    else
                        return false;
                else
                if (strlen($array[0]) == 2 && strlen($array[1]) == 2 && strlen($array[2]) == 4)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        return false;
    }

    /**
     * retorna o intervalo entre dois horario em minutos
     *
     * @param $horaMenor eg: 10:30
     * @param $horaMaior eg: 11:20
     */
    public static function intervaloEntreHoras($horaMenor, $horaMaior) {
        $horaMenorArray = explode(':', $horaMenor);
        $horaMaiorArray = explode(':', $horaMaior);

//        return $horaMenorArray;



        if ($horaMenorArray[0] == '00') {
            $horaMenorArray[0] = '24';
        }
        if ($horaMaiorArray[0] == '00') {
            $horaMaiorArray[0] = '24';
        }

        $hora = ($horaMaiorArray[0] - $horaMenorArray[0]) * 60;
        $min = ($horaMaiorArray[1] - $horaMenorArray[1]);
        return $hora + $min;

//    	print_r($g );die(__FILE__.' - ');
    }

}

?>