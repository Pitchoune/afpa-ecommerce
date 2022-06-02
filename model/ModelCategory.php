<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about categories
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
	 * The display order of the category.
	 *
	 * @var integer
	 */
	private $displayorder;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the category.
	 * @param string $name The name of the category.
	 * @param integer $parent_id Parent ID of the category.
	 * @param string $parentlist The parent list of the category.
	 * @param string $childlist The child list of the category.
	 * @param integer $displayorder The display order of the category.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $parent_id = null, $parentlist = null, $childlist = null, $displayorder = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->parent_id = $parent_id;
		$this->parentlist = $parentlist;
		$this->childlist = $childlist;
		$this->displayorder = $displayorder;
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
			WHERE parent_id = '-1'
			ORDER BY displayorder ASC
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
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO categorie
				(nom, parent_id, displayorder)
			VALUES
				(?, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->parent_id, \PDO::PARAM_INT);
		$query->bindParam(3, $this->displayorder, \PDO::PARAM_INT);

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
		$query->bindParam(3, $this->id, \PDO::PARAM_INT);

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
			SELECT id, nom
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
	public function listChildrenCategoryInfos($value)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM categorie
			WHERE id IN ($value)
			ORDER BY displayorder ASC
		");

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
				nom = ?,
				parent_id = ?,
				displayorder = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->parent_id, \PDO::PARAM_INT);
		$query->bindParam(3, $this->displayorder, \PDO::PARAM_INT);
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
	 *
	 */
	public function UpdateCategoryDisplayOrder()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			UPDATE categorie SET
				displayorder = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->displayorder, \PDO::PARAM_INT);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

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
	 * Defines the display order of the category.
	 *
	 * @param integer $displayorder Display order of the category.
	 *
	 * @return void
	 */
	public function set_displayorder($displayorder)
	{
		$this->displayorder = $displayorder;
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

	/**
	 * Returns the display order of the category.
	 *
	 * @return integer Display order of the category.
	 */
	public function get_displayorder()
	{
		return $this->displayorder;
	}
}

?>