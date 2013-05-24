<?php

echo "Populating cases... ";

$collection = new pmCaseCollection();
$collection->populateCases($pm);
echo "Done. ".curDate()."\nPopulating task cases... ";

$case = $collection->getIterator()->current();
$case->fetchTaskCase($pm);
echo "Done. ".curDate()."\nDoc list... ";
$case->fetchDocList($pm);
echo "Done. ".curDate()."\nVariables... ";
$case->fetchVariables($pm, array(
	//"EMail",
	//"Gender",

	"form[MainContactDetails][1][EMail]",
	"form[Additional_Contact][1][Gender]",
));
echo "Done. ".curDate()."\nCase Info... ";
$case->fetchCaseInfo($pm);
echo "Done. ".curDate()."\n";
print_r($case);

?>