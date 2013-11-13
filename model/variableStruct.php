<?php

class variableStruct {
	public $name;
	function __construct($name, $value = null) {
		$this->name = $name;
		if ($value) {$this->value = $value;}
	}
}


class variableListStruct {
	public $name, $value;
	
	function __construct($name, $value) {			
		$this->name = $name;
		$this->value = $value;
	}
}
?>
