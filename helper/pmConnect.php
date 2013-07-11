<?php

/**
 * PM Connector - SugarCRM
 * @author Gregory Collett
 */
class pmConnect {
    ////////////////////////////////////////
    /// Settings Configuration Variables
    /// (Edit to configure)
    ////////////////////////////////////////

    /**
     * Variable:	$url
     * Description:	The URL of the ProcessMaker Webservice
     * Example:		http://localhost:8080/sysworkflow/en/green/services/wsdl2
     */
    private $url = "http://localhost:8080/sysworkflow/en/green/services/wsdl2";

    /**
     * Variable:	$username
     * Description:	A ProcessMaker Username. It's recommended that
     * 				you create a seperate ProcessMaker Account
     *                          for webservice calls
     */
    private $username = "admin";

    /**
     * Variable:	$password
     * Description:	The password for the $username ProcessMaker account
     */
    private $password = "admin";

    ////////////////////////////////////////
    /// Other Variables
    /// DO NOT EDIT!!!
    ////////////////////////////////////////

    /**
     * Variable:	$session
     * Description:	Stores the session_id post login
     */
    public $session;

    /**
     * Variable:	$logged_in
     * Description:	Boolean flag for login status
     */
    private $logged_in;

    /**
     * Variable:	$error
     * Description:	The latest error
     */
    private $error = FALSE;

    /**
     * Function:	pmConnect()
     * Parameters: 	none	
     * Description:	Class constructor
     * Returns:		TRUE on login success, otherwise FALSE
     */
    function pmConnect($url, $username = null, $password = null, $auto_login = true) {
	$this->url = $url;
        if(isset($username) and isset($password))
        {
            $this->username = $username;
            $this->password = $password;
        }
	if ($auto_login) {
		if ($this->login()) {
		    $this->logged_in = TRUE;
		    $data['session'] = $this->session;
		} else {
		    $this->logged_in = FALSE;
		}
	}
    }

	////////////////////////////////////////////////////////////////////////////////////////
	////                                     LOGIN				        ////
	////////////////////////////////////////////////////////////////////////////////////////
	/**
	* Function:	login()
	* Parameters: 	none	
	*/
	public function login() {
		$params = array(array('userid' => $this->username, 'password' => $this->password));
		$result = $this->request('login', $params);
		$this->pm_status_code = $result->status_code;
		if ($result->status_code == 0) {
			$this->session = $result->message;
			return TRUE;
		} else {
			$this->pm_error = $result->message;
			$this->error = "Unable to connect to ProcessMaker. Error Number: $result->status_code Error Message: $result->message";
			return FALSE;
		}
	}

	public $pm_status_code = 0;
	public $pm_error = "";

