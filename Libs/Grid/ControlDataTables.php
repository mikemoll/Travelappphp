<?php

class Grid_ControlDataTables {

    /**
     * Função que retorno a arquivo Json necessario para a biblioteca
     * montar o Grid.
     *
     * Parametro $id opcional se não declarado o valor padrão e 'id'
     *
     * @param 	$colunas colunas que o grid está usando
     * @param 	$page pagina q é para o grid mostrar
     * @param 	$total total de registros
     * @param 	$rows lista de objetos ex UsuariosLst ou array
     * @param 	$id [optional] o $id pode ser passado três tipos um Bollean, String ou vazio (null) no primeiro caso será colocado o OID do
     * objeto, caso seja uma string será executado o get no objeto para pegar o campo e no ultimo caso será colocado a posição do objeto na
     * memoria
     * @return 	Arquivo Json para o Flexigrid
     */
    public static function setDataGridJson($colunas, $buttons, $page, $rows, $id = '', $return = false) {

        $post = Zend_Registry::get('post');
        $columns = Session_Control::getDataSession($post->idGrid);

        Session_Control::setDataSession('row_' . $post->idGrid, 0);

        if (is_object($rows)) {
            if ($rows->getItens() != '') {
                $itens = $rows->getItens();
            } else {
                $itens = array();
            }
        } elseif (is_array($rows)) {
            $itens = $rows;
        }
        $itemLst['data'] = array();
        $filtro = $columns->filter;
        if ($filtro != '') {
            $get = "get" . $filtro['prop'];
            $oper = $filtro['oper'];
            $val = $filtro['val'];
        }
        $cond = true;
        foreach ($itens as $key => $row) {
            if ($filtro != '') {
                //executa a filtragem dos itens caso o grid tenha um filtro
                eval('$cond = $row->$get() ' . $oper . ' ' . $val . '? true : false;');
            }
            if (!$row->deleted() and $cond) {

                $item = array();

                if ($id != '') {
                    if (is_string($id)) {
                        $nome = 'get' . $id;
                        $oid = $row->$nome();
                    } else {
                        $oid = $row->getID();
                    }
                } else {
                    $oid = $key;
                }

                foreach ($colunas as $col) {
                    $nomeColuna = $col->getName();
                    if (trim($nomeColuna) != '') {
                        $item[] = $col->render($oid, $row);
                    } else {
                        $item[] = "''";
                    }
                }

                if (count($buttons) > 0) {
                    $colButton = "<div class='btn-group btn-group-sm  btn-group-justified' style='width:" . (count($buttons) * 32) . "px'>";
                    foreach ($buttons as $button) {
                        $colButton .= $button->render($oid);
                    }
                    $colButton .=' </div> ';
                    $item[] = $colButton;
                }
                $itemLst['data'][] = $item;
            }
        }
//        print'<pre>';
//        die(print_r($itemLst));

        if ($return) {
            return $itemLst;
        } else {
            echo json_encode($itemLst);
        }
    }

    /**
     *  preenche o grid
     * 
     * @param obj|string $model lista que vai preencher o grid | classe que vai preencher o grid
     * @param bool $return [false] se quer que o json do grid seja retornado ou não.
     * @param bool $colocaOID [true] se é para colocar o <code>id</code> nas linhas do grid. essa opção serve para grid em que se quer que ele envie a linha ou o id no dblClick
     * @return type
     */
    public static function setDataGrid($model, $return = false, $colocaOID = true) {

        $post = Zend_Registry::get('post');
        $columns = Session_Control::getDataSession($post->idGrid);
        if (is_object($model)) {
            $id = $model->getPrimaryName();
            $obj = $model;
            if (!$colocaOID) {
                $id = '';
            }
        } else if (is_string($model)) {
            $obj = new $model;
            if (!$colocaOID)
                $id = $obj->getPrimaryName();
        }
//        if ($obj->countItens() == 0) {
//            $post->page = 1;
//            $obj->setReadCount();
////            $obj->limit($post->page, $post->gridNoticias_length);
//            if ($post->sortname != '') {
//                $obj->sortOrder($post->sortname, $post->sortorder);
//            }
//            $obj->readLst();
//        }
//        $totalItens = $obj->getTotalItens() > 0 ? $obj->getTotalItens() : $obj->countItens();

        $dataGrid = self::setDataGridJson($columns->getColumns(), $columns->getButtons(), $post->page, $obj, $id, $return);

        if ($return) {
            return $dataGrid;
        }
    }

    public static function setDataGridFromMemory() {
        
    }

    /**
     * Esse metodo pode executar duas ações. deletar do DB os iten ou Marcar pala deleção.
     *
     * Para atualizar mais de um grid passar o parametro $idGrid como um array com os ids dos grid, caso for apenas um grid pode
     * ser passado apenas uma String como id.
     *
     * @param String $instance Nome da instancia da classe de lista do grid (para marcar para deleção)| Classe de lista do grid (para deletar os itens do DB)
     * @param String $nomeLista Para casos em que a lista a ser marcada para deleção está dentro do Objeto passado no parametro <code>$Instance</code>
     * @param String|Array $idGrid id do grir a ser atualizado
     */
    public static function deleteDataGrid($instance, $nomeLista, $idGrid = '', &$br = false) {
        $post = Zend_Registry::get('post');

        $objOfInstance = Db_Table::getInstance($instance, $post->myid);
        if ($objOfInstance != '') {
            if ($nomeLista == '') {
                $list = &$objOfInstance;
            } else {
                $list = &$objOfInstance->$nomeLista;
            }
            $id = $post->id;
            if ($id != '') {
                if (is_array($list)) {
                    $item = $list[strtolower($id)];
                } else {
                    $item = $list->getItem($id);
                }
                $item->setDeleted();
                if (is_array($list)) {
                    $list[strtolower($id)] = $item;
                }
            } else {
                for ($i = 0; $i < $post->rp; $i++) {
                    $chk = 'gridChk_' . $i;
//                                die(print_r( $post->$chk ));
                    if ($post->$chk != '') {
                        $item = $list->getItem($post->$chk);
                        $item->setDeleted();
                    }
                }
            }

            $objOfInstance->setInstance($instance, $post->myid);
        } else {
            $id = $post->id;
            if ($id != '') {
                $item = new $instance();
                $item->read($id);
                $item->setDeleted();
                $item->save();
            }
        }


        if ($idGrid != '') {
            $oBRveioPorParametro = true;
            if (!$br) {
                $oBRveioPorParametro = false;
                $br = new Browser_Control();
            }
            if (is_array($idGrid)) {
                foreach ($idGrid as $val) {
                    $br->setUpdateDataTables($val);
                }
            } else {
                $br->setUpdateDataTables($idGrid);
            }
            if (!$oBRveioPorParametro) {
                $br->send();
            }
        }
    }

}
