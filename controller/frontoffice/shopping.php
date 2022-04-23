<?php

/**
 * Displays the cart page.
 *
 * @return void
 */
function viewCart()
{
	// We generate HTML code from the view
	require_once(DIR . '/view/frontoffice/ViewShopping.php');
	ViewShopping::DisplayCart();
}

?>