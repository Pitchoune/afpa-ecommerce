<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelEmployee.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelTrademark.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelEmployee;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelTrademark;
use \Ecommerce\Model\ModelMessage;

/**
 * Displays the register form.
 *
 * @return void
 */
function register()
{
	if ($_SESSION['user']['loggedin'])
	{
		throw new Exception('Vous êtes déjà identifié. Vous ne pouvez pas vous inscrire.');
	}

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::RegisterForm();
}

/**
 * Registers the user.
 *
 * @param string $firstname First name of the user.
 * @param string $lastname Last name of the user.
 * @param string $email Email address of the user.
 * @param string $password Password of the user.
 * @param string $passwordconfirm Password confirmation.
 *
 * @return void
 */
function doRegister($firstname, $lastname, $email, $password, $passwordconfirm)
{
	global $config;

	if ($_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$password = trim(strval($password));
	$passwordconfirm = trim(strval($passwordconfirm));

	// Enabling the model call here, useful to validate data
	$customer = new ModelCustomer($config);

	// Validate first name
	if (empty($firstname))
	{
		throw new Exception('Veuillez insérer votre prénom.');
	}
	else if (!preg_match('/^[\p{L}\s]{2,}$/u', $firstname))
	{
		throw new Exception('Le prénom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
	}

	// Validate last name
	if (empty($lastname))
	{
		throw new Exception('Veuillez insérer votre nom.');
	}
	else if (!preg_match('/^[\p{L}\s]{2,}$/u', $lastname))
	{
		throw new Exception('Le nom peut contenir uniquement des lettres, des chiffres et des caractères spéciaux.');
	}

	// Validate email
	if (empty($email))
	{
		throw new Exception('Veuillez insérer votre adresse email.');
	}
	else if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
	{
		throw new Exception('Veuillez insérer une adresse email valide.');
	}
	else
	{
		$customer->set_email($email);
		$customeremail = $customer->getCustomerId();

		if ($customeremail['id'])
		{
			throw new Exception('Cette adresse email existe déjà.');
		}
	}

	// Validate password
	if (empty($password))
	{
		throw new Exception('Veuillez insérer un mot de passe.');
	}
	else if ($password !== $passwordconfirm)
	{
		throw new Exception('Les mots de passe ne correspondent pas.');
	}
	else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
	{
		throw new Exception('Le mot de passe utilise des caractères interdits. Il doit contenir des caractères minuscules, majuscules, des chiffres et des caractères spéciaux, sur 8 caractères de long. Veuillez recommencer.');
	}

	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);

	// No error - we insert the new user with the model
	$customer->set_firstname($firstname);
	$customer->set_lastname($lastname);
	$customer->set_email($email);
	$customer->set_password($hashedpassword);

	if ($customer->saveNewCustomer())
	{
		$_SESSION['userregistered'] = 1;
	}
	else
	{
		throw new Exception('L\'inscription n\'a pas pu aller jusqu\'au bout. Veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
	}

	// We generate HTML code from the view
	header('Location: index.php');
}

/**
 * Displays the login form.
 *
 * @rturn void
 */
function login()
{
	if ($_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::LoginForm();
}

/**
 * Logins the user.
 *
 * @param string $email Email of the user.
 * @param string $password Corresponding password of the user.
 *
 * @return void
 */
function doLogin($email, $password)
{
	global $config;

	if ($_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	$email = trim(strval($email));
	$password = trim(strval($password));

	// Enabling the model call here, useful to validate data
	$customer = new ModelCustomer($config);

	// Validate email
	if (empty($email))
	{
		throw new Exception('Veuillez insérer votre adresse email.');
	}
	else if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
	{
		throw new Exception('Veuillez insérer une adresse email valide.');
	}
	else
	{
		$customer->set_email($email);
		$customerid = $customer->getCustomerId();

		if (!$customerid['id'])
		{
			throw new Exception('Une erreur est survenue, veuillez recommencer.');
		}
	}

	// Validate password
	if (empty($password))
	{
		throw new Exception('Veuillez insérer un mot de passe.');
	}
	else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
	{
		throw new Exception('Le mot de passe utilise des caractères interdits. Il doit contenir des caractères minuscules, majuscules, des chiffres et des caractères spéciaux, sur 8 caractères de long. Veuillez recommencer.');
	}

	// No error - we insert the new user with the model
	$customer->set_email($email);
	$user = $customer->getCustomerInfosFromEmail();

	if (!$user)
	{
		throw new Exception('L\'identification n\'a pas pu aller jusqu\'au bout. Veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
	}

	// Verify password
	if (password_verify($password, $user['pass']))
	{
		// Store session informations
		$_SESSION['user']['loggedin'] = true;
		$_SESSION['user']['id'] = $user['id'];
		$_SESSION['user']['email'] = $user['mail'];
		$_SESSION['userloggedin'] = 1;
	}
	else
	{
		throw new Exception('Une erreur est survenue, veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
	}

	// We generate HTML code from the view
	header('Location: index.php');
}

/**
 * Logouts the user.
 *
 * @return void
 */
function doLogout()
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	// Kill the whole session
	session_destroy();

	// Create a new session to store the value for the notification
	session_start();
	$_SESSION['userloggedout'] = 1;

	// We generate HTML code from the view
	header('Location: index.php');
}

/**
 * Displays the dashboard with links to manage account informations.
 *
 * @return void
 */
function viewDashboard()
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);
	$data = $customer->getCustomerInfosFromId();

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::CustomerDashboard($data);
}

/**
 * Displays the profile informations form to edit personal informations.
 *
 * @return void
 */
function editProfile()
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);
	$data = $customer->getCustomerInfosFromId();

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::CustomerProfile($data);
}

/**
 * Saves the profile informations.
 *
 * @param integer $id ID of the customer.
 * @param string $firstname First name of the customer.
 * @param string $lastname Last name of the customer.
 * @param string $email Email address of the customer.
 * @param string $address Address of the customer.
 * @param string $city City of the customer.
 * @param string $zipcode Zip code of the customer.
 * @param string $telephone Telephone of the customer.
 *
 * @return void
 */
function saveProfile($id, $firstname, $lastname, $email, $address, $city, $zipcode, $telephone)
{
	global $config;

	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	$id = intval($id);
	$firstname = trim(strval($firstname));
	$lastname = trim(strval($lastname));
	$email = trim(strval($email));
	$address = trim(strval($address));
	$city = trim(strval($city));
	$zipcode = intval($zipcode);
	$telephone = intval($telephone);

	$customers = new ModelCustomer($config);

	// Verify first name
	if ($firstname === '')
	{
		throw new Exception('Veuillez remplir le prénom.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/u', $firstname))
	{
		throw new Exception('Le format du prénom n\'est pas valide.');
	}

	// Verify last name
	if ($lastname === '')
	{
		throw new Exception('Veuillez remplir le nom.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/u', $lastname))
	{
		throw new Exception('Le format du nom n\'est pas valide.');
	}

	// Verify email address
	if ($email === '')
	{
		throw new Exception('Veuillez remplir l\'adresse email.');
	}

	if (!preg_match('/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si', $email))
	{
		throw new Exception('Le format de l\'adresse email n\'est pas valide.');
	}

	// Verify address
	if ($address === '')
	{
		throw new Exception('Veuillez remplir l\'adresse postale.');
	}

	if (!preg_match('/^[\d\w\-\s]{5,100}$/', $address))
	{
		throw new Exception('Le format de l\'adresse postale n\'est pas valide.');
	}

	// Verify city
	if ($city === '')
	{
		throw new Exception('Veuillez remplir la ville.');
	}

	if (!preg_match('/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/u', $city))
	{
		throw new Exception('Le format de la ville n\'est pas valide.');
	}

	// Verify zipcode
	if ($zipcode === '')
	{
		throw new Exception('Veuillez remplir le code postal.');
	}

	if (!preg_match('/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/', $zipcode))
	{
		throw new Exception('Le format du code postal n\'est pas valide.');
	}

	// Verify telephone
	if ($telephone === '')
	{
		throw new Exception('Veuillez remplir le téléphone.');
	}

	if (!preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $telephone))
	{
		throw new Exception('Le format du téléphone n\'est pas valide.');
	}

	$customers->set_id($id);
	$customers->set_firstname($firstname);
	$customers->set_lastname($lastname);
	$customers->set_email($email);
	$customers->set_address($address);
	$customers->set_city($city);
	$customers->set_zipcode($zipcode);
	$customers->set_telephone($telephone);

	// Save
	if ($customers->saveCustomerData())
	{
		$_SESSION['profile']['edit'] = 1;
	}
	else
	{
		throw new Exception('La mise à jour de vos données ne s\'est pas effectué, veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
	}

	header('Location: index.php?do=editprofile');
}

/**
 * Displays a form to edit customer password. You can access it logged-in or logged-out.
 *
 * @param string $email Email address of the customer. Used on forgot password.
 * @param string $token Generated token sent when customer forgot the password.
 *
 * @return void
 */
function editPassword($email = '', $token = '')
{
	global $config;

	$email = trim(strval($email));
	$token = trim(strval($token));

	if (!$_SESSION['user']['loggedin'])
	{
		// Forgot password feature after email reception with generated link to change password
		if ($email !== '' AND $token !== '')
		{
			$customers = new ModelCustomer($config);
			$customers->set_email($email);
			$customerid = $customers->getCustomerId();

			if ($customers->getCustomerId())
			{
				// ID exists, check the token
				$savedtoken = $customers->getCustomerToken();

				if ($savedtoken['token'] !== $token)
				{
					throw new Exception('Une erreur s\'est produite pendant la réinitialisation de votre mot de passe. Veuillez recommencer depuis le lien situé dans l\'email d\'oubli du mot de passe. Si le problème persiste, veuillez contacter l\'équipe.');
				}
			}
			else
			{
				throw new Exception('Une erreur s\'est produite pendant la réinitialisation de votre mot de passe. Veuillez recommencer depuis le lien situé dans l\'email d\'oubli du mot de passe. Si le problème persiste, veuillez contacter l\'équipe.');
			}
		}
	}

	$customer = new ModelCustomer($config);

	if ($customerid['id'])
	{
		$customer->set_id($customerid['id']);
	}
	else
	{
		$customer->set_id($_SESSION['user']['id']);
	}

	$data = $customer->getCustomerInfosFromId();

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::CustomerPassword($data, $savedtoken);
}

/**
 * Saves the new password defined by the customer.
 *
 * @param integer $id ID of the customer.
 * @param string $password Current password of the customer. Empty if from the forgot password email.
 * @param string $newpassword New password of the customer.
 * @param string $confirmpassword New password confirmation of the customer.
 * @param string $token Token of the customer if filled. Necessary on forgot password.
 *
 * @return void
 */
function savePassword($id, $password = '', $newpassword, $confirmpassword, $token = '')
{
	global $config;

	$id = intval($id);
	$password = trim(strval($password));
	$newpassword = trim(strval($newpassword));
	$confirmpassword = trim(strval($confirmpassword));
	$token = trim(strval($token));

	$customers = new ModelCustomer($config);
	$customers->set_id(intval($id));
	$customer = $customers->getCustomerInfosFromId();

	if (!$token)
	{
		// Verify password
		if ($password === '')
		{
			throw new Exception('Veuillez remplir le mot de passe actuel.');
		}

		if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password))
		{
			throw new Exception('Le mot de passe actuel n\'est pas valide. Il doit contenir des caractères minuscules, majuscules, des chiffres et des caractères spéciaux, sur 8 caractères de long.');
		}

		$checkpassword = password_verify($password, $customer['pass']);
	}
	else
	{
		// If there is a token submitted (forgot password), there is no current password field
		// We can't verify the current password, setting it to true for this case.
		$checkpassword = true;
	}

	// Verify new password
	if ($newpassword === '')
	{
		throw new Exception('Veuillez remplir le nouveau mot de passe.');
	}

	if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $newpassword))
	{
		throw new Exception('Le nouveau mot de passe n\'est pas valide. Il doit contenir des caractères minuscules, majuscules, des chiffres et des caractères spéciaux, sur 8 caractères de long.');
	}

	// Verify confirm password
	if ($confirmpassword === '')
	{
		throw new Exception('Veuillez remplir la confirmation du nouveau mot de passe.');
	}

	if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $confirmpassword))
	{
		throw new Exception('La confirmation du mot de passe n\'est pas valide. Il doit contenir des caractères minuscules, majuscules, des chiffres et des caractères spéciaux, sur 8 caractères de long.');
	}

	// Change password with the original password
	if ($checkpassword)
	{
		if ($newpassword === $confirmpassword)
		{
			if (!password_verify($newpassword, $customer['pass']))
			{
				// All checks are OK - save the hashed password into the database
				$hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
				$customers->set_password($hashedpassword);

				if ($customers->saveNewPassword())
				{
					// Delete the token
					if ($token)
					{
						$customers->set_token($token);
						$customers->deleteCustomerToken();
					}

					$_SESSION['password']['edit'] = 1;
				}
				else
				{
					throw new Exception('La modification du mot de passe a échoué. Veuillez recommencer. Si le problème persiste, veuillez contacter l\'éqauipe.');
				}
			}
			else
			{
				throw new Exception('Le nouveau mot de passe ne peut pas être l\'ancien mot de passe. Veuillez recommencer.');
			}
		}
		else
		{
			throw new Exception('Le nouveau mot de passe ne conrrespond pas à la confirmation du nouveau mot de passe. Veuillez recommencer.');
		}
	}
	else
	{
		throw new Exception('Le mot de passe actuel ne correpond pas. Veuillez recommencer.');
	}

	header('Location: index.php?do=editpassword');
}

