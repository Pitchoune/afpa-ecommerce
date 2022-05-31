<?php

require_once(DIR . '/model/ModelCategory.php');
use \Ecommerce\Model\ModelCategory;

/**
 * Class to display HTML content about categories in back.
 *
 * @date $Date$
 */
class ViewCategory
{
	/**
	 * Returns the HTML code to display the category list.
	 *
	 * @return void
	 */
	public static function CategoryList()
	{
		if (Utils::cando(9))
		{
			global $config, $pagenumber;

			$categories = new ModelCategory($config);

			$pagetitle = 'Gestion des catégories';
			$navtitle = 'Liste des catégories';

			$navbits = [
				'listcategories' => $pagetitle,
				'' => $navtitle
			];

			$categorieslist = $categories->listAllCategories();
			$cache = Utils::categoriesCache($categorieslist);
			$categorylist = Utils::constructCategoryChooserOptions($cache, false);

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
							if (count($categorieslist) > 0)
							{
								ViewTemplate::Breadcrumb($pagetitle, $navbits);
								?>

								<!-- categories listing -->
								<div class="container-fluid">
									<div class="row">
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<h5><?= $navtitle ?></h5>
												</div>
												<div class="card-body">
													<?php
													if (Utils::cando(10))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=addcategory" type="button" class="btn btn-secondary">Ajouter une catégorie</a>
														</div>
														<?php
													}
													?>
													<form class="table-responsive" action="index.php?do=updateorder" method="post">
														<div class="tablegrid">
															<div class="tablegrid-grid-header">
																<table class="tablegrid-table">
																	<thead>
																		<tr class="tablegrid-header-row">
																			<th class="tablegrid-header-cell" style="width: 125px">Intitulé</th>
																			<th class="tablegrid-header-cell" style="width: 50px">Ordre d'affichage</th>
																			<th class="tablegrid-header-cell" style="width: 75px">Nombre de produits</th>
																			<?php
																			if (Utils::cando(11) OR Utils::cando(12))
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
																		// Get the number of categories returned by the model for background lines
																		$quantity = count($categorieslist);

																		foreach ($categorieslist AS $data)
																		{
																			$categories->set_id($data['id']);
																			$compteur = $categories->getNumberOfProductsInCategory();
																			$data['compteur'] = intval($compteur['compteur']);
																			?>
																			<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																				<td class="tablegrid-cell text-left" style="width: 125px"><?= $categorylist[$data['id']] ?></td>
																				<td class="tablegrid-cell" style="width: 50px"><input type="text" name="order[<?= $data['id'] ?>]" value="<?= $data['displayorder'] ?>" /></td>
																				<td class="tablegrid-cell" style="width: 75px"><?= $data['compteur'] ?></td>
																				<?php
																				if (Utils::cando(11) OR Utils::cando(12))
																				{
																					?>
																					<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																						<?php
																						if (Utils::cando(11))
																						{
																						?>
																							<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editcategory&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																						}

																						if (Utils::cando(12))
																						{
																							if ($data['compteur'] === 0 AND $totalcategories['nbcats'] >= 2)
																							{
																							?>
																								<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deletecategory&amp;id=<?= $data['id'] ?>"></a>
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
														</div>
														<div class="btn-popup pull-right mt-4">
															<input type="hidden" name="do" value="updateorder" />
															<input type="submit" class="btn btn-secondary" value="Mettre à jour l'ordre d'affichage" />
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- / categories listing -->

								<?php
							}
							else
							{
								ViewTemplate::breadcrumb($pagetitle, array('Liste des catégories'));
								?>

								<!-- categories listing -->
								<div class="container-fluid">
									<div class="row">
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<h5>Liste des catégories</h5>
												</div>
												<div class="card-body">
													<?php
													if (Utils::cando(10))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=addcategory" type="button" class="btn btn-secondary">Ajouter une catégorie</a>
														</div>
														<?php
													}
													?>
													<div class="table-responsive">
														<div class="text-center">Il n'y a pas de catégorie.</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- categories listing -->
								<?php
							}
							?>
							</div>

							<?= ViewTemplate::BackFooter() ?>
						</div>


					</div>
					<?php
					ViewTemplate::BackFoot();

					if ($_SESSION['category']['add'] === 1)
					{
						ViewTemplate::BackToast('Ajout de catégorie', 'Catégorie ajoutée avec succès !');
						unset($_SESSION['category']['add']);
					}

					if ($_SESSION['category']['edit'] === 1)
					{
						ViewTemplate::BackToast('Modification de catégorie', 'Catégorie modifiée avec succès !');
						unset($_SESSION['category']['edit']);
					}

					if ($_SESSION['category']['delete'] === 1)
					{
						ViewTemplate::BackToast('Suppression de catégorie', 'Catégorie supprimée avec succès !');
						unset($_SESSION['category']['delete']);
					}

					if ($_SESSION['category']['orders'] === 1)
					{
						ViewTemplate::BackToast('Mise à jour des catégories', 'Order d\'affichage modifiée avec succès !');
						unset($_SESSION['category']['orders']);
					}
					?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des catégories.');
		}
	}

	/**
	 * Returns the HTML code to display the add or edit category form.
	 *
	 * @param integer $id ID of the category if we need to edit an existing category. Empty for a new category.
	 *
	 * @return void
	 */
	public static function CategoryAddEdit($id = '')
	{
		if (Utils::cando(10) OR Utils::cando(11))
		{
			global $config;

			$categories = new ModelCategory($config);

			$pagetitle = 'Gestion des catégories';

			if ($id)
			{
				$categories->set_id($id);
				$categoryinfos = $categories->listCategoryInfos();
				$navtitle = 'Modifier une catégorie';
				$formredirect = 'updatecategory';
				$compteur = $categories->getNumberOfProductsInCategory();
				$categoryinfos['compteur'] = $compteur['compteur'];
			}
			else
			{
				$categoryinfos = [
					'nom' => ''
				];

				$navtitle = 'Ajouter une catégorie';
				$formredirect = 'insertcategory';
			}

			if ($categoryinfos)
			{
				$navbits = [
					'listcategories' => $pagetitle,
					'' => $navtitle
				];

				// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
				$catlist = $categories->listAllCategories();
				$cache = Utils::categoriesCache($catlist);
				$categorylist = Utils::constructCategoryChooserOptions($cache);
				$categoriesselect = Utils::constructCategorySelectOptions($categorylist, $categoryinfos['parent_id']);

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

									<!-- add/edit category -->
									<div class="container-fluid">
										<div class="row product-adding">
											<div class="col">
												<div class="card">
													<div class="card-header">
														<h5><?= $navtitle ?></h5>
													</div>
													<div class="card-body">
														<form class="digital-add" method="post" action="index.php?do=<?= $formredirect ?>">
															<div class="form-group">
																<label for="title" class="col-form-label pt-0">Intitulé <span>*</span></label>
																<input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp" data-type="title" data-message="Le format de l'intitulé n'est pas valide." required value="<?= $categoryinfos['nom'] ?>" />
																<small id="titleHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="parent" class="col-form-label pt-0">Catégorie <span>*</span></label>
																<select class="custom-select form-control" id="parent" name="parent" aria-describedby="parentHelp" data-type="parent" data-message="La catégorie sélectionnée n'est pas valide.">
																<?= $categoriesselect ?>
																</select>
																<small id="parentHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="displayorder" class="col-form-label pt-0">Ordre d'affichage <span>*</span></label>
																<input type="text" class="form-control" id="displayorder" name="displayorder" aria-describedby="displayorderHelp" data-type="displayorder" data-message="Le format de l'ordre d'affichage n'est pas valide." required value="<?= $categoryinfos['displayorder'] ?>" />
																<small id="displayorderHelp" class="form-text text-muted"></small>
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
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- / add/edit category -->

								</div>

								<?= ViewTemplate::BackFooter() ?>
							</div>
							<!-- / body -->

						</div>

						<?php
						ViewTemplate::BackFoot();

						if ($id)
						{
							ViewTemplate::BackFormValidation('validation', 5, 1);
						}
						else
						{
							ViewTemplate::BackFormValidation('validation', 4, 1);
						}
						?>
					</body>
				</html>
				<?php
			}
			else
			{
				throw new Exception('Une erreur est survenue pendant l\'affichage des options de la catégorie.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à ajouter ou à modifier des catégories.');
		}
	}

	/**
	 * Returns the HTML code to display the delete category form.
	 *
	 * @param integer $id ID of the category to delete.
	 *
	 * @return void
	 */
	public static function CategoryDeleteConfirmation($id)
	{
		global $config;

		$id = intval($id);

		$categories = new ModelCategory($config);

		$pagetitle = 'Gestion des catégories';
		$navtitle = 'Supprimer la catégorie';

		$categories->set_id($id);
		$category = $categories->listCategoryInfos();

		$navbits = [
			'index.php?do=listcategories' => $pagetitle,
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
								'redirect' => 'killcategory',
								'typetext' => 'la catégorie',
								'itemname' => $category['nom'],
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
