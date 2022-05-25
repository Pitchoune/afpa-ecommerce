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
	 * The parent ID of the category.
	 *
	 * @var integer
	 */
	private $parent_id;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the category.
	 * @param string $name The name of the category.
	 * @param integer $parent_id Parent ID of the category.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $parent_id = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->parent_id = $parent_id;
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
	 * Returns an array of all categories without parents.
	 *
	 * @return array Categories informations.
	 */
	public function listAllCategoriesWithoutParents()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE parent_id IS NULL
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
	 * Returns the parent name of the current category.
	 *
	 * @return array Informations of the category.
	 */
	public function getParentName()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT nom
			FROM categorie
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the informations of the children categories.
	 *
	 * @return array Informations of the category.
	 */
	public function listChildrenCategoryInfos()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE parent_id = ?
		");
		$query->bindParam(1, $this->parent_id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
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
	 * Returns the number of categories in the database.
	 *
	 * @return mixed Integer if valid, false elsewhere.
	 */
	public function getTotalNumberOfCategories()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT COUNT(*) AS nbcats
			FROM categorie
		");

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the categories following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeCategories($limitlower, $perpage)
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT *
			FROM categorie
			LIMIT ?, ?
		");
		$query->bindParam(1, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(2, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns some of the categories following the defined limit and the given category.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeCategoriesContent($limitlower, $perpage)
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE id = ?
			LIMIT ?, ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);
		$query->bindParam(2, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(3, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the parent IDs of the current child categories.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getChildCategoriesIds()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT id
			FROM categorie
			WHERE parent_id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
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
	 * Defines the parent ID.
	 *
	 * @param string $parent_id Parent ID of the category.
	 *
	 * @return void
	 */
	public function set_parentid($parent_id)
	{
		$this->parent_id = $parent_id;
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

	/**
	 * Returns the parent ID of the category.
	 *
	 * @return string Name of the category.
	 */
	public function get_parentid()
	{
		return $this->parent_id;
	}
}