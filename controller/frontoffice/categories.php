<?php

use \Ecommerce\Model\ModelCustomer;

/**
 * Displays the selected category page.
 *
 * @param integer $id ID of the category.
 *
 * @return void
 */
function viewCategory($id = '')
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewCategory.php');
	ViewCategory::DisplayCategory($id);
}

?>