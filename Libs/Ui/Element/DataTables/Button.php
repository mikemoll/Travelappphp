<?php

class Ui_Element_DataTables_Button {

    private $url;
    private $href;
    private $display;
    private $name;
    private $bclass;
    private $onpress;
    private $event = 'click';
    private $sendFormFields;
    private $rel;
    private $img;
    private $attribs = '';
    private $atributos = array();
    public $visible = false;

    public function __construct($name, $display) {
        $this->setDisplay($name, $display);
        $this->setAttrib('class', 'btn btn-primary btn-xs');
    }

    public function setDisplay($name, $display) {
        $this->name = $name;
        $this->display = $display;
    }

    public function setEvent($val) {
        $this->event = $val;
    }

    public function setImg($src) {
        $this->img = $src;
    }

    public function setSendFormFields() {
        $this->sendFormFields = '1';
    }

    public function setRel($val) {
        $this->rel = $val;
    }

    public function setUrl($val) {
        $this->url = $val;
    }

    public function setAction($val) {
        $this->url = $val;
    }

    /**
     *
     * @param type $val
     * @param type $target
     */
    public function setHref($val, $target = '') {
        $this->href = $val;
        if ($target != '') {
            $this->setAttrib('target', $target);
        }
    }

    /**
     * Set element attribute
     *
     * @param  string $name
     * @param  mixed $value
     * @return Zend_Form_Element
     * @throws Zend_Form_Exception for invalid $name values
     */
    public function setAttrib($name, $value) {
        $name = (string) $name;
        if ('_' == $name[0]) {
            require_once 'Zend/Form/Exception.php';
            throw new Zend_Form_Exception(sprintf('Invalid attribute "%s"; must not contain a leading underscore', $name));
        }

        if (null === $value) {
            unset($this->$name);
        } else {
            $this->atributos[$name] = $name . "='" . $value . "'";
        }

        return $this;
    }

    public function setAttribs($attribs) {
        $this->attribs = $attribs;
    }

    public function getScript() {
        $scripts = '';
        return $scripts;
    }

    /**
     *
     * @param type $processo 
     * @param type $acao ['ver','editar,'inserir','excluir']
     */
    public function setVisible($processo, $acao = '') {
        $this->visible = Usuario::verificaAcesso($processo, $acao);
    }

    public function render($idRow) {

        $buttons = '';
        if ($this->visible) {
            $atributos = implode(' ', $this->atributos);
//            $buttons = "{name: '{$this->display}', value: '{$this->name}', onpress: '{$this->onpress}',url: '{$this->url}',rel: '{$this->rel}', event: '{$this->event}', sendFormFields: '{$this->sendFormFields}', href: '{$this->href}', img: '{$this->img}', attribs: '{$this->attribs}' }";
//            $buttons .= "<div url='{$this->url}' sendformfields='{$this->sendFormFields}' event='{$this->event}' name='{$this->name}' id='{$this->name}' class='btn btn-info btn-square' params='{$this->attribs}&id_row={$idRow}' ><img src='{$this->img}'><!--<i class='fa fa-plus'></i>--> </div> ";
//            $buttons .= "<button type='button' url='{$this->url}' sendformfields='{$this->sendFormFields}' event='{$this->event}' name='{$this->name}' id='{$this->name}' class='btn btn-primary btn-xs' params='{$this->attribs}&id_row={$idRow}' ><i class='fa fa-plus'></i></button> ";
            if ($this->href) {
                $buttons .= "<a href='{$this->href}/id/{$idRow}' $atributos title='{$this->display}'   name='{$this->name}' id='{$this->name}'  params='id_row={$idRow}&{$this->attribs}'   >";
                $buttons .= "<div   ><i class='fa fa-{$this->img}'></i></div> ";
                $buttons .= "</a>";
            } else {

                $buttons .= "<div url='{$this->url}' $atributos sendformfields='{$this->sendFormFields}' title='{$this->display}' event='{$this->event}' name='{$this->name}' id='{$this->name}'   params='id={$idRow}&{$this->attribs}' ><i class='fa fa-{$this->img}'></i></div> ";
            }
//            $buttons .= "<img src='{$this->img}'></a> ";
        }
        return $buttons;
    }

}
