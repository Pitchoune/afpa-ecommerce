<?php

/**
 * Class to display HTML content about roles in back.
 */
class ViewRole
{
	/**
	 * Returns the HTML code to display the role list.
	 *
	 * @param object $roles Model object of roles.
	 * @param array $roleslist List of all roles for the current page.
	 * @param array $totalroles Total number of roles in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function RoleList($roles, $roleslist, $totalroles, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des rôles';
		$navtitle = 'Liste des rôles';

		$navbits = [
			'index.php?do=listroles' => $pagetitle,
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
						if (count($roleslist) > 0)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- roles listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(2))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addrole" type="button" class="btn btn-secondary">Ajouter un rôle</a>
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
																		<th class="tablegrid-header-cell tablegrid-header-sortable" style="width: 125px">Intitulé</th>
																		<?php
																		if (Utils::cando(3) OR Utils::cando(4))
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
																	// Get the number of roles returned by the model for background lines
																	$quantity = count($roleslist);

																	foreach ($roleslist AS $data)
																	{
																		$roles->set_id($data['id']);
																		$compteur = $roles->getNumberOfEmployeesInRole();
																		$data['compteur'] = intval($compteur['compteur']);
																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																			<td class="tablegrid-cell" style="width: 125px"><?= $data['nom']; ?></td>
																			<?php
																			if (Utils::cando(3) OR Utils::cando(4))
																			{
																				?>
																				<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																					<?php
																					if (Utils::cando(3))
																					{
																					?>
																						<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editrole&amp;id=<?= $data['id'] ?>"></a>
																					<?php
																					}

																					if (Utils::cando(4))
																					{
																						if ($data['compteur'] === 0 AND $totalroles['nbroles'] >= 2)
																						{
																						?>
																							<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deleterole&amp;id=<?= $data['id'] ?>"></a>
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
														Utils::construct_page_nav($pagenumber, $perpage, $totalroles['nbroles'], 'index.php?do=listroles', 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / roles listing -->

							<?php
						}
						else
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- roles listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5>Liste des rôles</h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(2))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addrole" type="button" class="btn btn-secondary">Ajouter un rôle</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de rôle.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / roles listing -->
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

				if (isset($_SESSION['role']['add']) AND $_SESSION['role']['add'] === 1)
				{
					ViewTemplate::BackToast('Ajout de rôle', 'Rôle ajouté avec succès !');
					unset($_SESSION['role']['add']);
				}

				if (isset($_SESSION['role']['edit']) AND $_SESSION['role']['edit'] === 1)
				{
					ViewTemplate::BackToast('Modification de rôle', 'Rôle modifié avec succès !');
					unset($_SESSION['role']['edit']);
				}

				if (isset($_SESSION['role']['editperm']) AND $_SESSION['role']['editperm'] === 1)
				{
					ViewTemplate::BackToast('Modification des permissions de rôle', 'Permissions de rôle modifiée avec succès !');
					unset($_SESSION['role']['editperm']);
				}

				if (isset($_SESSION['role']['delete']) AND $_SESSION['role']['delete'] === 1)
				{
					ViewTemplate::BackToast('Suppression de rôle', 'Rôle supprimé avec succès !');
					unset($_SESSION['role']['delete']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the add or edit role form.
	 *
	 * @param string $navtitle Title of the page to show in the breadcrumb.
	 * @param array $navbits Breadcrumb content.
	 * @param array $roleinfos Default values to show as default in fields.
	 * @param string $formredirect Redirect part of the URL to save data.
	 * @param string $pagetitle Title of the page.
	 * @param integer $id ID of the role if we need to edit an existing role. Empty for a new role.
	 * @param array $permissions Array of permissions available for the system.
	 * @param array $perms Current permissions values for the given role.
	 *
	 * @return void
	 */
	public static function RoleAddEdit($navtitle, $navbits, $roleinfos, $formredirect, $pagetitle, $id = '', $permissions = '', $perms = '')
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

