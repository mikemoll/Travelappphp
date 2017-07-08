<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: FormText.php 20096 2010-01-06 02:05:09Z bkarwin $
 */
/**
 * Abstract class for extension
 */
require_once 'Zend/View/Helper/FormElement.php';

/**
 * Helper to generate a "text" element
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_View_Helper_FormTextMask extends Zend_View_Helper_FormElement {

    /**
     * Generates a 'text' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are used in place of added parameters.
     *
     * @param mixed $value The element value.
     *
     * @param array $attribs Attributes for the element tag.
     *
     * @return string The element XHTML.
     */
    public function formTextMask($name, $value = null, $attribs = null) {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable


        $maxlenght = $attribs['maxlenght'];
        $mask = '"' . $attribs['mask'] . '"';
        $autoTab = $attribs['autoTab'];
        $defaultValue = '"' . $attribs['defaultValue'] . '"';
        $reverse = $attribs['reverse'];

        unset($attribs['mask']);
        unset($attribs['autoTab']);
        unset($attribs['defaultValue']);
        unset($attribs['reverse']);

        $param = '';
        $sep = '';
        if (!empty($mask)) {
            $param .= '"mask":' . $mask;
            $sep = ', ';
        }
        if (!empty($autoTab)) {
            $param .= $sep . '"autoTab":' . $autoTab;
            $sep = ', ';
        }
        if (!empty($defaultValue)) {
            $param .= $sep . '"defaultValue":' . $defaultValue;
            $sep = ', ';
        }
        if ($reverse == true) {
            $param .= $sep . '"type":"reverse"';
            $sep = ', ';
        }

        // build the element
        $disabled = '';
        if ($disable) {
            // disabled
            $disabled = ' disabled="disabled"';
        }

        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag = '>';
        }

        $label = $attribs['label'];

        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag = '>';
        }
        if ($label != '') {
            $xhtml = '<div class="form-group form-group-default">';

            $xhtml .='<label>' . $label . '</label>';
        }
        $xhtml .= '<input type="text"'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($name) . '"'
                . ' value="' . $this->view->escape($value) . '"'
                . $this->_htmlAttribs($attribs)
                . $endTag;
        if ($maxlenght != '' and $maxlenght > 0) {
            $xhtml .= '<span class="max-char-text" ><span id="chars' . $this->view->escape($name) . '">' . ($maxlenght - strlen($this->view->escape($value))) . '</span> remaining characters</span>';
        }
        if ($label != '') {
            $xhtml .= '</div>';
        }

        $xhtml .= "<script type='text/javascript'>$('#" . $id . "').setMask({" . $param . "})</script>";
        return $xhtml;
    }

}
