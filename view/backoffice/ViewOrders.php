<?php

require_once(DIR . '/model/ModelOrderDetails.php');
use \Ecommerce\Model\ModelOrderDetails;

/**
 * Class to display HTML content about orders in back.
 */
class ViewOrder
{
	/**
	 * Returns the HTML code to display the orders list.
	 *
	 * @param object $orders Model object of orders.
	 * @param array $orderlist List of all orders for the current page.
	 * @param array $totalorders Total number of orders in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function OrdersList($orders, $orderlist, $totalorders, $limitlower, $perpage)
	{
		global $config, $pagenumber;

		$pagetitle = 'Gestion des commandes';
		$navtitle = 'Liste des commandes';

		$navbits = [
			'index.php?do=listorders' => $pagetitle,
			'' => $navtitle
		];
		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead($pagetitle) ?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- body -->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
						<?php
						if ($orderlist)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- orders listing -->
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
							<!-- / orders listing -->

							<?php
						}
						else
						{
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>

							<!-- orders listing -->
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
							<!-- / orders listing -->
							<?php
						}
						?>
						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->

				</div>

				<?= ViewTemplate::BackFoot() ?>
			</body>
		</html>

		<?php
	}
}

?>
