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
	 * The ID of the order details.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The order ID of the order details.
	 *
	 * @var integer
	 */
	private $id_order;

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
	 * @param integer $id The ID of the order details.
	 * @param integer $id_order The order ID of the order details.
	 * @param string $price The price of the order details.
	 * @param integer $quantity The quantity of the order details.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $id_order = null, $price = null, $quantity = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->id_order = $id_order;
		$this->price = $price;
		$this->quantity = $quantity;
	}



	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the order details.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the order ID.
	 *
	 * @param integer $id_order Date of the order.
	 *
	 * @return void
	 */
	public function set_order($id_order)
	{
		$this->id_order = $id_order;
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
	 * Returns the ID of the order details.
	 *
	 * @return integer ID of the order details.
	 */
	public function get_id()
	{
		return $this->id;
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