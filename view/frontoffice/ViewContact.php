<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelMessage;

/**
 * Class to display HTML content about categories in front.
 *
 * @date $Date$
 */
class ViewContact
{
	/**
	 * Returns the HTMl code to display the category page.
	 *
	 * @param integer $id ID of the category.
	 *
	 * @return void
	 */
	public static function DisplayContactForm($id = '')
	{
		global $config;

		if ($_SESSION['user']['id'])
		{
			$customers = new ModelCustomer($config);
			$customers->set_id($_SESSION['user']['id']);
			$customer = $customers->getCustomerInfosFromId();
		}

		$pagetitle = 'Contact';

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
				ViewTemplate::FrontBreadcrumb('Contact', ['index.php?do=contact' => 'Contact']);
				?>

				<!--section start-->
				<section class="contact-page section-big-py-space b-g-light">
					<div class="custom-container">
						<div class="row section-big-pb-space">
							<div class="col-xl-6 offset-xl-3">
								<h3 class="text-center mb-3">Restons en contact</h3>
								<form class="theme-form" method="post" action="index.php?do=sendcontact">
									<div class="row">
										<div class="col-md-6">
										   <div class="form-group">
											   <label for="firstname">Prénom</label>
											   <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du prénom n'est pas valide." placeholder="Insérez votre prénom" value="<?= $customer['prenom'] ?>" required />
											   <small id="firstnameHelp" class="form-text text-muted"></small>
										   </div>
										</div>
										<div class="col-md-6">
										  <div class="form-group">
											  <label for="lastname">Nom</label>
											  <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du nom n'est pas valide." placeholder="Nom" value="<?= $customer['nom'] ?>" required />
											  <small id="lastnameHelp" class="form-text text-muted"></small>
										  </div>
										</div>
										<div class="col-md-6">
										   <div class="form-group">
											   <label for="telephone">Téléphone</label>
											   <input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephoneHelp" data-type="telephone" data-message="Le format du numéro de téléphone n'est pas valide." placeholder="Insérez votre numéro de téléphone" value="<?= $customer['tel'] ?>" required />
											   <small id="telephoneHelp" class="form-text text-muted"></small>
										   </div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="email">Adresse email</label>
												<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Email" value="<?= $customer['mail'] ?>" required />
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
											<input type="hidden" name="do" value="sendcontact" />
											<button class="btn btn-normal" type="submit" id="valider">Envoyer votre message</button>
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
				ViewTemplate::FrontFormValidation('valider', 2, 1);
				?>
			</body>
		</html>
		<?php
	}
}

?>