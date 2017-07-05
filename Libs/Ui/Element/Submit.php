<?php
class Ui_Element_Submit extends Zend_Form_Element_Submit{
	public function init(){
		$this->addDecorator('ViewHelper');
	}	
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}