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
	 *
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