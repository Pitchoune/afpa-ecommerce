<?php

require_once(DIR . '/controller/stripe.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/view/frontoffice/ViewShopping.php');
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
	ViewShopping::DisplayCart();
}

/**
 * Displays the checkout page.
 *
 * @return void
 */
function viewCheckout()
{
	ViewShopping::DisplayCheckout();
}

/**
 * Display the place order page.
 *
 * @param string $price Total price of the checkout.
 * @param integer $deliver Deliver ID selected in the checkout.
 * @param integer $delivermode Deliver mode selected in the checkout.
 *
 * @return void
 */
function placeOrder($price, $deliver, $delivermode)
{
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
 * @param string $token2 CSRF token.
 *
 * @return void
 */
function paymentProcess($name, $email, $price, $deliver, $delivermode, $token, $item, $token2)
{
	global $config;

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate email
	$validmessage = Utils::datavalidation($email, 'mail');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate price
	$validmessage = Utils::datavalidation($price, 'price');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate deliver
	$validmessage = Utils::datavalidation($deliver, 'deliver');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate delivermode
	$validmessage = Utils::datavalidation($delivermode, 'delivermode');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Verify CSRF attempt is valid
	$antiCSRF = new SecurityService();
	$csrfResponse = $antiCSRF->validate();

	if (!empty($csrfResponse))
	{
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

			$date = date("Y-m-d H:i:s");

			// Save order
			$orders = new ModelOrder($config);
			$orders->set_date($date);
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
					$value['id'] = intval($value['id']);
					$value['price'] = trim(strval($value['price']));
					$value['quantity'] = intval($value['quantity']);

					// Validate price
					$validmessage = Utils::datavalidation($value['price'], 'price');

					if ($validmessage)
					{
						throw new Exception($validmessage);
					}

					// Validate quantity
					$validmessage = Utils::datavalidation($value['quantity'], 'quantity');

					if ($validmessage)
					{
						throw new Exception($validmessage);
					}

					// Save order details
					$orderdetails->set_order($orderid);
					$orderdetails->set_product($value['id']);
					$orderdetails->set_price($value['price']);
					$orderdetails->set_quantity($value['quantity']);
					$orderdetails->saveOrderDetails();


					// Save the product into the session for a payment success on the resume page
					$_SESSION['user']['order']['item'][$value['id']]['id'] = $value['id'];
					$_SESSION['user']['order']['item'][$value['id']]['price'] = $value['price'];
					$_SESSION['user']['order']['item'][$value['id']]['quantity'] = $value['quantity'];

					// Decrease quantity for each product
					$products = new ModelProduct($config);
					$products->set_id($value['id']);

					$product = $products->getCurrentQuantityStored();

					$newqty = $product['qty'] - $value['quantity'];

					$products->set_quantity($newqty);
					$products->setNewQuantityAfterPaidOrder();

					$addeditems++;
				}

				if ($nbitems === $addeditems)
				{
					// Save order is successful in $_SESSION
					$_SESSION['user']['order']['paid'] = 1;
					$_SESSION['user']['order']['id'] = $orderid;
					$_SESSION['user']['order']['price'] = $price;
					$_SESSION['user']['order']['date'] = $date;
					header('Location: index.php?do=paymentsuccess');
				}
			}
			else
			{
				$_SESSION['user']['order']['failed'] = 1;
				header('Location: index.php?do=paymentfailed');
			}
		}
	}
	else
	{
		throw new Exception('Une erreur inconnue est survenue. Veuillez recommencer.');
	}
}

/**
 * Displays the success payment page.
 *
 * @return void
 */
function paymentSuccess()
{
	ViewShopping::PaymentSuccess();
}

function paymentFailed()
{
	ViewShopping::PaymentFailed();
}

?>
