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
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

// ==========================================================

        Browser_Control::setScript('js', 'Jquery', 'jquery.js');
        Browser_Control::setScript('js', 'BorwserControl', '../Browser/Control.js');
        Browser_Control::setScript('js', 'Tabs', 'Ui/Ui.js');
        Browser_Control::setScript('css', 'Tabs', 'Ui/Ui.css');
// ==========================================================
        $view->assign('nomeUsuario', Session_Control::getPropertyUserLogado('nomecompleto'));
// ==========================================================
        if (!$post->ajax) {
            include_once './Application/Controllers/IndexController.php';
            $view->assign('menu', IndexController::getMenu());
            $view->assign('NomeSistema', cNOME_SISTEMA);
            $view->assign('usuarioLogado', Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('nomeUsuario', Session_Control::getPropertyUserLogado('nomecompleto'));
            $view->assign('ano', date('Y'));
            $view->assign('permissoesLst', Session_Control::getPropertyUserLogado('permissoesLst'));
//    $view->assign('ListaAcaoTopo', RncAcao::getListaRncAcaoTopo($view));
        }
// ==========================================================

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
        if ('Action' == substr($method, -6) and 'index' != substr($method, 0, 5)) {
            // If the action method was not found, forward to the
            // index action
            return $this->forward('index');
        } elseif ('index' == substr($method, 0, 5)) {
            $this->_redirect(HTTP_REFERER . 'index');
        }
    }

    public function btncancelarclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();
        $br->setRemoveWindow($post->IdWindowEdit);
        $br->send();
    }

    public function btnexcluirclickAction() {
        Grid_ControlDataTables::deleteDataGrid($this->Model, '', $this->IdGrid);
    }

}
