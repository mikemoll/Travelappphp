<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormBtn extends Zend_View_Helper_FormElement
{
	public function formBtn($name, $value = null, $attribs = null)
	{
		$info    = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable, escape

		$label = $this->view->escape($attribs['label']);
		$src = $attribs['src'];
		$alt = $attribs['alt'];
		$type = $attribs['type'];
		$link = $attribs['link'];

		unset($attribs['display']);
		unset($attribs['src']);
		unset($attribs['alt']);


		$xhtml = '<a name="'.$this->view->escape($name).'" id="'.$this->view->escape($name).'" href="'.$this->view->escape($link).'" '.$this->_htmlAttribs($attribs).' class="btn btn-'.$type.'">';
//		$xhtml .= '<table class="containerButton">';
//			$xhtml .= '<tr>';
//				$xhtml .= '<td class="btnE3x25"></td>';
//				$xhtml .= '<td class="btnC3x25">';
				if($src != ''){
					$xhtml .= '<i class="fa fa-'.$src.' fa-lg" ></i> ';
				}
				$xhtml .= $label ;
//				$xhtml .= '<td class="btnD3x25"></td>';
//				$xhtml .= '</tr>';
//		$xhtml .= '</table></a>';
		$xhtml .= '</a>';

/*		$xhtml = '<div class="containerButton">';
		$xhtml .= '<a name="' . $this->view->escape($name) . '" id="' . $this->view->escape($id) . '" href="#none"';
		$xhtml .= $this->_htmlAttribs($attribs) . '>';
		$xhtml .= '<div class="btnE3x25"></div>';
		$xhtml .= '<div class="btnC3x25">';
		if($src != '')
			$xhtml .= '<div class="btnImg"><img class="btnImg" src="'.$src.'" alt="'.$alt.'" title="'.$alt.'" /></div>';

//		$xhtml .= '<link rel="stylesheet" href="'.PATH_SCRIPTS.'Button/Button.css">';
		$xhtml .= '<div class="btnText">'.$label.'</div>';
		$xhtml .= '</div>';
		$xhtml .= '<div class="btnD3x25"></div>';
		$xhtml .= '</a>';
		$xhtml .= '</div>';
//		$xhtml .= '<script type="text/javascript" src="'.PATH_SCRIPTS.'Button/Button.js"></script>';
*/
		return $xhtml;
	}
}