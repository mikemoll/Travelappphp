<?php
class Ui_Element_TabMain extends Zend_Form_Element{

	public $helper = 'formTabMain';
	public $tabs;
	public $disabled;

	public function init(){
		$this->addDecorator('ViewHelper');
	}
	public function cache($cache = true){
		$this->cache = $cache;
	}
	public function collapsible ($collapsible = 'true'){
		$this->collapsible = $collapsible;
	}
	public function cookie($cookie = true){
		$this->cookie = $cookie;
	}
	public function deselectable($deselectable = true){
		$this->deselectable = $deselectable;
	}
	public function tabsDisabled($tabNumber){
		if(is_array($tabNumber)){
			$this->disabled = $tabNumber;
		}else{
			$this->disabled[] = $tabNumber;
		}
	}
	public function id($id) {
		$this->id = $id;
	}
	public function tabSelected($num){
		$this->selected = $num;
	}
	/**
	 * adiciona uma aba
	 *
	 * @param  $id
	 * @param  $title
	 * @param  $conteudo sendo qualquer coisa ou um Zend_Form
	 */
	public function addTab($tab){
		$this->tabs[] = $tab;
	}
}