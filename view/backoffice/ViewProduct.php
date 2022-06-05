<?php

/**
 * Class to display HTML content about products in back.
 */
class ViewProduct
{
	/**
	 * Returns the HTML code to display the product list.
	 *
	 * @param object $products Model object of products.
	 * @param array $productlist List of all products for the current page.
	 * @param array $totalproducts Total number of products in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function ProductList($products, $productlist, $totalproducts, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des produits';
		$navtitle = 'Liste des produits';

		$navbits = [
			'index.php?do=listproducts' => $pagetitle,
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
						if (count($productlist) > 0)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- products listing -->
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
																				<?= ($data['photo'] ? '<img src="../attachments/products/' . $data['photo'] . '" alt="" width="50px" height="50px" />' : '') ?>
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
																						?>
																							<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deleteproduct&amp;id=<?= $data['id'] ?>"></a>
																						<?php
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
							<!-- / products listing -->

							<?php
						}
						else
						{
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>

							<!-- products listing -->
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
							<!-- / products listing -->
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

	/**
	 * Returns the HTML code to display the add or edit product form.
	 *
	 * @param string $navtitle Title of the page to show in the breadcrumb.
	 * @param array $navbits Breadcrumb content.
	 * @param array $productinfos Default values to show as default in fields.
	 * @param string $formredirect Redirect part of the URL to save data.
	 * @param string $pagetitle Title of the page.
	 * @param mixed $catlist HTML code for the category <select>.
	 * @param array $trademarklist Array of all trademarks.
	 * @param integer $id ID of the product if we need to edit an existing product. Empty for a new product.
	 *
	 * @return void
	 */
	public static function ProductAddEdit($navtitle, $navbits, $productinfos, $formredirect, $pagetitle, $catlist, $trademarkslist, $id = '')
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

							<!-- add/edit product -->
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
														<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" data-type="name" data-message="Le format du nom n'est pas valide." value="<?= $productinfos['nom'] ?>" required />
														<small id="nameHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="ref" class="col-form-label pt-0">Référence <span>*</span></label>
														<input type="text" class="form-control" id="ref" name="ref" aria-describedby="refHelp" data-type="ref" data-message="Le format de la référence n'est pas valide." value="<?= $productinfos['ref'] ?>" maxlength="10" required />
														<small id="refHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="description" class="col-form-label pt-0">Description <span>*</span></label>
														<input type="text" class="form-control" id="description" name="description" aria-describedby="descriptionHelp" data-type="description" data-message="Le format de la description n'est pas valide." value="<?= $productinfos['description'] ?>" required />
														<small id="descriptionHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="quantity" class="col-form-label pt-0">Quantité<span>*</span> </label>
														<input type="text" class="form-control" id="quantity" name="quantity" aria-describedby="quantityHelp" data-type="quantity" data-message="Le format de la quantité n'est pas valide." value="<?= $productinfos['quantite'] ?>" required />
														<small id="quantityHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="price" class="col-form-label pt-0">Prix <span>*</span></label>
														<input type="text" class="form-control" id="price" name="price" aria-describedby="priceHelp" data-type="price" data-message="Le format du prix n'est pas valide." value="<?= $productinfos['prix'] ?>" required />
														<small id="priceHelp" class="form-text text-muted"></small>
													</div>
													<?php
													if (Utils::cando(26))
													{
														?>
														<div class="form-group">
															<label for="photo" class="col-form-label pt-0">Photo</label><br />
															<input type="file" id="photo" name="file" />
														</div>
														<?php
													}
													?>
													<div class="form-group">
														<label class="col-form-label">Catégorie <span>*</span></label>
														<select class="custom-select form-control" id="" name="category" aria-describedby="selectcatHelp" data-type="selectChoose" data-message="La catégorie est obligatoire." required>
															<?= $catlist ?>
														</select>
														<small id="selectcatHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label class="col-form-label">Marque <span>*</span></label>
														<select class="custom-select form-control" id="" name="trademark" aria-describedby="selecttrademarkHelp" data-type="selectChoose" data-message="La marque est obligatoire." required>
															<option value="0" selected disabled>Sélectionnez une marque</option>
																<?php

																foreach ($trademarkslist AS $content)
																{
																	echo '<option value="' . $content['id'] . '"' . ($content['id'] == $productinfos['id_marque'] ? ' selected' : '') . '>' . $content['nom'] . '</option>\n';
																}

																?>
														</select>
														<small id="selecttrademarkHelp" class="form-text text-muted"></small>
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
							<!-- / add/edit product -->

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
	 * Returns the HTML code to display the delete product form.
	 *
	 * @param integer $id ID of the product to delete.
	 * @param array $product Product informations.
	 *
	 * @return void
	 */
	public static function ProductDeleteConfirmation($id, $product)
	{
		$pagetitle = 'Gestion des produits';
		$navtitle = 'Supprimer le produit';

		$navbits = [
			'index.php?do=listproducts' => $pagetitle,
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

							<?php
							$data = [
								'id' => $id,
								'redirect' => 'killproduct',
								'typetext' => 'le produit',
								'itemname' => $product['nom'],
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
