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

 

}
