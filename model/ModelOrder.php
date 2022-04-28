<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about orders
 *
 * @date $Date$
 */
class ModelOrder extends Model
{
	/**
	 * The ID of the order.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The date of the order.
	 *
	 * @var string
	 */
	private $date;

	/**
	 * The status of the order.
	 *
	 * @var string
	 */
	private $status;

	/**
	 * The mode of the order.
	 *
	 * @var string
	 */
	private $mode;

	/**
	 * The customer ID of the order.
	 *
	 * @var string
	 */
	private $id_customer;

	/**
	 * The deliver ID of the order.
	 *
	 * @var string
	 */
	private $id_deliver;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the order.
	 * @param string $date The date of the order.
	 * @param string $status The status of the order.
	 * @param string $mode The mode of the order.
	 * @param integer $id_customer The customer ID of the order.
	 * @param integer $id_deliver The deliver ID of the order.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $date = null, $status = null, $mode = null, $id_customer = null, $id_deliver = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->date = $date;
		$this->status = $status;
		$this->mode = $mode;
		$this->id_customer = $id_customer;
		$this->id_deliver = $id_deliver;
	}

	/**
	 * Gets the number of orders for a customer.
	 *
	 * @return mixed Returns the number of orders for the specified customer.
	 */
	public function getNumberOfOrdersForCustomer()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS nborders
			FROM commande
			WHERE id_client = ?
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the new order in the 'commande' table.
	 *
	 * @return mixed Returns the saved order ID or false if there is an error.
	 */
	public function saveNewOrder()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO commande
				(date, etat, mode, id_client, id_transporteur)
			VALUES
				(?, ?, ?, ?, ?)
		");
		$query->bindParam(1, $this->date, \PDO::PARAM_STR);
		$query->bindParam(2, $this->status, \PDO::PARAM_STR);
		$query->bindParam(3, $this->mode, \PDO::PARAM_STR);
		$query->bindParam(4, $this->id_customer, \PDO::PARAM_INT);
		$query->bindParam(5, $this->id_deliver, \PDO::PARAM_INT);

		$query->execute();
		return $db->lastInsertId();
	}

	/**
	 * Gets the orders for the given customer.
	 *
	 * @return Returns the data for the customer orders.
	 */
	public function getCustomerOrders()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM commande
			WHERE id_client = ?
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Gets the orders for the given customer.
	 *
	 * @return Returns the data for the customer orders.
	 */
	public function getFiveLastCustomerOrders()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM commande
			WHERE id_client = ?
			ORDER BY id DESC
			LIMIT 0, 5
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Gets some of the order details from specific order.
	 *
	 * @return Returns the data for the specific customer order.
	 */
	public function getOrderDetails()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT c.*, COUNT(d.id_commande) AS nbproduits, SUM(d.prix) AS prix, SUM(d.quantite) AS totalquantite, t.nom AS delivername
			FROM commande AS c
				INNER JOIN details_commande AS d ON (d.id_commande = c.id)
				INNER JOIN transporteur AS t ON (t.id = c.id_transporteur)
			WHERE c.id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Updates the status for an order.
	 *
	 * @return mixed Returns saved order ID or false if there is an error.
	 */
	public function updateStatus()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE commande SET
				etat = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->status, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Returns the ID of the customer from the ID of the order.
	 *
	 * @return mixed Returns saved order ID or false if there is an error.
	 */
	public function getCustomerId()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT id_client
			FROM commande
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Gets the latest orders.
	 *
	 * @return Returns the data for the latest orders.
	 */
	public function getLatestOrders()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM commande
			ORDER BY id DESC
			LIMIT 0, 5
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of orders in the given customer.
	 *
	 * @return integer Number of orders in customer.
	 */
	public function getNumberOfOrdersPerCustomer()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS nborders
			FROM commande
			WHERE id_client = ?
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns some of the orders following the defined limit.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Returns the requested data or false if there is an error.
	 */
	public function getAllCustomerOrders($limitlower, $perpage)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM commande
			WHERE id_client = ?
			LIMIT ?, ?
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);
		$query->bindParam(2, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(3, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the order.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the date.
	 *
	 * @param string $date Date of the order.
	 *
	 * @return void
	 */
	public function set_date($date)
	{
		$this->date = $date;
	}

	/**
	 * Defines the status of the order.
	 *
	 * @param string $status Status of the order.
	 *
	 * @return void
	 */
	public function set_status($status)
	{
		$this->status = $status;
	}

	/**
	 * Defines the mode of the order.
	 *
	 * @param string Mode of the order.
	 *
	 * @return void
	 */
	public function set_mode($mode)
	{
		$this->mode = $mode;
	}

	/**
	 * Returns the customer ID of the order.
	 *
	 * @param integer $id_customer Customer ID of the order.
	 *
	 * @return void
	 */
	public function set_customer($id_customer)
	{
		$this->id_customer = $id_customer;
	}

	/**
	 * Defines the deliver ID of the order.
	 *
	 * @param integer $id_deliver Deliver ID of the order.
	 *
	 * @return void
	 */
	public function set_deliver($id_deliver)
	{
		$this->id_deliver = $id_deliver;
	}

	/**
	 * Returns the ID of the order.
	 *
	 * @return integer ID of the order.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the date of the order.
	 *
	 * @return string Date of the order.
	 */
	public function get_date()
	{
		return $this->date;
	}

	/**
	 * Returns the status of the order.
	 *
	 * @return string Status of the order.
	 */
	public function get_status()
	{
		return $this->status;
	}

	/**
	 * Returns the mode of the order.
	 *
	 * @return string Mode of the order.
	 */
	public function get_mode()
	{
		return $this->mode;
	}

	/**
	 * Returns the customer ID of the order.
	 *
	 * @return integer Customer ID of the order.
	 */
	public function get_customer()
	{
		return $this->id_customer;
	}

	/**
	 * Returns the deliver ID of the order.
	 *
	 * @return integer deliver ID of the order.
	 */
	public function get_deliver()
	{
		return $this->id_deliver;
	}
}