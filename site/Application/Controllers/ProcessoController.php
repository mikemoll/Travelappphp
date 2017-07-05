<?php

include_once 'AbstractController.php';

class ProcessoController extends AbstractController {

    public function init() {
        parent::init();
    }

    public function indexAction() {

        $form = new Ui_Form();
        $form->setName('formProcessos');
        $form->setAction('Processo');

        // Grid dos processos
        $grid = new Ui_Element_DataTables('grid');
        $grid->setParams('', BASE_URL . $form->getAction() . '/listaProcessos');
        $grid->setShowPager(false);

        $element = new Ui_Element_DataTables_Button('btnNovo', 'Inserir');
        $element->setImg('plus');
        $element->setVisible('PROC_CAD_PROCESSOS', 'inserir');
        $grid->addButton($element);
//        $element = new Ui_Element_DataTables_Button('btnExcluir', 'Excluir');
//        $element->setImg('Buttons/Cancelar.png');
//        $element->setAttribs('msg = "Excluir o item selecionado ?"');
//        $element->setVisible('PROC_CAD_PROCESSOS', 'excluir');
//        $element->setSendFormFields('sendFormFields', '1');
//        $grid->addButton($element);
//
//        $column = new Ui_Element_DataTables_Column_Check('ID', 'oid_processo', '30', 'center');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Nome', 'nome', '110');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Descricao', 'descricao', '190');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Controladores', 'controladores', '190');
        $grid->addColumn($column);


        Session_Control::setDataSession($grid->getId(), $grid);
        $form->addElement($grid);


        // Botao btnNovo
        $button = new Ui_Element_Btn('btnNovo');
        $button->setDisplay('Novo', 'plus');
        $button->setType('success');
        $button->setAttrib('click', '');
        $form->addElement($button);


        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
         $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $form->displayTpl($view, 'Processos/index.tpl'));
        $view->output('index.tpl');
    }

    public function btnexcluirclickAction() {
        Grid_ControlDataTables::deleteDataGrid('Processos', 'processos');
    }

    public function listaprocessosAction() {
        $p = new Processo();
        $p->readLst();
        Grid_ControlDataTables::setDataGrid($p);
    }

    public function btnnovoclickAction() {
        $this->edit();
    }

    public function processosdblclickAction() {
        $this->edit();
    }

    public function btnsalvarclickAction() {

        $post = Zend_Registry::get('post');

        $obj = new Processo();
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $obj->setDataFromRequest($post);

        $obj->save();

        $br = new Browser_Control();
        $br->setRemoveWindow('EditProcessos');
        $br->setUpdateDataTables('grid');
        $br->send();
    }

    public function edit() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $obj = new Processo();
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $br = new Browser_Control();
        $form = new Ui_Form();
        $form->setAction('Processo');
        $form->setName('formUpdateProcesso');

        // Campo nome
        $nome = new Ui_Element_Text('Nome', 'Nome');
        $nome->setAttrib('maxlength', '20');
        $form->addElement($nome);

        // Campo Descricao
        $descricao = new Ui_Element_Text('Descricao', 'Descrição');
        $descricao->setAttrib('maxlength', '30');
        $form->addElement($descricao);

        // Campo Descricao
        $descricao = new Ui_Element_Text('Controladores', 'Controladores');
        $descricao->setAttrib('maxlength', '200');
        $form->addElement($descricao);


        $button = new Ui_Element_Btn('btnSalvar');
        $button->setDisplay('Salvar', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id . $from);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $form->setDataForm($obj);

        // Botao Cancelar
        $button = new Ui_Element_Btn('btnCancelar');
        $button->setDisplay('Cancelar', 'times');
        $button->setType('default');
        $button->setAttrib('click', '');
        $form->addElement($button);

        $html = $form->displayTpl($view, 'Processos/edit.tpl');

        $w = new Ui_Window('EditProcessos', "Edição de processos", $html, true);
        $w->setDimension('600', '400');
        $w->setCloseOnEscape(true);
        $br = new Browser_Control();
        $br->newWindow($w, 'EditProcessos');
        $br->send();
    }

    public function btncancelarclickAction() {
        $br = new Browser_Control();
        $br->setRemove('EditProcessos');
        $br->send();
    }

}
