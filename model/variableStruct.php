<?php

class variableStruct {
	public $name;
	function __construct($name) {$this->name = $name;}
}


class variableListStruct {
	public $name, $value;
	
	function __construct($name, $value) {			
		$this->name = $name;
		$this->value = $value;
	}
}
?>
