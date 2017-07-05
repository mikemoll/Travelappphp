<?php
class Ui_Grid_Search
{
	protected $_Display;
	protected $_Name;
	protected $_IsDefault = 'false';
	
	public function __construct($display, $name, $IsDefault = 'false')
	{
		$this->_Display = $display;
		$this->_Name = $name;
		$this->_IsDefault = $IsDefault;
	}
	public function render()
	{
		$search = "{display: '{$this->_Display}', name: '{$this->_Name}', isdefault: {$this->_IsDefault}}";
		return $search; 
	}
}