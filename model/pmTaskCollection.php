<?php

require_once("pmTask.php");
require_once("pmBaseCollection.php");

class pmTaskCollection extends pmBaseCollection {
	function fetch(pmConnect $connection) {
		$response = $connection->get_task_list();
		$this->populate($response->tasks, "pmTask");
	}
	/*static $instance;
	static function getInstance() {
		if (!$instance) {
			self::$instance = new pmTaskCollection();
		}
		return self::$instance;
	}*/
}

?>
