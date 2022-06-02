<?php

require_once(DIR . '/view/backoffice/ViewMessage.php');
require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelMessage;

/**
 * Lists all conversations.
 *
 * @return void
 */
function ListMessages()
{
	if (Utils::cando(18))
	{
		global $config, $pagenumber;

		$messages = new ModelMessage($config);
		$messages->set_type('contact');
		$totalmessages = $messages->countMessagesFromType();

		$perpage = 10;
		$limitlower = Utils::define_pagination_values($totalmessages['nbmessages'], $pagenumber, $perpage);

		$messagelist = $messages->getSomeMessages($limitlower, $perpage);

		ViewMessage::MessageList($messages, $messagelist, $totalmessages, $limitlower, $perpage);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des transporteurs.');
	}
}

/**
 * Display the HTML code for a list of messages in a conversation.
 *
 * @param integer $id ID of the root conversation.
 *
 * @return void
 */
function ViewConversation($id)
{
	global $config;

	$messagelist = new ModelMessage($config);

	$id = intval($id);

	$messagelist->set_id($id);

	// Initialize the ids list array of all messages from the same conversation
	$messageids = [];
	$messageids[] = $id;
	$title = '';
	$latestid = 0;

	do {
		// Grab the next id from the latest grabbed
		$i = $messagelist->getNextMessageIdFromDiscussion();
		$messagelist->set_id($i['id']);

		// If the query result is empty, quit the loop
		if (empty($i['id']))
		{
			break;
		}

		// Add the latest found id in the ids list array
		$messageids[] = $i['id'];

		// Get the latest id only for send reply save
		$latestid = $i['id'];
	} while (true);

	// Now we have the ids list array filled with the correct ids, we can transform it
	// into a comma-separated id list for the query to grab all messages
	$list = implode(',', $messageids);

	// Get messages
	$messages = $messagelist->grabAllMessagesFromDiscussion($list);

	// Get only the first title if there is any other (should not)
	$title = $messages[0]['titre'];

	// Fill the correct latest ID if it's value is still to 0 (first reply)
	if ($latestid === 0)
	{
		$latestid = $id;
	}

	// Make impossible to open a discussion without $id being the first message
	if ($messages[0]['precedent_id'] AND $messages[0]['id'] == $id)
	{
		throw new Exception('Vous ne pouvez pas ouvrir une conversation depuis un message qui n\'est pas le premier message.');
	}

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);

	$customerinfos = $customer->getCustomerInfosFromId();

	ViewMessage::ViewConversation($id, $messages, $title, $customerinfos, $latestid);
}

/**
 * Adds the reply into the database.
 *
 * @param integer $id ID of the conversation.
 * @param integer $latestid ID of the latest reply.
 * @param string $reply Message of the employee.
 * @param integer $customerid ID of the customer.
 *
 * @return void
 */
function SendReply($id, $latestid, $reply, $customerid)
{
	global $config;

	$id = intval($id);
	$latestid = intval($latestid);
	$reply = trim(strval($reply));
	$customerid = intval($customerid);

	$messages = new ModelMessage($config);

	$date = date("Y-m-d H:i:s");

	$messages->set_type('contact');
	$messages->set_title(NULL);
	$messages->set_message($reply);
	$messages->set_date($date);
	$messages->set_previous($latestid);
	$messages->set_customer(NULL);
	$messages->set_employee($_SESSION['employee']['id']);

	if ($messages->saveNewMessage())
	{
		// Send an email to the customer
		$customers = new ModelCustomer($config);
		$customers->set_id($customerid);

		// Return to the original page
		$_SESSION['employee']['messaging']['replied'] = 1;
		header('Location: index.php?do=viewconversation&id=' . $id);
	}
	else
	{
		throw new Exception('Une erreur est survenue pendant l\'envoi de la réponse. Veuillez recommencer.');
	}
}

?>