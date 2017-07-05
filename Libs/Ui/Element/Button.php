<?php
class Ui_Element_Button extends Zend_Form_Element_Button{
	public function init(){
		$this->addDecorator('ViewHelper');
		$this->setAttrib('event', 'click');
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}