<?php
session_start();

error_reporting(E_ALL & ~E_NOTICE);

// Sanitize do= values, others required per page are sanitized when necessary
$do = isset($_REQUEST['do']) ? filter_var($_REQUEST['do'], FILTER_SANITIZE_STRING) : NULL;
$pagenumber = isset($_REQUEST['page']) ? filter_var($_REQUEST['page'], FILTER_VALIDATE_INT) : NULL;

// If you're not logged-in, display only the login form
if (empty($_SESSION['employee']['loggedin']) AND !in_array($do, ['login', 'dologin']))
{
	$do = 'login';
}

if (empty($do) OR !isset($do))
{
	$do = 'index';
}

// Controller call - contains functions which do model work and return the view
require_once('../controller/backoffice.php');
require_once(DIR . '/view/backoffice/ViewTemplate.php');

// Utils::printr($_SESSION, 1);

// Request employee informations here to be used for any page if the employee is logged-in
if (isset($_SESSION['employee']['id']))
{
	require_once(DIR . '/model/ModelEmployee.php');
	$employees = new \Ecommerce\Model\ModelEmployee($config);
	$employees->set_id($_SESSION['employee']['id']);
	$employee = $employees->getEmployeeInfosFromId();
}

// We define which action to do and will search in the controller the called function
try
{
	switch($do)
	{
		case 'index':
			index();
			break;
		// Login/logout
		case 'login':
			login();
			break;
		case 'dologin':
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : NULL;
			$pass = isset($_POST['pass']) ? filter_var($_POST['pass'], FILTER_SANITIZE_STRING) : NULL;
			doLogin($email, $pass);
			exit;
		case 'logout':
			doLogout();
			break;
		// Roles
		case 'listroles':
			ListRoles();
			break;
		case 'addrole':
			AddRole();
			break;
		case 'insertrole':
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			InsertRole($name);
			break;
		case 'editrole':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditRole($id);
			break;
		case 'updaterole':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			UpdateRole($id, $name);
			exit;
		case 'updateroleperms':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$permissions = isset($_POST['permission']) ? filter_var_array($_POST['permission'], FILTER_VALIDATE_INT) : NULL;
			UpdateRolePerms($id, $permissions);
			break;
		case 'deleterole':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteRole($id);
			break;
		// Employees
		case 'listemployees':
			ListEmployees();
			break;
		case 'addemployee':
			AddEmployee();
			break;
		case 'insertemployee':
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$role = isset($_POST['role']) ? filter_var($_POST['role'], FILTER_VALIDATE_INT) : NULL;
			InsertEmployee($firstname, $lastname, $email, $password, $role);
			break;
		case 'editemployee':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditEmployee($id);
			break;
		case 'updateemployee':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$role = isset($_POST['role']) ? filter_var($_POST['role'], FILTER_VALIDATE_INT) : NULL;
			UpdateEmployee($id, $firstname, $lastname, $email, $password, $role);
			exit;
		case 'deleteemployee':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteEmployee($id);
			break;
		// Categories
		case 'listcategories':
			ListCategories();
			break;
		case 'addcategory':
			AddCategory();
			break;
		case 'insertcategory':
			$title = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : NULL;
			InsertCategory($title);
			exit;
		case 'editcategory':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditCategory($id);
			break;
		case 'updatecategory':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$title = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : NULL;
			UpdateCategory($id, $title);
			exit;
		case 'deletecategory':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteCategory($id);
			break;
		// Trademarks
		case 'listtrademarks':
			ListTrademarks();
			break;
		case 'addtrademark':
			AddTrademark();
			break;
		case 'inserttrademark':
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			InsertTrademark($name);
			break;
		case 'edittrademark':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditTrademark($id);
			break;
		case 'updatetrademark':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			UpdateTrademark($id, $name);
			break;
		case 'deletetrademark':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteTrademark($id);
			break;
		// Delivers
		case 'listdelivers':
			ListDelivers();
			break;
		case 'adddeliver':
			AddDeliver();
			break;
		case 'insertdeliver':
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			InsertDeliver($name);
			break;
		case 'editdeliver':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditDeliver($id);
			break;
		case 'updatedeliver':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			UpdateDeliver($id, $name);
			break;
		case 'deletedeliver':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteDeliver($id);
			break;
		// Products
		case 'listproducts':
			ListProducts();
			break;
		case 'addproduct':
			AddProduct();
			break;
		case 'insertproduct':
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			$ref = isset($_POST['ref']) ? filter_var($_POST['ref'], FILTER_SANITIZE_STRING) : NULL;
			$description = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;
			$quantity = isset($_POST['quantity']) ? filter_var($_POST['quantity'], FILTER_VALIDATE_INT) : NULL;
			$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_STRING) : NULL;
			$category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_VALIDATE_INT) : NULL;
			$trademark = isset($_POST['trademark']) ? filter_var($_POST['trademark'], FILTER_VALIDATE_INT) : NULL;
			InsertProduct($name, $ref, $description, $quantity, $price, $category, $trademark);
			break;
		case 'editproduct':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditProduct($id);
			break;
		case 'updateproduct':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : NULL;
			$ref = isset($_POST['ref']) ? filter_var($_POST['ref'], FILTER_SANITIZE_STRING) : NULL;
			$description = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;
			$quantity = isset($_POST['quantity']) ? filter_var($_POST['quantity'], FILTER_VALIDATE_INT) : NULL;
			$price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_STRING) : NULL;
			$category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_VALIDATE_INT) : NULL;
			$trademark = isset($_POST['trademark']) ? filter_var($_POST['trademark'], FILTER_VALIDATE_INT) : NULL;
			UpdateProduct($id, $name, $ref, $description, $quantity, $price, $category, $trademark);
			break;
		case 'deleteproduct':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteProduct($id);
			break;
		// Customers
		case 'listcustomers':
			ListCustomers();
			break;
		case 'addcustomer':
			AddCustomer();
			break;
		case 'insertcustomer':
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$telephone = isset($_POST['telephone']) ? filter_var($_POST['telephone'], FILTER_SANITIZE_STRING) : NULL;
			$address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_STRING) : NULL;
			$city = isset($_POST['city']) ? filter_var($_POST['city'], FILTER_SANITIZE_STRING) : NULL;
			$zipcode = isset($_POST['zipcode']) ? filter_var($_POST['zipcode'], FILTER_SANITIZE_STRING) : NULL;
			InsertCustomer($firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode);
			break;
		case 'editcustomer':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			EditCustomer($id);
			break;
		case 'updatecustomer':
			$id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : NULL;
			$firstname = isset($_POST['firstname']) ? filter_var($_POST['firstname'], FILTER_SANITIZE_STRING) : NULL;
			$lastname = isset($_POST['lastname']) ? filter_var($_POST['lastname'], FILTER_SANITIZE_STRING) : NULL;
			$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : NULL;
			$password = isset($_POST['password']) ? filter_var($_POST['password'], FILTER_SANITIZE_STRING) : NULL;
			$telephone = isset($_POST['telephone']) ? filter_var($_POST['telephone'], FILTER_SANITIZE_STRING) : NULL;
			$address = isset($_POST['address']) ? filter_var($_POST['address'], FILTER_SANITIZE_STRING) : NULL;
			$city = isset($_POST['city']) ? filter_var($_POST['city'], FILTER_SANITIZE_STRING) : NULL;
			$zipcode = isset($_POST['zipcode']) ? filter_var($_POST['zipcode'], FILTER_SANITIZE_STRING) : NULL;
			UpdateCustomer($id, $firstname, $lastname, $email, $password, $telephone, $address, $city, $zipcode);
			break;
		case 'deletecustomer':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			DeleteCustomer($id);
			break;
		case 'viewcustomerprofile':
			$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : NULL;
			ViewCustomerProfile($id);
			break;
	}
}
catch(Exception $e)
{
	$errorMessage = $e->getMessage();
	require_once(DIR . '/view/backoffice/ViewError.php');

	if ($do == 'dologin')
	{
		ViewError::DisplayLoggedOutError($errorMessage);
		exit;
	}
	else
	{
		ViewError::DisplayLoggedInError($errorMessage);
		exit;
	}
}

?>