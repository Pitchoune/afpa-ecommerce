<?php

require_once(DIR . '/controller/stripe.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelProduct.php');
use \Ecommerce\Stripe\Stripe;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelProduct;

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
 * @param string $price Total price of the checkout.
 * @param $deliver Deliver ID selected in the checkout.
 * @param integer $delivermode Deliver mode selected in the checkout.
 *
 * @return void
 */
function placeOrder($price, $deliver, $delivermode)
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewShopping.php');
	ViewShopping::PlaceOrder($price, $deliver, $delivermode);
}

/**
 * Process the payment.
 *
 * @param string $name Name (firstname + lastname) of the customer.
 * @param string $email Email address of the customer.
 * @param string $price Total price of the checkout.
 * @param string $deliver Deliver ID selected in the checkout.
 * @param integer $delivermode Deliver mode selected in the checkout.
 * @param string $token Stripe token generate'd in the place order page.
 * @param array $item Array of all items in the cart. Used to save order details.
 *
 * @return void
 */
function paymentProcess($name, $email, $price, $deliver, $delivermode, $token, $item)
{
	global $config;

	// Call stripe class
	$stripe = new Stripe();

	// Set Stripe API key
	$stripe->set_apikey($config['Stripe']['privatekey']);

	// Create customer
	$customer = $stripe->api('customers', ['source' => $token, 'description' => $name, 'email' => $email]);

	// Proceed to charge the customer
	$charge = $stripe->api('charges', ['amount' => $price * 100, 'currency' => 'eur', 'customer' => $customer->id]);

	// Charge is successful, create the order and order details in the database for the customer and clear sessionStorage once created!
	if ($charge->paid === true)
	{
		// Define the text for the deliver mode
		switch($delivermode)
		{
			case 1:
				$mode = 'À domicile';
				break;
			case 2:
				$mode = 'Point-relais';
				break;
			case 3:
				$mode = 'Bureau de poste';
				break;
		}

		// Save order
		$orders = new ModelOrder($config);
		$orders->set_date(date("Y-m-d H:i:s"));
		$orders->set_status('Payé');
		$orders->set_mode($mode);
		$orders->set_customer($_SESSION['user']['id']);
		$orders->set_deliver($deliver);
		$orderid = $orders->saveNewOrder();

		if ($orderid > 0)
		{
			// Save the order details
			$orderdetails = new ModelOrderDetails($config);

			$nbitems = count($item);
			$addeditems = 0;

			foreach ($item AS $key => $value)
			{
				// Save order details
				$orderdetails->set_order($orderid);
				$orderdetails->set_product(intval($value['id']));
				$orderdetails->set_price(trim($value['price']));
				$orderdetails->set_quantity(intval($value['quantity']));
				$orderdetails->saveOrderDetails();

				// Decrease quantity for each product
				$products = new ModelProduct($config);
				$products->set_id($value['id']);
				$products->set_quantity($value['quantity']);
				$products->setNewQuantityAfterPaidOrder();

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