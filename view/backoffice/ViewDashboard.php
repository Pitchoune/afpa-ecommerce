<?php

require_once(DIR . '/model/ModelMessage.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
use \Ecommerce\Model\ModelMessage;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;

/**
 * Class to display HTML content about dashboard in back.
 */
class ViewDashboard
{
	/**
	 * Returns the HTML code to display the dashboard.
	 *
	 * @return void
	 */
	public static function DisplayDashboard()
	{
		global $config;

		$pagetitle = 'Tableau de bord';
		$navbits = [
			'' => $pagetitle
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
							<?= ViewTemplate::Breadcrumb($pagetitle, $navbits) ?>

							<!-- dashboard -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-6 xl-100">
										<div class="card height-equal">
											<div class="card-header">
												<h5>Activité des commandes</h5>
											</div>
											<div class="card-body">
												<div class="order-timeline">
													<?php
													$messages = new ModelMessage($config);
													$messages->set_type('notif');
													$messagelist = $messages->getAllMessagesFromType();

													foreach ($messagelist AS $key => $value)
													{
														?>
														<div class="media">
															<div class="timeline-line"></div>
															<div class="timeline-icon-primary">
																<i data-feather="map-pin"></i>
															</div>
															<div class="media-body">
																<span class="font-primary"><?= $value['message'] ?></span>
															</div>
														</div>
														<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 xl-100">
										<div class="card">
											<div class="card-header">
												<h5>Dernières commandes</h5>
											</div>
											<div class="card-body">
												<div class="user-status table-responsive latest-order-table">
													<table class="table table-bordernone">
														<thead>
														<tr>
															<th scope="col">Commande #</th>
															<th scope="col">Total</th>
															<th scope="col">Moyen de paiement</th>
															<th scope="col">État</th>
														</tr>
														</thead>
														<tbody>
														<?php
														$orders = new ModelOrder($config);
														$orderlist = $orders->getLatestOrders();

														foreach ($orderlist AS $key => $value)
														{
															$orderdetails = new ModelOrderDetails($config);
															$orderdetails->set_order($value['id']);
															$orderdetail = $orderdetails->getOrderDetails();
															$total = 0;

															foreach ($orderdetail AS $key2 => $value2)
															{
																$total += ($value2['prix'] * $value2['quantite']);
															}
															?>
															<tr>
																<td><?= $value['id'] ?></td>
																<td class="digits"><?= number_format($total, 2) ?> &euro;</td>
																<td class="font-primary">Carte bancaire</td>
																<td class="digits"><?= $value['etat'] ?></td>
															</tr>
															<?php
														}
														?>
														</tbody>
													</table>
													<a href="index.php?do=listorders" class="btn btn-primary">Voir toutes les commandes</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / dashboard -->
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
