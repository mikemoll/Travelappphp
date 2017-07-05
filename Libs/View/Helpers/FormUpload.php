<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormUpload extends Zend_View_Helper_FormElement
{
	public function formUpload($name, $value = null, $attribs = null)
	{
		//		print_r($attribs); die();
		$info = $this->_getInfo($name, null, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable


		$btnExeUpload = $attribs['btnExeUpload'];
		unset($attribs['btnExeUpload']);
		$btnCancel = $attribs['brnCancelar'];
		unset($attribs['brnCancelar']);

//		$onComplete = $attribs['onComplete'];
//		unset($attribs['onComplete']);

		$prop = array('script', 'auto', 'multi', 'onAllComplete', 'buttonText', 'cancelImg', 'uploader', 'queueID');
		$sep = '';
		$params = '';

		if($attribs['sendFormFields']){
			$params .= "'scriptData': {'verTodos':'N'}";//serializeDataFormJson('albuns')";//$('#".$attribs['sendFormFields']."').serialize()";
//			$params .= "'scriptData': 'arquivo'";//$('#".$attribs['sendFormFields']."').serialize()";
			unset($attribs['sendFormFields']);
			$sep = ', ';
		}

		if($attribs['data']){
			$params .= "'scriptData':".$attribs['data'];//serializeDataFormJson('albuns')";//$('#".$attribs['sendFormFields']."').serialize()";
			unset($attribs['sendFormFields']);
			$sep = ', ';
		}
//
//		if($onComplete != ''){
//			$params .= $sep."'onComplete':'alerta(response)'";
//			$sep = ', ';
//		}

		$params .= ', onError : function(event, queueID, fileObj, err){
                     if (err.info  == 404)
                        alert("Could not find upload script. Use a path relative to: "+"<?PHP getcwd() ?>");
                 else if (err.type === "HTTP")
                        alert("error1 "+err.type+": "+err.info  );
                 else if (err.type ==="File Size")
                        alert(fileObj.name+" "+err.type+" Limit: "+Math.round(err.sizeLimit/1024)+"KB");
                 else
                        alert("error2 "+err.type+": "+err.text);
                        }';
                
                // = = = = = = = = = = = = == = = = = = = == = = = 
                // ======== USAR ISSO QUANDO N�o SE SABE PORQUE N�O EST� FUNCIONANDO! ELE MOSTRA O RETORNO DO PHP!!! ====== 
                // = = = = = = = = = = = = == = = = = = = == = = = 
//		$params .= ', onComplete: function(a, b, c, data, e){alert(data);}';

		foreach($prop as $val){
			if($attribs[$val] != ''){
				if(is_bool($attribs[$val])){
					$params .= $sep."'".$val."':".$attribs[$val];
				}else{
					$params .= $sep."'".$val."':'".$attribs[$val]."'";
				}
				unset($attribs[$val]);
				$sep = ', ';
			}
		}

		// is it disabled?
		$disabled = '';
		if ($disable) {
			$disabled = ' disabled="disabled"';
		}

		// XHTML or HTML end tag?
		$endTag = ' />';
		if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
			$endTag= '>';
		}

		// build the element
		$xhtml = '<input type="file"'
		. ' name="' . $this->view->escape($name) . '"'
		. ' id="' . $this->view->escape($id) . '"'
		. $disabled
		. $this->_htmlAttribs($attribs)
		. $endTag;
		if($btnCancel != ''){
			$xhtml .= '<br><a id="'.$id.'btnCancelar">Cancelar envio</a>';
		}

		$xhtml .= '<script type="text/javascript">'
		. 		  		'$("#'.$id.'").uploadify({'.$params.'})'
		. 		   '</script>';



		if($btnExeUpload != ''){
			$xhtml .= '<script type="text/javascript">'
			. 		  		'$("#'.$btnExeUpload.'").live("click", function(){$("#'.$id.'").uploadifyUpload()});'
			.				'$("#'.$btnExeUpload.'").live("click", function(){$(this).removeAttr("event")})'
			. 		   '</script>';
		}

//		print_r($xhtml); die();
		return $xhtml;
	}
}

