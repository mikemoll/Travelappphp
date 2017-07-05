<?php
/**
 * Classe principal do Grid
 *
 * @filesource
 * @author			Ismael Sleifer
 * @copyright		Ismael Sleifer Web Designer
 * @package			Libs
 * @subpackage		Libs.Grid
 * @version			1.0
 *
 * @param  $id
 * @param  $url
 * @param  $dataType [optional]
 * @return Grid
 */
class Ui_Grid_Flexigrid {
	/**
	 * Id do flexigrid
	 *
	 * @var String
	 */
	private $_id;

	/**
	 * Url de consulta ao banco
	 *
	 * @var String
	 */
	private $url;

	/**
	 * Tipo de retorno a consulta ao banco
	 *
	 * @var String
	 */
	private $dataType = 'json';

	/**
	 * Nome do formulario onde estara o grid
	 *
	 * @var String
	 */
	private $formName;

	/**
	 * Array de colunas do Grid
	 *
	 * @var Array
	 */
	private $colModel = array();

	/**
	 * Array de bot�es do Grid
	 *
	 * @var Array
	 */
	private $buttons;

	/**
	 * Itens de procura no banco
	 *
	 * @var Array
	 */
	private $searchItens;

	/**
	 * Campo de ordena��o no grid
	 *
	 * @var String
	 */
	private $sortName;

	/**
	 * Tipo de ordena��o no grid
	 * Padr�o 'asc'
	 *
	 * @var String
	 */
	private $sortOrder = 'asc';

	/**
	 * Se � usado pagina��o
	 * valor padr�o e true
	 *
	 * @var Boolean
	 */
	private $usePage = 'true';

	/**
	 * Titulo do grid
	 *
	 * @var String
	 */
	private $title;

	/**
	 * Se quer que apare�a a caixa de numero de linhas por pagina
	 * valor padr�o e true
	 *
	 * @var Boolean
	 */
	private $useRp = 'true';

	/**
	 * Quantidade de linhas por pagina
	 * Valor padr�o 25
	 *
	 * @var Integer
	 */
	private $rp = 25;

	/**
	 * Se o Grid pode ser minimizado
	 * Valor padr�o e false
	 *
	 * @var Boolean
	 */
	private $sortTableToggleBtn = 'false';

	/**
	 * Comprimento do Grid
	 * Valor padr�o 700
	 *
	 * @var Integer
	 */
	private $width;

	/**
	 * Altura do Grid
	 * Valor padr�o 255
	 *
	 * @var
	 */
	private $height;

	/**
	 * Aceita ou n�o multi sele��o
	 * Valor padr�o true sendo true valor para single sele��o
	 *
	 * @var
	 */
	private $singleSelect = 'true';

	/**
	 * Configura as op��es de exibi��o de numero de linhas
	 * por pagina.
	 * Valores padr�es 10, 15, 20, 25, 40
	 *
	 * @var String
	 */
	private $rpOptions = '[10, 15, 20, 25, 40]';

	/**
	 * Se o Grid pode ser redimencionado
	 * Valor padrão false
	 *
	 * @var boolean
	 */
	private $resizable = 'false';
	/**
	 * Evento de edição da linha no grid
	 * @var String
	 */
	private $eventEdit = 'dblclik';
	/**
	 * Controllador do grid
	 */
	private $controller;
	private $errormsg;
	private $pagetext;
	private $outof;
	private $findtext;
	private $procmsg;

