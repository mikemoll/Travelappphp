<?php

class Ui_Element_File extends Zend_Form_Element_File {

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('class', '');
    }

    /**
     * 
     * @param string $id
     * @param string $label
     */
    public function __construct($id, $label = '') {
        parent::__construct($id, '');

        $this->label = $label;
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

    /**
     * Define o id desse componente no template (.tpl)
     *
     * @param string $id
     */
    public function setTemplateId($id) {
        $this->setAttrib('templateId', $id);
    }

    public function setReadOnly($flag, $classCss = 'readonly') {
        if ($flag) {
            $this->setAttrib('readonly', 'readonly');
        }
    }

}
