<?php
/**
 * Classe que estende o Smarty
 * @filesource
 * @author		Ismael Sleifer
 * @copyright	Ismael Sleifer Web Designer
 * @package		libs
 * @subpackage	libs.view
 * @version		1.0
 */
require_once'View/Smarty/libs/Smarty.class.php';
require_once 'Zend/View/Abstract.php';
class View_Smarty extends Zend_View_Abstract
{
	private $_smarty;
	private $_operatingSystem;
	private $_bar;
	private $_pathSeparator;
	private $_documentRoot;
	private $_libraryPath;
	private $html;

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->_smarty = new Smarty();
		/**
		 * Identifica o sistema operacional do servidor, considerando que pode ser Windows ou Linux.
		 */
		$this->_operatingSystem =  stripos($_SERVER['SERVER_SOFTWARE'],'win32')!== FALSE ? 'WINDOWS' : 'LINUX';
		$this->_bar = $this->_operatingSystem == 'WINDOWS' ? '\\' : '/' ;
		$this->_pathSeparator = $this->_operatingSystem == 'WINDOWS' ? ';' : ':' ;
		$this->_documentRoot =  $this->_operatingSystem == 'WINDOWS' ? str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT'];

		$this->_libraryPath = RAIZ_DIRETORY . $this->_bar.'Libs'.$this->_bar.'View'.$this->_bar;
		/**
		 * Recupera as cinfigura��es do Smarty
		 */
		$config = parse_ini_file($this->_libraryPath.'Config.ini', TRUE);

		$this->_smarty->caching = (bool)$config['smarty']['caching'];
		$this->_smarty->cache_lifetime = (int)$config['smarty']['cachelifetime'];
		$this->_smarty->template_dir = '';
		$this->_smarty->compile_dir = $this->_libraryPath.$this->_bar.'templates_c';
		$this->_smarty->config_dir = $this->_libraryPath.$this->_bar.'configs';
		$this->_smarty->cache_dir = $this->_libraryPath.$this->_bar.'cache';
		/**
		 * Coloca o diret�tio do Smarty no path do PHP
		 */
		$smartyPath = $this->_pathSeparator.$this->_libraryPath.'view'.$this->_bar.'Smarty';
		set_include_path(get_include_path().$smartyPath);
	}
	/**
	 * M�todo que configura o diret�rio de templates do Smarty.
	 * @return void
	 */
	public function setTemplateDir($applicationName)
	{
		$this->_smarty->template_dir = RAIZ_DIRETORY . $this->_bar.$applicationName.
//		$this->_bar.'Application'.$this->_bar.'views'.$this->_bar.'tpl'.$this->_bar;
		$this->_bar.'Application'.$this->_bar.'views'.$this->_bar;
	}
	protected function _run($template = 'index.tpl')
	{
		$this->_smarty->display($template);
	}
	public function assign($spec, $value = NULL)
	{
		if(is_string($spec))
		{
			$this->_smarty->assign($spec, $value);
		}
		elseif (is_array($spec))
		{
			foreach($spec as $key => $value)
			{
				$this->_smarty->assign($key, $value);
			}
		}
		else
		{
			throw new Zend_View_Exception('assign() expects a string or array, got '.gettype($var));
		}
	}
	public function escape($var)
	{
		if(is_string($var))
		{
			return parent::escape($var);
		}
		elseif (is_array($var))
		{
			foreach($var as $key => $val)
			{
				$var[$key] = $this->escape($val);
			}
			return $var;
		}
		else
		{
			return $var;
		}
	}
	public function setHtml($html)
	{
		$this->html = $html;
	}
	public function getHtml()
	{
		return $this->html;
	}
	public function fetch($name)
	{
		return $this->_smarty->fetch($this->_smarty->template_dir.$name);
	}
	public function output($name)
	{
		$this->_smarty->display($this->_smarty->template_dir.$name);
		exit;
	}

	public function isCached($template)
	{
		if ($this->_smarty->is_cached($template))
		{
			return TRUE;
		}
		return FALSE;
	}
	public function setCaching($caching)
	{
		$this->_smarty->caching = $caching;
	}
}
?>