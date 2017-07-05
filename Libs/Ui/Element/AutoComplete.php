<?php
class Ui_Element_AutoComplete extends Zend_Form_Element_Text{

	public $helper = 'formAutoComplete';
	
	public $disabled;
	public $appendTo;
	public $autoFocus;
	/**
	 * Tempo para o inicio da busca
	 * @var integer
	 */
	public $delay;
	public $minLength;
	public $position;
	/**
	 * local da consulta
	 * 
	 * @var String
	 */
	public $source;

	public function init(){
		$this->addDecorator('ViewHelper');
	}
	
	public function setSource($source){
		$this->source = $source;
	}
	
	public function setDelay($time){
		$this->delay = $time;
	}
	
	public function setMinLength($tam){
		$this->minLength = $tam;
	}
	
	public function setParams($source, $minLength, $delay){
		$this->setSource($source);
		$this->setMinLength($minLength);
		$this->setDelay($delay);
	}
	
	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}