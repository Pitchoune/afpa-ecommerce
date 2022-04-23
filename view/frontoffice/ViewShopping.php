<?php

// require_once(DIR . '/model/ModelCategory.php');

/**
 * Class to display HTML content about shopping in front.
 *
 * @date $Date$
 */
class ViewShopping
{
	/**
	 * Returns the HTMl code to display the cart.
	 *
	 * @return void
	 */
	public static function DisplayCart()
	{
		global $config;

		$pagetitle = 'Panier';

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php
				ViewTemplate::FrontHead($pagetitle);
				?>
			</head>

			<body class="bg-light">
				<!-- loader start -->
				<div class="loader-wrapper">
				  <div>
					<img src="assets/images/loader.gif" alt="loader">
				  </div>
				</div>
				<!-- loader end -->

				<?php
				ViewTemplate::FrontHeader();
				?>

				<?php
				ViewTemplate::FrontBreadcrumb($pagetitle, ['viewcart' => $pagetitle]);
				?>

				<!--section start-->
				<section class="cart-section section-big-py-space b-g-light">
					<form action="index.php?do=viewcheckout" method="post">
						<div class="custom-container">
							<div class="row">
								<div class="col-sm-12">
									<table class="table cart-table table-responsive-xs">
										<thead>
											<tr class="table-head">
												<th scope="col">image</th>
												<th scope="col">nom</th>
												<th scope="col">prix</th>
												<th scope="col">quantité</th>
												<th scope="col">total</th>
											</tr>
										</thead>
										<tbody class="cart_list">
										</tbody>
									</table>
									<table class="table cart-table table-responsive-md">
										<tfoot>
										<tr>
											<td>total :</td>
											<td>
												<h2 class="total-cart"></h2>
											</td>
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="row cart-buttons">
								<div class="col-12">
									<a href="index.php" class="btn btn-normal">Continuer vos achats</a>
									<a href="index.php?do=viewcheckout" class="btn btn-normal ms-3" type="submit">Passer la commande</a>
								</div>
							</div>
						</div>
					</form>
				</section>
				<!--section end-->

				<?php
				ViewTemplate::FrontFooter();
				?>

				<!-- latest jquery-->
				<script src="assets/js/jquery-3.5.1.min.js" ></script>

				<!-- slick js-->
				<script src="assets/js/slick.js"></script>

				<!-- popper js-->
				<script src="assets/js/popper.min.js" ></script>
				<script src="assets/js/bootstrap-notify.min.js"></script>

				<!-- menu js-->
				<script src="assets/js/menu.js"></script>

				<!-- Bootstrap js-->
				<script src="assets/js/bootstrap.js"></script>

				<!-- tool tip js -->
				<script src="assets/js/tippy-popper.min.js"></script>
				<script src="assets/js/tippy-bundle.iife.min.js"></script>

				<!-- father icon -->
				<script src="assets/js/feather.min.js"></script>
				<script src="assets/js/feather-icon.js"></script>

				<!-- Theme js-->
				<script src="assets/js/modal.js"></script>
				<script src="assets/js/script.js" ></script>
			</body>
		</html>
		<?php
	}
}

?>