<?php

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	include('openCage/AbstractGeocoder.php');
	include('openCage/Geocoder.php');

	$geocoder = new \OpenCage\Geocoder\Geocoder('132371ae7d494c458d333706485bcaff');
	$result = $geocoder->geocode($_REQUEST['q'],['language'=>$_REQUEST['lang']]);

  $searchResult = [];
  $searchResult['results'] = [];
  $temp = [];

  foreach ($result['results'] as $entry) {
    $temp['source'] = 'opencage';
    $temp['formatted'] = $entry['formatted'];
    $temp['geometry']['lat'] = $entry['geometry']['lat'];
    $temp['geometry']['lng'] = $entry['geometry']['lng'];
    $temp['countryCode'] = strtoupper($entry['components']['country_code']);
    $temp['timezone'] = $entry['annotations']['timezone']['name'];

    array_push($searchResult['results'], $temp);
  }

	header('Content-Type: application/json; charset=UTF-8');	
  echo json_encode($searchResult, JSON_UNESCAPED_UNICODE);
  
?>