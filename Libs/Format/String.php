<?php

class Format_String {

    /**
     * Converte todos os os caracteres convertidos para html para caracteres normais.
     *
     * Ex: &lt br &gt retorna <br>
     * por padrão converte os caracteres html para formato acentuados normal
     */
    protected static function converteString($string, $invert = false) {
        $ret = '';
        $acento = array('Á', 'á', 'Â', 'â', 'À', 'à', 'Ã', 'ã', 'É', 'é', 'Ê', 'ê', 'È', 'è', 'Ó', 'ó', 'Ô', 'ô', 'Ò', 'ò', 'Õ', 'õ', 'Í', 'í',
            'Î', 'î', 'Ì', 'ì', 'Ú', 'ú', 'Û', 'û', 'Ù', 'ù', 'Ç', 'ç', '<', '>', 'º');

        $html = array('&Aacute;', '&aacute;', '&Acirc;', '&acirc;', '&Agrave;', '&agrave;', '&Atilde;', '&atilde;', '&Eacute;', '&eacute;',
            '&Ecirc;', '&ecirc;', '&Egrave;', '&egrave;', '&Oacute;', '&oacute;', '&Ocirc;', '&ocirc;', '&Ograve;', '&ograve;',
            '&Otilde;', '&otilde;', '&Iacute;', '&iacute;', '&Icirc;', '&icirc;', '&Igrave;', '&igrave;', '&Uacute;', '&uacute;',
            '&Ucirc;', '&ucirc;', '&Ugrave;', '&ugrave;', '&Ccedil;', '&ccedil;', '&lt;', '&gt;', '&ordm;');

        if (is_array($string)) {
            foreach ($string as $key => $value) {
                if (is_array($value)) {
                    FormataDados::htmlToString($value);
                } else {
                    if (!$invert) {
                        $ret[$key] = str_replace($html, $acento, $value);
                    } else {
                        $ret[$key] = str_replace($acento, $html, $value);
                    }
                }
            }
        } else {
            if (!$invert) {
                $ret = str_replace($html, $acento, $string);
            } else {
                $ret = str_replace($acento, $html, $string);
            }
        }
        return $ret;
    }

    public static function htmlToString($string) {
        return Format_String::converteString($string);
    }

    public static function stringToHtml($string) {
        return Format_String::converteString($string, true);
    }

    public static function jqueryParams($params) {
        $sep = '';
        $json = '{';
        foreach ($params as $key => $value) {
            if ($value != '') {
                if (is_array($value)) {
                    Format_String::jqueryParams($value);
                } else if (is_string($value) && $key != 'select' && $key != 'colModel' && $key != 'buttons') {
                    $json .= $sep . $key . ':"' . $value . '"';
                } else {
                    $json .= $sep . $key . ':' . $value;
                }
                $sep = ', ';
            }
        }
        $json .= '}';
        //print_r($json);die('<br><br>' .  __LINE__);
        return $json;
    }

    /**
     * Seta a primeira letra de uma string para maiúsculas
     *
     * @param	string	$str   string
     */
    static function toUpperFirstLetter($pStr) {
//        print'<pre>';die(print_r(  mb_detect_encoding($pStr) ));
//        print'<pre>';
//        (print_r(($pStr)));
        $pStr = self::strtolower_utf8($pStr);
//        print'<pre>';
//        die(print_r($pStr));
//        $pStr = ucfirst($pStr);
        $pStr = ucwords($pStr);
        return $pStr;
    }

    static function strtolower_utf8($inputString) {
        $outputString = utf8_decode($inputString);
        $outputString = strtolower($outputString);
        $outputString = utf8_encode($outputString);
        return $outputString;
    }