	/**
	 * Construtor da classe
	 *
	 * @param  $id
	 * @param  $url
	 * @param  $dataType [optional]
	 * @return
	 */
	public function __construct($id, $title, $url) {
		$this->_id = $id;
		$this->title = $title;
		$this->url = $url;
		$this->errormsg = 'Erro na conexão';
		$this->pagetext= 'Página';
		$this->outof = 'de';
		$this->findtext = 'Localizar';
		$this->procmsg = 'Processando, por favor aguarde ...';

		Browser_Control::setScript('js', 'Flexigrid', 'Flexigrid/Flexigrid.js');
		Browser_Control::setScript('css', 'Flexigrid', 'Flexigrid/Flexigrid.css');
	}
	public function setFormName($val) {
		$this->formName = $val;
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
	public function setUsePage($usePage) {
		$this->usePage = $usePage;
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
	public function setSortTableToggleBtn($minimiza) {
		$this->sortTableToggleBtn = $minimiza;
	}
	public function setDimension($width, $height) {
		$this->width = $width;
		$this->height = $height;
	}
	public function setSingleSelect ($singleSelect = 'true') {
		$this->singleSelect = $singleSelect;
	}
	public function setRpOptions($rpOptions = '10, 15, 20, 25, 40') {
		$this->rpOptions = '[' . $rpOptions . ']';
	}
	public function setResizable($resizable = 'false') {
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
	private function renderButtons() {
		$separator = '';
		$buttons = '[';
		if(isset($this->buttons)){
			foreach ($this->buttons as $button) {
				if($button->visible){
					$buttons .= $separator.$button->render();
					$separator = ',{separator: true},';
				}
			}
		}
		$buttons .= ']';
		return $buttons;
	}
	public function getScriptButons() {

		foreach ($this->buttons as $button) {
			$scripts .= "\n" . $button->getScript();

		}

		return ($buttons);
	}
	public function addSearch($search) {
		$this->searchItens[] = $search;
	}
	private function renderSearch() {
		$separator = '';
		$procura = '[';
		if(isset($this->searchItens)) {
			foreach ($this->searchItens as $search) {
				$procura .= $separator.$search->render();
				$separator = ',';
			}
		}
		$procura .= ']';
		return($procura);
	}
	public function addColumn($column) {
		$this->colModel[] = $column;
	}
	private function renderColumn() {
		$separator = '';
		$columns = '[';
		foreach ($this->colModel as $column) {
			if($column->getVisible()){
				$columns .= $separator.$column->getParams();
				$colunas[] = $column;
				$separator = ',';
			}
		}
		$columns .= ']';

		Session_Control::setDataSession($this->_id, $colunas);

		return($columns);
	}
	public function render() {

		$script = '<table id="'.$this->_id.'" style="display: none;" class="flexigrid"></table>';
		$script .= '<script type="text/javascript">'."\n";
		$script .= '$(document).ready(function(){'."\n";
		$script .= '	$(\'#'.$this->_id.'\').flexigrid'."\n";
		$script .= '	({'."\n";
		$script .= '		url: \''.$this->url.'\','."\n";
		$script .= '		id: \''.$this->_id.'\','."\n";
		$script .= '		formName: \''.$this->formName.'\','."\n";
		$script .= '		dataType: \''.$this->dataType.'\','."\n";
		$script .= '		colModel: '.$this->renderColumn().','."\n";
		$script .= '		buttons: '.$this->renderButtons().','."\n";
		$script .= '		errormsg: "'.$this->errormsg.'",'."\n";
		$script .= '		pagetext: "'.$this->pagetext.'",'."\n";
		$script .= '		outof: "'.$this->outof.'",'."\n";
		$script .= '		findtext: "'.$this->findtext.'",'."\n";
		$script .= '		procmsg: "'.$this->procmsg.'",'."\n";
		if(isset($this->searchItens)){
			$script .= '		searchitems: '.$this->renderSearch().','."\n";
		}
		$script .= '		sortname: "'.$this->sortName.'",'."\n";
		$script .= '		sortorder: "'.$this->sortOrder.'",'."\n";
		$script .= '		usepager: '.$this->usePage.','."\n";
		$script .= '		title: \''.$this->title.'\','."\n";
		$script .= '		useRp: '.$this->useRp.','."\n";
		$script .= '		rp: '.$this->rp.','."\n";
		$script .= '		showTableToggleBtn: '.$this->sortTableToggleBtn.','."\n";
		if(isset($this->width)){
			$script .= '		width: '.$this->width.','."\n";
		}
		if(isset($this->height)){
			$script .= '		height: '.$this->height.','."\n";
		}
		$script .= '		singleSelect: '.$this->singleSelect.','."\n";
		$script .= '		rpOptions: '.$this->rpOptions.','."\n";
		$script .= '		pagestat: \'Mostrando: {from} de {to} para {total} itens.\''.','."\n";
		$script .= '		procmsg: \'Processando, por favor aguarde...\','."\n";
		$script .= '		resizable: '.$this->resizable.','."\n";
		$script .= '		eventEdit: \''.$this->eventEdit.'\','."\n";
		$script .= '		controller: "'.$this->controller.'"';
		$script .= '	});'."\n";
		$script .= '});'."\n";
		$script .= '</script>'."\n";
		return $script;
	}
}