<?php

require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelOrderDetails.php');
use \Ecommerce\Model\ModelProduct;
use \Ecommerce\Model\ModelOrderDetails;

/**
 * Class to display HTML content about first page in front.
 */
class ViewIndex
{
	/**
	 * Returns the HTML code to display the index page.
	 *
	 * @param string $pagetitle Title of the page.
	 * @param array $navbits Breadcrumb navigation.
	 *
	 * @return void
	 */
	public static function DisplayIndex($pagetitle, $navbits)
	{
		global $config;

		?>
			<!DOCTYPE html>
			<html>
				<head>
					<?=ViewTemplate::FrontHead($pagetitle) ?>
				</head>

				<body class="bg-light">
					<?php
					ViewTemplate::FrontHeader();

					ViewTemplate::FrontBreadcrumb('', '');
					?>

					<!-- media banner tab start-->
					<section class="ratio_square">
						<div class="custom-container b-g-white section-pb-space">
							<div class="row">
								<div class="col p-0">
									<div class="theme-tab product">
										<ul class="tabs tab-title media-tab">
											<li class="current">Meilleurs ventes</li>
										</ul>
										<div class="tab-content-cls">
											<div class="tab-content active default">
												<div class="media-slide-5 product-m no-arrow">
													<?php
													for ($i = 0; $i < 6; $i++)
													{
														?>
														<div>
															<div class="media-banner media-banner-1 border-0">
																<?php
																$orderdetails = new ModelOrderDetails($config);
																$bestsellinglist = $orderdetails->getBestSellingProductsFromSpecificRange(($i + $i * 2), 3);

																foreach ($bestsellinglist AS $key => $value)
																{
																	if ($value['photo'])
																	{
																		$photo = 'attachments/products/' . $value['photo'];
																	}
																	else
																	{
																		$photo = 'assets/images/nophoto.jpg';
																	}
																	?>

																		<div class="media-banner-box">
																			<div class="media">
																				<a href="index.php?do=viewproduct&amp;id=<?= $value['id_produit'] ?>">
																					<img src="<?= $photo ?>" height="108px" width="84" class="img-fluid" alt="Bannière">
																				</a>
																				<div class="media-body">
																					<div class="media-content">
																						<div>
																							<div class="product-detail">
																								<a href="index.php?do=viewproduct&amp;id=<?= $value['id_produit'] ?>"><p><?= $value['nom'] ?></p></a>
																								<h6><?= $value['prix'] ?> &euro;</h6>
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
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- media banner tab end -->
					<!-- media banner tab start-->
					<section class=" ratio_square">
						<div class="custom-container b-g-white section-pb-space">
							<div class="row">
								<div class="col p-0">
									<div class="theme-tab product">
										<ul class="tabs tab-title media-tab">
											<li class="current">Nouveaux produits</li>
										</ul>
										<div class="tab-content-cls">
											<div class="tab-content active default">
												<div class="media-slide-5 product-m no-arrow">
													<?php
													for ($i = 0; $i < 6; $i++)
													{
														?>
														<div>
															<div class="media-banner media-banner-1 border-0">
																<?php
																$products = new ModelProduct($config);
																$productlist = $products->getLatestNewProductsFromSpecificRange(($i + $i * 2), 3);

																foreach ($productlist AS $key => $value)
																{
																	if ($value['photo'])
																	{
																		$photo = 'attachments/products/' . $value['photo'];
																	}
																	else
																	{
																		$photo = 'assets/images/nophoto.jpg';
																	}
																	?>
																		<div class="media-banner-box">
																			<div class="media">
																				<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>">
																					<img src="<?= $photo ?>" height="108px" width="84" class="img-fluid " alt="banner">
																				</a>
																				<div class="media-body">
																					<div class="media-content">
																						<div>
																							<div class="product-detail">
																								<a href="index.php?do=viewproduct&amp;id=<?= $value['id'] ?>"><p><?= $value['nom'] ?></p></a>
																								<h6><?= $value['prix'] ?> &euro;</h6>
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
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- media banner tab end -->

					<?php
					ViewTemplate::FrontFooter();

					if (isset($_SESSION['userregistered']) AND $_SESSION['userregistered'] === 1)
					{
						ViewTemplate::FrontNotify('Inscription', 'Vous vous êtes inscrit avec succès !', 'success');
						unset($_SESSION['userregistered']);
					}

					if (isset($_SESSION['userloggedin']) AND $_SESSION['userloggedin'] === 1)
					{
						ViewTemplate::FrontNotify('Identification', 'Vous vous êtes identifié avec succès !', 'success');
						unset($_SESSION['userloggedin']);
					}

					if (isset($_SESSION['userloggedout']) AND $_SESSION['userloggedout'] === 1)
					{
						ViewTemplate::FrontNotify('Déconnexion', 'Vous vous êtes déconnecté avec succès !', 'success');
						unset($_SESSION['userloggedout']);
					}

					if (isset($_SESSION['customerremoved']) AND $_SESSION['customerremoved'] === 1)
					{
						ViewTemplate::FrontNotify('Suppression de compte', 'Votre compte utilisateur a été supprimé avec succès !', 'success');
						unset($_SESSION['customerremoved']);
					}

					if (isset($_SESSION['user']['contact']) AND $_SESSION['user']['contact'] === 1)
					{
						ViewTemplate::FrontNotify('Nous contacter', 'Votre message a été envoyé à notre équipe avec succès !', 'success');
						unset($_SESSION['user']['contact']);
					}

					if (isset($_SESSION['nonallowed']) AND $_SESSION['nonallowed'] === 1)
					{
						ViewTemplate::FrontNotify('Erreur', 'Vous ne pouvez pas accéder à cette page.', 'danger');
						unset($_SESSION['nonallowed']);
					}
					?>

				</body>
			</html>
		<?php
	}
}

?>
