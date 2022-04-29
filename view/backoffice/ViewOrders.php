<?php

require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;

/**
 * Class to display HTML content about dashboard in back.
 *
 * @date $Date$
 */
class ViewOrder
{
	/**
	 * Returns the HTML code to display the dashboard.
	 *
	 * @return void
	 */
	public static function OrdersList()
	{
		global $config, $pagenumber;

		$pagetitle = 'Gestion des commandes';
		$navtitle = 'Liste des commandes';

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
			'' => $navtitle
		];

		$orders = new ModelOrder($config);
		$totalorders = $orders->getTotalNumberOfOrders();

		// Number max per page
		$perpage = 10;

		Utils::sanitize_pageresults($totalorders['nborders'], $pagenumber, $perpage, 200, 20);

		$limitlower = ($pagenumber - 1) * $perpage;
		$limitupper = ($pagenumber) * $perpage;

		if ($limitupper > $totalorders['nborders'])
		{
			$limitupper = $totalorders['nborders'];

			if ($limitlower > $totalorders['nborders'])
			{
				$limitlower = ($totalorders['nborders'] - $perpage) - 1;
			}
		}

		if ($limitlower < 0)
		{
			$limitlower = 0;
		}

		$orderlist = $orders->getAllOrders($limitlower, $perpage);

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php
				ViewTemplate::BackHead($pagetitle);
				?>
			</head>

			<body>
				<div class="page-wrapper">

					<!-- Page Header Start-->
					<?php
					ViewTemplate::BackHeader();
					?>
					<!-- Page Header Ends -->

					<!-- Page Body Start-->
					<div class="page-body-wrapper">

						<!-- Page Sidebar Start-->
						<?php
						ViewTemplate::Sidebar();
						?>
						<!-- Page Sidebar Ends-->

						<div class="page-body">
						<?php
						if ($orderlist)
						{
							?>
							<!-- Container-fluid starts-->
							<?php
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<div class="table-responsive">
													<div class="tablegrid">
														<div class="tablegrid-grid-header">
															<table class="tablegrid-table">
																<thead>
																	<tr class="tablegrid-header-row">
																		<th class="tablegrid-header-cell" style="width: 125px">Commande #</th>
																		<th class="tablegrid-header-cell" style="width: 75px">Total</th>
																		<th class="tablegrid-header-cell" style="width: 75px">État</th>
																		<th class="tablegrid-header-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">Actions</th>
																	</tr>
																</thead>
															</table>
														</div>
														<div class="tablegrid-grid-body">
															<table class="tablegrid-table">
																<tbody>
																	<?php
																	// Get the number of orders returned by the model for background lines
																	$quantity = count($orderlist);

																	foreach ($orderlist AS $key => $value)
																	{
																		$orderdetails = new ModelOrderDetails($config);
																		$orderdetails->set_order($value['id']);
																		$details = $orderdetails->getOrderDetails();

																		$totalprice = 0;

																		foreach ($details AS $key2 => $value2)
																		{
																			$totalprice += ($value2['quantite'] * $value2['prix']);
																		}

																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																			<td class="tablegrid-cell" style="width: 125px"><?= $value['id'] ?></td>
																			<td class="tablegrid-cell" style="width: 75px"><?= number_format($totalprice, 2) ?> &euro;</td>
																			<td class="tablegrid-cell" style="width: 75px"><?= $value['etat'] ?></td>
																			<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																				<a class="tablegrid-button tablegrid-search-button" type="button" title="Modifier" href="index.php?do=viewcustomerorderdetails&amp;id=<?= $value['id'] ?>"></a>
																			</td>
																		</tr>
																		<?php
																	}
																	?>
																</tbody>
															</table>
														</div>
														<?php
														Utils::construct_page_nav($pagenumber, $perpage, $totalorders['nborders'], 'index.php?do=listorders', 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						else
						{
							?>
							<!-- Container-fluid starts-->
							<?php
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>
							<!-- Container-fluid ends-->

							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5>Liste des commandes</h5>
											</div>
											<div class="card-body">
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de commande.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>

						</div>

						<!-- footer start-->
						<?php
						ViewTemplate::BackFooter();
						?>
						<!-- footer end-->
					</div>


				</div>
				<!-- latest jquery-->
				<script src="../assets/js/jquery-3.5.1.min.js"></script>

				<!-- Bootstrap js-->
				<script src="../assets/js/popper.min.js"></script>
				<script src="../assets/js/bootstrap.js"></script>

				<!-- feather icon js-->
				<script src="../assets/js/icons/feather-icon/feather.min.js"></script>
				<script src="../assets/js/icons/feather-icon/feather-icon.js"></script>

				<!-- Sidebar jquery-->
				<script src="../assets/js/sidebar-menu.js"></script>
				<script src="../assets/js/slick.js"></script>

				<!--script admin-->
				<script src="../assets/js/admin-script.js"></script>
			</body>
		</html>

		<?php
	}
}

?>
