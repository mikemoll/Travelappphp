<?php

class Zend_View_Helper_FormTabMain extends Zend_View_Helper_FormElement {

    public function getParams($attribs) {
        $params = '{';
        $sep = '';
        foreach ($attribs as $key => $val) {
            if (!($key == 'id' || $key == 'tabs' || $key == 'disabled')) {
                if ($val) {
                    $params .= $sep . $key . ' : ' . $val;
                    $sep = ', ';
                }
            } else if ($key == 'disabled') {
                if ($val) {
                    $p = '[';
                    $sep2 = '';
                    foreach ($val as $value) {
                        $p .= $sep2 . $value;
                        $sep2 = ' ,';
                    }
                    $p .= ']';
                    $params .= $sep . $key . ':' . $p;
                    $sep = ' ,';
                }
            }
        }
        $params .= '}';
        return $params;
    }

    public function formTabMain($name, $value = null, $attribs = null) {
        $view = Zend_Registry::get('view');
        $active = 'active';
        $tabs = '<div id="' . $attribs['id'] . '" class="tabs"><ul id="tabs" class="nav nav-tabs" data-tabs="tabs">';
        foreach ($attribs['tabs'] as $val) {
            if ($val->visible) {
                if ($val) {
                    $datatoggle = 'data-toggle="tab"';
                    $hide = '';
                    if (trim($val->disabled) != '') {
//                        $datatoggle = '';
                        $hide = ' style="display:none;" ';
                    }
//                    $tabs .= '<li class="' . $active . ' ' . $val->disabled . '" ' . $hide . '><a href="#' . $val->getName() . '" ' . $datatoggle . ' >' . $val->title . '</a></li>';
                    $tabs .= '<li id="li' . $val->getName() . '" class="nav-item ' . $active . '  " ' . $hide . '>'
                            . '<a class="nav-link" href="#' . $val->getName() . '" ' . $datatoggle . ' >' . $val->title . '</a>'
                            . '</li>';
                    $active = '';
                }
            }
        }
        $tabs .= '</ul>';
        $tabs .= '<div id="my-tab-content" class="tab-content">';

        $active = 'active';
        foreach ($attribs['tabs'] as $val) {
            if ($val->visible) {
                if ($val->fields) {
                    foreach ($val->fields as $comp) {
                        if ($comp->templateId != '') {
                            $view->assign($comp->templateId, $comp->render());
                        } else {
                            $view->assign($comp->getName(), $comp->render());
                        }
                    }
                }
                if ($val->template)
                    $tabs .= '<div class="tab-pane ' . $active . '" id="' . $val->getName() . '">' . $view->fetch($val->template) . '</div>';
                else
                    $tabs .= '<div class="tab-pane ' . $active . '" id="' . $val->getName() . '">' . $view->fetch('abas/' . $val->getName() . '.tpl') . '</div>';
                $active = '';
            }
        }
        $tabs .= '</div>';
        $tabs .= '</div>';
//        $tabs .= '<script type="text/javascript">$("#' . $attribs['id'] . '")';
//        $tabs .= '.tabs(' . $this->getParams($attribs) . ')';
//        $tabs .= '</script>';
        return $tabs;
    }

}
