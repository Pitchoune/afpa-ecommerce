<?php

require_once(DIR . '/model/ModelCategory.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelCategory;
use \Ecommerce\Model\ModelTrademark;

/**
 * Class to display HTML content about any captured error in front.
 */
class ViewSearch
{
	/**
	 * Returns the HTML code to display the advanced search page.
	 *
	 * @param string $pagetitle Title of the page.
	 * @param array $navbits Breadcrumb navigation.
	 *
	 * @return void
	 */
	public static function DisplayAdvSearch($pagetitle, $navbits)
	{
		global $config;

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?= ViewTemplate::FrontHead($pagetitle) ?>
			</head>
			<body class="bg-light">
				<?php
				ViewTemplate::FrontHeader();

				ViewTemplate::FrontBreadcrumb($pagetitle, $navbits);
				?>
				<!-- advanced search -->
				<section class="contact-page section-big-py-space b-g-light">
					<div class="custom-container">
						<form action="index.php?do=searchresults" method="get">
							<div class="row">
								<div class="col-lg-12">
									<div class="theme-form">
										<div class="row">
											<div class="col-md-6">
												<div class="col-md-12">
													<div class="form-group">
														<label for="product">Produit <span>*</span></label>
														<input type="text" class="form-control" id="product" name="product" required />
														<div class="form-check">
															<input type="checkbox" class="form-check-input" id="description" name="description" value="1" /> Rechercher dans les descriptions ?
														</div>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label for="ref">Référence</label>
														<input type="text" class="form-control" id="ref" name="reference" aria-describedby="referenceHelp" data-type="reference" data-message="Le format de la référence n'est pas valide." />
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Catégorie</label>
														<?php

														$categories = new ModelCategory($config);

														$categorieslist = $categories->listAllCategories();
														$cache = Utils::categoriesCache($categorieslist);
														$categorylist = Utils::constructCategoryChooserOptions($cache, true, 'front');

														$categoriesselect = Utils::constructCategorySelectOptions($categorylist, '-1');

														?>
														<select class="form-control" name="category">
															<?= $categoriesselect ?>
														</select>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Prix</label>
														<div class="price-input">
															<div class="field">
																<span>Min</span>
																<input type="number" class="form-control input-min" name="price-min" value="2500">
															</div>
															<div class="separator">-</div>
															<div class="field">
																<span>Max</span>
																<input type="number" class="form-control input-max" name="price-max" value="7500">
															</div>
														</div>
														<div class="slider">
															<div class="progress"></div>
														</div>
														<div class="range-input">
															<input type="range" class="range-min" min="0" max="10000" value="2500" step="100">
															<input type="range" class="range-max" min="0" max="10000" value="7500" step="100">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Marques</label>
													<?php

													$trademarks = new ModelTrademark($config);
													$trademarkslist = $trademarks->listAllTrademarks();

													foreach ($trademarkslist AS $key => $value)
													{
														?>
														<div class="form-check">
															<input type="checkbox" class="form-check-input" name="trademark[]" value="<?= $value['id'] ?>" /> <?= $value['nom'] ?>
														</div>
														<?php
													}
													?>
												</div>
											</div>
											<div class="col-md-12">
												<input type="hidden" name="do" value="searchresults" />
												<button class="btn btn-sm btn-normal pull-right" type="submit">Rechercher</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</section>
				<!-- / advanced search -->
				<?php
				ViewTemplate::FrontFooter();

				if (isset($_SESSION['userloggedin']) AND $_SESSION['userloggedin'] === 1)
				{
					ViewTemplate::FrontNotify('Identification', 'Vous vous êtes identifié avec succès !', 'success');
					unset($_SESSION['userloggedin']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the search page results.
	 *
	 * @param string $pagetitle Title of the page.
	 * @param array $navbits Breadcrumb navigation.
	 * @param array $results Search results.
	 * @param string $address Part of the URL for the filter values.
	 * @param integer $perpage Number of items per page.
	 * @param string $sortby Sort direction of products.
	 * @param string $pagination URL arguments for pagination.
	 *
	 * @return void
	 */
	public static function DisplayResults($pagetitle, $navbits, $results, $address, $perpage, $sortby, $pagination)
	{
		global $pagenumber;

		$pagetitle = 'Résultats de la recherche';

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?= ViewTemplate::FrontHead($pagetitle) ?>
			</head>
			<body class="bg-light">
				<?php
				ViewTemplate::FrontHeader();

				ViewTemplate::FrontBreadcrumb($pagetitle, $navbits);

				if ($results)
				{
					$nbresults = count($results);
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
															foreach ($results AS $key => $value)
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
													<?= Utils::construct_page_nav($pagenumber, $perpage, $nbresults, 'index.php?do=searchresults' . $pagination, 'front', $address) ?>
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
					<!-- search results -->
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
					<!-- / search results -->
					<?php
				}
				?>

				<?php
				ViewTemplate::FrontFooter();

				if (isset($_SESSION['userloggedin']) AND $_SESSION['userloggedin'] === 1)
				{
					ViewTemplate::FrontNotify('Identification', 'Vous vous êtes identifié avec succès !', 'success');
					unset($_SESSION['userloggedin']);
				}
				?>
			</body>
		</html>
		<?php
	}
}

?>
