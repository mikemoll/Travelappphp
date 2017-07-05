<?php
include_once 'Abstract.php';
class Ui_Element_Grid_Column_Text extends Ui_Element_Grid_Column_Abstract {
	protected $type = 'text';
	public function getParams()
	{
		$coluna = '';
		if($this->visible){
			$coluna = "{display: '{$this->display}', name: '{$this->name}', width: '{$this->width}', sortable: {$this->sortable}, align: '{$this->align}', hide: {$this->hide}, podeEsconder:'{$this->podeEsconder}'}";
		}
		return $coluna;
	}

	public function render($oid, $row){
		$nomeColuna = 'get'.$this->getName();
		if(is_array($row)){
			return "<span alt='{$row[$nomeColuna]}' title='{$row[$nomeColuna]}'>".$row[$nomeColuna].'</span>';
		}else{
			return "<span alt='{$row->$nomeColuna()}' title='{$row->$nomeColuna()}'>".$row->$nomeColuna().'</span>';
		}
	}
}