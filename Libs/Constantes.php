<?php

define('APPLICATION_NAME', basename(getcwd()));
define('PATH_SCRIPTS', '/' . (BASE != '' ? BASE . '/' : '') . 'Libs/Scripts/');
define('PATH_IMAGES', '/' . (BASE != '' ? BASE . '/' : '') . 'Libs/Images/');
define('PATH_PUBLIC', '/' . (BASE != '' ? BASE . '/' : '') . APPLICATION_NAME . '/Public/');
define('PATH_MENU_IMG', PATH_PUBLIC . 'Images/menu-icons/');
/**
 * EX: <code>http://localhost/sinigaglia/site/</code> <br><br>
 * termina com uma barra!
 */
define('BASE_URL', '/' . (BASE != '' ? BASE . '/' : '') . APPLICATION_NAME . '/');

define('cTRUE', 'S');
define('cFALSE', 'N');


define('cCREATE', '1');
define('cUPDATE', '2');
define('cDELETE', '3');

######## Constantes dos Logs ########
define('cLOG_PAGINA_NAO_ENCONTRADA', '1');
define('cLOG_ACESSO_NEGADO', '2');
define('cLOG_SQL', '3');
define('cLOG_ERROR', '4');
define('cLOG_CAMPOS', '5');
define('cLOG_DELETE', '6');
define('cLOG_INSERT', '7');

define('cLOG_ACAO_INSERT', '1');
define('cLOG_ACAO_UPDATE', '2');
define('cLOG_ACAO_DELETE', '3');
#####################################

