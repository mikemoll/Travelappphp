<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormBtnImg extends Zend_View_Helper_FormElement
{
    public function formBtnImg($name, $value = null, $attribs = null)
    {
        $info    = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable, escape

        // Get content
        $content = '';
        if (isset($attribs['content'])) {
            $content = $attribs['content'];
            unset($attribs['content']);
        } else {
            $content = $value;
        }

        $content = ($escape) ? $this->view->escape($content) : $content;

        $xhtml = '<a name="' . $this->view->escape($name) . '" id="' . $this->view->escape($id) . '" ';

        $xhtml .= $this->_htmlAttribs($attribs) . '>';
		$xhtml .= '<img class="btn" src="'.$attribs['src'].'" alt="'.$attribs['alt'].'" title="'.$attribs['alt'].'" />';

        $xhtml .= $content . '</a>';

        return $xhtml;
    }
}
