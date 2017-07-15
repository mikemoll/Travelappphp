<?php

include_once 'AbstractController.php';

/**
 *  Search and Dreamboard
 * 
 * @author Leonardo Danieli <leonardo.danieli@gmail.com>
 * @version 1.0
 * 
 */
class DreamboardController extends AbstractController {

    public function init() {
        parent::init();
        $this->IdGrid = 'grid';
        $this->FormName = 'formDreamboard';
        $this->Action = 'Dreamboard';
        $this->TituloLista = "Dreamboard";
        $this->TituloEdicao = "Dreamboard";
        $this->ItemEditInstanceName = 'DreamboardEdit';
        $this->ItemEditFormName = 'formDreamboardItemEdit';
        $this->Model = 'Dreamboard';
        $this->IdWindowEdit = 'EditDreamboard';
        $this->TplDreamboard = 'Dreamboard/index.tpl';
        $this->TplEdit = 'Dreamboard/edit.tpl';
    }

    public function dashboardAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');

        $dreamLts = new Dreamboard;
        $dreamLts->where('dreamboard.id_usuario', Usuario::getIdUsuarioLogado());
        $dreamLts->readLst();
//        print'<pre>';
//        die(print_r($dreamLts));
        $ActivityLst = new Activity();
        $EventLst = new Event();
        for ($i = 0; $i < $dreamLts->countItens(); $i++) {
            $dream = $dreamLts->getItem($i);
            // ---- Activities ----------
            $ActivityLst->where('activity.id_activity', $dream->getId_Activity(), '=', 'or', 'id');
            // ---- Events ----------
            $EventLst->where('event.id_event', $dream->getId_Event(), '=', 'or', 'id');
        }
        $ActivityLst->readLst();
        $view->assign('activityLst', $ActivityLst->getItens());
        $EventLst->readLst();
        $view->assign('eventLst', $EventLst->getItens());

//        $view->assign('url', $this->Action);
        $view->assign('scriptsJs', Browser_Control::getScriptsJs());
        $view->assign('scriptsCss', Browser_Control::getScriptsCss());
        $view->assign('titulo', $this->TituloEdicao);
        $view->assign('TituloPagina', $this->TituloEdicao);
        $view->assign('body', $view->fetch('Explore/index.tpl'));
        $view->output('index.tpl');
    }

}
