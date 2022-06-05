<?php

require_once(DIR . '/model/ModelCategory.php');
require_once(DIR . '/model/ModelProduct.php');
use \Ecommerce\Model\ModelCategory;
use \Ecommerce\Model\ModelProduct;

/**
 * Displays the selected category page.
 *
 * @param integer $id ID of the category.
 * @param integer $perpage Number of items per page.
 * @param string $sortby Sort direction of items list.
 *
 * @return void
 */
function viewCategory($id, $perpage, $sortby)
{
    $id = intval($id);
    $perpage = intval($perpage);
    $sortby = trim(strval(array_search($sortby, ['asc', 'desc'])));

    global $config, $pagenumber;

    $categories = new ModelCategory($config);
    $categories->set_id($id);
    $category = $categories->listCategoryInfos();

    // Category found, displays products
    $pagetitle = 'Visualisation de la catégorie : « ' . $category['nom'] . ' »';

    $products = new ModelProduct($config);

    $address = '';

    $address .= ($perpage ? '&amp;pp=' . $perpage : '');
    $address .= ($sortby ? '&amp;sortby=' . $sortby : '');

    // Define only after $address default values for $perpage & $sortby
    // This will allow to fill them with default values in pagination urls.
    $perpage = ($perpage ? $perpage : 24);
    $sortby = ($sortby ? $sortby : 'asc');

    if ($category['parent_id'])
    {
        // parent found, we're on a child category, list only category products
        $products = new ModelProduct($config);
        $products->set_category($id);
        $totalproducts = $products->getTotalNumberOfProductsForSpecificCategory();

        $nbproducts = $totalproducts['nbproducts'];

        $limitlower = Utils::define_pagination_values($totalproducts['nbproducts'], $pagenumber, $perpage);

        $product = $products->getSomeProductsForSpecificCategory($limitlower, $perpage, strtoupper($sortby));

        // Construct the breadcrumb content
        $categories->set_id($category['parent_id']);
        $parentname = $categories->getParentName();

        $navbits['viewcategory&amp;id=' . $category['parent_id'] . $address] = $parentname['nom'];
    }
    else
    {
        // Parent category - grab data from child categories to list them all here
        $parentids = $categories->getChildCategoriesIds();

        $totalproducts = [];
        $total = [];
        $parentlist = [];

        // Add the sub-array value into a single array to get products
        // From this ID, get the total number of products
        // To create a final values of all products in all child categories.
        foreach ($parentids AS $key => $value)
        {
            $parentlist[] = $value['id'];
            $products->set_category($value['id']);
            $totalproducts[] = $products->getTotalNumberOfProductsForSpecificCategory();
        }

        // List of IDs to search products
        $categorieslist = implode(',', $parentlist);

        // Merge all number of products options together to have only one.
        foreach ($totalproducts AS $key => $array)
        {
            $total = array_merge_recursive($total, $array);
        }

        // Calculate all values in array to have one final value.
        $nbproducts = (array_sum($total['nbproducts']));

        $limitlower = Utils::define_pagination_values($nbproducts, $pagenumber, $perpage);

        $product = $products->getSomeProductsForSpecificCategories($categorieslist, $limitlower, $perpage, strtoupper($sortby));
    }

    $navbits['viewcategory&amp;id=' . $category['id'] . $address] = $category['nom'];

	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewCategory.php');
	ViewCategory::DisplayCategory($pagetitle, $navbits, $category, $product, $nbproducts, $address, $perpage, $sortby);
}

?>
