<?php
include_once 'Abstract.php';
class Ui_Element_Grid_Column_ImageLink extends Ui_Grid_Column_Abstract{

	protected $img1;
	protected $img2;
	protected $link;

	/**
	 * Adiciona o link para o botão
	 * ex: http://www.google.com.br
	 * @param String $link
	 */
	public function setLink($link){
		$this->link = $link;
	}

	public function getParams(){
		$column = '';
		if($this->visible){
			$column = "{display: '{$this->display}', name: '{$this->name}', width: {$this->width},
			sortable: {$this->sortable}, align: '{$this->align}'}";
		}
		return $column;
	}

	public function render($oid, $row){

		if($this->verificaCondicao($row)){
			$html = "<a href='" . $this->link . "' {$this->getAttribs()}>";
			$html = "<img src='".$this->img1."'></a>";
		}else{
			$html = "<a href='" . $this->link . "' {$this->getAttribs()}>";
			$html = "<img src='".$this->img2."'></a>";
		}

		return trim($html);
	}
}