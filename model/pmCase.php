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
	function fetchVariables(pmConnect $connection, $names = null) {
		$vars = array();
		foreach($names as $name) {$vars[] = new variableStruct($name);}
		$variables = $connection->get_variables($this->guid, $vars);
		if (isset($variables->variables)) {
			foreach($variables->variables as $variable) {
				$this->variables[$variable->name] = $variable->value;
			}
		} else {
			$this->variables = array();
		}
	}
	function fetchCaseInfo(pmConnect $connection) {
		$this->info = $connection->get_case_info($this->guid, 0);
	}
	function executeTrigger(pmConnect $connection, $triggerIndex) {
		$connection->execute_trigger($this->guid, $triggerIndex, $this->delIndex);
	}
}

?>
