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
            // ==========================================================

            include_once './Application/Controllers/IndexController.php';
            $view->assign('menu', IndexController::getMenu());
            $view->assign('NomeSistema', cNOME_SISTEMA);
            $view->assign('usuarioLogado',      Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('nomeUsuario',        Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('loggeduserlastname', Session_Control::getPropertyUserLogado('lastname'));
            $view->assign('loggeduserPhoto',    Session_Control::getUserLogadoPhotoPath());
            $view->assign('ano', date('Y'));
            $view->assign('permissoesLst',      Session_Control::getPropertyUserLogado('permissoesLst'));
//    $view->assign('ListaAcaoTopo', RncAcao::getListaRncAcaoTopo($view));
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
