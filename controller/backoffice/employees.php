<?php

require_once(DIR . '/model/ModelEmployee.php');
use \Ecommerce\Model\ModelEmployee;

/**
 * Displays the index page as a dashboard.
 *
 * @return void
 */
function index()
{
	// We generate HTML code from the view
	require_once(DIR . '/view/backoffice/ViewDashboard.php');
	ViewDashboard::DisplayDashboard();
}

/**
 * Displays the login form.
 *
 * @return void
 */
function login()
{
	// We generate HTML code from the view
	require_once(DIR . '/view/backoffice/ViewEmployee.php');
	ViewEmployee::loginForm();
}

/**
 * Logins the admin.
 *
 * @param string $email Email of the employee.
 * @param string $pass Password of the employee.
 *
 * @return mixed If there is an error, throw an exception else redirects to index.php
 */
function doLogin($email, $pass)
{
	global $config;

	$email = trim(strval($email));
	$pass = trim(strval($pass));

	// Enabling the model call here, useful to validate data
	$employees = new ModelEmployee($config);

	// Validate email
	if (empty($email))
	{
		throw new Exception('Veuillez insérer votre adresse email.');
	}
	else if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
	{
		throw new Exception('Veuillez insérer une adresse email valide.');
	}

	// Validate password
	if (empty($pass))
	{
		throw new Exception('Veuillez insérer un mot de passe valide.');
	}

	/*if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
	{
		throw new Exception('Le format du mot de passe n\'est pas valide.');
	}*/

	// No error - get the employee informations to login
	$employees->set_email($email);
	$employe = $employees->getEmployeeInfosFromEmail();

	// Check if employee infos are found
	if ($employe !== false)
	{
		// Employee found, verify password
		if (password_verify($pass, $employe['pass']))
		{
			// Store session informations
			$_SESSION['employee']['loggedin'] = true;
			$_SESSION['employee']['id'] = $employe['id'];
			$_SESSION['employee']['roleid'] = $employe['role'];
			$_SESSION['employee']['permissions'] = [];

			// Get permissions and store them in the session
			$employees->set_role($employe['role']);
			$permissions = $employees->getEmployeePermissions();

			foreach ($permissions AS $permission)
			{
				$_SESSION['employee']['permissions'][] = $permission['id_perm'];
			}
		}
		else
		{
			// Employee password does not correspond, don't tell it to the user to avoid security issues (hacker can try to force brute the login if the account is labelled as existing)
			throw new Exception('Une erreur est survenue, veuillez recommencer.');
		}

		// Employee is logged-in, redirects
		header('Location: index.php');
	}
	else
	{
		// Employee not found, don't tell it to the user to avoid security issues (hacker can try to force brute the login if the account is labelled as existing)
		throw new Exception('Une erreur est survenue, veuillez recommencer.');
	}
}

/**
 * Logouts from the admin.
 *
 * @return void
 */
function doLogout()
{
	// Kill the whole session
	$_SESSION['employee'] = [];
	session_destroy();

	// Redirects the user to the index.php page
	header('Location: index.php');
}

/**
 * Lists all employees.
 *
 * @return void
 */
function ListEmployees()
{
	if (Utils::cando(5))
	{
		require_once(DIR . '/view/backoffice/ViewEmployee.php');
		ViewEmployee::EmployeeList();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des employés.');
	}
}

/**
 * Displays a form to add a new employee
 *
 * @return void
 */
function AddEmployee()
{
	if (Utils::cando(6))
	{
		require_once(DIR . '/view/backoffice/ViewEmployee.php');
		ViewEmployee::EmployeeAddEdit();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des employés.');
	}
}

/**
 * Inserts a new employee into the database.
 *
 * @param string $firstname First name of the employee.
 * @param string $lastname Last name of the employee.
 * @param string $email Email of the employee.
 * @param string $password Password of the employee.
 * @param integer $role Role of the employee.
 *
 * @return void
 */
