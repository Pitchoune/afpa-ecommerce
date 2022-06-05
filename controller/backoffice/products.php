<?php

require_once(DIR . '/view/backoffice/ViewProduct.php');
require_once(DIR . '/model/ModelCategory.php');
require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelCategory;
use \Ecommerce\Model\ModelProduct;
use \Ecommerce\Model\ModelTrademark;

/**
 * Lists all products
 *
 * @return void
 */
function listProducts()
{
	if (!Utils::cando(23))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des produits.');
		}

	global $config, $pagenumber;

	$products = new ModelProduct($config);
	$totalproducts = $products->getTotalNumberOfProducts();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totalproducts['nbproducts'], $pagenumber, $perpage);

	$productlist = $products->getSomeProducts($limitlower, $perpage);

	ViewProduct::ProductList($products, $productlist, $totalproducts, $limitlower, $perpage);
}

/**
 * Displays a form to add a new product.
 *
 * @return void
 */
function AddProduct()
{
	if (!Utils::cando(24))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}

	global $config;

	$products = new ModelProduct($config);

	$productinfos = [
		'nom' => '',
		'ref' => '',
		'description' => '',
		'quantity' => '',
		'price' => '',
		'file' => '',
		'category' => ''
	];

	$pagetitle = 'Gestion des produits';
	$navtitle = 'Ajouter un produit';
	$formredirect = 'insertproduct';

	$navbits = [
		'index.php?do=listproducts' => $pagetitle,
		'' => $navtitle
	];

	// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
	$categories = new ModelCategory($config);

	$categorieslist = $categories->listAllCategories();

	if (!$categorieslist)
	{
		throw new Exception('Il n\'y a pas de catégorie. Veuillez ajouter une catégorie pour pouvoir ajouter un produit.');
	}

	$cache = Utils::categoriesCache($categorieslist);
	$categorylist = Utils::constructCategoryChooserOptions($cache);
	$catlist = Utils::constructCategorySelectOptions($categorylist, $productinfos['category']);

	// Grab all existing trademarks
	$trademarks = new ModelTrademark($config);
	$trademarkslist = $trademarks->listAllTrademarks();

	ViewProduct::ProductAddEdit($navtitle, $navbits, $productinfos, $formredirect, $pagetitle, $catlist, $trademarkslist);
}

/**
 * Inserts a new product into the database.
 *
 * @param string $name Name of the product.
 * @param string $ref Reference of the product.
 * @param string $description Description of the product.
 * @param integer $quantity Quantity of the product.
 * @param string $price Price of the product.
 * @param integer $category Category of the product.
 * @param integer $trademark Trademark of the product.
 *
 * @return void
 */
