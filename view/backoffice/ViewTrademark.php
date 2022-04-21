<?php

require_once(DIR . '/model/ModelTrademark.php');

/**
 * Class to display HTML content about roles in back.
 *
 * @date $Date$
 */
class ViewTrademark
{
	/**
	 * Returns the HTML code to display the trademark list.
	 *
	 * @return void
	 */
	public static function TrademarkList()
	{
		if (Utils::cando(13))
		{
			global $config;

			$trademarks = new \Ecommerce\Model\ModelTrademark($config);
			$trademarkslist = $trademarks->listAllTrademarks();

			$pagetitle = 'Gestion des marques';
			$navtitle = 'Liste des marques';
			$navbits = [
				'index.php?do=listtrademarkss' => $pagetitle,
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
							if (count($trademarkslist) > 0)
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
																		$numberproducts = $quantity = count($trademarkslist);

																		foreach ($trademarkslist AS $data)
																		{
																			$trademarks->set_id($data['id']);
																			$compteur = $trademarks->getNumberOfProductsInTrademark();
																			$data['compteur'] = intval($compteur['compteur']);
																			?>
																			<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																				<td class="tablegrid-cell" style="width: 75px">
																				<?php
																				if ($data['logo'])
																				{
																				?>
																					<img src="../attachments/trademarks/<?= $data['logo'] ?>" alt="" width="50px" height="50px" />
																				<?php
																				}
																				else
																				{
																				?>
																					&nbsp;
																					<?php
																				} ?>
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
																							if ($data['compteur'] === 0 AND $numberproducts >= 2)
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
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des marques.');
		}
	}

	/**
	 * Returns the HTML code to display the add or edit trademark form.
	 *
	 * @param integer $id ID of the trademark if we need to edit an existing trademark. Empty for a new trademark.
	 *
	 * @return void
	 */
	public static function TrademarkAddEdit($id = '')
	{
		if (Utils::cando(14) OR Utils::cando(15))
		{
			global $config;

			$trademarks = new \Ecommerce\Model\ModelTrademark($config);

			$pagetitle = 'Gestion des marques';

			if ($id)
			{
				$trademarks->set_id($id);
				$trademarkinfos = $trademarks->listTrademarkInfos();
				$navtitle = 'Modifier une marque';
				$formredirect = 'updatetrademark';
			}
			else
			{
				$trademarkinfos = [
					'nom' => ''
				];

				$navtitle = 'Ajouter une marque';
				$formredirect = 'inserttrademark';
			}

			if ($trademarkinfos)
			{
				$navbits = [
					'index.php?do=listtrademarks' => $pagetitle,
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
															<input class="form-control" id="validationCustom01" type="text" required name="name" value="<?= $trademarkinfos['nom'] ?>">
														</div>
														<?php
														if (Utils::cando(16))
														{
															?>
															<div class="form-group">
																<label for="validationCustom02" class="col-form-label pt-0"><span>*</span> Logo</label>
																<input type="file" id="validationCustom02" name="file" />
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
						<script src="../assets/js/jquery-3.3.1.min.js"></script>

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
				throw new Exception('Une erreur est survenue pendant l\'affichage des options de la marque.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à ajouter ou modifier des marques.');
		}
	}
}
?>
