<?php

require_once(DIR . '/model/ModelCategory.php');

/**
 * Class to display HTML content about categories in front.
 *
 * @date $Date$
 */
class ViewCategory
{
	/**
	 * Returns the HTMl code to display the category page.
	 *
	 * @param integer $id ID of the category.
	 *
	 * @return void
	 */
	public static function DisplayCategory($id = '')
	{
		global $config, $pagenumber;

		$categories = new \Ecommerce\Model\ModelCategory($config);

		$categories->set_id($id);

		require_once(DIR . '/model/ModelProduct.php');
		$products = new \Ecommerce\Model\ModelProduct($config);
		$products->set_category($id);
		$totalproducts = $products->getTotalNumberOfProductsForSpecificCategory();

		// Number max per page
		$perpage = 2;

		Utils::sanitize_pageresults($totalproducts['nbproducts'], $pagenumber, $perpage, 200, 20);

		$limitlower = ($pagenumber - 1) * $perpage;
		$limitupper = ($pagenumber) * $perpage;

		if ($limitupper > $totalproducts['nbproducts'])
		{
			$limitupper = $totalproducts['nbproducts'];

			if ($limitlower > $totalproducts['nbproducts'])
			{
				$limitlower = ($totalproducts['nbproducts'] - $perpage) - 1;
			}
		}

		if ($limitlower < 0)
		{
			$limitlower = 0;
		}

		$category = $categories->listCategoryInfos();
		$product = $products->getSomeProductsForSpecificCategory($limitlower, $perpage);

		$pagetitle = 'Visualisation de la catégorie : « ' . $category['nom'] . ' »';

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php
				ViewTemplate::FrontHead($pagetitle);
				?>
			</head>

			<body class="bg-light">

				<?php
				ViewTemplate::FrontHeader();
				?>

				<?php
				ViewTemplate::FrontBreadcrumb('Catégorie « ' . $category['nom'] . ' »', ['viewcategory&amp;id=' . $category['id'] => $category['nom']]);

				if ($category)
				{
					?>

					<!-- section start -->
					<section class="section-big-pt-space ratio_asos b-g-light">
						<div class="collection-wrapper">
							<div class="custom-container">
								<div class="row">
									<div class="collection-content col">
										<div class="page-main-content">
											<div class="row">
												<div class="col-sm-12">
													<div class="collection-product-wrapper">
														<div class="product-top-filter">
															<div class="container-fluid p-0">
															  <div class="row">
																<div class="col-xl-12">
																	<div class="filter-main-btn ">
																	  <span class="filter-btn ">
																		<i class="fa fa-filter" aria-hidden="true"></i> Filtre
																	  </span>
																	</div>
																</div>
															</div>
																<div class="row">
																	<div class="col-12 position-relative">
																		<div class="product-filter-content horizontal-filter-mian ">
																			<div class="horizontal-filter-toggle">
																			  <h4></i>&nbsp;</h4>
																			</div>
																			<div class="collection-view">
																				<ul>
																					<li><i class="fa fa-th grid-layout-view"></i></li>
																					<li><i class="fa fa-list-ul list-layout-view"></i></li>
																				</ul>
																			</div>
																			<div class="collection-grid-view">
																				<ul>
																					<li><img src="assets/images/category/icon/2.png" alt="" class="product-2-layout-view"></li>
																					<li><img src="assets/images/category/icon/3.png" alt="" class="product-3-layout-view"></li>
																					<li><img src="assets/images/category/icon/4.png" alt="" class="product-4-layout-view"></li>
																					<li><img src="assets/images/category/icon/6.png" alt="" class="product-6-layout-view"></li>
																				</ul>
																			</div>
																			<div class="product-page-per-view">
																				<select>
																					<option value="High to low">24 produits par page</option>
																					<option value="Low to High">50 produits par page</option>
																					<option value="Low to High">100 produits par page</option>
																				</select>
																			</div>
																			<div class="product-page-filter ">
																				<select>
																					<option value="High to low">Ordre de tri</option>
																					<option value="Low to High">Ordre alphabétique</option>
																					<option value="Low to High">Ordre inversé</option>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>

														<div class="product-wrapper-grid product">
															<div class="row">

															<?php

															// require_once(DIR . '/model/ModelProduct.php');
															// $products = new \Ecommerce\Model\ModelProduct($config);
															// $products->set_category($category['id']);
															// $product = $products->listProductInfosFromCategory();

															foreach ($product AS $key => $value)
															{
																if (empty($value['photo']))
																{
																	$value['photo'] = 'assets/images/nophoto.jpg';
																}
																else
																{
																	$value['photo'] = 'attachments/products/' . $value['photo'];
																}
															?>
																<div class="col-xl-2 col-lg-3 col-md-4 col-6 col-grid-box">
																	<div class="product-box">
																		<div class="product-imgbox">
																			<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>"> <img src="<?= $value['photo'] ?>" class="img-fluid  " alt="product"> </a>
																		</div>
																		<div class="product-detail detail-center detail-inverse">
																			<div class="detail-title">
																				<div class="detail-left">
																					<p><?= $value['description'] ?></p>
																					<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>">
																						<h6 class="price-title">
																							<?= $value['nom'] ?>
																						</h6>
																					</a>
																				</div>
																				<div class="detail-right">
																					<div class="price">
																						<div class="price"> <?= $value['prix'] ?> &euro;</div>
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
														<?php
														Utils::construct_page_nav($pagenumber, $perpage, $totalproducts['nbproducts'], 'index.php?do=viewcategory&amp;id=' . $category['id'], 'front');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- section End -->

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
											<div>Aucune catégorie trouvée.</div>
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
					<script src="assets/js/script.js" ></script>
				</body>
			</html>
		<?php
	}
}

?>