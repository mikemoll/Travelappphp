<?php

include_once 'Abstract.php';

class Ui_Element_DataTables_Column_Image extends Ui_Element_DataTables_Column_Abstract {

    protected $img1;
    protected $img2;
    protected $link;

    /**
     * Adiciona o link para o botão
     * ex: http://www.google.com.br
     * @param String $link
     */
    public function setLink($link) {
        $this->link = $link;
    }
    public function setImages($imgTrue, $imgFalse){
		$this->img1 = $imgTrue;
		$this->img2 = $imgFalse;
	}


//	public function getParams(){
//		$column = '';
//		if($this->visible){
//			$column = "{display: '{$this->display}', name: '{$this->name}', width: {$this->width},
//			sortable: {$this->sortable}, align: '{$this->align}'}";
//		}
//		return $column;
//	}

    public function render($oid, $row) {

        if ($this->img1 != '') {
            if ($this->verificaCondicao($row)) {
                $html = "<a href='" . $this->link . "' {$this->getAttribs()}>";
                $html = "<img src='" . $this->img1 . "'></a>";
            } else {
                $html = "<a href='" . $this->link . "' {$this->getAttribs()}>";
                $html = "<img src='" . $this->img2 . "'></a>";
            }
        } else {
            if (is_array($row)) {
                $nomeColuna = $this->getName();
                $src = $row[$nomeColuna];
            } else {
                $nomeColuna = 'get' . $this->getName();
                $src = $row->$nomeColuna();
            }
            return "<img style='width:100%' class='img-responsive' src='{$src}'/> ";
        }

        return trim($html);
    }

}
