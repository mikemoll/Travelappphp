<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormAutoComplete extends Zend_View_Helper_FormElement
{
	public function formAutoComplete($name, $value = null, $attribs = null)
	{
		$info    = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable, escape


		$param['disabled'] = $attribs['disabled'];
		$param['appendTo'] = $attribs['appendTo'];
		$param['autoFocus'] = $attribs['autoFocus'];
		$param['delay'] = $attribs['delay'];
		$param['minLength'] = $attribs['minLength'];
		$param['position'] = $attribs['position'];
		$param['source'] = $attribs['source'];

		$param['select'] = "function(event, ui){alert('jjjjj')}";

		foreach ($param as $key){
			unset($attribs[$key]);
		}
		/*
		unset($attribs['disabled']);
		unset($attribs['appendTo']);
		unset($attribs['autoFocus']);
		unset($attribs['delay']);
		unset($attribs['minLength']);
		unset($attribs['position']);
		unset($attribs['source']);*/

		$json = Format_String::jqueryParams($param);
		//print_r($json);die('<br><br>' .  __LINE__);

		$disabled = '';
		if ($disable) {
			// disabled
			$disabled = ' disabled="disabled"';
		}

		// XHTML or HTML end tag?
		$endTag = ' />';
		if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
			$endTag= '>';
		}

		$xhtml = '<input type="text"'
		. ' name="' . $this->view->escape($name) . '"'
		. ' id="' . $this->view->escape($id) . '"'
		. ' value="' . $this->view->escape($value) . '"'
		. $disabled
		. $this->_htmlAttribs($attribs)
		. $endTag;
		$xhtml .= '<script type="text/javascript">'
		. '$(document).ready(function(){'
		. '$("#' . $id . '").autocomplete('
		. $json
		. ')'
		. '});'
		. '</script>';

		//print_r($xhtml);die('<br><br>' .  __LINE__);

		/*$xhtml = '<a name="'.$this->view->escape($name).'" id="'.$this->view->escape($id).'" href="#none"'.$this->_htmlAttribs($attribs).' class="btnText">';
		 $xhtml .= '<table class="containerButton">';
			$xhtml .= '<tr>';
			$xhtml .= '<td class="btnE3x25"></td>';
			$xhtml .= '<td class="btnC3x25">';
			if($src != ''){
			$xhtml .= '<img class="btnImg" src="'.$src.'" alt="'.$alt.'" title="'.$alt.'" />';
			}
			$xhtml .= $label.'</td>';
			$xhtml .= '<td class="btnD3x25"></td>';
			$xhtml .= '</tr>';
			$xhtml .= '</table></a>';*/

		return $xhtml;
	}
}