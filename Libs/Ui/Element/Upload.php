<?php
class Ui_Element_Upload extends Zend_Form_Element{

	public $helper = 'formUpload';
	public $dataToSend = array();
	public function init(){
		$this->addDecorator('ViewHelper');
		$this->cancelImg = PATH_SCRIPTS.'Upload/Images/cancel.png';
		$this->uploader = PATH_SCRIPTS.'Upload/uploadify.swf';
		Browser_Control::setScript('js', 'Upload', 'Upload/Upload.js');
		Browser_Control::setScript('js', 'SwfUpload', 'Upload/Swfobject.js');
		Browser_Control::setScript('css', 'Upload', 'Upload/Upload.css');
	}

	/**
	 *
	 * @param string $textButton texto que vai aparecer no botao
	 * @param string $controllerAction controlador e a action q ele vai chamar quando for
	 * @param bool $multiSelecao para ativar multi selecao de arquivos para upload
	 * @param bool $autoEnvio se e pra enviar os arquivo automaticamente ao termino da selecao dos arquivos
	 */
	public function setParams($textButton, $controllerAction, $multiSelecao = false, $autoEnvio = true){
		$this->buttonText = $textButton;
		$this->script = $controllerAction;
		$this->multi = $multiSelecao;
		$this->auto = $autoEnvio;
	}

	/**
	 * para enviar os dados de formulario junto com a imagem no upload
	 * informar o id do formulario
	 *
	 * @param string $idForm
	 */
	public function sendFormFields($idForm){
		$this->sendFormFields = $idForm;
	}

	/**
	 *
	 * dados enviados no post usei esta opção pois no firefox quando setavamos algo na sessão se perdia os dados;
	 *
	 **/
	public function addDataSend($name, $val){
		$this->dataToSend[] = "'".$name."':'".$val."'";
                
		$this->data = "{".  implode(',', $this->dataToSend)."}";
	}

	/**
	 *  seta qual funcao vai ser executada ao terminar o(s) upload(s
	 * @param string $val nome da funcao
	 */
	public function setFunctionOnComplete($val){
		$this->onComplete = $val;
	}

	/**
	 *  seta qual botao vai iniciar a acao de upload dos arquivos
	 * @param string $id
	 */
	public function setButtonEvent($id){
		$this->btnExeUpload = $id;
	}

	/** seta o id de onde vai ser colocada a fila
	 *
	 * @param string $id
	 */
	public function setOndeMostraFila($id){
		$this->queueID = $id;
	}

	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}