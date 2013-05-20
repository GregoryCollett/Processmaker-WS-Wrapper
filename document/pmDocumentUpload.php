<?php

class pmDocumentUpload {
	
	// Keep this stuff private man...
	private $process, $case, $task, $user, $doc, $response;

	/**
	* Constructor
	*/
	public function pmDocumentUpload() {

	}

	// Generate a random document id (preferably a guid based on the doc title)
	private function generateDocId() {
	
	}

	// Set the document.. (Expects an obj)
	public function setDoc($document) {
		$this->doc = $document
	}

	/**
	* Upload that doc!
	*/
	public function upload($document) {
		$this->request("ATTACHED");
	}

	/**
	* Curl Requests...
	*/
	public function request($doc_type = null, $ssl = false) {
		if ( !$doc_type ) {
			$doc_type = "ATTACHED";
		}
		$c_init = curl_init();
		$params = array (
		    'ATTACH_FILE'  => '@' . $file_path,
		    'APPLICATION'  => $this->case->id,
		    'INDEX'        => 1,
		    'USR_UID'      => $this->user->id,
		    'DOC_UID'      => '547CEBEE61202A',
		    'APP_DOC_TYPE' => $doc_type,
		    'TITLE'        => $this->doc->title,
		    'COMMENT'      => (isset($this->doc->comment)) ? $this->doc->comment : "";
		 );
		 ob_flush();
		 $c_init = curl_init();
		 curl_setopt($c_init, CURLOPT_URL, 'http://192.168.1.100/sysworkflow/en/green/services/upload');
		 // curl_setopt($c_init, CURLOPT_VERBOSE, 1);  //Uncomment to debug
		 curl_setopt($c_init, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($c_init, CURLOPT_POST, 1);
		 curl_setopt($c_init, CURLOPT_POSTFIELDS, $params);

		 if ($ssl) {
		 	curl_setopt ($c_init, CURLOPT_SSL_VERIFYHOST, 1); //Uncomment for SSL
		 	curl_setopt ($c_init, CURLOPT_SSL_VERIFYPEER, 1); //Uncomment for SSL
		 }
		 $response = curl_exec($c_init);
		 curl_close($c_init);
		 print "<HTML><BODY><PRE>$response</PRE></BODY></HTML>";
	}

}
?>