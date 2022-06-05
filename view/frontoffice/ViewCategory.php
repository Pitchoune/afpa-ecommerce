<?php

/**
 * Class to display HTML content about categories in front.
 */
class ViewCategory
{
	/**
	 * Returns the HTML code to display the category page.
	 *
	 * @param string $pagetitle Title of the page.
	 * @param array $navbits Breadcrumb content.
	 * @param array $category Category informations.
	 * @param array $product Products list.
	 * @param integer $nbproducts Total number of products.
	 * @param string $address Part of the URL for the filter values.
	 * @param integer $perpage Number of items per page.
	 * @param string $sortby Sort direction of products.
	 *
	 * @return void
	 */
	public static function DisplayCategory($pagetitle, $navbits, $category, $product, $nbproducts, $address, $perpage, $sortby)
	{
		global $pagenumber;
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?= ViewTemplate::FrontHead($pagetitle) ?>
			</head>
			<body class="bg-light">
				<?php
				ViewTemplate::FrontHeader($address);

				if ($category)
				{
					ViewTemplate::FrontBreadcrumb('Catégorie « ' . $category['nom'] . ' »', $navbits, true);

					if ($nbproducts)
					{
						?>
						<!-- category -->
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
																	<div class="col-12 position-relative">
																		<div class="product-filter-content horizontal-filter-main">
																			<div class="collection-view">
																				<ul>
																					<li><i class="fa fa-th grid-layout-view"></i></li>
																					<li><i class="fa fa-list-ul list-layout-view"></i></li>
																				</ul>
																			</div>
																			<div class="collection-grid-view">
																				<ul>
																					<li><img src="assets/images/2byline.png" alt="" class="product-2-layout-view"></li>
																					<li><img src="assets/images/3byline.png" alt="" class="product-3-layout-view"></li>
																					<li><img src="assets/images/4byline.png" alt="" class="product-4-layout-view"></li>
																					<li><img src="assets/images/6byline.png" alt="" class="product-6-layout-view"></li>
																				</ul>
																			</div>
																			<div class="product-page-per-view">
																				<select id="perpage">
																					<option value="24"<?= ($perpage == 24 ? ' selected' : '') ?>>24 produits par page</option>
																					<option value="50"<?= ($perpage == 50 ? ' selected' : '') ?>>50 produits par page</option>
																					<option value="100"<?= ($perpage == 100 ? ' selected' : '') ?>>100 produits par page</option>
																				</select>
																			</div>
																			<div class="product-page-filter ">
																				<select id="sortby">
																					<option value="asc"<?= ($sortby == 'asc' ? ' selected' : '') ?>>Ordre alphabétique</option>
																					<option value="desc"<?= ($sortby == 'desc' ? ' selected' : '') ?>>Ordre inversé</option>
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
																				<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>"> <img src="<?= $value['photo'] ?>" class="img-fluid" alt="product"></a>
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
														<?= Utils::construct_page_nav($pagenumber, $perpage, $nbproducts, 'index.php?do=viewcategory&amp;id=' . $category['id'], 'front', $address) ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!-- / category -->
						<?php
					}
					else
					{
						?>
						<!-- category -->
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
						<!-- / category -->
						<?php
					}
				}
				else
				{
					// Category not found
					ViewTemplate::FrontBreadcrumb('Erreur', '', false);

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
				</body>
			</html>
		<?php
	}
}

?>
