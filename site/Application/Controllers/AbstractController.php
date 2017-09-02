<?php

class AbstractController extends Zend_Controller_Action {

    public $IdGrid; // = 'gridOrdemServico';
    public $FormName; // = 'formOrdemServico';
    public $Action; // = 'OrdemServico';
    public $TituloLista; // = "Ordem de Serviço";
    public $TituloEdicao; // = "Edição";
    public $ItemEditInstanceName; // = 'OrdemServicoEdit';
    public $ItemEditFormName; // = 'formOrdemServicoItenEdit';
    public $Model; // = 'OrdemServico';
    public $IdWindowEdit; // = 'EditOrdemServico';
    public $TplIndex; // = 'OrdemServico/index.tpl';
    public $TplEdit; // = 'OrdemServico/edit.tpl';

    public function init() {
        parent::init();
        $post = Zend_Registry::get('post');

        if (!$post->ajax) {
            // ----- It just get inside this if, if this is not an ajax request ---
            $view = Zend_Registry::get('view');
            // ==========================================================
            // Framework js
            Browser_Control::setScript('js', 'BorwserControl', '../Browser/Control.js');
            // Framework Ui
//        Browser_Control::setScript('js', 'Tabs', 'Ui/Ui.js');
//        Browser_Control::setScript('css', 'Tabs', 'Ui/Ui.css');
//        Browser_Control::setScript('css', 'Padrao', '../../site/Public/Css/Padrao.css');
            Browser_Control::setScript('css', 'Style', '../../site/Public/assets/css/style.css');
            // ==========================================================

            include_once './Application/Controllers/IndexController.php';
            $view->assign('menu', IndexController::getMenu());
            $view->assign('NomeSistema', cNOME_SISTEMA);
            $view->assign('usuarioLogado', Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('nomeUsuario', Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('userEmail', Session_Control::getPropertyUserLogado('email'));
            $view->assign('userCreatedAtUnixTimestamp', date_timestamp_get(date_create(Session_Control::getPropertyUserLogado('created_at'))));
            //$view->assign('userCreatedAtUnixTimestamp', time());
            $view->assign('loggeduserlastname', Session_Control::getPropertyUserLogado('lastname'));
            $view->assign('loggeduserPhoto', Session_Control::getUserLogadoPhotoPath());
            $view->assign('ano', date('Y'));
            $view->assign('permissoesLst', Session_Control::getPropertyUserLogado('permissoesLst'));
//    $view->assign('ListaAcaoTopo', RncAcao::getListaRncAcaoTopo($view));
            // ================== form Search =====================
            $form = new Ui_Form();
            $form->setAction('explore');
            $form->setName('search');

            $element = new Ui_Element_Text('search2');
            $element->setPlaceholder('Search for places, activities or events');
            $element->setAttrib('hotkeys', 'enter, btnSearch, click');
//        $element->addClass('search-link');
            $element->setAttrib('class', 'form-control search-link');
            $element->setValue($q);
            $form->addElement($element);

            list($StartDate, $EndDate) = explode('_', $post->daterange);
            $element = new Ui_Element_Date('startdate');
            $element->setAlternativeField('enddate');
            $element->setValue(DataHora::inverteDataIngles($StartDate));

            $form->addElement($element);

            $element = new Ui_Element_Date('enddate');
            $element->setValue(DataHora::inverteDataIngles($EndDate));
            $form->addElement($element);



            $element = new Ui_Element_Select('typeFilter', 'Type');
            $element->addMultiOption('', '- select -');
            $element->addMultiOption('E', 'Event');
            $element->addMultiOption('A', 'Activity'); 
//            $element->setAttrib('event', 'change');
//            $element->setAttrib('url', 'explore');
            $form->addElement($element);



            $button = new Ui_Element_Btn('btnSearch');
            $button->setDisplay('', 'search');
//            $button->setAttrib('class', 'btn btn-primary btn-animated from-left fa fa-search');
            $button->setType('primary');
            $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
            $form->addElement($button);

            $button = new Ui_Element_Btn('btnFeelingLucky');
            $button->setDisplay('Feeling lucky', '');
//        $button->setType('success');
            $button->setSendFormFiends();
//        $button->setAttrib('validaObrig', '1');
            $form->addElement($button);

            $button = new Ui_Element_Btn('btnApplyDate');
            $button->setDisplay('Apply', '');
            $button->setAttrib('class', 'btn btn-sm');
            $button->setAttrib('params', $links['base']);
            $button->setSendFormFiends();
            $button->setAttrib('url', 'explore');
//        $button->setAttrib('validaObrig', '1');
            $form->addElement($button);

            $form->setDataSession();

            $view->assign('formSearch', $form->displayTpl($view, 'Explore/form_search.tpl'));
        }
// ==========================================================
    }

    public function listAction() {
//        $post = Zend_Registry::get('post');
        $obj = new $this->Model();
        $obj->readLst();
        Grid_ControlDataTables::setDataGrid($obj, false, true);
    }

    public function bloqueialoadAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $obj = Fichatecnica::getInstance($post->sessionname, $post->myid);
        $bloq = $obj->bloqueia();
        if (!$bloq) {
            $br->setMsgAlert("Bloqueado!", "Somente Leitura. Aberto por <strong>{$obj->getBloqueadoPorNome()}</strong> há {$obj->getTempoBloqueado()} seg", 'alert-warning');
        } else {
//            $br->setMsgAlert("Desbloqueado!", "");
        }
        $br->send();
    }

    public function __call($method, $args) {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if ('Action' == substr($method, -6) and 'index' != substr($method, 0, 5)) {
                // If the action method was not found, forward to the
                // index action
                return $this->forward('index');
            } elseif ('index' == substr($method, 0, 5)) {
                $this->_redirect(HTTP_REFERER . 'index');
            }
        } else {
            $br = new Browser_Control();
            $br->setAlert("Request Error!", "There is something wrong with your request!<br><br>The action called doesn't exist<br><br><strong> " . strtolower($_SERVER['REQUEST_URI']) . "</strong> ");
            $br->send();
        }
    }

    public function btncancelclickAction() {
        $br = new Browser_Control();
        $br->setBrowserUrl(BASE_URL . $this->Action);
        $br->send();
    }

    public function btncloseclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setRemoveWindow($post->IdWindowEdit);
        $br->send();
    }

    public function btndeleteclickAction() {
        $br = new Browser_Control();
        Grid_ControlDataTables::deleteDataGrid($this->Model, '', $this->IdGrid, $br);
        $br->setMsgAlert('Deleted', 'Item deleted!');
        $br->send();
    }

}
