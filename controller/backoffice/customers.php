<?php

use \Ecommerce\Model\ModelCustomer;

/**
 * Lists all custoers.
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
function InsertCustomer($firstname, $lastname, $email, $telephone, $address, $city, $zipcode)
{
	if (Utils::cando(29))
	{
		global $config;

		require_once(DIR . '/model/ModelCustomer.php');
		$customers = new \Ecommerce\Model\ModelCustomer($config);

		// Verify first name
		if ($firstname === '')
		{
			throw new Exception('Le nom est vide.');
		}

		// Verify last name
		if ($lastname === '')
		{
			throw new Exception('Le prénom est vide.');
		}

		// Verify email address
		if ($email === '')
		{
			throw new Exception('L\'adresse email est vide.');
		}

		// Verify telephone
		if ($telephone === '')
		{
			throw new Exception('Le téléphone est vide.');
		}

		// Verify address
		if ($address === '')
		{
			throw new Exception('L\'adresse est vide.');
		}

		// Verify city
		if ($city === '')
		{
			throw new Exception('La ville est vide.');
		}

		// Verify zip code
		if ($zipcode === '')
		{
			throw new Exception('Le code postal est vide.');
		}

		$customers->set_firstname($firstname);
		$customers->set_lastname($lastname);
		$customers->set_email($email);
		$customers->set_telephone($telephone);
		$customers->set_address($address);
		$customers->set_city($city);
		$customers->set_zipcode($zipcode);

		if ($customers->saveNewCustomer())
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
function UpdateCustomer($id, $firstname, $lastname, $email, $telephone, $address, $city, $zipcode)
{
	if (Utils::cando(30))
	{
		global $config;

		require_once(DIR . '/model/ModelCustomer.php');
		$customers = new \Ecommerce\Model\ModelCustomer($config);

		// Verify first name
		if ($firstname === '')
		{
			throw new Exception('Le nom est vide.');
		}

		// Verify last name
		if ($lastname === '')
		{
			throw new Exception('Le prénom est vide.');
		}

		// Verify email address
		if ($email === '')
		{
			throw new Exception('L\'adresse email est vide.');
		}

		// Verify telephone
		if ($telephone === '')
		{
			throw new Exception('Le téléphone est vide.');
		}

		// Verify address
		if ($address === '')
		{
			throw new Exception('L\'adresse est vide.');
		}

		// Verify city
		if ($city === '')
		{
			throw new Exception('La ville est vide.');
		}

		// Verify zip code
		if ($zipcode === '')
		{
			throw new Exception('Le code postal est vide.');
		}

		$customers->set_id($id);
		$customers->set_firstname($firstname);
		$customers->set_lastname($lastname);
		$customers->set_email($email);
		$customers->set_telephone($telephone);
		$customers->set_address($address);
		$customers->set_city($city);
		$customers->set_zipcode($zipcode);

		if ($customers->saveCustomerData())
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

function ViewCustomerProfile($id)
{
	require_once(DIR . '/view/backoffice/ViewCustomer.php');
	ViewCustomer::ViewCustomerProfile($id);
}

?>