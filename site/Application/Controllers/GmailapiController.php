<?php

include_once 'AbstractController.php';

class GmailapiController extends AbstractController {

    public function init() {
        parent::init();
        // $this->IdGrid = 'grid';
        // $this->FormName = 'formCurrency';
        $this->Action = 'Gmailapi';
        // $this->TituloLista = "Currency";
        $this->TituloEdicao = "Gmail API";
        // $this->ItemEditInstanceName = 'CurrencyEdit';
        $this->ItemEditFormName = 'formGmailapiEdit';
        // $this->Model = 'Currency';
        // $this->IdWindowEdit = 'EditCurrency';
        // $this->TplIndex = 'Currency/index.tpl';
        //$this->TplEdit = 'Gmailapi/test.tpl';
    }

    public function testAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName($this->ItemEditFormName);

        $element = new Ui_Element_Date('date', 'Select a date');
        $element->setRequired();
        $form->addElement($element);


        $button = new Ui_Element_Btn('btnruntest');
        $button->setDisplay('import', 'check');
        $button->setType('success');
        $button->setAttrib('click', '');
        $button->setAttrib('sendFormFields', '1');
        $form->addElement($button);

        $form->setDataSession();

        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $form->displayTpl($view, 'Gmailapi/test.tpl'));
        $view->output('index.tpl');
    }

    public function btnruntestclickAction() {
        $post = Zend_Registry::get('post');

        $br = new Browser_Control();
        //$this->_redirect('../google/email_import.php?date='.$post->date);
        file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/traveltrack/google/email_import.php?date='.$post->date);

        $br->setBrowserUrl(BASE_URL . 'Gmailapi/testresult');
        $br->send();
    }

    public function testresultAction() {
        //ob_start();
        //var_dump($_SESSION['gmailapi_jsons']);die();
        //$jsons = ob_get_contents();
        //ob_end_clean();

        $view = Zend_Registry::get('view');
        $view->assign('jsons', $_SESSION['gmailapi_jsons']);
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $view->fetch('Gmailapi/testresult.tpl'));
        $view->output('index.tpl');
    }
}
