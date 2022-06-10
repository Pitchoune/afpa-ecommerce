<?php

// Start the session here
session_start();

// Hide some notices from errors - added for the upload stuff
error_reporting(E_ALL & ~E_NOTICE);

use \Ecommerce\Model\ModelCustomer;

// Sanitize do= values, others required per page are sanitized when necessary
$do = isset($_REQUEST['do']) ? filter_var($_REQUEST['do'], FILTER_SANITIZE_STRING) : NULL;
$pagenumber = isset($_REQUEST['page']) ? filter_var($_REQUEST['page'], FILTER_VALIDATE_INT) : intval(1);

// Force to go to the index if there is no routing defined
if (empty($do) OR !isset($do))
{
	$do = 'index';
}

// Controller call - contains functions which do model work and return the view
require_once('controller/frontoffice.php');
require_once(DIR . '/view/frontoffice/ViewTemplate.php');

// Debug stuff - do not take into account
// echo $do;
// Utils::printr($_SESSION, 1);

// Request customer informations here to be used for any page if the customer is logged-in
if (isset($_SESSION['user']['id']))
{
	require_once(DIR . '/model/ModelCustomer.php');
	$customers = new ModelCustomer($config);
	$customers->set_id($_SESSION['user']['id']);
	$customer = $customers->getCustomerInfosFromId();
}

