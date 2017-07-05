<?php
include_once 'Abstract.php';
class Ui_Element_Grid_Column_Check extends Ui_Grid_Column_Abstract {
	protected $alt;
	protected $type = 'check';

	public function setAlt($val) {
		$this->alt = $val;
	}

	public function getParams()
	{
		if($this->visible){
			$coluna = "{display: '{$this->display}', name: '{$this->name}', width: '{$this->width}', sortable: false, align: '{$this->align}',
			hide: {$this->hide}, type: 'checkbox', podeEsconder: 'false'}";
		}
		return $coluna;
	}

	public function render($oid, $row){

		$post = Zend_Registry::get('post');

		$numRow = Session_Control::getDataSession('row_'.$post->idGrid) + 1;
		Session_Control::setDataSession('row_'.$post->idGrid, $numRow);


		if($this->verificaCondicao($row)){
			$html = "<input type='checkbox' alt='{$this->alt}' title='{$this->alt}' id='gridChk_{$numRow}' name='gridChk_{$numRow}' ";
			$html .= "col='{$this->getName()}' {$this->getAttribs()} value='{$oid}'>";
		}else{
			$html = '';
		}

		return trim($html);
	}
}