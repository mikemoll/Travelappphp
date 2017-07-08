<?php

include_once 'AbstractController.php';

class CurrencyController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formCurrency';
        $this->Action = 'Currency';
        $this->TituloLista = "Currency";
        $this->TituloEdicao = "Currency";
        $this->ItemEditInstanceName = 'CurrencyEdit';
        $this->ItemEditFormName = 'formCurrencyItemEdit';
        $this->Model = 'Currency';
        $this->IdWindowEdit = 'EditCurrency';
        $this->TplIndex = 'Currency/index.tpl';
        $this->TplEdit = 'Currency/edit.tpl';
    }

    public function indexAction() {
        $post = Zend_Registry::get('post');
        $form = new Ui_Form();
        $form->setName($this->FormName);
        $form->setAction($this->Action);

        ////-------- Grid   --------------------------------------------------------------
        $form = new Ui_Form();
        $form->setName($this->FormName);
        $form->setAction($this->Action);

        $idGrid = $this->IdGrid;
        $grid = new Ui_Element_DataTables($idGrid);
        $grid->setParams('', BASE_URL . $this->Action . '/list');
//        $grid->setShowLengthChange(false);
//        $grid->setShowPager(false);
        $grid->setOrder('name', 'desc');
//        $grid->setFillListOptions('FichaTecnica', 'readFichatecnicaLst');


        // $element = new Ui_Element_DataTables_Button('btnNew', 'New Item');
        // $element->setImg('plus');
        // $element->setVisible('PROC_CURRENCY', 'insert');
        // $grid->addButton($element);

        $button = new Ui_Element_DataTables_Button('btnEdit', 'Edit');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_CURRENCY', 'edit');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnDelete', 'Delete');
        $button->setImg('trash');
        $button->setAttribs('msg = "Delete the selected currency?"');
        $button->setVisible('PROC_CURRENCY', 'delete');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Date('Currency Name', 'name');
        $column->setWidth('1');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Symbol', 'symbol');
        $column->setWidth('1');
        $grid->addColumn($column);


        Session_Control::setDataSession($grid->getId(), $grid);
        $form->addElement($grid);

        // =========================================================================
//
        $button = new Ui_Element_Btn('btnNew');
        $button->setDisplay('New Item', 'plus');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setType('success');
        $button->setVisible('PROC_CURRENCY', 'insert');
        $form->addElement($button);


        $view = Zend_Registry::get('view');

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloLista);
        $view->assign('TituloPagina', $this->TituloLista);

        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function editAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
//        $id_indicador = $post->id;

        $view = Zend_Registry::get('view');
        if (isset($post->id)) {
            // if some field needs to be readonly on the item edition, use this variable;
//            $readOnly = true;
        }


        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Text('name', "Currency Name");
        $element->setAttrib('maxlenght', 45);
        $form->addElement($element);


        $element = new Ui_Element_Text('symbol', "Symbol");
//        $element->setTinyMce();
        $element->setAttrib('maxlenght', 4);
        $form->addElement($element);

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);

        $button = new Ui_Element_Btn('btnSave');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancel');
        $cancelar->setAttrib('params', 'IdWindowEdit=' . $this->IdWindowEdit);
        $cancelar->setDisplay('Cancel', 'times');
        $cancelar->setHref(HTTP_REFERER . $this->Action );
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    public function btnnewclickAction() {
        $this->edit();
    }

    public function btnsaveclickAction($enviar = false) {
        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;
        $br = new Browser_Control();

        /* @var $lObj */
        $lObj = Currency::getInstance($this->ItemEditInstanceName);
        $form = Session_Control::getDataSession($this->ItemEditFormName);

        $lObj->setDataFromRequest($post);
//        print'<pre>';die(print_r( $lObj ));
        try {
            $lObj->save();
            $lObj->setInstance($this->ItemEditInstanceName);
        } catch (Exception $exc) {
            $br->setAlert('Erro!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $msg = 'Changes saved!';
        $br->setMsgAlert('Saved!', $msg);
        $br->setBrowserUrl(BASE_URL . 'currency');
        $br->send();

    }

    public function viewAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');
        $idUsuario = Usuario::getIdUsuarioLogado();

        $obj = new $this->Model();
        if (isset($post->id)) {
            $obj->read($post->id);
        }
        $obj->setInstance($this->ItemEditInstanceName);
        if ($obj->found() and ( Usuario::verificaAcesso('PROC_MENSAGENS', 'insert') or $obj->getUsuarioTemAcesso($idUsuario) )) {
            $obj->setVisualizada($idUsuario);

            $view->assign('titulo', 'Cominicação Interna');

            if (Usuario::verificaAcesso('PROC_MENSAGEM', 'edit')) {
                $view->assign('id_mensagem', $obj->getID());
            }
            $view->assign('TituloPagina', $obj->getAssunto());
            $view->assign('Assunto', $obj->getAssunto());
            $view->assign('Currency', $obj->getCurrency());
            $view->assign('Remetente', $obj->getNomeRemetente());
            $view->assign('DataCadastro', $obj->getDataCadastro());
            if (Usuario::verificaAcesso('PROC_MENSAGENS', 'insert')) {
                $view->assign('visualizacoes', $obj->getListaVisualizacoes());
            }
        } else {

            $view->assign('titulo', 'Currency not found');
            $view->assign('TituloPagina', 'Currency not found');
            $view->assign('Assunto', 'Currency not found');
            $view->assign('Remetente', 'Administrator');
            $view->assign('Currency', 'The currency you are trying to access is not available.');
        }

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('body', $view->fetch('Currency/view.tpl'));
        $view->output('index.tpl');
    }

}
