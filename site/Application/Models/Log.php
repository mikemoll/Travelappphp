<?php
/**
 * Classe para inserção dos logs do sistema na base de dados
 *
 */
class Log extends Db_Table {
	protected $_name = 'log';
	public $_primary = 'id_log';
	protected $_log_ativo = false;

	public function init(){
		$this->setUsuario(Session_Control::getPropertyUserLogado('nomecompleto'));
		$this->setIp($_SERVER['REMOTE_ADDR']);
		$this->setController(Zend_Registry::get('controller'));
		$this->setAct(Zend_Registry::get('act'));
	}
	
	public static function gridLogs($id, $controller, $w = 545, $h = 175){
		$gridLogs = new Ui_Element_Grid('gridLogs');
		$gridLogs->setParams('Logs', BASE_URL . 'Log/listaLogs/id/'.$id.'/controller/'.$controller);
		$gridLogs->setController('Log');
		$gridLogs->setDimension($w, $h);
		$gridLogs->setEventEdit('');

		$column = new Ui_Element_Grid_Column_Check('id', 'id_log', '30', 'center');
		$column->setHide();
		$gridLogs->addcolumn($column);

		$column = new Ui_Element_Grid_Column_Text('Descricao', 'descricao', '430');
		$gridLogs->addColumn($column);

		$column = new Ui_Element_Grid_Column_Text('Usuário', 'usuario');
		$gridLogs->addColumn($column);

		$column = new Ui_Element_Grid_Column_Text('Data/Hora', 'datahora');
		$gridLogs->addColumn($column);

		return $gridLogs;
	}

	/**
	 * Grava um log no banco de dados
	 * pega automaticamente se estiver logado o usuario e o ip utilizado
	 * @param int $id_owner - id do pai
	 * @param string $descricao - ex: valor da descricao mudado de 'teste' para 'teste_1'
	 * @param int $tipo - consulta SQL, Ação de tentativa de acesso a paginas negadas;
	 * @param int $acao - novo, excluir, atualização
	 * @return void
	 */
	public static function createLog($id_owner, $descricao, $tipo, $acao = 0){
		$log = new Log;
		$log->setId_Owner($id_owner);
		$log->setDescricao($descricao);
		$log->setTipo($tipo);
		$log->setAcao($acao);
		$log->save();
	}

	/**
	 * Grava um log  no banco de dados
	 * pega automaticamente se estiver logado o usuario e o ip utilizado
	 *
	 * OBS: caso haja outro log este logo de sql deve SEMPRE ficar acima do outro
	 * caso ele fique abaixo ele irá pegar o sql de insert do log anterior
	 *
	 * @param obj $obj - objeto que esta sendo executado o sql
	 * @param int $id_owner - id do pai
	 * @param int $tipo - consulta SQL, Ação de tentativa de acesso a paginas negadas;
	 * @param int $acao - novo, excluir, atualização
	 * @return void
	 */
	public static function createLogSql($obj, $id_owner, $tipo, $acao = ''){

		$adapter = $obj->getAdapter();

		$profiler = $adapter->getProfiler();

		$query = $profiler->getLastQueryProfile();
		$string = $query->getQuery();
		$params = $query->getQueryParams();
		foreach($params as $value){
			$string = substr_replace($string, "'".$value."'", strpos($string, '?'), 1);
		}

		$string = str_replace('"', '', $string);
		$string = str_replace("''", 'null', $string);

		Log::createLog($id_owner, $string, $tipo, $acao);
	}
	/**
	 * recebe um objeto com os campos modificados, faz uma consulta no banco deste obejto com os dados originais
	 * e apos faz uma verificação campo a campo para verificar quais campos foram modificados gerando uma string
	 * com todos os campos modificados e assim inserindo esta string na tabela de logs
	 *
	 * @param object $obj
	 * @param String $texto
	 */
	public static function createLogCampos($obj, $texto = ''){
		$nomeClass = get_class($obj);

		$item = new $nomeClass;
		$item->setRemoveJoin();
		$item->read($obj->getID());

		//print_r($item);die('<br><br>\n\n' . ' Linha: ' . __LINE__ . ' Arquivo: ' . __FILE__);
		
		$varsObjOld = get_object_vars($item);
		$varsObjNew = get_object_vars($obj);

		$sep = '';
		foreach ($varsObjOld as $keyOld => $valueOld) {
			
			if (!is_object($valueOld) && !is_array($valueOld) && substr_compare($keyOld, "a_", 0, 2) == 0) {
				if (strcasecmp($valueOld, $varsObjNew[$keyOld]) != 0) {
					if($valueOld == ''){
						$valueOld = 'vazio';
					}
					if($varsObjNew[$keyOld] == ''){
						$varsObjNew[$keyOld] = 'vazio';
					}
					$string .= $sep . 'Valor do campo <b>' . substr($keyOld, 2) . '</b> foi alterado de <b>' . $valueOld . '</b> para <b>' . $varsObjNew[$keyOld] . '</b>.';
					$sep = ' <br /> ';
				}
			}
		}
		if ($string != '') {
			if ($texto != '') {
				$string = $texto . ' <br /> ' . $string;
			}

			if($obj->getOwner() != ''){
				Log::createLog($obj->getOwner(), $string, cLOG_CAMPOS, cLOG_ACAO_UPDATE);
			}else{
				Log::createLog($obj->getID(), $string, cLOG_CAMPOS, cLOG_ACAO_UPDATE);
			}
			return true;
		}else{
			return false;
		}
	}
	public static function createLogFile($string, $tipo = Zend_Log::INFO){
		$string .= ' - ip: ' . $_SERVER['REMOTE_ADDR'] . ' - Data: ' . date('d/m/Y') . ' - Hora: ' . date('H:m:s');

//		$writer = new Zend_Log_Writer_Stream('/var/www/'.BASE.'/Opertur/Application/Log/log.txt');
//		$logger = new Zend_Log($writer);

//		$logger->log($string, $tipo);
	}
}