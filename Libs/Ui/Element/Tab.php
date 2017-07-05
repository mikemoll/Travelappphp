<?php

class Ui_Element_Tab extends Zend_Form_Element {

    public $helper = 'formTab';
    public $fields;
    public $visible;

    public function init() {
        $this->addDecorator('ViewHelper')
                ->addDecorator('Label')
                ->addDecorator('HtmlTag');
        $this->visible = true;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDisabled($title = true) {
        if ($title) {
            $this->disabled = 'disabled';
        }
    }

    public function setTemplate($template) {
        $this->template = $template;
    }

    public function addElement($element) {
        if (get_class($element) == 'Ui_Element_DataTables') {
            //se for um grid DataTables que está sendo adicionado no Formulário,
//            devemos guardalo na sessão para utilizar mais tarde no Grid_ControlDataTables::setDataGrid()
            Session_Control::setDataSession($element->getId(), $element);
        }
        $this->fields[] = $element;
    }

    public function setVisible($processo, $acao = 'ver') {
        $this->visible = Usuario::verificaAcesso($processo, $acao);
    }

}
