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
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewContact.php');
	ViewContact::DisplayContactForm();
}

/**
 *
 */
function sendContact($firstname, $lastname, $email, $telephone, $message, $id = '')
{
	global $config;

	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$telephone = trim(strval($telephone));
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

	// Verify message
	if ($message === '' OR empty($message))
	{
		throw new Exception('Veuillez remplir le message.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/u', $message))
	{
		throw new Exception('Le format du message n\'est pas valide.');
	}

	// Save the message
	$messages = new ModelMessage($config);
	$messages->set_type('contact');
	$messages->set_message($message);
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