<?php

include_once 'AbstractController.php';

class ProcessoController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formProcesso';
        $this->Action = 'Processo';
        $this->TituloLista = "Trip Type";
        $this->TituloEdicao = "Trip Type";
        $this->ItemEditInstanceName = 'ProcessoEdit';
        $this->ItemEditFormName = 'formProcessoItemEdit';
        $this->Model = 'Processo';
        $this->IdWindowEdit = 'EditProcesso';
        $this->TplIndex = 'Processo/index.tpl';
        $this->TplEdit = 'Processo/edit.tpl';
    }

    public function indexAction() {

        $form = new Ui_Form();
        $form->setName('formProcessos');
        $form->setAction('Processo');

        // Grid dos processos
        $grid = new Ui_Element_DataTables('grid');
        $grid->setParams('', BASE_URL . $form->getAction() . '/listaProcessos');
        $grid->setShowPager(false);

        $element = new Ui_Element_DataTables_Button('btnNovo', 'Edit');
        $element->setImg('plus');
        $element->setVisible('PROC_CAD_PROCESSOS', 'inserir');
        $grid->addButton($element);

        $element = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $element->setImg('trash');
        $element->setAttrib('msg', "Excluir o item selecionado ?");
        $element->setVisible('PROC_CAD_PROCESSOS', 'excluir');
        $grid->addButton($element);
//
        $column = new Ui_Element_DataTables_Column_Text('ID', 'id_processo');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Proccess Name', 'nome');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Description', 'descricao');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Controllers', 'controladores');
        $grid->addColumn($column);


        $form->addElement($grid);


        // Botao btnNovo
        $button = new Ui_Element_Btn('btnNovo');
        $button->setDisplay('New Item', 'plus');
        $button->setType('success');
        $button->setAttrib('click', '');
        $form->addElement($button);


        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $form->displayTpl($view, 'Processos/index.tpl'));
        $view->output('index.tpl');
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
        $nome = new Ui_Element_Text('Nome', 'Name');
        $nome->setAttrib('maxlength', '30');
        $form->addElement($nome);

        // Campo Descricao
        $descricao = new Ui_Element_Text('Descricao', 'Description');
        $descricao->setAttrib('maxlength', '30');
        $form->addElement($descricao);

        // Campo Descricao
        $descricao = new Ui_Element_Text('Controladores', 'Controllers it has access');
        $descricao->setAttrib('maxlength', '200');
        $form->addElement($descricao);


        $button = new Ui_Element_Btn('btnSalvar');
        $button->setDisplay('Save', 'check');
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
        $button->setDisplay('Cancel', 'times');
        $button->setType('default');
        $button->setAttrib('click', '');
        $form->addElement($button);

        $html = $form->displayTpl($view, 'Processos/edit.tpl');

        $w = new Ui_Window('EditProcessos', "Proccess", $html, true);
        $w->setDimension('600', '400');
        $w->setCloseOnEscape(true);
        $br = new Browser_Control();
        $br->newWindow($w);
        $br->send();
    }

    public function btncancelarclickAction() {
        $br = new Browser_Control();
        $br->setRemoveWindow('EditProcessos');
        $br->send();
    }

}
