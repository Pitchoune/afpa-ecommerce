<?php

require_once(DIR . '/model/ModelOrder.php');
require_once(DIR . '/model/ModelOrderDetails.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelOrder;
use \Ecommerce\Model\ModelOrderDetails;
use \Ecommerce\Model\ModelTrademark;

/**
 * Class to display HTML content about customers in back.
 */
class ViewCustomer
{
	/**
	 * Returns the HTML code to display the customer list.
	 *
	 * @param object $customers Model object of customers.
	 * @param array $customerlist List of all customers for the current page.
	 * @param array $totalcustomers Total number of customers in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function CustomerList($customers, $customerlist, $totalcustomers, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Liste des clients';

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
																		<th class="tablegrid-header-cell" style="width: 75px">Pr??nom</th>
																		<?php
																		if (Utils::cando(30) OR Utils::cando(33) OR Utils::cando(35))
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
																			if (Utils::cando(30) OR Utils::cando(33) OR Utils::cando(35))
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

																					if (Utils::cando(35))
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

				if (isset($_SESSION['customer']['add']) AND $_SESSION['customer']['add'] === 1)
				{
					ViewTemplate::BackToast('Ajout de client', 'Client ajout?? avec succ??s !');
					unset($_SESSION['customer']['add']);
				}

				if (isset($_SESSION['customer']['edit']) AND $_SESSION['customer']['edit'] === 1)
				{
					ViewTemplate::BackToast('Modification de client', 'Client modifi?? avec succ??s !');
					unset($_SESSION['customer']['edit']);
				}

				if (isset($_SESSION['customer']['delete']) AND $_SESSION['customer']['delete'] === 1)
				{
					ViewTemplate::BackToast('Suppression de client', 'Client supprim?? avec succ??s !');
					unset($_SESSION['customer']['delete']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the add or edit customer form.
	 *
	 * @param string $navtitle Title of the page to show in the breadcrumb.
	 * @param array $navbits Breadcrumb content.
	 * @param array $customerinfos Default values to show as default in fields.
	 * @param string $formredirect Redirect part of the URL to save data.
	 * @param string $pagetitle Title of the page.
	 * @param integer $id ID of the customer if we need to edit an existing customer. Empty for a new customer.
	 *
	 * @return void
	 */
	public static function CustomerAddEdit($navtitle, $navbits, $customerinfos, $formredirect, $pagetitle, $id = '')
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
														<label for="firstname" class="col-form-label pt-0"> Nom <span>*</span></label>
														<input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" data-type="firstname" data-message="Le format du nom n'est pas valide." placeholder="Ins??rez votre nom" value="<?= $customerinfos['nom'] ?>" required />
														<small id="firstnameHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="lastname" class="col-form-label pt-0">Pr??nom <span>*</span></label>
														<input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" data-type="lastname" data-message="Le format du pr??nom n'est pas valide." placeholder="Ins??rez votre pr??nom" value="<?= $customerinfos['prenom'] ?>" required />
														<small id="lastnameHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="mail" class="col-form-label pt-0">Email <span>*</span></label>
														<input type="text" class="form-control" id="mail" name="email" aria-describedby="emailHelp" data-type="email" data-message="Le format de l'adresse email n'est pas valide." placeholder="Ins??rez votre adresse email" value="<?= $customerinfos['mail'] ?>" required />
														<small id="emailHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="telephone" class="col-form-label pt-0">T??l??phone <span>*</span></label>
														<input type="text" class="form-control" id="telephone" name="telephone" aria-describedby="telephoneHelp" data-type="telephone" data-message="Le format du num??ro de t??l??phone n'est pas valide." placeholder="Ins??rez votre t??l??phone" value="<?= $customerinfos['tel'] ?>" required />
														<small id="telephoneHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="address" class="col-form-label pt-0">Adresse <span>*</span></label>
														<input type="text" class="form-control" id="address" name="address" aria-describedby="addressHelp" data-type="address" data-message="Le format de l'adresse postale n'est pas valide." placeholder="Adresse" value="<?= $customerinfos['adresse'] ?>" required />
														<small id="addressHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="city" class="col-form-label pt-0">Ville <span>*</span></label>
														<input type="text" class="form-control" id="city" name="city" aria-describedby="cityHelp" data-type="city" data-message="Le format de la ville n'est pas valide." placeholder="Ville" value="<?= $customerinfos['ville'] ?>" required />
														<small id="cityHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="zipcode" class="col-form-label pt-0">Code postal <span>*</span></label>
														<input type="text" class="form-control" id="zipcode" name="zipcode" aria-describedby="zipcodeHelp" data-type="zipcode" data-message="Le format du code postal n'est pas valide." placeholder="Code postal" value="<?= $customerinfos['code_post'] ?>" required />
														<small id="zipcodeHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="country" class="col-form-label pt-0">Pays <span>*</span></label>
														<select class="form-control" name="country" id="country">
															<option value="0" <?= (!$customerinfos['pays'] ? ' selected disabled' : '') ?>>Choisissez le pays</option>
															<?= Utils::createCountryList($customerinfos['pays']) ?>
														</select>
														<small id="countryHelp" class="form-text text-muted"></small>
													</div>
													<div class="form-group">
														<label for="password" class="col-form-label pt-0">Mot de passe<?= (!$id ? ' <span>*</span>' : '') ?></label>
														<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" data-type="password" data-message="Le format du mot de passe n'est pas valide." required />
														<small id="passwordHelp" class="form-text text-muted"></small>
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

				ViewTemplate::BackFormValidation('validation', $id ? 5 : 4, 1);
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the delete customer form.
	 *
	 * @param integer $id ID of the customer to delete
	 * @param array $customer Customer informations.
	 *
	 * @return void
	 */
	public static function CustomerDeleteConfirmation($id, $customer)
	{
		$pagetitle = 'Gestion des clients';
		$navtitle = 'Supprimer le client';

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
	 * @param object $orders Model object of orders.
	 * @param array $data Customer data.
	 *
	 * @return void
	 */
	public static function ViewCustomerProfile($id, $orders, $data)
	{
		global $config;

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Visualisation d\'un client';

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
															<h6>T??l??phone de contact</h6>
															<div>
																<?= $data['tel'] ?>
															</div>
														</div>
													</div>
													<div class="media">
														<div class="media-body">
															<h6>Nombre de commandes effectu??es</h6>
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
																<td>Liste des 5 derni??res commandes effectu??es :</td>
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
																								<th class="tablegrid-header-cell" style="width: 25px">D??tails</th>
																								<th class="tablegrid-header-cell" style="width: 25px">??tat</th>
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
																								<td class="tablegrid-cell" style="width: 25px">Date de la commande : <?= $value['date'] ?><br />Quantit?? : <?= $totalquantity ?></td>
																								<td class="tablegrid-cell" style="width: 25px"><?= $value['etat'] ?></td>
																								<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 25px">
																									<a class="tablegrid-button tablegrid-search-button" type="button" title="Voir les d??tails de la commande" href="index.php?do=viewcustomerorderdetails&amp;id=<?= $value['id'] ?>"></a>
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
																	<td>Aucune commande n'a encore ??t?? effectu??e.</td>
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

	/**
	 * Returns the HTML code to display all orders done by a specific customer.
	 *
	 * @param integer $id ID of the customer.
	 * @param array $data Customer informations.
	 * @param array $orderlist All customer's orders.
	 * @param array $totalorders Total number of orders in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function ViewCustomerAllOrders($id, $data, $orderlist, $totalorders, $limitlower, $perpage)
	{
		global $config, $pagenumber;

		$pagetitle = 'Gestion des clients';
		$navtitle = 'Liste des commandes du client';

		$navbits = [
			'index.php?do=listcustomers' => $pagetitle,
			'' => $navtitle
		];

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
																		<th class="tablegrid-header-cell" style="width: 75px">??tat</th>
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
												<h5>Liste des cat??gories</h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(10))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addcategory" type="button" class="btn btn-secondary">Ajouter une cat??gorie</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de cat??gorie.</div>
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
	 * @param array $data Details of the order
	 * @param array $customer Customer informations.
	 *
	 * @return void
	 */
	public static function ViewOrderDetails($id, $data, $customer)
	{
		global $config;

		$pagetitle = 'Gestion des clients';
		$navtitle = 'D??tails de la commande';

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
														<h5 class="f-w-600 pb-3">D??tails g??n??raux</h5>
														<div class="table-responsive profile-table">
															<table class="table table-responsive">
																<tbody>
																	<tr>
																		<td>Date de commande</td>
																		<td><?= $data['date'] ?></td>
																	</tr>
																	<tr>
																		<td>??tat de la commande</td>
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
																		<td class="tablegrid-header-cell" style="width: 40px">Quantit??</td>
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
														<h5 class="f-w-600 pb-3">D??tails g??n??raux</h5>
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
																	if ($data['etat'] !== 'Envoy??')
																	{
																		?>
																		<tr class="tablegrid-row">
																			<td class="tablegrid-cell" colspan="2">Actions</td>
																		</tr>
																		<tr class="tablegrid-row">
																			<td class="tablegrid-cell" colspan="2">
																				<?php

																				if ($data['etat'] === 'Pay??')
																				{
																					?>
																					<a href="index.php?do=changecustomerorderstatus&amp;status=2&amp;id=<?= $data['id'] ?>" class="btn btn-primary">Modifier l'??tat en ????En pr??paration ??</a>
																					<?php
																				}
																				?>
																				<?php
																				if ($data['etat'] === 'En pr??paration')
																				{
																					?>
																					<a href="index.php?do=changecustomerorderstatus&amp;status=3&amp;id=<?= $data['id'] ?>" class="btn btn-primary">Modifier l'??tat en ?? Envoy?? ??</a>
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

				if (isset($_SESSION['employee']['order']['statusprepare']) AND $_SESSION['employee']['order']['statusprepare'] === 1)
				{
					ViewTemplate::BackToast('Modification de commande', '??tat de la commande pass?? ?? ?? En pr??paration ?? avec succ??s !');
					unset($_SESSION['employee']['order']['statusprepare']);
				}

				if (isset($_SESSION['employee']['order']['statussent']) AND $_SESSION['employee']['order']['statussent'] === 1)
				{
					ViewTemplate::BackToast('Modification de commande', '??tat de la commande pass?? ?? ?? Envoy?? ?? avec succ??s !');
					unset($_SESSION['employee']['order']['statussent']);
				}
				?>
			</body>
		</html>
	<?php
	}
}

?>
