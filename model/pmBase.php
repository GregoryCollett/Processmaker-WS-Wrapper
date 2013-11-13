<?php

class pmBase {
	private $id, $name;
	public function set($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	public function getID() {return $this->id;}
	public function getName() {return $this->name;}
}

?>
