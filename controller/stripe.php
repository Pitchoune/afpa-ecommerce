<?php

namespace Ecommerce\Stripe;

/**
 * Class to handle every part of Stripe payment system.
 */
class Stripe
{
	/**
	 * The API key provided by Stripe.
	 *
	 * @var string
	 */
	private $api_key;

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->api_key = $api_key;
	}

	/**
	 * cURL calls between the website and Stripe API.
	 *
	 * @param string $endpoint Part of the API to call.
	 * @param array $data Some data to send as complement to Stripe API.
	 *
	 * @return stdClass Decoded-json response from Stripe API.
	 */
	public function api(string $endpoint, array $data = null): ?\stdClass
	{
		// Init cURL connection
		$ch = curl_init();

		// Define settings
		curl_setopt_array($ch, [
			CURLOPT_URL => 'https://api.stripe.com/v1/' . $endpoint,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERPWD => $this->api_key,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC
		]);

		// Use this setting only if $data is filled.
		if ($data !== null)
		{
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		}

		// Handle errors from cURL
		if (curl_errno($ch))
		{
			echo 'Error:' . curl_error($ch);
		}

		// Extract API response return as JSON
		$response = json_decode(curl_exec($ch));

		// Close cURL connection, useless to keep it opened.
		curl_close($ch);

		// Handle error in the response
		if (property_exists($response, 'error'))
		{
			throw new \Exception($response->error->message);
		}

		// Return the final answer if there is no error.
		return $response;
	}

	/**
	 * Defines the API key.
	 *
	 * @return void
	 */
	public function set_apikey($api_key)
	{
		$this->api_key = $api_key;
	}

	/**
	 * Returns the API key.
	 *
	 * @return string API key of Stripe.
	 */
	public function get_apikey()
	{
		return $this->api_key;
	}
}

?>