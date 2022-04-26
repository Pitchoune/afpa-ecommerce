<?php

use \Ecommerce\Model\ModelProduct;

/**
 * Displays the selected product page.
 *
 * @param integer $id ID of the product.
 *
 * @return void
 */
function viewProduct($id = '', $ref = '')
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewProduct.php');
	ViewProduct::DisplayProduct($id, $ref);
}

/**
 * Does a search and returns results to the customer.
 *
 * @param string $query Customer query.
 * @param string $category ID of the category. '0' for all categories.
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

		require_once(DIR . '/model/ModelProduct.php');
		$products = new \Ecommerce\Model\ModelProduct($config);
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
		// We generate HTML code from the view
		require_once(DIR . '/view/frontoffice/ViewProduct.php');
		ViewProduct::SearchResults($query, $category);
	}
}

?>