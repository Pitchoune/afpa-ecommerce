<?php

namespace Ecommerce\Model;

require_once(DIR . '/model/Model.php');

/**
 * Class to do data save/delete operations about customers
 *
 * @date	$Date$
 */
class ModelCustomer extends Model
{
	/**
	 * The ID of the customer.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * The first name of the customer.
	 *
	 * @var string
	 */
	private $firstname;

	/**
	 * The last name of the customer.
	 *
	 * @var string
	 */
	private $lastname;

	/**
	 * The email address of the customer.
	 *
	 * @var string
	 */
	private $email;

	/**
	 * The password of the customer.
	 *
	 * @var string
	 */
	private $password;

	/**
	 * The address of the customer.
	 *
	 * @var string
	 */
	private $address;

	/**
	 * The city of the customer.
	 *
	 * @var string
	 */
	private $city;

	/**
	 * The zip code of the customer.
	 *
	 * @var string
	 */
	private $zipcode;

	/**
	 * The telephone of the customer.
	 *
	 * @var string
	 */
	private $telephone;

	/**
	 * The token of the customer.
	 *
	 * @var string
	 */
	private $token;

	/**
	 * The country of the customer.
	 *
	 * @var string
	 */
	private $country;

	/**
	 * Constructor.
	 *
	 * @param array $config Database informations.
	 * @param integer $id ID of the customer.
	 * @param string $firstname First name of the customer.
	 * @param string $lastname Last name of the customer.
	 * @param string $email Email address of the customer.
	 * @param string $address Address of the customer.
	 * @param string $city City of the customer.
	 * @param string $zipcode Zip code of the customer.
	 * @param string $telephone Telephone of the customer.
	 * @param string $token Token of the customer.
	 * @param string $country Country of the customer.
	 *
	 * @return void
	 */
	public function __construct($config, $id = null, $firstname = null, $lastname = null, $email = null, $password = null,$address = null, $city = null, $zipcode = null, $telephone = null, $token = null, $country = null)
	{
		$this->config = $config;
		$this->id = $id;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->password = $password;
		$this->address = $address;
		$this->city = $city;
		$this->zipcode = $zipcode;
		$this->telephone = $telephone;
		$this->token = $token;
		$this->country = $country;
	}

	/**
	 * Returns an array of all customers.
	 *
	 * @return array Customers informations.
	 */
	public function listAllCustomers()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM client
		");

