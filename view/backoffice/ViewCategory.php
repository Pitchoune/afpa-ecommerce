<?php

require_once(DIR . '/model/ModelCategory.php');

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

			$categories = new \Ecommerce\Model\ModelCategory($config);

			$pagetitle = 'Gestion des catégories';
			$navtitle = 'Liste des catégories';

			$navbits = [
				'listcategories' => $pagetitle,
				'' => $navtitle
			];

			$totalcategories = $categories->getTotalNumberOfCategories();

			// Number max per page
			$perpage = 10;

			Utils::sanitize_pageresults($totalcategories['nbcats'], $pagenumber, $perpage, 200, 20);

			$limitlower = ($pagenumber - 1) * $perpage;
			$limitupper = ($pagenumber) * $perpage;

			if ($limitupper > $totalcategories['nbcats'])
			{
				$limitupper = $totalcategories['nbcats'];

				if ($limitlower > $totalcategories['nbcats'])
				{
					$limitlower = ($totalcategories['nbcats'] - $perpage) - 1;
				}
			}

			if ($limitlower < 0)
			{
				$limitlower = 0;
			}

			$categorieslist = $categories->getSomeCategories($limitlower, $perpage);

			?>
			<!DOCTYPE html>
			<html>
				<head>
					<?php
					ViewTemplate::BackHead($pagetitle);
					?>
				</head>

				<body>
					<div class="page-wrapper">

						<!-- Page Header Start-->
						<?php
						require_once(DIR . '/view/backoffice/ViewTemplate.php');
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
							<?php
							if (count($categorieslist) > 0)
							{
								?>
								<!-- Container-fluid starts-->
								<?php
								ViewTemplate::Breadcrumb($pagetitle, $navbits);
								?>
								<!-- Container-fluid ends-->

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
													<div class="table-responsive">
														<div class="tablegrid">
															<div class="tablegrid-grid-header">
																<table class="tablegrid-table">
																	<thead>
																		<tr class="tablegrid-header-row">
																			<th class="tablegrid-header-cell" style="width: 125px">Intitulé</th>
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
																				<td class="tablegrid-cell" style="width: 125px"><?= $data['nom']; ?></td>
																				<td class="tablegrid-cell" style="width: 75px"><?= $data['compteur']; ?></td>
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
															<?php
															Utils::construct_page_nav($pagenumber, $perpage, $totalcategories['nbcats'], 'index.php?do=listcategories', 'back');
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<?php
							}
							else
							{
								?>
								<!-- Container-fluid starts-->
								<?php
								ViewTemplate::breadcrumb($pagetitle, array('Liste des catégories'));
								?>
								<!-- Container-fluid ends-->

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
								<?php
							}
							?>
							</div>

							<!-- footer start-->
							<?php
							ViewTemplate::BackFooter();
							?>
							<!-- footer end-->
						</div>


					</div>
					<!-- latest jquery-->
					<script src="../assets/js/jquery-3.5.1.min.js"></script>

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
					<?php
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

			$categories = new \Ecommerce\Model\ModelCategory($config);

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
					'nom' => '',
					'parentid' => '-1',
					'etat' => 0,
					'compteur' => 0
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

				?>
				<!DOCTYPE html>
				<html>
					<head>
						<?php
						ViewTemplate::BackHead($pagetitle);
						?>
					</head>

					<body>
						<div class="page-wrapper">

							<!-- Page Header Start-->
							<?php
							require_once(DIR . '/view/backoffice/ViewTemplate.php');
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
								<?php
								ViewTemplate::Breadcrumb($pagetitle, $navbits);
								?>
								<!-- Container-fluid ends-->

								<div class="container-fluid">
									<div class="row product-adding">
										<div class="col">
											<div class="card">
												<div class="card-header">
													<h5><?= $navtitle ?></h5>
												</div>
												<div class="card-body">
													<form class="digital-add needs-validation" method="post" action="index.php?do=<?= $formredirect ?>">
														<div class="form-group">
															<label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Intitulé</label>
															<input class="form-control" id="validationCustom01" type="text" required name="title" value="<?= $categoryinfos['nom'] ?>">
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
																<input type="submit" class="btn btn-primary" value="<?= ($id ? 'Modifier' : 'Ajouter') ?>" />
																<input type="reset" class="btn btn-light" value="Annuler"/>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>

								</div>

								<!-- footer start-->
								<?php
								ViewTemplate::BackFooter();
								?>
								<!-- footer end-->
							</div>


						</div>
						<!-- latest jquery-->
						<script src="../assets/js/jquery-3.5.1.min.js"></script>

						<!-- Bootstrap js-->
						<script src="../assets/js/popper.min.js"></script>
						<script src="../assets/js/bootstrap.js"></script>

						<!-- feather icon js-->
						<script src="../assets/js/icons/feather-icon/feather.min.js"></script>
						<script src="../assets/js/icons/feather-icon/feather-icon.js"></script>

						<!-- Sidebar jquery-->
						<script src="../assets/js/sidebar-menu.js"></script>
						<script src="../assets/js/slick.js"></script>

						<!--script admin-->
						<script src="../assets/js/admin-script.js"></script>
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
}
?>
