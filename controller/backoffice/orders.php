<?php

require_once(DIR . '/view/backoffice/ViewOrders.php');
require_once(DIR . '/model/ModelOrder.php');
use \Ecommerce\Model\ModelOrder;

/**
 * Lists all orders.
 *
 * @return void
 */
function ListOrders()
{
    if (Utils::cando(35))
    {
        global $config, $pagenumber;

        $orders = new ModelOrder($config);
        $totalorders = $orders->getTotalNumberOfOrders();

        // Number max per page
        $perpage = 10;
        $limitlower = Utils::define_pagination_values($totalorders['nborders'], $pagenumber, $perpage);

        $orderlist = $orders->getAllOrders($limitlower, $perpage);

	    ViewOrder::OrdersList($orders, $orderlist, $totalorders, $limitlower, $perpage);
    }
    else
    {
        throw new Exception('Vous n\'êtes pas autorisé à affichier la liste des commandes.');
    }
}

?>