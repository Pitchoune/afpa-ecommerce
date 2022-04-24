<?php

/**
 * Displays the cart page.
 *
 * @return void
 */
function viewCart()
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewShopping.php');
	ViewShopping::DisplayCart();
}

/**
 * Displays the checkout page.
 *
 * @return void
 */
function viewCheckout()
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewShopping.php');
	ViewShopping::DisplayCheckout();
}

/**
 * Display the place order page.
 *
 * @return void
 */
function placeOrder($price)
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewShopping.php');
	ViewShopping::PlaceOrder($price);
}

/**
 * Process the payment.
 *
 * @param string $name Name (firstname + lastname) of the customer.
 * @param string $email Email address of the customer.
 * @param string $price Total price of the checkout.
 * @param string $token Stripe token generate'd in the place order page.
 * @param array $item Array of all items in the cart. Used to save order details.
 *
 * @return void
 */
function paymentProcess($name, $email, $price, $token, $item)
{
	global $config;

	// Call stripe class
	require_once(DIR . '/controller/stripe.php');
	$stripe = new \Ecommerce\Controller\Stripe();

	// Set Stripe API key
	$stripe->set_apikey($config['Stripe']['privatekey']);

	// Create customer
	$customer = $stripe->api('customers', ['source' => $token, 'description' => $name, 'email' => $email]);

	// Proceed to charge the customer
	$charge = $stripe->api('charges', ['amount' => $price * 100, 'currency' => 'eur', 'customer' => $customer->id]);

	// Charge is successful, create the order and order details in the database for the customer and clear sessionStorage once created!
	if ($charge->paid === true)
	{
		// Save the order
		require_once(DIR . '/model/ModelOrder.php');
		$orders = new \Ecommerce\Model\ModelOrder($config);
		$orders->set_date(date("Y-m-d H:i:s"));
		$orders->set_status('Payé');
		$orders->set_mode('');
		$orders->set_customer($_SESSION['user']['id']);
		$orders->set_deliver(3);
		$orderid = $orders->saveNewOrder();

		if ($orderid > 0)
		{
			// Save the order details
			require_once(DIR . '/model/ModelOrderDetails.php');
			$orderdetails = new \Ecommerce\Model\ModelOrderDetails($config);

			$nbitems = count($item);
			$addeditems = 0;

			foreach ($item AS $key => $value)
			{
				$orderdetails->set_order($orderid);
				$orderdetails->set_product(intval($value['id']));
				$orderdetails->set_price(trim($value['price']));
				$orderdetails->set_quantity(intval($value['quantity']));
				$orderdetails->saveOrderDetails();
				$addeditems++;
			}

			if ($nbitems === $addeditems)
			{
				// Save order is successful in $_SESSION
				$_SESSION['order']['paid'] = 1;

				header('Location: index.php');
			}
		}
		else
		{
			$_SESSION['order']['failed'] = 1;

			header('Location: index.php?do=placeorder');
		}
	}
}

?>