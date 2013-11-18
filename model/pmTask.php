<?php

require_once("pmBase.php");
require_once("pmCaseCollection.php");

class pmTask extends pmBase{
	private $process, $cases;
	function __construct() {
		$this->cases = new pmCaseCollection();
	}
	function setProcess($process) {
		$this->process = $process;
		$process->addTask($this);
	}
	function addCase($case) {
		$this->cases->add($case);
	}
	public function printChildren($depth, $showId) {
		$this->cases->printTree($depth, $showId);
	}
}

?>
