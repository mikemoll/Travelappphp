<?php

class Ui_Element_Textarea extends Zend_Form_Element_Textarea {

    public function init() {
        $this->addDecorator('ViewHelper');
        $this->setAttrib('class', 'form-control');
    }

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
     * Define o placeholder desse componente
     *
     * @param string $placeholder
     */
    public function addPlaceholder($placeholder) {
        $this->setAttrib('placeholder', $placeholder);
    }

    /**
     * Define que esse componente deve ser preenchido pelo usuário
     *
     * @param boolean $v [true|false]
     */
    public function setObrig($flag = true) {
        $this->setRequired($flag);
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

    public function setReadOnly($flag = true, $classCss = 'readonly') {
        if ($flag) {
            $this->setAttrib('readonly', 'readonly');
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

    public function setVisible($processo, $acao = '') {
        if (!Usuario::verificaAcesso($processo, $acao)) {
            $this->removeDecorator('ViewHelper');
        }
    }

    /**
     * set if it to Hide Remaining Characters
     *
     * @param string $placeholder
     */
    public function setHideRemainingCharacteres() {
        $this->setAttrib('data-hide-remaining-caracters', true);
    }

    /** Para que o TinyMce funcione em Ui_Window aberta pelo Browser_Control, é preciso
     * passar a instancia do Browser_Control para chamar o addLoadScript para que ele execute ao abrir a "Ui_Window"
     *
     * @param Browser_Control $br passar a instancia do Browser_Control quando for abrir uma Ui_Window que tenha um campo TinyMce
     */
    public function setTinyMce($br = false) {
        if ($br) {

//            // as configurações feitas aqui devem ser replicadas para a a classe  View_Helper_FormTextarea::FormTextarea()
//            $opcoes = '{
//                          selector:"[data-editor=' . "'" . 'tinymce' . $this->getId() . "'" . ']"'
//                    . ', menubar: false'
//                    . ',    resize: true '
//                    . ',  statusbar: true'
//                    . ', autoresize_bottom_margin: 5'
//                    . ', autoresize_on_init: false '
//                    . ', plugins: "table code mention autoresize" '
//                    . ", mentions: {
//                            delimiter: ['" . '{' . "'],
//                            source: function (data, process, delimiter) {
//                                    $.getJSON('" . HTTP_REFERER . "laudo/variaveislaudo', function (data) {
//                                        //call process to show the result
//                                        process(data)
//                                    });
//
//                            }
//                        } "
//                    . ', toolbar: ' . "'" . 'undo redo | bold italic underline | bullist numlist  | table code' . "'" . ' }';
//
////            $opcoes = '{
////                          selector:"[data-editor=' . "'" . 'tinymce' . $this->getId() . "'" . ']"' . ' }';
//            // as configurações feitas aqui devem ser replicadas para a a classe  View_Helper_FormTextarea::FormTextarea()
//            $br->addLoadScript(HTTP_LIBS . "/Scripts/Tinymce/tinymce.min.js", 'tinymce.baseURL = "' . HTTP_LIBS . '/Scripts/Tinymce"; tinymce.init(' . $opcoes . ');');
////            $br->addLoadScript(HTTP_LIBS . "/Scripts/Tinymce/tinymce.min.js", 'tinymce.baseURL = "' . HTTP_LIBS . '/Scripts/Tinymce"; ' . "tinymce.execCommand('mceAddControl',true,'" . $this->getId() . "');");
////            $br->addLoadScript(HTTP_LIBS . "/Scripts/Tinymce/tinymce.min.js", "tinymce.execCommand('mceRemoveControl', true," . $this->getId() . ");" . 'tinymce.baseURL = "' . HTTP_LIBS . '/Scripts/Tinymce"; tinymce.init(' . $opcoes . ');');
//            $this->setAttrib('data-editor', 'tinymce');
            //                                tinymce.EditorManager.execCommand("mceAddEditor", false, "Texto");
        } else {
            $_SESSION['tinymce'] = 0;
            Browser_Control::setScript('js', 'TinyMce', 'Tinymce/tinymce.min.js');
        }
        $this->setAttrib('data-editor', 'tinymce');
    }

}
