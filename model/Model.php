<?php

namespace Ecommerce\Model;

/**
 * Class to do data save/delete operations into the database.
 */

class Model
{
	/**
	 * The database configuration informations.
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param array $config Database informations.
	 *
	 * @return void
	 */
	private function __construct($config)
	{
		$this->config = $config;
	}

	/**
	 * Connects to the database.
	 *
	 * @return mixed Database connection.
	 */
	protected function dbConnect()
	{
		try
		{
			$db = new \PDO('mysql:host=' . $this->config['server']['servername'] . ';dbname=' . $this->config['database']['dbname'] . ';charset=utf8', $this->config['server']['username'], $this->config['server']['password'], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC]);
			return $db;
		}
		catch(PDOException $e)
		{
			$errorMessage = $e->getMessage();

			require_once(DIR . '/view/backoffice/ViewError.php');

			if ($do == 'dologin')
			{
				ViewError::DisplayLoggedOutError($errorMessage);
				exit;
			}

			ViewError::DisplayLoggedInError($errorMessage);
		}
	}

	/**
	 * Checks if the given value is in the allowed data.
	 *
	 * @param mixed $value The data to validate. Can be a string, an integer, an array, etc.
	 * @param array $allowed Allowed data to verify. Composed of an array with valid values.
	 * @param string $message Error message to display if the value doesn't match the allowed values.
	 */
	protected function white_list(&$value, $allowed, $message)
	{
		if ($value === null)
		{
			return $allowed[0];
		}

		$key = array_search($value, $allowed, true);

		if ($key === false)
		{
			throw new Exception($message);
		}
		else
		{
			return $value;
		}
	}
}