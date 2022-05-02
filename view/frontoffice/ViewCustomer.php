<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelTrademark.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelTrademark;
use \Ecommerce\Model\ModelMessage;

/**
 * Class to display HTML content about customers in front.
 *
 * @date $Date$
 */
class ViewCustomer
{
	/**
	 * Returns the HTML form to register a new customer.
	 *
	 * @return void
	 */
	public static function RegisterForm()
	{
		$pagetitle = 'Inscription';

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
				ViewTemplate::FrontBreadcrumb($pagetitle, ['register' => $pagetitle]);
				?>
				<section class="login-page section-big-py-space b-g-light">
					<div class="custom-container">
						<div class="row">
							<div class="col-lg-4 offset-lg-4">
								<div class="theme-card">
									<h3 class="text-center">Inscription</h3>
									<form class="theme-form" action="index.php?do=doregister" method="post">
										<div class="row g-3">
											<div class="col-md-12 form-group">
												<label for="firstname">Prénom</label>
												<input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du prénom n'est pas valide." placeholder="Prénom" />
												<small id="firstnameHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="row g-3">
											<div class="col-md-12 form-group">
												<label for="lastname">Nom</label>
												<input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du nom n'est pas valide." placeholder="Nom" />
												<small id="lastnameHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="row g-3">
											<div class="col-md-12 form-group">
												<label for="mail">Adresse email</label>
												<input type="email" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Adresse email" autocomplete="off" />
												<small id="emailHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="row g-3">
											<div class="col-md-12 form-group">
												<label for="password">Mot de passe</label>
												<input type="password" class="form-control" id="password" name="password" aria-describedby="password" data-message="Le format du mot de passe n'est pas valide." placeholder="Insérez un mot de passe" autocomplete="off" />
												<small id="passwordHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="row g-3">
											<div class="col-md-12 form-group">
												<label for="passwordconfirm">Confirmation du mot de passe</label>
												<input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm" placeholder="Confirmez le mot de passe" />
											</div>
											<div class="col-md-12 form-group"><input type="submit" id="valider" class="btn btn-normal" value="S'inscrire" /></div>
										</div>
										<div class="row g-3">
											<div class="col-md-12 ">
												<p>Vous êtes déjà inscrit ? <a href="index.php?do=login" class="txt-default">Cliquez ici pour vous identifier</a>.</p>
											</div>
										</div>
									</form>
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
				<script src="assets/js/script.js" ></script>

				<?php
				ViewTemplate::FrontFormValidation('valider', 2, 1);
				?>
			</body>
		</html>
	<?php
	}