function InsertProduct($name, $ref, $description, $quantity, $price, $category, $trademark)
{
	if (!Utils::cando(24))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}

	$name = trim(strval($name));
	$ref = trim(strval($ref));
	$description = trim(strval($description));
	$quantity = intval($quantity);
	$price = trim(strval($price));
	$category = intval($category);
	$trademark = intval($trademark);

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate ref
	$validmessage = Utils::datavalidation($ref, 'ref', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate description
	$validmessage = Utils::datavalidation($description, 'description', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate quantity
	$validmessage = Utils::datavalidation($quantity, 'quantity');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate price
	$validmessage = Utils::datavalidation($price, 'price', 'Vous ne pouvez mettre qu\'un prix à 5 chiffres avec un point et 2 chiffres après.');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate category
	if ($category === '' OR $category === 0)
	{
		throw new Exception('La catégorie est vide.');
	}

	// Validate trademark
	if ($trademark === '' OR $trademark === 0)
	{
		throw new Exception('La marque est vide.');
	}

	global $config;

	$products = new ModelProduct($config);
	$products->set_name($name);
	$products->set_ref($ref);
	$products->set_description($description);
	$products->set_quantity($quantity);
	$products->set_price($price);
	$products->set_category($category);
	$products->set_trademark($trademark);

	if (Utils::cando(16))
	{
		// $_FILES validation
		if (is_array($_FILES['file']))
		{
			if (is_array($_FILES['file']['name']))
			{
				$files = count($_FILES['file']['name']);

				for ($index = 0; $index < $files; $index++)
				{
					$_FILES['file']['name']["$index"] = trim(strval($_FILES['file']['name']["$index"]));
					$_FILES['file']['type']["$index"] = trim(strval($_FILES['file']['type']["$index"]));
					$_FILES['file']['tmp_name']["$index"] = trim(strval($_FILES['file']['tmp_name']["$index"]));
					$_FILES['file']['error']["$index"] = intval($_FILES['file']['error']["$index"]);
					$_FILES['file']['size']["$index"] = intval($_FILES['file']['size']["$index"]);
				}
			}
			else
			{
				$_FILES['name'] = trim(strval($_FILES['name']));
				$_FILES['type'] = trim(strval($_FILES['type']));
				$_FILES['tmp_name'] = trim(strval($_FILES['tmp_name']));
				$_FILES['error'] = intval($_FILES['error']);
				$_FILES['size'] = intval($_FILES['size']);
			}
		}

		// Do the file upload
		if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
		{
			// Specify the allowed extensions list
			$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];
			require_once(DIR . '/controller/Utils.php');

			// Do the upload
			$upload = Utils::upload($extensions, $_FILES['file'], 'products');

			// Do some last stuff if the upload is correctly done
			if ($upload)
			{
				// Save the filename in the database
				$products->set_photo($upload);

				// Save the product in the database
				if ($products->saveNewProductWithPictures())
				{
					$_SESSION['product']['add'] = 1;
				}
			}
			else
			{
				throw new Exception('Une erreur inattendue est survenue pendant l\'upload. Veuillez recommancer.');
			}
		}
		else
		{
			// Save the product in the database
			if ($products->saveNewProductWithoutPictures())
			{
				$_SESSION['product']['add'] = 1;
			}
		}
	}
	else
	{
		// Save the product in the database
		if ($products->saveNewProductWithoutPictures())
		{
			$_SESSION['product']['add'] = 1;
		}
	}

	header('Location: index.php?do=listproducts');
}

/**
 * Displays a form to edit a product.
 *
 * @param integer $id ID of the product to edit.
 *
 * @return void
 */
function EditProduct($id)
{
	if (!Utils::cando(25))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des produits.');
	}

	$id = intval($id);

	global $config;

	$products = new ModelProduct($config);

	$products->set_id($id);
	$productinfos = $products->listProductInfosFromId();

	if (!$productinfos)
	{
		throw new Exception('Le produit n\'existe pas.');
	}

	$pagetitle = 'Gestion des produits';
	$navtitle = 'Modifier un produit';
	$formredirect = 'updateproduct';

	$navbits = [
		'index.php?do=listproducts' => $pagetitle,
		'' => $navtitle
	];

	// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
	$categories = new ModelCategory($config);

	$categorieslist = $categories->listAllCategories();
	$cache = Utils::categoriesCache($categorieslist);
	$categorylist = Utils::constructCategoryChooserOptions($cache);
	$catlist = Utils::constructCategorySelectOptions($categorylist, $productinfos['id_categorie']);

	// Grab all existing trademarks
	$trademarks = new ModelTrademark($config);
	$trademarkslist = $trademarks->listAllTrademarks();

	ViewProduct::ProductAddEdit($navtitle, $navbits, $productinfos, $formredirect, $pagetitle, $catlist, $trademarkslist, $id);
}

/**
 * Updates a product into the database.
 *
 * @param integer $id ID of the product.
 * @param string $name Name of the product.
 * @param string $ref Reference of the product.
 * @param string $description Description of the product.
 * @param integer $quantity Quantity of the product.
 * @param string $price Price of the product.
 * @param integer $category Category of the product.
 * @param integer $trademark Trademark of the product.
 *
 * @return void
 */
