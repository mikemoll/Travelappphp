<?php

class IndexController extends Zend_Controller_Action {

    public function init() {

        include_once './Application/ControllersWeb/WebController.php';
    }

    public function indexAction() {
        $this->redirect('web/index');
        exit;
    }

    public function aboutAction() {
        
    }

}
