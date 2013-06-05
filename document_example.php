<?php
echo "Made it <br>";

require_once('helper/pmDocumentUpload.php');

echo "required it<br>";
$caseID = '15904999251af4b408a74b8065578970';
$caseID = "14739338851af40043961c5024584722";
echo $caseID;

$uploader = new pmDocumentUpload($caseID);

// or you can instantiate object and then...
// ->setCaseID($caseID)

echo $uploader->getCaseID()."<br>";

echo $uploader->upload()."<br>";

?>