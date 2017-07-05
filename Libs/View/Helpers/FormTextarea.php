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
class Zend_View_Helper_FormTextarea extends Zend_View_Helper_FormElement {

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
    public function FormTextarea($name, $value = null, $attribs = null) {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable
//        print '<pre>';
//        die(print_r($info));

        $maxlength = $attribs['maxlength'];
        $label = $attribs['label'];
        $tinyMce = $attribs['data-editor'];
        $js = $attribs['data-js'];
        unset($attribs['data-js']);
//        print'<pre>';die(print_r( $tinyMce ));
        if (!empty($js)) {
            $xhtml .= "<script>$js</script>";
        }

//        print'<pre>'; (print_r(  $tinyMce));
//        print'<pre>';die(print_r(  $_SESSION['tinymce']));
        if ($tinyMce == 'tinymce' and ( $_SESSION['tinymce'] == 0 or $_SESSION['tinymce'] == '')) {
            $_SESSION['tinymce'] ++;
            $opcoes = '{
                          selector:"[data-editor=' . "'" . 'tinymce' . "'" . ']"'
                    . ', menubar: false'
                    . ',    resize: true '
                    . ',  statusbar: true'
                    . ', autoresize_bottom_margin: 5'
                    . ', autoresize_on_init: false '
                    . ', plugins: "table code mention autoresize textcolor image"  '
                    . ", mentions: {
                            delimiter: ['" . '{' . "'],
                            source: function (data, process, delimiter) {

                                    $.getJSON('" . HTTP_REFERER . "laudo/variaveislaudo', function (data) {
                                        //call process to show the result
                                        process(data)
                                    });

                            }
                        } "
                    . ', toolbar: ' . "'" . 'undo redo | bold italic underline forecolor backcolor | bullist numlist  | table image code' . "'" . ' }';
            $_SESSION['opcoesTinyMCE'] = $opcoes;
            $xhtml .= '<script>tinymce.init(' . $opcoes . ');</script>';
        }

        // XHTML or HTML end tag?
        if ($label != '') {
            $xhtml .= '<div class="form-group">';

            $xhtml .='<span class="control-label">' . $label . '</span>';
        }
        $xhtml .= '<textarea'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($name) . '"'
//                . ' value="' . $this->view->escape($value) . '"'
                . $this->_htmlAttribs($attribs);

        $xhtml .= ' >' . $this->view->escape($value) . '</textarea>';

        if ($maxlength != '') {
            $xhtml .= '<span class="max-char-text" ><span id="chars' . $this->view->escape($name) . '">' . ($maxlength - strlen($this->view->escape($value))) . '</span> letras restantes</span>';
        }
        if ($label != '') {
            $xhtml .= '</div>';
        }
        return $xhtml;
    }

}