/**
 * Displays a form to change customer password if the password is forgotten.
 *
 * @return void
 */
function forgotPassword()
{
	if ($_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);
	$data = $customer->getCustomerInfosFromId();

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::CustomerForgotPassword($data);
}

/**
 * Send an email with the link to define a new password.
 *
 * @param string $email Email of the customer.
 *
 * @return void
 */
function sendPassword($email)
{
	if ($_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$email = trim(strval($email));

	$customers = new ModelCustomer($config);
	$customers->set_email($email);
	$customer = $customers->getCustomerInfosFromEmail();

	// Check if the email address is valid
	if ($customer)
	{
		// User found, generate a token
		// Define the length to 50 as the final token will have the defined length x 2
		$token = bin2hex(random_bytes(50));
		$customers->set_token($token);
		$customers->set_id($customer['id']);

		if ($customers->saveCustomerToken())
		{
			// Send the generate password link to send to the customer
			$message = 'Bonjour,

Voici le lien pour modifier votre mot de passe oublié :

https://' . $_SERVER['HTTP_HOST'] . $_SERVER['DOCUMENT_URI'] . '?do=editpassword&t=' . $token . '&email=' . $email;

			$headers = 'From: admin@yrg.ovh' . "\r\n" . 'Reply-To: admin@yrg.ovh' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

			$sentmail = mail($email, 'Oubli de votre mot de passe', $message, $headers);

			if ($sentmail)
			{
				$_SESSION['password']['forgot'] = 1;
			}
		}
		else
		{
			throw new Exception('Une erreur est survenue pendant la réinitialisation du mot de passe. Veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
		}
	}
	else
	{
		throw new Exception('Une erreur est survenue pendant la réinitialisation du mot de passe. Veuillez recommencer. Si le problème persiste, veuillez contacter l\'équipe.');
	}

	header('Location: index.php?do=forgotpassword');
}

/**
 * Displays the HTML code to let the user to request to delete his/her profile.
 *
 * @return void
 */
function deleteProfile()
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);

	$data = $customer->getCustomerInfosFromId();

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::CustomerDeleteProfile($data);
}

