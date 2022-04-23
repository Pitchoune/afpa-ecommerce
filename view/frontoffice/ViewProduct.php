<?php

require_once(DIR . '/model/ModelProduct.php');

/**
 * Class to display HTML content about products in front.
 *
 * @date $Date$
 */
class ViewProduct
{
	/**
	 * Returns the HTML form to search into products.
	 *
	 * @param string $query Search query.
	 * @param integer $category ID of the category to search.
	 *
	 * @return void
	 */
	public static function SearchResults($query, $category)
	{
		global $config;

		$pagetitle = 'Résultats de la recherche';

		$products = new \Ecommerce\Model\ModelProduct($config);
		$products->set_name($query);
		$products->set_ref($query);
		$products->set_description($query);

		if ($category !== 0)
		{
			// Search in a specific category
			$products->set_category($category);
			$product = $products->searchProductsWithCategory();
		}
		else
		{
			// Search despite the category (in all categories)
			$product = $products->searchProductsWithoutCategory();
		}

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
				ViewTemplate::FrontBreadcrumb($pagetitle, ['search' => $pagetitle]);

				if ($product)
				{
					?>
					<!-- product section start -->
					<section class="section-big-py-space ratio_asos b-g-light">
						<div class="custom-container">
							<div class="row search-product related-pro1">
								<?php
								foreach ($product AS $key => $value)
								{
									?>
									<div class="col-xl-3 col-md-4 col-sm-6">
										<div class="product">
											<div class="product-box">
												<div class="product-imgbox">
													<div class="product-front">
														<img src="attachments/products/<?= $value['photo'] ?>" class="img-fluid" alt="product">
													</div>
												</div>
												<div class="product-detail detail-center">
													<div class="detail-title">
														<div class="detail-left">
															<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>">
																<h6 class="price-title">
																	<?= $value['nom'] ?>
																</h6>
															</a>
														</div>
														<div class="detail-right">
															<div class="price">
																<div class="price">
																	<?= $value['prix'] ?> &euro;
																</div>
															</div>
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
						</div>
					</section>
					<!-- product section end -->
					<?php
				}
				else
				{
					?>
					<section class="login-page section-big-py-space b-g-light">
						<div class="custom-container">
							<div class="row">
								<div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
									<div class="theme-card">
										<div>Aucun produit trouvé.</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php
				}

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