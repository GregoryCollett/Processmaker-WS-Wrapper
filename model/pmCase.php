<?php

require_once('variableStruct.php');

class pmCase {
	public $guid, $name, $status, $delIndex;
	public $task, $docs, $variables, $info;
	function fetchTaskCase(pmConnect $connection) {
		$this->task = $connection->get_task_case($this->guid);
	}
	function fetchDocList(pmConnect $connection) {
		$this->docs = $connection->output_doc_list($this->guid);
	}
	function fetchVariables(pmConnect $connection, $variables = null) {
		$vars = array();
		foreach($variables as $variable) {$vars[] = new variableStruct($variable);}
		$this->variables = $connection->get_variables($this->guid, $vars);
	}
	function fetchCaseInfo(pmConnect $connection) {
		$this->info = $connection->get_case_info($this->guid, 0);
	}

}

?>
