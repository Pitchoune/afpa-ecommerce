<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelMessage.php');

require_once(DIR . '/view/frontoffice/ViewContact.php');
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

	ViewContact::DisplayContactForm($customer);
}

/**
 * Sends the contact form.
 *
 * @param string $firstname First name of the contact.
 * @param string $lastname Last name of the contact.
 * @param string $email Email address of the contact.
 * @param string $telephone Phone of the contact.
 * @param string $title Title of the message.
 * @param string $message Content of the message.
 *
 * @return void
 */
function sendContact($firstname, $lastname, $email, $telephone, $title, $message)
{
	global $config;

	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$telephone = trim(strval($telephone));
	$title = trim(strval($title));
	$message = trim(strval($message));

	$message = nl2br($message);

	if ($_SESSION['user']['id'])
	{
		$customers = new ModelCustomer($config);
		$customers->set_id($_SESSION['user']['id']);
	}

	// Validate first name
	$validmessage = Utils::datavalidation($firstname, 'firstname', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate last name
	$validmessage = Utils::datavalidation($lastname, 'lastname', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate email
	$validmessage = Utils::datavalidation($email, 'mail');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate telephone
	$validmessage = Utils::datavalidation($telephone, 'telephone');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate title
	$validmessage = Utils::datavalidation($title, 'title');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate message
	$validmessage = Utils::datavalidation($message, 'message', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- _ ~ - ! @ # : " \' = . , ; $ % ^ & * ( ) [ ] &lt; &gt;');

	if ($validmessage)
	{
		throw new Exception($validmessage);
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
