<?php

require_once('variableStruct.php');
require_once('pmBase.php');

class pmCase extends pmBase {
	public $name, $status, $delIndex;
	public $task, $docs, $variables, $info;
	public $processId;
	
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
				die("\nDied\n");
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
	/*function push(pmConnect $connection) {
		foreach($this->variables as 
		$connection->new_case($this->process_id, $task_id, $variables = null);
	}*/
}

class NoTaskAssignedException extends Exception {}

?>
