<?php
class Ui_Element_Radio extends Zend_Form_Element_Radio{
	public function init(){
		$this->addDecorator('ViewHelper');
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}