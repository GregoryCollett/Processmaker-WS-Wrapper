<?php
//echo "Made it <br>";
//
//require_once('helper/pmDocumentUpload.php');
//
//echo "required it<br>";
////$caseID = '15904999251af4b408a74b8065578970';
//$caseID = "11519342751b07ddaa033e1004274996";
//$caseID = '13065244351b07ea28f0241067721291';
//$caseID = '28164286951b1b6dabc5fb7083794870';
//echo $caseID;
//
//$uploader = new pmDocumentUpload($caseID);
//
//// or you can instantiate object and then...
//// ->setCaseID($caseID)
//
//echo $uploader->getCaseID()."<br>";
//
//$uploader->setFile("/home/four4long/test.txt");
//
//$uploader->upload('INPUT', '88784293251b1b7665c2837049710923', '13278063851b1ad20ed45d5060708376');
//echo '<pre>';
//print_r($uploader);
//echo '</pre>';

require_once('helper/pmConnect.php');
require_once('model/variableStruct.php');
$case_id = "22548072451b07ccd15e3b8090597125";

$pm = new pmConnect("http://salesprocess.gointeractive.biz/sysworkflow/en/green/services/wsdl2", "admin", "YOADspw*");
$payment = new variableListStruct("PaymentComplete", "No");
$variables = array($payment);

$pm->send_variables($case_id, $variables);
?>