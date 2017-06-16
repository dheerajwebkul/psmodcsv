<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

require_once "db.php";

// Reading CSV
function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $result = fgetcsv($file_handle, 1024);
        if ($result !== false) {
        	$line_of_text[] = $result;
        }
    }
    fclose($file_handle);
    return $line_of_text;
}

// Set path to CSV file
$csvFile = 'csv/test.csv';
$csvArray = readCSV($csvFile);
unset($csvArray[0]);

echo "<pre>";
echo "Creating Array...<br/>";

$moduleList = array();
foreach ($csvArray as $key => $modules) {
	$moduleList[$key]['Year'] = isset($modules[0]) ? $modules[0] : '';
	$moduleList[$key]['Make'] = isset($modules[1]) ? $modules[1] : '';
	$moduleList[$key]['Model'] = '1.6';
	$moduleList[$key]['Length'] = '1';
}

echo "Updating database...<br/>";

foreach ($moduleList as $module) {
	$insert = "INSERT INTO demo (Year, Make, Model, Length
) VALUES ('".$module['Year']."', '".$module['Make']."', '".$module['Model']."', '".$module['Length']."')";
	$select = "SELECT id FROM demo WHERE Make='".$module['Make']."'";

	$getRow = Db::Connect()->query($select);
	if (!$getRow->num_rows) {
		Db::Connect()->query($insert);
	}
}

echo ("Successfully udpated.<br/>");
die;