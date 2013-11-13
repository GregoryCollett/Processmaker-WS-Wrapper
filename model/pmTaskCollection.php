<?php

require_once("pmTask.php");
require_once("pmBaseCollection.php");

class pmTaskCollection extends pmBaseCollection {
	function fetch(pmConnect $connection) {
		$response = $connection->get_task_list();
		$this->populate($response['tasks'], "pmTask");
	}
}

?>
