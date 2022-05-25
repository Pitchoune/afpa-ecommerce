<?php

require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelTrademark.php');
require_once(DIR . '/model/ModelCategory.php');
use \Ecommerce\Model\ModelProduct;
use \Ecommerce\Model\ModelTrademark;
use \Ecommerce\Model\ModelCategory;

/**
 * Displays the selected product page.
 *
 * @param integer $id ID of the product.
 * @param string $ref Reference of the product.
 *
 * @return void
 */
function viewProduct($id = '', $ref = '')
{
	global $config;

	$products = new ModelProduct($config);

	if ($id)
	{
		$products->set_id($id);
		$product = $products->listProductInfosFromId();
	}
	else if ($ref)
	{
		$products->set_ref($ref);
		$product = $products->listProductInfosFromRef();
	}

	$pagetitle = 'Visualisation du produit : « ' . $product['nom'] . ' »';

	if ($product)
	{
		if (empty($product['photo']))
		{
			$product['photo'] = 'assets/images/nophoto.jpg';
		}
		else
		{
			$product['photo'] = 'attachments/products/' . $product['photo'];
		}

		$trademarks = new ModelTrademark($config);
		$trademarks->set_id($product['id_marque']);
		$trademark = $trademarks->listTrademarkInfos();

		$navbits = [];

		// Grab data for breadcrumb
		if ($product['id_categorie'])
		{
			// Get parent category name
			$categories = new ModelCategory($config);
			$categories->set_id($product['id_categorie']);
			$categoryinfos = $categories->listCategoryInfos();

			// Get the parent name only if there is a parent ID
			// No parent_id = product is in parent category
			if ($categoryinfos['parent_id'])
			{
				$categories->set_id($categoryinfos['parent_id']);
				$category = $categories->getParentName();

				$navbits['viewcategory&amp;id=' . $category['id'] . ''] = $category['nom'];
			}
		}

		$navbits['viewcategory&amp;id=' . $product['id_categorie']] = $product['category']; //
		$navbits['viewproduct&amp;id=' . $product['id']] = 'Produit « ' . $product['nom'] . ' »';
	}

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewProduct.php');
	ViewProduct::DisplayProduct($pagetitle, $product, $trademark, $navbits);
}

/**
 * Does a search and returns results to the customer.
 *
 * @param string $query Customer query.
 * @param string $category ID of the category. '0' for all categories.
 * @param string $type Type of query: 'json' for predictive search, else nothing.
 *
 * @return void
 */
function searchResults($query, $category, $type = '')
{
	// Verify query
	if ($query === '')
	{
		throw new Exception('La requête de recherche est vide.');
	}

	if ($type !== 'json')
	{
		if (!preg_match('/^[\p{L}\s]{2,}$/', $query))
		{
			throw new Exception('La requête de recherche contient des caractères non valides.');
		}
	}

	if (intval($category) === false)
	{
		throw new Exception('La catégorie sélectionnée n\'est pas correcte.');
	}

	$query = trim($query);
	$category = intval($category);

	if ($type == 'json')
	{
		global $config;


		$products = new ModelProduct($config);
		$products->set_name($query);
		$products->set_ref($query);
		$products->set_description($query);
		$product = $products->searchProductsWithoutCategory();

		$encode = [];

		foreach ($product AS $key => $value)
		{
			$encode[$value['id']] = $value;
		}

		echo json_encode(array_values($encode));
	}
	else
	{
		global $config;

		$pagetitle = 'Résultats de la recherche';

		$products = new ModelProduct($config);
		$products->set_name($query);
		$products->set_ref($query);
		$products->set_description($query);

		if ($category !== 0)
		{
			// Search in a specific category
			$products->set_category($category);
			$product = $products->searchProductsWithCategory();
		}
		else
		{
			// Search despite the category (in all categories)
			$product = $products->searchProductsWithoutCategory();
		}

		// We generate HTML code from the view
		require_once(DIR . '/view/frontoffice/ViewProduct.php');
		ViewProduct::SearchResults($pagetitle, $product);
	}
}

?>