<?php
class Ui_Element_BtnImg extends Zend_Form_Element{
	public $src;
	public $alt;
	public $helper = 'formBtnImg';
	
	public function init(){
		$this->addDecorator('ViewHelper');
		$this->setAttrib('event', 'click');
	}
	
	public function setImage($src, $alt = ''){
		$this->src = $src;
		$this->alt = $alt;
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}