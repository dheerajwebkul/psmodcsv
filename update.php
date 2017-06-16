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
$csvFile = 'csv/PS Modules.csv';
$csvArray = readCSV($csvFile);
unset($csvArray[0]);

echo "<pre>";
echo "Creating Array...<br/>";

$moduleList = array();
foreach ($csvArray as $key => $modules) {
	$moduleList[$key]['module_name'] = isset($modules[0]) ? $modules[0] : '';
	$moduleList[$key]['module_tech_name'] = isset($modules[1]) ? $modules[1] : '';
	$moduleList[$key]['version'] = '1.6';
	$moduleList[$key]['is_active'] = '1';
}

echo "Updating database...<br/>";

foreach ($moduleList as $module) {
	$insert = "INSERT INTO demo_modules (module_name,module_tech_name,version,is_active) VALUES ('".$module['module_name']."', '".$module['module_tech_name']."', '".$module['version']."', '".$module['is_active']."')";
	$select = "SELECT id FROM demo_modules WHERE module_tech_name='".$module['module_tech_name']."'";

	$getRow = Db::Connect()->query($select);
	if (!$getRow->num_rows) {
		Db::Connect()->query($insert);
	}
}

echo ("Successfully udpated.<br/>");
die;