<?php

class pmDocumentUpload {

    // Keep this stuff private man...
    private $process, $caseID, $file, $response;

    /**
     * Constructor
     */
    public function __construct($caseID = null, $file = null) {
        if ($caseID) {
            $this->setCaseID($caseID);
        }

        if ($file) {
            $this->setFile($file);
        }
    }

    // Set the document.. (Expects an obj)
    public function setFile($document) {
        $this->file = $document;
        return $this;
    }

    public function setCaseID($caseID) {
        $this->caseID = $caseID;
        return $this;
    }

    public function getCaseID() {
        return $this->caseID;
    }

    /**
     * Upload that doc!
     */
    public function upload() {
        $this->request();
    }

    /**
     * Curl Requests...
     */
    public function request($doc_type = null, $ssl = false) {
        if (!$doc_type) {
            $doc_type = "ATTACHED";
        }
        $params = array(
            'ATTACH_FILE' => '@/home/four4long/test.txt',
            'APPLICATION' => $this->caseID,
            'INDEX' => 1,
            'USR_UID' => '00000000000000000000000000000001',
            'DOC_UID' => '-1',
            'APP_DOC_TYPE' => $doc_type,
            'TITLE' => 'Test Doc',
            'COMMENT' => (isset($this->doc->comment)) ? $this->doc->comment : ""
        );
        ob_flush();
        $c_init = curl_init();
        curl_setopt($c_init, CURLOPT_URL, 'http://151.236.221.19/sysworkflow/en/uxmodern/services/upload');
        // curl_setopt($c_init, CURLOPT_VERBOSE, 1);  //Uncomment to debug
        curl_setopt($c_init, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c_init, CURLOPT_POST, 1);
        curl_setopt($c_init, CURLOPT_POSTFIELDS, $params);

        if ($ssl) {
            curl_setopt($c_init, CURLOPT_SSL_VERIFYHOST, 1); //Uncomment for SSL
            curl_setopt($c_init, CURLOPT_SSL_VERIFYPEER, 1); //Uncomment for SSL
        }
        $response = curl_exec($c_init);
        curl_close($c_init);
        
        $this->setResponse($response);
        return $this->response;
    }
    
    private function setResponse($response) {
        $this->response = $response;
    }
    
    public function getResponse() {
        return $this->response;
    }
}

?>