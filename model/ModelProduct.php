<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about products
 *
 * @date	$Date$
 */
class ModelProduct extends Model
{
	/**
	 * The ID of the product.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The name of the product.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The reference of the product.
	 *
	 * @var string
	 */
	private $ref;

	/**
	 * The description of the product.
	 *
	 * @var string
	 */
	private $description;

	/**
	 * The quantity of the product.
	 *
	 * @var integer
	 */
	private $quantity;

	/**
	 * The price of the product.
	 *
	 * @var string
	 */
	private $price;

	/**
	 * The photo of the product.
	 *
	 * @var string
	 */
	private $photo;

	/**
	 * The ID of the category.
	 *
	 * @var string
	 */
	private $id_category;

	/**
	 * The ID of the trademark.
	 *
	 * @var string
	 */
	private $id_trademark;

	/**
	 * Constructor
	 *
	 * @param array $config Database informations
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $name = null, $ref = null, $description = null, $quantity = null, $price = null, $photo = null, $id_category = null, $id_trademark = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->name = $name;
		$this->ref = $ref;
		$this->description = $description;
		$this->quantity = $quantity;
		$this->price = $price;
		$this->photo = $photo;
		$this->id_category = $id_category;
		$this->id_trademark = $id_trademark;
	}

	/**
	 * Returns an array of all products.
	 *
	 * @return array Products informations
	 */
	public function listAllProducts()
	{
		$db = $this->dbConnect();
		$query = $db->query("
			SELECT *
			FROM produit
		");

		$query->execute();

		return $query->fetchAll();
	}

	/**
	 * Saves a new product in the 'produit' table.
	 *
	 * @return mixed Returns saved product ID or false if there is an error.
	 */
	public function saveNewProductWithoutPictures()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO produit
				(nom, ref, description, quantite, prix, id_categorie, id_marque)
			VALUES
				(?, ?, ?, ?, ?, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->ref, \PDO::PARAM_STR);
		$query->bindParam(3, $this->description, \PDO::PARAM_STR);
		$query->bindParam(4, $this->quantity, \PDO::PARAM_INT);
		$query->bindParam(5, $this->price, \PDO::PARAM_STR);
		$query->bindParam(6, $this->id_category, \PDO::PARAM_INT);
		$query->bindParam(7, $this->id_trademark, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves a new product in the 'produit' table.
	 *
	 * @return mixed Returns saved product ID or false if there is an error.
	 */
	public function saveNewProductWithPictures()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO produit
				(nom, ref, description, quantite, prix, photo, id_categorie, id_marque)
			VALUES
				(?, ?, ?, ?, ?, ?, ?, ?)
		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->ref, \PDO::PARAM_STR);
		$query->bindParam(3, $this->description, \PDO::PARAM_STR);
		$query->bindParam(4, $this->quantity, \PDO::PARAM_INT);
		$query->bindParam(5, $this->price, \PDO::PARAM_STR);
		$query->bindParam(6, $this->photo, \PDO::PARAM_STR);
		$query->bindParam(7, $this->id_category, \PDO::PARAM_INT);
		$query->bindParam(8, $this->id_trademark, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Returns an array of informations about a specific product following its ID.
	 *
	 * @return array Informations about a specific product.
	 */
	public function listProductInfosFromId()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT p.*, c.nom AS category
			FROM produit AS p
				INNER JOIN categorie AS c ON (c.id = p.id_categorie)
			WHERE p.id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns an array of informations about a specific product following its reference.
	 *
	 * @return array Informations about a specific product.
	 */
	public function listProductInfosFromRef()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM produit
			WHERE ref = ?
		");
		$query->bindParam(1, $this->ref, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns an array of informations about a specific product following its reference.
	 *
	 * @return array Informations about a specific product.
	 */
	public function listProductInfosFromCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM produit
			WHERE id_categorie = ?
		");
		$query->bindParam(1, $this->id_category, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Saves the existing specified product with updated data.
	 *
	 * @return mixed Returns the product ID if done, else false if it fails.
	 */
	public function saveEditProductWithPictures()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE produit SET
				nom = ?,
				ref = ?,
				description = ?,
				quantite = ?,
				prix = ?,
				photo = ?,
				id_categorie = ?,
				id_marque = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->ref, \PDO::PARAM_STR);
		$query->bindParam(3, $this->description, \PDO::PARAM_STR);
		$query->bindParam(4, $this->quantity, \PDO::PARAM_INT);
		$query->bindParam(5, $this->price, \PDO::PARAM_STR);
		$query->bindParam(6, $this->photo, \PDO::PARAM_STR);
		$query->bindParam(7, $this->id_category, \PDO::PARAM_INT);
		$query->bindParam(8, $this->id_trademark, \PDO::PARAM_INT);
		$query->bindParam(9, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves the existing specified product with updated data.
	 *
	 * @return mixed Returns the product ID if done, else false if it fails.
	 */
	public function saveEditProductWithoutPictures()
	{
		$this->counter = 0;

		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE produit SET
				nom = ?,
				ref = ?,
				description = ?,
				quantite = ?,
				prix = ?,
				id_categorie = ?,
				id_marque = ?
			WHERE id = ?

		");
		$query->bindParam(1, $this->name, \PDO::PARAM_STR);
		$query->bindParam(2, $this->ref, \PDO::PARAM_STR);
		$query->bindParam(3, $this->description, \PDO::PARAM_STR);
		$query->bindParam(4, $this->quantity, \PDO::PARAM_INT);
		$query->bindParam(5, $this->price, \PDO::PARAM_STR);
		$query->bindParam(6, $this->id_category, \PDO::PARAM_INT);
		$query->bindParam(7, $this->id_trademark, \PDO::PARAM_INT);
		$query->bindParam(8, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the specified product.
	 *
	 * @return void
	 */
	public function deleteProduct()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			DELETE FROM produit
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Search in the products per customer request for specified category.
	 *
	 * @return mixed Returns the products if found, else false if it fails.
	 */
	public function searchProductsWithCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM produit
			WHERE
				(nom LIKE :q1
				OR ref LIKE :q2
				OR description LIKE :q3)
				AND id_categorie = :c1
		");

		$query->execute([':q1' => '%' . $this->name . '%', ':q2' => '%' . $this->ref . '%', ':q3' => '%' . $this->description. '%', ':c1' => $this->id_category]);
		return $query->fetchAll();
	}

	/**
	 * Search in the products per customer request for all categories.
	 *
	 * @return mixed Returns the products if found, else false if it fails.
	 */
	public function searchProductsWithoutCategory()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM produit
			WHERE
				nom LIKE :q1
				OR ref LIKE :q2
				OR description LIKE :q3
		");

		$query->execute([':q1' => '%' . $this->name . '%', ':q2' => '%' . $this->ref . '%', ':q3' => '%' . $this->description. '%']);
		return $query->fetchAll();
	}

	/**
	 * Returns the number of products in the database.
	 *
	 * @return mixed Integer if valid, false elsewhere.
	 */
	public function getTotalNumberOfProducts()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT COUNT(*) AS nbproducts
			FROM produit
		");

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the products following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeProducts($limitlower, $perpage)
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT *
			FROM produit
			LIMIT ?, ?
		");
		$query->bindParam(1, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(2, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of products in the database.
	 *
	 * @return mixed Integer if valid, false elsewhere.
	 */
	public function getTotalNumberOfProductsForSpecificCategory()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT COUNT(*) AS nbproducts
			FROM produit
			WHERE id_categorie = ?
		");
		$query->bindParam(1, $this->id_category, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the products following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Array of data if found or false if there is nothing found.
	 */
	public function getSomeProductsForSpecificCategory($limitlower, $perpage)
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			SELECT *
			FROM produit
			WHERE id_categorie = ?
			LIMIT ?, ?
		");
		$query->bindParam(1, $this->id_category, \PDO::PARAM_INT);
		$query->bindParam(2, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(3, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the product.
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
	 * @param string $name Name of the product.
	 *
	 * @return void
	 */
	public function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * Defines the reference of the product.
	 *
	 * @param string $ref Reference of the product.
	 *
	 * @return void
	 */
	public function set_ref($ref)
	{
		$this->ref = $ref;
	}

	/**
	 * Defines the description of the product.
	 *
	 * @param string $description Description of the product.
	 *
	 * @return void
	 */
	public function set_description($description)
	{
		$this->description = $description;
	}

	/**
	 * Returns the quantity of the product.
	 *
	 * @param integer $quantity Quantity of the product.
	 *
	 * @return void
	 */
	public function set_quantity($quantity)
	{
		$this->quantity = $quantity;
	}

	/**
	 * Defines the price of the product.
	 *
	 * @param string $price Price of the product.
	 *
	 * @return void
	 */
	public function set_price($price)
	{
		$this->price = $price;
	}

	/**
	 * Defines the photo of the product.
	 *
	 * @param string $photo Photo of the product.
	 *
	 * @return void
	 */
	public function set_photo($photo)
	{
		$this->photo = $photo;
	}

	/**
	 * Defines the category of the product.
	 *
	 * @param string $id_category Category of the product.
	 *
	 * @return void
	 */
	public function set_category($id_category)
	{
		$this->id_category = $id_category;
	}

	/**
	 * Defines the trademark of the product.
	 *
	 * @param string $id_trademark Trademark of the product.
	 *
	 * @return void
	 */
	public function set_trademark($id_trademark)
	{
		$this->id_trademark = $id_trademark;
	}

	/**
	 * Returns the ID of the product.
	 *
	 * @return integer ID of the product.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the name of the product.
	 *
	 * @return string Name of the product.
	 */
	public function get_name()
	{
		return $this->name;
	}

	/**
	 * Returns the reference of the product.
	 *
	 * @return string Reference of the product.
	 */
	public function get_ref()
	{
		return $this->ref;
	}

	/**
	 * Returns the description of the product.
	 *
	 * @return string Description of the product.
	 */
	public function get_description()
	{
		return $this->description;
	}

	/**
	 * Returns the quantity of the product.
	 *
	 * @return string Quantity of the product.
	 */
	public function get_quantity()
	{
		return $this->quantity;
	}

	/**
	 * Returns the price of the product.
	 *
	 * @return string Price of the product.
	 */
	public function get_price()
	{
		return $this->price;
	}

	/**
	 * Returns the photo of the product.
	 *
	 * @return string Photo of the product.
	 */
	public function get_photo()
	{
		return $this->photo;
	}

	/**
	 * Returns the category of the product.
	 *
	 * @return string Category of the product.
	 */
	public function get_category()
	{
		return $this->id_category;
	}

	/**
	 * Returns the trademark of the product.
	 *
	 * @return string Trademark of the product.
	 */
	public function get_trademark()
	{
		return $this->id_trademark;
	}
}