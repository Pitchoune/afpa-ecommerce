<?php

namespace Ecommerce\SecurityService;

/**
 * Class to handle CSRF tokens.
 */
class SecurityService
{
	private $formTokenLabel = 'eg-csrf-token-label';

	private $sessionTokenLabel = 'EG_CSRF_TOKEN_SESS_IDX';

	private $post = [];

	private $session = [];

	private $server = [];

	private $excludeUrl = [];

	private $hashAlgo = 'sha256';

	private $hmac_ip = true;

	private $hmacData = 'ABCeNBHVe3kmAqvU2s7yyuJSF2gpxKLC';

	/**
	 * Constructor
	 *
	 * @param array $excludeurl URLs to exclude.
	 * @param array $post $_POST content.
	 * @param array $session $_SESSION content.
	 * @param array $server $_SERVER content.
	 *
	 * @return void
	 */
	public function __construct($excludeurl = null, &$post = null, &$session = null, &$server = null)
	{
		if (!is_null($excludeurl))
		{
			$this->excludeurl = $excludeurl;
		}

		if (!is_null($post))
		{
			$this->post = &$post;
		}
		else
		{
			$this->post = &$_POST;
		}

		if (!is_null($server))
		{
			$this->server = &$server;
		}
		else
		{
			$this->server = &$_SERVER;
		}

		if (!is_null($session))
		{
			$this->session = &$session;
		}
		else if (!is_null($_SESSION) AND isset($_SESSION))
		{
			$this->session = &$_SESSION;
		}
		else
		{
			throw new Exception('Il n\'y a pas de session valide.');
		}
	}

	/**
	 * Adds a new CSRF token to a form.
	 *
	 * @return string HTML data.
	 */
	public function insertHiddenToken()
	{
		$token = self::getCSRFToken();

		return '<input type="hidden" name="' . self::xssafe($this->formTokenLabel) . '" value="' . self::xssafe($token) . '" />';
	}

	/**
	 * Cleans data.
	 *
	 * @param string $data Data to clean.
	 * @param string $encoding Encoding to follow to clean.
	 *
	 * @return string Cleaned data.
	 */
	private function xssafe($data, $encoding = 'UTF-8')
	{
		return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
	}

	/**
	 * Generates, stores and returns the CSRF token.
	 *
	 * @return string CSRF token.
	 */
	private function getCSRFToken()
	{
		if (empty($this->session[$this->sessionTokenLabel]))
		{
			$this->session[$this->sessionTokenLabel] = bin2hex(openssl_random_pseudo_bytes(32));
		}

		if ($this->hmac_ip !== false)
		{
			$token = self::hMacWithIp($this->session[$this->sessionTokenLabel]);
		}
		else
		{
			$token = $this->session[$this->sessionTokenLabel];
		}

		return $token;
	}

	/**
	 * Hashes with IP address removed for GDPR compliance easiness and hmacdata is used.
	 *
	 * @param string $token CSRF token.
	 *
	 * @return string Hashed data.
	 */
	private function hMacWithIp($token)
	{
		$hashHmac = hash_hmac($this->hashAlgo, $this->hmacData, $token);

		return $hashHmac;
	}

	/**
	 * Validates the CSRF attempt.
	 *
	 * @return boolean True if CSRF is valid, else false if CSRF is not valid.
	 */
	public function validate()
	{
		// Get current URL
		$currenturl = self::getCurrentRequestUrl();

		// It is an excluded URL?
		if (!in_array($currenturl, $this->excludeUrl))
		{
			// Is there any $_POST value?
			if (!empty($this->post))
			{
				// Is CSRF token valid?
				if (!self::validateRequest())
				{
					/*
					CSRF attack attempt.

					CSRF attempt is detected. We need to not reveal that information
					to the attacker, so just failing without information.

					Error code 1837 stands for CSRF attempt and this is for our identification purposes.
					*/

					//throw new Exception('Critical Error! Error Code: 1837');

					return false;
				}

				return true;
			}
		}
	}

	/**
	 * Returns the current URL.
	 *
	 * @return Current page URL.
	 */
	private function getCurrentRequestUrl()
	{
		$protocol = 'http';

		if (isset($this->server['HTTPS']))
		{
			$protocol = 'https';
		}

		$currenturl = $protocol = '://' . $this->server['HTTP_HOST'] . $this->server['REQUEST_URI'];

		return $currenturl;
	}

	/**
	 * Validates a request based on session.
	 *
	 * @return boolean True if request is valid, else false if request is not valid.
	 */
	private function validateRequest()
	{
		// Check if CSRF exists
		if (!isset($this->session[$this->sessionTokenLabel]))
		{
			return false;
		}

		// Take the token from $_POST if it exists
		if (!empty($this->post[$this->formTokenLabel]))
		{
			$token = $this->post[$this->formTokenLabel];
		}
		else
		{
			return false;
		}

		// Check if the token is a string
		if (!is_string($token))
		{
			return false;
		}

		// Grab the stored token
		if ($this->hmac_ip !== false)
		{
			$expected = self::hMacWithIp($this->session[$this->sessionTokenLabel]);
		}
		else
		{
			$expected = $this->session[$this->sessionTokenLabel];
		}

		return hash_equals($token, $expected);
	}
}

?>