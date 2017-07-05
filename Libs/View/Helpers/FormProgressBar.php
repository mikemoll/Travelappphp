<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormProgressBar extends Zend_View_Helper_FormElement
{
	public function formProgressBar($name, $value = null, $attribs = null)
	{
                $info = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable


                $valor = $this->view->escape($value);
//		unset($attribs['valor']);
		$width = $attribs['width'];
		unset($attribs['width']);
		$height = $attribs['height'];
		unset($attribs['height']);

		// build the element
		$xhtml = '<div'
		. ' name="' . $this->view->escape($name) . '"'
		. ' id="' . $this->view->escape($id) . '"'
		. $this->_htmlAttribs($attribs)
		. ' style="width:'.$width.'; height: '.$height.'; float: left"></div>'.$valor.'%';

		$xhtml .= '<script type="text/javascript">'
		. 		  		'$("#'.$id.'").progressbar({value: '.$valor.'})'
		. 		   '</script>';


//		print_r($xhtml); die();
		return $xhtml;
	}
}