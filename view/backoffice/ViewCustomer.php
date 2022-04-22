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
																			if (Utils::cando(30) OR Utils::cando(33) OR Utils::cando(34))
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
																				if (Utils::cando(30) OR Utils::cando(33) OR Utils::cando(34))
																				{
																					?>
																					<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																						<?php
																						if (Utils::cando(33))
																						{
																							?>
																							<a class="tablegrid-button tablegrid-search-button" type="button" title="Voir le profil" href="index.php?do=viewcustomerprofile&amp;id=<?= $data['id'] ?>"></a>
																							<?php
																						}

																						if (Utils::cando(30))
																						{
																							?>
																							<a class="tablegrid-button tablegrid-edit-button" type="button" title="Modifier" href="index.php?do=editcustomer&amp;id=<?= $data['id'] ?>"></a>
																							<?php
																						}

																						if (Utils::cando(34))
																						{
																							?>
																								<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deletecustomer&amp;id=<?= $data['id'] ?>"></a>
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
															<a href="index.php?do=addcustomer" type="button" class="btn btn-secondary">Ajouter un client</a>
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
			throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des clients.');
		}
	}

	/**
	 * Returns the HTML code to display the add or edit customer form.
	 *
	 * @param integer $id ID of the customer if we need to edit an existing customer. Empty for a new customer.
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
				$customerinfos = $customers->getCustomerInfosFromId();
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
															<label for="validationCustom01" class="col-form-label pt-0"><span>*</span> Nom</label>
															<input class="form-control" id="validationCustom01" type="text" required name="firstname" value="<?= $customerinfos['nom'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom02" class="col-form-label pt-0"><span>*</span> Nom</label>
															<input class="form-control" id="validationCustom02" type="text" required name="lastname" value="<?= $customerinfos['prenom'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom03" class="col-form-label pt-0"><span>*</span> Email</label>
															<input class="form-control" id="validationCustom03" type="text" required name="email" value="<?= $customerinfos['mail'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom04" class="col-form-label pt-0"><span>*</span> Téléphone</label>
															<input class="form-control" id="validationCustom04" type="text" required name="telephone" value="<?= $customerinfos['tel'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom05" class="col-form-label pt-0"><span>*</span> Adresse</label>
															<input class="form-control" id="validationCustom05" type="text" required name="address" value="<?= $customerinfos['adresse'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom06" class="col-form-label pt-0"><span>*</span> Ville</label>
															<input class="form-control" id="validationCustom06" type="text" required name="city" value="<?= $customerinfos['ville'] ?>">
														</div>
														<div class="form-group">
															<label for="validationCustom07" class="col-form-label pt-0"><span>*</span> Code postal</label>
															<input class="form-control" id="validationCustom07" type="text" required name="zipcode" value="<?= $customerinfos['code_post'] ?>">
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

	public static function ViewCustomerProfile($id)
	{
		if (Utils::cando(33))
		{
			global $config;

			$customers = new \Ecommerce\Model\ModelCustomer($config);

			$pagetitle = 'Gestion des clients';

			$customers->set_id($id);
			$data = $customers->getCustomerInfosFromId();

			// Grab an external value and add it into the data array filled above
			require_once(DIR . '/model/ModelOrder.php');
			$orders = new \Ecommerce\Model\ModelOrder($config);
			$orders->set_customer($data['id']);
			$data += $orders->getNumberOfOrdersForCustomer();

			$navtitle = 'Visualisation d\'un client';

			if ($data)
			{
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

									<!-- Container-fluid starts-->
									<?php
									ViewTemplate::Breadcrumb($pagetitle, $navbits);
									?>
									<!-- Container-fluid ends-->

									<!-- Container-fluid starts-->
									<div class="container-fluid">
										<div class="row">
											<div class="col-xl-4">
												<div class="card">
													<div class="card-body">
														<div class="profile-details text-center">
															<h5 class="f-w-600 mb-0"><?= $data['prenom'] . ' ' . $data['nom'] ?></h5>
															<span><?= $data['mail'] ?></span>
														</div>
														<hr>
														<div class="project-status">
															<h5 class="f-w-600">Adresse du client</h5>
															<div class="media">
																<div class="media-body">
																	<h6>Adresse</h6>
																	<div>
																		<?= $data['adresse'] ?>
																	</div>
																</div>
															</div>
															<div class="media">
																<div class="media-body">
																	<h6>Code postal</h6>
																	<div>
																		<?= $data['code_post'] ?>
																	</div>
																</div>
															</div>
															<div class="media">
																<div class="media-body">
																	<h6>Ville</h6>
																	<div>
																		<?= $data['ville'] ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-8">
												<div class="card tab2-card">
													<div class="card-body">
														<div class="tab-pane fade show active" id="top-profile" role="tabpanel" aria-labelledby="top-profile-tab">
															<h5 class="f-w-600">Profil</h5>
															<div class="table-responsive profile-table">
																<table class="table table-responsive">
																	<tbody>
																	<tr>
																		<td>Téléphone de contact :</td>
																		<td><?= $data['tel'] ?></td>
																	</tr>
																	<tr>
																		<td>Nombre de commandes effectuées :</td>
																		<td><?= $data['nborders'] ?></td>
																	</tr>
																	<tr>
																		<td>Liste des 5 dernières commandes effectuées :</td>
																	</tr>
																	<tr>
																		<?php
																		if ($data['nborders'] > 0)
																		{
																			?>
																			Traitement de la liste des commandes
																			<?php
																		}
																		else
																		{
																			?>
																			<td>Aucune commande n'a encore été effectuée.</td>
																			<?php
																		}
																		?>
																	</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- Container-fluid Ends-->

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
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
		}
	}
}
?>
