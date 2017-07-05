<?php

class Ui_Element_Btn extends Zend_Form_Element {

    public $helper = 'formBtn';
    public $type = 'default';
    public $link = '#none';

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('event', 'click');
//		Browser_Control::setScript('js', 'Button', 'Button/Button.js');
//		Browser_Control::setScript('css', 'Button', 'Button/Button.css');
    }

    function setType($val) {
        $this->type = $val;
    }

    function setActionToCallOnClick($val) {
        $this->setAction($val);
    }

    function setAction($val) {
        $this->setAttrib('url', $val);
    }

    public function addClass($class) {
        $a = $this->getAttrib('class');
        $this->setAttrib('class', $a . ' ' . $class);
    }

    function setHref($val) {
        $this->setLink($val);
    }

    function setLink($val) {
        $this->link = $val;
        $this->setAttrib('event', '');
    }

    /**
     * Define se esse botão deve enviar todos os dados dos campos na request
     */
    function setSendFormFiends() {
        $this->setAttrib('sendformfields', '1');
    }

    function setConfirmMsg($msg) {
        $this->setAttrib('msg', $msg);
    }

    /**
     * Adiciona o texto e a imagem para o botão
     *
     * @param String $label
     * @param String $src
     * @param String $alt
     */
    public function setDisplay($label, $src = '', $alt = '') {
        $this->label = $label;
        $this->src = $src;
        $this->alt = $alt;
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
