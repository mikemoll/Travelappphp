<?php
class Ui_Element_Hash extends Zend_Form_Element_Hash{
	public function init(){
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}