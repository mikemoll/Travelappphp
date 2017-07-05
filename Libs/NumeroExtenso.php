<?php

/**
 *
 * @author Leonardo Danieli <leonardo@4coffee.com.br>
 * @copyright  Work 4 Coffee
 * @access public
 * @package Libs 
 */

/**
 * 
 * @author Leonardo Danieli <leonardo@4coffee.com.br>
 * @copyright  Work 4 Coffee
 * @access public
 * @package Libs 
 */
class NumeroExtenso {

    /**
     * Escreve um numero por extenso
     * @param String $numero
     * @param type $caps
     * @return String
     */
    static function escrever($numero, $caps = 1, $dinheiro = false) {
        $many = array('', ' mil ', ' milhões ', ' bilhões ');

        $numero = strval($numero);
        list($numero, $posVirgula) = explode('.', $numero);
        //=========
        if ($posVirgula == '')
            list($numero, $posVirgula) = explode(',', $numero);

//                fazer o exlode denovo com a virgula
        //=====================
        $saida = "";

        if (strlen($numero) % 3 != 0) {
            $saida .= self::cada3(substr($numero, 0, strlen($numero) % 3));
            $saida .= $many[floor(strlen($numero) / 3)];
        }

        for ($i = 0; $i < floor(strlen($numero) / 3); $i++) {
            $saida .= self::cada3(substr($numero, strlen($numero) % 3 + ($i * 3), 3));
            if ($numero[strlen($numero) % 3 + ($i * 3)] != 0) {
                $saida .= $many[floor(strlen($numero) / 3) - 1 - $i];
            }
        }

        $match = array('/um mil /', '/um milhхes/', '/um bilhхes/', '/ +/', '/ $/', '/ /', '/e mil/', '/e bil/');
        $replace = array('mil ', 'um milhão ', 'um bilhão ', ' ', '', ' e ', ' mil ', ' bil ');
        $saida = preg_replace($match, $replace, $saida);
        if ($dinheiro) {
            $saida .= ' reais';
        }
        if ($posVirgula != 0) {
            $saida .= ' com ' . self::escrever($posVirgula, $caps);
            if ($dinheiro) {
                $saida .= ' centavos';
            }
        }
        if ($caps) {
            $saida = ucwords($saida);
            $saida = preg_replace("/ E /", " e ", $saida);
            $saida = preg_replace("/ Com /", " com ", $saida);
        }

        return $saida;
    }

    static function cada3($numero) {
        $unidades = array('um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove');
        $dez = array('onze', 'doze', 'treze', 'catorze', 'quinze', 'dezesseis', 'dezessete', 'dezoito', 'dezenove');
        $dezenas = array('dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa');
        $centenas = array('cento ', 'duzentos ', 'trezentos ', 'quatrocentos ', 'quinhentos ', 'seiscentos ', 'setecentos ', 'oitocentos ', 'novecentos ');

        $saida = "";
        $j = strlen($numero);
        $ok = false;
        for ($i = 0; $i < strlen($numero); $i++) {
            if ($j == 2) {
                if ($numero[$i] == 1) {
                    if ($numero[$i + 1] == 0)
                        $saida .= $dezenas[$numero[$i] - 1];
                    else {
                        $saida .= $dez[$numero[$i + 1] - 1];
                        $ok = true;
                    }
                } else {
                    if (!empty($dezenas[$numero[$i] - 1]))
                        $saida .= $dezenas[$numero[$i] - 1] . ' ';
                }
            }
            elseif (($numero[$i] != 0) AND ( !$ok) AND ( $j == 3) AND ( $numero[0] == 1) AND ( $numero[1] == 0) AND ( $numero[2] == 0))
                $saida .= "cem";
            elseif (($numero[$i] != 0) AND ( !$ok) AND ( $j == 3))
                $saida .= $centenas[$numero[0] - 1];
            elseif ($numero[$i] != 0 && !$ok)
                $saida .= $unidades[$numero[$i] - 1];
            $j--;
        }
        return $saida;
    }

}

?>