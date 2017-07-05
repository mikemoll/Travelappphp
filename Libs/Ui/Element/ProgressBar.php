<?php
class Ui_Element_ProgressBar extends Zend_Form_Element{

	public $helper = 'formProgressBar';
	public function init(){
		$this->addDecorator('ViewHelper');
		Browser_Control::setScript('js', 'ProgressBar', 'ProgressBar/ProgressBar.js');
		Browser_Control::setScript('css', 'ProgressBar', 'ProgressBar/ProgressBar.css');

                
	}

	/**
	 *
	 * @param string $textButton texto que vai aparecer no botao
	 * @param string $controllerAction controlador e a action q ele vai chamar quando for
	 * @param bool $multiSelecao para ativar multi selecao de arquivos para upload
	 * @param bool $autoEnvio se e pra enviar os arquivo automaticamente ao termino da selecao dos arquivos
	 */
	public function setParams( $width = '100%', $height = '20px'){
		
		$this->width = $width;
		$this->height = $height;

                $this->valor= $this->getValue();
	}


	public function setVisible($processo, $acao = ''){
		if(!Usuario::verificaAcesso($processo, $acao)){
			$this->removeDecorator('ViewHelper');
		}
	}
}