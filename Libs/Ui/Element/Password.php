<?php

class Ui_Element_Password extends Zend_Form_Element_Password {

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('class', 'form-control');
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

    /**
     * Define se esse componente deve executar o onBlur
     *
     * @param string $id
     */
    public function setOnBlur($id = true) {
        if ($id) {
            $this->setAttrib('event', 'blur');
        }
    }

    /**
     * Define o placeholder desse componente
     *
     * @param string $placeholder
     */
    public function addPlaceholder($placeholder) {
        $this->setAttrib('placeholder', $placeholder);
    }

    /**
     * Define o placeholder desse componente
     *
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder) {
        $this->addPlaceholder($placeholder);
    }

    /**
     * Define que esse componente deve ser preenchido pelo usuário
     *
     * @param boolean $v [true|false]
     */
    public function setObrig($v) {
        $this->setAttrib('obrig', 'obrig');
        $this->setRequired();
    }

    /**
     *
     * @param type $flag
     * @param type $classCss
     */
    public function setReadOnly($flag = true, $classCss = 'readonly') {
        if ($flag) {
            $this->setAttrib('readonly', 'readonly');
        }
    }

}
