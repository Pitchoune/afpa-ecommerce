<?php

/**
 * Class to display HTML content about first page in front.
 *
 * @date $Date$
 */
class ViewIndex
{
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
					<!-- loader start -->
					<div class="loader-wrapper">
					  <div>
						<img src="assets/images/loader.gif" alt="loader">
					  </div>
					</div>
					<!-- loader end -->

					<?php
					ViewTemplate::FrontHeader();
					?>

					<?php
					ViewTemplate::FrontBreadcrumb('', '');
					?>

					<p>Page en cours, contenu à venir une fois que les produits seront gérés en admin.</p>
					<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />La page a un contenu vide assez haut car si sa hauteur est trop courte, le template foire.
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
					</p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

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

					?>

				</body>
			</html>
		<?php
	}
}

?>