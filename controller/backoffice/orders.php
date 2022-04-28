<?php

use \Ecommerce\Model\ModelOrders;

/**
 * Lists all orders.
 *
 * @return void
 */
function ListOrders()
{
	require_once(DIR . '/view/backoffice/ViewOrders.php');
	ViewOrder::OrdersList();
}

?>