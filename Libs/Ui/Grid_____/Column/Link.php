<?
include_once 'Abstract.php';
class Ui_Element_Grid_Column_Link extends Ui_Grid_Column_Abstract{

	protected $link;
	protected $text;
	protected $alt;

	/**
	 * Adiciona o link para o botão, o texto que ira aparecer na tela e o texto alternativo
	 * 
	 * @param String $link
	 * @param String $text
	 * @param String $alt
	 */
	public function setLink($link, $text, $alt = ''){
		$this->link = $link;
		$this->text = $text;
		$this->alt = $alt;
	}
	public function getParams()
	{
		$column = '';
		if($this->visible){
			$column = "{display: '{$this->display}', name: '{$this->name}', width: {$this->width},
			sortable: {$this->sortable}, align: '{$this->align}'}";
		}
		return $column;
	}

	public function render($oid, $row){

//		if($this->verificaCondicao($row)){
			$html = "<a href='".$this->link."' title='".$this->alt."' alt='".$this->alt."' {$this->getAttribs()}>";

			$html .= $this->text."</a>";

		return trim($html);
	}
}