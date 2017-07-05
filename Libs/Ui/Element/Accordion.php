<?php
class Ui_Element_Accordion extends Zend_Form_Element_Text{

	public $helper = 'formAccordion';
	
	protected $disabled;
	protected $active = -1;
	protected $animated;
	protected $autoHeight;
	protected $clearStyle;
	protected $collapsible = true;
	protected $event;
	protected $fillSpace;
	protected $header;
	protected $icons;
	protected $navigation;
	protected $navigationFilter;
	protected $section;
	
	public function init(){
		$this->addDecorator('ViewHelper');
	}
	
	public function setDisabled($val = true){
		$this->disabled = $val;
	}
	public function setActive($num){
		$this->active = $num;
	}
	public function setAnimated($effect){
		$this->animated = $effect;
	}
	public function setAutoHeigth($auto = false){
		$this->autoHeight = $auto;
	}
	public function setClearStyle($clear = true){
		$this->clearStyle = $clear;
	}
	public function setCollapsible($val = false){
		$this->collapsible = $val;
	}
	public function setEvent($event){
		$this->event = $event;
	}
	public function setFillSpace($val = true){
		$this->fillSpace = $val;
	}
	public function setNavigation($val = true){
		$this->navigation = $val;
	}
	public function addSection($section){
		$this->section[] = $section;
	}
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}