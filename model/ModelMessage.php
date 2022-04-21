<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about orders
 *
 * @date $Date$
 */
class ModelMessage extends Model
{
	/**
	 * The ID of the message.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The type of the message.
	 *
	 * @var string
	 */
	private $type;

	/**
	 * The date of the message.
	 *
	 * @var integer
	 */
	private $date;

	/**
	 * The message of the message.
	 *
	 * @var string
	 */
	private $message;

	/**
	 * The previous message ID of the message.
	 *
	 * @var string
	 */
	private $previous_id;

	/**
	 * The customer ID of the message.
	 *
	 * @var string
	 */
	private $id_customer;

	/**
	 * The employee ID of the message.
	 *
	 * @var string
	 */
	private $id_employee;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id The ID of the message.
	 * @param string $type The type of the message.
	 * @param string $date The date of the message.
	 * @param string $message The message content of the message.
	 * @param integer $previous_id The previous ID of the message.
	 * @param integer $id_customer The customer ID of the message.
	 * @param integer $id_employee The employee ID of the message.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $type = null, $date = null, $message = null, $previous_id = null, $id_customer = null, $id_employee = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->type = $type;
		$this->date = $date;
		$this->message = $message;
		$this->previous_id = $previous_id;
		$this->id_customer = $id_customer;
		$this->id_employee = $id_employee;
	}



	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the message.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the type.
	 *
	 * @param string $type Type of the message.
	 *
	 * @return void
	 */
	public function set_type($type)
	{
		$this->type = $type;
	}

	/**
	 * Defines the date.
	 *
	 * @param integer $date Date of the message.
	 *
	 * @return void
	 */
	public function set_date($date)
	{
		$this->date = $date;
	}

	/**
	 * Defines the status of the message.
	 *
	 * @param string $status Status of the message.
	 *
	 * @return void
	 */
	public function set_message($message)
	{
		$this->message = $message;
	}

	/**
	 * Defines the previous ID of the message.
	 *
	 * @param integer Previous ID of the message.
	 *
	 * @return void
	 */
	public function set_previous($previous_id)
	{
		$this->previous_id = $previous_id;
	}

	/**
	 * Returns the customer ID of the message.
	 *
	 * @param integer $id_customer Customer ID of the message.
	 *
	 * @return void
	 */
	public function set_customer($id_customer)
	{
		$this->id_customer = $id_customer;
	}

	/**
	 * Defines the employee ID of the message.
	 *
	 * @param integer $id_deliver Employee ID of the message.
	 *
	 * @return void
	 */
	public function set_employee($id_employee)
	{
		$this->id_employee = $id_employee;
	}

	/**
	 * Returns the ID of the message.
	 *
	 * @return integer ID of the message.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the type of the message.
	 *
	 * @return string Type of the message.
	 */
	public function get_type()
	{
		return $this->type;
	}

	/**
	 * Returns the date of the message.
	 *
	 * @return string Date of the message.
	 */
	public function get_date()
	{
		return $this->date;
	}

	/**
	 * Returns the message of the message.
	 *
	 * @return string Message of the message.
	 */
	public function get_message()
	{
		return $this->message;
	}

	/**
	 * Returns the previous ID of the message.
	 *
	 * @return integer Previous ID of the message.
	 */
	public function get_previous()
	{
		return $this->previous_id;
	}

	/**
	 * Returns the customer ID of the message.
	 *
	 * @return integer Customer ID of the message.
	 */
	public function get_customer()
	{
		return $this->id_customer;
	}

	/**
	 * Returns the employee ID of the message.
	 *
	 * @return integer Employee ID of the message.
	 */
	public function get_employee()
	{
		return $this->id_employee;
	}
}