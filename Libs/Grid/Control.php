<?php
class Grid_Control{

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
	public static function setDataGridJson($colunas, $page, $total, $rows, $id = '', $return = false) {


		$post = Zend_Registry::get('post');

		Session_Control::setDataSession('row_'.$post->idGrid, 0);

		$json = '{';
		$json .= '"page":"' . $page . '",';
		$json .= '"total":"' . $total . '",';
		$json .= '"rows": [';
		$separator = '';

		$pos = 0;
		// VERIFICAR ######################################
		if (is_array($rows)) {
			foreach ($rows as $row) {
				if(!isset($row['state']) || $row['state'] != cDELETE){
					$json .= $separator . '{';
					if($id != ''){
						$json .= '"id":"' . $row[$id] . '",';
					}else{
						$json .= '"id":"' . $pos . '",';
					}
					$json .= '"cell":[';
					$separator1 = '';
					foreach ($colunas as $col) {
						$nomeColuna = $col->getName();
						$json .= $separator1 . '"' . $col->render($row[$nomeColuna]) . '"';
						$separator1 = ',';
					}
					$json .= ']}';
					$separator = ',';
					$pos++;
				}
			}
		} else if (is_object($rows)) {
			if($rows->getItens() != ''){
				$itens = $rows->getItens();
			}else{
				$itens = array();
			}

			foreach ($itens as $key => $row) {
				if (!$row->deleted()) {

					$json .= $separator . '{';

					if($id != ''){
						if(is_string($id)){
							$nome = 'get'.$id;
							$oid = $row->$nome();
						}else{
							$oid = $row->getOID();
						}
					}else{
						$oid = $key;
					}

					$json .= '"id":"' . $oid . '",';
					$json .= '"cell":[';
					$separator1 = '';

					foreach ($colunas as $col) {
						$nomeColuna = $col->getName();
						if(trim($nomeColuna) != ''){
							$json .= $separator1 . '"' . $col->render($oid, $row) . '"';
							$separator1 = ',';
						} else {
							$json .= $separator1 . "''";
							$separator1 = ',';
						}
					}

					$json .= ']}';
					$separator = ',';
				}
			}
		}

		$json .= "]}";
		if($return){
			return $json;
		}else{
			echo $json;
		}
	}

        /**
         *  preenche o grid
         * 
         * @param obj|string $model lista que vai preencher o grid | classe que vai preencher o grid
         * @param bool $return se quer que o json do grid seja retornado ou não.
         * @param bool $colocaOID se é para colocar o <code>id</code> nas linhas do grid. essa opção serve para grid em que se quer que ele envie a linha ou o id no dblClick
         * @return type
         */
	public static function setDataGrid($model, $return = false, $colocaOID = true){
		$post = Zend_Registry::get('post');
		$columns = Session_Control::getDataSession($post->idGrid);
                
		if(is_object($model)){
			$id = $model->getPrimaryName();
			$obj = $model;
			if(!$colocaOID){
				$id = '';
			}
		}else if(is_string($model)){
			$obj = new $model;
			if(!$colocaOID)
                            $id = $obj->getPrimaryName();
		}
                if($obj->countItens()==0){
                    $post->page = 1;
                    $obj->setReadCount();
                    $obj->limit($post->page, $post->gridNoticias_length);
                    if($post->sortname != ''){
                            $obj->sortOrder($post->sortname ,	$post->sortorder);
                    }
                    $obj->readLst();
                }
                $totalItens = $obj->getTotalItens()>0?$obj->getTotalItens():$obj->countItens();
                
		$dataGrid = Grid_Control::setDataGridJson($columns, $post->page,$totalItens , $obj, $id, $return);

		if($return){
			return $dataGrid;
		}
	}

	public static function setDataGridFromMemory(){

	}
        
	/**
         * Esse metodo pode executar duas ações. deletar do DB os iten ou Marcar pala deleção.
         *
	 * Para atualizar mais de um grid passar o parametro $idGrid como um array com os ids dos grid, caso for apenas um grid pode
	 * ser passado apenas uma String como id.
	 *
	 * @param String $Instance Nome da instancia da classe de lista do grid (para marcar para deleção)| Classe de lista do grid (para deletar os itens do DB)
	 * @param String $NomeLista Para casos em que a lista a ser marcada para deleção está dentro do Objeto passado no parametro <code>$Instance</code>
	 * @param String|Array $idGrid id do grir a ser atualizado
	 */
	public static function deleteDataGrid($instance, $nomeLista, $idGrid = '') {
		$post = Zend_Registry::get('post');

		$objOfInstance = Db_Table::getInstance($instance);
		if ($objOfInstance != '') {
			if ($nomeLista == ''){
				$list = &$objOfInstance;
			}else{
				$list = &$objOfInstance->$nomeLista;
			}
			for ($i = 0; $i < $post->rp; $i++) {
				$chk = 'gridChk_' . $i;
//                                die(print_r( $post->$chk ));
				if ($post->$chk != '') {
					$item = $list->getItem($post->$chk);
					$item->setDeleted();
				}
			}

			$objOfInstance->setInstance($instance);

		} else {
			for ($i = 0; $i < $post->rp; $i++) {
				$chk = 'gridChk_' . $i;
				if ($post->$chk != '') {
					$table = new $instance;
					$table->read($post->$chk);
					$table->setDeleted();
					$table->save();
				}
			}
		}

		if ($idGrid != '') {
			$br = new Browser_Control();
			if(is_array($idGrid)){
				foreach ($idGrid as $val){
					$br->setUpdateGrid($val);
				}
			}else{
				$br->setUpdateGrid($idGrid);
			}
			$br->send();
		}
	}
}