<?php

class Ui_Element_Select extends Zend_Form_Element_Select {

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('class', 'form-control');
    }

    public function __construct($id, $label = '') {
        parent::__construct($id, '');

        $this->addClass('full-width');
        $this->label = $label;
    }

    public function addClass($class) {
        $a = $this->getAttrib('class');
        $this->setAttrib('class', $a . ' ' . $class);
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
     * Set required flag
     *
     * @param  bool $flag Default value is true
     * @return Zend_Form_Element
     */
    public function setRequired($flag = true) {
        $this->setAttrib('obrig', 'obrig');
        return parent::setRequired($flag);
    }

    /**
     * Define que esse componente deve fazer uma requisição ao
     * servidor ao ser selecionado
     *
     * @param boolean $v [true|false]
     */
    public function setOnChange($v = true) {
        if ($v) {
            $this->setAttrib('event', 'change');
        }
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
     * define se o componente irá utilizar a biblioteca Select2
     *
     * @param boolean $val
     */
    public function setSelect2($val = true) {
        if ($val) {
            $this->setAttrib('select2', 'select2');
        }
    }

    /**
     * define se o componente irá utilizar a biblioteca Select2
     *
     * @param boolean $controller
     */
    public function setSelect2AjaxLoad($controller = true) {
        if ($controller) {
            $this->setAttrib('data-select2-ajaxload', $controller);
        }
    }

    /**
     * define se o componente irá utilizar  MultiSelect
     *
     * @param boolean $val
     */
    public function setMultiSelect($val = true) {
        if ($val) {
            $this->setAttrib('multiple', 'multiple');
        }
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

    /**
     *
     * @param string $processo nome do processo ou controller
     * @param string $acao [Ver|Inserir|Excluir|Editar]
     */
    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

}
