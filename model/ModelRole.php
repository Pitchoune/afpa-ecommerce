<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about roles.
 */
class ModelRole extends Model
{
	/**
	 * The ID of the role.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The name of the role.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The permissions of the role.
	 *
	 * @var integer
	 */
	private $perms;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id ID of the role.
	 * @param string $name Name of the role.
	 * @param integer $perms The permissions of the role.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $perms = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->perms = $perms;
	}

	/**
	 * Returns an array of all roles.
	 *
	 * @return array Roles informations.
	 */
	public function listAllRoles()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM role
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of employees in the given role.
	 *
	 * @return integer Number of employees in role.
	 */
	public function getNumberOfEmployeesInRole()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS compteur
			FROM employe
			WHERE role = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves a new role in the 'role' table.
	 *
	 * @return mixed Returns saved role ID or false if there is an error.
	 */
	public function saveNewRole()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO role
				(nom)
			VALUES
				(?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Returns an array of informations about a specific role.
	 *
	 * @return array Informations about a specific role.
	 */
	public function listRoleInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM role
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the existing specified role with updated data.
	 *
	 * @return mixed Returns the role ID if done, else false if it fails.
	 */
	public function saveEditRole()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE role SET
				nom = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Selects all existing permissions.
	 *
	 * @return mixed Returns an array with all existing permissions or false if it fails.
	 */
	public function getAllRolePermissions()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT id, module, description
			FROM permission
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the existing permissions values from the database.
	 *
	 * @return mixed Returns the database entries if found else false.
	 */
	public function getRolePermissions()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT p.id, p.module, p.description
			FROM role AS r
			INNER JOIN role_permission AS rp ON (rp.id_role = r.id)
			INNER JOIN permission AS p ON (p.id = rp.id_perm)
			WHERE r.id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns only 1 occurence of the role permission if it exists
	 *
	 * @return mixed Returns the database entry if found else false.
	 */
	public function getRolePermission()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT id_perm
			FROM role_permission
			WHERE id_role = ?
				AND id_perm = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);
		$query->bindParam(2, $this->perms, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Inserts the role permissions.
	 *
	 * @return mixed Returns the role ID if done, else false if it fails.
	 */
	public function insertRolePerm()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO role_permission VALUES
				(?, ?)
		");
		$query->bindParam(1, $this->perms, \PDO::PARAM_INT);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes all role permissions.
	 *
	 * @return mixed Returns the role ID if done, else false if it fails.
	 */
	public function deleteAllRolePerms()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM role_permission
			WHERE id_role = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the specified role.
	 *
	 * @return void
	 */
	public function deleteRole()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM role
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Returns the number of roles in the database.
	 *
	 * @return integer Number of roles.
	 */
	public function getTotalNumberOfRoles()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS nbroles
			FROM role
		");

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the roles following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeRoles($limitlower, $perpage)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM role
			LIMIT ?, ?
		");
		$query->bindParam(1, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(2, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Defines the ID of the role.
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
	 * Defines the role name.
	 *
	 * @param string $name Name of the role.
	 *
	 * @return void
	 */
	public function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * Defines the permissions.
	 *
	 * @param integer $perms Permissions of the role.
	 *
	 * @return void
	 */
	public function set_perms($perms)
	{
		$this->perms = $perms;
	}

	/**
	 * Returns the ID of the role.
	 *
	 * @return integer ID of the employee.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the name of the role.
	 *
	 * @return string Name of the role.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Returns the permissions.
	 *
	 * @return integer Permissions of the role.
	 */
	public function get_perms()
	{
		return $this->perms;
	}
}

?>
