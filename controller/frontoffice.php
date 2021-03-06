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
include(CWD . '/model/config.php');

if (sizeof($config) == 0)
{
	if (file_exists(CWD . '/model/config.php'))
	{
		die('<br /><br /><strong>Configuration</strong>: model/config.php does not exist. Please fill out the data in config.php.new and rename it to config.php');
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

// Include it for all, use everywhere
require_once(DIR . '/controller/Utils.php');
require_once(DIR . '/vendor/autoload.php');

date_default_timezone_set('Europe/Paris');

// Here, import files only on specific routing
if (in_array($do, ['index']))
{
	require_once(DIR . '/controller/frontoffice/index.php');
}

if (in_array($do, ['register', 'doregister', 'login', 'dologin', 'dashboard', 'editprofile', 'saveprofile', 'editpassword', 'savepassword', 'forgotpassword', 'sendpassword', 'deleteprofile', 'dodeleteprofile', 'vieworders', 'vieworder', 'viewmessages', 'viewmessage', 'sendreply', 'claim', 'doclaim', 'exportpdf', 'logout']))
{
	require_once(DIR . '/controller/frontoffice/customer.php');
}

if (in_array($do, ['viewproduct', 'search']))
{
	require_once(DIR . '/controller/frontoffice/products.php');
}

if (in_array($do, ['viewcategory']))
{
	require_once(DIR . '/controller/frontoffice/categories.php');
}

if (in_array($do, ['viewcart', 'viewcheckout', 'placeorder', 'paymentprocess', 'paymentsuccess', 'paymentfailed']))
{
	require_once(DIR . '/controller/frontoffice/shopping.php');
}

if (in_array($do, ['contact', 'sendcontact']))
{
	require_once(DIR . '/controller/frontoffice/contact.php');
}

if (in_array($do, ['advancedsearch', 'searchresults']))
{
	require_once(DIR . '/controller/frontoffice/search.php');
}

?>