    ////////////////////////////////////////////////////////////////////////////////////////
    ////                                    REQUESTS			                        ////
    ////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Function:	request()
     *
     * Parameters: 	$call_name          = String    - the API call name.
     * 			$call_arguments     = Array 	- the arguments for the API call.
     *
     * Description:	Makes an API call to the given call name and arguments
     * Returns:		An object
     */
    private function request($call_name, $call_arguments) {
        $client = new SoapClient($this->url);
	return $client->__soapCall($call_name, $call_arguments);
    }
    
    
    //Does as it says, returns the user list
    public function get_user_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('userList', $params);
        return $result;
    }
    
    //Does as it says, returns a list of groups created in the specific pm instance
    public function get_group_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('groupList', $params);
        return $result;
    }
    
    //This is getting a bit repetitive lol
    public function get_department_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('departmentList', $params);
        return $result;
    }
    
    //Oh gosh, quite obvious...
    public function get_role_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('roleList', $params);
        return $result;
    }
    
    //Create a pm user (by default admin)
    public function create_user($user_name, $first_name, $last_name, $email, $password, $role = 'PROCESSMAKER_ADMIN') {
        $params = array(
            array(
                'userId' => $user_name,
                'firstname' => $first_name,
                'lastname' => $last_name,
                'email' => $email,
                'role' => $role,
                'password' => $password,
            )
        );
        if (!isset($user_name) or !isset($password)) {
            $result = "please make sure you have chosen a user name and password!";
            $this->error = $result;
        } else {
            $result = $this->resuest('createUser', $params);
        }
        return $result;
    }
    
    //Create a group in pm
    public function create_group($group_name) {
        $params = array(
            array(
                'sessionId' => $this->session,
                'name' => $group_name
            )
        );
        $result = $this->request('createGroup', $params);
        return $result;
    }
    
    //Boring...
    public function create_department($department_name, $parent_department = '') {
        $params = array(
            array(
                'sessionId' => $this->session,
                'name' => $department_name,
                'parentUID' => $parent_department
            )
        );
        $result = $this->request('createDepartment', $params);
        return $result;
    }
    
    //Add the relationship between a user and a group
    public function assign_user_to_group($user_id, $group_id) {
        $params = array(
            array(
                'sessionId' => $this->session,
                'userId' => $user_id,
                'groupId' => $group_id
            )
        );
        $result = $this->request('assignUserToGroup', $params);
        return $result;
    }
    
    //Boring ^^^
    public function assign_user_to_department($user_id, $department_id) {
        $params = array(
            array(
                'sessionId' => $this->session,
                'userId' => $user_id,
                'departmentId' => $group_id
            )
        );
        $result = $this->request('assignUserToDepartment', $params);
        return $result;
    }
    
    //Does as it says, returns a list of the active process'.
    public function get_process_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('processList', $params);
        return $result;
    }
    
    //returns all taks for all process'
    public function get_task_list() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('taskList', $params);
        return $result;
    }
    
    //gets a task for a specific case 
    public function get_task_case($case_id) {
        $params = array(array('sessionId' => $this->session, 'caseId' => $case_id));
        $result = $this->request('taskCase', $params);
        return $result;
    }
    
    //get the active cases
    public function get_case_list() {
        $params = array(array('sessionId' => $this->session));
	try {
		return $this->request('caseList', $params);
	} catch (SoapFault $e) {
		echo "SoapFault: {$e->getMessage()}. There are probably no cases.\n";
	} catch (Exception $e) {
		echo "Unknown Exception: {$e->getMessage()}\n";
	}
	$exceptionResult = new stdClass();
	$exceptionResult->cases = null;
	return $exceptionResult;
    }
    
    //get cases that have no user assigned (lost cases!)
    public function get_unassigned_cases() {
        $params = array(array('sessionId' => $this->session));
        $result = $this->request('unassignedCaseList', $params);
        return $result;
    }
    
    //get any info avail on the given case
    public function get_case_info($case_id, $index) {
        $params = array(array('sessionId' => $this->session, 'caseId' => $case_id, 'delIndex' => $index));
        $result = $this->request('getCaseInfo', $params);
        return $result;
    }

    //Create a new case for a specific proccess assign a task to go to a specific task (also accept pm variables array()
    public function new_case($process_id, $task_id, $variables = null) {
        $params = array(array('sessionId' => $this->session, 'processId' => $process_id, 'taskId' => $task_id, 'variables' => $variables));
        $result = $this->request('newCase', $params);
        return $result;
    }

    public function new_case_impersonate($process_id, $user_id, $variables = null) {
        $params = array(array('sessionId' => $this->session, 'processId' => $process_id, 'userId' => $user_id, 'variables' => $variables));
        $result = $this->request('newCaseImpersonate', $params);
        return $result;
    }
    
    public function reassign_case($case_id, $index, $current_user_id, $target_user_id){
        $params = array(
            array(
                'sessionId' => $this->session,
                'caseId' => $case_id,
                'delIndex' => $index,
                'userIdSource' => $currenct_user_id,
                'userIdTarget' => $target_user_id
            )
        );
        $result = $this->request('reassignCase', $params);
        return $result;
    }
    
    public function route_case($case_id, $index){
        $params = array(array('session' => $this->session, 'caseId' => $case_id, 'delIndex' => $index));
        $result = $this->request('routeCase', $params);
        return $result;
    }
    
    public function get_variables($case_id, $variables = null){
        $params = array(array('sessionId' => $this->session, 'caseId' => $case_id, 'variables' => $variables));
        $result = $this->request('getVariables', $params);
        return $result;
   }
   
   public function send_variables($case_id, $variables = null){
       $params = array(array('sessionId' => $this->session, 'caseId' => $case_id, 'variables' => $variables));
        $result = $this->request('sendVariables', $params);
        return $result;
   }
   
   public function get_trigger_list(){
       $params = array(array('sessionId' => $this->session));
       $result = $this->request('triggerList', $params);
       return $result;
   }
   
   public function execute_trigger($case_id, $trig_index, $index){
       $params = array(array('sessionId' => $this->session, 'caseId' => $case_id, 'triggerIndex' => $trig_index, 'delIndex' => $index));
       $result = $this->request('executeTrigger', $params);
       return $result;
   }
   
   public function send_message($case_id, $from, $to, $cc = null, $bcc = null, $subject = 'No Subject Set', $template){
       $params = array(
           array(
               'sessionId' => $this->session,
               'caseId' => $case_id,
               'from' => $from,
               'to' => $to,
               'cc' => $cc,
               'bcc' => $bcc,
               'subject' => $subject,
               'template' => $template,
           )
       );
       $result = $request('sendMessage', $params);
       return $result;
   }
   
   public function sys_info(){
       $params = array(array('sessionId' => $this->session));
       $result = $this->request('systemInformation', $params);
       return $result;
   }
   
   public function input_doc_case_list($case_id){
       $params = array(
           array(
               'sessionId' => $this->session,
               'caseId' => $case_id,
               
           )
       );
       $result = $this->request('inputDocumentList', $params);
       return $result;
   }
   
   public function input_doc_proc_list($process_id){
       $params = array(
           array(
               'sessionId' => $this->session,
               'processId' => $process_id,   
           )
       );
       $result = $this->request('inputDocumentProcessList', $params);
       return $result;
   }
   
   public function output_doc_list($case_id){
       $params = array(
           array(
               'sessionId' => $this->session,
               'caseId' => $case_id,   
           )
       );
       $result = $this->request('outputDocumentList', $params);
       return $result;
   }
   
   public function delete_doc($doc_id){
       $params = array(
           array(
               'sessionId' => $this->session,
               'appDocUid' => $doc_id,
           )
       );
       $result = $this->request('removeDocument', $params);
       return $result;
   }
   
   public function set_privates($private, $val)
   {
       $this->$private = $val;
   }
   
}

?>
