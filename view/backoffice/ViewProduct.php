<?php

require_once(DIR . '/model/ModelProduct.php');
require_once(DIR . '/model/ModelCategory.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelProduct;
use \Ecommerce\Model\ModelCategory;
use \Ecommerce\Model\ModelTrademark;

/**
 * Class to display HTML content about products in back.
 *
 * @date $Date$
 */
class ViewProduct
{
	/**
	 * Returns the HTML code to display the product list.
	 *
	 * @return void
	 */
	public static function ProductList()
	{
		if (Utils::cando(23))
		{
			global $config, $pagenumber;

			$products = new ModelProduct($config);

			$pagetitle = 'Gestion des produits';
			$navtitle = 'Liste des produits';

			$navbits = [
				'index.php?do=listproducts' => $pagetitle,
				'' => $navtitle
			];

			$totalproducts = $products->getTotalNumberOfProducts();

			// Number max per page
			$perpage = 10;

			Utils::sanitize_pageresults($totalproducts['nbproducts'], $pagenumber, $perpage, 200, 20);

			$limitlower = ($pagenumber - 1) * $perpage;
			$limitupper = ($pagenumber) * $perpage;

			if ($limitupper > $totalproducts['nbproducts'])
			{
				$limitupper = $totalproducts['nbproducts'];

				if ($limitlower > $totalproducts['nbproducts'])
				{
					$limitlower = ($totalproducts['nbproducts'] - $perpage) - 1;
				}
			}

			if ($limitlower < 0)
			{
				$limitlower = 0;
			}

			$productlist = $products->getSomeProducts($limitlower, $perpage);

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
							if (count($productlist) > 0)
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
													if (Utils::cando(24))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=addproduct" type="button" class="btn btn-secondary">Ajouter un produit</a>
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
																			if (Utils::cando(25) OR Utils::cando(26))
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
																		$quantity = count($productlist);

																		foreach ($productlist AS $data)
																		{
																			?>
																			<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																					<td class="tablegrid-cell" style="width: 75px">
																					<?php
																					if ($data['photo'])
																					{
																					?>
																						<img src="../attachments/products/<?= $data['photo'] ?>" alt="" width="50px" height="50px" />
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
																				if (Utils::cando(25) OR Utils::cando(26))
																				{
																					?>
																					<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																						<?php
																						if (Utils::cando(25))
																						{
																							?>
																							<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editproduct&amp;id=<?= $data['id'] ?>"></a>
																							<?php
																						}

																						if (Utils::cando(26))
																						{
																							//if ($data['compteur'] == 0 OR $quantity >= 1)
																							//{
																							?>
																								<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deleteproduct&amp;id=<?= $data['id'] ?>"></a>
																							<?php
																							//}
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
															Utils::construct_page_nav($pagenumber, $perpage, $totalproducts['nbproducts'], 'index.php?do=listproducts', 'back');
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
								ViewTemplate::breadcrumb($pagetitle, $navbits);
								?>
								<!-- Container-fluid ends-->

								<div class="container-fluid">
									<div class="row">
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<h5>Liste des produits</h5>
												</div>
												<div class="card-body">
													<?php
													if (Utils::cando(24))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=addproduct" type="button" class="btn btn-secondary">Ajouter un produit</a>
														</div>
														<?php
													}
													?>
													<div class="table-responsive">
														<div class="text-center">Il n'y a pas de produit.</div>
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
					if ($_SESSION['product']['add'] === 1)
					{
						ViewTemplate::BackToast('Ajout de produit', 'Produit ajouté avec succès !');
						unset($_SESSION['product']['add']);
					}

					if ($_SESSION['product']['edit'] === 1)
					{
						ViewTemplate::BackToast('Modification de produit', 'Produit modifié avec succès !');
						unset($_SESSION['product']['edit']);
					}

					if ($_SESSION['product']['delete'] === 1)
					{
						ViewTemplate::BackToast('Suppression de produit', 'Produit supprimé avec succès !');
						unset($_SESSION['product']['delete']);
					}
					?>
				</body>
			</html>
			<?php
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des produits.');
		}
	}

	/**
	 * Returns the HTML code to display the add or edit product form.
	 *
	 * @param integer $id ID of the product if we need to edit an existing product. Empty for a new deliver.
	 *
	 * @return void
	 */
	public static function ProductAddEdit($id = '')
	{
		if (Utils::cando(24) OR Utils::cando(25))
		{
			global $config;

			$products = new ModelProduct($config);

			$pagetitle = 'Gestion des produits';

			if ($id)
			{
				$products->set_id($id);
				$productinfos = $products->listProductInfosFromId();
				$navtitle = 'Modifier un produit';
				$formredirect = 'updateproduct';
			}
			else
			{
				$productinfos = [
					'nom' => '',
					'ref' => '',
					'description' => '',
					'quantity' => '',
					'price' => '',
					'file' => '',
					'category' => ''
				];

				$navtitle = 'Ajouter un produit';
				$formredirect = 'insertproduct';
			}

			if ($productinfos)
			{
				$navbits = [
					'index.php?do=listproducts' => $pagetitle,
					'' => $navtitle
				];

				// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
				$categories = new ModelCategory($config);
				$catlist = $categories->listAllCategories();

				// Grab all existing trademarks
				$trademarks = new ModelTrademark($config);
				$trademarkslist = $trademarks->listAllTrademarks();

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
													<form class="digital-add needs-validation" enctype="multipart/form-data" method="post" action="index.php?do=<?= $formredirect ?>">
														<div class="form-group">
															<label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Intitulé</label>
															<input class="form-control" id="validationCustom01" type="text" required name="name" value="<?= $productinfos['nom'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom02" class="col-form-label pt-0"><span>*</span> Référence</label>
															<input class="form-control" id="validationCustom02" type="text" maxlength="10" required name="ref" value="<?= $productinfos['ref'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom03" class="col-form-label pt-0"><span>*</span> Description</label>
															<input class="form-control" id="validationCustom03" type="text" required name="description" value="<?= $productinfos['description'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom04" class="col-form-label pt-0"><span>*</span> Quantité</label>
															<input class="form-control" id="validationCustom04" type="text" required name="quantity" value="<?= $productinfos['quantite'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom05" class="col-form-label pt-0"><span>*</span> Prix</label>
															<input class="form-control" id="validationCustom05" type="text" required name="price" value="<?= $productinfos['prix'] ?>">
														</div>
														<?php
														if (Utils::cando(26))
														{
															?>
															<div class="form-group">
																<label for="validationCustom06" class="col-form-label pt-0">Photo</label>
																<input type="file" id="validationCustom06" name="file" />
															</div>
															<?php
														}
														?>
														<div class="form-group">
															<label class="col-form-label"><span>*</span> Catégorie</label>
															<select class="custom-select form-control" required name="category">
																<option value="0" selected disabled>Sélectionnez une catégorie</option>
																	<?php

																	foreach ($catlist AS $content)
																	{
																		echo '<option value="' . $content['id'] . '"' . ($content['id'] == $productinfos['id_categorie'] ? ' selected' : '') . '>' . $content['nom'] . '</option>\n';
																	}

																	?>
															</select>
														</div>
														<div class="form-group">
															<label class="col-form-label"><span>*</span> Marque</label>
															<select class="custom-select form-control" required name="trademark">
																<option value="0" selected disabled>Sélectionnez une marque</option>
																	<?php

																	foreach ($trademarkslist AS $content)
																	{
																		echo '<option value="' . $content['id'] . '"' . ($content['id'] == $productinfos['id_marque'] ? ' selected' : '') . '>' . $content['nom'] . '</option>\n';
																	}

																	?>
															</select>
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
				throw new Exception('Une erreur est survenue pendant l\'affichage des options du produit.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à ajouter ou modifier des produits.');
		}
	}
}
?>
