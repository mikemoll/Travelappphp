<?php
include_once 'Abstract.php';
class Ui_Element_Grid_Column_Image extends Ui_Grid_Column_Abstract{

	/**
	 * imagen caso a condição seja verdadeira
	 * @var text
	 */
	protected $img1;
	/**
	 * imagem caso a condição seja falsa
	 * @var text
	 */
	protected $img2;
	protected $type = 'image';

	/**
	 * adiciona as imagens para as condições
	 * @param text $imgTrue
	 * @param text $imgFalse
	 */
	public function setImages($imgTrue, $imgFalse){
		$this->img1 = $imgTrue;
		$this->img2 = $imgFalse;
	}

	public function getParams()
	{
		$image = '';
		if($this->visible){
			$image = "{display: '{$this->display}', name: '{$this->name}', width: {$this->width},
			sortable: {$this->sortable}, align: '{$this->align}'}";
		}
		return $image;
	}
	public function render($oid, $row){

		if(!$this->verificaCondicao($row)){
			$html = "<img src='".$this->img1."' height='15' {$this->getAttribs()}>";
		}else{
			$html = "<img src='".$this->img2."' height='15' {$this->getAttribs()}>";
		}

		return trim($html);
	}
}