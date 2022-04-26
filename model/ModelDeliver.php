<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about delivers.
 *
 * @date $Date$
 */
class ModelDeliver extends Model
{
	/**
	 * The ID of the deliver.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The name of the deliver.
	 *
	 * @var integer
	 */
	private $name;

	/**
	 * The logo of the deliver.
	 *
	 * @var string
	 */
	private $logo;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param string $id The ID of the deliver.
	 * @param string $name The name of the deliver.
	 * @param string $logo The logo of the deliver.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $logo = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->logo = $logo;
	}

	/**
	 * Returns an array of all delivers.
	 *
	 * @return array Delivers informations.
	 */
	public function listAllDelivers()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM transporteur
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of orders in the given deliver.
	 *
	 * @return integer Number of orders in deliver.
	 */
	public function getNumberOfOrdersInDeliver()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS compteur
			FROM commande
			WHERE id_transporteur = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves a new deliver in the 'transporteur table.
	 *
	 * @return mixed Returns saved deliver ID or false if there is an error.
	 */
	public function saveNewDeliverWithoutLogo()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO transporteur
				(id, nom, logo)
			VALUES
				(NULL, ?, '')
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Saves a new deliver in the 'transporteur' table.
	 *
	 * @return mixed Returns saved deliver ID or false if there is an error.
	 */
	public function saveNewDeliverWithLogo()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO transporteur
				(id, nom, logo)
			VALUES
				(NULL, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->logo, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Returns an array of informations about a specific deliver.
	 *
	 * @return array Informations about a specific deliver.
	 */
	public function listDeliverInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM transporteur
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the existing specified deliver with updated data.
	 *
	 * @return mixed Returns the deliver ID if done, else false if it fails.
	 */
	public function saveEditDeliverWithLogo()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE transporteur SET
				nom = ?,
				logo = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->logo, \PDO::PARAM_STR);
		$query->bindParam(3, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves the existing specified deliver with updated data.
	 *
	 * @return mixed Returns the deliver ID if done, else false if it fails.
	 */
	public function saveEditDeliverWithoutLogo()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE transporteur SET
				nom = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the specified deliver.
	 *
	 * @return void
	 */
	public function deleteDeliver()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM transporteur
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Returns the number of delivers in the database.
	 *
	 * @return mixed Integer if valid, false elsewhere.
	 */
	public function getTotalNumberOfDelivers()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT COUNT(*) AS nbdelivers
			FROM transporteur
		");

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the delivers following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeDelivers($limitlower, $perpage)
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT *
			FROM transporteur
			LIMIT ?, ?
		");
		$query->bindParam(1, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(2, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the deliver.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the name.
	 *
	 * @param string $name Name of the deliver.
	 *
	 * @return void
	 */
	public function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * Defines the logo of the deliver.
	 *
	 * @param string $logo Logo of the deliver.
	 *
	 * @return void
	 */
	public function set_logo($logo)
	{
		$this->logo = $logo;
	}

	/**
	 * Returns the ID of the deliver.
	 *
	 * @return integer ID of the deliver.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the name of the deliver.
	 *
	 * @return string Name of the deliver.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Returns the logo of the deliver.
	 *
	 * @return string Logo of the deliver.
	 */
	public function get_logo()
	{
		return $this->logo;
	}
}