							<!-- add/edit roles -->
							<div class="container-fluid">
								<div class="row product-adding">
									<div class="col">
										<div class="card tab2-card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<?php
												if ($id)
												{
													?>
													<ul class="nav nav-tabs tab-coupon" id="myTab" role="tablist">
														<li class="nav-item"><a class="nav-link active show" id="account-tab" data-bs-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="true" data-original-title="" title="">Compte</a></li>
														<li class="nav-item"><a class="nav-link" id="permission-tabs" data-bs-toggle="tab" href="#permission" role="tab" aria-controls="permission" aria-selected="false" data-original-title="" title="">Permissions</a></li>
													</ul>
													<div class="tab-content" id="myTabContent">
														<div class="tab-pane fade active show" id="account" role="tabpanel" aria-labelledby="account-tab">
												<?php
												}
												?>
													<form class="digital-add" method="post" action="index.php?do=<?= $formredirect ?>">
														<div class="form-group">
															<label for="name" class="col-form-label pt-0">Intitulé <span>*</span></label>
															<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" data-type="name" data-message="Le format de l'intitulé n'est pas valide." value="<?= $roleinfos['nom'] ?>" required />
															<small id="nameHelp" class="form-text text-muted"></small>
														</div>
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
												<?php
												if ($id)
												{
													?>
														</div>
														<div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tabs">
															<form class="user-add" novalidate="" method="post" action="index.php?do=updateroleperms">
																<div class="permission-block">
																<?php
																foreach ($permissions AS $module => $values)
																{
																	?>
																	<div class="attribute-blocks">
																		<h5 class="f-w-600 mb-3">Permissions des <?= $module ?></h5>
																		<?php
																		foreach ($values AS $permid => $description)
																		{
																			?>
																			<div class="row">
																				<div class="col-xl-3 col-sm-4">
																					<label><?= $description ?></label>
																				</div>
																				<div class="col-xl-9 col-sm-8">
																					<div class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
																						<label class="d-block" for="rb_1_permission[<?= $permid ?>]">
																							<input class="radio_animated" id="rb_1_permission[<?= $permid ?>]" type="radio" name="permission[<?= $permid ?>]" value="1" <?= ($perms["$module"]["$permid"] == 1 ? ' checked' : '') ?> />
																							Oui
																						</label>
																						<label class="d-block" for="rb_0_permission[<?= $permid ?>]">
																							<input class="radio_animated" id="rb_0_permission[<?= $permid ?>]" type="radio" name="permission[<?= $permid ?>]" value="0" <?= ($perms["$module"]["$permid"] == 0 ? ' checked' : '') ?> />
																							Non
																						</label>
																					</div>
																				</div>
																			</div>
																			<?php
																		}
																		?>
																	</div>
																	<?php
																}
																?>
																</div>
																<div class="text-center">
																	<input type="hidden" name="do" value="updateroleperms" />
																	<input type="hidden" name="id" value="<?= $id ?>" />
																	<input type="submit" class="btn btn-primary" value="Modifier" />
																	<input type="reset" class="btn btn-primary" value="Annuler"/>
																</div>
															</form>
														</div>
														<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / add/edit roles -->

						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->
				</div>

				<?php
				ViewTemplate::BackFoot();

				ViewTemplate::BackFormValidation('validation', $id ? 4 : 3, 1);
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete role form.
	 *
	 * @param integer $id ID of the role to delete.
	 * @param array $role Role informations.
	 *
	 * @return void
	 */
	public static function RoleDeleteConfirmation($id, $role)
	{
		$pagetitle = 'Gestion des rôles';
		$navtitle = 'Supprimer le rôle';

		$navbits = [
			'index.php?do=listroles' => $pagetitle,
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
								'redirect' => 'killrole',
								'typetext' => 'le rôle',
								'itemname' => $role['nom'],
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
