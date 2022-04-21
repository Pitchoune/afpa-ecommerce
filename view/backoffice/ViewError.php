<?php

/**
 * Class to display HTML content about any captured error in back.
 *
 * @date $Date$
 */
class ViewError
{
	/**
	 * Returns the HTML code to display the caught error when logged-out.
	 *
	 * @return void
	 */
	public static function DisplayLoggedOutError($errorMessage)
	{
		?>
		<!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h5>Erreur</h5>
				</div>
				<div class="card-body vendor-table">
					<?= $errorMessage; ?>
				</div>
			</div>
		</div>
		<!-- Container-fluid Ends-->
		<?php
	}

	/**
	 * Returns the HTML code to display the caught error when logged-in.
	 *
	 * @return void
	 */
	public static function DisplayLoggedInError($errorMessage)
	{
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<?php
				ViewTemplate::BackHead('Erreur');
				?>
			</head>

			<body>
				<div class="page-wrapper">

					<!-- Page Header Start-->
					<?php
					ViewTemplate::BackHeader();
					?>
					<!-- Page Header Ends -->

					<!-- Page Body Start-->
					<div class="page-body-wrapper">

						<!-- Page Sidebar Start-->
						<?php
						ViewTemplate::Sidebar();
						?>
						<!-- Page Sidebar Ends-->

						<div class="page-body">
							<!-- Container-fluid starts-->
							<div class="container-fluid">
								<div class="card">
									<div class="card-header">
										<h5>Erreur</h5>
									</div>
									<div class="card-body vendor-table">
										<?= $errorMessage; ?>
									</div>
								</div>
							</div>
							<!-- Container-fluid Ends-->
						</div>

						<!-- footer start-->
						<?php
						ViewTemplate::BackFooter();
						?>
						<!-- footer end-->
					</div>
				</div>
				<!-- latest jquery-->
				<script src="../assets/js/jquery-3.3.1.min.js"></script>

				<!-- Bootstrap js-->
				<script src="../assets/js/popper.min.js"></script>
				<script src="../assets/js/bootstrap.js"></script>

				<!-- feather icon js-->
				<script src="../assets/js/icons/feather-icon/feather.min.js"></script>
				<script src="../assets/js/icons/feather-icon/feather-icon.js"></script>

				<!-- Sidebar jquery-->
				<script src="../assets/js/sidebar-menu.js"></script>
				<script src="../assets/js/slick.js"></script>

				<!--Customizer admin-->
				<script src="../assets/js/admin-customizer.js"></script>

				<!--script admin-->
				<script src="../assets/js/admin-script.js"></script>
			</body>
		</html>
		<?php
	}
}