    /**
     * Here is the explaination
     *
     *     Strip HTML Tags
     *    Remove Break/Tabs/Return Carriage
     *   Remove Illegal Chars for folder and filename
     *  Put the string in lower case
     * Remove foreign accents such as Éàû by convert it into html entities and then remove the code and keep the letter.
     * Replace Spaces with dashes
     * Encode special chars that could pass the previous steps and enter in conflict filename on server. ex. "中文百强网"
     * Replace "%" with dashes to make sure the link of the file will not be rewritten by the browser when querying th file.
     * OK, some filename will not be releavant but in most case it will work.
     *
     * @param type $str
     * @return type
     */
    public static function normalizeString($str = '') {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);
        return $str;
    }

    /**
     * Seta um string para maiúsculas
     *
     * @param	string	$str   string
     */
    static function toUpper($str) {

        $str = strtoupper($str);
        $str = str_replace('á', "Á", $str);
        $str = str_replace('à', "À", $str);
        $str = str_replace('â', "Â", $str);
        $str = str_replace('ã', "Ã", $str);
        $str = str_replace('é', "É", $str);
        $str = str_replace('è', "È", $str);
        $str = str_replace('ê', "Ê", $str);
        $str = str_replace('í', "Í", $str);
        $str = str_replace('ì', "Ì", $str);
        $str = str_replace('ó', "Ó", $str);
        $str = str_replace('ò', "Ò", $str);
        $str = str_replace('ô', "Ô", $str);
        $str = str_replace('õ', "Õ", $str);
        $str = str_replace('ú', "Ú", $str);
        $str = str_replace('ù', "Ù", $str);
        $str = str_replace('û', "Û", $str);
        $str = str_replace('ç', "Ç", $str);
        return $str;
    }

    static function toLower($str) {

        $str = str_replace("Á", 'á', $str);
        $str = str_replace("À", 'à', $str);
        $str = str_replace("Â", 'â', $str);
        $str = str_replace("Ã", 'ã', $str);
        $str = str_replace("É", 'é', $str);
        $str = str_replace("È", 'è', $str);
        $str = str_replace("Ê", 'ê', $str);
        $str = str_replace("Í", 'í', $str);
        $str = str_replace("Ì", 'ì', $str);
        $str = str_replace("Ó", 'ó', $str);
        $str = str_replace("Ò", 'ò', $str);
        $str = str_replace("Ô", 'ô', $str);
        $str = str_replace("Õ", 'õ', $str);
        $str = str_replace("Ú", 'ú', $str);
        $str = str_replace("Ù", 'ù', $str);
        $str = str_replace("Û", 'û', $str);
        $str = str_replace("Ç", 'ç', $str);
//        $str = strtolower($str);
        return $str;
    }

    function fullLower($str) {
        // convert to entities
        $subject = htmlentities($str, ENT_QUOTES);
        $pattern = '/&([a-z])(uml|acute|circ';
        $pattern.= '|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
        $replace = "'&'.strtolower('\\1').'\\2'.';'";
        $result = preg_replace($pattern, $replace, $subject);
        // convert from entities back to characters
        $htmltable = get_html_translation_table(HTML_ENTITIES);
        foreach ($htmltable as $key => $value) {
            $result = ereg_replace(addslashes($value), $key, $result);
        }
        return(strtolower($result));
    }

    /**
     * Retira a acentuação
     *
     * @param	string	$str   string
     */
    static function tiraAcentos($str) {

        $str = str_replace('á', "a", $str);
        $str = str_replace('à', "a", $str);
        $str = str_replace('â', "a", $str);
        $str = str_replace('ã', "a", $str);
        $str = str_replace('é', "e", $str);
        $str = str_replace('è', "e", $str);
        $str = str_replace('ê', "e", $str);
        $str = str_replace('í', "i", $str);
        $str = str_replace('ì', "i", $str);
        $str = str_replace('ó', "o", $str);
        $str = str_replace('ò', "o", $str);
        $str = str_replace('ô', "o", $str);
        $str = str_replace('õ', "o", $str);
        $str = str_replace('ú', "u", $str);
        $str = str_replace('ù', "u", $str);
        $str = str_replace('û', "u", $str);

        $str = str_replace('Á', "A", $str);
        $str = str_replace('À', "A", $str);
        $str = str_replace('Â', "A", $str);
        $str = str_replace('Ã', "A", $str);
        $str = str_replace('É', "E", $str);
        $str = str_replace('È', "E", $str);
        $str = str_replace('Ê', "E", $str);
        $str = str_replace('Í', "I", $str);
        $str = str_replace('Ì', "I", $str);
        $str = str_replace('Ó', "O", $str);
        $str = str_replace('Ò', "O", $str);
        $str = str_replace('Ô', "O", $str);
        $str = str_replace('Õ', "O", $str);
        $str = str_replace('Ú', "U", $str);
        $str = str_replace('Ù', "U", $str);
        $str = str_replace('Û', "U", $str);

        $str = str_replace('Ç', "C", $str);
        $str = str_replace('ç', "c", $str);

        $str = str_replace('ñ', "n", $str);
        $str = str_replace('Ñ', "N", $str);

        $str = str_replace('º', "", $str);
        $str = str_replace('°', "", $str);
        $str = str_replace('ª', "", $str);

        $str = str_replace('Ý', "Y", $str);
        $str = str_replace('ý', "y", $str);


        return $str;
    }

    /**
     * Retira a acentuação
     *
     * @param	string	$str   string
     */
    function acentosToHtmlEntites($str) {

        $lTexto = $str;

        $lTexto = str_replace('á', '&aacute;', $lTexto);
        $lTexto = str_replace('é', '&eacute;', $lTexto);
        $lTexto = str_replace('í', '&iacute;', $lTexto);
        $lTexto = str_replace('ó', '&oacute;', $lTexto);
        $lTexto = str_replace('ú', '&uacute;', $lTexto);
        $lTexto = str_replace('ý', '&yacute;', $lTexto);
        $lTexto = str_replace('Á', '&Aacute;', $lTexto);
        $lTexto = str_replace('É', '&Eacute;', $lTexto);
        $lTexto = str_replace('Í', '&Iacute;', $lTexto);
        $lTexto = str_replace('Ó', '&Oacute;', $lTexto);
        $lTexto = str_replace('Ú', '&Uacute;', $lTexto);
        $lTexto = str_replace('Ý', '&Yacute;', $lTexto);

        $lTexto = str_replace('â', '&acirc;', $lTexto);
        $lTexto = str_replace('ê', '&ecirc;', $lTexto);
        $lTexto = str_replace('î', '&icirc;', $lTexto);
        $lTexto = str_replace('ô', '&ocirc;', $lTexto);
        $lTexto = str_replace('û', '&ucirc;', $lTexto);
        $lTexto = str_replace('Â', '&Acirc;', $lTexto);
        $lTexto = str_replace('Ê', '&Ecirc;', $lTexto);
        $lTexto = str_replace('Î', '&Icirc;', $lTexto);
        $lTexto = str_replace('Ô', '&Ocirc;', $lTexto);
        $lTexto = str_replace('Û', '&Ucirc;', $lTexto);

        $lTexto = str_replace('à', '&agrave;', $lTexto);
        $lTexto = str_replace('è', '&egrave;', $lTexto);
        $lTexto = str_replace('ì', '&igrave;', $lTexto);
        $lTexto = str_replace('ò', '&ograve;', $lTexto);
        $lTexto = str_replace('ù', '&ugrave;', $lTexto);
        $lTexto = str_replace('À', '&Agrave;', $lTexto);
        $lTexto = str_replace('È', '&Egrave;', $lTexto);
        $lTexto = str_replace('Ì', '&Igrave;', $lTexto);
        $lTexto = str_replace('Ò', '&Ograve;', $lTexto);
        $lTexto = str_replace('Ù', '&Ugrave;', $lTexto);

        $lTexto = str_replace('ä', '&auml;', $lTexto);
        $lTexto = str_replace('ë', '&euml;', $lTexto);
        $lTexto = str_replace('ï', '&iuml;', $lTexto);
        $lTexto = str_replace('ö', '&ouml;', $lTexto);
        $lTexto = str_replace('ü', '&uuml;', $lTexto);
        $lTexto = str_replace('ÿ', '&yuml;', $lTexto);
        $lTexto = str_replace('Ä', '&Auml;', $lTexto);
        $lTexto = str_replace('Ë', '&Euml;', $lTexto);
        $lTexto = str_replace('Ï', '&Iuml;', $lTexto);
        $lTexto = str_replace('Ö', '&Ouml;', $lTexto);
        $lTexto = str_replace('Ü', '&Uuml;', $lTexto);


        $lTexto = str_replace('ã', '&atilde;', $lTexto);
        $lTexto = str_replace('õ', '&otilde;', $lTexto);
        $lTexto = str_replace('ñ', '&ntilde;', $lTexto);
        $lTexto = str_replace('Ã', '&Atilde;', $lTexto);
        $lTexto = str_replace('Õ', '&Otilde;', $lTexto);
        $lTexto = str_replace('Ñ', '&Ntilde;', $lTexto);

        $lTexto = str_replace('ç', '&ccedil;', $lTexto);
        $lTexto = str_replace('Ç', '&Ccedil;', $lTexto);

        $lTexto = str_replace('²', '&sup2;', $lTexto);
        $lTexto = str_replace('°', '&deg;', $lTexto);
        $lTexto = str_replace('º', '&ordm;', $lTexto);
        $lTexto = str_replace('¡', '&iexcl;;', $lTexto);
        $lTexto = str_replace('¢', '&cent;', $lTexto);
        $lTexto = str_replace('£', '&pound;', $lTexto);
        $lTexto = str_replace('¤', '&curren;', $lTexto);
        $lTexto = str_replace('¥', '&yen;', $lTexto);
        $lTexto = str_replace('§', '&sect;', $lTexto);
        $lTexto = str_replace('¨', '&uml;', $lTexto);
        $lTexto = str_replace('©', '&copy;', $lTexto);
        $lTexto = str_replace('ª', '&ordf;', $lTexto);
        $lTexto = str_replace('«', '&laquo;', $lTexto);
        $lTexto = str_replace('»', '&raquo;', $lTexto);
        $lTexto = str_replace('¬', '&not;', $lTexto);
        $lTexto = str_replace('­', '&shy;', $lTexto);
        $lTexto = str_replace('®', '&reg;', $lTexto);
        $lTexto = str_replace('¯', '&macr;', $lTexto);
        $lTexto = str_replace('±', '&plusmn;', $lTexto);
        $lTexto = str_replace('²', '&sup2;', $lTexto);
        $lTexto = str_replace('³', '&sup3;', $lTexto);
        $lTexto = str_replace('´', '&acute;', $lTexto);
        $lTexto = str_replace('µ', '&micro;', $lTexto);
        $lTexto = str_replace('¶', '&para;', $lTexto);
        $lTexto = str_replace('·', '&middot;', $lTexto);

        $lTexto = str_replace('¸', '&cedil;', $lTexto);
        $lTexto = str_replace('¹', '&sup1;', $lTexto);
        $lTexto = str_replace('¼', '&frac14;', $lTexto);
        $lTexto = str_replace('½', '&frac12;', $lTexto);

        $lTexto = str_replace('¿', '&iquest;', $lTexto);
        $lTexto = str_replace('Æ', '&AElig;', $lTexto);
        $lTexto = str_replace('Ð', '&ETH;', $lTexto);
        $lTexto = str_replace('×', '&times;', $lTexto);
        $lTexto = str_replace('Ø', '&Oslash;', $lTexto);
        $lTexto = str_replace('Þ', 'THORN&;', $lTexto);
        $lTexto = str_replace('ß', '&szlig;', $lTexto);
        $lTexto = str_replace('å', '&aring;', $lTexto);
        $lTexto = str_replace('æ', '&aelig;', $lTexto);
        $lTexto = str_replace('ð', '&eth;', $lTexto);
        $lTexto = str_replace('÷', '&divide;', $lTexto);
        $lTexto = str_replace('ø', '&oslash;', $lTexto);
        $lTexto = str_replace('þ', '&thorn;', $lTexto);


        return $lTexto;

        /*

          Description                               Code            Entity name
          ===================================       ============    ==============
          quotation mark                            &#34;  --> "    &quot;   --> "
          ampersand                                 &#38;  --> &    &amp;    --> &
          less-than sign                            &#60;  --> <    &lt;     --> <
          greater-than sign                         &#62;  --> >    &gt;     --> >

          Description                          Char Code            Entity name
          ===================================  ==== ============    ==============
          non-breaking space                        &#160; -->      &nbsp;   -->
          inverted exclamation                 ¡    &#161; --> ¡    &iexcl;  --> ¡
          cent sign                            ¢    &#162; --> ¢    &cent;   --> ¢
          pound sterling                       £    &#163; --> £    &pound;  --> £
          general currency sign                ¤    &#164; --> ¤    &curren; --> ¤
          yen sign                             ¥    &#165; --> ¥    &yen;    --> ¥
          broken vertical bar                  ¦    &#166; --> ¦    &brvbar; --> ¦
          &brkbar; --> &brkbar;
          section sign                         §    &#167; --> §    &sect;   --> §
          umlaut (dieresis)                    ¨    &#168; --> ¨    &uml;    --> ¨
          &die;    --> &die;
          copyright                            ©    &#169; --> ©    &copy;   --> ©
          feminine ordinal                     ª    &#170; --> ª    &ordf;   --> ª
          left angle quote, guillemotleft      «    &#171; --> «    &laquo;  --> «
          not sign                             ¬    &#172; --> ¬    &not;    --> ¬
          soft hyphen                          ­    &#173; --> ­    &shy;    --> ­
          registered trademark                 ®    &#174; --> ®    &reg;    --> ®
          macron accent                        ¯    &#175; --> ¯    &macr;   --> ¯
          &hibar;  --> &hibar;
          degree sign                          °    &#176; --> °    &deg;    --> °
          plus or minus                        ±    &#177; --> ±    &plusmn; --> ±
          superscript two                      ²    &#178; --> ²    &sup2;   --> ²
          superscript three                    ³    &#179; --> ³    &sup3;   --> ³
          acute accent                         ´    &#180; --> ´    &acute;  --> ´
          micro sign                           µ    &#181; --> µ    &micro;  --> µ
          paragraph sign                       ¶    &#182; --> ¶    &para;   --> ¶
          middle dot                           ·    &#183; --> ·    &middot; --> ·
          cedilla                              ¸    &#184; --> ¸    &cedil;  --> ¸
          superscript one                      ¹    &#185; --> ¹    &sup1;   --> ¹
          masculine ordinal                    º    &#186; --> º    &ordm;   --> º
          right angle quote, guillemotright    »    &#187; --> »    &raquo;  --> »
          fraction one-fourth                  ¼    &#188; --> ¼    &frac14; --> ¼
          fraction one-half                    ½    &#189; --> ½    &frac12; --> ½
          fraction three-fourths               ¾    &#190; --> ¾    &frac34; --> ¾
          inverted question mark               ¿    &#191; --> ¿    &iquest; --> ¿
          capital A, grave accent              À    &#192; --> À    &Agrave; --> À
          capital A, acute accent              Á    &#193; --> Á    &Aacute; --> Á
          capital A, circumflex accent         Â    &#194; --> Â    &Acirc;  --> Â
          capital A, tilde                     Ã    &#195; --> Ã    &Atilde; --> Ã
          capital A, dieresis or umlaut mark   Ä    &#196; --> Ä    &Auml;   --> Ä
          capital A, ring                      Å    &#197; --> Å    &Aring;  --> Å
          capital AE diphthong (ligature)      Æ    &#198; --> Æ    &AElig;  --> Æ
          capital C, cedilla                   Ç    &#199; --> Ç    &Ccedil; --> Ç
          capital E, grave accent              È    &#200; --> È    &Egrave; --> È
          capital E, acute accent              É    &#201; --> É    &Eacute; --> É
          capital E, circumflex accent         Ê    &#202; --> Ê    &Ecirc;  --> Ê
          capital E, dieresis or umlaut mark   Ë    &#203; --> Ë    &Euml;   --> Ë
          capital I, grave accent              Ì    &#204; --> Ì    &Igrave; --> Ì
          capital I, acute accent              Í    &#205; --> Í    &Iacute; --> Í
          capital I, circumflex accent         Î    &#206; --> Î    &Icirc;  --> Î
          capital I, dieresis or umlaut mark   Ï    &#207; --> Ï    &Iuml;   --> Ï
          capital Eth, Icelandic               Ð    &#208; --> Ð    &ETH;    --> Ð
          &Dstrok; --> &Dstrok;
          capital N, tilde                     Ñ    &#209; --> Ñ    &Ntilde; --> Ñ
          capital O, grave accent              Ò    &#210; --> Ò    &Ograve; --> Ò
          capital O, acute accent              Ó    &#211; --> Ó    &Oacute; --> Ó
          capital O, circumflex accent         Ô    &#212; --> Ô    &Ocirc;  --> Ô
          capital O, tilde                     Õ    &#213; --> Õ    &Otilde; --> Õ
          capital O, dieresis or umlaut mark   Ö    &#214; --> Ö    &Ouml;   --> Ö
          multiply sign                        ×    &#215; --> ×    &times;  --> ×
          capital O, slash                     Ø    &#216; --> Ø    &Oslash; --> Ø
          capital U, grave accent              Ù    &#217; --> Ù    &Ugrave; --> Ù
          capital U, acute accent              Ú    &#218; --> Ú    &Uacute; --> Ú
          capital U, circumflex accent         Û    &#219; --> Û    &Ucirc;  --> Û
          capital U, dieresis or umlaut mark   Ü    &#220; --> Ü    &Uuml;   --> Ü
          capital Y, acute accent              Ý    &#221; --> Ý    &Yacute; --> Ý
          capital THORN, Icelandic             Þ    &#222; --> Þ    &THORN;  --> Þ
          small sharp s, German (sz ligature)  ß    &#223; --> ß    &szlig;  --> ß
          small a, grave accent                à    &#224; --> à    &agrave; --> à
          small a, acute accent                á    &#225; --> á    &aacute; --> á
          small a, circumflex accent           â    &#226; --> â    &acirc;  --> â
          small a, tilde                       ã    &#227; --> ã    &atilde; --> ã
          small a, dieresis or umlaut mark     ä    &#228; --> ä    &auml;   --> ä
          small a, ring                        å    &#229; --> å    &aring;  --> å
          small ae diphthong (ligature)        æ    &#230; --> æ    &aelig;  --> æ
          small c, cedilla                     ç    &#231; --> ç    &ccedil; --> ç
          small e, grave accent                è    &#232; --> è    &egrave; --> è
          small e, acute accent                é    &#233; --> é    &eacute; --> é
          small e, circumflex accent           ê    &#234; --> ê    &ecirc;  --> ê
          small e, dieresis or umlaut mark     ë    &#235; --> ë    &euml;   --> ë
          small i, grave accent                ì    &#236; --> ì    &igrave; --> ì
          small i, acute accent                í    &#237; --> í    &iacute; --> í
          small i, circumflex accent           î    &#238; --> î    &icirc;  --> î
          small i, dieresis or umlaut mark     ï    &#239; --> ï    &iuml;   --> ï
          small eth, Icelandic                 ð    &#240; --> ð    &eth;    --> ð
          small n, tilde                       ñ    &#241; --> ñ    &ntilde; --> ñ
          small o, grave accent                ò    &#242; --> ò    &ograve; --> ò
          small o, acute accent                ó    &#243; --> ó    &oacute; --> ó
          small o, circumflex accent           ô    &#244; --> ô    &ocirc;  --> ô
          small o, tilde                       õ    &#245; --> õ    &otilde; --> õ
          small o, dieresis or umlaut mark     ö    &#246; --> ö    &ouml;   --> ö
          division sign                        ÷    &#247; --> ÷    &divide; --> ÷
          small o, slash                       ø    &#248; --> ø    &oslash; --> ø
          small u, grave accent                ù    &#249; --> ù    &ugrave; --> ù
          small u, acute accent                ú    &#250; --> ú    &uacute; --> ú
          small u, circumflex accent           û    &#251; --> û    &ucirc;  --> û
          small u, dieresis or umlaut mark     ü    &#252; --> ü    &uuml;   --> ü
          small y, acute accent                ý    &#253; --> ý    &yacute; --> ý
          small thorn, Icelandic               þ    &#254; --> þ    &thorn;  --> þ
          small y, dieresis or umlaut mark     ÿ    &#255; --> ÿ    &yuml;   --> ÿ

         */
    }

    /**
     * Seta um float para string
     *
     * @param	string	$v   valor
     * @param	string	$decimal   . ou ,
     */
    function floatToStr($v, $decimal = '.') {

        //procura a posição do separador de decimais
        $dec = strpos($v, $decimal);

        if ($dec) {

            if ($decimal == ',') {
                $v = str_replace('.', '', $v);
                $v = str_replace(',', '.', $v);
            } else
                $v = str_replace('.', ',', $v);
        }else {
            if ($decimal == '.')
                $v = str_replace('.', '', $v);
            else
                $v = str_replace(',', '', $v);
        }

        return $v;
    }

    /**
     *
     */
    function strToFloat($str) {

        $str = str_replace(',', '.', $str);

        return (double) $str;
    }

    /**
     *
     */
    function strToFloatBD($str) {

        $posPonto = strpos($str, '.');
        $posVirg = strpos($str, ',');

        //Se tem . e virg, descobre se ponto
        if (($posPonto != 0) && ($posVirg != 0))
            $str = str_replace('.', '', $str);


        $str = str_replace('.', ',', $str);

        $vl = explode(',', $str);
        if (count($vl) > 1) {

            $inteiro = $vl[0];
            $frac = $vl[1];
            if (strlen($frac) == 1)
                $frac = $frac . '0';

            return $inteiro . '.' . $frac;
        }else {
            return $vl[0] . '.' . '00';
        }
    }

    /**
     * Tratamento da Apostrofo na string
     *
     * @param	string	$v   valor
     * @param	string	$decimal   . ou ,
     */
    function trataApostrofo($texto) {

        return str_replace("'", "''", $texto);
    }

    //setlocale (LC_ALL, 'pt_BR');

    /**
      /**
     * Formata um numero conforme parametros
     * @param String $pValor - val
     * @param type $pSeparaMilhar
     * @param type $pNumCasas
     * @param type $pArredonda
     * @return type
     */
    function toFormattedFloat2($pValor, $pSeparaMilhar = false, $pNumCasas = 2, $pArredonda = false) {



//                print($pValor.' - ');
        if (!$pValor)
            return '0,00';

        $pValor = str_replace(',', '.', $pValor);
//                  print $pValor.'<br>';
        if ($pArredonda == true) {
            $pValor = ceil($pValor);
        }
//die($pValor);
        if ($pSeparaMilhar == true)
            return number_format($pValor, $pNumCasas, ',', '.');
        else
            return number_format($pValor, $pNumCasas, ',', '');



//		$lArr = explode( '.', $pValor);
//		if(count($lArr)<2)
//			$lArr = explode( ',', $pValor);
//
//		$lDec = $lArr[0];
//		$lFrac = substr( $lArr[1],0,2);
//
//                if($pSeparaMilhar == true ){
//
//                    $lTamanho = strlen($lDec);
//                    $lModulo = $lTamanho%3;
//                    $lDecMilhar[0] = substr( $lDec,0,$lModulo);
//
//                    for($i=$lModulo;$i<$lTamanho;$i+=3){
//
//                        $lDecMilhar[$i] = substr( $lDec,$i,3);
//
//                    }
//                    $lDec = implode('.',$lDecMilhar);
//
//                }
//
//
//		if( intval( $lFrac ) < 10)
//			return $lDec . ',0' . intval( $lFrac ) ;
//		else
//			return $lDec . ',' . intval( $lFrac );
    }

    /**
     *  31-07-09
     *  Função criada apenas para o Ismael usar para montar as tabelas pro site
     *
     * @param <type> Numeric
     * @param <type> True/False
     * @return <type> Number(float)
     */
    function toFormattedFloat22($pValor, $pSeparaMilhar = false) {

        if (!$pValor)
            return '0';

        $lArr = explode('.', $pValor);
        if (count($lArr) < 2)
            $lArr = explode(',', $pValor);

        $lDec = $lArr[0];
        $lFrac = substr($lArr[1], 0, 2);

        if ($pSeparaMilhar == true) {

            $lTamanho = strlen($lDec);
            $lModulo = $lTamanho % 3;
            $lDecMilhar[0] = substr($lDec, 0, $lModulo);

            for ($i = $lModulo; $i < $lTamanho; $i+=3) {

                $lDecMilhar[$i] = substr($lDec, $i, 3);
            }
            $lDec = implode('.', $lDecMilhar);
        }


        if (intval($lFrac) < 10)
            return $lDec;
        else
            return $lDec;
    }

    /*

      if (!function_exists('money_format')) {
      function money_format($format, $number)
      {
      $regex  = array(
      '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?(?:#([0-9]+))?',
      '(?:\.([0-9]+))?([in%])/'
      );
      $regex = implode('', $regex);
      if (setlocale(LC_MONETARY, null) == '') {
      setlocale(LC_MONETARY, '');
      }
      $locale = localeconv();
      $number = floatval($number);
      if (!preg_match($regex, $format, $fmatch)) {
      trigger_error("No format specified or invalid format",
      E_USER_WARNING);
      return $number;
      }
      $flags = array(
      'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
      $match[1] : ' ',
      'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
      'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
      $match[0] : '+',
      'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
      'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
      );
      $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
      $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
      $right      = trim($fmatch[4]) ? (int)$fmatch[4] :
      $locale['int_frac_digits'];
      $conversion = $fmatch[5];
      $positive = true;
      if ($number < 0) {
      $positive = false;
      $number  *= -1;
      }
      $letter = $positive ? 'p' : 'n';
      $prefix = $suffix = $cprefix = $csuffix = $signal = '';
      if (!$positive) {
      $signal = $locale['negative_sign'];
      switch (true) {
      case $locale['n_sign_posn'] == 0 || $flags['signal'] ==
      '(':
      $prefix = '(';
      $suffix = ')';
      break;
      case $locale['n_sign_posn'] == 1:
      $prefix = $signal;
      break;
      case $locale['n_sign_posn'] == 2:
      $suffix = $signal;
      break;
      case $locale['n_sign_posn'] == 3:
      $cprefix = $signal;
      break;
      case $locale['n_sign_posn'] == 4:
      $csuffix = $signal;
      break;
      }
      }
      if (!$flags['nosimbol']) {
      $currency  = $cprefix;
      $currency .= (
      $conversion == 'i' ?
      $locale['int_curr_symbol'] :
      $locale['currency_symbol']
      );
      $currency .= $csuffix;
      } else {
      $currency = '';
      }
      $space    = $locale["{$letter}_sep_by_space"] ? ' ' : '';

      $number = number_format($number, $right,
      $locale['mon_decimal_point'],
      $flags['nogroup'] ? '' :
      $locale['mon_thousands_sep']
      );
      $number = explode($locale['mon_decimal_point'], $number);

      $n = strlen($prefix) + strlen($currency);
      if ($left > 0 && $left > $n) {
      if ($flags['isleft']) {
      $number[0] .= str_repeat($flags['fillchar'], $left - $n);
      } else {
      $number[0] = str_repeat($flags['fillchar'], $left - $n) .
      $number[0];
      }
      }
      $number = implode($locale['mon_decimal_point'], $number);
      if ($locale["{$letter}_cs_precedes"]) {
      $number = $prefix . $currency . $space . $number . $suffix;
      } else {
      $number = $prefix . $number . $space . $currency . $suffix;
      }
      if ($width > 0) {
      $number = str_pad($number, $width, $flags['fillchar'],
      $flags['isleft'] ? STR_PAD_RIGHT : STR_PAD_LEFT);
      }
      $format = str_replace($fmatch[0], $number, $format);
      return $format;
      }
      }

     */

    //Function to seperate multiple tags one line
    /**
     *
     * @param type $fixthistext
     * @return type
     */
    function fix_newlines_for_clean_html($fixthistext) {
        $fixthistext_array = explode("\n", $fixthistext);
        foreach ($fixthistext_array as $unfixedtextkey => $unfixedtextvalue) {
            //Makes sure empty lines are ignores
            if (!preg_match("/^(\s)*$/", $unfixedtextvalue)) {
                $fixedtextvalue = preg_replace("/>(\s|\t)*</U", ">\n<", $unfixedtextvalue);
                $fixedtext_array[$unfixedtextkey] = $fixedtextvalue;
            }
        }
        return implode("\n", $fixedtext_array);
    }

    /**
     *
     * @param type $uncleanhtml
     * @return String
     */
    function cleanHtmlCode($uncleanhtml) {
        //Set wanted indentation
        $indent = "    ";


        //Uses previous function to seperate tags
        $fixed_uncleanhtml = String::fix_newlines_for_clean_html($uncleanhtml);
        $uncleanhtml_array = explode("\n", $fixed_uncleanhtml);
        //Sets no indentation
        $indentlevel = 0;
        foreach ($uncleanhtml_array as $uncleanhtml_key => $currentuncleanhtml) {
            //Removes all indentation
            $currentuncleanhtml = preg_replace("/\t+/", "", $currentuncleanhtml);
            $currentuncleanhtml = preg_replace("/^\s+/", "", $currentuncleanhtml);

            $replaceindent = "";

            //Sets the indentation from current indentlevel
            for ($o = 0; $o < $indentlevel; $o++) {
                $replaceindent .= $indent;
            }

            //If self-closing tag, simply apply indent
            if (preg_match("/<(.+)\/>/", $currentuncleanhtml)) {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
            }
            //If doctype declaration, simply apply indent
            else if (preg_match("/<!(.*)>/", $currentuncleanhtml)) {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
            }
            //If opening AND closing tag on same line, simply apply indent
            else if (preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && preg_match("/<\/(.*)>/", $currentuncleanhtml)) {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
            }
            //If closing HTML tag or closing JavaScript clams, decrease indentation and then apply the new level
            else if (preg_match("/<\/(.*)>/", $currentuncleanhtml) || preg_match("/^(\s|\t)*\}{1}(\s|\t)*$/", $currentuncleanhtml)) {
                $indentlevel--;
                $replaceindent = "";
                for ($o = 0; $o < $indentlevel; $o++) {
                    $replaceindent .= $indent;
                }

                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
            }
            //If opening HTML tag AND not a stand-alone tag, or opening JavaScript clams, increase indentation and then apply new level
            else if ((preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && !preg_match("/<(link|meta|base|br|img|hr)(.*)>/", $currentuncleanhtml)) || preg_match("/^(\s|\t)*\{{1}(\s|\t)*$/", $currentuncleanhtml)) {
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;

                $indentlevel++;
                $replaceindent = "";
                for ($o = 0; $o < $indentlevel; $o++) {
                    $replaceindent .= $indent;
                }
            } else {
                //Else, only apply indentation
                $cleanhtml_array[$uncleanhtml_key] = $replaceindent . $currentuncleanhtml;
            }
        }
        //Return single string seperated by newline
        return implode("\n", $cleanhtml_array);
    }

    //devolve todas as tags html de um texto...
    function strip_tags_content($text, $tags = '', $invert = FALSE) {

        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if (is_array($tags) AND count($tags) > 0) {
            if ($invert == FALSE) {
                return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            } else {
                return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
            }
        } elseif ($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

//devolve o texto sem as tags html
    function html2txt($document) {
        $search = array('@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
        );
        $text = preg_replace($search, '', $document);
        return $text;
    }

}
