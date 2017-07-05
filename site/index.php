<?php

//phpinfo();
/**
 * Arquivo principal da aplica��o
 * Define todos os caminhos onde os arquivos est?o armazenados,
 * todos os includes necess�rios e todos os componentes que a
 * aplicao utilizar�.
 * Respons?vel por inicializar a aplica��o, ele invoca os
 * arquivos de controlador que s?o respons�veis pelo funcionamento
 * da aplica��o.
 * 
 * @author			Ismael Sleifer
 * @author			Leonardo Danieli <leonardo@4coffee.com.br>
 * @copyright		Work 4Coffee
 * @package			zendframework
 * @subpackage		zendframework.system
 * @version			15.05.2015
 */
//ini_set("display_errors", 1);
//ini_set('error_reporting', E_ALL ^ E_NOTICE | E_STRICT);
//ini_set('error_reporting', E_ALL);
// ====  Configura��es iniciais do sistema =====
switch ($_SERVER['HTTP_HOST']) {

    case 'localhost':
        error_reporting(E_ALL ^ E_NOTICE | E_STRICT);
        $dbconfig = 'local';
        define('BASE', "travelappphp"); // BASE the path to the site's root folder (Ex.: na locaweb e o "public_htm", mas o caminho fica sem o "public_html")
        break;

    case '172.0.0.5:8080': // Production
//        error_reporting(0);
        error_reporting(E_ERROR);
//        error_reporting(E_ALL ^ E_NOTICE | E_STRICT);
        $dbconfig = 'producao';
        define('BASE', ""); // BASE the path to the site's root folder (Ex.: na locaweb e o "public_htm", mas o caminho fica sem o "public_html")
        break;
}
date_default_timezone_set('America/Sao_Paulo');

define('HTTP_HOST', 'http://' . $_SERVER['HTTP_HOST']);

/*  aqui s�o feitas as verifica��es de sistema operacional para saber qual barra ('\'ou '/') usar 
 * e qual separador (':' ou ';') dos paths para o set_include_path() */
$operatingSystem = stripos($_SERVER['SERVER_SOFTWARE'], 'win32') !== FALSE ? 'WINDOWS' : 'LINUX';
$bar = $operatingSystem == 'WINDOWS' ? '\\' : '/';
$pathSeparator = $operatingSystem == 'WINDOWS' ? ';' : ':';
$documentRoot = $operatingSystem == 'WINDOWS' ? str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT'];

define('RAIZ_DIRETORY', $documentRoot . $bar . (BASE != '' ? BASE . $bar : ''));
$applicationName = basename(getcwd()) . $bar;
if ($operatingSystem == 'WINDOWS') {
    $path = $pathSeparator . RAIZ_DIRETORY . 'Libs';
    $path .= $pathSeparator . RAIZ_DIRETORY . $applicationName . 'Application' . $bar . 'Models';
    $path .= $pathSeparator . RAIZ_DIRETORY . $applicationName . 'Application' . $bar . 'ModelsView';
} else {
    $path = $pathSeparator . RAIZ_DIRETORY . 'Libs';
    $path .= $pathSeparator . RAIZ_DIRETORY . $applicationName . 'Application' . $bar . 'Models';
    $path .= $pathSeparator . RAIZ_DIRETORY . $applicationName . 'Application' . $bar . 'ModelsView';
}
set_include_path(get_include_path() . $path);

//print '<pre>';
//die(print_r(get_include_path() ));
//require_once('Constantes.php');
require_once RAIZ_DIRETORY . 'Libs/Constantes.php';
require_once 'Constantes.php';
require_once RAIZ_DIRETORY . $applicationName . 'Application/Constantes.php';
//include RAIZ_DIRETORY . $applicationName . 'Application/Models/Log.php';
//die(print_r(RAIZ_DIRETORY .  $applicationName . 'Application/Models/Log.php' ));
//include RAIZ_DIRETORY . $applicationName . 'Application/Models/Config.php';

require_once('Zend/Loader/Autoloader.php');
require_once RAIZ_DIRETORY . 'Libs/Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
include_once 'Application/Models/Config.php';
include_once 'Application/Models/Log.php';

Zend_Registry::set('js', array());
Zend_Registry::set('css', array());


Zend_Session::setOptions(['hash_bits_per_character' => 5]);
/* coloca numa lista a URL */
$array1 = explode('/', $_SERVER['REQUEST_URI']);
$array = array();
foreach ($array1 as $value) {
    if ($value != 'index.php')
        array_push($array, $value);
}
$_SERVER['REQUEST_URI'] = implode('/', $array);

if (BASE != '') {
    $pos = count(explode('/', BASE));
} else {
    $pos = 0;
}

$post = null;
if (count($_POST) > 0) {
    $post = $_POST;
}
if (count($_FILES) > 0) {
    if (count($_POST) > 0) {
        $post = array_merge($post, $_FILES);
    } else {
        $post = $_FILES;
    }
}
//print'<pre>';
//die(print_r($array));
//die(print_r(  "{$array[4 + $pos]} != NULL"));

/* tudo que tiver depois do endere�o padrao � parametro. */
//if (count($array) > (5 + $pos)) {
if (isset($array[4 + $pos])) {
    for ($i = (4 + $pos); $i < count($array); $i++) {
        $post[$array[$i]] = rawurldecode($array[++$i]);
    }
}

//print'<pre>';die(print_r( $post )  );

Zend_Registry::set('post', new Zend_Filter_Input(NULL, NULL, $post));
Zend_Registry::set('get', new Zend_Filter_Input(NULL, NULL, $_GET));

/** Configur��es das vis�es */
$view = new View_Smarty();
$view->setEncoding('UTF-8');
$view->setEscape('htmlentities');
$view->addHelperPath('../Libs/View/Helpers');
$view->assign('baseUrl', BASE_URL);

