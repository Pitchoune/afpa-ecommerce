<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about order details.
 *
 * @date $Date$
 */
class ModelOrderDetails extends Model
{
	/**
	 * The order ID of the order details.
	 *
	 * @var integer
	 */
	private $id_order;

	/**
	 * The product ID of the order details.
	 *
	 * @var integer
	 */
	private $id_product;

	/**
	 * The price of the order details.
	 *
	 * @var string
	 */
	private $price;

	/**
	 * The quantity of the order details.
	 *
	 * @var integer
	 */
	private $quantity;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	  * @param integer $id_order The order ID of the order details.
	 * @param integer $id_product The product ID of the order details.
	 * @param string $price The price of the order details.
	 * @param integer $quantity The quantity of the order details.
	 *
	 * @return void
	 */
	public function __construct($config, $id_order = null, $id_product = null, $price = null, $quantity = null)
	{
		$this->config = $config;
		$this->id_order = $id_order;
		$this->id_product = $id_product;
		$this->price = $price;
		$this->quantity = $quantity;
	}

	/**
	 * Saves a new order detail in the 'details_commande' table.
	 *
	 * @return mixed Returns false if there is an error.
	 */
	public function saveOrderDetails()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO details_commande
				(id_commande, id_produit, prix, quantite)
			VAlUES
				(?, ?, ?, ?)
		");
		$query->bindParam(1, $this->id_order, \PDO::PARAM_INT);
		$query->bindParam(2, $this->id_product, \PDO::PARAM_INT);
		$query->bindParam(3, $this->price, \PDO::PARAM_STR);
		$query->bindParam(4, $this->quantity, \PDO::PARAM_INT);

		return $query->execute();
	}

	public function getOrderDetails()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT d.id_produit, d.prix, d.quantite, p.nom, p.photo, p.id_marque
			FROM details_commande AS d
				INNER JOIN produit AS p ON (p.id = d.id_produit)
			WHERE d.id_commande = ?
		");
		$query->bindParam(1, $this->id_order, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Defines the order ID.
	 *
	 * @param integer $id_order Order ID of the order details.
	 *
	 * @return void
	 */
	public function set_order($id_order)
	{
		$this->id_order = $id_order;
	}

	/**
	 * Defines the product ID.
	 *
	 * @param integer $id Product ID of the order details.
	 *
	 * @return void
	 */
	public function set_product($id_product)
	{
		$this->id_product = $id_product;
	}

	/**
	 * Defines the price of the order element.
	 *
	 * @param string $price Price of the order element.
	 *
	 * @return void
	 */
	public function set_price($price)
	{
		$this->price = $price;
	}

	/**
	 * Defines the quantity of the order element.
	 *
	 * @param integer Quantity of the order element.
	 *
	 * @return void
	 */
	public function set_quantity($quantity)
	{
		$this->quantity = $quantity;
	}

	/**
	 * Returns the order ID of the order.
	 *
	 * @return integer Order ID of the order.
	 */
	public function get_order()
	{
		return $this->id_order;
	}

	/**
	 * Returns the product ID of the order details.
	 *
	 * @return integer Product ID of the order details.
	 */
	public function get_product()
	{
		return $this->id_product;
	}

	/**
	 * Returns the price of the order element.
	 *
	 * @return string Price of the order element.
	 */
	public function get_price()
	{
		return $this->price;
	}

	/**
	 * Returns the quantity of the order element.
	 *
	 * @return integer Quantity of the order element.
	 */
	public function get_quantity()
	{
		return $this->quantity;
	}
}