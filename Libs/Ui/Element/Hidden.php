<?php
class Ui_Element_Hidden extends Zend_Form_Element_Hidden{
	public function init(){
		$this->addDecorator('ViewHelper');
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}