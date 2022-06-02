<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about messages.
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
	 * The title of the message
	 *
	 * @var string
	 */
	private $title;

	/**
	 * The message of the message.
	 *
	 * @var string
	 */
	private $message;

	/**
	 * The date of the message.
	 *
	 * @var string
	 */
	private $date;

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
	 * @param string $title The title of the message.
	 * @param string $message The message content of the message.
	 * @param string $date Date of the message.
	 * @param integer $previous_id The previous ID of the message.
	 * @param integer $id_customer The customer ID of the message.
	 * @param integer $id_employee The employee ID of the message.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $type = null, $title = null, $message = null, $date = null, $previous_id = null, $id_customer = null, $id_employee = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->type = $type;
		$this->title = $title;
		$this->message = $message;
		$this->date = $date;
		$this->previous_id = $previous_id;
		$this->id_customer = $id_customer;
		$this->id_employee = $id_employee;
	}

	/**
	 * Saves a mew notification in the 'message' table.
	 *
	 * @return mixed Returns saved message ID or false if there is an error.
	 */
	public function saveNewMessage()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO message
				(type, titre, message, date, precedent_id, id_client, id_employe)
			VALUES
				(?, ?, ?, ?, ?, ?, ?)
		");
		$query->bindParam(1, $this->type, \PDO::PARAM_STR);
		$query->bindParam(2, $this->title, \PDO::PARAM_STR);
		$query->bindParam(3, $this->message, \PDO::PARAM_STR);
		$query->bindParam(4, $this->date, \PDO::PARAM_STR);
		$query->bindParam(5, $this->previous_id, \PDO::PARAM_STR);
		$query->bindParam(6, $this->id_customer, \PDO::PARAM_INT);
		$query->bindParam(7, $this->id_employee, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Returns all messages from a specific type.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function getAllMessagesFromType()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM message
			WHERE type = ?
		");
		$query->bindParam(1, $this->type, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns all messages from a specific type for a specific customer.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function getSomeMessages($limitlower, $perpage)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM message
			WHERE type = ?
				AND precedent_id IS NULL
			ORDER BY date DESC
			LIMIT ?, ?
		");
		$query->bindParam(1, $this->type, \PDO::PARAM_STR);
		$query->bindParam(2, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(3, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns all messages from a specific type for a specific customer.
	 *
	 * @param integer $limitlower Minimum value for the limit.
	 * @param integer $perpage Number of items to return.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function getAllMessagesFromCustomer($limitlower, $perpage)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM message
			WHERE id_client = ?
				AND precedent_id IS NULL
			ORDER BY date DESC
			LIMIT ?, ?
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);
		$query->bindParam(2, $limitlower, \PDO::PARAM_INT);
		$query->bindParam(3, $perpage, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the requested reply from a discussion.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function getMessageFromDiscussion()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM message
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the next message ID from a discussion.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function getNextMessageIdFromDiscussion()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT m.id
			FROM message AS m
			INNER JOIN message AS n ON (m.precedent_id = n.id)
			WHERE n.id = ?
		");

		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns all the messages data from a discussion following an ID list.
	 *
	 * @param string $list List of IDs to get data
	 *
	 * @return mixed Returns the requested messages content or false if there is an error.
	 */
	public function grabAllMessagesFromDiscussion($list)
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM message
			WHERE id IN ($list)
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the number of messages from a certain type.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function countMessagesFromType()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS count
			FROM message
			WHERE type = ?
		");
		$query->bindParam(1, $this->type, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the number of messages from a certain type for a specific customer.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function countMessagesFromCustomer()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS nbmessages
			FROM message
			WHERE id_client = ?
				AND precedent_id IS NULL
		");
		$query->bindParam(1, $this->id_customer, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the number of messages from a certain discussion.
	 *
	 * @return mixed Returns the requested content or false if there is an error.
	 */
	public function countMessagesFromDiscussion()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT COUNT(*) AS nbmessages
			FROM message
			WHERE id = ?
				OR precedent_id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
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
	 * Defines the title of the message.
	 *
	 * @param string $title Title of the message.
	 *
	 * @return void
	 */
	public function set_title($title)
	{
		$this->title = $title;
	}

	/**
	 * Defines the text of the message.
	 *
	 * @param string $message Text of the message.
	 *
	 * @return void
	 */
	public function set_message($message)
	{
		$this->message = $message;
	}

	/**
	 * Defines the date of the message.
	 *
	 * @param string $date Date of the message.
	 *
	 * @return void
	 */
	public function set_date($date)
	{
		$this->date = $date;
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
	 * Returns the title of the message.
	 *
	 * @return string Title of the message.
	 */
	public function get_title()
	{
		return $this->title;
	}

	/**
	 * Returns the text of the message.
	 *
	 * @return string Text of the message.
	 */
	public function get_message()
	{
		return $this->message;
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