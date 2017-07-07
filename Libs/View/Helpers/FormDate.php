<?php

class Zend_View_Helper_FormDate extends Zend_View_Helper_FormElement {

    public function formDate($name, $value = null, $attribs = null) {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable

        $showCalendar = $attribs['showCalendar'];
        $mask = $attribs['mask'];

        unset($attribs['showCalendar']);
        unset($attribs['mask']);

//        $attribs['masked'] = 'true';
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
//		print_r($mask);
//		die();
        unset($attribs['id']);
        $sep = '';
        $params = '{';
        foreach ($attribs as $key => $val) {
            if ($key == 'buttonText' && $val == '') {
                $val = $name;
            }
            if ($val) {
                $params .= $sep . $key . " : '" . $val . "'";
                $sep = ', ';
            }
//			unset($attribs[$key]); Por deste unset ???????
        }
        $params .= '}';
        $label = $attribs['label'];
        $dateFormat = $attribs['dateFormat'];
        $minViewMode = $attribs['minViewMode'];
        if ($label != '') {
            $xhtml .= '<div class="form-group form-group-default  input-group">';

            $xhtml .='<label >' . $label . '</label>';
        }
        $paddingRigth = '';
        if ($showCalendar) {
            // se mostrar o calendario a direita, tem que colocar padding-rigth, senão o texto fica junto com o calendario
            $paddingRigth = 'padding-right: 25px;';
        }
        $xhtml .= '<input type="text"  style="' . $paddingRigth . '"'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($id) . '"'
                . ' value="' . $this->view->escape($value) . '"'
//                . ' data-mask="' . $mask . '"'
//                . ' data-date-format="' . $dateFormat . '"'
//                . ' data-date-autoclose="true"'
//                . ' data-date-today-highlight="true"'
//                . ' data-date-toggle-active="true"'
//                . ' data-date-language="pt-BR" '
//                . ' data-date-disable-touch-keyboard="true" '
                . $this->_htmlAttribs($attribs)
                . $endTag;

        if ($showCalendar) {
//            $xhtml .= '<span class="input-group-addon"><i class="fa fa-calendar"></i></span> ';
//            $xhtml .= '<span class="add-on datepicker-icon"><i class="fa fa-calendar"></i></span> ';
            $xhtml .= '<span class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </span> ';
//            $xhtml .= '<i onclick="$(' . "'" . '#' . $id . "'" . ').focus()" class="fa fa-calendar" style="cursor:pointer;position: absolute; z-index: 2; margin: 10px 0 0 -22px;"></i> ';
        }
//        $xhtml .= '<script >$(document).ready(function() {
//                                    $(".datepicker").datepicker({
//                                        format: "' . $dateFormat . '",
//                                        minViewMode: ' . $minViewMode . ',
//                                        language: "pt-BR",
//                                        autoclose: true,
//                                        todayHighlight: true,
//                                        toggleActive: true
//                                    });
//
//
//                            }) '
//                . '</script>';


        $xhtml .= "<script type='text/javascript'>$('#" . $id . "').setMask({mask: '$mask', autoTab: false})</script>";


        if ($label != '') {
            $xhtml .= '</div>';
        }

        return $xhtml;
    }

}
