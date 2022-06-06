<?php

require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelTrademark.php');
require_once(DIR . '/model/ModelCategory.php');
require_once(DIR . '/view/frontoffice/ViewProduct.php');
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

	$id = intval($id);
	$ref = trim(strval($ref));

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
			if ($categoryinfos['parent_id'] !== '-1')
			{
				$categories->set_id($categoryinfos['parent_id']);
				$category = $categories->getParentName();

				$navbits['viewcategory&amp;id=' . $category['id'] . ''] = $category['nom'];
			}
		}

		$navbits['viewcategory&amp;id=' . $product['id_categorie']] = $product['category']; //
		$navbits['viewproduct&amp;id=' . $product['id']] = 'Produit « ' . $product['nom'] . ' »';
	}

	ViewProduct::DisplayProduct($pagetitle, $product, $trademark, $navbits);
}

/**
 * Does a search and returns results to the customer.
 *
 * @param string $query Customer query.
 * @param string $type Type of query: 'json' for predictive search, else nothing.
 *
 * @return void
 */
function searchResults($query, $type = '')
{
	$query = trim($query);
	$type = trim(strval($type));

	if ($type !== 'json')
	{
		// Validate query
		$validmessage = Utils::datavalidation($query, 'query', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- _ ~ - ! @ # : " \' = . , ; $ % ^ & * ( ) [ ]');

		if ($validmessage)
		{
			throw new Exception($validmessage);
		}
	}

	global $config;

	$products = new ModelProduct($config);
	$products->set_name($query);
	$products->set_ref($query);
	$products->set_description($query);
	$product = $products->searchProductsWithoutCategory();

	if ($type == 'json')
	{
		$encode = [];

		foreach ($product AS $key => $value)
		{
			$encode[$value['id']] = $value;
		}

		echo json_encode(array_values($encode));
	}
	else
	{
		ViewProduct::SearchResults($pagetitle, $product);
	}
}

?>
