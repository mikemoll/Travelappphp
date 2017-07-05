<?php
class Ui_Element_Grid_Button
{
	private $url;
	private $href;
	private $display;
	private $name;
	private $bclass;
	private $onpress;
	private $event = 'click';
	private $sendFormFields;
	private $rel;
	private $img;
	private $attribs = '';
	public $visible = false;

	public function __construct($name, $display){
		$this->setDisplay($name, $display);
	}
	public function setDisplay($name, $display)
	{
		$this->name = $name;
        $this->display = $display;
	}
	public function setEvent($val){
		$this->event = $val;
	}
	public function setImg($src){
		$this->img = PATH_IMAGES.$src;
	}
	public function setSendFormFields(){
		$this->sendFormFields = '1';
	}
	public function setRel($val){
		$this->rel = $val;
	}
	public function setUrl($val){
		$this->url = $val;
	}
	public function setHref($val){
		$this->href = $val;
	}
	public function setAttribs($attribs){
		$this->attribs = $attribs;
	}
    public function getScript(){
        $script .= '	if (action == "Delete"){' .   "\n";
		$script .= '		if($(".trSelected",grid).length>0){'."\n";
		$script .= '			 if(confirm("Delete " + $(".trSelected",grid).length + " items?")){'."\n";
		$script .= '		var items = $(".trSelected",grid);'."\n";
		$script .= '		var itemlist ="";'."\n";
		$script .= '		for(i = 0; i < items.length; i++){'."\n";
		$script .= '			itemlist += items[i].id.substr(3)+","}'."\n";
		$script .= '	   	$.ajax({'."\n";
		$script .= '	   	type: "POST",'."\n";
		$script .= '	   	dataType: "json",'."\n";
		$script .= '	   	url: "delete.php",'."\n";
		$script .= '	    data: "items="+itemlist,'."\n";
		$script .= '        success: function(data){'."\n";
		$script .= '	   		alert("Query: "+data.query+" - Total affected rows: "+data.total);'."\n";
		$script .= '	    $("#flex1").flexreload();'."\n";
		$script .= '	 	}'."\n";
		$script .= '	 	});'."\n";
		$script	.= '	}'."\n";
		$script .= '	}';
        return $script;
	}
	public function setVisible($processo, $acao = ''){
		$this->visible = Usuario::verificaAcesso($processo, $acao);
	}

	public function render()
	{
		$buttons = '';
		if($this->visible)
			$buttons = "{name: '{$this->display}', value: '{$this->name}', onpress: '{$this->onpress}',url: '{$this->url}',rel: '{$this->rel}', event: '{$this->event}', sendFormFields: '{$this->sendFormFields}', href: '{$this->href}', img: '{$this->img}', attribs: '{$this->attribs}' }";
		return $buttons;
	}
}