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
	 * The status of the category.
	 *
	 * @var string
	 */
	private $status;

	/**
	 * The parent ID of the category.
	 *
	 * @var string
	 */
	private $parentid;

	/**
	 * The parent list of the category.
	 *
	 * @var string
	 */
	private $parentlist;

	/**
	 * The child list of the category.
	 *
	 * @var string
	 */
	private $childlist;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the category.
	 * @param string $name The name of the category.
	 * @param string $status The status of the category.
	 * @param string $parentid The parent ID of the category.
	 * @param string $parentlist The parent list of the category.
	 * @param string $childlist The child list of the category.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $status = null, $parentid = null, $parentlist = null, $childlist = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->status = $status;
		$this->parentid = $parentid;
		$this->parentlist = $parentlist;
		$this->childlist = $childlist;
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
	 *
	 */
	public function listCategoriesWithParent()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE parentid = ?
		");
		$query->bindParam(1, $this->parentid, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Saves a new category in the 'categorie' table.
	 *
	 * @return mixed Returns saved category ID or false if there is an error.
	 */
	public function saveNewCategory()
	{
		if ($this->parentid == '0')
		{
			$this->parentid = '-1';
		}

		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO categorie
				(nom, etat, parentid)
			VALUES
				(?, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->status, \PDO::PARAM_STR); // ENUM in SQL requires to have quoted content
		$query->bindParam(3, $this->parentid, \PDO::PARAM_STR); // Can be -1 if category is at root level

		return $query->execute();
	}

	/**
	 *
	 */
	public function updateCategoriesGenealogy()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE categorie SET
				parentlist = ?,
				childlist = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->parentlist);
		$query->bindParam(2, $this->childlist);
		$query->bindParam(3, $this->categoryid);

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
				nom = ?,
				etat = ?,
				parentid = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->status, \PDO::PARAM_STR); // ENUM in SQL requires to have quoted content
		$query->bindParam(3, $this->parentid, \PDO::PARAM_STR); // Can be -1 if category is at root level
		$query->bindParam(4, $this->id, \PDO::PARAM_INT);

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
	 * Defines the status of the category.
	 *
	 * @param string $status Status of the category (visible or not).
	 *
	 * @return void
	 */
	public function set_status($status)
	{
		$this->status = $status;
	}

	/**
	 * Defines the parent ID of the category.
	 *
	 * @param string Parent ID of the category.
	 *
	 * @return void
	 */
	public function set_parentid($parentid)
	{
		$this->parentid = $parentid;
	}

	/**
	 * Returns the parent list of the category.
	 *
	 * @param string $parentlist Parent list of the category.
	 *
	 * @return void
	 */
	public function set_parentlist($parentlist)
	{
		$this->parentlist = $parentlist;
	}

	/**
	 * Defines the child list of the category.
	 *
	 * @param string $childlist Child list of the category.
	 *
	 * @return void
	 */
	public function set_childlist($childlist)
	{
		$this->childlist = $childlist;
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
	 * Returns the status of the category (1 : visible, 0 : not visible)
	 *
	 * @return string Status of the category.
	 */
	public function get_status()
	{
		return $this->status;
	}

	/**
	 * Returns the parent ID of the category.
	 *
	 * @return string Parent ID of the category. Can be -1 if no parent.
	 */
	public function get_parentid()
	{
		return $this->parentid;
	}

	/**
	 * Returns the parent list of the category.
	 *
	 * @return string Parent list of the category.
	 */
	public function get_parentlist()
	{
		return $this->parentlist;
	}

	/**
	 * Returns the child list of the category.
	 *
	 * @return string Child list of the category.
	 */
	public function get_childlist()
	{
		return $this->childlist;
	}
}