function UpdateProduct($id, $name, $ref, $description, $quantity, $price, $category, $trademark)
{
	if (!Utils::cando(25))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}

	$id = intval($id);
	$name = trim(strval($name));
	$ref = trim(strval($ref));
	$description = trim(strval($description));
	$quantity = intval($quantity);
	$price = trim(strval($price));
	$category = intval($category);
	$trademark = intval($trademark);

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate ref
	$validmessage = Utils::datavalidation($ref, 'ref', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate description
	$validmessage = Utils::datavalidation($description, 'description', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate quantity
	$validmessage = Utils::datavalidation($quantity, 'quantity');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate price
	$validmessage = Utils::datavalidation($price, 'price', 'Vous ne pouvez mettre qu\'un prix à 5 chiffres avec un point et 2 chiffres après.');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Verify category
	if ($category === '' OR $category === 0)
	{
		throw new Exception('La catégorie est vide.');
	}

	// Verify trademark
	if ($trademark === '' OR $trademark === 0)
	{
		throw new Exception('La marque est vide.');
	}

	global $config;

	$products = new ModelProduct($config);
	$products->set_id($id);
	$products->set_name($name);
	$products->set_ref($ref);
	$products->set_description($description);
	$products->set_quantity($quantity);
	$products->set_price($price);
	$products->set_category($category);
	$products->set_trademark($trademark);

	if (Utils::cando(16))
	{
		// $_FILES validation
		if (is_array($_FILES['file']))
		{
			if (is_array($_FILES['file']['name']))
			{
				$files = count($_FILES['file']['name']);

				for ($index = 0; $index < $files; $index++)
				{
					$_FILES['file']['name']["$index"] = trim(strval($_FILES['file']['name']["$index"]));
					$_FILES['file']['type']["$index"] = trim(strval($_FILES['file']['type']["$index"]));
					$_FILES['file']['tmp_name']["$index"] = trim(strval($_FILES['file']['tmp_name']["$index"]));
					$_FILES['file']['error']["$index"] = intval($_FILES['file']['error']["$index"]);
					$_FILES['file']['size']["$index"] = intval($_FILES['file']['size']["$index"]);
				}
			}
			else
			{
				$_FILES['name'] = trim(strval($_FILES['name']));
				$_FILES['type'] = trim(strval($_FILES['type']));
				$_FILES['tmp_name'] = trim(strval($_FILES['tmp_name']));
				$_FILES['error'] = intval($_FILES['error']);
				$_FILES['size'] = intval($_FILES['size']);
			}
		}

		// Do the file upload
		if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
		{
			// Specify the allowed extensions list
			$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];

			// Do the upload
			$upload = Utils::upload($extensions, $_FILES['file'], 'products');

			// Do some last stuff if the upload is correctly done
			if ($upload)
			{
				// Save the filename in the database
				$products->set_photo($upload);

				// Save the product in the database
				if ($products->saveEditProductWithPictures())
				{
					$_SESSION['product']['edit'] = 1;
				}
			}
			else
			{
				throw new Exception('Une erreur inattendue est survenue pendant l\'upload. Veuillez recommancer.');
			}
		}
		else
		{
			// Save the product in the database
			if ($products->saveEditProductWithoutPictures())
			{
				$_SESSION['product']['edit'] = 1;
			}
		}
	}
	else
	{
		// Save the product in the database
		if ($products->saveEditProductWithoutPictures())
		{
			$_SESSION['product']['edit'] = 1;
		}
	}

	header('Location: index.php?do=listproducts');
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the product to delete.
 *
 * @return void
 */
function DeleteProduct($id)
{
	if (!Utils::cando(27))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des produits.');
	}

	$id = intval($id);

	global $config;

	$products = new ModelProduct($config);
	$products->set_id($id);
	$product = $products->listProductInfosFromId();

	if (!$product)
	{
		throw new Exception('Le produit n\'existe pas.');
	}

	ViewProduct::ProductDeleteConfirmation($id, $product);
}

/**
 * Deletes the given product.
 *
 * @param integer $id ID of the product to delete.
 *
 * @return void
 */
function KillProduct($id)
{
	if (!Utils::cando(27))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des produits.');
	}

	$id = intval($id);

	global $config;

	$products = new ModelProduct($config);
	$products->set_id($id);
	$productinfo = $products->listProductInfosFromId();

	if (!$product)
	{
		throw new Exception('Le produit n\'existe pas.');
	}

	$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . productinfo['photo'];
	unlink($targetFile);

	if ($products->deleteProduct())
	{
		$_SESSION['product']['delete'] = 1;
		header('Location: index.php?do=listproducts');
	}
}

?>
