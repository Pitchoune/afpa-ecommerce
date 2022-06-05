<?php

require_once(DIR . '/view/backoffice/ViewCustomer.php');
require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelMessage;

/**
 * Lists all customers.
 *
 * @return void
 */
function ListCustomers()
{
	if (!Utils::cando(28))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des clients.');
	}

	global $config, $pagenumber;

	$customers = new ModelCustomer($config);
	$totalcustomers = $customers->getTotalNumberOfCustomers();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totalcustomers['nbcustomers'], $pagenumber, $perpage);

	$customerlist = $customers->getSomeCustomers($limitlower, $perpage);

	ViewCustomer::CustomerList($customers, $customerlist, $totalcustomers, $limitlower, $perpage);
}

/**
 * Displays a form to add a new customer.
 *
 * @return void
 */
function AddCustomer()
{
	if (!Utils::cando(29))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des clients.');
	}

	$customerinfos = [
		'nom' => '',
		'prenom' => '',
		'mail' => '',
		'tel' => '',
		'adresse' => '',
		'ville' => '',
		'code_post' => '',
	];

	$pagetitle = 'Gestion des clients';
	$navtitle = 'Ajouter un client';
	$formredirect = 'insertcustomer';

	$navbits = [
		'index.php?do=listcustomers' => $pagetitle,
		'' => $navtitle
	];

	ViewCustomer::CustomerAddEdit($navtitle, $navbits, $customerinfos, $formredirect, $pagetitle);
}

/**
 * Inserts a new customer into the database.
 *
 * @param string $firstname First name of the customer.
 * @param string $lastname Last name of the customer.
 * @param string $email Email of the customer.
 * @param string $password Password of the customer.
 * @param string $telephone Telephone of the customer.
 * @param string $address Address of the customer.
 * @param string $city City of the customer.
 * @param string $zipcode Zip code of the customer.
 *
 * @return void
 */
function InsertCustomer($firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode)
{
	if (!Utils::cando(29))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des clients.');
	}

	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$password = trim(strval($password));
	$telephone = trim(strval($telephone));
	$address = trim(strval($address));
	$city = trim(strval($city));
	$zipcode = trim(strval($zipcode));

	// Validate firstname
	$validmessage = Utils::datavalidation($firstname, 'firstname', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate lastname
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

	// Validate password
	$validmessage = Utils::datavalidation($password, 'pass', '', $passwordconfirm);

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

	// Validate address
	$validmessage = Utils::datavalidation($address, 'address');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate city
	$validmessage = Utils::datavalidation($city, 'city');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate zipcode
	$validmessage = Utils::datavalidation($zipcode, 'zipcode');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

	global $config;

	$customers = new ModelCustomer($config);
	$customers->set_firstname($firstname);
	$customers->set_lastname($lastname);
	$customers->set_email($email);
	$customers->set_password($hashedpassword);
	$customers->set_telephone($telephone);
	$customers->set_address($address);
	$customers->set_city($city);
	$customers->set_zipcode($zipcode);

	if ($customers->saveNewCustomerFromBack())
	{
		$_SESSION['customer']['add'] = 1;
		header('Location: index.php?do=listcustomers');
	}
	else
	{
		throw new Exception('Le client n\'a pas été ajouté.');
	}
}

/**
 * Displays a form to edit a customer.
 *
 * @return void
 */
function EditCustomer($id)
{
	if (!Utils::cando(30))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des clients.');
	}

	global $config;

	$customers = new ModelCustomer($config);

	$id = intval($id);

	$customers->set_id($id);
	$customerinfos = $customers->getCustomerInfosFromId();

	if (!$customerinfos)
	{
		throw new Exception('Le client n\'existe pas.');
	}

	$pagetitle = 'Gestion des clients';
	$navtitle = 'Modifier un client';
	$formredirect = 'updatecustomer';

	$navbits = [
		'index.php?do=listcustomers' => $pagetitle,
		'' => $navtitle
	];

	ViewCustomer::CustomerAddEdit($navtitle, $navbits, $customerinfos, $formredirect, $pagetitle, $id);
}

/**
 * Updates the given customer into the database.
 *
 * @param integer $id ID of the customer.
 * @param string $firstname First name of the customer.
 * @param string $lastname Last name of the customer.
 * @param string $email Email of the customer.
 * @param string $password Password of the customer.
 * @param string $telephone Telephone of the customer.
 * @param string $address Address of the customer.
 * @param string $city City of the customer.
 * @param string $zipcode Zip code of the customer.
 *
 * @return void
 */
function UpdateCustomer($id, $firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode)
{
	if (!Utils::cando(30))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des clients.');
	}

	$id = intval($id);
	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$password = trim(strval(password));
	$telephone = trim(strval(telephone));
	$address = trim(strval(address));
	$city = trim(strval(city));
	$zipcode = trim(strval(zipcode));

	// Validate firstname
	$validmessage = Utils::datavalidation($firstname, 'firstname', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate lastname
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

	if ($password)
	{
		// Validate password
		$validmessage = Utils::datavalidation($password, 'pass', '', $passwordconfirm);

		if ($validmessage)
		{
			throw new Exception($validmessage);
		}
	}

	// Validate telephone
	$validmessage = Utils::datavalidation($telephone, 'telephone');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate address
	$validmessage = Utils::datavalidation($address, 'address');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate city
	$validmessage = Utils::datavalidation($city, 'city');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate zipcode
	$validmessage = Utils::datavalidation($zipcode, 'zipcode');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	global $config;

	$customers = new ModelCustomer($config);
	$customers->set_id($id);
	$customers->set_firstname($firstname);
	$customers->set_lastname($lastname);
	$customers->set_email($email);
	$customers->set_telephone($telephone);
	$customers->set_address($address);
	$customers->set_city($city);
	$customers->set_zipcode($zipcode);

	if ($password)
	{
		$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
		$customers->set_password($hashedpassword);
		$customer = $customers->saveCustomerDataWithPassword();
	}
	else
	{
		$customer = $customers->saveCustomerData();
	}

	if ($customer)
	{
		$_SESSION['customer']['edit'] = 1;
		header('Location: index.php?do=listcustomers');
	}
	else
	{
		throw new Exception('Le client n\'a pas été enregistré.');
	}
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the customer to delete.
 *
 * @return void
 */
function DeleteCustomer($id)
{
	if (!Utils::cando(35))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des clients.');
	}

	global $config;

	$customers = new ModelCustomer($config);

	$id = intval($id);

	$customers->set_id($id);
	$customer = $customers->getCustomerInfosFromId();

	if (!$customer)
	{
		throw new Exception('Le client n\'existe pas.');
	}

	ViewCustomer::CustomerDeleteConfirmation($id, $customer);
}

