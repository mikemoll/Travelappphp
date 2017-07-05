<?php
class Ui_Window{

	private $id;
	private $title;
	private $html;
	private $modal;
	private $position;
	private $width;
	private $height;
	private $autoOpen;
	private $resizable;
	private $dragglable;
	private $show;
	private $hide;
	private $closeOnEscape = true;
	private $zIndex;

	/**
	 * Configuras as opções de apresentação da janela como titulo, posição, e se e modal
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $html
	 * @param string $modal
	 * @param string $position
	 */
	public function __construct($id, $title = '', $html = '', $modal = 'false', $position = 'center'){
		$this->id = $id;
		$this->title = $title;
		$this->html = $html;
		$this->modal = $modal;
		$this->position = $position;
		$this->resizable = 'false';
	}
	/**
	 * Configura o tamanho da janela
	 *
	 * @param integer $width
	 * @param integer $height
	 */
	public function setDimension($width = '200', $height = '200'){
		$this->width = $width;
		$this->height = $height;
	}
	/**
	 * Configura se a janela já aparece aberta na tela;
	 *
	 * @param bool $auto
	 */
	public function setAutoOpen($auto = 'false'){
		$this->autoOpen = $auto;
	}
	/**
	 * Configura a janela para ela poder ou não ser redimencionada
	 *
	 * @param bool $resizable
	 */
	public function setResizable($resizable = 'true'){
		$this->resizable = $resizable;
	}
	/**
	 * Configura a janela para não deixar ele ser movimentada na tela
	 *
	 * @param bool $drag
	 */
	public function setNotDraggable($drag = 'false'){
		$this->draggable = $drag;
	}
	/**
	 * Tipos de efeitos na abertura da janela e quando ela e fechada
	 *
	 * @param text $show
	 * @param text $hide
	 */
	public function setEffect($show = '', $hide = ''){
		$this->show = $show;
		$this->hide = $hide;
	}
	/**
	 * Se falso a janela não fechara quando apertado o esc
	 *
	 * @param bool $escape
	 */
	public function setCloseOnEscape($escape = 'false'){
		$this->closeOnEscape = $escape;
	}
	/**
	 * Confgura o zIndex do elemento na tela
	 *
	 * @param integer $zIndex
	 */
	public function setZIndex($zIndex){
		$this->zIndex = $zIndex;
	}

	public function render(){

		$html = '';
		$sep = '';

		$attribs = get_object_vars($this);
		$options = '{';
		foreach ($attribs as $key => $value){
			if($key != 'html' and $key != 'id'){
				if($value != ''){
					if($value != 'false' && $value != 'true'){
						$options .= $sep .  $key . ':"' . $value . '"';
					}else{
						$options .= $sep .  $key . ':' . $value;
					}
					$sep = ', ';
				}
			}
		}
		$options .= ', close: function(event, ui){$(this).remove();}';
		$options .= '}';


		$html .= '<div id="' . $this->id . '" title="' . $this->title . '" style="display:none;">';
		$html .= '<script type="text/javascript">';
		$html .= "$(document).ready(function(){ $('#" . $this->id . "').dialog(";
		$html .= $options;
		$html .= ');})';
		$html .= '</script>';
		$html .= $this->html;
		$html .= '</div>';



		return $html;
		//print_r($html); die("<br /><br />" . __FILE__ . " - " . __LINE__);
	}

}