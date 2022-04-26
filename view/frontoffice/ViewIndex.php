<?php

/**
 * Class to display HTML content about first page in front.
 *
 * @date $Date$
 */
class ViewIndex
{
	/**
	 * Returns the HTMl code to display the index page.
	 *
	 * @return void
	 */
	public static function DisplayIndex()
	{
		$pagetitle = 'Accueil';

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
					ViewTemplate::FrontBreadcrumb('', '');
					?>

					<br /><br /><br /><br /><br />
					<p>Page en cours, contenu à venir une fois que les produits seront gérés en admin.</p>
					<br /><br /><br /><br /><br />
					<p>La page a un contenu vide assez haut car si sa hauteur est trop courte, le template foire.</p>
					<br /><br /><br /><br /><br />
					<p>Vous êtes actuellement
					<?php
					if ($_SESSION['user']['loggedin'] !== true)
					{
					?>
						déconnecté.
					<?php
					}
					else
					{
					?>
						connecté.
					<?php
					}
					?>
					</p>
					<br /><br /><br /><br /><br />

					<!-- media banner tab start-->
					<section class=" ratio_square">
						<div class="custom-container b-g-white section-pb-space">
							<div class="row">
								<div class="col p-0">
									<div class="theme-tab product">
										<ul class="tabs tab-title media-tab">
											<li class="current"><a href="tab-7">new products</a></li>
											<li class=""><a href="tab-9">best Sellers</a></li>
										</ul>
										<div class="tab-content-cls">
											<div id="tab-7" class="tab-content active default ">
												<div class="media-slide-5 product-m no-arrow">
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																	<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div id="tab-9" class="tab-content ">
												<div class="media-slide-5 product-m no-arrow">
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div>
														<div class="media-banner media-banner-1 border-0">
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/1.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>bajaj rex mixer</p></a>
																					<h6>$40.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/2.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>usha table fan</p></a>
																					<h6>$52.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="media-banner-box">
																<div class="media">
																	<a href="product-page(left-sidebar).html">
																		<img src="assets/images/layout-2/media-banner/3.jpg" class="img-fluid " alt="banner">
																	</a>
																	<div class="media-body">
																		<div class="media-contant">
																			<div>
																				<div class="product-detail">
																					<a href="product-page(left-sidebar).html"><p>sumsung galaxy</p></a>
																					<h6>$47.05</h6>
																				</div>
																				<div class="cart-info">
																					<button onclick="openCart()" class="tooltip-top" data-tippy-content="Add to cart"><i data-feather="shopping-cart"></i></button>
																					<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#quick-view" class="tooltip-top" data-tippy-content="Quick View"><i data-feather="eye"></i></a>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
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
					?>

					<!-- latest jquery-->
					<script src="assets/js/jquery-3.3.1.min.js" ></script>

					<!-- slick js-->
					<script src="assets/js/slick.js"></script>

					<!-- popper js-->
					<script src="assets/js/popper.min.js" ></script>
					<script src="assets/js/bootstrap-notify.min.js"></script>

					<!-- menu js-->
					<script src="assets/js/menu.js"></script>

					<!-- timer js -->
					<!-- <script src="assets/js/timer2.js"></script> -->

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

					<?php

					if ($_SESSION['nonallowed'] === 1)
					{
						ViewTemplate::FrontNotify('Erreur', 'Vous ne pouvez pas accéder à cette partie.', 'danger');
						unset($_SESSION['nonallowed']);
					}

					if ($_SESSION['userregistered'] === 1)
					{
						ViewTemplate::FrontNotify('Inscription', 'Vous vous êtes inscrit avec succès !', 'success');
						unset($_SESSION['userregistered']);
					}

					if ($_SESSION['userloggedin'] === 1)
					{
						ViewTemplate::FrontNotify('Identification', 'Vous vous êtes identifié avec succès !', 'success');
						unset($_SESSION['userloggedin']);
					}

					if ($_SESSION['userloggedout'] === 1)
					{
						ViewTemplate::FrontNotify('Déconnexion', 'Vous vous êtes déconnecté avec succès !', 'success');
						unset($_SESSION['userloggedout']);
					}

					if ($_SESSION['customerremoved'] === 1)
					{
						ViewTemplate::FrontNotify('Suppression de compte', 'Votre compte utilisateur a été supprimé avec succès !', 'success');
						unset($_SESSION['customerremoved']);
					}

					// Setting this one before the previous to be able to show the notify
					if ($_SESSION['order']['confirmpaid'] === 1)
					{
						ViewTemplate::FrontNotify('Règlement de commande', 'Votre commande a été effectuée avec succès !', 'success');
						unset($_SESSION['order']['confirmpaid']);
					}

					if ($_SESSION['order']['paid'] === 1)
					{
						?>
						<script>
						$(window).on('load', function()
						{
							shoppingCart.clearCart();
							location.reload();
						});
						</script>
						<?php

						$_SESSION['order']['confirmpaid'] = 1;
						unset($_SESSION['order']['paid']);
					}
					?>

				</body>
			</html>
		<?php
	}
}

?>