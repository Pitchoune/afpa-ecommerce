<?php

namespace Ecommerce\Model;

/**
 * Class to do data save/delete operations into the database.
 *
 * @date $Date$
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
}