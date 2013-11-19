<?php

require_once('variableStruct.php');
require_once('pmBase.php');

class pmCase extends pmBase {
	public $name, $status, $delIndex;
	public $task, $docs, $variables, $info;
	public $processId;
	private $fields = array();
	
	function fetchTaskCase(pmConnect $connection) {
		$this->task = $connection->get_task_case($this->getID());
	}
	function fetchDocList(pmConnect $connection) {
		$this->docs = $connection->output_doc_list($this->getID());
	}
	function fetchVariables(pmConnect $connection, $names = null) {
		$vars = array();
		foreach($names as $name) {$vars[] = new variableStruct($name);}
		$variables = $connection->get_variables($this->getID(), $vars);
		if (isset($variables->variables)) {
			foreach($variables->variables as $variable) {
				$this->variables[$variable->name] = $variable->value;
			}
		} else {
			$this->variables = array();
		}
	}
	function fetchCaseInfo(pmConnect $connection) {
		$this->info = $connection->get_case_info($this->getID(), $this->delIndex);
		$this->processId = $this->info->processId;
	}
	function executeTrigger(pmConnect $connection, $triggerIndex) {
		$connection->execute_trigger($this->getID(), $triggerIndex, $this->delIndex);
	}
	function setProcess(pmProcessCollection $processes) {
		if ($this->task) {
			try {
				$process = $processes->get($this->processId);
				$this->task->setProcess($process);
			} catch(NoSuchItemException $e) {
				print_r($this);
				die("\nDied - task doesn't exist for this case. Presumably need to getInfo.\n");
			} catch(Exception $e) {
				throw $e;
			}
		} else {
			throw new NoTaskAssignedException("No task assigned to case '{$this->id}', '{$this->label}'. Run fetchCaseInfo(pmConnect).");
		}
	}
	function setTask(pmTaskCollection $tasks) {
		$this->task = $tasks->get($this->info->currentUsers->taskId);
		$this->task->addCase($this);
	}
	function getVariableStructs() {
		$vars = array();
		foreach($this->variables as $name => $value) {
			$vars[] = new variableStruct($name, $value);
		}
		return $vars;
	}
	function push(pmConnect $connection) {
		if ($this->getID()) {
			// Not so interested in overwriting cases right now.
		} else {
			$variables = $this->getVariableStructs();
			$connection->new_case($this->task->getProcess()->getID(), $this->task->getID(), $variables);
		}
	}
	function setFields($fields) {$this->fields = array_merge($this->fields, $fields);}
	function getFields() {return $this->fields;}
}

class NoTaskAssignedException extends Exception {}

?>
