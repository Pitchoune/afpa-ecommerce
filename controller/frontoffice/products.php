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
function searchResults($query, $category)
{
	// Verify query
	if ($query === '')
	{
		throw new Exception('La requête de recherche est vide.');
	}

	if (!preg_match('/^[\p{L}\s]{2,}$/', trim($query)))
	{
		throw new Exception('La requête de recherche contient des caractères non valides.');
	}

	if (intval($category) === false)
	{
		throw new Exception('La catégorie sélectionnée n\'est pas correcte.');
	}

	$query = trim($query);
	$category = intval($category);

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewProduct.php');
	ViewProduct::SearchResults($query, $category);
}

?>