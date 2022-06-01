<?php

/**
 * Class to display HTML content about any captured error in back.
 */
class ViewError
{
	/**
	 * Returns the HTML code to display the caught error when logged-out.
	 *
	 * @param string $errorMessage Error message to display.
	 *
	 * @return void
	 */
	public static function DisplayLoggedOutError($errorMessage)
	{
		?>
		<!-- error -->
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
		<!-- / error-->
		<?php
	}

	/**
	 * Returns the HTML code to display the caught error when logged-in.
	 *
	 * @param string $errorMessage Error message to display.
	 *
	 * @return void
	 */
	public static function DisplayLoggedInError($errorMessage)
	{
		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead('Erreur') ?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- body -->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
							<?= ViewTemplate::Breadcrumb('Erreur', ['' => 'Erreur']) ?>

							<!-- error -->
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
							<!-- / error -->
						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->
				</div>

				<?= ViewTemplate::BackFoot() ?>
			</body>
		</html>
		<?php
	}
}
