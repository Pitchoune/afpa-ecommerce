<?php

/**
 * Class to display HTML content about delivers in back.
 */
class ViewDeliver
{
	/**
	 * Returns the HTML code to display the deliver list.
	 *
	 * @param object $delivers Model object of delivers.
	 * @param array $deliverlist List of all delivers for the current page.
	 * @param array $totaldelivers Total number of delivers in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function DeliverList($delivers, $deliverlist, $totaldelivers, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des transporteurs';
		$navtitle = 'Liste des transporteurs';

		$navbits = [
			'index.php?do=listdelivers' => $pagetitle,
			'' => $navtitle
		];

		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead($pagetitle) ?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- Page Body Start-->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
						<?php
						if (count($deliverlist) > 0)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- delivers listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(19))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=adddeliver" type="button" class="btn btn-secondary">Ajouter un transporteur</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="tablegrid">
														<div class="tablegrid-grid-header">
															<table class="tablegrid-table">
																<thead>
																	<tr class="tablegrid-header-row">
																		<th class="tablegrid-header-cell" style="width: 75px">Logo</th>
																		<th class="tablegrid-header-cell tablegrid-header-sortable" style="width: 125px">Intitul??</th>
																		<?php
																		if (Utils::cando(20) OR Utils::cando(22))
																		{
																			?>
																			<th class="tablegrid-header-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">Actions</th>
																			<?php
																		}
																		?>
																	</tr>
																</thead>
															</table>
														</div>
														<div class="tablegrid-grid-body">
															<table class="tablegrid-table">
																<tbody>
																	<?php
																	// Get the number of delivers returned by the model for background lines
																	$quantity = count($deliverlist);

																	foreach ($deliverlist AS $data)
																	{
																		$delivers->set_id($data['id']);
																		$compteur = $delivers->getNumberOfOrdersInDeliver();
																		$data['compteur'] = intval($compteur['compteur']);
																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																				<td class="tablegrid-cell" style="width: 75px">
																				<?= ($data['logo'] ? '<img src="../attachments/delivers/' . $data['logo'] . '" alt="" width="50px" height="50px" />' : '') ?>
																				</td>
																			<td class="tablegrid-cell" style="width: 125px"><?= $data['nom']; ?></td>
																			<?php
																			if (Utils::cando(20) OR Utils::cando(22))
																			{
																				?>
																				<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																					<?php
																					if (Utils::cando(20))
																					{
																						?>
																						<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editdeliver&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																					}

																					if (Utils::cando(22))
																					{
																						if ($data['compteur'] === 0 OR $totaldelivers['nbdelivers'] >= 2)
																						{
																						?>
																							<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deletedeliver&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																						}
																					}
																					?>
																				</td>
																				<?php
																			}
																			?>
																		</tr>
																	<?php
																	}
																	?>
																</tbody>
															</table>
														</div>
														<?php
														Utils::construct_page_nav($pagenumber, $perpage, $totaldelivers['nbdelivers'], 'index.php?do=listdelivers', 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / delivers listing -->

							<?php
						}
						else
						{
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>

							<!-- delivers listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5>Liste des transporteurs</h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(19))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=adddeliver" type="button" class="btn btn-secondary">Ajouter un transporteur</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de transporteur.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / delivers listing -->
							<?php
						}
						?>
						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->
				</div>

				<?php
				ViewTemplate::BackFoot();

				if (isset($_SESSION['deliver']['add']) AND $_SESSION['deliver']['add'] === 1)
				{
					ViewTemplate::BackToast('Ajout de transporteur', 'Transporteur ajout?? avec succ??s !');
					unset($_SESSION['deliver']['add']);
				}

				if (isset($_SESSION['deliver']['edit']) AND $_SESSION['deliver']['edit'] === 1)
				{
					ViewTemplate::BackToast('Modification de transporteur', 'Transporteur modifi?? avec succ??s !');
					unset($_SESSION['deliver']['edit']);
				}

				if (isset($_SESSION['deliver']['delete']) AND $_SESSION['deliver']['delete'] === 1)
				{
					ViewTemplate::BackToast('Suppression de transporteur', 'Transporteur supprim?? avec succ??s !');
					unset($_SESSION['deliver']['delete']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the add or edit deliver form.
	 *
	 * @param string $navtitle Title of the page to show in the breadcrumb.
	 * @param array $navbits Breadcrumb content.
	 * @param array $deliverinfos Default values to show as default in fields.
	 * @param string $formredirect Redirect part of the URL to save data.
	 * @param string $pagetitle Title of the page.
	 * @param integer $id ID of the deliver if we need to edit an existing deliver. Empty for a new deliver.
	 *
	 * @return void
	 */
	public static function DeliverAddEdit($navtitle, $navbits, $deliverinfos, $formredirect, $pagetitle, $id = '')
	{
		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead($pagetitle) ?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- body -->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
							<?= ViewTemplate::Breadcrumb($pagetitle, $navbits) ?>

							<!-- add/edit trademarks -->
							<div class="container-fluid">
								<div class="row product-adding">
									<div class="col">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<form class="digital-add" enctype="multipart/form-data" method="post" action="index.php?do=<?= $formredirect ?>">
													<div class="form-group">
														<label for="title" class="col-form-label pt-0">Intitul?? <span>*</span></label>
														<input type="text" class="form-control" id="title" name="name" aria-describedby="titleHelp" data-type="title" data-message="Le format de l'intitul?? n'est pas valide." required value="<?= $deliverinfos['nom'] ?>">
														<small id="titleHelp" class="form-text text-muted"></small>
													</div>
													<?php
													if (Utils::cando(21))
													{
														?>
														<div class="form-group">
															<label for="logo" class="col-form-label pt-0">Logo <span>*</span></label><br />
															<input type="file" id="logo" name="file" />
														</div>
														<?php
													}
													?>
													<div class="form-group mb-0">
														<div class="product-buttons text-center">
															<input type="hidden" name="do" value="<?= $formredirect ?>" />
															<?php
															if ($id)
															{
															?>
															<input type="hidden" name="id" value="<?= $id ?>" />
															<?php
															}
															?>
															<input type="submit" class="btn btn-primary" id="validation" value="<?= ($id ? 'Modifier' : 'Ajouter') ?>" />
															<input type="reset" class="btn btn-primary" value="Annuler"/>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / add/edit trademarks -->

						</div>

						<?=ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->

				</div>

				<?php
				ViewTemplate::BackFoot();

				ViewTemplate::BackFormValidation('validation', id ? 4 : 3, 1);
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete deliver form.
	 *
	 * @param integer $id ID of the deliver to delete.
	 * @param array $deliver Deliver informations.
	 *
	 * @return void
	 */
	public static function DeliverDeleteConfirmation($id, $deliver)
	{
		$pagetitle = 'Gestion des transporteurs';
		$navtitle = 'Supprimer le transporteur';

		$navbits = [
			'index.php?do=listdelivers' => $pagetitle,
			'' => $navtitle
		];

		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead($pagetitle) ?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- body -->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
							<?php
							ViewTemplate::Breadcrumb($pagetitle, $navbits);

							$data = [
								'id' => $id,
								'redirect' => 'killdeliver',
								'typetext' => 'le transporteur',
								'itemname' => $deliver['nom'],
								'navtitle' => $navtitle
							];

							ViewTemplate::PrintDeleteConfirmation($data);
							?>
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

?>
