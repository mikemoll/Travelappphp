<?php

class FormataDados {

    /**
     * Formata uma valor depedendo do tipo passado para a função, caso seja passado na propriedade valor
     * um objeto o tipo e valor sera pego do proprio objeto
     *
     * @param String or Object $valor
     * @param String $tipo
     */
    public static function formataDadosSaveSinigaglia($valor, $tipo) {

        if (is_object($valor)) {
            $key = 'get' . $tipo;
            $tipo = $valor->getTipoColuna($tipo);
            $valor = $valor->$key();
        }


        if (strcmp($tipo, 'date') == 0 or strcmp($tipo, 'datetime') == 0) {
            if ($valor != '') {
                return "'" . DataHora::inverteData($valor) . "'";
            } else {
                return 'null';
            }
        } else if (strcmp($tipo, 'nvarchar') == 0 or strcmp($tipo, 'ntext') == 0 or strcmp($tipo, 'nchar') == 0 or strcmp($tipo, 'char') == 0or strcmp($tipo, 'bit') == 0) {
            return "'" . str_replace("'", "''", $valor) . "'";
        } else if (strcmp($tipo, 'numeric') == 0 or strcmp($tipo, 'float') == 0 or strcmp($tipo, 'decimal') == 0 or strcmp($tipo, 'real') == 0) {
            if ($valor != '') {
                if (strpos($valor, ',') !== false) {
                    $source = array('.', ',');
                    $replace = array('', '.');
                    $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
                }
                return $valor;
            } else {
                return 'null';
            }
        } else if (strcmp($tipo, 'int4') == 0 or strcmp($tipo, 'int') !== false) {
            if ($valor != '') {
                return number_format($valor, 0, '.', '');
            } else {
                return '0';
            }
        } else if (DataHora::isDate($valor, '/')) {
            if ($valor != '') {
                return "'" . DataHora::inverteData($valor) . "'";
            } else {
                return 'null';
            }
        } else {
            return $valor;
        }
    }

    /**
     * Formata uma valor depedendo do tipo passado para a função, caso seja passado na propriedade valor
     * um objeto o tipo e valor sera pego do proprio objeto
     *
     * @param String or Object $valor
     * @param String $tipo
     */
    public static function formataDadosSave($valor, $tipo) {

        if (is_object($valor)) {
            $key = 'a_' . $tipo;
            $tipo = $valor->getTipoColuna($tipo);
            $valor = $valor->$key;
        }
//        print'------------------<pre>';
//         (print_r("$key - $tipo -  $valor <br><br>" ));

        if (strcmp($tipo, 'date') == 0) {
            return DataHora::inverteData($valor);
        } else if (strcmp($tipo, 'decimal') == 0 or strcmp($tipo, 'numeric') == 0 or strcmp($tipo, 'int4') == 0) {
            if (strpos($valor, ',') !== false) {
                $source = array('.', ',');
                $replace = array('', '.');
                $valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
            }
            return $valor;
        } else if (DataHora::isDate($valor, '/')) {
            return DataHora::inverteData($valor);
        } else if ($valor == '') {
            return null;
        } else {
            return $valor;
        }
    }

    /**
     * Formata uma valor depedendo do tipo passado para a função, caso seja passado na propriedade valor
     * um objeto o tipo e valor sera pego do proprio objeto
     *
     * @param String|Object $valor
     * @param String $tipo
     */
    public static function formataDadosRead($valor = '', $tipo = '') {

        if (is_object($valor)) {
            $key = 'a_' . $tipo;
            $tipo = $valor->getTipoColuna($tipo);
            $valor = $valor->$key;
        }


        if ($valor == '') {
            return null;
        } elseif (strcmp($tipo, 'date') == 0) {
            return DataHora::inverteData($valor);
        } else if (strcmp($tipo, 'numeric') == 0) {
            return number_format($valor, 2, '.', '');
        } else if (strcmp($tipo, 'int4') == 0) {
            return number_format($valor, 0, '.', '');
        } else if (DataHora::isDate($valor, '-')) {
            return DataHora::inverteData($valor);
        } else {
            return $valor;
        }
    }

    /* public static function tuuuurataDados($value){
      if (DataHora::isDate($value)){
      $value = DataHora::inverteData($value);
      }else{
      $value = Browser_Control::htmlToString($value);
      }
      return $value;
      } */



    /**
     * Converte todos os os caracteres convertidos para html para caracteres normais para mostrar no campos de texto.
     *
     * Ex: <br> retorna  &lt br &gt
     *
     */
    /* public static function stringToForm($string) {
      if (is_array($string)) {
      foreach ($string as $key => $value) {
      $ret[$key] = FormataDados::htmlToString($value);
      }
      }else{
      $ret = FormataDados::htmlToString($string);
      }

      return $ret;
      } */
}
