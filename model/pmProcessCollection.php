<?php

require_once("pmProcess.php");
require_once("pmBaseCollection.php");

class pmProcessCollection extends pmBaseCollection {
	function fetch(pmConnect $connection) {
		$response = $connection->get_process_list();
		$this->populate($response->processes, "pmProcess");
	}
	//function 
}

?>
