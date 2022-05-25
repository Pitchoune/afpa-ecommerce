<?php

/**
 * Class to display HTML content about any captured error in front.
 *
 * @date $Date$
 */
class ViewError
{
	/**
	 * Returns the HTMl code to display any error message.
	 *
	 * @param string $errorMessage The error message to display.
	 *
	 * @return void
	 */
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
				<?php
				ViewTemplate::FrontHeader();

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
			</body>
		</html>
		<?php
	}
}

?>