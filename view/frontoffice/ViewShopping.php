<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelDeliver.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelProduct;
use \Ecommerce\Model\ModelDeliver;

/**
 * Class to display HTML content about shopping in front.
 */
class ViewShopping
{
	/**
	 * Returns the HTML code to display the cart.
	 *
	 * @return void
	 */
	public static function DisplayCart()
	{
		$pagetitle = 'Panier';

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?= ViewTemplate::FrontHead($pagetitle) ?>
			</head>
			<body class="bg-light">
				<?php
				ViewTemplate::FrontHeader();

				ViewTemplate::FrontBreadcrumb($pagetitle, ['viewcart' => $pagetitle]);
				?>
				<!-- cart -->
				<section class="cart-section section-big-py-space b-g-light">
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
										<td>Total :</td>
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
								<a href="index.php?do=viewcheckout" class="btn btn-normal ms-3 submitcheckout" type="submit">Passer la commande</a>
							</div>
						</div>
					</div>
				</section>
				<!-- / cart -->
				<?php
				ViewTemplate::FrontFooter();

				if ($_SESSION['userloggedin'] === 1)
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
	 * Returns the HTML code to display the checkout.
	 *
	 * @return void
	 */
	public static function DisplayCheckout()
	{
		global $config;

		if ($_SESSION['user']['id'])
		{
			$pagetitle = 'Vérification de la commande';

			$customers = new ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();

			?>
			<!DOCTYPE html>
			<html>
				<head>
					<?= ViewTemplate::FrontHead($pagetitle) ?>
				</head>
				<body class="bg-light">
					<?php
					ViewTemplate::FrontHeader();

					ViewTemplate::FrontBreadcrumb($pagetitle, ['viewcheckout' => $pagetitle]);
					?>
					<!-- checkout -->
					<section class="section-big-py-space b-g-light">
						<div class="custom-container">
							<div class="checkout-page contact-page">
								<div class="checkout-form">
									<form action="index.php?do=placeorder" method="post">
										<div class="row">
											<div class="col-lg-6 col-sm-12 col-xs-12">
												<div class="checkout-title">
													<h3>Détails de livraison / facturation</h3>
												</div>
												<div class="theme-form">
													<div class="row check-out ">
														<div class="form-group col-md-6 col-sm-6 col-xs-12">
															<label>Prénom</label>
															<input type="text" name="field-name" value="<?= $customer['prenom'] ?>" disabled />
														</div>
														<div class="form-group col-md-6 col-sm-6 col-xs-12">
															<label>Nom</label>
															<input type="text" name="field-name" value="<?= $customer['nom'] ?>" disabled />
														</div>
														<div class="form-group col-md-6 col-sm-6 col-xs-12">
															<label class="field-label">Téléphone</label>
															<input type="text" name="field-name" value="<?= $customer['tel'] ?>" disabled />
														</div>
														<div class="form-group col-md-6 col-sm-6 col-xs-12">
															<label class="field-label">Adresse email</label>
															<input type="text" name="field-name" value="<?= $customer['mail'] ?>" disabled />
														</div>
														<div class="form-group col-md-12 col-sm-12 col-xs-12">
															<label class="field-label">Adresse postale</label>
															<input type="text" name="field-name" value="<?= $customer['adresse'] ?>" disabled />
														</div>
														<div class="form-group col-md-12 col-sm-12 col-xs-12">
															<label class="field-label">Ville</label>
															<input type="text" name="field-name" value="<?= $customer['ville'] ?>" disabled>
														</div>
														<div class="form-group col-md-12 col-sm-6 col-xs-12">
															<label class="field-label">Code postal</label>
															<input type="text" name="field-name" value="<?= $customer['code_post'] ?>" disabled>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-sm-12 col-xs-12">
												<div class="checkout-details theme-form section-big-mt-space">
													<div class="order-box">
														<div class="title-box">
															<div>Produit <span>Total</span></div>
														</div>
														<ul class="qty">
														</ul>
														<ul class="sub-total">
															<li>Sous-total <span class="count total-cart"></span></li>
															<li>Livraison <span class="shipping float-end">Gratuit</span></li>
														</ul>
														<ul class="total">
															<li>Total <span class="count total-cart"></span></li>
														</ul>
													</div>
													<div class="delivermode-box">
														<div class="title-box">
															<div>Mode de livraison</div>
														</div>
														<div class="delivermode-list">
															<select name="delivermode" id="delivermode">
																<option value="0" selected disabled>Sélectionnez un mode de livraison</option>
																<option value="1">À domicile</option>
																<option value="2">En point-relais</option>
																<option value="3">Au bureau de poste</option>
															</select>
														</div>
													</div>
													<div class="delivery-box">
														<div class="title-box">
															<div>Transporteur</div>
														</div>
														<div class="delivery-list">
															<select name="deliver" id="deliver">
																<option value="0" selected disabled>Sélectionnez un transporteur</option>
																<?php
																$delivers = new ModelDeliver($config);
																$deliverlist = $delivers->listAllDelivers();

																foreach ($deliverlist AS $key => $value)
																{
																	?>
																	<option value="<?= $value['id'] ?>"><?= $value['nom'] ?></option>
																	<?php
																}
																?>
															</select>
														</div>
													</div>
													<div class="payment-box">
														<div class="upper-box">
															<div class="payment-options">
																<ul>
																	<li>
																		<div class="radio-option">
																			<input type="radio" name="payment-group" id="payment-1" checked>
																			<label for="payment-1">Carte bancaire</label>
																		</div>
																	</li>
																</ul>
															</div>
														</div>
														<div class="text-right">
															<input type="hidden" class="novisibleprice" name="price" value="" />
															<input class="btn-normal btn submitcheckoutbutton" type="submit" value="Effectuer le paiement" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
					<!-- checkout -->
					<?= ViewTemplate::FrontFooter() ?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Afin de pouvoir procéder au paiement, veuillez vous identifier. Votre panier sera conservé.');
		}
	}

	/**
	 * Returns the HTML code to display the place order page.
	 *
	 * @param string $price Price of the whole checkout.
	 * @param integer $deliver Deliver ID selected in the checkout.
	 * @param integer $delivermode Deliver mode selected in the checkout.
	 *
	 * @return void
	 */
	public static function PlaceOrder($price, $deliver, $delivermode)
	{
		if ($_SESSION['user']['id'])
		{
			global $config;

			$pagetitle = 'Paiement';

			$customers = new ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();

			?>
			<!DOCTYPE html>
			<html>
				<head>
					<?= ViewTemplate::FrontHead($pagetitle) ?>
				</head>
				<body class="bg-light">
					<?php
					ViewTemplate::FrontHeader();

					ViewTemplate::FrontBreadcrumb($pagetitle, ['placeorder' => $pagetitle]);
					?>
					<section class="checkout-second section-big-py-space b-g-light">
						<div class="custom-container">
							<div class="row">
								<div class="col-md-12">
									<div class="checkout-box">
										<div class="checkout-header">
											<h2>Paiement de votre commande</h2>
											<h4>Veuillez compléter tous les champs pour terminer votre achat.</h4>
										</div>
										<div class="checkout-body">
											<form class="checkout-form" action="index.php?do=paymentprocess" method="post" id="payment_form">
												<div class="checkout-fr-box">
													<div class="form-card">
														<h3 class="form-title">Informations de paiement</h3>
														<ul class="payment-info">
															<li>
																<img src="assets/images/rupay.png" alt="" class="payment-method">
															</li>
															<li>
																<img src="assets/images/mastercard.png" alt="" class="payment-method">
															</li>
															<li>
																<img src="assets/images/visa.png" alt="" class="payment-method">
															</li>
														</ul>
														<div class="form-group">
															<label class="pay">Nom *</label>
															<input type="text" name="name" class="form-control" />
														</div>
														<div class="form-group">
															<div class="small-group">
																<div>
																	<label>Numéro de carte *</label>
																	<input type="text" name="number" placeholder="" class="form-control" minlength="16" maxlength="16" data-stripe="number" />
																</div>
																<div class="small-sec">
																	<label>CVC *</label>
																	<input type="password" name="cvc" placeholder="***" class="form-control" minlength="3" maxlength="3" data-stripe="cvc" />
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>Date d'expiration *</label>
															<div class="small-group">
																<input type="text" name="exp-month" placeholder="MM" class="form-control" minlength="2" maxlength="2" data-stripe="exp_month" />
																<input type="text" name="exp-year" placeholder="YY" class="form-control" minlength="2" maxlength="2" data-stripe="exp_year" />
															</div>
														</div>
													</div>
													<div class="hiddeninput"></div>
													<input type="hidden" name="email" value="<?= $customer['mail'] ?>" />
													<input type="hidden" name="price" value="<?= $price ?>" />
													<input type="hidden" name="deliver" value="<?= $deliver ?>" />
													<input type="hidden" name="delivermode" value="<?= $delivermode ?>" />
													<input type="submit" class="btn btn-normal sendbutton" value="Payer" />
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>

					<?= ViewTemplate::FrontFooter() ?>

					<!-- Stripe - use v2, v3 requires app auth from your bank with paymentInstants -->
					<script src="https://js.stripe.com/v2/"></script>

					<script>
						Stripe.setPublishableKey('<?= $config['Stripe']['publickey'] ?>');

						$('#payment_form').submit(function (e)
						{
							e.preventDefault();
							$('#payment_form').find('.sendbutton').attr('disabled', true);

							Stripe.card.createToken($('#payment_form'), function(status, response)
							{
								if (response.error)
								{
									$('#payment_form').prepend('<div><p>' + response.error.message + '</p></div>');
									$('#payment_form').find('.next').attr('disabled', false);
								}
								else
								{
									$('#payment_form').append($('<input type="hidden" name="stripeToken" />').val(response.id));
									$('#payment_form').get(0).submit();
								}
							})
						})
					</script>

				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous ne pouvez pas accéder à cette page en étant non identifié. Veuillez vous identifier ou vous inscrire.');
		}
	}

	/**
	 * Returns the HTML code to display the success payment page.
	 *
	 * @return void
	 */
	public static function PaymentSuccess()
	{
		if ($_SESSION['user']['order']['paid'] === 1)
		{
			global $config;

			$pagetitle = 'Commande effectuée !';

			$date = strtotime($_SESSION['user']['order']['date']);
			$deliverydate = strtotime("+7 days", $date);

			$customers = new ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();

			$products = new ModelProduct($config);

			?>
			<!DOCTYPE html>
			<html>
				<head>
					<?= ViewTemplate::FrontHead($pagetitle) ?>
				</head>
				<body class="bg-light">
					<?php
					ViewTemplate::FrontHeader();

					if ($_SESSION['user']['order']['confirmpaid'] === 1)
					{
						?>
						<!-- order success -->
						<section class="section-big-py-space light-layout">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
											<h2>Merci</h2>
											<p>Le paiement a été effectuée avec succès et votre commande va rapidement être préparée</p>
											<p>Commande #<?= $_SESSION['user']['order']['id'] ?></p>
										</div>
									</div>
								</div>
							</div>
						</section>

						<section class="section-big-py-space mt--5 b-g-light">
							<div class="custom-container">
								<div class="row">
									<div class="col-lg-6">
										<div class="product-order">
											<h3>Détails de votre commande</h3>
											<?php
											foreach ($_SESSION['user']['order']['item'] AS $key => $value)
											{
												$products->set_id($value['id']);
												$product = $products->listProductInfosFromId();

												if (empty($product['photo']))
												{
													$product['photo'] = 'assets/images/nophoto.jpg';
												}
												else
												{
													$product['photo'] = 'attachments/products/' . $product['photo'];
												}
												?>
												<div class="row product-order-detail">
													<div class="col-3"><img src="<?= $product['photo'] ?>" alt="" class="img-fluid "></div>
													<div class="col-3 order_detail">
														<div>
															<h4>Produit</h4>
															<h5><?= $product['nom'] ?></h5></div>
													</div>
													<div class="col-3 order_detail">
														<div>
															<h4>Quantité</h4>
															<h5><?= $value['quantity'] ?></h5></div>
													</div>
													<div class="col-3 order_detail">
														<div>
															<h4>Prix</h4>
															<h5><?= $value['price'] ?> &euro;</h5></div>
													</div>
												</div>
												<?php
											}
											?>
											<div class="total-sec">
												<ul>
													<li>Sous-total <span><?= $_SESSION['user']['order']['price'] ?> &euro;</span></li>
													<li>Livraison <span>Gratuite</span></li>
												</ul>
											</div>
											<div class="final-total">
												<h3>total <span><?= $_SESSION['user']['order']['price'] ?> &euro;</span></h3></div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="row order-success-sec">
											<div class="col-sm-6">
												<h4>Résumé</h4>
												<ul class="order-detail">
													<li>Commande #<?= $_SESSION['user']['order']['id'] ?></li>
													<li>Date de commande: <?= $_SESSION['user']['order']['date'] ?></li>
													<li>Total de la commande : <?= $_SESSION['user']['order']['price'] ?> &euro;</li>
												</ul>
											</div>
											<div class="col-sm-6">
												<h4>Adresse de livraison</h4>
												<ul class="order-detail">
													<li><?= $customer['prenom'] ?> <?= $customer['nom'] ?></li>
													<li><?= $customer['adresse'] ?></li>
													<li><?= $customer['code_post'] ?> <?= $customer['ville'] ?></li>
													<li><?= $customer['tel'] ?></li>
												</ul>
											</div>
											<div class="col-sm-12 payment-mode">
												<h4>Méthode de paiement</h4>
												<p>Carte bancaire</p>
											</div>
											<div class="col-md-12">
												<div class="delivery-sec">
													<h3>Estimation de la livraison</h3>
													<h2><?= date("d F Y", $deliverydate) ?></h2></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!-- / order success -->
						<?php
						unset($_SESSION['user']['order']);

						ViewTemplate::FrontFooter();
					}
					else
					{
						ViewTemplate::FrontFooter();

						$_SESSION['user']['order']['confirmpaid'] = 1;
						?>
						<script>
						// Empty cart
						$(document).ready(function()
						{
							$(window).on('load', function()
							{
								shoppingCart.clearCart();
								location.reload();
							});
						});
						</script>
						<?php
					}
					?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'avez pas l\'autorisation d\'être sur cette page.');
		}
	}

	/**
	 * Returns the HTML code to display the failed payment page.
	 *
	 * @return void
	 */
	public static function PaymentFailed()
	{
		if ($_SESSION['user']['order']['failed'])
		{
			global $config;

			$pagetitle = 'Commande echouée !';
			?>
			<!DOCTYPE html>
			<html>
				<head>
					<?= ViewTemplate::FrontHead($pagetitle) ?>
				</head>

				<body class="bg-light">
					<?= ViewTemplate::FrontHeader() ?>
					<!-- order failed -->
					<section class="section-big-py-space light-layout">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="danger-text"><i class="fas fa-times-circle" aria-hidden="true"></i>
										<h2>Echec</h2>
										<p>Le paiement a échouée. Votre panier est conservée tant que vous restez sur cette fenêtre/onglet.</p>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- / order failed -->
					<?= ViewTemplate::FrontFooter() ?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'avez pas l\'autorisation d\'être sur cette page.');
		}
	}
}

?>