/**
 * Deletes the given customer.
 *
 * @param integer $id ID of the customer to delete.
 *
 * @return void
 */
function KillCustomer($id)
{
	if (!Utils::cando(35))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des clients.');
	}

	global $config;

	$id = intval($id);

	$customers = new ModelCustomer($config);
	$customers->set_id($id);

	if ($customers->deleteCustomer())
	{
		$_SESSION['customer']['delete'] = 1;
		header('Location: index.php?do=listcustomers');
	}
}

/**
 * Returns the HTML code to display the customer profile.
 *
 * @param integer $id ID of the customer.
 *
 * @return void
 */
function ViewCustomerProfile($id)
{
	if (!Utils::cando(33))
	{
		throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
	}

	global $config;

	$customers = new ModelCustomer($config);
	$customers->set_id($id);
	$data = $customers->getCustomerInfosFromId();

	if (!$data)
	{
		throw new Exception('Le client n\'existe pas.');
	}

	// Grab an external value and add it into the data array filled above
	$orders = new ModelOrder($config);
	$orders->set_customer($data['id']);
	$data += $orders->getNumberOfOrdersForCustomer();

	ViewCustomer::ViewCustomerProfile($id, $orders, $data);
}
/**
 * Returns the HTML code to display all orders made by the specified customer.
 *
 * @param integer $id ID of the customer.
 *
 * @return void
 */
function ViewCustomerAllOrders($id)
{
	if (!Utils::cando(31))
	{
		throw new Exception('Vous n\'êtes pas autorisé à consulter les commandes des clients.');
	}

	global $config;

	$customers = new ModelCustomer($config);
	$customers->set_id($id);
	$data = $customers->getCustomerInfosFromId();

	if (!$data)
	{
		throw new Exception('Le client n\'existe pas.');
	}

	$orders = new ModelOrder($config);
	$orders->set_customer($data['id']);
	$totalorders = $orders->getNumberOfOrdersForCustomer();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totalorders['nborders'], $pagenumber, $perpage);

	$orderlist = $orders->getAllCustomerOrders($limitlower, $perpage);

	ViewCustomer::ViewCustomerAllOrders($id, $data, $orderlist, $totalorders, $limitlower, $perpage);
}

/**
 * Returns the HTML code to display the order details.
 *
 * @param integer $id ID of the order.
 *
 * @return void
 */
function ViewCustomerOrderDetails($id)
{
	if (!Utils::cando(32))
	{
		throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
	}

	global $config;

	// Grab an external value and add it into the data array filled above
	$orders = new ModelOrder($config);
	$orders->set_id($id);
	$data = $orders->getOrderDetails();

	if (!$data)
	{
		throw new Exception('Le client n\'a pas de commande.');
	}

	// Get customer informations
	$customers = new ModelCustomer($config);
	$customers->set_id($data['id_client']);
	$customer = $customers->getCustomerInfosFromId();

	if (!$customer)
	{
		throw new Exception('Le client n\'existe pas.');
	}

	ViewCustomer::ViewOrderDetails($id, $data, $customer);
}

/**
 * Updates the order status.
 *
 * @param integer $id ID of the order.
 * @param integer $status ID of a fictive status. 2 for 'Preparing', 3 for 'Sent'.
 */
function ChangeOrderStatus($id, $status)
{
	if (!Utils::cando(34))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier l\'état des commandes');
	}

	$id = intval($id);
	$status = intval($status);

	switch($status)
	{
		case 2:
			$mode = 'En préparation';
			break;
		case 3:
			$mode = 'Envoyé';
			break;
	}

	global $config;

	$orders = new ModelOrder($config);
	$orders->set_id($id);
	$orders->set_status($mode);

	if ($orders->updateStatus())
	{
		// Get customer ID
		$orders->set_id($id);
		$order = $orders->getCustomerId();

		// Send a notification in message
		$messages = new ModelMessage($config);
		$messages->set_type('notif');
		$messages->set_message('Commande ' . $id . ' marqué en préparation');
		$messages->set_employee($_SESSION['employee']['id']);
		$messages->set_customer($order['id_client']);
		$messages->set_previous(NULL);

		switch($status)
		{
			case 2:
				$messages->set_message('Commande #' . $id . ' marqué en préparation');
				$_SESSION['employee']['order']['statusprepare'] = 1;
				break;
			case 3:
				$messages->set_message('Commande #' . $id . ' marqué comme envoyé');
				$_SESSION['employee']['order']['statussent'] = 1;
				break;
		}

		if ($messages->saveNewMessage())
		{
			header('Location: index.php?do=viewcustomerorderdetails&id=' . $id);
		}
	}
}

?>
