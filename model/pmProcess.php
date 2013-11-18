<?php

require_once("pmTaskCollection.php");

class pmProcess extends pmBase {
	private $tasks;
	function __construct() {$this->tasks = new pmTaskCollection();}
	public function printChildren($depth, $showId) {
		$this->tasks->printTree($depth, $showId);
	}
	function addTask($task) { // Seems a bit superfluous, should probably use getTask and add to that.
		$this->tasks->add($task);
	}
	function getTasks() {return $this->tasks;}
}

?>