/**
 * Process the profile deletion.
 *
 * @param integer $id ID of the customer to delete.
 * @param boolean $deletion True or false from the checkbox from the customer to delete the account.
 *
 * @return void
 */
function doDeleteProfile($id, $deletion)
{
	global $config;

	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	if ($deletion)
	{
		// Kill the session - kill also the admin session too
		session_destroy();

		// Create a new empty session to store the notify.
		session_start();

		// Delete only the customer account, not the previous orders
		$customers = new ModelCustomer($config);
		$customers->set_id($id);

		if ($customers->deleteCustomer())
		{
			$_SESSION['customerremoved'] = 1;
		}
	}
	else
	{
		throw new Exception('Vous n\'avez pas coché la case de confirmation de suppression de votre compte, veuillez recommencer.');
	}

	header('Location: index.php');
}

/**
 * Displays the HTML code for the view orders page.
 *
 * @retrun void
 */
function viewOrders()
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config, $pagenumber;

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);
	$data = $customer->getCustomerInfosFromId();

	$orderlist = new ModelOrder($config);
	$orderlist->set_customer($data['id']);
	$totalorders = $orderlist->getNumberOfOrdersForCustomer();

	if ($totalorders['nborders'] > 0)
	{
		// Number max per page
		$perpage = 10;

		$limitlower = Utils::define_pagination_values($totalorders['nborders'], $pagenumber, $perpage);

		$orders = $orderlist->getAllCustomerOrders($limitlower, $perpage);
	}

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::DisplayOrders($orders, $orderlist, $totalorders, $perpage);
}

