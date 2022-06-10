<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelEmployee.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelEmployee;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelTrademark;

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

				ViewTemplate::FrontBreadcrumb($pagetitle, ['register' => $pagetitle]);
				?>
				<!-- register -->
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
											<div class="col-md-12 form-group"><input type="submit" id="validation" class="btn btn-normal" value="S'inscrire" /></div>
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
				<!-- / register -->
				<?php
				ViewTemplate::FrontFooter();

				ViewTemplate::FrontFormValidation('validation', 2, 1);
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

				ViewTemplate::FrontBreadcrumb($pagetitle, ['login' => $pagetitle]);
				?>
				<!-- login -->
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
										<input type="submit" class="btn btn-normal" id="validation" value="S'identifier" />
										<a class="float-end txt-default mt-2" href="index.php?do=forgotpassword">Oubli de votre mot de passe ?</a>
									</form>
									<p class="mt-3">Inscrivez-vous gratuitement sur notre boutique. L'inscription est rapide et facile. Ceci vous permettra d'effectuer vos achats depuis notre boutique. Pour commencer, cliquez sur « Créez votre compte ».</p>
									<a href="index.php?do=register" class="txt-default pt-3 d-block">Créez votre compte</a>
								</div>
							</div>
						</div>
					</div>
				</section>
				<!-- / login -->
				<?php
				ViewTemplate::FrontFooter();

				ViewTemplate::FrontFormValidation('validation', 2, 1);
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML form to display the customer dashboard.
	 *
	 * @param array $data Logged-in user data.
	 *
	 * @return void
	 */
	public static function CustomerDashboard($data)
	{
		$pagetitle = 'Tableau de bord';

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

				ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => $pagetitle]);
				?>
				<!-- dashboard -->
				<section class="section-big-py-space b-g-light">
					<div class="container">
						<div class="row">
							<div class="col-lg-3">
								<div class="account-sidebar"><a class="popup-btn">Mon compte</a></div>
								<div class="dashboard-left">
									<div class="collection-mobile-back">
										<span class="filter-back">Fermer</span>
									</div>
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
																<address>Vous n'avez pas défini d'adresse.<br /><a href="javascript:void(0)">Modifier l'adresse</a></address>
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
				<!-- / dashboard -->
				<?php
				ViewTemplate::FrontFooter();

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
	 * @param array $data Logged-in user data.
	 *
	 * @return void
	 */
	public static function CustomerProfile($data)
	{
		$pagetitle = 'Modifier mon profil';

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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'editprofile' => $pagetitle]);
					?>
					<!-- personal details -->
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
												<div class="col-md-12">
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
													<button class="btn btn-sm btn-normal" type="submit" id="validation">Enregistrer les modifications</button>
													<button class="btn btn-sm btn-danger" type="reset">Réinitialiser</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
					<!-- / personal details -->
					<?php
					ViewTemplate::FrontFooter();

					if ($_SESSION['profile']['edit'] === 1)
					{
						ViewTemplate::FrontNotify('Modification du profil', 'Profil modifié avec succès !', 'success');
						unset($_SESSION['profile']['edit']);
					}

					ViewTemplate::FrontFormValidation('validation', 3, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML form to edit customer password.
	 *
	 * @param array $data Logged-in user data.
	 * @param string $token Generated token of the customer to change password if forgotten.
	 *
	 * @return void
	 */
	public static function CustomerPassword($data, $token = '')
	{
		$pagetitle = 'Modifier mon mot de passe';
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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'editpassword' => $pagetitle]);
					?>
					<!-- password change -->
					<section class="contact-page register-page section-big-py-space b-g-light">
						<div class="custom-container">
							<form action="index.php?do=savepassword" method="post">
								<div class="row">
									<div class="col-lg-6 col-md-8 offset-lg-3 offset-md-2">
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
															<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" data-message="Le mot de passe original est manquant." placeholder="Mot de passe actuel" />
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
														<input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirmation du nouveau mot de passe" />
													</div>
												</div>
												<div class="col-md-12">
													<input type="hidden" name="id" value="<?= $data['id'] ?>" />
													<?= ($token ? '<input type="hidden" name="token" value="' . $token['token'] . '" />' : '') ?>
													<button class="btn btn-sm btn-normal" id="validation" type="submit">Enregistrer les modifications</button>
													<button class="btn btn-sm btn-danger" type="reset">Réinitialiser</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</section>
					<!-- / password change -->
					<?php
					ViewTemplate::FrontFooter();

					if ($_SESSION['password']['edit'] === 1)
					{
						ViewTemplate::FrontNotify('Modification du mot de passe', 'Mot de passe modifié avec succès !', 'success');
						unset($_SESSION['password']['edit']);
					}

					ViewTemplate::FrontFormValidation('validation', $token ? 4 : 3, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML form to change the password if forgotten.
	 *
	 * @param array $data Logged-in user data.
	 *
	 * @return void
	 */
	public static function CustomerForgotPassword($data)
	{
		$pagetitle = 'Mot de passe oublié';

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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'forgotpassword' => $pagetitle]);
					?>

					<!-- forgot password -->
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
												<button class="btn btn-normal" id="validation" type="submit">Envoyer</button>
											  </div>
											</div>
										</div>
									</form>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- / forgot password -->

					<?php
					ViewTemplate::FrontFooter();

					if ($_SESSION['password']['forgot'] === 1)
					{
						ViewTemplate::FrontNotify('Oubli du mot de passe', 'Demande de nouveau mot de passe effectuée avec succès !', 'success');
						unset($_SESSION['password']['forgot']);
					}

					ViewTemplate::FrontFormValidation('validation', 1, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete profile form.
	 *
	 * @param array $data Logged-in user data.
	 *
	 * @return void
	 */
	public static function CustomerDeleteProfile($data)
	{
		$pagetitle = 'Suppression de compte';

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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'deleteprofile' => $pagetitle]);
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

					if ($_SESSION['password']['forgot'] === 1)
					{
						ViewTemplate::FrontNotify('Oubli du mot de passe', 'Demande de nouveau mot de passe effectuée avec succès !', 'success');
						unset($_SESSION['password']['forgot']);
					}
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the customers orders page.
	 *
	 * @param array $orders List of orders to display.
	 * @param object $orderlist Order object.
	 * @param array $totalorders Total number of orders.
	 * @param integer $perpage Number of orders to display per page.
	 *
	 * @return void
	 */
	public static function DisplayOrders($orders, $orderlist, $totalorders, $perpage)
	{
		global $config, $pagenumber;

		$pagetitle = 'Liste des commandes';

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

					if ($totalorders['nborders'] > 0)
					{
						ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'vieworders' => $pagetitle]);
						?>

						<!-- orders history -->
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
															<a href="index.php?do=vieworder&amp;id=<?= $value['id'] ?>">Commande #: <span class="dark-data"><?= $orderdetail['id'] ?></span></a>
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
														</td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<?php
								Utils::construct_page_nav($pagenumber, $perpage, $totalorders['nborders'], 'index.php?do=vieworders', 'front');
								?>
							</div>
						</section>
						<!-- / orders history -->

						<?php
					}
					else
					{
						ViewTemplate::FrontBreadcrumb('Erreur', '', false);

						?>
						<section class="login-page section-big-py-space b-g-light">
							<div class="custom-container">
								<div class="row">
									<div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
										<div class="theme-card">
											<div>Aucune commande trouvée.</div>
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

	/**
	 * Returns the HTML code to display a specific customer order details.
	 *
	 * @param integer $id ID of the order.
	 *
	 * @return void
	 */
	public static function DisplayOrder($id, $orderdetail)
	{
		global $config;

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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'vieworders' => 'Liste des commandes', 'vieworder&amp;id=' . $id => $pagetitle]);
					?>
					<!-- order details -->
					<section class="order-tracking section-big-my-space">
						<div class="container" >
							<div class="row">
								<div class="col-md-12">
									<div>
										<fieldset>
											<div class="container p-0">
												<div class="row shipping-block">
													<div class="col-lg-8">
														<div class="order-tracking-contain order-tracking-box">
															<div class="tracking-group">
																<div class="delivery-code">
																	<h4>Commande #<?= $id ?></h4>
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
																	Sous-total : <span><?= number_format($totalprice, 2) ?> &euro;</span>
																</li>
																<li>
																	Livraison :<span>Gratuit</span>
																</li>
																<li>
																	<div class="total">
																		Total :<span><?= number_format($totalprice, 2) ?> &euro;</span>
																	</div>
																</li>
																<li class="pt-0">
																	<div class="buttons">
																		<a href="index.php?do=claim&id=<?= $id ?>" class="btn btn-normal btn-sm btn-block">Faire une réclamation</a>
																		<a href="javascript:void(0)" class="btn btn-normal btn-sm btn-block">Exporter ma facture</a>
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
					<!-- / order details -->
					<?php
					ViewTemplate::FrontFooter();
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the customer messages.
	 *
	 * @return void
	 */
	public static function ViewMessages($messages, $perpage, $nbmessages)
	{
		global $pagenumber;

		$pagetitle = 'Liste des messages';

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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'viewmessages' => $pagetitle]);
					?>
					<!-- messages -->
					<section class="messages-section order-history section-big-py-space">
						<div class="custom-container">
							<div class="row">
								<div class="col-sm-12">
									<table class="table messages-table table-responsive-xs">
										<thead>
										<tr class="table-head">
											<th scope="col">De</th>
											<th scope="col">Sujet</th>
											<th scope="col">Reçu le</th>
										</tr>
										</thead>
										<tbody>
											<?php
											foreach ($messages AS $key => $value)
											{
												?>
												<tr>
													<td>
														<?= ($value['type'] == 'notif' ? 'Système' : $value['nom_client']) ?>
														<div class="mobile-messages-content row">
															<div class="col-xs-3">
																Reçu le <?= $value['date'] ?>
															</div>
														</div>
													</td>
													<td>
														<?= (in_array($value['type'], array('contact', 'reclam')) ? '<a href="index.php?do=viewmessage&amp;id=' . $value['id'] . '">' : '') ?><span class="dark-data"><?= $value['titre'] ?></span><?= ($value['type'] == 'contact' ? '</a>' : '') ?>
													</td>
													<td>
														<?= $value['date'] ?>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<?php
							Utils::construct_page_nav($pagenumber, $perpage, $nbmessages, 'index.php?do=viewmessages', 'front');
							?>
						</div>
					</section>
					<!-- / messages -->
					<?php
					ViewTemplate::FrontFooter();
					?>
				</body>
			</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the messages list of a conversation.
	 *
	 * @param integer $id ID of the conversation.
	 * @param array $messages Array containing messages informations
	 * @param string $title Title of the conversation.
	 * @param array $customerinfos Customer informations.
	 * @param integer $latestid Latest message ID of the conversation.
	 * @param array $employee Employee informations.
	 *
	 * @return void
	 */
	public static function ViewMessage($id, $messages, $title, $customerinfos, $latestid, $employee)
	{
		global $config;

		$pagetitle = 'Conversation';
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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'viewmessages' => 'Liste des messages', 'viewmessage&amp;id=' . $id => $pagetitle]);
					?>
					<!-- messaging -->
					<section class="order-tracking section-big-mt-space">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div>
										<fieldset>
											<div class="container p-0">
												<div class="order-tracking-contain order-tracking-box">
													<div class="tracking-group">
														<div class="delivery-code">
															<h4>Informations</h4>
														</div>
													</div>
													<div class="tracking-group pb-0">
														<?php
														if ($employee['prenom'] AND $employee['nom'] AND $employee['rolename'])
														{
															?>
															Échange avec <?= $employee['prenom'] ?> <?= $employee['nom'] ?>, <?= $employee['rolename'] ?>.
															<?php
														}
														else
														{
															?>
															Pas encore d'échange avec l'équipe.
															<?php
														}
														?>
													</div>
												</div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section class="order-tracking section-big-mt-space">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<fieldset>
										<div class="container p-0">
											<div class="conversations">
												<div class="message-header">
													<div class="message-title">
														<div class="user ms-2">
															<div>
																<img class="img-40 rounded-circle" src="assets/images/noavatar.png" alt="Avatar de l'employé" />
															</div>
															<div class="user-info ms-2">
																<span class="name"><?= $title ?></span>
															</div>
														</div>
													</div>
												</div>
												<div class="conversations-body">
													<div class="conversations-content">
													<?php
													foreach ($messages AS $data)
													{
														?>
														<div class="message-content-wrapper">
															<div class="message message-<?= ($data['id_client'] ? 'out' : 'in') ?>">
																<?php
																if ($data['id_employe'])
																	{ ?>
																	<div class="me-2">
																		<img class="img-40 rounded-circle" src="assets/images/noavatar.png" alt="Avatar de l'employé" />
																	</div>
																	<?php
																	}
																?>
																<div class="message-body">
																	<div class="message-content">
																		<div class="content">
																			<?= Utils::htmlSpecialCharsUni($data['message'], false) ?>
																		</div>
																	</div>
																</div>
																<?php
																if ($data['id_client'])
																	{ ?>
																	<div class="ms-2">
																		<img class="img-40 rounded-circle" src="assets/images/noavatar.png" alt="Avatar de l'employé" />
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
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section class="contact-page section-big-mb-space b-g-light">
						<div class="custom-container">
							<div class="row section-big-pb-space">
								<div class="col-xl-6 offset-xl-3">
									<h3 class="text-center mb-3">Répondre</h3>
									<form class="theme-form" method="post" action="index.php?do=sendreply">
										<div class="row">
											<div class="col-md-6">
											   <div class="form-group">
												   <label for="firstname">Prénom</label>
												   <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du prénom n'est pas valide." placeholder="Insérez votre prénom" value="<?= $customerinfos['prenom'] ?>" disabled />
												   <small id="firstnameHelp" class="form-text text-muted"></small>
											   </div>
											</div>
											<div class="col-md-6">
											  <div class="form-group">
												  <label for="lastname">Nom</label>
												  <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du nom n'est pas valide." placeholder="Nom" value="<?= $customerinfos['nom'] ?>" disabled />
												  <small id="lastnameHelp" class="form-text text-muted"></small>
											  </div>
											</div>
											<div class="col-md-6">
											   <div class="form-group">
												   <label for="telephone">Téléphone</label>
												   <input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephoneHelp" data-type="telephone" data-message="Le format du numéro de téléphone n'est pas valide." placeholder="Insérez votre numéro de téléphone" value="<?= $customerinfos['tel'] ?>" disabled />
												   <small id="telephoneHelp" class="form-text text-muted"></small>
											   </div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="email">Adresse email</label>
													<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Email" value="<?= $customerinfos['mail'] ?>" disabled />
													<small id="emailHelp" class="form-text text-muted"></small>
												</div>
											</div>
											<div class="col-md-12">
												<div>
													<label for="message">Votre Message</label>
													<textarea class="form-control" id="message" name="message" aria-describedby="messageHelp" data-type="message" data-message="Le format du message n'est pas valide." placeholder="Écrivez votre message" rows="2"></textarea>
													<small id="messageHelp" class="form-text text-muted"></small>
												</div>
											</div>
											<div class="col-md-12">
												<input type="hidden" name="do" value="sendreply" />
												<input type="hidden" name="id" value="<?= $id ?>" />
												<input type="hidden" name="latestid" value="<?= $latestid ?>" />
												<button class="btn btn-normal" type="submit" id="validation">Envoyer votre message</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</section>
					<!-- / messaging -->
					<?php
					ViewTemplate::FrontFooter();

					if ($_SESSION['user']['sendreply'] === 1)
					{
						ViewTemplate::FrontNotify('Réponse aux messages', 'Vous avez répondu au message avec succès !', 'success');
						unset($_SESSION['user']['sendreply']);
					}

					ViewTemplate::FrontFormValidation('validation', 4, 1);
					?>
				</body>
			</html>
		<?php
	}

	/**
	 *
	 */
	public static function ViewClaimOrder($id, $orderdetail)
	{
		global $config;

		$pagetitle = 'Réclamation sur la commande « #' . $id . ' »';
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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'vieworders' => 'Liste des commandes', 'vieworder&amp;id=' . $id => $pagetitle]);
					?>

					<!-- claim -->
					<section class="order-tracking section-big-my-space">
						<div class="container" >
							<div class="row">
								<div class="col-md-12">
									<div>
										<fieldset>
											<div class="container p-0">
												<form action="index.php?do=doclaim&amp;id=<?= $id ?>" method="post">
													<div class="row shipping-block">
														<div class="col-lg-8">
															<div class="order-tracking-contain order-tracking-box">
																<div class="tracking-group">
																	<div class="delivery-code">
																		<h4>Faire une réclamation</h4>
																	</div>
																</div>
																<div class="tracking-group pb-0">
																	<h4 class="tracking-title">Choisir les articles à retourner</h4>
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
																					<img src="<?= $value['photo'] ?>" class="img-fluid" alt="<?= $value['nom'] ?>" />
																					<div class="media-body">
																						<h3><a href="index.php?do=viewproduct&amp;id=<?= $value['id_produit'] ?>"><?= $trademark['nom'] ?> - <?= $value['nom'] ?></a></h3>
																						<h5>Prix à l'unité : <?= number_format($value['prix'], 2) ?> &euro;</h5>
																						<h5>Quantité : <?= $value['quantite'] ?></h5>
																						<br />
																						<h4><?= number_format($value['prix'] * $value['quantite'], 2) ?> &euro;</h4>
																						<br />
																						<select name="reason[<?= $value['id_produit'] ?>]" class="pull-right">
																							<option value="0" selected disabled>Choisir une réponse</option>
																							<option value="1">Produit incompatible ou inutile</option>
																							<option value="2">Produit endommagé mais emballage intact</option>
																							<option value="3">Achat effectué par erreur</option>
																							<option value="4">Achat non autorisé</option>
																							<option value="5">Produit et boîte d'expédition endommagés</option>
																							<option value="6">Meilleur prix trouvé ailleurs</option>
																							<option value="7">Pièces ou accessoires manquants</option>
																							<option value="8">Date de livraison estimée manquée</option>
																							<option value="9">Le produit reçu n'est pas le bon</option>
																							<option value="10">Description erronée sur le site</option>
																							<option value="11">Plus besoin du produit</option>
																							<option value="12">Arrivée en plus de ce qui a été commandé</option>
																							<option value="13">Le produit est défectueux ou ne fonctionne pas</option>
																							<option value="14">Performances ou qualité non adéquates</option>
																						</select>
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
																	<li class="pt-0">
																		<div class="buttons">
																			<input type="hidden" name="do" value="doclaim" />
																			<input type="hidden" name="id" value="<?= $id ?>" />
																			<input type="submit" value="Envoyer la réclamation" class="btn btn-normal btn-sm btn-block" />
																		</div>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</form>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
					</section>
					<!-- / claim -->

					<?= ViewTemplate::FrontFooter() ?>
				</body>
			</html>
		<?php
	}

	/**
	 *
	 */
	public static function ApplyClaimOrder($id, $messageid)
	{
		$pagetitle = 'Réclamation sur la commande « #' . $id . ' »';
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

					ViewTemplate::FrontBreadcrumb($pagetitle, ['dashboard' => 'Tableau de bord', 'vieworders' => 'Liste des commandes', 'vieworder&amp;id=' . $id => $pagetitle]);
					?>

					<section class="login-page section-big-py-space b-g-light">
						<div class="custom-container">
							<div class="row">
								<div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
									<div class="theme-card">
										<div>La réclamation a bien été effectuée, vous pouvez la retrouver et y ajouter des commentaires <a href="index.php?do=viewmessage&amp;id=<?= $messageid ?>">ici</a>.
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>

					<?= ViewTemplate::FrontFooter() ?>
				</body>
			</html>
		<?php
	}
}

?>
