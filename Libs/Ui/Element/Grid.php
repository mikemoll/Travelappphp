<?php
class Ui_Element_Grid extends Zend_Form_Element{

	public $helper = 'formGrid';

	/**
	 * Id do flexigrid
	 *
	 * @var String
	 */
	protected $_id;

	/**
	 * Url de consulta ao banco
	 *
	 * @var String
	 */
	protected $url;

	/**
	 * Tipo de retorno a consulta ao banco
	 *
	 * @var String
	 */
	protected $dataType = 'json';

	/**
	 * Nome do formulario onde estara o grid
	 *
	 * @var String
	 */
	protected $formName;

	/**
	 * Array de colunas do Grid
	 *
	 * @var Array
	 */
	protected $colModel = array();

	/**
	 * Array de bot�es do Grid
	 *
	 * @var Array
	 */
	protected $buttons;

	/**
	 * Itens de procura no banco
	 *
	 * @var Array
	 */
	protected $searchItens;

	/**
	 * Campo de ordena��o no grid
	 *
	 * @var String
	 */
	protected $sortName = null;

	/**
	 * Tipo de ordenação no grid
	 * Padr�o 'asc'
	 *
	 * @var String
	 */
	protected $sortOrder = 'asc';

	/**
	 * Se � usado pagina��o
	 * valor padr�o e true
	 *
	 * @var Boolean
	 */
	protected $usePager = 'true';

	/**
	 * Titulo do grid
	 *
	 * @var String
	 */
	protected $title;

	/**
	 * Se quer que apare�a a caixa de numero de linhas por pagina
	 * valor padr�o e true
	 *
	 * @var Boolean
	 */
	protected $useRp = 'true';

	/**
	 * Quantidade de linhas por pagina
	 * Valor padr�o 25
	 *
	 * @var Integer
	 */
	protected $rp = 25;

	/**
	 * Se o Grid pode ser minimizado
	 * Valor padr�o e false
	 *
	 * @var Boolean
	 */
	protected $showTableToggleBtn = 'false';

	/**
	 * Comprimento do Grid
	 * Valor padr�o 700
	 *
	 * @var Integer
	 */
	protected $width;

	/**
	 * Altura do Grid
	 * Valor padr�o 255
	 *
	 * @var
	 */
	protected $height;

	/**
	 * Aceita ou não multi seleção
	 * Valor padr�o true sendo true valor para single sele��o
	 *
	 * @var
	 */
	protected $singleSelect = 'true';

	/**
	 * Configura as op��es de exibição de numero de linhas
	 * por pagina.
	 * Valores padrões 10, 15, 20, 25, 40
	 *
	 * @var String
	 */
	protected $rpOptions = '[10, 15, 20, 25, 40]';

	/**
	 * Se o Grid pode ser redimencionado
	 * Valor padrão false
	 *
	 * @var boolean
	 */
	protected $resizable = 'false';
	/**
	 * Evento de edição da linha no grid
	 * @var String
	 */
	protected $eventEdit = 'dblclik';
	/**
	 * Controllador do grid
	 */
	protected $controller;
	protected $errormsg;
	protected $pagetext;
	protected $outof;
	protected $findtext;
	protected $procmsg;
	
	protected $visible = true;

	public function init(){
		$this->addDecorator('ViewHelper');

		$this->errormsg = 'Erro na conexão';
		$this->pagetext= 'Página';
		$this->outof = 'de';
		$this->findtext = 'Localizar';
		$this->procmsg = 'Processando, por favor aguarde ...';
	}

	public function setFormName($val) {
		$this->formName = $val;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	public function setAction($action){
		$this->url = $action;
	}
	public function setParams($title, $action){
		$this->title = $title;
		$this->url = $action;
	}
	/**
	 * configura o campo e o tipo de ordenação do grid
	 *
	 * @param String $sortName nome da coluna
	 * @param String $sortOrder tipo de ordenação
	 */
	public function setOrder($sortName, $sortOrder = 'asc') {
		$this->sortName = $sortName;
		$this->sortOrder = $sortOrder;
	}
	/**
	 * Habilita ou desabilita a paginação
	 *
	 * @param Boolean $usePage
	 */
	public function setUsePager($usePage) {
		$this->usePager = $usePage;
	}
	/**
	 * configura o retorno dos dados das linhas do grid pode ser de dois tipo Json (default) e xml
	 *
	 * @param String $dataType
	 */
	public function setDatatype($dataType) {
		$this->dataType = $dataType;
	}
	public function setUseRp($useRp) {
		$this->useRp = $useRp;
	}
	public function setRp($rp) {
		$this->rp = $rp;
	}
	public function setShowTableToggleBtn($minimiza) {
		$this->showTableToggleBtn = $minimiza;
	}
	public function setDimension($width, $height) {
		$this->width = $width;
		$this->height = $height;
	}
	public function setSingleSelect ($singleSelect = false) {
		$this->singleSelect = $singleSelect;
	}
	public function setRpOptions($rpOptions = '10, 15, 20, 25, 40') {
		$this->rpOptions = '[' . $rpOptions . ']';
	}
	public function setResizable($resizable = false) {
		$this->resizable = $resizable;
	}
	public function addButton($button) {
		$this->buttons[] = $button;
	}
	public function setEventEdit($event){
		$this->eventEdit = $event;
	}
	public function setController($controller){
		$this->controller = $controller;
	}
	public function addSearch($search) {
		$this->searchItens[] = $search;
	}
	public function addColumn($column) {
		$this->colModel[] = $column;
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}