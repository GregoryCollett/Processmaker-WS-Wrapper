<?php

require_once("pmProcess.php");
require_once("pmBaseCollection.php");

class pmProcessCollection extends pmBaseCollection {
	function fetch(pmConnect $connection) {
		$response = $connection->get_process_list();
		$this->populate($response->processes, "pmProcess");
	}
	function getTaskByNames($processName, $taskName) {
		$chosenTask = null;
		foreach($processes->getByName($processName) as $process) {
			foreach($process->getTasks()->getByName($taskName) as $task) {
				$chosentask = $task;
			}
		}
		return $chosenTask;
	}
	function getCase($id) {
		foreach($this as $process) {
			foreach($process->getTasks() as $task) {
				return $task->getCases()->get($id);
			}
		}
	}
}

?>
