<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about trademarks.
 *
 * @date $Date$
 */
class ModelTrademark extends Model
{
	/**
	 * The ID of the trademark.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The name of the trademark.
	 *
	 * @var integer
	 */
	private $name;

	/**
	 * The logo of the trademark.
	 *
	 * @var string
	 */
	private $logo;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param string $id The ID of the trademark.
	 * @param string $name The name of the trademark.
	 * @param string $logo The logo of the trademark.
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
	 * Returns an array of all trademarks.
	 *
	 * @return array Trademarks informations.
	 */
	public function listAllTrademarks()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM marque
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of products in the given trademark.
	 *
	 * @return integer Number of products in trademark.
	 */
	public function getNumberOfProductsInTrademark()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS compteur
			FROM produit
			WHERE id_marque = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves a new trademark in the 'marque' table.
	 *
	 * @return mixed Returns saved trademark ID or false if there is an error.
	 */
	public function saveNewTrademarkWithoutLogo()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO marque
				(id, nom, logo)
			VALUES
				(NULL, ?, '')
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Saves a new trademark in the 'marque' table.
	 *
	 * @return mixed Returns saved trademark ID or false if there is an error.
	 */
	public function saveNewTrademarkWithLogo()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO marque
				(id, nom, logo)
			VALUES
				(NULL, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->logo, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Returns an array of informations about a specific trademark.
	 *
	 * @return array Informations about a specific trademark.
	 */
	public function listTrademarkInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM marque
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the existing specified trademark with updated data.
	 *
	 * @return mixed Returns the trademark ID if done, else false if it fails.
	 */
	public function saveEditTrademarkWithLogo()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE marque SET
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
	 * Saves the existing specified trademark with updated data.
	 *
	 * @return mixed Returns the trademark ID if done, else false if it fails.
	 */
	public function saveEditTrademarkWithoutLogo()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE marque SET
				nom = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the specified trademark.
	 *
	 * @return void
	 */
	public function deleteTrademark()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM marque
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the trademark.
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
	 * @param string $name Name of the trademark.
	 *
	 * @return void
	 */
	public function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * Defines the logo of the trademark.
	 *
	 * @param string $logo Logo of the trademark.
	 *
	 * @return void
	 */
	public function set_logo($logo)
	{
		$this->logo = $logo;
	}

	/**
	 * Returns the ID of the trademark.
	 *
	 * @return integer ID of the trademark.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the name of the trademark.
	 *
	 * @return string Name of the trademark.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Returns the logo of the trademark.
	 *
	 * @return string Logo of the trademark.
	 */
	public function get_logo()
	{
		return $this->logo;
	}
}