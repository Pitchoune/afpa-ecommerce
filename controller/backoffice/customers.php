<?php

use \Ecommerce\Model\ModelCustomer;

/**
 * Lists all customers.
 *
 * @return void
 */
function ListCustomers()
{
	if (Utils::cando(28))
	{
		require_once(DIR . '/view/backoffice/ViewCustomer.php');
		ViewCustomer::CustomerList();
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
		require_once(DIR . '/view/backoffice/ViewCustomer.php');
		ViewCustomer::CustomerAddEdit();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des clients.');
	}
}

/**
 * Inserts a new customer into the database.
 *
 * @return void
 */
function InsertCustomer($firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode)
{
	if (Utils::cando(29))
	{
		global $config;

		require_once(DIR . '/model/ModelCustomer.php');
		$customers = new \Ecommerce\Model\ModelCustomer($config);

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
		require_once(DIR . '/view/backoffice/ViewCustomer.php');
		ViewCustomer::CustomerAddEdit($id);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des clients.');
	}
}

/**
 * Updates the given customer into the database.
 *
 * @return void
 */
function UpdateCustomer($id, $firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode)
{
	if (Utils::cando(30))
	{
		global $config;

		require_once(DIR . '/model/ModelCustomer.php');
		$customers = new \Ecommerce\Model\ModelCustomer($config);

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
 * Deletes the given customer.
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

		require_once(DIR . '/model/ModelCustomer.php');
		$customers = new \Ecommerce\Model\ModelCustomer($config);

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
 *
 */
function ViewCustomerProfile($id)
{
	require_once(DIR . '/view/backoffice/ViewCustomer.php');
	ViewCustomer::ViewCustomerProfile($id);
}

?>