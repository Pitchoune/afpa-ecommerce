<?php

/**
 * Class to display HTML content about any captured error in front.
 *
 * @date $Date$
 */
class ViewError
{
	public static function DisplayError($errorMessage)
	{
		$pagetitle = 'Erreur';

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
				ViewTemplate::FrontBreadcrumb('Erreur', '');
				?>

				<section class="login-page section-big-py-space b-g-light">
					<div class="custom-container">
						<div class="row">
							<div class="col-xl-4 col-lg-6 col-md-8 offset-xl-4 offset-lg-3 offset-md-2">
								<div class="theme-card">
									<div><?= $errorMessage; ?></div>
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
			</body>
		</html>
		<?php
	}
}


?>