	/**
	 * Returns the HTML form to login.
	 *
	 * @return void
	 */
	public static function LoginForm()
	{
		$pagetitle = 'S\'identifier';

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
				ViewTemplate::FrontBreadcrumb($pagetitle, ['login' => $pagetitle]);
				?>

				<section class="login-page section-big-py-space b-g-light">
					<div class="custom-container">
						<div class="row">
							<div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
								<div class="theme-card">
									<h3 class="text-center">S'identifier</h3>
									<form class="theme-form" action="index.php?do=dologin" method="post">
										<div class="form-group">
											<label for="mail">Adresse email</label>
											<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Adresse email" autocomplete="on">
											<small id="emailHelp" class="form-text text-muted"></small>
										</div>
										<div class="form-group">
											<label for="password">Mot de passe</label>
											<input type="password" class="form-control" id="password" name="password" aria-describedby="password" data-message="Le format du mot de passe n'est pas valide." placeholder="Insérez votre mot de passe" autocomplete="on">
											<small id="password" class="form-text text-muted"></small>
										</div>
										<input type="submit" class="btn btn-normal" id="valider" value="S'identifier" />
										<a class="float-end txt-default mt-2" href="index.php?do=forgotpassword">Oubli de votre mot de passe ?</a>
									</form>
									<p class="mt-3">Inscrivez-vous gratuitement sur notre boutique. L'inscription est rapide et facile. Ceci vous permettra d'effectuer vos achats depuis notre boutique. Pour commencer, cliquez sur « Créez votre compte ».</p>
									<a href="index.php?do=register" class="txt-default pt-3 d-block">Créez votre compte</a>
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
				<script src="assets/js/script.js" ></script>

				<?php
				ViewTemplate::FrontFormValidation('valider', 2, 1);
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML form to display the customer dashboard.
	 *
	 * @return void
	 */
	public static function CustomerDashboard()
	{
		global $config;

		$pagetitle = 'Tableau de bord';

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);
		$data = $customer->getCustomerInfosFromId();

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
				ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => $pagetitle]);
				?>

				<!-- section start -->
				<section class="section-big-py-space b-g-light">
					<div class="container">
						<div class="row">
							<div class="col-lg-3">
								<div class="account-sidebar"><a class="popup-btn">Mon compte</a></div>
								<div class="dashboard-left">
									<div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
									<div class="block-content ">
										<ul>
											<li class="active"><a href="index.php?do=profile">Tableau de bord</a></li>
											<li><a href="index.php?do=vieworders">Mes commandes</a></li>
											<li><a href="index.php?do=viewmessages">Mes messages</a></li>
											<li><a href="index.php?do=editprofile">Mon compte</a></li>
											<li><a href="index.php?do=editpassword">Modifier mon mot de passe</a></li>
											<li><a href="index.php?do=deleteprofile">Supprimer mon compte</a></li>
											<li class="last"><a href="index.php?do=logout">Se déconnecter</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-9">
								<div class="dashboard-right">
									<div class="dashboard">
										<div class="page-title"><h2>Mon tableau de bord</h2></div>
										<div class="welcome-msg">
											<p>Bonjour, <?= $data['prenom'] . ' ' . $data['nom'] ?> !</p>
											<p>Depuis ce tableau de bord, vous avez la possibilité de voir un aperçu de votre activité récente ainsi que de mettre vos informations à jour. Sélectionnez un lien ci-dessous pour afficher ou modifier vos informations.</p>
											<p>Vous avez aussi la possibilité de modifier votre mot de passe ainsi que de vouloir demander la suppression de votre compte.</p>
										</div>
										<div class="box-account box-info">
											<div class="row">
												<div class="col-sm-12">
													<div class="box">
														<div class="box-title"><h3>Informations de contact</h3><a href="index.php?do=editprofile">Modifier</a></div>
														<div class="box-content">
															<h6><?= $data['prenom'] . ' ' . $data['nom'] ?></h6>
															<h6><?= $data['mail'] ?></h6>
															<h6><a href="index.php?do=editpassword">Modifier le mot de passe</a></h6></div>
													</div>
												</div>
											</div>
											<div>
												<div class="box">
													<div class="box-title"><h3>Adresse</h3><a href="index.php?do=editprofile">Modifier</a></div>
													<div class="row">
														<div class="col-sm-12">
															<h6>Adresse de livraison et de facturation</h6>
															<?php
															if ($data['adresse'])
															{
																?>
																<address><?= $data['adresse'] . '<br />' . $data['code_post'] . ' ' . $data['ville'] ?></address>
																<?php
															}
															else
															{
																?>
																<address>You have not set a default billing address.<br><a href="javascript:void(0)">Edit Address</a></address>
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
				<script src="assets/js/script.js" ></script>

				<?php

				if ($_SESSION['profile']['edit'] === 1)
				{
					ViewTemplate::FrontNotify('Modification du profil', 'Profil modifié avec succès !', 'success');
					unset($_SESSION['profile']['edit']);
				}

				?>

			</body>
		</html>
	<?php
	}

	/**
	 * Returns the HTML form to allow the customer to edit their profile.
	 *
	 * @return void
	 */
	public static function CustomerProfile()
	{
		global $config;

		$pagetitle = 'Modifier mon profil';

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);
		$data = $customer->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'editprofile' => $pagetitle]);
					?>

					<!-- personal detail section start -->
					<section class="contact-page register-page section-big-py-space b-g-light">
						<div class="custom-container">
							<form action="index.php?do=saveprofile" method="post">
								<div class="row">
									<div class="col-lg-6">
										<h3 class="mb-3">INFORMATIONS PERSONNELLES</h3>
											<div class="theme-form">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="firstname">Prénom</label>
														<input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du prénom n'est pas valide." placeholder="Insérez votre prénom"<?= ($data['prenom'] ? ' value="' . $data["prenom"] . '"' : '') ?> required />
														<small id="firstnameHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="lastname">Nom</label>
														<input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du nom n'est pas valide." placeholder="Insérez votre nom"<?= ($data['nom'] ? ' value="' . $data["nom"] . '"' : '') ?> required />
														<small id="lastnameHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="telephone">Téléphone</label>
														<input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephoneHelp" data-type="telephone" data-message="Le format du numéro de téléphone n'est pas valide." placeholder="Insérez votre téléphone"<?= ($data['tel'] ? ' value="' . $data["tel"] . '"' : '') ?> required />
														<small id="telephoneHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="mail">Adresse Email</label>
														<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Insérez votre adresse email"<?= ($data['mail'] ? ' value="' . $data["mail"] . '"' : '') ?> required />
														<small id="emailHelp" class="form-text text-muted"></small>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<h3 class="mb-3 spc-responsive">ADRESSE DE LIVRAISON</h3>
										<div class="theme-form">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="address">Adresse *</label>
														<input type="text" class="form-control" id="address" name="address" aria-describedby="addressHelp" data-type="address" data-message="Le format de l'adresse postale n'est pas valide." placeholder="Adresse"<?= ($data['adresse'] ? ' value="' . $data["adresse"] . '"' : '') ?> required />
														<small id="addressHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="zipcode">Code postal *</label>
														<input type="text" class="form-control" id="zipcode" name="zipcode" aria-describedby="zipcodeHelp" data-type="zipcode" data-message="Le format du code postal n'est pas valide." placeholder="Code postal"<?= ($data['code_post'] ? ' value="' . (strlen($data['code_post']) === 4 ? '0' . $data["code_post"] : $data["code_post"]) . '"' : '') ?> required />
														<small id="zipcodeHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="city">Ville *</label>
														<input type="text" class="form-control" id="city" name="city" aria-describedby="cityHelp" data-type="city" data-message="Le format de la ville n'est pas valide." placeholder="Ville"<?= ($data['ville'] ? ' value="' . $data["ville"] . '"' : '') ?> required />
														<small id="cityHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-12">
													<input type="hidden" name="id" value="<?= $data['id'] ?>" />
													<button class="btn btn-sm btn-normal" type="submit" id="valider">Enregistrer les modifications</button>
													<button class="btn btn-sm btn-danger" type="reset">Réinitialiser</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
					<!-- Section ends -->

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
					<script src="assets/js/script.js" ></script>

					<?php

					if ($_SESSION['profile']['edit'] === 1)
					{
						ViewTemplate::FrontNotify('Modification du profil', 'Profil modifié avec succès !', 'success');
						unset($_SESSION['profile']['edit']);
					}

					ViewTemplate::FrontFormValidation('valider', 3, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML form to edit customer password.
	 *
	 * @param integer $id ID of the customer.
	 * @param string $token Generated token of the customer to change password if forgotten.
	 *
	 * @return void
	 */
	public static function CustomerPassword($id = '', $token = '')
	{
		global $config;

		$pagetitle = 'Modifier mon mot de passe';

		$customer = new ModelCustomer($config);

		if ($id)
		{
			$customer->set_id($id);
		}
		else
		{
			$customer->set_id($_SESSION['user']['id']);
		}

		$data = $customer->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'editpassword' => $pagetitle]);
					?>

					<!-- personal detail section start -->
					<section class="contact-page register-page section-big-py-space b-g-light">
						<div class="custom-container">
							<form action="index.php?do=savepassword" method="post">
								<div class="row">
									<div class="col-lg-6">
										<h3 class="mb-3 spc-responsive">MOT DE PASSE</h3>
										<div class="theme-form">
											<div class="row">
												<?php
												if (!$token)
												{
													?>
													<div class="col-md-12">
														<div class="form-group">
															<label >Mot de passe actuel *</label>
															<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" data-message="Le mot de passe original est manquant." placeholder="Mot de passe" />
															<small id="passwordHelp" class="form-text text-muted"></small>
														</div>
													</div>
													<?php
												}
												?>
												<div class="col-md-12">
													<div class="form-group">
														<label >Nouveau mot de passe *</label>
														<input type="password" class="form-control" id="newpassword" name="newpassword" aria-describedby="newpasswordHelp" data-message="Le format du mot de passe n'est pas correct." placeholder="Nouveau mot de passe" />
														<small id="newpasswordHelp" class="form-text text-muted"></small>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label >Confirmation du nouveau mot de passe *</label>
														<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirmation du mot de passe" />
													</div>
												</div>
												<div class="col-md-12">
													<input type="hidden" name="id" value="<?= $data['id'] ?>" />
													<?= ($token ? '<input type="hidden" name="token" value="' . $token['token'] . '" />' : '') ?>
													<button class="btn btn-sm btn-normal" id="valider" type="submit">Enregistrer les modifications</button>
													<button class="btn btn-sm btn-danger" type="reset">Réinitialiser</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
					<!-- Section ends -->

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
					<script src="assets/js/script.js" ></script>

					<?php

					if ($_SESSION['password']['edit'] === 1)
					{
						ViewTemplate::FrontNotify('Modification du mot de passe', 'Mot de passe modifié avec succès !', 'success');
						unset($_SESSION['password']['edit']);
					}

					if ($token)
					{
						$removeitem = 4;
					}
					else
					{
						$removeitem = 3;
					}

					ViewTemplate::FrontFormValidation('valider', $removeitem, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML form to change the password if forgotten.
	 *
	 * @return void
	 */
	public static function CustomerForgotPassword()
	{
		global $config;

		$pagetitle = 'Mot de passe oublié';

		$customer = new ModelCustomer($config);

		if ($id)
		{
			$customer->set_id($id);
		}
		else
		{
			$customer->set_id($_SESSION['user']['id']);
		}

		$data = $customer->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'forgotpassword' => $pagetitle]);
					?>

					<!--section start-->
					<section class="login-page pwd-page section-big-py-space b-g-light">
						<div class="container">
							<div class="row">
								<div class="col-lg-6 offset-lg-3">
									<div class="theme-card">
									<h3>Oubli du mot de passe</h3>
									<form class="theme-form" action="index.php?do=sendpassword" method="post">
										<div class="row">
											<div class="col-md-12">
											  <div class="form-group">
												  <input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="L'adresse email n'est pas une adresse email valide." placeholder="Insérez votre adresse email" />
												  <small id="emailHelp" class="form-text text-muted"></small>
											  </div>
											  <div class="form-group mb-0">
												<button class="btn btn-normal" id="valider" type="submit">Envoyer</button>
											  </div>
											</div>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!--Section ends-->

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
					<script src="assets/js/script.js" ></script>

					<?php

					if ($_SESSION['password']['forgot'] === 1)
					{
						ViewTemplate::FrontNotify('Oubli du mot de passe', 'Demande de nouveau mot de passe effectuée avec succès !', 'success');
						unset($_SESSION['password']['forgot']);
					}

					ViewTemplate::FrontFormValidation('valider', 1, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete profile form.
	 *
	 * @return void
	 */
	public static function CustomerDeleteProfile()
	{
		global $config;

		$pagetitle = 'Suppression de compte';

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);

		$data = $customer->getCustomerInfosFromId();

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'deleteprofile' => $pagetitle]);
					?>

					<!--section start-->
					<section class="contact-page section-big-py-space b-g-light">
						<div class="custom-container">
							<div class="row section-big-pb-space">
								<div class="col-xl-6 offset-xl-3">
									<form class="theme-form" action="index.php?do=dodeleteprofile" method="post">
										<div class="row">
											<div class="col-md-12">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" name="deleteprofile" id="name" value="1" />
													<label for="name">Oui, je souhaite la suppression de mon compte et de toutes les données associées.</label>
											   </div>
											</div>
											<div class="col-md-12">
												<input type="hidden" name="id" value="<?= $data['id'] ?>" />
												<button class="btn btn-normal" type="submit">Supprimer mon compte</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
					<!--Section ends-->

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
					<script src="assets/js/script.js" ></script>

					<?php

					if ($_SESSION['password']['forgot'] === 1)
					{
						ViewTemplate::FrontNotify('Oubli du mot de passe', 'Demande de nouveau mot de passe effectuée avec succès !', 'success');
						unset($_SESSION['password']['forgot']);
					}

					ViewTemplate::FrontFormValidation('valider', 1, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the customers orders page.
	  *
	  * @return void
	 */
	public static function DisplayOrders()
	{
		global $config, $pagenumber;

		$pagetitle = 'Liste des commandes';

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);

		$data = $customer->getCustomerInfosFromId();


		$orderlist = new ModelOrder($config);
		$orderlist->set_customer($data['id']);
		$totalorders = $orderlist->getNumberOfOrdersForCustomer();

		// Number max per page
		$perpage = 10;

		Utils::sanitize_pageresults($totalorders['nborders'], $pagenumber, $perpage, 200, 20);

		$limitlower = ($pagenumber - 1) * $perpage;
		$limitupper = ($pagenumber) * $perpage;

		if ($limitupper > $totalorders['nborders'])
		{
			$limitupper = $totalorders['nborders'];

			if ($limitlower > $totalorders['nborders'])
			{
				$limitlower = ($totalorders['nborders'] - $perpage) - 1;
			}
		}

		if ($limitlower < 0)
		{
			$limitlower = 0;
		}

		$orders = $orderlist->getAllCustomerOrders($limitlower, $perpage);

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
					ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'vieworders' => $pagetitle]);
					?>

					<!--section start-->
					<section class="cart-section order-history section-big-py-space">
						<div class="custom-container">
							<div class="row">
								<div class="col-sm-12">
									<table class="table cart-table table-responsive-xs">
										<thead>
										<tr class="table-head">
											<th scope="col">description</th>
											<th scope="col">prix</th>
											<th scope="col">détails</th>
											<th scope="col">état</th>
										</tr>
										</thead>
										<tbody>
											<?php

											foreach ($orders AS $key => $value)
											{
												$orderlist->set_id($value['id']);
												$orderdetail = $orderlist->getOrderDetails();

												$orderdetails = new ModelOrderDetails($config);
												$orderdetails->set_order($value['id']);
												$ordercontent = $orderdetails->getOrderDetails();

												$totalprice = 0;

												foreach ($ordercontent AS $key2 => $data)
												{
													$totalprice += $data['prix'] * $data['quantite'];
												}

												?>
												<tr>
													<td>
														<a href="javascript:void(0)">Commande #: <span class="dark-data"><?= $orderdetail['id'] ?></span></a>
														<div class="mobile-cart-content row">
															<div class="col-xs-3">
																<span>Nombre de produits : <?= $orderdetail['nbproduits'] ?></span>
															</div>
															<div class="col-xs-3">
																<span>Quantité totale: <?= $orderdetail['totalquantite'] ?></span>
															</div>
														</div>
													</td>
													<td>
														<h4><?= number_format($totalprice, 2) ?> &euro;</h4>
													</td>
													<td>
														<span>Nombre de produits : <?= $orderdetail['nbproduits'] ?></span>
														<br />
														<span>Quantité totale: <?= $orderdetail['totalquantite'] ?></span>
													</td>
													<td>
														<div class="responsive-data">
															<h4 class="price"><?= number_format($totalprice, 2) ?> &euro;</h4>
														</div>
														<span class="dark-data"><?= $value['etat'] ?></span>
														<br />
														<span class="dark-data"><a href="index.php?do=vieworder&amp;id=<?= $value['id'] ?>">Afficher la commande</a></span>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php
						Utils::construct_page_nav($pagenumber, $perpage, $totalorders['nborders'], 'index.php?do=vieworders', 'front');
						?>
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
					<script src="assets/js/script.js" ></script>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display a specific customer order details.
	 *
	 * @param integer $id ID of the order.
	 *
	 * @return void
	 */
	public static function DisplayOrder($id)
	{
		global $config;

		$customer = new ModelCustomer($config);
		$customer->set_id($_SESSION['user']['id']);

		$data = $customer->getCustomerInfosFromId();

		if ($data['id'] === $_SESSION['user']['id'])
		{
			$orderdetails = new ModelOrderDetails($config);
			$orderdetails->set_order(intval($id));
			$orderdetail = $orderdetails->getOrderDetails();

			$pagetitle = 'Commande #' . intval($id);

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
						ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'vieworders' => 'Liste des commandes', 'vieworder' => $pagetitle]);
						?>

						<!--order tracking start-->
						<section class="order-tracking section-big-my-space">
							<div class="container" >
								<div class="row">
									<div class="col-md-12">
										<div id="msform">
											<fieldset>
												<div class="container p-0">
													<div class="row shpping-block">
														<div class="col-lg-8">
															<div class="order-tracking-contain order-tracking-box">
																<div class="tracking-group">
																	<div class="delevery-code">
																		<h4>Commande #<?= intval($id) ?></h4>
																	</div>
																</div>
																<div class="tracking-group pb-0">
																	<h4 class="tracking-title">Liste des produits</h4>
																	<ul class="may-product">
																		<?php
																		$totalprice = 0;
																		foreach ($orderdetail AS $key => $value)
																		{
																			$totalprice += $value['prix'] * $value['quantite'];

																			if (empty($value['photo']))
																			{
																				$value['photo'] = 'assets/images/nophoto.jpg';
																			}
																			else
																			{
																				$value['photo'] = 'attachments/products/' . $value['photo'];
																			}

																			$trademarks = new ModelTrademark($config);
																			$trademarks->set_id($value['id_marque']);
																			$trademark = $trademarks->listTrademarkInfos();
																			?>
																			<li>
																				<div class="media">
																					<img src="<?= $value['photo'] ?>" class="img-fluid" alt="" />
																					<div class="media-body">
																						<h3><a href="index.php?do=viewproduct&amp;id=<?= $value['id_produit'] ?>"><?= $trademark['nom'] ?> - <?= $value['nom'] ?></a></h3>
																						<h5>Prix à l'unité : <?= number_format($value['prix'], 2) ?> &euro;</h5>
																						<h5>Quantité : <?= $value['quantite'] ?></h5>
																						<br />
																						<h4><?= number_format($value['prix'] * $value['quantite'], 2) ?> &euro;</h4>
																					</div>
																				</div>
																			</li>
																			<?php
																		}
																		?>
																	</ul>
																</div>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="order-tracking-sidebar order-tracking-box">
																<ul class="cart_total">
																	<li>
																		subtotal : <span><?= number_format($totalprice, 2) ?> &euro;</span>
																	</li>
																	<li>
																		shipping <span>free</span>
																	</li>
																	<li>
																		<div class="total">
																			total<span><?= number_format($totalprice, 2) ?> &euro;</span>
																		</div>
																	</li>
																	<li class="pt-0">
																		<div class="buttons">
																			<a href="javascript:void(0)" class="btn btn-solid btn-sm btn-block mt-1">Faire une réclamation</a>
																			<a href="javascript:void(0)" class="btn btn-solid btn-sm btn-block mt-1">Exporter ma facture</a>
																		</div>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
											</fieldset>
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
						<script src="assets/js/script.js" ></script>
					</body>
				</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à afficher cette page.');
		}
	}

	/**
	 * Returns the HTMl code to display the customer messages.
	 *
	 * @return void
	 */
	public static function ViewMessages()
	{
		if (!empty($_SESSION['user']['id']))
		{
			global $config, $pagenumber;

			$pagetitle = 'Liste des messages';

			$customer = new ModelCustomer($config);
			$customer->set_id($_SESSION['user']['id']);

			$data = $customer->getCustomerInfosFromId();

			$messagelist = new ModelMessage($config);
			$messagelist->set_customer($data['id']);
			$messagelist->set_type('contact', 'notif');
			$totalmessages = $messagelist->countMessagesFromCustomer();

			// Number max per page
			$perpage = 10;

			Utils::sanitize_pageresults($totalmessages['nbmessages'], $pagenumber, $perpage, 200, 20);

			$limitlower = ($pagenumber - 1) * $perpage;
			$limitupper = ($pagenumber) * $perpage;

			if ($limitupper > $totalmessages['nbmessages'])
			{
				$limitupper = $totalmessages['nbmessages'];

				if ($limitlower > $totalmessages['nbmessages'])
				{
					$limitlower = ($totalmessages['nbmessages'] - $perpage) - 1;
				}
			}

			if ($limitlower < 0)
			{
				$limitlower = 0;
			}

			$messages = $messagelist->getAllMessagesFromCustomer($limitlower, $perpage);

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
						ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'viewmessages' => $pagetitle]);
						?>

						<!--section start-->
						<section class="cart-section order-history section-big-py-space">
							<div class="custom-container">
								<div class="row">
									<div class="col-sm-12">
										<table class="table cart-table table-responsive-xs">
											<thead>
											<tr class="table-head">
												<th scope="col">message</th>
												<th scope="col">état</th>
											</tr>
											</thead>
											<tbody>
												<?php

												foreach ($messages AS $key => $value)
												{
													if ($value['precedent_id'] === NULL)
													{
														if (strlen($value['message']) > 40)
														{
															$value['shortmessage'] = substr($value['message'], 0, 40) . '...';
														}
														else
														{
															$value['shortmessage'] = $value['message'];
														}
													?>
													<tr>
														<td>
															<a href="javascript:void(0)"><span class="dark-data"><?= $value['shortmessage'] ?></span></a>
														</td>
														<td>
															<?= ($value['type'] == 'contact' ? '<span class="dark-data"><a href="index.php?do=viewmessage&amp;id=' . $value['id'] . '">Afficher la conversation</a></span>' : '&nbsp;') ?>
														</td>
													</tr>
													<?php
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php
							Utils::construct_page_nav($pagenumber, $perpage, $totalmessages['nbmessages'], 'index.php?do=viewmessages', 'front');
							?>
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
						<script src="assets/js/script.js" ></script>
					</body>
				</html>
			<?php
		}
		else
		{
			throw new Exception('Vous devez vous identifier avant de pouvoir consulter vos messages.');
		}
	}

	/**
	 *
	 */
	public static function ViewMessage($id)
	{
		if (!empty($_SESSION['user']['id']))
		{
			global $config;

			$pagetitle = 'Conversation';

			$customer = new ModelCustomer($config);
			$customer->set_id($_SESSION['user']['id']);

			$data = $customer->getCustomerInfosFromId();

			$messagelist = new ModelMessage($config);
			$messagelist->set_id($id);
			$messagelist->set_previous($id);

			$totalmessages = 0;

			do
			{
				$messagelist->set_previous($$value['id']);
				$totalmessages++;
			}
			while ($value = $messagelist->countMessagesFromDiscussion());

			echo $totalmessages;exit;exit;exit;exit;exit;exit;exit;

			$firstmessage = $messagelist->getFirstMessageFromDiscussion();
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
						ViewTemplate::FrontBreadcrumb($pagetitle, ['profile' => 'Tableau de bord', 'viewmessages' => 'Liste des messages', 'viewmessage&amp;id=' => $pagetitle]);
						?>

						<!--section start-->
						<section class="cart-section order-history section-big-py-space">
							<div class="custom-container">
								<div class="row">
									<div class="col-sm-12">
										<table class="table cart-table table-responsive-xs">
											<thead>
											<tr class="table-head">
												<th scope="col">interlocuteur</th>
												<th scope="col">message</th>
											</tr>
											</thead>
											<tbody>
												<tr>
													<td><?= $value['id_employe'] ?></td>
													<td>
														<a href="javascript:void(0)"><span class="dark-data"><?= $firstmessage['message'] ?></span></a>
													</td>
												</tr>
												<?php
												$nbmessages = 1;

												do
												{
													$messagelist->set_previous($firstmessage['id']);
													$message = $messagelist->getMessageFromDiscussion();
													$nbmessages++;
													?>
													<tr>
														<td><?= $message['id_employe'] ?></td>
														<td>
															<a href="javascript:void(0)"><span class="dark-data"><?= $message['message'] ?></span></a>
														</td>
													</tr>
													<?php
												}
												while ($nbmessages < $totalmessages['nbmessages']);
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
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
						<script src="assets/js/script.js" ></script>
					</body>
				</html>
			<?php
		}
		else
		{
			throw new Exception('Vous devez vous identifier avant de pouvoir consulter vos messages.');
		}
	}
}

?>