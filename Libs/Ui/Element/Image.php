<?php
class Ui_Element_Image extends Zend_Form_Element_Image{
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