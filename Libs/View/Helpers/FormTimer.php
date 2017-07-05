<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormTimer extends Zend_View_Helper_FormElement {

    public function formTimer($name, $value = null, $attribs = null) {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable, escape

        $label = $this->view->escape($attribs['label']);
        $url = $attribs['url'];
        $intervalo = $attribs['intervalo'];
        $delay = $attribs['delay'];
        $justOnce = $attribs['justOnce'];
        $event = $attribs['event'];
        $id = $this->view->escape($name);

        unset($attribs['event']);

        $xhtml = '<input type="hidden" id="' . $this->view->escape($name) . '"   name="' . $this->view->escape($name) . '" ' . $this->_htmlAttribs($attribs) . ' >';
        $xhtml .= "<script>";

        if ($justOnce) {

            $xhtml .= " $(document).ready(function() {
                            console.log('O elemento [$id] atualizará em {$intervalo}ms apenas uma vez.');
                        setTimeout(function () {
                                ajaxRequest($('#$id'), '$event')
                        }, " . $intervalo . "); /* 120 segundos depois de carregado */"
                    . '';
        } else {
            $xhtml .= " $(document).ready(function() {
                            console.log('O elemento [$id] atualiza  a cada {$intervalo}ms com um atrazo de {$delay}ms para iniciar.');
                        setTimeout(function () {
                                ajaxRequest($('#$id') ,'$event')
                            var interval$id = setInterval(function () {
                                ajaxRequest($('#$id') ,'$event')
                            }, " . $intervalo . ");/* de 60 em 60 segundos*/

                        }, " . $delay . "); /* 120 segundos depois de carregado */"
                    . '';
        }

        $xhtml .= "  });"
                . "</script>";

        return $xhtml;
    }

}