/**
 * Display the HTML code for the specific order page.
 *
 * @param integer $id ID of the order.
 *
 * @return void
 */
function viewOrder($id)
{
	if (!$_SESSION['user']['loggedin'])
	{
		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}

	global $config;

	$id = intval($id);

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);

	$data = $customer->getCustomerInfosFromId();

	if ($data['id'] === $_SESSION['user']['id'])
	{
		$orderdetails = new ModelOrderDetails($config);
		$orderdetails->set_order(intval($id));
		$orderdetail = $orderdetails->getOrderDetails();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher cette page.');
	}

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::DisplayOrder($id, $orderdetail);
}

/**
 * Display the HTML code for the conversations list page.
 *
 * @return void
 */
function viewMessages()
{
	if ($_SESSION['user']['loggedin'])
	{
		global $config, $pagenumber;

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);

		$data = $customer->getCustomerInfosFromId();

		$messagelist = new ModelMessage($config);
		$messagelist->set_customer($data['id']);
		$messagelist->set_type('contact', 'notif');
		$totalmessages = $messagelist->countMessagesFromCustomer();

		$perpage = 10;
		$limitlower = Utils::define_pagination_values($totalmessages['nbmessages'], $pagenumber, $perpage);

		$getmessage = $messagelist->getAllMessagesFromCustomer($limitlower, $perpage);

		$messages = [];

		foreach ($getmessage AS $key => $value)
		{
			$messages[$key] = $value;

			if ($value['id_client'])
			{
				// If the client started the message, displays its first and last name
				$customer->set_id($value['id_client']);
				$customerinfo = $customer->getCustomerInfosFromId();
				$messages[$key]['nom_client'] = $customerinfo['prenom'] . ' ' . $customerinfo['nom'];
			}
		}

		require_once(DIR . '/view/frontoffice/ViewCustomer.php');
		ViewCustomer::viewMessages($messages, $perpage, $totalmessages['nbmessages']);
	}
	else
	{

		$_SESSION['nonallowed'] = 1;
		header('Location: index.php');
	}
}

