<?php

// Define current directory
if (!defined('CWD'))
{
	/**
	 * Tries to define the path from root of the server.
	 */
	define('CWD', (($getcwd = getcwd()) ? $getcwd : '.'));
}

// Parse the config file for database connection
$config = [];
include(CWD . '/../model/config.php');

if (sizeof($config) == 0)
{
	if (file_exists(CWD . '/../model/config.php'))
	{
		die('<br /><br /><strong>Configuration</strong>: model/config.php does not exist. Please fill out the data in config.php.');
	}
}

if (CWD == '.')
{
	// getcwd() failed and so we need to be told the full path in config.php
	if (!empty($config['Misc']['path']))
	{
		define('DIR', $config['Misc']['path']);
	}
	else
	{
		trigger_error('<strong>Configuration</strong>: You must insert a value for <strong>path</strong> in config.php', E_USER_ERROR);
	}
}
else
{
	/**
	 * Defines the final path from root of the server.
	 */
	define('DIR', CWD);
}

// Do the geolocalisation following the IP address
require_once(DIR . '/../vendor/autoload.php');
use GeoIp2\Database\Reader;

// This creates the Reader object, which should be reused across lookups.
$reader = new Reader(DIR . '/../assets/GeoIP2/GeoLite2-Country.mmdb');

$record = $reader->country($_SERVER["REMOTE_ADDR"]);

$countrylist = array(
	'AT',
	'BE',
	'BG',
	'HR',
	'CY',
	'CZ',
	'DK',
	'EE',
	'FI',
	'FR',
	'DE',
	'EL',
	'HU',
	'IE',
	'IT',
	'LV',
	'LT',
	'LU',
	'MT',
	'NL',
	'PL',
	'PT',
	'RO',
	'SK',
	'SI',
	'ES',
	'SE'
);

if (!$record)
{
	// No record found
	$result = array(
		'isoCode' => $isoCode,
		'status' => 'error',
		'message' => 'Internal error'
	);
}
else if (!$_SERVER["REMOTE_ADDR"])
{
	// $_SERVER['REMOTE_ADDR'] is empty
	$result = array(
		'isoCode' => $isoCode,
		'status' => 'error',
		'message' => 'Ip address not found'
	);
}
else if (in_array($record->country->isoCode, $countrylist))
{
	// All is good here
	$result = array(
		'isoCode' => $record->country->isoCode,
		'status' => 'success',
		'message' => $message
	);
}

$result_json = json_encode($result);

header('Content-Type: application/json');
header('Content-Length:' . strlen($result_json));

// Returns the result to display or not the GDPR bar
echo $result_json;

?>
