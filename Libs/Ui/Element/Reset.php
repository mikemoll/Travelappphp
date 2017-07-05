<?php
class Ui_Element_Reset extends Zend_Form_Element_Reset{
	public function init(){
		$this->addDecorator('ViewHelper');
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}