/**
 * Display the HTML code for a list of messages in a conversation.
 *
 * @param integer $id ID of the root conversation.
 *
 * @return void
 */
function viewMessage($id)
{
	if (!$_SESSION['user']['id'])
	{
		throw new Exception('Vous devez vous identifier avant de pouvoir consulter vos messages.');
	}

	global $config;

	$id = intval($id);

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);
	$customerinfos = $customer->getCustomerInfosFromId();

	$messagelist = new ModelMessage($config);
	$messagelist->set_id($id);

	// Initialize the ids list array of all messages from the same conversation
	$messageids = [];
	$messageids[] = $id;
	$title = '';
	$latestid = 0;

	do {
		// Grab the next id from the latest grabbed
		$i = $messagelist->getNextMessageIdFromDiscussion();
		$messagelist->set_id($i['id']);

		// If the query result is empty, quit the loop
		if (empty($i['id']))
		{
			break;
		}

		// Add the latest found id in the ids list array
		$messageids[] = $i['id'];

		// Get the latest id only for send reply save
		$latestid = $i['id'];
	} while (true);

	// Now we have the ids list array filled with the correct ids, we can transform it
	// into a comma-separated id list for the query to grab all messages
	$list = implode(',', $messageids);

	// Get messages
	$messages = $messagelist->grabAllMessagesFromDiscussion($list);

	// Get only the first title if there is any other (should not)
	$title = $messages[0]['titre'];

	// Get the latest employee response to mark it as assigned to the conversation
	$latestemployee = '';

	for ($i = 0; $i <= count($messages); $i++)
	{
		if ($messages[$i]['id_employe'] !== null)
		{
			$latestemployee = $messages[$i]['id_employe'];
		}
	}

	$employees = new ModelEmployee($config);
	$employees->set_id($latestemployee);
	$employee = $employees->getEmployeeFirstAndLastName();

	// Make impossible to open a discussion without $id being the first message
	if ($messages[0]['precedent_id'] AND $messages[0]['id'] == $id)
	{
		throw new Exception('Vous ne pouvez pas ouvrir une conversation depuis un message qui n\'est pas le premier message.');
	}

	// Make impossible for the current user to read others customers messages
	if ($messages[0]['id_client'] != $_SESSION['user']['id'])
	{
		throw new Exception('Vous ne pouvez pas consulter les messages des autres clients.');
	}

	require_once(DIR . '/view/frontoffice/ViewCustomer.php');
	ViewCustomer::viewMessage($id, $messages, $title, $customerinfos, $latestid, $employee);
}

