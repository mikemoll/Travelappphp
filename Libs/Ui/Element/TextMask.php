<?php

class Ui_Element_TextMask extends Zend_Form_Element_Text {

    public $helper = 'formTextMask';

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
     *  Essa  propriedade foi criada para quando o formulário está preenchendo os valores,
     * não considerar o campo como uma propriedade do objeto. Se não dá um erro dizendo que esse campo não foi encontrado no Objeto
     * @param boolean $val
     */
    public function notProperty($val = true) {
        $this->notProperty = $val;
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
     * criar uma mascara para o input
     * Obs:  caso usar o reverse a mascara sera invertida devido a biblioteca js

     * @param String $mascara EX:9999,99 em caso de uso do reverse, colocar a mascara ao contrário
     * @param bool $reverse <code>TRUE</code> para o campo ficar ao contrario(usado para campos de valor);
     * @param String $defaulValue valor default do campo.
     * @param Boolean $autoTab <code>TRUE</code> para que ao final da digitação do valor o foco passar para o proximo campo;
     * @link http://www.meiocodigo.com/projects/meiomask 
     */
    public function setMask($mascara, $reverse = false, $defaultValue = '', $autoTab = 'false') {
        $this->mask = $mascara;
        $this->defaultValue = $defaultValue;
        $this->reverse = $reverse;
        $this->autoTab = $autoTab;
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

    /**
     * Define o placeholder desse componente
     *
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder) {
        $this->addPlaceholder($placeholder);
    }

//
    public function setReadOnly($flag, $classCss = 'readonly') {
        if ($flag) {
            $this->setAttrib('readonly', 'readonly');
        }
    }

//    public function setReadOnly($flag, $classCss = 'readonly') {
//        if ($flag) {
//            $this->setAttrib('readonly', 'readonly');
//            $this->setAttrib('class', $classCss);
//        }
//    }
}
