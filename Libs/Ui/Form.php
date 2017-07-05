<?php

/** Zend_View_Helper_FormElement */
//require_once 'Zend/View/Helper/FormElement.php';

/**
 * Exten��o criada para adicionar funcionalidades ao Zend_Form
 *
 * @author Leonardo Andriolli Danieli
 * @copyright Uneworld
 * @name Ext_Class_Form
 * @package Ext
 * @subpackage Class
 */
class Ui_Form extends Zend_Form {

    public function init() {
        $this->removeDecorator('DtDdWrapper');
    }

    /**
     * Converts an associative array to a string of tag attributes.
     *
     * @access public
     *
     * @param array $attribs From this array, each key-value pair is
     * converted to an attribute name and value.
     *
     * @return string The XHTML for the attributes.
     */
    protected function _htmlAttribs($attribs) {
        $xhtml = '';
        foreach ((array) $attribs as $key => $val) {
            $key = $key;
            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    require_once 'Zend/Json.php';
                    $val = Zend_Json::encode($val);
                }
                $val = preg_replace('/"([^"]*)":/', '$1:', $val);
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $val;
            }
            if ('id' == $key) {
                $val = $val;
            }
            if (strpos($val, '"') !== false) {
                $xhtml .= " $key='$val'";
            } else {
                $xhtml .= " $key=\"$val\"";
            }
        }
        return $xhtml;
    }

    /**
     * Render HTML form
     *
     * @param  null|array $attribs HTML form attributes
     * @param  false|string $content Form content
     * @return string
     */
    public function renderForm($content = false) {
        $attribs = $this->getAttribs();
        if (!empty($attribs[$id])) {
            $id = ' id="' . $attribs[$id] . '"';
        } else {
            $id = '';
        }
//		$xhtml = "<script>$('#{$attribs['id']}').validator();</script>";
        if (array_key_exists('id', $attribs) && empty($attribs['id'])) {
            unset($attribs['id']);
        }
        $xhtml .= '<form ' . $id . $this->_htmlAttribs($attribs) . '>';
        if (false !== $content) {
            $xhtml .= $content;
        }
        $xhtml .= '</form>';


        return $xhtml;
    }

    /**
     * Este método recebe como parâmetro uma instância de smarty, e um template. Aplica o "assign" a todos
     * os componentes e botoes que possuem template associado, e j� processa o template passado como
     * parâmetro, retornando assim o html gerado e processado
     *
     * @param	objeto	$pSmarty   Instância de Smarty
     * @param	string	$pTemplateName   Path do template
     * @return	string
     */
    public function fetchTpl(&$smarty, $templateName) {
        $this->assignTpl($smarty);
        return $smarty->fetch($templateName);
    }

    /**
     * retorna o html do formulario
     * deve-se passar como parametro uma instancia do smart e um caminho d template
     * @param objeto $smarty
     * @param caminho $templateName
     */
    public function displayTpl(&$smarty, $templateName) {
        $html = $this->assignTpl($smarty);

        $form = $this->renderForm($html . $smarty->fetch($templateName));
        return $form;
    }

    /**
     * Este m�todo recebe como par�metro uma inst�ncia de smarty, e aplica o "assign" a todos
     * os componentes e botoes que possuem template associado
     *
     * @param	objeto	$pSmarty   Inst�ncia de Smarty
     * @return	nada
     */
    public function assignTpl(&$smarty) {
        $elements = array();
        foreach ($this->getElements() as $name => $element) {
            $elements[] = clone $element;
        }

        $hiddens = '';
        for ($i = 0; $i < count($elements); $i++) {
            $field = &$elements[$i];

            if (get_class($field) == 'Ui_Element_Hidden' or get_class($field) == 'Ui_Element_Timer') {
                $hiddens .= $field->render();
            } else {
                if ($field->templateId != '') {
                    $smarty->assign($field->templateId, $field);
                } else {
                    $smarty->assign($field->getName(), $field);
                }
            }
        }
        return $hiddens;
    }

    public function setName($name) {
        $this->setAttrib('name', $name);
        $this->setAttrib('id', $name);
    }

    /**
     *  O MyID é utilizado para dar a possibilidade de abrir mais de um formulário do mesmo registro.
     * Por Exemplo abrir duas FT diferentes em abas separadas, sem uma sobrescrever a outra na $_SESSION
     * @param string $MyId
     */
    public function setMyId($MyId) {
        $this->setAttrib("data-post-params", "myid=$MyId");
    }

    /**
     *   Define se o formulário deve fazer uma request ao servidor após ser carregado
     * @param string $sim [true|false]
     * @param string $delay tempo de atraso para fazer a requisição. Em Milisegundos
     */
    public function setRequestOnFormCrate($sim = true, $delay = '') {
        if ($sim) {
            $this->setAttrib("data-request-on-form-create", "$sim");
            $this->setAttrib("data-request-on-form-create-delay", "$delay");
        }
    }

    /**
     * Adiciona o formulario na memoria para apos ser usado para validação
     */
    public function setDataSession($name = '') {
        if ($name == '') {
            $name = $this->getName();
        }
        Session_Control::setDataSession($name, $this);
    }

    /**
     * função que preenche os valores dos campos do formulario.
     * esta função tambem preenche os campos das abas
     */
    public function setDataForm($item) {
        if ($item != '') {
            foreach ($this->_elements as $nomeCampo => $componente) {
                if (get_class($componente) == 'Ui_Element_TabMain') {
                    foreach ($componente->tabs as $aba) {
                        if ($aba->fields != '') {
                            foreach ($aba->fields as $field) {
                                if (get_class($field) != 'Ui_Element_DataTables' and
                                        get_class($field) != 'Ui_Element_Btn' and
                                        get_class($field) != 'Ui_Element_Timer') {
                                    //@TODO Adicionar condições para todos os componentes que não são atributos
                                    if(!$field->notProperty){
                                        //se o campo não é uma propriedade da classe em questão, não faz o get
                                        $metodo = 'get' . $field->getName();
                                        $field->setValue($item->$metodo());
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (get_class($componente) != 'Ui_Element_DataTables' and
                            get_class($componente) != 'Ui_Element_Btn' and
                            get_class($componente) != 'Ui_Element_Timer') {
                        $metodo = 'get' . $nomeCampo;
                        $componente->setValue($item->$metodo());
                    }
                }
            }
        }
    }

    /**
     * função que preenche os valores dos campos do formulario.
     * esta função tambem preenche os campos das abas
     */
    public function getElement($nomeElemento) {
        if ($nomeElemento != '') {
            foreach ($this->_elements as $nomeCampo => $componente) {
                if (get_class($componente) == 'Ui_Element_TabMain') {
                    foreach ($componente->tabs as $aba) {
                        if ($aba->fields != '') {
                            foreach ($aba->fields as $field) {
                                if ($field->getName() == $nomeElemento) {
                                    return $field;
                                }
                            }
                        }
                    }
                } else {
                    if ($componente->getName() == $nomeElemento) {
                        return $componente;
                    }
                }
            }
        }
    }

    public function addElement($element, $name = null, $options = null) {
        if (get_class($element) == 'Ui_Element_DataTables') {
            //se for um grid DataTables que está sendo adicionado no Formulário,
//            devemos guardalo na sessão para utilizar mais tarde no Grid_ControlDataTables::setDataGrid()
            Session_Control::setDataSession($element->getId(), $element);
        }
        parent::addElement($element, $name, $options);
    }

}