		$query->execute();
		return $query->fetchAll();
	}

	/**
	 * Returns the customer ID.
	 *
	 * @return array ID of the customer.
	 */
	public function getCustomerId()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT id
			FROM client
			WHERE mail = ?
		");
		$query->bindParam(1, $this->email, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the customer token.
	 *
	 * @return array Token of the customer.
	 */
	public function getCustomerToken()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT token
			FROM client
			WHERE mail = ?
		");
		$query->bindParam(1, $this->email, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the customer informations from the email address.
	 *
	 * @return array Informations of the customer.
	 */
	public function getCustomerInfosFromEmail()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM client
			WHERE mail = ?
		");
		$query->bindParam(1, $this->email, \PDO::PARAM_STR);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Returns the customer informations from the ID.
	  *
	  * @return array Informations of the customer.
	 */
	public function getCustomerInfosFromId()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			SELECT *
			FROM client
			WHERE id = ?
		");
		$query->bindParam(1, $this->id, \PDO::PARAM_INT);

		$query->execute();
		return $query->fetch();
	}

	/**
	 * Saves the new customer at registration.
	 *
	 * @return mixed Returns the ID generated if query is correct else returns false.
	 */
	public function saveNewCustomer()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			INSERT INTO client
				(nom, prenom, mail, pass)
			VALUES
				(?, ?, ?, ?)
		");
		$query->bindParam(1, $this->firstname, \PDO::PARAM_STR);
		$query->bindParam(2, $this->lastname, \PDO::PARAM_STR);
		$query->bindParam(3, $this->email, \PDO::PARAM_STR);
		$query->bindParam(4, $this->password, \PDO::PARAM_STR);

		return $query->execute();
	}

	/**
	 * Saves the customer personal informations from profile edit.
	 *
	 * @return mixed Returns the ID generated if query is correct else returns false.
	 */
	public function saveCustomerData()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE client SET
				nom = ?,
				prenom = ?,
				mail = ?,
				adresse = ?,
				ville = ?,
				code_post = ?,
				tel = ?,
				pays = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->firstname, \PDO::PARAM_STR);
		$query->bindParam(2, $this->lastname, \PDO::PARAM_STR);
		$query->bindParam(3, $this->email, \PDO::PARAM_STR);
		$query->bindParam(4, $this->address, \PDO::PARAM_STR);
		$query->bindParam(5, $this->city, \PDO::PARAM_STR);
		$query->bindParam(6, $this->zipcode, \PDO::PARAM_STR);
		$query->bindParam(7, $this->telephone, \PDO::PARAM_STR);
		$query->bindParam(8, $this->country, \PDO::PARAM_STR);
		$query->bindParam(9, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves the new generated token to the corresponding customer.
	 *
	 * @return mixed Returns false if the query failed.
	 */
	public function saveCustomerToken()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE client SET
				token = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->token, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Deletes the corresponding customer token.
	 *
	 * @return mixed Returns false if the query failed.
	 */
	public function deleteCustomerToken()
	{
		$db = $this->dbConnect($config);
		$query = $db->prepare("
			UPDATE client SET
				token = ?
			WHERE id = ?
		");
		$query->bindParam(1, NULL);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Saves the new password for the corresponding customer.
	 *
	 * @return mixed Returns false if the query failed.
	 */
	public function saveNewPassword()
	{
		$db = $this->dbConnect();
		$query = $db->prepare("
			UPDATE client SET
				pass = ?
			WHERE id = ?
		");
		$query->bindParam(1, $this->password, \PDO::PARAM_STR);
		$query->bindParam(2, $this->id, \PDO::PARAM_INT);

		return $query->execute();
	}

	/**
	 * Defines the ID.
	 *
	 * @param integer $id ID of the customer.
	 *
	 * @return void
	 */
	public function set_id($id)
	{
		$this->id = $id;
	}

	/**
	 * Defines the first name.
	 *
	 * @param string $firstname First name of the customer.
	 *
	 * @return void
	 */
	public function set_firstname($firstname)
	{
		$this->firstname = $firstname;
	}

	/**
	 * Defines the last name.
	 *
	 * @param string $lastname Last name of the customer.
	 *
	 * @return void
	 */
	public function set_lastname($lastname)
	{
		$this->lastname = $lastname;
	}

	/**
	 * Defines the email address.
	 *
	 * @param string $email Email addressof the customer.
	 *
	 * @return void
	 */
	public function set_email($email)
	{
		$this->email = $email;
	}

	/**
	 * Defines the password.
	 *
	 * @param string $password Password of the customer.
	 *
	 * @return void
	 */
	public function set_password($password)
	{
		$this->password = $password;
	}

	/**
	 * Defines the address.
	 *
	 * @param string $address Address of the customer.
	 *
	 * @return void
	 */
	public function set_address($address)
	{
		$this->address = $address;
	}

	/**
	 * Defines the city.
	 *
	 * @param string $city City of the customer.
	 *
	 * @return void
	 */
	public function set_city($city)
	{
		$this->city = $city;
	}

	/**
	 * Defines the zip code.
	 *
	 * @param string $zipcode Zip code of the customer.
	 *
	 * @return void
	 */
	public function set_zipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

	/**
	 * Defines the telephone.
	 *
	 * @param string $telephone Telephone of the customer.
	 *
	 * @return void
	 */
	public function set_telephone($telephone)
	{
		$this->telephone = $telephone;
	}

	/**
	 * Defines the token.
	 *
	 * @param string $token Token of the customer.
	 *
	 * @return void
	 */
	public function set_token($token)
	{
		$this->token = $token;
	}

	/**
	 * Defines the country.
	 *
	 * @param string $country Country of the customer.
	 *
	 * @return void
	 */
	public function set_country($country)
	{
		$this->country = $country;
	}

	/**
	 * Returns the ID of the customer.
	 *
	 * @return integer ID of the customer.
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Returns the first name of the customer.
	 *
	 * @return string First name of the customer.
	 */
	public function get_firstname()
	{
		return $this->firstname;
	}

	/**
	 * Returns the last name of the customer.
	 *
	 * @return string Last name of the customer.
	 */
	public function get_lastname()
	{
		return $this->lastname;
	}

	/**
	 * Returns the email address of the customer.
	 *
	 * @return string Email address of the customer.
	 */
	public function get_email()
	{
		return $this->email;
	}

	/**
	 * Returns the password of the customer.
	 *
	 * @return string Password of the customer.
	 */
	public function get_password()
	{
		return $this->password;
	}

	/**
	 * Returns the address of the customer.
	 *
	 * @return string Address of the customer.
	 */
	public function get_address()
	{
		return $this->address;
	}

	/**
	 * Returns the city of the customer.
	 *
	 * @return string City of the customer.
	 */
	public function get_city()
	{
		return $this->city;
	}

	/**
	 * Returns the zip code of the customer.
	 *
	 * @return string Zip code of the customer.
	 */
	public function get_zipcode()
	{
		return $this->zipcode;
	}

	/**
	 * Returns the telephone of the customer.
	 *
	 * @return string Telephone of the customer.
	 */
	public function get_telephone()
	{
		return $this->telephone;
	}

	/**
	 * Returns the token of the customer.
	 *
	 * @return string Token of the customer.
	 */
	public function get_token()
	{
		return $this->token;
	}

	/**
	 * Returns the country of the customer.
	 *
	 * @return string Country of the customer.
	 */
	public function get_country()
	{
		return $this->country;
	}
}