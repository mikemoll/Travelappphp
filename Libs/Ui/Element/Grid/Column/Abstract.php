<?php
abstract class Ui_Element_Grid_Column_Abstract{

	protected $display;
	protected $name;
	protected $width;
	protected $sortable = 'true';
	protected $align;
	protected $hide = 'false';
	protected $type;
	protected $event;
	protected $visible = true;
	protected $attribs = array();

	protected $valor = '"~~"';
	protected $condicao = '==';
	protected $coluna;

	public function __construct($display, $name, $width = 40, $align = 'left'){
		$this->setDisplay($display, $name, $width, $align);
	}
	/* ########		Set		#########*/
	public function setDisplay($display, $name, $width = 40, $align = 'left') {
		$this->display = $display;
		$this->name = $name;
		$this->width = $width;
		$this->align = $align;
	}
	/**
	 * seta a columa para aparece escondida
	 */
	public function setHide() {
		$this->hide = 'true';
	}
	/**
	 * se a coluna pode ser ordenada
	 * @param boolean $sortable
	 */
	public function setSortable($sortable = 'true') {
		$this->sortable = $sortable;
	}
	/**
	 * se a coluna pode ser escondida
	 * @param boolean $val
	 */
	public function setPodeEsconder($val = 'true') {
		$this->podeEsconder= $val;
	}
	public function setEvent($val ) {
		$this->event = $val;
	}
	public function getVisible(){
		return $this->visible;
	}
	/**
	 * retorna o nome da coluna
	 */
	public function getName(){
		return $this->name;
	}

	public function getType(){
		return $this->type;
	}
	/**
	 * adiciona uma propriedade na celula
	 * ex: lenght='10' 
	 * @param String $key
	 * @param Strind $value
	 */
	public function setAttrib($key, $value){
		$this->attribs[] = array($key => $value);
	}
	/**
	 * Retorna os atributos do componente formatados
	 * Ex: lenght='10' ...
	 */
	public function getAttribs(){
		$attribs = '';
		foreach($this->attribs as $key => $value){
			$attribs .= $key . "='".$value."' ";
		}
		return $attribs;
	}
	/**
	 * verifica se o usuario pode ver ou não a coluna no grid

	 * @param string $processo
	 * @param string $acao
	 */
	public function setVisible($processo, $acao = ''){
		if(!Usuarios::verificaAcesso($processo, $acao)){
			$this->visible = false;
		}
	}
	/**
	 * seta a condição para se mostrar ou não algo da linha na coluna
	 * ex: coluna de checkbox verifica se o usuario pode ser excluido
	 * 
	 * @param $valor valor que será comparado com o valor no banco de dados
	 * @param $coluna qual o nome da coluna que se deve pegar o valor
	 * @param $condicao operador da condição ex: ==, !=, <=, >=, <, >
	 */
	public function setCondicao($valor, $coluna = '', $condicao = '==' ){
		$this->valor = $valor;
		$this->coluna = $coluna;
		$this->condicao = $condicao;
	}
	/**
	 * verifica as condições para mostrar o valor da coluna na linha
	 * 
	 * @param Object $row
	 */
	public function verificaCondicao($row){
		if($this->coluna != ''){
			$nomeColuna = 'get'.$this->coluna;
		}else{
			$nomeColuna = 'get'.$this->getName();
		}

		if(is_array($row)){
			$condicao = $this->valor . ' ' . $this->condicao . ' ' . $row[$nomeColuna];
		}else{
			$condicao = $this->valor . ' ' . $this->condicao . ' ' . $row->$nomeColuna();
		}
		
		if(eval("return ".$condicao.";")){
			return false;
		}else{
			return true;
		}

	}

	public function getParams(){

	}
	/**
	 * metodo pricipal que renderiza a linha.
	 * cada coluna deve implementar a sua logica retorando a celula da linha
	 * @param String $oid
	 * @param Objeto $row
	 */
	public function render($oid, $row){

	}
}