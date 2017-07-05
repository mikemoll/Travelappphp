<?php
class Ui_Element_Section extends Zend_Form_Element_Text{

	public $helper = 'formSection';
	
	protected $title;
	protected $template;
	protected $fields;
	protected $visible = true;
	
	public function init(){
		$this->addDecorator('ViewHelper');
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	public function setTemplate($template){
		$this->template = $template;
	}
	public function addElement($element){
		$this->fields[] = $element;
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}