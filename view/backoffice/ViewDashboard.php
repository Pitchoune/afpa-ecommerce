<?php

/**
 * Class to display HTML content about dashboard in back.
 *
 * @date $Date$
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

							<!-- Container-fluid starts-->
							<?php
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>
							<!-- Container-fluid ends-->
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-3 col-md-6 xl-50">
										<div class="card o-hidden  widget-cards">
											<div class="bg-secondary card-body">
												<div class="media static-top-widget">
													<div class="media-body"><span class="m-0">Products</span>
														<h3 class="mb-0">$ <span class="counter">9856</span><small> This Month</small></h3>
													</div>
													<div class="icons-widgets">
														<i data-feather="box"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 xl-50">
										<div class="card o-hidden widget-cards">
											<div class="bg-primary card-body">
												<div class="media static-top-widget">
													<div class="media-body"><span class="m-0">Messages</span>
														<h3 class="mb-0">$ <span class="counter">893</span><small> This Month</small></h3>
													</div>
													<div class="icons-widgets">
														<i data-feather="message-square"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 xl-50">
										<div class="card o-hidden widget-cards">
											<div class="bg-warning card-body">
												<div class="media static-top-widget">
													<div class="media-body"><span class="m-0">Earnings</span>
														<h3 class="mb-0">$ <span class="counter">6659</span><small> This Month</small></h3>
													</div>
													<div class="icons-widgets">
														<i data-feather="navigation"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-6 xl-50">
										<div class="card o-hidden widget-cards">
											<div class="bg-success card-body">
												<div class="media static-top-widget">
													<div class="media-body"><span class="m-0">New Vendors</span>
														<h3 class="mb-0">$ <span class="counter">45631</span><small> This Month</small></h3>
													</div>
													<div class="icons-widgets">
														<i data-feather="users"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-4 xl-100">
										<div class="card height-equal">
											<div class="card-header">
												<h5>Activité des commandes</h5>
											</div>
											<div class="card-body">
												<div class="order-timeline">
													<?php
													require_once(DIR . '/model/ModelMessage.php');
													$messages = new \Ecommerce\Model\ModelMessage($config);
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
									<div class="col-xl-8 xl-100">
										<div class="card btn-months">
											<div class="card-header">
												<h5>This Month Revenue</h5>
											</div>
											<div class="card-body">
												<div class="revenue-chart"></div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 xl-100">
										<div class="card">
											<div class="card-header">
												<h5>Product Value</h5>
												<div class="card-header-right">
													<ul class="list-unstyled card-option">
														<li><i class="icofont icofont-simple-left"></i></li>
														<li><i class="view-html fa fa-code"></i></li>
														<li><i class="icofont icofont-maximize full-card"></i></li>
														<li><i class="icofont icofont-minus minimize-card"></i></li>
														<li><i class="icofont icofont-refresh reload-card"></i></li>
														<li><i class="icofont icofont-error close-card"></i></li>
													</ul>
												</div>
											</div>
											<div class="card-body">
												<div class="market-chart"></div>
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
														require_once(DIR . '/model/ModelOrder.php');
														$orders = new \Ecommerce\Model\ModelOrder($config);
														$orderlist = $orders->getLatestOrders();

														foreach ($orderlist AS $key => $value)
														{
															require_once(DIR . '/model/ModelOrderDetails.php');
															$orderdetails = new \Ecommerce\Model\ModelOrderDetails($config);
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
													<a href="order.html" class="btn btn-primary">View All Orders</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="card btn-months">
											<div class="card-header">
												<h5>Buy / Sell</h5>
											</div>
											<div class="card-body sell-graph">
												<div class="flot-chart-placeholder" id="multiple-real-timeupdate"></div>
											</div>
										</div>
									</div>
									<div class="col-xl-4 xl-50">
										<div class="card customers-card">
											<div class="card-header">
												<h5>New Customers</h5>
												<div class="chart-value-box pull-right">
													<div class="value-square-box-secondary"></div><span class="f-12 f-w-600">Customers</span>
												</div>
											</div>
											<div class="card-body p-0">
												<div class="apex-chart-container">
													<div id="customers"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-8 xl-50">
										<div class="card height-equal">
											<div class="card-header">
												<h5>Employee Status</h5>
											</div>
											<div class="card-body">
												<div class="user-status table-responsive products-table">
													<table class="table table-bordernone mb-0">
														<thead>
														<tr>
															<th scope="col">Name</th>
															<th scope="col">Designation</th>
															<th scope="col">Skill Level</th>
															<th scope="col">Experience</th>
														</tr>
														</thead>
														<tbody>
														<tr>
															<td class="bd-t-none u-s-tb">
																<div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="../assets/images/dashboard/user2.jpg" alt="" data-original-title="" title="">
																	<div class="d-inline-block">
																		<h6>John Deo <span class="text-muted digits">(14+ Online)</span></h6>
																	</div>
																</div>
															</td>
															<td>Designer</td>
															<td>
																<div class="progress-showcase">
																	<div class="progress" style="height: 8px;">
																		<div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															<td class="digits">2 Year</td>
														</tr>
														<tr>
															<td class="bd-t-none u-s-tb">
																<div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="../assets/images/dashboard/man.png" alt="" data-original-title="" title="">
																	<div class="d-inline-block">
																		<h6>Mohsib lara<span class="text-muted digits">(99+ Online)</span></h6>
																	</div>
																</div>
															</td>
															<td>Tester</td>
															<td>
																<div class="progress-showcase">
																	<div class="progress" style="height: 8px;">
																		<div class="progress-bar bg-primary" role="progressbar" style="width: 60%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															<td class="digits">5 Month</td>
														</tr>
														<tr>
															<td class="bd-t-none u-s-tb">
																<div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="../assets/images/dashboard/user.png" alt="" data-original-title="" title="">
																	<div class="d-inline-block">
																		<h6>Hileri Soli <span class="text-muted digits">(150+ Online)</span></h6>
																	</div>
																</div>
															</td>
															<td>Designer</td>
															<td>
																<div class="progress-showcase">
																	<div class="progress" style="height: 8px;">
																		<div class="progress-bar bg-secondary" role="progressbar" style="width: 30%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															<td class="digits">3 Month</td>
														</tr>
														<tr>
															<td class="bd-t-none u-s-tb">
																<div class="align-middle image-sm-size"><img class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded" src="../assets/images/dashboard/designer.jpg" alt="" data-original-title="" title="">
																	<div class="d-inline-block">
																		<h6>Pusiz bia <span class="text-muted digits">(14+ Online)</span></h6>
																	</div>
																</div>
															</td>
															<td>Designer</td>
															<td>
																<div class="progress-showcase">
																	<div class="progress" style="height: 8px;">
																		<div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
																	</div>
																</div>
															</td>
															<td class="digits">5 Year</td>
														</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Container-fluid Ends-->

						</div>

						<!-- footer start-->
						<?php
						ViewTemplate::BackFooter();
						?>
						<!-- footer end-->
					</div>


				</div>
				<!-- latest jquery-->
				<script src="../assets/js/jquery-3.3.1.min.js"></script>

				<!-- Bootstrap js-->
				<script src="../assets/js/popper.min.js"></script>
				<script src="../assets/js/bootstrap.js"></script>

				<!-- feather icon js-->
				<script src="../assets/js/icons/feather-icon/feather.min.js"></script>
				<script src="../assets/js/icons/feather-icon/feather-icon.js"></script>

				<!-- Sidebar jquery-->
				<script src="../assets/js/sidebar-menu.js"></script>
				<script src="../assets/js/slick.js"></script>

				<!--dropzone js-->
				<script src="../assets/js/dropzone/dropzone.js"></script>
				<script src="../assets/js/dropzone/dropzone-script.js"></script>

				<!--chartist js-->
				<script src="../assets/js/chart/chartist/chartist.js"></script>

				<!-- lazyload js-->
				<script src="../assets/js/lazysizes.min.js"></script>

				<!--copycode js-->
				<script src="../assets/js/prism/prism.min.js"></script>
				<script src="../assets/js/clipboard/clipboard.min.js"></script>
				<script src="../assets/js/custom-card/custom-card.js"></script>

				<!--counter js-->
				<script src="../assets/js/counter/jquery.waypoints.min.js"></script>
				<script src="../assets/js/counter/jquery.counterup.min.js"></script>
				<script src="../assets/js/counter/counter-custom.js"></script>

				<!--Customizer admin-->
				<script src="../assets/js/admin-customizer.js"></script>

				<!--map js-->
				<script src="../assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
				<script src="../assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>

				<!--apex chart js-->
				<script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
				<script src="../assets/js/chart/apex-chart/stock-prices.js"></script>

				<!--chartjs js-->
				<script src="../assets/js/chart/flot-chart/excanvas.js"></script>
				<script src="../assets/js/chart/flot-chart/jquery.flot.js"></script>
				<script src="../assets/js/chart/flot-chart/jquery.flot.time.js"></script>
				<script src="../assets/js/chart/flot-chart/jquery.flot.categories.js"></script>
				<script src="../assets/js/chart/flot-chart/jquery.flot.stack.js"></script>
				<script src="../assets/js/chart/flot-chart/jquery.flot.pie.js"></script>
				<!--dashboard custom js-->
				<script src="../assets/js/dashboard/default.js"></script>

				<!--height equal js-->
				<script src="../assets/js/equal-height.js"></script>

				<!--script admin-->
				<script src="../assets/js/admin-script.js"></script>
				<script src="../assets/js/slick.js"></script>

				<script>
					$('.single-item').slick({
							arrows: false,
							dots: true
						}
					);
				</script>
			</body>
		</html>

		<?php
	}
}

?>
