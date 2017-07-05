<?php

class Ui_Element_Checkbox extends Zend_Form_Element_Checkbox {

    public function init() {
        $this->addDecorator('ViewHelper');
    }

    public function __construct($id, $label = '') {
        parent::__construct($id, '');

        $this->label = $label;
    }

    /**
     * Define se esse botão deve enviar todos os dados dos campos na request
     */
    function setSendFormFiends() {
        $this->setAttrib('sendformfields', '1');
    }

    function setCheckedValue($v) {
        $this->setAttrib('checkedValue', $v);
        parent::setCheckedValue($v);
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
