<?php

require_once(DIR . '/model/ModelCustomer.php');

/**
 * Class to display HTML content about customers in back.
 *
 * @date $Date$
 */
class ViewCustomer
{
	/**
	 * Returns the HTML code to display the customer list.
	 *
	 * @return void
	 */
	public static function CustomerList()
	{
		if (Utils::cando(28))
		{
			global $config;

			$customers = new \Ecommerce\Model\ModelCustomer($config);
			$customerlist = $customers->listAllCustomers();
			$pagetitle = 'Gestion des clients';
			$navtitle = 'Liste des clients';
			$navbits = [
				'index.php?do=listcustomers' => $pagetitle,
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
							if (count($customerlist) > 0)
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
													if (Utils::cando(29))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=addcustomer" type="button" class="btn btn-secondary">Ajouter un client</a>
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
																			<th class="tablegrid-header-cell" style="width: 25px">#</th>
																			<th class="tablegrid-header-cell" style="width: 75px">Nom</th>
																			<th class="tablegrid-header-cell" style="width: 75px">Prénom</th>
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
																		// Get the number of customers returned by the model for background lines
																		$numbercustomers = $quantity = count($customerlist);

																		foreach ($customerlist AS $data)
																		{
																			?>
																			<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																				<td class="tablegrid-cell" style="width: 25px"><?= $data['id'] ?></td>
																				<td class="tablegrid-cell" style="width: 75px"><?= $data['nom'] ?></td>
																				<td class="tablegrid-cell" style="width: 75px"><?= $data['prenom']; ?></td>
																				<?php
																				if (Utils::cando(20) OR Utils::cando(22))
																				{
																					?>
																					<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																						<a class="tablegrid-button tablegrid-search-button" type="button" title="Voir le profil" href="index.php?do=viewcustomerprofile&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																						if (Utils::cando(20))
																						{
																							?>
																							<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editdeliver&amp;id=<?= $data['id'] ?>"></a>
																							<?php
																						}

																						if (Utils::cando(22))
																						{
																							?>
																								<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deletedeliver&amp;id=<?= $data['id'] ?>"></a>
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
													<h5>Liste des clients</h5>
												</div>
												<div class="card-body">
													<?php
													if (Utils::cando(29))
													{
														?>
														<div class="btn-popup pull-right">
															<a href="index.php?do=adddeliver" type="button" class="btn btn-secondary">Ajouter un client</a>
														</div>
														<?php
													}
													?>
													<div class="table-responsive">
														<div class="text-center">Il n'y a pas de client.</div>
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
					if ($_SESSION['customer']['add'] === 1)
					{
						ViewTemplate::BackToast('Ajout de client', 'Client ajouté avec succès !');
						unset($_SESSION['customer']['add']);
					}

					if ($_SESSION['customer']['edit'] === 1)
					{
						ViewTemplate::BackToast('Modification de client', 'Client modifié avec succès !');
						unset($_SESSION['customer']['edit']);
					}

					if ($_SESSION['customer']['delete'] === 1)
					{
						ViewTemplate::BackToast('Suppression de client', 'Client supprimé avec succès !');
						unset($_SESSION['customer']['delete']);
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
	public static function CustomerAddEdit($id = '')
	{
		if (Utils::cando(29) OR Utils::cando(30))
		{
			global $config;

			$customers = new \Ecommerce\Model\ModelCustomer($config);

			$pagetitle = 'Gestion des clients';

			if ($id)
			{
				$customers->set_id($id);
				$customerinfos = $customers->listDeliverInfos();
				$navtitle = 'Modifier un client';
				$formredirect = 'updatecustomer';
			}
			else
			{
				$customerinfos = [
					'nom' => ''
				];

				$navtitle = 'Ajouter un client';
				$formredirect = 'insertcustomer';
			}

			if ($customerinfos)
			{
				$navbits = [
					'index.php?do=listdelivers' => $pagetitle,
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
															<input class="form-control" id="validationCustom01" type="text" required name="name" value="<?= $customerinfos['nom'] ?>">
														</div>
														<?php
														if (Utils::cando(21))
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
				throw new Exception('Une erreur est survenue pendant l\'affichage des options du client.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à ajouter ou modifier des clients.');
		}
	}
}
?>
