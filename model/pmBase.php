<?php

class pmBase {
	private $id, $name;
	public function set($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	public function getID() {return $this->id;}
	public function getName() {return $this->name;}
	public function printLeaf($depth, $showId) {
		echo str_repeat ("-", $depth)."{$this->name}".($showId?": ({$this->id})":"")."\n";
		$this->printChildren($depth+1, $showId);
	}
	public function printChildren($depth, $showId) {}
}

?>
