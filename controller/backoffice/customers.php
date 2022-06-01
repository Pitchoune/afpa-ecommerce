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
	if (Utils::cando(28))
	{
		global $config, $pagenumber;

		$customers = new ModelCustomer($config);
		$totalcustomers = $customers->getTotalNumberOfCustomers();

		$perpage = 10;
		$limitlower = Utils::define_pagination_values($totalcustomers['nbcustomers'], $pagenumber, $perpage);

		$customerlist = $customers->getSomeCustomers($limitlower, $perpage);

		ViewCustomer::CustomerList($customers, $customerlist, $totalcustomers, $limitlower, $perpage);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des clients.');
	}
}

/**
 * Displays a form to add a new customer.
 *
 * @return void
 */
function AddCustomer()
{
	if (Utils::cando(29))
	{
		global $config;

		$customers = new ModelCustomer($config);

		$customerinfos = [
			'nom' => ''
		];

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Ajouter un client';
		$formredirect = 'insertcustomer';

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
			'' => $navtitle
		];

		ViewCustomer::CustomerAddEdit('', $navtitle, $navbits, $customerinfos, $formredirect, $pagetitle);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des clients.');
	}
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
	if (Utils::cando(29))
	{
		global $config;

		$firstname = trim(strval($firstname));
		$lastname = trim(strval($lastname));
		$email = trim(strval($email));
		$password = trim(strval($password));
		$telephone = trim(strval($telephone));
		$address = trim(strval($address));
		$city = trim(strval($city));
		$zipcode = trim(strval($zipcode));

		$customers = new ModelCustomer($config);

		// Verify first name
		if ($firstname === '' OR empty($firstname))
		{
			throw new Exception('Le prénom est vide.');
		}

		if (!preg_match('/^[\p{L}\s-]{2,}$/u', trim($firstname)))
		{
			throw new Exception('Le prénom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify last name
		if ($lastname === '' OR empty($lastname))
		{
			throw new Exception('Le nom est vide.');
		}

		if (!preg_match('/^[\p{L}\s]{1,}$/u', $lastname))
		{
			throw new Exception('Le nom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify email address
		if ($email === '' OR empty($email))
		{
			throw new Exception('L\'adresse email est vide.');
		}

		if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
		{
			throw new Exception('L\'adresse email n\'est pas valide.');
		}

		// Verify password
		if ($password === '' OR empty($password))
		{
			throw new Exception('Le mot de passe est vide.');
		}

		if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
		{
			throw new Exception('Le mot de passe n\'est pas valide.');
		}

		// Verify telephone
		if ($telephone === '' OR empty($telephone))
		{
			throw new Exception('Le téléphone est vide.');
		}

		if (!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $telephone))
		{
			throw new Exception('Le téléphone n\'est pas valide.');
		}

		// Verify address
		if ($address === '' OR empty($address))
		{
			throw new Exception('L\'adresse est vide.');
		}

		if (!preg_match('/^[\d\w\-\s]{5,100}$/', $address))
		{
			throw new Exception('L\'adresse n\'est pas valide.');
		}

		// Verify city
		if ($city === '' OR empty($city))
		{
			throw new Exception('La ville est vide.');
		}

		if (!preg_match('/^([a-zA-Z]+(?:[\s-][a-zA-Z]+)*){1,}$/u', $city))
		{
			throw new Exception('La ville n\'est pas valide.');
		}

		// Verify zip code
		if ($zipcode === '' OR empty($zipcode))
		{
			throw new Exception('Le code postal est vide.');
		}

		if (!preg_match('/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/', $zipcode))
		{
			throw new Exception('Le code postal n\'est pas valide.');
		}

		$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

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
		}
		else
		{
			throw new Exception('Le client n\'a pas été ajouté.');
		}

		// Save is correctly done, redirects to the customers list
		header('Location: index.php?do=listcustomers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des clients.');
	}
}

/**
 * Displays a form to edit a customer.
 *
 * @return void
 */
function EditCustomer($id)
{
	if (Utils::cando(30))
	{
		global $config;

		$customers = new ModelCustomer($config);

		$id = intval($id);

		$customers->set_id($id);
		$customerinfos = $customers->getCustomerInfosFromId();

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Modifier un client';
		$formredirect = 'updatecustomer';

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
			'' => $navtitle
		];

		ViewCustomer::CustomerAddEdit($id, $navtitle, $navbits, $customerinfos, $formredirect, $pagetitle);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des clients.');
	}
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
	if (Utils::cando(30))
	{
		global $config;

		$id = intval($id);
		$firstname = trim(strval($firstname));
		$lastname = trim(strval($lastname));
		$email = trim(strval($email));
		$password = trim(strval(password));
		$telephone = trim(strval(telephone));
		$address = trim(strval(address));
		$city = trim(strval(city));
		$zipcode = trim(strval(zipcode));

		$customers = new ModelCustomer($config);

		// Verify first name
		if ($firstname === '')
		{
			throw new Exception('Le prénom est vide.');
		}

		if (!preg_match('/^[\p{L}\s]{2,}$/u', $firstname))
		{
			throw new Exception('Le prénom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify last name
		if ($lastname === '')
		{
			throw new Exception('Le nom est vide.');
		}

		if (!preg_match('/^[\p{L}\s]{1,}$/u', $lastname))
		{
			throw new Exception('Le nom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify email address
		if ($email === '')
		{
			throw new Exception('L\'adresse email est vide.');
		}

		if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
		{
			throw new Exception('L\'adresse email n\'est pas valide.');
		}

		if ($password)
		{
			// Verify password
			if ($password === '' OR empty($password))
			{
				throw new Exception('Le mot de passe est vide.');
			}

			if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
			{
				throw new Exception('Le mot de passe n\'est pas valide.');
			}
		}

		// Verify telephone
		if ($telephone === '')
		{
			throw new Exception('Le téléphone est vide.');
		}

		if (!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $telephone))
		{
			throw new Exception('Le téléphone n\'est pas valide.');
		}

		// Verify address
		if ($address === '')
		{
			throw new Exception('L\'adresse est vide.');
		}

		if (!preg_match('/^[\d\w\-\s]{5,100}$/', $address))
		{
			throw new Exception('L\'adresse n\'est pas valide.');
		}

		// Verify city
		if ($city === '')
		{
			throw new Exception('La ville est vide.');
		}

		if (!preg_match('/^([a-zA-Z]+(?:[\s-][a-zA-Z]+)*){1,}$/u', $city))
		{
			throw new Exception('La ville n\'est pas valide.');
		}

		// Verify zip code
		if ($zipcode === '')
		{
			throw new Exception('Le code postal est vide.');
		}

		if (!preg_match('/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/', $zipcode))
		{
			throw new Exception('Le code postal n\'est pas valide.');
		}

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
		}
		else
		{
			throw new Exception('Le client n\'a pas été enregistré.');
		}

		// Save is correctly done, redirects to the customers list
		header('Location: index.php?do=listcustomers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des clients.');
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
	if (Utils::cando(34))
	{
		global $config;

		$customers = new ModelCustomer($config);

		$id = intval($id);

		$customers->set_id($id);
		$customer = $customers->getCustomerInfosFromId();

		ViewCustomer::CustomerDeleteConfirmation($id, $customer);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des clients.');
	}
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
	if (Utils::cando(34))
	{
		global $config;

		$id = intval($id);

		$customers = new ModelCustomer($config);

		$customers->set_id($id);

		if ($customers->deleteCustomer())
		{
			$_SESSION['customer']['delete'] = 1;
		}

		// Save is correctly done, redirects to the customers list
		header('Location: index.php?do=listcustomers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des clients.');
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
	if (Utils::cando(33))
	{
		global $config;

		$customers = new ModelCustomer($config);
		$customers->set_id($id);
		$data = $customers->getCustomerInfosFromId();

		// Grab an external value and add it into the data array filled above
		$orders = new ModelOrder($config);
		$orders->set_customer($data['id']);
		$data += $orders->getNumberOfOrdersForCustomer();

		ViewCustomer::ViewCustomerProfile($id, $orders, $data);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
	}
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
	global $config;

	$customers = new ModelCustomer($config);
	$customers->set_id($id);
	$data = $customers->getCustomerInfosFromId();

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
	if (Utils::cando(32))
	{
		global $config;

		// Grab an external value and add it into the data array filled above
		$orders = new ModelOrder($config);
		$orders->set_id($id);
		$data = $orders->getOrderDetails();

		// Get customer informations
		$customers = new ModelCustomer($config);
		$customers->set_id($data['id_client']);
		$customer = $customers->getCustomerInfosFromId();

		ViewCustomer::ViewOrderDetails($id, $data, $customer);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
	}
}

/**
 * Updates the order status.
 *
 * @param integer $id ID of the order.
 * @param integer $status ID of a fictive status. 2 for 'Preparing', 3 for 'Sent'.
 */
function ChangeOrderStatus($id, $status)
{
	global $config;

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