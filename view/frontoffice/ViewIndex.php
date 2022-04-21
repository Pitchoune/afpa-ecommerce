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

					<p>Page en cours</p>
					<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					<p>
					<?php
					if ($_SESSION['user']['loggedin'] !== true)
					{
					?>
						 Déconnecté<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					 <?php
					}
					else
					{
					?>
						 Connecté<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
					 <?php
					}

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
				</body>
			</html>
		<?php
	}
}

?>