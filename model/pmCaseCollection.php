<?php

require_once('pmCase.php');
require_once('pmBaseCollection.php');

class pmCaseCollection extends pmBaseCollection /*implements IteratorAggregate */{
	//private $cases = array();
	/*function populateCases(pmConnect $connection) {
		$cases = $connection->get_case_list();
		if (count($cases->cases)>1) {
			foreach($cases->cases as $caseRow) {
				$this->createCase($caseRow);
			}
		} else if ($cases->cases) {
			$this->createCase($cases->cases);
		}
	}*/
	function fetch(pmConnect $connection) {
		$response = $connection->get_case_list();
		$this->populate($response->cases, "pmCase");
	}
	function createCase($caseRow) {
		$case = new pmCase();
		$case->guid = $caseRow->guid;
		$case->name = $caseRow->name;
		$case->status = $caseRow->status;
		$case->delIndex = $caseRow->delIndex;
		$this->add($case);
	}
	function populateTaskCases(pmConnect $connection) {
		foreach($this->items as &$case) {
			$case->fetchTaskCase($connection);
		}
	}
	function populateDocLists(pmConnect $connection) {
		foreach($this->items as &$case) {
			$case->fetchDocList($connection);
		}
	}
	function populateCaseInfo(pmConnect $connection) {
		foreach($this as &$case) {
			$case->fetchCaseInfo($connection);
		}
	}
	/*public function getIterator() {
		return new ArrayIterator( $this->cases );
	}*/
	public function populateTaskCollection(pmProcessCollection $processes, pmTaskCollection $tasks) {
		foreach($this as &$case) {
			$case->setTask($tasks);
			$case->setProcess($processes);
		}
	}
}

?>
