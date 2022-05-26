<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelMessage;

/**
 * Displays the contact page.
 *
 * @return void
 */
function viewContact()
{
	global $config;

	if ($_SESSION['user']['id'])
	{
		$customers = new ModelCustomer($config);
		$customers->set_id($_SESSION['user']['id']);
		$customer = $customers->getCustomerInfosFromId();
	}

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewContact.php');
	ViewContact::DisplayContactForm($customer);
}

/**
 *
 */
function sendContact($firstname, $lastname, $email, $telephone, $title, $message, $id = '')
{
	global $config;

	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$telephone = trim(strval($telephone));
	$title = trim(strval($title));
	$message = trim(strval($message));
	$id = intval($id);

	if ($_SESSION['user']['id'])
	{
		$customers = new ModelCustomer($config);
		$customers->set_id($_SESSION['user']['id']);
	}

	// Verify first name
	if ($firstname === '' OR empty($firstname))
	{
		throw new Exception('Veuillez remplir le prénom.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/u', $firstname))
	{
		throw new Exception('Le format du prénom n\'est pas valide.');
	}

	// Verify last name
	if ($lastname === '' OR empty($lastname))
	{
		throw new Exception('Veuillez remplir le nom.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/u', $lastname))
	{
		throw new Exception('Le format du nom n\'est pas valide.');
	}

	// Verify email address
	if ($email === '' OR empty($email))
	{
		throw new Exception('Veuillez remplir l\'adresse email.');
	}

	if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
	{
		throw new Exception('Le format de l\'adresse email n\'est pas valide.');
	}

	// Verify telephone
	if ($telephone === '' OR empty($telephone))
	{
		throw new Exception('Veuillez remplir le téléphone.');
	}

	if (!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $telephone))
	{
		throw new Exception('Le format du téléphone n\'est pas valide.');
	}

	// Verify title
	if ($title === '' OR empty($title))
	{
		throw new Exception('Veuillez remplir l\'intitulé.');
	}

	if (!preg_match('/^[\p{L}\s-[:punct:]]{2,}$/u', $title))
	{
		throw new Exception('Le format de l\'intitulé n\'est pas valide.');
	}

	// Verify message
	if ($message === '' OR empty($message))
	{
		throw new Exception('Veuillez remplir le message.');
	}

	if (!preg_match('/^[\p{L}\s-[:punct:]]{2,}$/u', $message))
	{
		throw new Exception('Le format du message n\'est pas valide.');
	}

	$date = date("Y-m-d H:i:s");

	// Save the message
	$messages = new ModelMessage($config);
	$messages->set_type('contact');
	$messages->set_title($title);
	$messages->set_message($message);
	$messages->set_date($date);
	$messages->set_previous(NULL);
	$messages->set_customer($_SESSION['user']['id']);
	$messages->set_employee(NULL);

	if ($messages->saveNewMessage())
	{
		$_SESSION['user']['contact'] = 1;
		header('Location: index.php');
	}
}

?>