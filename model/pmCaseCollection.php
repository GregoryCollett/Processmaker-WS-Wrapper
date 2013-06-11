<?php

require_once('pmCase.php');

class pmCaseCollection implements IteratorAggregate {
	private $cases = array();
	function populateCases(pmConnect $connection) {
		$cases = $connection->get_case_list();
		if (count($cases->cases)>1) {
			foreach($cases->cases as $caseRow) {
				$this->createCase($caseRow);
			}
		} else if ($cases->cases) {
			$this->createCase($cases->cases);
		}
	}
	function createCase($caseRow) {
		$case = new pmCase();
		$case->guid = $caseRow->guid;
		$case->name = $caseRow->name;
		$case->status = $caseRow->status;
		$case->delIndex = $caseRow->delIndex;
		$this->cases[$case->guid] = $case;
	}
	function populateTaskCases(pmConnect $connection) {
		foreach($this->cases as &$case) {
			$case->fetchTaskCase($connection);
		}
	}
	function populateDocLists(pmConnect $connection) {
		foreach($this->cases as &$case) {
			$case->fetchDocList($connection);
		}
	}
	public function getIterator() {
		return new ArrayIterator( $this->cases );
	}
}

?>
