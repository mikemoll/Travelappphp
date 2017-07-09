<?php

class Ui_Element_Date extends Zend_Form_Element_Text {

    public $buttonImageOnly = true;
    public $showOn = 'button';
    public $dateFormat = 'mm/dd/yyyy';
    public $placeholder = '__/__/_____';
    public $mask = '99/99/9999';
    public $buttonText = '';
    public $autoSize = true;
    public $constrainInput = false;
    public $helper = 'formDate';
    public $minViewMode = '0'; // esse é o nivel que o calendário vai aparecer [0 = day, 1 = month, 2 = year]
    public $showCalendar = true; // se deve ou não mostrar o calendário ao lado do campo

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('class', 'form-control datepicker');
//		Browser_Control::setScript('js', 'Date', 'Date/Date.js');
//        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        Browser_Control::setScript('js', 'jquery.inputmask', '../../site/Public/assets/plugins/jquery-inputmask/jquery.inputmask.min.js');

//		Browser_Control::setScript('css', 'Date', 'Date/Date.css');
//                $this->buttonImage = PATH_IMAGES.'Calendarios/CalendarAdd24x24.png';
    }

    public function __construct($id, $label = '') {
        parent::__construct($id, '');

        $this->label = $label;
        $this->setAttrib('placeholder', $this->placeholder);
        $this->setAttrib('data-date-min-view-mode', '0');
        $this->setAttrib('data-date-today-btn', 'true');
        $this->setAttrib('data-date-language', 'en');
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
     * Define que esse componente deve ser preenchido pelo usuário
     *
     * @param boolean $v [true|false]
     */
    public function setObrig($v = true) {
        $this->setAttrib('obrig', 'obrig');
        $this->setRequired();
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

    public function setAlt($alt) {
        $this->buttonText = $alt;
    }

    /**
     * Desabilita o datepicker do campo
     */
    public function disableCalendar() {
        $this->setAttrib('class', 'form-control');
    }

    /**
     * Devine se mostra o calendário no onFocus do campo
     * @param type $val
     */
    public function setShowCalendarOnFocus($val) {
        $this->setAttrib('data-date-show-on-focus', $val);
    }

    /** Forca a data que foi digitada no campo a ser uma data valida
     *
     * @param type $alt
     */
    public function setForceParse($alt = 'true') {
        $this->setAttrib('data-date-force-parse', $alt);
    }

    /** Set a minimum limit for the view mode.<Br>
     *  Accepts: 0 or “days” or “month”, 1 or “months” or “year”, 2 or “years” or “decade”, 3 or “decades” or “century”, and 4 or “centuries” or “millenium”.
     *
     * @param type $val
     */
    public function setMinDateViewMode($val = 'days') {
        $this->setAttrib('data-date-min-view-mode', $val);
    }

    /** Define um campo alternativo para ser preenchido junto com o atual.
     *
     * Isso serve para quando se tem dois campos de datas que são um periodo (inicio e fim)
     *
     * Assim no primeiro campo se define o nome do segundo campo a ser preenchido
     *
     * @param type $alt
     */
    public function setAlternativeField($alt) {
        $this->setAttrib('data-alternative-field', $alt);
    }

    public function setShowCalendar($alt) {
        $this->showCalendar = $alt;
    }

    public function setImage($scr, $button) {
        $this->buttonImage = $src;
        $this->buttonImageOnly = $button;
    }

    public function setFormatData($format = 'dd/mm/yy') {
        $this->dateFormat = $format;
    }

    public function setMinViewMode($format = 0) {
        $this->minViewMode = $format;
    }

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

    public function setReadOnly($flag, $classCss = 'readonly') {
        if ($flag) {
            $this->setAttrib('readonly', 'readonly');
            $this->setAttrib('class', 'form-control ');
        }
    }

}
