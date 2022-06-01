<?php

// Define current directory
if (!defined('CWD'))
{
	/**
	 * Tries to define the path from root of the server.
	 */
	define('CWD', (($getcwd = getcwd()) ? $getcwd . '/..' : '.'));
}

// Parse the config file for database connection
$config = [];
include(CWD . '/model/config.php');

if (sizeof($config) == 0)
{
	if (file_exists(CWD . '/../model/config.php'))
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

if (in_array($do, ['listroles', 'addrole', 'insertrole', 'editrole', 'updaterole', 'updateroleperms', 'deleterole', 'killrole']))
{
	require_once(DIR . '/controller/backoffice/roles.php');
}

if (in_array($do, ['index', 'login', 'dologin', 'logout', 'listemployees', 'addemployee', 'insertemployee', 'editemployee', 'updateemployee', 'deleteemployee', 'killemployee', 'profile', 'updateprofile']))
{
	require_once(DIR . '/controller/backoffice/employees.php');
}

if (in_array($do, ['listcategories', 'addcategory', 'insertcategory', 'editcategory', 'updatecategory', 'deletecategory', 'killcategory', 'updateorder']))
{
	require_once(DIR . '/controller/backoffice/categories.php');
}

if (in_array($do, ['listtrademarks', 'addtrademark', 'inserttrademark', 'edittrademark', 'updatetrademark', 'deletetrademark', 'killtrademark']))
{
	require_once(DIR . '/controller/backoffice/trademarks.php');
}

if (in_array($do, ['listdelivers', 'adddeliver', 'insertdeliver', 'editdeliver', 'updatedeliver', 'deletedeliver', 'killdeliver']))
{
	require_once(DIR . '/controller/backoffice/delivers.php');
}

if (in_array($do, ['listproducts', 'addproduct', 'insertproduct', 'editproduct', 'updateproduct', 'deleteproduct', 'killproduct']))
{
	require_once(DIR . '/controller/backoffice/products.php');
}

if (in_array($do, ['listcustomers', 'addcustomer', 'insertcustomer', 'editcustomer', 'updatecustomer', 'deletecustomer', 'killcustomer', 'viewcustomerprofile', 'viewcustomerallorders', 'viewcustomerorderdetails', 'changecustomerorderstatus']))
{
	require_once(DIR . '/controller/backoffice/customers.php');
}

if (in_array($do, ['listmessages', 'viewconversation', 'sendreply']))
{
	require_once(DIR . '/controller/backoffice/messages.php');
}

if (in_array($do, ['listorders']))
{
	require_once(DIR . '/controller/backoffice/orders.php');
}

?>