function InsertEmployee($firstname, $lastname, $email, $password, $role)
{
	if (Utils::cando(6))
	{
		global $config;

		$firstname = trim(strval($firstname));
		$lastname =  trim(strval($lastname));
		$email = trim(strval($email));
		$password  = trim(strval($password));
		$role = trim(strval($role));

		$employees = new ModelEmployee($config);

		// Verify firstname
		if ($firstname === '' OR empty($firstname))
		{
			throw new Exception('Le prénom est vide.');
		}

		if (!preg_match('/^[\p{L}\s-]{2,}$/u', trim($firstname)))
		{
			throw new Exception('Le prénom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify lastname
		if ($lastname === '' OR empty($lastname))
		{
			throw new Exception('Le nom est vide.');
		}

		if (!preg_match('/^[\p{L}\s]{1,}$/u', $lastname))
		{
			throw new Exception('Le nom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify email
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
			throw new Exception('Le nmot de passe est vide.');
		}

		if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
		{
			throw new Exception('Le mot de passe n\'est pas valide.');
		}

		// Verify role
		if ($role === '' OR (empty($role)))
		{
			throw new Exception('Le rôle est vide.');
		}

		if ($role === '0')
		{
			throw new Exception('Le rôle indiqué n\'est pas valide. Ceci est sûrement dû à cause d\'une liste de rôles disponibles vide. Veuillez contacter votre responsable.');
		}

		$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

		$employees->set_firstname($firstname);
		$employees->set_lastname($lastname);
		$employees->set_email($email);
		$employees->set_password($hashedpassword);
		$employees->set_role($role);

		// Save the new employee in the database
		if ($employees->saveNewEmployee())
		{
			$_SESSION['employee']['add'] = 1;
		}

		// Save is correctly done, redirects to the employees list
		header('Location: index.php?do=listemployees');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des employés.');
	}
}

/**
 * Displays a form to edit an employee.
 *
 * @return void
 */
function EditEmployee($id)
{
	if (Utils::cando(7))
	{
		$id = intval($id);

		require_once(DIR . '/view/backoffice/ViewEmployee.php');
		ViewEmployee::EmployeeAddEdit($id);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des employés.');
	}
}

/**
 * Updates the given employee into the database.
 *
 * @param integer $id ID of the employee.
 * @param string $firstname First name of the employee.
 * @param string $lastname Last name of the employee.
 * @param string $email Email of the employee.
 * @param string $password Password of the employee.
 * @param integer $role Role of the employee.
 *
 * @return void
 */
function UpdateEmployee($id, $firstname, $lastname, $email, $password, $role)
{
	if (Utils::cando(7))
	{
		global $config;

		$id = intval($id);
		$firstname = trim(strval($firstname));
		$lastname = trim(strval($lastname));
		$email = trim(strval($email));
		$password = trim(strval($password));
		$role = trim(strval($role));

		$employees = new ModelEmployee($config);

		// Verify firstname
		if ($firstname === '' OR empty($firstname))
		{
			throw new Exception('Le prénom est vide.');
		}

		if (!preg_match('/^[\p{L}\s-]{2,}$/u', trim($firstname)))
		{
			throw new Exception('Le prénom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify lastname
		if ($lastname === '' OR empty($lastname))
		{
			throw new Exception('Le nom est vide.');
		}

		if (!preg_match('/^[\p{L}\s]{1,}$/u', $lastname))
		{
			throw new Exception('Le nom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
		}

		// Verify email
		if ($email === '' OR empty($email))
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
			if ($password === '')
			{
				throw new Exception('Le nmot de passe est vide.');
			}

			if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
			{
				throw new Exception('Le mot de passe n\'est pas valide.');
			}
		}

		// Verify role
		if ($role === '' OR (empty($role)))
		{
			throw new Exception('Le rôle est vide.');
		}

		if ($role === '0')
		{
			throw new Exception('Le rôle indiqué n\'est pas valide. Ceci est sûrement dû à cause d\'une liste de rôles disponibles vide. Veuillez contacter votre responsable.');
		}

		$employees->set_id($id);
		$employees->set_firstname($firstname);
		$employees->set_lastname($lastname);
		$employees->set_email($email);
		$employees->set_role($role);

		if (isset($password))
		{
			$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
			$employees->set_password($hashedpassword);

			// Save the employee in the database
			if ($employees->saveEditEmployeeWithPassword())
			{
				$_SESSION['employee']['edit'] = 1;
			}
		}
		else
		{
			// Save the employee in the database
			if ($employees->saveEditEmployeeWithoutPassword())
			{
				$_SESSION['employee']['edit'] = 1;
			}
		}

		// Save is correctly done, redirects to the employees list
		header('Location: index.php?do=listemployees');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des employés.');
	}
}

function DeleteEmployee($id)
{
	if (Utils::cando(8))
	{
		global $config;

		$id = intval($id);

		require_once(DIR . '/view/backoffice/ViewEmployee.php');
		ViewEmployee::EmployeeDeleteConfirmation($id);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des employés.');
	}
}

/**
 * Deletes the given employee from the database.
 *
 * @param integer $id ID of the employee to delete.
 *
 * @return void
 */
function KillEmployee($id)
{
	if (Utils::cando(8))
	{
		global $config;

		$id = intval($id);

		$employees = new ModelEmployee($config);

		$total = $employees->getTotalNumberOfEmployees();

		if ($total['nbemployees'] > 1)
		{
			$employees->set_id($id);

			if ($employees->deleteEmployee())
			{
				$_SESSION['employee']['delete'] = 1;
			}

			// Save is correctly done, redirects to the employees list
			header('Location: index.php?do=listemployees');
		}
		else
		{
			throw new Exception('Vous ne pouvez pas supprimer le dernier employé.');
		}
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des employés.');
	}
}

/**
 * Display the current employee profile to edit own informations.
 *
 * @return void
 */
function ViewProfile()
{
	require_once(DIR . '/view/backoffice/ViewEmployee.php');
	ViewEmployee::ViewProfile();
}

/**
 * Updates the given employee profile into the database.
 *
 * @param integer $id ID of the employee.
 * @param string $email Email of the employee.
 * @param string $password Password of the employee.
 *
 * @return void
 */
function UpdateProfile($id, $email, $password)
{
	global $config;

	$id = intval($id);
	$email = trim(strval($email));
	$password = trim(strval($password));

	$employees = new ModelEmployee($config);

	// Verify email
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

	$employees->set_id($id);
	$employees->set_email($email);

	if (isset($password))
	{
		$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
		$employees->set_password($hashedpassword);

		// Save the employee in the database
		if ($employees->saveEditEmployeeWithPassword())
		{
			$_SESSION['employee']['edit'] = 1;
		}
	}
	else
	{
		// Save the employee in the database
		if ($employees->saveEditEmployeeWithoutPassword())
		{
			$_SESSION['employee']['edit'] = 1;
		}
	}

	// Save is correctly done, redirects to the profile
	header('Location: index.php?do=profile');
}

?>