/**
 * HTTP_REFERER eh o endereco web do site ou sistema mais a URL base que eh a pasta dentro do servidor em q se encontra os site ou sistema.
 * usado para criar links no html ou tpl 
 */
define('HTTP_REFERER', HTTP_HOST . BASE_URL);
define('HTTP_LIBS', HTTP_HOST . '/' . BASE . '/Libs');
$view->assign('HTTP_REFERER', HTTP_REFERER);
$view->assign('PATH_IMAGES', PATH_IMAGES);
$view->assign('HTTP_LIBS', HTTP_LIBS);
$view->assign('HTTP_HOST', HTTP_HOST);

$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
$viewRenderer->setNeverRender(); // desabilita todas as renderiza��es das paginas
$viewRenderer->setView($view);
Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

$view->setTemplateDir($applicationName);
Zend_Registry::set('view', $view);

Zend_Session::start();

Zend_Registry::set('session', new Zend_Session_Namespace());

$baseUrl = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], '/index'));

$frontController = Zend_Controller_Front::getInstance();

$frontController->setbaseUrl($baseUrl);

$frontController->throwExceptions(TRUE);

$config = new Zend_Config_Ini('./Application/Config.ini', $dbconfig);

Zend_Registry::set('config', $config);

$db = Zend_Db::factory($config->db->adapter, $config->db->config->toArray());
Zend_Db_Table_Abstract::setDefaultAdapter($db);

###############  SOMENTE USAR EM AMBIENTE DE DESENVOLVIMENTO  #####################
//$profiler = new Zend_Db_Profiler_Firebug('SQL');
//$profiler = new Zend_Db_Profiler;
//$profiler->setEnabled(true);
//$db->setProfiler($profiler);
###################################################################################

Zend_Registry::set('db', $db);


############################ SEGURAN�A DO SISTEMA #########################
//print'<pre>';(print_r($array ));
//$controller = $array[3];
//$act = $array[4];
if (isset($array[2 + $pos])) {
    $controller = $array[$pos + 2];
}
if (isset($array[3 + $pos])) {
    $act = $array[$pos + 3];
}
//print ("\$controller = \$array[$pos+3]: $controller; <br>\$act = \$array[$pos+4]:$act;");
//die("<br>\$controller: $controller <br> \$act: $act");


$session = Zend_Registry::get('session');

if ($controller == '') {
    $controller = 'webindex';
}

if (($act == '')) {
    $act = 'index';
}


Zend_Registry::set('controller', $controller);
//  print'<pre>';die(print_r($controller ));
Zend_Registry::set('act', $act);

$web = substr($controller, 0, 3);
//print'<pre>';die(print_r($web ));
if (strcasecmp($web, 'web') != 0) {
    $flag = true;
    $frontController->setControllerDirectory('./Application/Controllers');
} else {
    $flag = false;
    $frontController->setControllerDirectory('./Application/ControllersWeb');
}

//die("$controller == 'Arquivo' && $act == 'upload'");
// usando pois quando e feito o upload com o componente em flash da erro 302
if ($controller == 'Arquivo' && $act == 'upload') {
    $flag = false;
}

function setBrowserUrl($ctrl, $array, $pos = 0) {
    $html = "<script type='text/javascript'>";
    if (strpos($ctrl, 'http://') !== false) {
        $html .= "window.parent.location = '" . $ctrl . "';";
    } else {
        if (count($array) <= 4 + $pos) {
            $html .= "window.parent.location = './" . $ctrl . "';";
        } else {
            for ($i = 4; $i < count($array); $i++) {
                $pontos .= '../';
            }
            $html .= "window.parent.location = '" . $pontos . $ctrl . "';";
        }
    }
    $html .= "</script>";
//    print'<pre>';
//    die(print_r('$html'));
    return $html;
}

//unset($session->usuario);
if ($flag) {
    if (strcasecmp($controller, 'login') != 0) {
        if (!isset($session->usuario)) {
            $post = Zend_Registry::get('post');
            if (!isset($post->ajax)) {
                if ($controller != 'login') {
                    echo setBrowserUrl(HTTP_REFERER . 'login/index/next/' . base64_encode($_SERVER['REDIRECT_URL']), $array, $pos);
                } else {
                    echo setBrowserUrl(HTTP_REFERER . 'login', $array, $pos);
                }
                exit;
            } else {
                $br = new Browser_Control();
                if ($controller != 'login') {
                    $br->setBrowserUrl(HTTP_REFERER . 'login/index/next/' . base64_encode($_SERVER['HTTP_REFERER']), $array);
                } else {
                    $br->setBrowserUrl(HTTP_REFERER . './', $array);
                }
                $br->send();
                exit;
            }
        } else if (strcasecmp($controller, 'index') != 0) {
            if (!isset($post->ajax)) {
                if (!Usuario::verificaAcesso($controller)) {
                    Log::createLog('', 'Acesso ao controlador "' . $controller . '" negado', cLOG_ACESSO_NEGADO);
                    echo setBrowserUrl(HTTP_REFERER . 'index', $array);
                    exit;
                }
            } else {
                if (!Usuario::verificaAcesso($controller)) {
                    Log::createLog('', 'Acesso ao controlador "' . $controller . '" negado', cLOG_ACESSO_NEGADO);
                    $br = new Browser_Control();
                    $br->setBrowserUrl(HTTP_REFERER . './index');
                    $br->send();
                    exit;
                }
            }
        }
    }
}

//  print'<pre>';die(print_r($frontController ));
#####################################################################################################################

setlocale(LC_MONETARY, 'ptb');


//$frontController->setParam('useCaseSensitiveActions', TRUE);

$frontController->dispatch();
