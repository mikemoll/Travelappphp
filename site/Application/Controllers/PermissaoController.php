<?php

include_once 'AbstractController.php';
class PermissaoController extends AbstractController {

    public function indexAction() {

        $form = new Ui_Form();
        $form->setName('formPermissao');
        $form->setAction('Permissao');

        // Grid Permissões
        $grid = new Ui_Element_DataTables('grid');
        $grid->setParams('', BASE_URL . $form->getAction() . '/listaPermissoes');


        $element = new Ui_Element_DataTables_Button('btnExcluir', 'Excluir');
        $element->setImg('trash-o');
        $element->setAttribs('msg = "Excluir o item selecionado ?"');
        $element->setVisible('PROC_CAD_PERMISSOES', 'excluir');
        $grid->addButton($element);


        $column = new Ui_Element_DataTables_Column_Text('Descricao', 'Descricao', '110');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Processo', 'descricao', '110');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Image('Ver', 'ver', '30', 'center');
        $column->setCondicao('S', '', '==');
        $column->setImages(PATH_IMAGES . 'Buttons/Ok.png', PATH_IMAGES . 'Buttons/Cancelar.png');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Image('Inserir', 'inserir', '40', 'center');
        $column->setCondicao('S', '', '==');
        $column->setImages(PATH_IMAGES . 'Buttons/Ok.png', PATH_IMAGES . 'Buttons/Cancelar.png');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Image('Excluir', 'excluir', '40', 'center');
        $column->setCondicao('S', '', '==');
        $column->setImages(PATH_IMAGES . 'Buttons/Ok.png', PATH_IMAGES . 'Buttons/Cancelar.png');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Image('Editar', 'editar', '40', 'center');
        $column->setCondicao('S', '', '==');
        $column->setImages(PATH_IMAGES . 'Buttons/Ok.png', PATH_IMAGES . 'Buttons/Cancelar.png');
        $grid->addColumn($column);

        Session_Control::setDataSession($grid->getId(), $grid);
        $form->addElement($grid);

        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('body', $form->displayTpl($view, 'Permissoes/index.tpl'));
        $view->output('index.tpl');
    }

    public function btnexcluirclickAction() {
        $post = Zend_Registry::get('post');

        $permissoes = new Permissao;

        $userEdit = Session_Control::getDataSession('userEdit');

        for ($i = 0; $i < $post->rp; $i++) {
            $chk = 'gridChk_' . $i;
            if ($post->$chk != '') {
                $item = $userEdit->permissoesLst[$post->$chk];
                $item->setState(cDELETE);
                $userEdit->permissoesLst[$post->$chk] = $item;
            }
        }

        Session_Control::setDataSession('userEdit', $userEdit);

        $br = new Browser_Control();
        $br->setUpdateDataTables('gridPermissao');
        $br->send();
    }

    public function listapermissoesuserAction() {
        $user = Usuario::getInstance('userEdit');
        $post = Zend_Registry::get('post');
        $permissoes = new Permissao();

        if ($user->permissoesLst != '') {
            $permissoesLst = $user->permissoesLst;
        } else {
            $permissoesLst = array();
        }

        foreach ($permissoesLst as $permissao) {

            if ($permissao->getTipo() != 'controlador' && $permissao->getState() != cDELETE) {
                $permissoes->addItem($permissao);
            }
        }
        $columns = Session_Control::getDataSession($post->idGrid);
        Grid_ControlDataTables::setDataGridJson($columns->getColumns(), $columns->getButtons(), $post->page, $permissoes, 'nome');
    }

    public function btninserirclickAction() {
        $this->edit();
    }

    public function btneditarclickAction() {
        $this->edit();
    }

