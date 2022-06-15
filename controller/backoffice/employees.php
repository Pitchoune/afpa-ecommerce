<?php

require_once(DIR . '/view/backoffice/ViewEmployee.php');
require_once(DIR . '/model/ModelEmployee.php');
require_once(DIR . '/model/ModelRole.php');
use \Ecommerce\Model\ModelEmployee;
use \Ecommerce\Model\ModelRole;

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
function doLogin($email, $password)
{
	global $config;

	$email = trim(strval($email));
	$password = trim(strval($password));

	// Enabling the model call here, useful to validate data
	$employees = new ModelEmployee($config);

	// Validate email
	$validmessage = Utils::datavalidation($email, 'mail');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate password
	$validmessage = Utils::datavalidation($password, 'pass');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// No error - get the employee informations to login
	$employees->set_email($email);
	$employe = $employees->getEmployeeInfosFromEmail();

	// Check if employee infos are found
	if ($employe !== false)
	{
		// Employee found, verify password
		if (password_verify($password, $employe['pass']))
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
	// If employee have a valid session in frontoffice, let's stay logged-in
	$user = $_SESSION['user'];

	// Kill the whole session
	$_SESSION['employee'] = [];
	session_destroy();

	// Recreate session for frontoffice
	session_start();
	$_SESSION['user'] = $user;

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
	if (!Utils::cando(5))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des employés.');
	}

	global $config, $pagenumber;

	$employees = new ModelEmployee($config);
	$totalemployees = $employees->getTotalNumberOfEmployees();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totalemployees['nbemployees'], $pagenumber, $perpage);

	$employeeslist = $employees->getSomeEmployees($limitlower, $perpage);

	ViewEmployee::EmployeeList($employees, $employeeslist, $totalemployees, $limitlower, $perpage);
}

/**
 * Displays a form to add a new employee
 *
 * @return void
 */
function AddEmployee()
{
	if (!Utils::cando(6))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des employés.');
	}

	global $config;

	$employees = new ModelEmployee($config);

	$employeeinfos = [
		'nom' => '',
		'prenom' => '',
		'mail' => '',
		'role' => ''
	];

	$pagetitle = 'Gestion des employées';
	$navtitle = 'Ajouter un employé';
	$formredirect = 'insertemployee';

	$roles = new ModelRole($config);
	$rolelist = $roles->listAllRoles();

	if ($rolelist)
	{
		$options = '<option value="0" selected disabled>Sélectionnez un rôle</option>';

		foreach ($rolelist AS $key => $value)
		{
			$options .= '<option value="' . $value['id'] . '">' . $value['nom'] . '</option>';
		}
	}
	else
	{
		$options = '<option value="0" disabled>Il n\'y a pas de rôle à lister.</option>';
	}

	$navbits = [
		'index.php?do=listemployees' => $pagetitle,
		'' => $navtitle
	];

	ViewEmployee::EmployeeAddEdit($navtitle, $navbits, $employeeinfos, $formredirect, $pagetitle, $options);
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
	if (!Utils::cando(6))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des employés.');
	}

	$firstname = trim(strval($firstname));
	$lastname =  trim(strval($lastname));
	$email = trim(strval($email));
	$password  = trim(strval($password));
	$role = intval($role);

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
	$validmessage = Utils::datavalidation($password, 'pass');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	if ($role === 0)
	{
		throw new Exception('Le rôle indiqué n\'est pas valide. Ceci est sûrement dû à cause d\'une liste de rôles disponibles vide. Veuillez contacter votre responsable.');
	}

	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

	global $config;

	$employees = new ModelEmployee($config);
	$employees->set_firstname($firstname);
	$employees->set_lastname($lastname);
	$employees->set_email($email);
	$employees->set_password($hashedpassword);
	$employees->set_role($role);

	// Save the new employee in the database
	if ($employees->saveNewEmployee())
	{
		$_SESSION['employee']['add'] = 1;
		header('Location: index.php?do=listemployees');
	}
}

/**
 * Displays a form to edit an employee.
 *
 * @param integer $id Id of the employee to edit.
 *
 * @return void
 */
function EditEmployee($id)
{
	if (!Utils::cando(7))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des employés.');
	}

	$id = intval($id);

	global $config;

	$employees = new ModelEmployee($config);
	$employees->set_id($id);
	$employeeinfos = $employees->listEmployeeInfos();

	$pagetitle = 'Gestion des employées';
	$navtitle = 'Modifier un employé';
	$formredirect = 'updateemployee';
	$options = '<option value="0" disabled>Sélectionnez un rôle</option>';

	$roles = new ModelRole($config);
	$rolelist = $roles->listAllRoles();

	if ($rolelist)
	{
		foreach ($rolelist AS $key => $value)
		{
			$options .= '<option value="' . $value['id'] . '">' . $value['nom'] . '</option>';
		}
	}
	else
	{
		$options = '<option value="0" disabled>Il n\'y a pas de rôle à lister.</option>';
	}

	$navbits = [
		'index.php?do=listemployees' => $pagetitle,
		'' => $navtitle
	];

	ViewEmployee::EmployeeAddEdit($navtitle, $navbits, $employeeinfos, $formredirect, $pagetitle, $options, $id);
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
	if (!Utils::cando(7))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des employés.');
	}

	$id = intval($id);
	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$password = trim(strval($password));
	$role = intval($role);

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
		$validmessage = Utils::datavalidation($password, 'pass');

		if ($validmessage)
		{
			throw new Exception($validmessage);
		}
	}

	if ($role === 0)
	{
		throw new Exception('Le rôle indiqué n\'est pas valide. Ceci est sûrement dû à cause d\'une liste de rôles disponibles vide. Veuillez contacter votre responsable.');
	}

	global $config;

	$employees = new ModelEmployee($config);
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

	header('Location: index.php?do=listemployees');
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the employee to delete.
 *
 * @return void
 */
function DeleteEmployee($id)
{
	if (!Utils::cando(8))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des employés.');
	}

	global $config;

	$id = intval($id);

	$employees = new ModelEmployee($config);

	$employees->set_id($id);
	$employee = $employees->listEmployeeInfos();

	if (!$employee)
	{
		throw new Exception('L\'employé n\'existe pas.');
	}

	ViewEmployee::EmployeeDeleteConfirmation($id, $employee);
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
	if (!Utils::cando(8))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des employés.');
	}

	$id = intval($id);

	global $config;

	$employees = new ModelEmployee($config);

	$total = $employees->getTotalNumberOfEmployees();

	if ($total['nbemployees'] > 1)
	{
		$employees->set_id($id);

		if ($employees->deleteEmployee())
		{
			$_SESSION['employee']['delete'] = 1;
			header('Location: index.php?do=listemployees');
		}
	}
	else
	{
		throw new Exception('Vous ne pouvez pas supprimer le dernier employé.');
	}
}

/**
 * Display the current employee profile to edit own informations.
 *
 * @return void
 */
function ViewProfile()
{
	global $config;

	$employees = new ModelEmployee($config);
	$employees->set_id($_SESSION['employee']['id']);
	$employee = $employees->getEmployeeInfosFromId();

	ViewEmployee::ViewProfile($employee);
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

	// Validate email
	$validmessage = Utils::datavalidation($email, 'mail');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	if ($password)
	{
		// Validate password
		$validmessage = Utils::datavalidation($password, 'pass');

		if ($validmessage)
		{
			throw new Exception($validmessage);
		}
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

	header('Location: index.php?do=profile');
}

?>