/**
 * Adds the reply into the database.
 *
 * @param integer $id ID of the conversation.
 * @param integer $latestid ID of the latest reply.
 * @param string $message Message of the customer.
 *
 * @return void
 */
function addReplyToMessage($id, $latestid, $message)
{
	if (!$_SESSION['user']['id'])
	{
		throw new Exception('Vous devez vous identifier avant de pouvoir envoyer des réponses aux messages.');
	}

	global $config;

	$id = intval($id);
	$latestid = intval($latestid);
	$message = trim(strval($message));

	$message = nl2br($message);

	$customer = new ModelCustomer($config);
	$customer->set_id($_SESSION['user']['id']);

	$data = $customer->getCustomerInfosFromId();

	// Verify message
	if ($message === '' OR empty($message))
	{
		throw new Exception('Veuillez remplir le message.');
	}

	if (!preg_match('/^[\p{L}\s-[:punct:]]{2,}$/u', $message))
	{
		throw new Exception('Le format du message n\'est pas valide.');
	}

	$date = date("Y-m-d H:i:s");

	// Save the message
	$messages = new ModelMessage($config);
	$messages->set_type('contact');
	$messages->set_title($title);
	$messages->set_message($message);
	$messages->set_date($date);
	$messages->set_previous($latestid);
	$messages->set_customer($_SESSION['user']['id']);
	$messages->set_employee(NULL);

	if ($messages->saveNewMessage())
	{
		$_SESSION['user']['sendreply'] = 1;
		header('Location: index.php?do=viewmessage&id=' . $id);
	}
}

?>