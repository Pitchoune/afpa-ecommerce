<?php

require_once(DIR . '/view/frontoffice/ViewSearch.php');
require_once(DIR . '/model/ModelProduct.php');
use \Ecommerce\Model\ModelProduct;

/**
 * Displays the advanced search page.
 *
 * @return void
 */
function AdvancedSearch()
{
    $pagetitle = 'Recherche avancée';

    $navbits = [];
    $navbits['advancedsearch'] = $pagetitle;
	ViewSearch::DisplayAdvSearch($pagetitle, $navbits);
}

/**
 * Displays the search results.
 *
 * @param string $product Product search.
 * @param integer $perpage Number of items per page.
 * @param string $sortby Sort direction of items list.
 * @param boolean $description Search in descriptions?
 * @param string $reference Reference search.
 * @param integer $category Category to search.
 * @param integer $pricemin Minimum price to search.
 * @param integer $pricemax Maximum price to search.
 * @param array $trademark Array of checked trademarks.
 *
 * @return void
 */
function SearchResults($product, $perpage, $sortby, $description = '', $reference = '', $category = '', $pricemin = '', $pricemax = '', $trademark = '')
{
    $product = trim(strval($product));
    $description = trim(strval($description));
    $reference = trim(strval($reference));
    $category = intval($category);
    $pricemin = intval($pricemin);
    $pricemax = intval($pricemax);

    // Validate product
    $validmessage = Utils::datavalidation($product, 'product', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

    if ($validmessage)
    {
        throw new Exception($validmessage);
    }

    // Validate description
    $validmessage = Utils::datavalidation($description, 'description', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- _ ~ - ! @ # : " \' = . , ; $ % ^ & * ( ) [ ] &lt; &gt;', '', true);

    if ($validmessage)
    {
        throw new Exception($validmessage);
    }

    // Validate reference
    $validmessage = Utils::datavalidation($reference, 'ref', '', '', true); // Not mandatory to search, product is the minimum

    if ($validmessage)
    {
        throw new Exception($validmessage);
    }

    // Validate price min
    $validmessage = Utils::datavalidation($pricemin, 'pricemin', '', '', true); // Being able to pass pricemin as 0

    if ($validmessage)
    {
        throw new Exception($validmessage);
    }

    // Validate price max
    $validmessage = Utils::datavalidation($pricemax, 'pricemax');

    if ($validmessage)
    {
        throw new Exception($validmessage);
    }

    $address = '';

    $address .= ($perpage ? '&amp;pp=' . $perpage : '');
    $address .= ($sortby ? '&amp;sortby=' . $sortby : '');

    // Define only after $address default values for $perpage & $sortby
    // This will allow to fill them with default values in pagination urls.
    $perpage = ($perpage ? $perpage : 24);
    $sortby = ($sortby ? $sortby : 'asc');

    global $config;

    $products = new ModelProduct($config);

    // Build the SQL part here
    // Not the best way but we can't do SQL "IN (x,y,z)" without having quotes around each integer value,
    // Making the query to fail to execute (don't find anything while not having the quotes works)
    // Would be better to not use PDO and works with oriented-object MySQL but oh well... Security stuff blah blah....
    // If you pass all values into intval() or mysqli_escape_string(), there is NO WAY to bypass security!
    $join = [];
    $join1 = '';
    $join2 = '';

    // Handle OR
    $joinquery1 = [];
    $joinquery1[] = 'nom LIKE \'%' . $product . '%\'';

    // Description
    if ($description)
    {
        $joinquery1[] = 'description LIKE \'%' . $product . '%\'';
    }

    // Reference
    if ($reference)
    {
        $joinquery1[] = 'ref LIKE \'%' . $reference . '%\'';
    }

    // Category
    if ($category)
    {
        $joinquery1[] = 'id_categorie = ' . $category;
    }

    $join1 = implode($joinquery1, ' OR ');

    // Handle AND
    $joinquery2 = [];

    // Price range
    $joinquery2[] = 'prix >= ' . $pricemin . ' AND prix <= ' . $pricemax;

    // Trademark
    if ($trademark)
    {
        // Even if trademark have its setter, as it's a list of ids and not an unique id, we can't use setter
        $trademark1 = implode($trademark, ',');
        $joinquery2[] = 'id_marque IN (' . $trademark1 . ')';
    }

    $join2 = implode($joinquery2, ' AND ');

    $join = $join1 . ' AND ' . $join2;

    $results = $products->getProductsFromSearch($join);

    $pagetitle = 'Résultats de la recherche';

    $navbits = [];
    $navbits['advancedsearch'] = $pagetitle;

    // Create URL arguments for pagination
    $pagination = '';

    $pagination .= ($product ? '&amp;product=' . $product : '');
    $pagination .= ($description ? '&amp;description=' . $description : '');
    $pagination .= ($reference ? '&amp;reference=' . $reference : '');
    $pagination .= ($category ? '&amp;category=' . $category : '');
    $pagination .= ($pricemin ? '&amp;price-min=' . $pricemin : '&amp;price-min=0'); // Price min is mandatory, force it if = 0
    $pagination .= ($pricemax ? '&amp;price-max=' . $pricemax : '');

    if ($trademark)
    {
        // Trademark is an array
        foreach ($trademark AS $key => $value)
        {
            $pagination .= '&amp;trademark%5B%5D=' . $value;
        }
    }

    ViewSearch::DisplayResults($pagetitle, $navbits, $results, $address, $perpage, $sortby, $pagination);
}

?>
