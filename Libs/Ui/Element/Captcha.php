<?php
class Ui_Element_Captcha extends Zend_Form_Element_Button{
	public function init(){
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}