// We define which action does and will search in the controller the called function
try
{
	switch($do)
	{
		// Home page
		case 'index':
		default:
			index();
			break;
		// Customer
		case 'register':
			register();
			break;
		case 'doregister':
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$passwordconfirm = isset($_POST['passwordconfirm']) ? filter_var($_POST['passwordconfirm'], FILTER_SANITIZE_STRING) : NULL;
			doRegister($firstname, $lastname, $email, $password, $passwordconfirm);
			break;
		case 'login':
			login();
			break;
		case 'dologin':
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$doaction = isset($_POST['doaction']) ? filter_var($_POST['doaction'], FILTER_SANITIZE_STRING) : NULL;
			doLogin($email, $password, $doaction);
			break;
		case 'dashboard':
			viewDashboard();
			break;
		case 'editprofile':
			editProfile();
			break;
		case 'saveprofile':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_STRING) : NULL;
			$city = isset($_POST['city']) ? filter_var($_POST['city'], FILTER_SANITIZE_STRING) : NULL;
			$zipcode = isset($_POST['zipcode']) ? filter_var($_POST['zipcode'], FILTER_SANITIZE_STRING) : NULL;
			$telephone = isset($_POST['telephone']) ? filter_var($_POST['telephone'], FILTER_SANITIZE_STRING) : NULL;
			$country = isset($_POST['country']) ? filter_var($_POST['country'], FILTER_SANITIZE_STRING) : NULL;
			saveProfile($id, $firstname, $lastname, $email, $address, $city, $zipcode, $telephone, $country);
			break;
		case 'editpassword':
			$email = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$token = isset($_GET['t']) ? filter_var($_GET['t'], FILTER_SANITIZE_STRING) : NULL;
			editPassword($email, $token);
			break;
		case 'savepassword':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$newpassword = isset($_POST['newpassword']) ? filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING) : NULL;
			$confirmpassword = isset($_POST['confirmpassword']) ? filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$token = isset($_POST['token']) ? filter_var($_POST['token'], FILTER_SANITIZE_STRING) : NULL;
			savePassword($id, $password, $newpassword, $confirmpassword, $token);
			break;
		case 'forgotpassword':
			forgotPassword();
			break;
		case 'sendpassword':
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			sendPassword($email);
			break;
		case 'deleteprofile':
			deleteProfile();
			break;
		case 'dodeleteprofile':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$deletion = $_POST['deleteprofile'];
			doDeleteProfile($id, $deletion);
			break;
		case 'vieworders':
			viewOrders();
			break;
		case 'vieworder':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			viewOrder($id);
			break;
		case 'viewmessages':
			viewMessages();
			break;
		case 'viewmessage':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			viewMessage($id);
			break;
		case 'sendreply':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$latestid = isset($_POST['latestid']) ? filter_var($_POST['latestid'], FILTER_VALIDATE_INT) : NULL;
			$message = isset($_POST['message']) ? $_POST['message'] : NULL; // No need to clean it, there is a better validator later
			addReplyToMessage($id, $latestid, $message);
			break;
		case 'claim':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			viewClaimOrder($id);
			break;
		case 'doclaim':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$reason = isset($_POST['reason']) ? filter_var_array($_POST['reason'], FILTER_VALIDATE_INT) : NULL;
			doClaim($id, $reason);
			break;
		case 'logout':
			doLogout();
			break;
		// Products
		case 'viewproduct':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			$ref = isset($_GET['ref']) ? filter_var($_GET['ref'], FILTER_SANITIZE_STRING) : NULL;
			viewProduct($id, $ref);
			break;
		case 'search':
			$query = isset($_GET['query']) ? filter_var($_GET['query'], FILTER_SANITIZE_STRING) : NULL;
			$type = isset($_GET['type']) ? filter_var($_GET['type'], FILTER_SANITIZE_STRING) : NULL;
			searchResults($query, $type);
			break;
		// Categories
		case 'viewcategory':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			$perpage = isset($_GET['pp']) ? filter_var($_GET['pp'], FILTER_VALIDATE_INT) : NULL;
			$sortby = isset($_GET['sortby']) ? filter_var($_GET['sortby'], FILTER_SANITIZE_STRING) : NULL;
			viewCategory($id, $perpage, $sortby);
			break;
		// Shopping
		case 'viewcart':
			viewCart();
			break;
		case 'viewcheckout':
			viewCheckout();
			break;
		case 'placeorder':
			$deliver = isset($_POST['deliver']) ? filter_var($_POST['deliver'], FILTER_VALIDATE_INT) : NULL;
			$delivermode = isset($_POST['delivermode']) ? filter_var($_POST['delivermode'], FILTER_VALIDATE_INT) : NULL;
			$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_STRING) : NULL;
			placeOrder($price, $deliver, $delivermode);
			break;
		case 'paymentprocess':
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_STRING) : NULL;
			$deliver = isset($_POST['deliver']) ? filter_var($_POST['deliver'], FILTER_VALIDATE_INT) : NULL;
			$delivermode = isset($_POST['delivermode']) ? filter_var($_POST['delivermode'], FILTER_VALIDATE_INT) : NULL;
			$token = isset($_POST['stripeToken']) ? filter_var($_POST['stripeToken'], FILTER_SANITIZE_STRING) : NULL;
			$item = isset($_POST['item']) ? $_POST['item'] : NULL;
			paymentProcess($name, $email, $price, $deliver, $delivermode, $token, $item);
			break;
		case 'paymentsuccess':
			paymentSuccess();
			break;
		case 'paymentfailed':
			paymentFailed();
			break;
		// Contact
		case 'contact':
			viewContact();
			break;
		case 'sendcontact':
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : NULL;
			$telephone = isset($_POST['telephone']) ? filter_var($_POST['telephone'], FILTER_SANITIZE_STRING) : NULL;
			$title = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : NULL;
			$message = isset($_POST['message']) ? $_POST['message'] : NULL; // No need to clean it, there is a better validator later
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			sendContact($firstname, $lastname, $email, $telephone, $title, $message, $id);
			break;
		// Search
		case 'advancedsearch':
			AdvancedSearch();
			break;
		case 'searchresults':
			$product = isset($_REQUEST['product']) ? filter_var($_REQUEST['product'], FILTER_SANITIZE_STRING) : NULL;
			$perpage = isset($_GET['pp']) ? filter_var($_GET['pp'], FILTER_VALIDATE_INT) : NULL;
			$sortby = isset($_GET['sortby']) ? filter_var($_GET['sortby'], FILTER_SANITIZE_STRING) : NULL;
			$description = isset($_REQUEST['description']) ? filter_var($_REQUEST['description'], FILTER_VALIDATE_INT) : NULL;
			$reference = isset($_REQUEST['reference']) ? filter_var($_REQUEST['reference'], FILTER_SANITIZE_STRING) : NULL;
			$category = isset($_REQUEST['category']) ? filter_var($_REQUEST['category'], FILTER_VALIDATE_INT) : NULL;
			$pricemin = isset($_REQUEST['price-min']) ? filter_var($_REQUEST['price-min'], FILTER_VALIDATE_INT) : NULL;
			$pricemax = isset($_REQUEST['price-max']) ? filter_var($_REQUEST['price-max'], FILTER_VALIDATE_INT) : NULL;
			$trademark = isset($_REQUEST['trademark']) ? filter_var_array($_REQUEST['trademark'], FILTER_VALIDATE_INT) : NULL;
			SearchResults($product, $perpage, $sortby, $description, $reference, $category, $pricemin, $pricemax, $trademark);
			break;
	}
}
catch(Exception $e)
{
	// Error has been caught, display it in a specific view
	$errorMessage = $e->getMessage();
	require_once(DIR . '/view/frontoffice/ViewError.php');

	ViewError::DisplayError($errorMessage);
	exit;
}

?>
