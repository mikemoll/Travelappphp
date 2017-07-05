<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormAccordion extends Zend_View_Helper_FormElement
{
	public function formAccordion($name, $value = null, $attribs = null)
	{
		$info    = $this->_getInfo($name, $value, $attribs);
		extract($info); // name, id, value, attribs, options, listsep, disable, escape


		$param['disabled'] = $attribs['disabled'];
		$param['active'] = $attribs['active'];
		$param['animated'] = $attribs['animated'];
		$param['autoHeight'] = $attribs['autoHeight'];
		$param['clearStyle'] = $attribs['clearStyle'];
		$param['collapsible'] = $attribs['collapsible'];
		$param['event'] = $attribs['event'];
		$param['fillSpace'] = $attribs['fillSpace'];
		$param['header'] = $attribs['header'];
		$param['icons'] = $attribs['icons'];
		$param['navigation'] = $attribs['navigation'];
		$param['navigationFilter'] = $attribs['navigationFilter'];

		//$param['select'] = "function(event, ui){alert('jjjjj')}";

		foreach ($param as $key){
			unset($attribs[$key]);
		}

		$json = Format_String::jqueryParams($param);

		$view = Zend_Registry::get('view');

		//print_r($id);die('<br><br>' .  __LINE__);
		
		
		$xhtml = '<div id="'.$id.'">';

		//print_r('');die('<br><br>' .  __LINE__);
		
		foreach($attribs['section'] as $val){
			if($val->visible){
				if($val)
				//$xhtml .=  '<li><a href="#'.$val->getName().'" class="tabs">'.$val->title.'</a></li>';
				$xhtml .=  '<h3><a href="#">'.$val->title.'</a></h3>';

				if($val->fields){
					foreach($val->fields as $comp){
						$view->assign($comp->getName(), $comp->render());
					}
				}
				
				$xhtml .= '<div>'
					   . $view->fetch($val->template)
					   . '</div>';
			}
		}
		
		$xhtml .= '</div>'
			   . '<script type="text/javascript">$("#'.$id.'")'
			   . '.accordion(' . $json . ')'
			   . '</script>';







//print_r($xhtml);die('<br><br>' .  __LINE__);







		return $xhtml;
	}
}