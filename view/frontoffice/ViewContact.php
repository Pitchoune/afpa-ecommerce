<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelMessage;

/**
 * Class to display HTML content about contacting the team.
 */
class ViewContact
{
	/**
	 * Returns the HTML code to contact the team.
	 *
	 * @param integer $customer Customer informations.
	 *
	 * @return void
	 */
	public static function DisplayContactForm($customer = '')
	{
		$pagetitle = 'Contact';

		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?= ViewTemplate::FrontHead($pagetitle) ?>
			</head>
			<body class="bg-light">
				<?php
				ViewTemplate::FrontHeader();

				ViewTemplate::FrontBreadcrumb('Contact', ['index.php?do=contact' => 'Contact']);
				?>

				<!-- contact -->
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
											<div class="form-group">
												<label for="title">Intitulé</label>
												<input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp" data-type="title" data-message="Le format de l'intitulé n'est pas valide." placeholder="Titre" required />
												<small id="titleHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="col-md-12">
											<div>
												<label for="message">Votre Message</label>
												<textarea class="form-control" id="message" name="message" aria-describedby="messageHelp" data-type="message" data-message="Le format du message n'est pas valide." placeholder="Écrivez votre message" rows="10"></textarea>
												<small id="messageHelp" class="form-text text-muted"></small>
											</div>
										</div>
										<div class="col-md-12">
											<input type="hidden" name="do" value="sendcontact" />
											<button class="btn btn-normal" type="submit" id="validation">Envoyer votre message</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
				<!-- / contact -->
				<?php
				ViewTemplate::FrontFooter();

				if ($_SESSION['userloggedin'] === 1)
				{
					ViewTemplate::FrontNotify('Identification', 'Vous vous êtes identifié avec succès !', 'success');
					unset($_SESSION['userloggedin']);
				}

				ViewTemplate::FrontFormValidation('validation', 2, 1);
				?>
			</body>
		</html>
		<?php
	}
}

?>
