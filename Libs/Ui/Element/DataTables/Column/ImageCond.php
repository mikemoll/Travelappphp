<?php
include_once 'Abstract.php';
class Ui_Element_DataTables_Column_ImageCond extends Ui_Element_DataTables_Column_Abstract{

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

//	public function getParams(){
//		$image = '';
//		if($this->visible){
//			$image = "{display: '{$this->display}', name: '{$this->name}', width: {$this->width},
//			sortable: {$this->sortable}, align: '{$this->align}'}";
//		}
//		return $image;
//	}
	public function render($oid, $row){
		if($this->verificaCondicao($row)){
                    $img = $this->img1;
                $html = "<i class='fa fa-".$img." text-success'  {$this->getAttribs()}></i>";
		}else{
                    $img = $this->img2;
                $html = "<i class='fa fa-".$img."'  {$this->getAttribs()}></i>";
		}
		return trim($html);
	}
}