<?php

require_once("pmBase.php");
require_once("pmCaseCollection.php");

class pmTask extends pmBase{
	private $process, $cases;
	function __construct() {
		$this->cases = new pmCaseCollection();
	}
	function setProcess($process) {$this->process = $process;}
	function addCase($case) {
		$this->cases->add($case);
	}
}

?>
