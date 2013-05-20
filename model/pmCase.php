<?php

class pmCase {
	public $guid, $name, $status, $delIndex;
	public $task, $docs, $variables;
	function fetchTaskCase(pmConnect $connection) {
		$this->task = $connection->get_task_case($this->guid);
	}
	function fetchDocList(pmConnect $connection) {
		$this->docs = $connection->output_doc_list($this->guid);
	}
	function getVariables(pmConnect $connection) {
		$this->variables = $connection->get_variables($this->guid);
	}

}

?>