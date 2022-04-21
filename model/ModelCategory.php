<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about categories
 *
 * @date $Date$
 */
class ModelCategory extends Model
{
	/**
	 * The ID of the category.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The name of the category.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the category.
	 * @param string $name The name of the category.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * Returns an array of all categories.
	 *
	 * @return array Categories informations.
	 */
	public function listAllCategories()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of products in the given category.
	 *
	 * @return integer Number of products in category.
	 */
	public function getNumberOfProductsInCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS compteur
			FROM produit
			WHERE id_categorie = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves a new category in the 'categorie' table.
	 *
	 * @return mixed Returns saved category ID or false if there is an error.
	 */
	public function saveNewCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO categorie
				(nom)
			VALUES
				(?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Returns the informations of the category.
	 *
	 * @return array Informations of the category.
	 */
	public function listCategoryInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the existing specified category with updated data.
	 *
	 * @return void
	 */
	public function saveEditCategory()
	{

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE categorie SET
				nom = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the specified category.
	 *
	 * @return void
	 */
	public function deleteCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM categorie
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);
		return $query->execute();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the category.
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
	 * @param string $name Name of the category.
	 *
	 * @return void
	 */
	public function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * Returns the ID of the category.
	 *
	 * @return integer ID of the category.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the name of the category.
	 *
	 * @return string Name of the category.
	 */
	public function get_name()
	{
		return $this->name;
	}
}