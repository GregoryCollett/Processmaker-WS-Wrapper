<?php

class pmDocumentUpload {

    private $caseID,
            $file,
            $response,
            $error,
            $docType = "ATTACHED";

    /**
     * Constructor
     * Set the case and file here if you want, or not, I dont care.
     */
    public function __construct($caseID = null, $file = null) {
        if ($caseID) {
            $this->setCaseID($caseID);
        }

        if ($file) {
            $this->setFile($file);
        }
    }

    /**
     * Upload that doc!
     */
    public function upload($docType = null, $doc_id = null, $ssl = null) {
        $this->request($docType, $doc_id, $ssl);
    }

    /**
     * Curl Request...
     */
    public function request($doc_type = null, $doc_id = null, $doc_uid = null, $ssl = null) {
        if (!$doc_type) {
            $doc_type = "ATTACHED";
        }
        if (!$doc_uid) {
            $doc_uid = '-1';
        }
        $params = array(
            'ATTACH_FILE' => '@' . $this->file,
            'APPLICATION' => $this->caseID,
            'INDEX' => 1,
            'USR_UID' => '00000000000000000000000000000001',
            'DOC_UID' => $doc_uid,
            'APP_DOC_TYPE' => $doc_type,
            'TITLE' => 'Test Doc',
            'COMMENT' => (isset($this->doc->comment)) ? $this->doc->comment : ""
        );
        
        if ($doc_id) {
            $params['APP_DOC_UID'] = $doc_id;
        }
        
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

    /*
     * Set the file location (string)
     */

    public function setFile($file) {
        $this->file = $file;
        return $this;
    }

    /*
     * Set the case ID or this shit gonna fail yo!
     */

    public function setCaseID($caseID) {
        $this->caseID = $caseID;
        return $this;
    }

    /*
     * Could be used for some sort of check before upload runs or some shit
     */

    public function getCaseID() {
        return $this->caseID;
    }

    private function setResponse($response) {
        $this->response = $response;
        return $this;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getError() {
        return $this->error;
    }

}

?>