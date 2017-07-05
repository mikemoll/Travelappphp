<?php

class Ui_Element_Timer extends Zend_Form_Element {

    public $helper = 'formTimer';

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('event', 'load');
    }

    /**
     *
     * @param type $id
     * @param type $interval
     * @param type $delay
     */
    public function __construct($id, $interval = 0, $delay = 0) {
        parent::__construct($id, '');
        $this->setIntervalo($interval);
        $this->setDelay($delay);
    }

    public function setIntervalo($val) {
        $this->setAttrib('intervalo', $val);
    }

    public function setDelay($val) {
        $this->setAttrib('delay', $val);
    }

    public function setJustOnce($val) {
        $this->setAttrib('justOnce', $val);
    }

    public function setController($val) {
        $this->setAttrib('url', $val);
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

}
