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

if (in_array($do, ['listroles', 'addrole', 'insertrole', 'editrole', 'updaterole', 'updateroleperms', 'deleterole']))
{
	require_once(DIR . '/controller/backoffice/roles.php');
}

if (in_array($do, ['index', 'login', 'dologin', 'logout', 'listemployees', 'addemployee', 'insertemployee', 'editemployee', 'updateemployee', 'deleteemployee']))
{
	require_once(DIR . '/controller/backoffice/employees.php');
}

if (in_array($do, ['listcategories', 'addcategory', 'insertcategory', 'editcategory', 'updatecategory', 'deletecategory']))
{
	require_once(DIR . '/controller/backoffice/categories.php');
}

if (in_array($do, ['listtrademarks', 'addtrademark', 'inserttrademark', 'edittrademark', 'updatetrademark', 'deletetrademark']))
{
	require_once(DIR . '/controller/backoffice/trademarks.php');
}

if (in_array($do, ['listdelivers', 'adddeliver', 'insertdeliver', 'editdeliver', 'updatedeliver', 'deletedeliver']))
{
	require_once(DIR . '/controller/backoffice/delivers.php');
}

if (in_array($do, ['listproducts', 'addproduct', 'insertproduct', 'editproduct', 'updateproduct', 'deleteproduct']))
{
	require_once(DIR . '/controller/backoffice/products.php');
}

if (in_array($do, ['listcustomers', 'addcustomer', 'insertcustomer', 'editcustomer', 'updatecustomer', 'deletecustomer', 'viewcustomerprofile', 'viewcustomerorderdetails']))
{
	require_once(DIR . '/controller/backoffice/customers.php');
}

if (in_array($do, ['listmessages', 'addmessage', 'insertmessage', 'editmessage', 'updatemessage', 'deletemessage']))
{
	require_once(DIR . '/controller/backoffice/messages.php');
}

?>