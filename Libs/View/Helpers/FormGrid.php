<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormGrid extends Zend_View_Helper_FormElement
{	
	public function formGrid($name, $value = null, $attribs = null)
	{
		$info    = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable, escape
		
		$json = '{';
		if($attribs['url'] != ''){
			$json .= "url:'" . $attribs['url'] . "',";
		}
		if($attribs['dataType'] != ''){
			$json .= "dataType:'" . $attribs['dataType'] . "',";
		}
		if($attribs['colModel'] != ''){
			$json .= "colModel:" . $this->renderColumn($id, $attribs['colModel']) . ",";
		}
		if($attribs['buttons'] != ''){
			$json .= "buttons:" . $this->renderButtons($attribs['buttons']) . ",";
		}
		if($attribs['searchItens'] != ''){
			$json .= "searchItens:" . $this->renderSearch($attribs['searchItens']) . ",";
		}
		//if($attribs['sortName'] != ''){
			$json .= "sortname:'" . $attribs['sortName'] . "',";
		//	}
		if($attribs['sortOrder'] != ''){
			$json .= "sortorder:'" . $attribs['sortOrder'] . "',";
		}
		if($attribs['usePager'] != ''){
			$json .= "usepager:" . $attribs['usePager'] . ",";
		}
		if($attribs['title'] != ''){
			$json .= "title:'" . $attribs['title'] . "',";
		}
		if($attribs['useRp'] != ''){
			$json .= "useRp:" . $attribs['useRp'] . ",";
		}
		if($attribs['showTableToggleBtn'] != ''){
			$json .= "showTableToggleBtn:" . $attribs['showTableToggleBtn'] . ",";
		}
		if($attribs['width'] != ''){
			$json .= "width:'" . $attribs['width'] . "',";
		}
		if($attribs['height'] != ''){
			$json .= "height:'" . $attribs['height'] . "',";
		}
		if($attribs['singleSelect'] != ''){
			$json .= "singleSelect:" . $attribs['singleSelect'] . ",";
		}
		if($attribs['rpOptions'] != ''){
			$json .= "rpOptions:" . $attribs['rpOptions'] . ",";
		}
		if($attribs['resizable'] != ''){
			$json .= "resizable:" . $attribs['resizable'] . ",";
		}
		if($attribs['eventEdit'] != ''){
			$json .= "eventEdit:'" . $attribs['eventEdit'] . "',";
		}
		if($attribs['controller'] != ''){
			$json .= "controller:'" . $attribs['controller'] . "',";
		}
		if($attribs['errormsg'] != ''){
			$json .= "errormsg:'" . $attribs['errormsg'] . "',";
		}
		if($attribs['outof'] != ''){
			$json .= "outof:'" . $attribs['outof'] . "',";
		}
		if($attribs['findtext'] != ''){
			$json .= "findtext:'" . $attribs['findtext'] . "',";
		}
		if($attribs['procmsg'] != ''){
			$json .= "procmsg:'" . $attribs['procmsg'] . "',";
		}
		if($id != ''){
			$json .= "id:'" . $id . "',";
		}
		if($attribs['pagetext'] != ''){
			$json .= "pagetext:'" . $attribs['pagetext'] . "',"; 
		}
		$json .= "pagestat:'Mostrando: {from} de {to} para {total} itens.',";
		$json .= "procmsg: 'Processando, por favor aguarde...'";
		$json .= '}';

		$xhtml = '<table id="'.$id.'" style="display: none;" class="flexigrid"></table>'
			   . '<script type="text/javascript">'
			   . '$("#'.$id.'").flexigrid(' . $json . ')'
			   . '</script>';

			   
		return $xhtml;
	}
	
	
	private function renderColumn($id, $col) {
		$separator = '';
		$columns = '[';
		foreach ($col as $column) {
			if($column->getVisible()){
				$columns .= $separator.$column->getParams();
				$colunas[] = $column;
				$separator = ',';
			}
		}
		$columns .= ']';
		Session_Control::setDataSession($id, $colunas);
		return($columns);
	}
	
	private function renderButtons($buttons) {
		$separator = '';
		$return = '[';
		if($buttons != ''){
			foreach ($buttons as $button) {
				if($button->visible){
					$return .= $separator.$button->render();
					$separator = ',{separator: true},';
				}
			}
		}
		$return .= ']';
		
		if($buttons = ''){
			$return = '';
		}
		return $return;
	}
	
	private function renderSearch($searchs) {
		$separator = '';
		$procura = '[';
		if(isset($searchs)) {
			foreach ($searchs as $search) {
				$procura .= $separator.$search->render();
				$separator = ',';
			}
		}
		$procura .= ']';
		return $procura;
	}
	public function getScriptButons($script) {

		foreach ($script as $button) {
			$scripts .= "\n" . $button->getScript();

		}

		return ($buttons);
	}
}