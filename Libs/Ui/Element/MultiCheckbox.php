<?php

class Ui_Element_MultiCheckbox extends Zend_Form_Element_MultiCheckbox {

    public function init() {
        $this->addDecorator('ViewHelper');
    }

    public function __construct($id, $label = '', $options = '') {
        parent::__construct($id, $options);

        $this->label = $label;
    }

    /**
     * Define o id desse componente no template (.tpl)
     * 
     * @param string $id
     */
    public function setTemplateId($id) {
        $this->setAttrib('templateId', $id);
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

}
