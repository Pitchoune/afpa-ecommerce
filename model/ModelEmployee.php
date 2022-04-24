<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about employees
 *
 * @date $Date$
 */
class ModelEmployee extends Model
{
	/**
	 * The ID of the employee.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The first name of the employee.
	 *
	 * @var string
	 */
	private $firstname;

	/**
	 * The last name of the employee.
	 *
	 * @var integer
	 */
	private $lastname;

	/**
	 * The email address of the employee.
	 *
	 * @var string
	 */
	private $email;

	/**
	 * The password of the employee.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * The role of the employee.
	 *
	 * @var integer
	 */
	private $role;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param id $id The ID of the employee.
	 * @param string $firstname The first name of the employee.
	 * @param string $lastname The last name of the employee.
	 * @param string $email The email address of the employee.
	 * @param string $password The password of the employee.
	 * @param integer $role The role of the employee.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $firstname = null, $lastname = null, $email = null, $password = null, $role = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->password = $password;
		$this->role = $role;
	}

	/**
	 * Returns an array of all employees.
	 *
	 * @return array Employees informations.
	 */
	public function listAllEmployees()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT e.*, r.nom AS role
			FROM employe AS e
			INNER JOIN role AS r ON(r.id = e.role)
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of employees in the database.
	 *
	 * @return integer Number of employees.
	 */
	public function getEmployeeCount()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS employeecount
			FROM employe
		");

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the number of users in the given role.
	 *
	 * @return integer Number of users in role
	 */
	public function getNumberOfUsersInRole()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS compteuremploye
			FROM employe
			WHERE role = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves a new employee in the 'employe' table.
	 *
	 * @return mixed Returns saved employee ID or false if there is an error.
	 */
	public function saveNewEmployee()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO employe
				(nom, prenom, mail, pass, role)
			VALUES
				(?, ?, ?, ?, ?)
		");
		$query->bindParam(1, $this->firstname, \PDO::PARAM_STR);
		$query->bindParam(2, $this->lastname, \PDO::PARAM_STR);
		$query->bindParam(3, $this->email, \PDO::PARAM_STR);
		$query->bindParam(4, $this->password, \PDO::PARAM_STR);
		$query->bindParam(5, $this->role, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Retrieves all user data via its email.
	 *
	 * @return mixed Returns the user infos if found or false if not found.
	 */
	public function getEmployeeInfosFromEmail()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT e.*, r.nom AS rolename
			FROM employe AS e
			INNER JOIN role AS r ON (r.id = e.role)
			WHERE e.mail = ?
		");
		$query->bindParam(1, $this->email, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Retrieves all user data via its id.
	 *
	 * Returns the user data WITHOUT the hashed password for security purposes.
	 *
	 * @return mixed Returns the employee infos if found or false if not found.
	 */
	public function getEmployeeInfosFromId()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT e.id, e.prenom, e.nom, e.mail, r.id AS roleid, r.nom AS rolename
			FROM employe AS e
			INNER JOIN role AS r ON (e.role = r.id)
			WHERE e.id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the informations of the employee.
	 *
	 * @return array Informaitons of the employee.
	 */
	public function listEmployeeInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM employe
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the existing specified employee with updated data without the password.
	 *
	 * @return mixed Returns the employee ID if done, else false if it fails.
	 */
	public function saveEditEmployeeWithoutPassword()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE employe SET
				nom = ?,
				prenom = ?,
				mail = ?,
				role = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->firstname, \PDO::PARAM_STR);
		$query->bindParam(2, $this->lastname, \PDO::PARAM_STR);
		$query->bindParam(3, $this->email, \PDO::PARAM_STR);
		$query->bindParam(4, $this->role, \PDO::PARAM_INT);
		$query->bindParam(5, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves the existing specified employee with updated data with the password.
	 *
	 * @return mixed Returns the employee ID if done, else false if it fails.
	 */
	public function saveEditEmployeeWithPassword()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE employe SET
				nom = ?,
				prenom = ?,
				mail = ?,
				pass = ?,
				role = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->firstname, \PDO::PARAM_STR);
		$query->bindParam(2, $this->lastname, \PDO::PARAM_STR);
		$query->bindParam(3, $this->email, \PDO::PARAM_STR);
		$query->bindParam(4, $this->password, \PDO::PARAM_STR);
		$query->bindParam(5, $this->role, \PDO::PARAM_INT);
		$query->bindParam(6, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Get the employees permissions for the associated employee role.
	 *
	 * @return mixed Returns all allowed permissions for the specified employee.
	 */
	public function getEmployeePermissions()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM role_permission
			WHERE id_role = ?
		");
		$query->bindParam(1, $this->role, \PDO::PARAM_INT);

		$query->execute();

		return $query->fetchAll();
	}

	/**
	 * Deletes the specified employee.
	 *
	 * @return void
	 */
	public function deleteEmployee()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM employe
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the employee.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the first name.
	 *
	 * @param string $firstname First name of the employee.
	 *
	 * @return void
	 */
	public function set_firstname($firstname)
	{
		$this->firstname = $firstname;
	}

	/**
	 * Defines the last name.
	 *
	 * @param string $lastname Last name of the employee.
	 *
	 * @return void
	 */
	public function set_lastname($lastname)
	{
		$this->lastname = $lastname;
	}

	/**
	 * Defines the email.
	 *
	 * @param string $email Email of the employee.
	 *
	 * @return void
	 */
	public function set_email($email)
	{
		$this->email = $email;
	}

	/**
	 * Defines the password.
	 *
	 * @param string $password Password of the employee.
	 *
	 * @return void
	 */
	public function set_password($password)
	{
		$this->password = $password;
	}

	/**
	 * Defines the role.
	 *
	 * @param integer $role Role of the employee.
	 *
	 * @return void
	 */
	public function set_role($role)
	{
		$this->role = $role;
	}

	/**
	 * Returns the ID.
	 *
	 * @return integer ID of the employee.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the first name.
	 *
	 * @return string First name of the employee.
	 */
	public function get_firstname()
	{
		return $this->firstname;
	}

	/**
	 * Returns the last name.
	 *
	 * @return string Last name of the employee.
	 */
	public function get_lastname()
	{
		return $this->lastname;
	}

	/**
	 * Returns the email.
	 *
	 * @return string Email of the employee.
	 */
	public function get_email()
	{
		return $this->email;
	}

	/**
	 * Returns the password.
	 *
	 * @return string Password of the employee.
	 */
	public function get_password()
	{
		return $this->password;
	}

	/**
	 * Returns the role.
	 *
	 * @return integer Role of the employee.
	 */
	public function get_role()
	{
		return $this->role;
	}
}