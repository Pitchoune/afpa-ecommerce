<?php

require_once(DIR . '/model/ModelCustomer.php');
require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelCustomer;
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelTrademark;

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
			global $config, $pagenumber;

			$customers = new ModelCustomer($config);

			$pagetitle = 'Gestion des clients';
			$navtitle = 'Liste des clients';

			$navbits = [
				'index.php?do=listcustomers' => $pagetitle,
				'' => $navtitle
			];

			$totalcustomers = $customers->getTotalNumberOfCustomers();

			// Number max per page
			$perpage = 10;

			Utils::sanitize_pageresults($totalcustomers['nbcustomers'], $pagenumber, $perpage, 200, 20);

			$limitlower = ($pagenumber - 1) * $perpage;
			$limitupper = ($pagenumber) * $perpage;

			if ($limitupper > $totalcustomers['nbcustomers'])
			{
				$limitupper = $totalcustomers['nbcustomers'];

				if ($limitlower > $totalcustomers['nbcustomers'])
				{
					$limitlower = ($totalcustomers['nbcustomers'] - $perpage) - 1;
				}
			}

			if ($limitlower < 0)
			{
				$limitlower = 0;
			}

			$customerlist = $customers->getSomeCustomers($limitlower, $perpage);

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
							if (count($customerlist) > 0)
							{
								ViewTemplate::Breadcrumb($pagetitle, $navbits);
								?>

								<!-- customers listing -->
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
																		$quantity = count($customerlist);

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
															<?php
															Utils::construct_page_nav($pagenumber, $perpage, $totalcustomers['nbcustomers'], 'index.php?do=listcustomers', 'back');
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- / customers listing -->

								<?php
							}
							else
							{
								ViewTemplate::breadcrumb($pagetitle, $navbits);
								?>

								<!-- customers listing -->
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
								<!-- / customers listing -->
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

			$customers = new ModelCustomer($config);

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

									<!-- add/edit customers -->
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
																<label for="firstname" class="col-form-label pt-0"><span>*</span> Prénom</label>
																<input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du nom n'est pas valide." placeholder="Insérez votre nom" value="<?= $customerinfos['nom'] ?>" required />
																<small id="firstnameHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="lastname" class="col-form-label pt-0"><span>*</span> Nom</label>
																<input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du prénom n'est pas valide." placeholder="Insérez votre prénom" value="<?= $customerinfos['prenom'] ?>" required />
																<small id="lastnameHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="mail" class="col-form-label pt-0"><span>*</span> Email</label>
																<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Insérez votre adresse email" value="<?= $customerinfos['mail'] ?>" required />
																<small id="emailHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="password" class="col-form-label pt-0"><span>*</span> Mot de passe</label>
																<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" data-type="password" data-message="Le format du mot de passe n'est pas valide." required />
																<small id="passwordHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="telephone" class="col-form-label pt-0"><span>*</span> Téléphone</label>
																<input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephoneHelp" data-type="telephone" data-message="Le format du numéro de téléphone n'est pas valide." placeholder="Insérez votre téléphone" value="<?= $customerinfos['tel'] ?>" required />
																<small id="telephoneHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="address" class="col-form-label pt-0"><span>*</span> Adresse</label>
																<input type="text" class="form-control" id="address" name="address" aria-describedby="addressHelp" data-type="address" data-message="Le format de l'adresse postale n'est pas valide." placeholder="Adresse" value="<?= $customerinfos['adresse'] ?>" required />
																<small id="addressHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="city" class="col-form-label pt-0"><span>*</span> Ville</label>
																<input type="text" class="form-control" id="city" name="city" aria-describedby="cityHelp" data-type="city" data-message="Le format de la ville n'est pas valide." placeholder="Ville" value="<?= $customerinfos['ville'] ?>" required />
																<small id="cityHelp" class="form-text text-muted"></small>
															</div>
															<div class="form-group">
																<label for="zipcode" class="col-form-label pt-0"><span>*</span> Code postal</label>
																<input type="text" class="form-control" id="zipcode" name="zipcode" aria-describedby="zipcodeHelp" data-type="zipcode" data-message="Le format du code postal n'est pas valide." placeholder="Code postal" value="<?= $customerinfos['code_post'] ?>" required />
																<small id="zipcodeHelp" class="form-text text-muted"></small>
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
									<!-- / add/edit customers -->

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

	/**
	 * Returns the HTML code to display the delete customer form.
	 *
	 * @param integer $id ID of the customer to delete
	 *
	 * @return void
	 */
	public static function CustomerDeleteConfirmation($id)
	{
		global $config;

		$id = intval($id);

		$customers = new ModelCustomer($config);

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Supprimer le client';

		$customers->set_id($id);
		$customer = $customers->getCustomerInfosFromId();

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
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
								'redirect' => 'killcustomer',
								'typetext' => 'le client',
								'itemname' => $customer['prenom'] . ' ' . $customer['nom'],
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

	/**
	 * Returns the HTML code to display the customer profile
	 *
	 * @param integer $id, ID of the customer.
	 *
	 * @return void
	 */
	public static function ViewCustomerProfile($id)
	{
		if (Utils::cando(33))
		{
			global $config;

			$pagetitle = 'Gestion des clients';

			$customers = new ModelCustomer($config);
			$customers->set_id($id);
			$data = $customers->getCustomerInfosFromId();

			// Grab an external value and add it into the data array filled above
			$orders = new ModelOrder($config);
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

									<!-- customer profile -->
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
														<div class="customer-infos">
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
															<div class="media">
																<div class="media-body">
																	<h6>Téléphone de contact</h6>
																	<div>
																		<?= $data['tel'] ?>
																	</div>
																</div>
															</div>
															<div class="media">
																<div class="media-body">
																	<h6>Nombre de commandes effectuées</h6>
																	<div>
																		<?= $data['nborders'] ?>
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
															<div class="table-responsive profile-table">
																<table class="table table-responsive">
																	<tbody>
																	<tr>
																		<td>Liste des 5 dernières commandes effectuées :</td>
																	</tr>
																	<tr>
																		<?php
																		if (intval($data['nborders']) > 0)
																		{
																			?>
																			<td>
																				<div class="table-responsive">
																					<div class="tablegrid">
																						<div class="tablegrid-grid-header">
																							<table class="tablegrid-table">
																								<thead>
																									<tr class="tablegrid-header-row">
																										<th class="tablegrid-header-cell" style="width: 25px">Commande</th>
																										<th class="tablegrid-header-cell" style="width: 25px">Prix</th>
																										<th class="tablegrid-header-cell" style="width: 25px">Détails</th>
																										<th class="tablegrid-header-cell" style="width: 25px">État</th>
																										<th class="tablegrid-header-cell tablegrid-control-field tablegrid-align-center" style="width: 25px">Actions</th>
																									</tr>
																								</thead>
																							</table>
																						</div>
																						<div class="tablegrid-grid-body">
																							<table class="tablegrid-table">
																								<tbody>
																								<?php
																								$listorders = $orders->getFiveLastCustomerOrders();

																								foreach ($listorders AS $key => $value)
																								{
																									$orderdetails = new ModelOrderDetails($config);
																									$orderdetails->set_order($value['id']);
																									$orderdetail = $orderdetails->getOrderDetails();

																									$totalorder = 0;
																									$totalquantity = 0;

																									foreach ($orderdetail AS $detail => $content)
																									{
																										$totalorder += ($content['quantite'] * $content['prix']);
																										$totalquantity += $content['quantite'];
																									}

																									?>
																									<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																										<td class="tablegrid-cell" style="width: 25px">#<?= $value['id'] ?></td>
																										<td class="tablegrid-cell" style="width: 25px"><?= number_format($totalorder, 2) ?> &euro;</td>
																										<td class="tablegrid-cell" style="width: 25px">Date de la commande : <?= $value['date'] ?><br />Quantité : <?= $totalquantity ?></td>
																										<td class="tablegrid-cell" style="width: 25px"><?= $value['etat'] ?></td>
																										<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 25px">
																											<a class="tablegrid-button tablegrid-search-button" type="button" title="Voir les détails de la commande" href="index.php?do=viewcustomerorderdetails&amp;id=<?= $value['id'] ?>"></a>
																										</td>
																									</tr>
																									<?php
																								}
																								?>
																								</tbody>
																							</table>
																						</div>
																					</div>
																				</div>
																			</td>
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
														<div class="btn-popup pull-right">
															<a href="index.php?do=viewcustomerallorders&id=<?= $data['id'] ?>" type="button" class="btn btn-secondary">Afficher toutes les commandes</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- / customer profile -->

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
			else
			{
				throw new Exception('Une erreur est survenue pendant l\'affichage du client.');
			}
		}
		else
		{
			throw new Exception('Vous n\'êtes pas autorisé à consulter le profil des clients.');
		}
	}

	/**
	 * Returns the HTML code to display all orders done by a specific customer.
	 *
	 * @param integer $id ID of the customer.
	 *
	 * @return void
	 */
	public static function ViewCustomerAllOrders($id)
	{
		global $config, $pagenumber;

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Liste des commandes du client';

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
			'' => $navtitle
		];

		$customers = new ModelCustomer($config);
		$customers->set_id($id);
		$data = $customers->getCustomerInfosFromId();

		$orders = new ModelOrder($config);
		$orders->set_customer($data['id']);
		$totalorders = $orders->getNumberOfOrdersForCustomer();

		// Number max per page
		$perpage = 10;

		Utils::sanitize_pageresults($totalorders['nborders'], $pagenumber, $perpage, 200, 20);

		$limitlower = ($pagenumber - 1) * $perpage;
		$limitupper = ($pagenumber) * $perpage;

		if ($limitupper > $totalorders['nborders'])
		{
			$limitupper = $totalorders['nborders'];

			if ($limitlower > $totalorders['nborders'])
			{
				$limitlower = ($totalorders['nborders'] - $perpage) - 1;
			}
		}

		if ($limitlower < 0)
		{
			$limitlower = 0;
		}

		$orderlist = $orders->getAllCustomerOrders($limitlower, $perpage);

		?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<?= ViewTemplate::BackHead($pagetitle)?>
			</head>

			<body>
				<div class="page-wrapper">
					<?= ViewTemplate::BackHeader() ?>

					<!-- body -->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
						<?php
						if ($orderlist)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- customer orders -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<div class="table-responsive">
													<div class="tablegrid">
														<div class="tablegrid-grid-header">
															<table class="tablegrid-table">
																<thead>
																	<tr class="tablegrid-header-row">
																		<th class="tablegrid-header-cell" style="width: 125px">Commande #</th>
																		<th class="tablegrid-header-cell" style="width: 75px">Total</th>
																		<th class="tablegrid-header-cell" style="width: 75px">État</th>
																		<th class="tablegrid-header-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">Actions</th>
																	</tr>
																</thead>
															</table>
														</div>
														<div class="tablegrid-grid-body">
															<table class="tablegrid-table">
																<tbody>
																	<?php
																	// Get the number of orders returned by the model for background lines
																	$quantity = count($orderlist);

																	foreach ($orderlist AS $key => $value)
																	{
																		$orderdetails = new ModelOrderDetails($config);
																		$orderdetails->set_order($value['id']);
																		$details = $orderdetails->getOrderDetails();

																		$totalprice = 0;

																		foreach ($details AS $key2 => $value2)
																		{
																			$totalprice += ($value2['quantite'] * $value2['prix']);
																		}

																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																			<td class="tablegrid-cell" style="width: 125px"><?= $value['id'] ?></td>
																			<td class="tablegrid-cell" style="width: 75px"><?= number_format($totalprice, 2) ?> &euro;</td>
																			<td class="tablegrid-cell" style="width: 75px"><?= $value['etat'] ?></td>
																			<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																				<a class="tablegrid-button tablegrid-search-button" type="button" title="Modifier" href="index.php?do=viewcustomerorderdetails&amp;id=<?= $value['id'] ?>"></a>
																			</td>
																		</tr>
																		<?php
																	}
																	?>
																</tbody>
															</table>
														</div>
														<?php
														Utils::construct_page_nav($pagenumber, $perpage, $totalorders['nborders'], 'index.php?do=viewcustomerallorders&amp;id=' . $data['id'], 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / customer orders -->

							<?php
						}
						else
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- customer orders -->
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
							<!-- / customer orders -->
							<?php
						}
						?>
						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
				</div>

				<?= ViewTemplate::BackFoot() ?>
			</body>
		</html>
	<?php
	}

	/**
	 * Returns the HTMl code to display the details of an order.
	 *
	 * @param integer $id ID of the order.
	 *
	 * @return void
	 */
	public static function ViewOrderDetails($id)
	{
		if (Utils::cando(32))
		{
			global $config;

			$pagetitle = 'Gestion des clients';

			// Grab an external value and add it into the data array filled above
			$orders = new ModelOrder($config);
			$orders->set_id($id);

			$data = $orders->getOrderDetails();

			$navtitle = 'Détails de la commande';

			if ($data)
			{
				// Get customer informations
				$customers = new ModelCustomer($config);
				$customers->set_id($data['id_client']);
				$customer = $customers->getCustomerInfosFromId();

				$navbits = [
					'index.php?do=listcustomers' => $pagetitle,
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

									<!-- customer order details -->
									<div class="container-fluid">
										<div class="row">
											<div class="col-xl-8">
												<div class="card">
													<div class="card-header">
														<h5>Commande #<?= $data['id'] ?></h5>
													</div>
													<div class="card-body">
														<div class="row">
															<div class="col-xl-6">
																<h5 class="f-w-600 pb-3">Détails généraux</h5>
																<div class="table-responsive profile-table">
																	<table class="table table-responsive">
																		<tbody>
																			<tr>
																				<td>Date de commande</td>
																				<td><?= $data['date'] ?></td>
																			</tr>
																			<tr>
																				<td>État de la commande</td>
																				<td><?= $data['etat'] ?></td>
																			</tr>
																			<tr>
																				<td>Client</td>
																				<td><?= $customer['prenom'] ?> <?= $customer['nom'] ?></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
															<div class="col-xl-6">
																<h5 class="f-w-600 pb-3">Adresse de facturation / livraison</h5>
																<div class="table-responsive profile-table">
																	<table class="table-responsive">
																		<tbody>
																			<tr>
																				<td>Adresse</td>
																				<td><?= $customer['adresse'] ?></td>
																			</tr>
																			<tr>
																				<td>Code postal</td>
																				<td><?= $customer['code_post'] ?></td>
																			</tr>
																			<tr>
																				<td>Ville</td>
																				<td><?= $customer['ville'] ?></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="card">
													<div class="card-header">
														<h5>Produits de la commande</h5>
													</div>
													<div class="card-body">
														<div class="table-responsive">
															<div class="tablegrid">
																<div class="tablegrid-grid-header">
																	<table class="tablegrid-table">
																		<thead>
																			<tr class="tablegrid-header-row">
																				<td class="tablegrid-header-cell" style="width: 180px">Produit</td>
																				<td class="tablegrid-header-cell" style="width: 40px">Prix</td>
																				<td class="tablegrid-header-cell" style="width: 40px">Quantité</td>
																				<td class="tablegrid-header-cell" style="width: 40px">Total</td>
																			</tr>
																		</thead>
																	</table>
																</div>
																<div class="tablegrid-grid-body">
																	<table class="tablegrid-table">
																		<tbody>
																			<?php
																			$orderdetails = new ModelOrderDetails($config);
																			$orderdetails->set_order($id);
																			$details = $orderdetails->getOrderDetails();

																			$totalprice = 0;

																			foreach ($details AS $key => $value)
																			{
																				$totalprice += ($value['quantite'] * $value['prix']);

																				if (empty($value['photo']))
																				{
																					$photo = "../assets/images/nophoto.jpg";
																				}
																				else
																				{
																					$photo = "../attachments/products/" . $value['photo'];
																				}

																				$trademarks = new ModelTrademark($config);
																				$trademarks->set_id($value['id_marque']);
																				$trademark = $trademarks->listTrademarkInfos();
																				?>
																				<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																					<td class="tablegrid-cell" style="width: 180px">
																						<div>
																							<div class="float-start"><img src="<?= $photo ?>" alt="" width="50px" height="50px" /></div>
																							<div style="line-height: 50px"><?= $trademark['nom'] ?> - <?= $value['nom'] ?></div>
																						</div>
																					</td>
																					<td class="tablegrid-cell" style="width: 40px"><?= $value['prix'] ?> &euro;</td>
																					<td class="tablegrid-cell" style="width: 40px"><?= $value['quantite'] ?></td>
																					<td class="tablegrid-cell" style="width: 40px"><?= number_format($value['prix'] * $value['quantite'], 2) ?> &euro;</td>
																				</tr>
																				<?php
																			}
																			?>
																		</tbody>
																	</table>
																</div>
																<div class="tavblegrid-grid-body">
																	<table class="tablegrid-table">
																		<tbody>
																			<tr class="tablegrid-row">
																				<td class="tablegrid-cell" style="width: 180px">Frais de port</td>
																				<td class="tablegrid-cell" style="width: 40px">&nbsp;</td>
																				<td class="tablegrid-cell" style="width: 40px">&nbsp;</td>
																				<td class="tablegrid-cell" style="width: 40px">0 &euro;</td>
																			</tr>
																			<tr class="tablegrid-row">
																				<td class="tablegrid-cell" style="width: 180px">Total</td>
																				<td class="tablegrid-cell" style="width: 40px">&nbsp;</td>
																				<td class="tablegrid-cell" style="width: 40px">&nbsp;</td>
																				<td class="tablegrid-cell" style="width: 40px"><?= number_format($totalprice, 2) ?> &euro;</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-4">
												<div class="card">
													<div class="card-header">
														<h5>Informations de livraison</h5>
													</div>
													<div class="card-body">
														<div class="row">
															<div class="col-xl-12">
																<h5 class="f-w-600 pb-3">Détails généraux</h5>
																<div class="table-responsive profile-table">
																	<table class="table table-responsive">
																		<tbody>
																			<tr class="tablegrid-row">
																				<td class="tablegrid-cell">Mode de livraison</td>
																				<td class="tablegrid-cell"><?= $data['mode']?></td>
																			</tr>
																			<tr class="tablegrid-row">
																				<td class="tablegrid-cell">Transporteur</td>
																				<td class="tablegrid-cell"><?= $data['delivername'] ?></td>
																			</tr>
																			<?php
																			if ($data['etat'] !== 'Envoyé')
																			{
																				?>
																				<tr class="tablegrid-row">
																					<td class="tablegrid-cell" colspan="2">Actions</td>
																				</tr>
																				<tr class="tablegrid-row">
																					<td class="tablegrid-cell" colspan="2">
																						<?php

																						if ($data['etat'] === 'Payé')
																						{
																							?>
																							<a href="index.php?do=changecustomerorderstatus&amp;status=2&amp;id=<?= $data['id'] ?>" class="btn btn-primary">Modifier l'état en « En préparation »</a>
																							<?php
																						}
																						?>
																						<?php
																						if ($data['etat'] === 'En préparation')
																						{
																							?>
																							<a href="index.php?do=changecustomerorderstatus&amp;status=3&amp;id=<?= $data['id'] ?>" class="btn btn-primary">Modifier l'état en « Envoyé »</a>
																							<?php
																						}
																						?>
																					</td>
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
									<!-- / customer order details -->
								</div>

								<?= ViewTemplate::BackFooter() ?>
							</div>
							<!-- / body -->
						</div>

						<?php
						ViewTemplate::BackFoot();

						if ($_SESSION['employee']['order']['statusprepare'] === 1)
						{
							ViewTemplate::BackToast('Modification de commande', 'État de la commande passé à « En préparation » avec succès !');
							unset($_SESSION['employee']['order']['statusprepare']);
						}

						if ($_SESSION['employee']['order']['statussent'] === 1)
						{
							ViewTemplate::BackToast('Modification de commande', 'État de la commande passé à « Envoyé » avec succès !');
							unset($_SESSION['employee']['order']['statussent']);
						}
						?>
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