    public function btnsalvarclickAction() {

        $post = Zend_Registry::get('post');

        $user = Usuario::getInstance('userEdit');

        $processos = new Processo;
        $processos->read($post->processo);

        $state = cCREATE;

        $id = $processos->getNome();


        $permissao = new Permissao();
        if ($post->id != '') {
            $state = cUPDATE;
            $id = $post->id;
            $permissao = $user->permissoesLst[$post->id];
            $oidPermissao = $permissao->getId_Permissao();
        }

        $permissao->setId_Permissao($oidPermissao);
        $permissao->setId_Processo($post->processo);
        $permissao->setNome($processos->getNome());
        $permissao->setDescricao($processos->getDescricao());
        $permissao->setVer($post->ver);
        $permissao->setInserir($post->inserir);
        $permissao->setExcluir($post->excluir);
        $permissao->setEditar($post->editar);
        $permissao->setGrupo('N');
        $permissao->setId_Usuario('');
        $permissao->setTipo('permissao');
        $permissao->setState($state);

        $user->permissoesLst[$id] = $permissao;

        Session_Control::setDataSession('userEdit', $user);

        $br = new Browser_Control();
        $br->setUpdateDataTables('gridPermissao');
        $br->setRemove('insertPermissao');
        $br->send();
    }

    public function edit() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $listaProcessos = Usuario::getListaProcessos();

        if ($listaProcessos == '' && !isset($post->id)) {
            $br->setAlert('Permissões', 'Não há mais permissões a serem inseridas. ', 380, 140);
            $br->send();
            exit;
        }

        $chkVer = false;
        $chkInserir = false;
        $chkExcluir = false;
        $chkEditar = false;

        $item = new Permissao;
        if (isset($post->id)) {
            $user = Session_Control::getDataSession('userEdit');


            $item = $user->permissoesLst[$post->id];

            if ($item->getGrupo() == 'S') {
                $br->setAlert('Permissões', 'Permissões do grupo não podem ser editadas. <br />Para autorizar ou negar a permissão, insira ela no usuário.', 380, 140);
                $br->send();
                exit;
            }
            if ($item->getVer() == 'S') {
                $chkVer = true;
            }
            if ($item->getInserir() == 'S') {
                $chkInserir = true;
            }
            if ($item->getExcluir() == 'S') {
                $chkExcluir = true;
            }
            if ($item->getEditar() == 'S') {
                $chkEditar = true;
            }
        }

        $form = new Ui_Form();
        $form->setAction('Permissao');
        $form->setName('formPermissaoEdit');

        $processos = new Ui_Element_Select('processo');
        if (isset($post->id)) {
            $processos->addMultiOption($item->getId_processo(), $item->getDescricao());
        } else {
            $processos->addMultiOptions($listaProcessos);
        }
        $form->addElement($processos);

        $element = new Ui_Element_Checkbox('ver', 'Ver');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cTRUE);
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('inserir', 'inserir');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cTRUE);
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('excluir', 'excluir');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cTRUE);
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('editar', 'editar');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cTRUE);
        $form->addElement($element);

        $btnSalvar = new Ui_Element_Btn('btnSalvar');
        $btnSalvar->setDisplay('Salvar', PATH_IMAGES . 'Buttons/Ok.png');
        $btnSalvar->setAttrib('sendFormFields', '1');
        $btnSalvar->setAttrib('params', 'id=' . $post->id);
        $form->addElement($btnSalvar);

        $btnCancelar = new Ui_Element_Btn('btnCancelar');
        $btnCancelar->setDisplay('Cancelar', PATH_IMAGES . 'Buttons/Cancelar.png');
        $form->addElement($btnCancelar);

        $form->setDataForm($item);

        $view = Zend_Registry::get('view');

        $w = new Ui_Window('insertPermissao', 'Permissões', $form->displayTpl($view, 'Permissoes/edit.tpl'));
        $w->setDimension('600', '300');
        $w->setCloseOnEscape(true);
        $br->newWindow($w);
        $br->send();
    }

    public function btncancelarclickAction() {
        $br = new Browser_Control();
        $br->setRemove('insertPermissao');
        $br->send();
    }

}
