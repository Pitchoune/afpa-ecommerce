<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);

// Sanitize do= values, others required per page are sanitized when necessary
$do = isset($_REQUEST['do']) ? filter_var($_REQUEST['do'], FILTER_SANITIZE_STRING) : NULL;

if (empty($do) OR !isset($do))
{
	$do = 'index';
}

// Controller call - contains functions which do model work and return the view
require_once('controller/frontoffice.php');
require_once(DIR . '/view/frontoffice/ViewTemplate.php');

// Utils::printr($_SESSION, 1);

// Request customer informations here to be used for any page if the customer is logged-in
if (isset($_SESSION['user']['id']))
{
	require_once(DIR . '/model/ModelCustomer.php');
	$customers = new \Ecommerce\Model\ModelCustomer($config);
	$customers->set_id($_SESSION['user']['id']);
	$customer = $customers->getCustomerInfosFromId();
}

// We define which action does and will search in the controller the called function
try
{
	switch($do)
	{
		case 'index':
		default:
			index();
			break;
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
			doLogin($email, $password);
			break;
		case 'profile':
			viewProfile();
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
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$newpassword = isset($_POST['newpassword']) ? filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING) : NULL;
			$confirmpassword = isset($_POST['confirmpassword']) ? filter_var($_POST['confirmpassword'], FILTER_SANITIZE_STRING) : NULL;
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
		case 'logout':
			doLogout();
			break;
	}
}
catch(Exception $e)
{
	$errorMessage = $e->getMessage();
	require_once(DIR . '/view/frontoffice/ViewError.php');

	ViewError::DisplayError($errorMessage);
	exit;
}
?>
