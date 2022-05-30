<?php

require_once(DIR . '/model/ModelDeliver.php');
use \Ecommerce\Model\ModelDeliver;

/**
 * Class to display HTML content about delivers in back.
 *
 * @date $Date$
 */
class ViewDeliver
{
	/**
	 * Returns the HTML code to display the deliver list.
	 *
	 * @return void
	 */
	public static function DeliverList()
	{
		if (Utils::cando(18))
		{
			global $config, $pagenumber;

			$delivers = new ModelDeliver($config);

			$pagetitle = 'Gestion des transporteurs';
			$navtitle = 'Liste des transporteurs';

			$navbits = [
				'index.php?do=listdelivers' => $pagetitle,
				'' => $navtitle
			];

			$totaldelivers = $delivers->getTotalNumberOfDelivers();

			// Number max per page
			$perpage = 10;

			Utils::sanitize_pageresults($totaldelivers['nbdelivers'], $pagenumber, $perpage, 200, 20);

			$limitlower = ($pagenumber - 1) * $perpage;
			$limitupper = ($pagenumber) * $perpage;

			if ($limitupper > $totaldelivers['nbdelivers'])
			{
				$limitupper = $totaldelivers['nbdelivers'];

				if ($limitlower > $totaldelivers['nbdelivers'])
				{
					$limitlower = ($totaldelivers['nbdelivers'] - $perpage) - 1;
				}
			}

			if ($limitlower < 0)
			{
				$limitlower = 0;
			}

			$deliverlist = $delivers->getSomeDelivers($limitlower, $perpage);

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
																			<th class="tablegrid-header-cell tablegrid-header-sortable" style="width: 125px">Intitulé</th>
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
																					<?php
																					if ($data['logo'])
																					{
																					?>
																						<img src="../attachments/delivers/<?= $data['logo'] ?>" alt="" width="50px" height="50px" />
																					<?php
																					}
																					else
																					{
																					?>
																						&nbsp;
																						<?php
																					} ?>
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

					if ($_SESSION['deliver']['add'] === 1)
					{
						ViewTemplate::BackToast('Ajout de transporteur', 'Transporteur ajouté avec succès !');
						unset($_SESSION['deliver']['add']);
					}

					if ($_SESSION['deliver']['edit'] === 1)
					{
						ViewTemplate::BackToast('Modification de transporteur', 'Transporteur modifié avec succès !');
						unset($_SESSION['deliver']['edit']);
					}

					if ($_SESSION['deliver']['delete'] === 1)
					{
						ViewTemplate::BackToast('Suppression de transporteur', 'Transporteur supprimé avec succès !');
						unset($_SESSION['deliver']['delete']);
					}
					?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des transporteurs.');
		}
	}

	/**
	 * Returns the HTML code to display the add or edit deliver form.
	 *
	 * @param integer $id ID of the deliver if we need to edit an existing deliver. Empty for a new deliver.
	 *
	 * @return void
	 */
	public static function DeliverAddEdit($id = '')
	{
		if (Utils::cando(19) OR Utils::cando(20))
		{
			global $config;

			$delivers = new ModelDeliver($config);

			$pagetitle = 'Gestion des transporteurs';

			if ($id)
			{
				$delivers->set_id($id);
				$deliverinfos = $delivers->listDeliverInfos();
				$navtitle = 'Modifier un transporteur';
				$formredirect = 'updatedeliver';
			}
			else
			{
				$deliverinfos = [
					'nom' => ''
				];

				$navtitle = 'Ajouter un transporteur';
				$formredirect = 'insertdeliver';
			}

			if ($deliverinfos)
			{
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
																<label for="title" class="col-form-label pt-0"><span>*</span> Intitulé</label>
																<input type="text" class="form-control" id="title" name="name" aria-describedby="titleHelp" data-type="title" data-message="Le format de l'intitulé n'est pas valide." required value="<?= $deliverinfos['nom'] ?>">
																<small id="titleHelp" class="form-text text-muted"></small>
															</div>
															<?php
															if (Utils::cando(21))
															{
																?>
																<div class="form-group">
																	<label for="logo" class="col-form-label pt-0"><span>*</span> Logo</label><br />
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
																	<input type="submit" class="btn btn-primary" id="valider" value="<?= ($id ? 'Modifier' : 'Ajouter') ?>" />
																	<input type="reset" class="btn btn-light" value="Annuler"/>
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
			else
			{
				throw new Exception('Une erreur est survenue pendant l\'affichage des options du transporteur.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à ajouter ou modifier des transporteurs.');
		}
	}

	/**
	 * Returns the HTML code to display the delete deliver form.
	 *
	 * @param integer $id ID of the deliver to delete.
	 *
	 * @return void
	 */
	public static function DeliverDeleteConfirmation($id)
	{
		global $config;

		$id = intval($id);

		$delivers = new ModelDeliver($config);

		$pagetitle = 'Gestion des transporteurs';
		$navtitle = 'Supprimer le transporteur';

		$delivers->set_id($id);
		$deliver = $delivers->listDeliverInfos();

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
