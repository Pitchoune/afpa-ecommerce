<?php

use \Ecommerce\Model\ModelProduct;

/**
 * Lists all products
 *
 * @return void
 */
function listProducts()
{
	if (Utils::cando(23))
	{
		require_once(DIR . '/view/backoffice/ViewProduct.php');
		ViewProduct::ProductList();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des produits.');
	}
}

/**
 * Displays a form to add a new product.
 *
 * @return void
 */
function AddProduct()
{
	if (Utils::cando(24))
	{
		require_once(DIR . '/view/backoffice/ViewProduct.php');
		ViewProduct::ProductAddEdit();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}
}

/**
 * Inserts a new product into the database.
 *
 * @param string $name Name of the product.
 * @param string $parentcategory ID of the parent. Can be -1 if the category is at root level.
 * @param string $status Status ID of the status. It's saved in the db in an enum, so a string is required between 0 and 1.
 *
 * @return void
 */
function InsertProduct($name, $ref, $description, $quantity, $price, $category, $trademark)
{
	if (Utils::cando(24))
	{
		global $config;

		require_once(DIR . '/model/ModelProduct.php');
		$products = new \Ecommerce\Model\ModelProduct($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('L\'intitulé est vide.');
		}

		// Verify ref
		if ($ref === '')
		{
			throw new Exception('La référence est vide.');
		}

		// Verify description
		if ($description === '')
		{
			throw new Exception('La description est vide.');
		}

		// Verify quantity
		if ($quantity === '')
		{
			throw new Exception('La quantité est vide.');
		}

		// Verify price
		if ($price === '')
		{
			throw new Exception('Le prix est vide.');
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

		$products->set_name($name);
		$products->set_ref($ref);
		$products->set_description($description);
		$products->set_quantity($quantity);
		$products->set_price($price);
		$products->set_category($category);
		$products->set_trademark($trademark);

		if (Utils::cando(16))
		{
			// Do the file upload
			if ($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4)
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

		// Save is correctly done, redirects to the product list
		header('Location: index.php?do=listproducts');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}
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
	if (Utils::cando(25))
	{
		require_once(DIR . '/view/backoffice/ViewProduct.php');
		ViewProduct::ProductAddEdit($id);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des produits.');
	}
}

/**
 * Inserts a new product into the database.
 *
 *
 * @return void
 */
function UpdateProduct($id, $name, $ref, $description, $quantity, $price, $category, $trademark)
{
	if (Utils::cando(25))
	{
		global $config;

		require_once(DIR . '/model/ModelProduct.php');
		$products = new \Ecommerce\Model\ModelProduct($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('L\'intitulé est vide.');
		}

		// Verify ref
		if ($ref === '')
		{
			throw new Exception('La référence est vide.');
		}

		// Verify description
		if ($description === '')
		{
			throw new Exception('La description est vide.');
		}

		// Verify quantity
		if ($quantity === '')
		{
			throw new Exception('La quantité est vide.');
		}

		// Verify price
		if ($price === '')
		{
			throw new Exception('Le prix est vide.');
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
			// Do the file upload
			if ($_FILES['file']['error'] >= 0 AND $_FILES['file']['error'] != 4)
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

		// Save is correctly done, redirects to the product list
		header('Location: index.php?do=listproducts');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des produits.');
	}
}

/**
 * Deletes the given product.
 *
 * @param integer $id ID of the product to delete.
 *
 * @return void
 */
function DeleteProduct($id)
{
	if (Utils::cando(27))
	{
		global $config;

		require_once(DIR . '/model/ModelProduct.php');
		$products = new \Ecommerce\Model\ModelProduct($config);

		$products->set_id($id);

		// Delete the file first
		$productinfo = $products->listProductInfosFromId();
		$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . productinfo['photo'];
		unlink($targetFile);

		if ($products->deleteProduct())
		{
			$_SESSION['product']['delete'] = 1;
		}

		// Save is correctly done, redirects to the products list
		header('Location: index.php?do=listproducts');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des produits.');
	}
}

?>