<?php

/**
 * Class to display HTML content about roles in back.
 */
class ViewTrademark
{
	/**
	 * Returns the HTML code to display the trademark list.
	 *
	 * @param object $trademarks Model object of trademarks.
	 * @param array $trademarklist List of all trademarks for the current page.
	 * @param array $totaltrademarks Total number of trademarks in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function TrademarkList($trademarks, $trademarkslist, $totaltrademarks, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des marques';
		$navtitle = 'Liste des marques';

		$navbits = [
			'index.php?do=listtrademarks' => $pagetitle,
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
						if (count($trademarkslist) > 0)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- trademarks listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(14))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addtrademark" type="button" class="btn btn-secondary">Ajouter une marque</a>
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
																		<th class="tablegrid-header-cell" style="width: 125px">Intitulé</th>
																		<th class="tablegrid-header-cell tablegrid-header-sortable" style="width: 75px">Nombre de produits</th>
																		<?php
																		if (Utils::cando(15) OR Utils::cando(17))
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
																	// Get the number of trademarks returned by the model for background lines
																	$quantity = count($trademarkslist);

																	foreach ($trademarkslist AS $data)
																	{
																		$trademarks->set_id($data['id']);
																		$compteur = $trademarks->getNumberOfProductsInTrademark();
																		$data['compteur'] = intval($compteur['compteur']);
																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																			<td class="tablegrid-cell" style="width: 75px">
																			<?= ($data['logo'] ? '<img src="../attachments/trademarks/' . $data['logo'] . '" alt="" width="50px" height="50px" />' : '') ?>
																			</td>
																			<td class="tablegrid-cell" style="width: 125px"><?= $data['nom'] ?></td>
																			<td class="tablegrid-cell" style="width: 75px"><?= $data['compteur']; ?></td>
																			<?php
																			if (Utils::cando(15) OR Utils::cando(17))
																			{
																				?>
																				<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																					<?php
																					if (Utils::cando(15))
																					{
																						?>
																						<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=edittrademark&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																					}

																					if (Utils::cando(17))
																					{
																						if ($data['compteur'] === 0 AND $totaltrademarks['nbtrademarks'] >= 2)
																						{
																						?>
																							<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deletetrademark&amp;id=<?= $data['id'] ?>"></a>
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
														Utils::construct_page_nav($pagenumber, $perpage, $totaltrademarks['nbtrademarks'], 'index.php?do=listtrademarks', 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / trademarks listing -->

							<?php
						}
						else
						{
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>

							<!-- trademarks listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5>Liste des marques</h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(14))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addtrademark" type="button" class="btn btn-secondary">Ajouter une marque</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de marque.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / trademarks listing -->
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

				if ($_SESSION['trademark']['add'] === 1)
				{
					ViewTemplate::BackToast('Ajout de marque', 'Marque ajoutée avec succès !');
					unset($_SESSION['trademark']['add']);
				}

				if ($_SESSION['trademark']['edit'] === 1)
				{
					ViewTemplate::BackToast('Modification de marque', 'Marque modifiée avec succès !');
					unset($_SESSION['trademark']['edit']);
				}

				if ($_SESSION['trademark']['delete'] === 1)
				{
					ViewTemplate::BackToast('Suppression de marque', 'Marque supprimée avec succès !');
					unset($_SESSION['trademark']['delete']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the add or edit trademark form.
	 *
	 * @param integer $id ID of the trademark if we need to edit an existing trademark. Empty for a new trademark.
	 * @param string $navtitle Title of the page to show in the breadcrumb.
	 * @param array $navbits Breadcrumb content.
	 * @param array $trademarkinfos Default values to show as default in fields.
	 * @param string $formredirect Redirect part of the URL to save data.
	 * @param string $pagetitle Title of the page.
	 *
	 * @return void
	 */
	public static function TrademarkAddEdit($id = '', $navtitle, $navbits, $trademarkinfos, $formredirect, $pagetitle)
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
							<?= ViewTemplate::Breadcrumb($pagetitle, $navbits);?>

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
														<label for="name" class="col-form-label pt-0">Intitulé <span>*</span></label>
														<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" data-type="name" data-message="Le format de l'intitulé n'est pas valide." value="<?= $trademarkinfos['nom'] ?>" required />
														<small id="nameHelp" class="form-text text-muted"></small>
													</div>
													<?php
													if (Utils::cando(16))
													{
														?>
														<div class="form-group">
															<label for="photo" class="col-form-label pt-0">Logo <span>*</span></label><br />
															<input type="file" id="photo" name="file" />
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
															<input type="submit" class="btn btn-primary" id="valider" value="<?= ($id ? 'Modifier' : 'Ajouter') ?>" />
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

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->

				</div>

				<?php
				ViewTemplate::BackFoot();

				if ($id)
				{
					ViewTemplate::BackFormValidation('valider', 4, 1);
				}
				else
				{
					ViewTemplate::BackFormValidation('valider', 3, 1);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete trademark form.
	 *
	 * @param integer $id ID of the trademark to delete.
	 * @param array $trademark Trademark informations.
	 *
	 * @return void
	 */
	public static function TrademarkDeleteConfirmation($id, $trademark)
	{
		$pagetitle = 'Gestion des marques';
		$navtitle = 'Supprimer la marque';

		$navbits = [
			'index.php?do=listtrademarks' => $pagetitle,
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
								'redirect' => 'killtrademark',
								'typetext' => 'la marque',
								'itemname' => $trademark['nom'],
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
