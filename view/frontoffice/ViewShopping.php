<?php

require_once(DIR . '/model/ModelCustomer.php');

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
									<a href="index.php?do=viewcheckout" class="btn btn-normal ms-3 submitcheckout" type="submit">Passer la commande</a>
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

	/**
	 * Returns the HTMl code to display the checkout.
	 *
	 * @return void
	 */
	public static function DisplayCheckout()
	{
		global $config;

		if ($_SESSION['user']['id'])
		{
			$pagetitle = 'Vérification de la commande';

			$customers = new \Ecommerce\Model\ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['viewcheckout' => $pagetitle]);
					?>

					<!-- section start -->
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
												<div class="checkout-details theme-form  section-big-mt-space">
													<div class="order-box">
														<div class="title-box">
															<div>Produit <span>Total</span></div>
														</div>
														<ul class="qty">
														</ul>
														<ul class="sub-total">
															<li>Sous-total <span class="count total-cart"></span></li>
															<li>Livraison <span style="position: relative; float: right; width: 35%;">Gratuit</span></li>
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
																require_once(DIR . '/model/ModelDeliver.php');
																$delivers = new \Ecommerce\Model\ModelDeliver($config);
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
					<!-- section end -->

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
		else
		{
			throw new Exception('Afin de pouvoir procéder au paiement, veuillez vous identifier. Votre panier sera conservé.');
		}
	}

	/**
	 * Returns the HTMl code to display the place order page.
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

			$customers = new \Ecommerce\Model\ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['placeorder' => $pagetitle]);
					?>

					<section class="checkout-second section-big-py-space b-g-light">
						<div class="custom-container" id="grad1">
							<div class="row justify-content-center">
								<div class="col-md-11">
									<div class=" checkout-box">
										<div class="checkout-header">
											<h2>Paiement de votre commande</h2>
											<h4>Veuillez compléter tous les champs pour terminer votre achat.</h4>
										</div>
										<div class="checkout-body ">
											<form class="checkout-form" action="index.php?do=paymentprocess" method="post" id="payment_form">
												<div class="checkout-fr-box">
													<div class="form-card">
														<h3 class="form-title">Informations de paiement</h3>
														<ul class="payment-info">
															<li>
																<img src="assets/images/checkout/payment-method/1.png" alt="" class="payment-method">
															</li>
															<li>
																<img src="assets/images/checkout/payment-method/2.png" alt="" class="payment-method">
															</li>
															<li>
																<img src="assets/images/checkout/payment-method/3.png" alt="" class="payment-method">
															</li>
															<li>
																<img src="assets/images/checkout/payment-method/4.png" alt="" class="payment-method">
															</li>
														</ul>
														<div class="form-group">
															<label class="pay">Nom*</label>
															<input type="text" name="name" class="form-control" />
														</div>
														<div class="form-group">
															<div class="small-group">
																<div>
																	<label>Numéro de carte*</label>
																	<input type="text" name="number" placeholder="" class="form-control" data-stripe="number" />
																</div>
																<div class="small-sec">
																	<label>CVC*</label>
																	<input type="password" name="cvc" placeholder="***" class="form-control" data-stripe="cvc" />
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>Date d'expiration*</label>
															<div class="small-group">
																<input type="text" name="exp-month" placeholder="MM" class="form-control" data-stripe="exp_month" />
																<input type="text" name="exp-year" style="margin-left: 15px;" placeholder="YY" class="form-control" data-stripe="exp_year" />
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
}

?>