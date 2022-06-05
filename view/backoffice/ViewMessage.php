<?php

/**
 * Class to display HTML content about messages in back.
 */
class ViewMessage
{
	/**
	 * Returns the HTML code to display the message list.
	 *
	 * @param object $messages Model object of messages.
	 * @param array $messagelist List of all messages for the current page.
	 * @param array $totalmessages Total number of messages in the database.
	 * @param integer $limitlower Position in the database items to start the pagination.
	 * @param integer $perpage Number of items per page.
	 *
	 * @return void
	 */
	public static function MessageList($messages, $messagelist, $totalmessages, $limitlower, $perpage)
	{
		global $pagenumber;

		$pagetitle = 'Gestion des messages';
		$navtitle = 'Liste des messages';

		$navbits = [
			'index.php?do=listmessages' => $pagetitle,
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

					<!-- Page Body Start-->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
						<?php
						if (count($messagelist) > 0)
						{
							ViewTemplate::Breadcrumb($pagetitle, $navbits);
							?>

							<!-- delivers listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5><?= $navtitle ?></h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(19))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=adddeliver" type="button" class="btn btn-secondary">Ajouter un transporteur</a>
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
																	// Get the number of delivers returned by the model for background lines
																	$quantity = count($messagelist);

																	foreach ($messagelist AS $data)
																	{
																		$messages->set_id($data['id']);
																		//$compteur = $messages->getNumberOfOrdersInDeliver();
																		$data['compteur'] = 0;//intval($compteur['compteur']);
																		?>
																		<tr class="<?= (($quantity++ % 2) == 0 ? 'tablegrid-row' : 'tablegrid-alt-row') ?>">
																			<td class="tablegrid-cell" style="width: 125px"><?= $data['titre']; ?></td>
																			<?php
																			if (Utils::cando(20) OR Utils::cando(22))
																			{
																				?>
																				<td class="tablegrid-cell tablegrid-control-field tablegrid-align-center" style="width: 75px">
																					<?php
																					if (Utils::cando(20))
																					{
																						?>
																						<a class="tablegrid-button tablegrid-search-button" type="button" title="Modifier" href="index.php?do=viewconversation&amp;id=<?= $data['id'] ?>"></a>
																						<?php
																					}

																					if (Utils::cando(22))
																					{
																						if ($data['compteur'] === 0 OR $totalmessages['nbmessages'] >= 2)
																						{
																						?>
																							<a class="tablegrid-button tablegrid-delete-button" type="button" title="Supprimer" href="index.php?do=deleteconversation&amp;id=<?= $data['id'] ?>"></a>
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
														Utils::construct_page_nav($pagenumber, $perpage, $totalmessages['nbdelivers'], 'index.php?do=listdelivers', 'back');
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / delivers listing -->

							<?php
						}
						else
						{
							ViewTemplate::breadcrumb($pagetitle, $navbits);
							?>

							<!-- delivers listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-header">
												<h5>Liste des messages</h5>
											</div>
											<div class="card-body">
												<?php
												if (Utils::cando(19))
												{
													?>
													<div class="btn-popup pull-right">
														<a href="index.php?do=addmessage" type="button" class="btn btn-secondary">Ajouter un message</a>
													</div>
													<?php
												}
												?>
												<div class="table-responsive">
													<div class="text-center">Il n'y a pas de message.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- / delivers listing -->
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

				if ($_SESSION['deliver']['add'] === 1)
				{
					ViewTemplate::BackToast('Ajout de transporteur', 'Transporteur ajouté avec succès !');
					unset($_SESSION['deliver']['add']);
				}

				if ($_SESSION['deliver']['edit'] === 1)
				{
					ViewTemplate::BackToast('Modification de transporteur', 'Transporteur modifié avec succès !');
					unset($_SESSION['deliver']['edit']);
				}

				if ($_SESSION['deliver']['delete'] === 1)
				{
					ViewTemplate::BackToast('Suppression de transporteur', 'Transporteur supprimé avec succès !');
					unset($_SESSION['deliver']['delete']);
				}
				?>
			</body>
		</html>
		<?php
	}

	/**
	 * Returns the HTML code to display the messages list of a conversation.
	 *
	 * @param integer $id ID of the conversation.
	 * @param array $messages Array containing messages informations.
	 * @param string $title Title of the conversation.
	 * @param array $customerinfos Customer informations.
	 * @param integer $latestid Latest message ID of the conversation.
	 *
	 * @return void
	 */
	public static function ViewConversation($id, $messages, $title, $customerinfos, $latestid)
	{
		$pagetitle = 'Gestion des messages';
		$navtitle = 'Visualisation de la conversation';

		$navbits = [
			'listmessages' => $pagetitle,
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

					<!-- Page Body Start-->
					<div class="page-body-wrapper">
						<?= ViewTemplate::Sidebar() ?>

						<div class="page-body">
							<?= ViewTemplate::Breadcrumb($pagetitle, $navbits) ?>

							<!-- messages listing -->
							<div class="container-fluid">
								<div class="row">
									<div class="col-xl-9">
										<div class="card">
											<div class="card-body">
												<div class="conversations">
													<div class="message-header">
														<div class="message-title">
															<div class="user ms-2">
																<div>
																	<img class="img-40 rounded-circle" src="../assets/images/noavatar.png" alt="Avatar de l'employé" />
																</div>
																<div class="user-info ms-2">
																	<span class="name"><?= $title ?></span>
																</div>
															</div>
														</div>
													</div>
													<div class="conversations-body">
														<div class="conversations-content">
															<?php
															foreach ($messages AS $data)
															{
																?>
																<div class="message-content-wrapper">
																	<div class="message message-<?= ($data['id_client'] ? 'in' : 'out') ?>">
																		<?php
																		if ($data['id_client'])
																			{ ?>
																			<div class="me-2">
																				<img class="img-40 rounded-circle" src="../assets/images/noavatar.png" alt="Avatar de l'employé" />
																			</div>
																			<?php
																			}
																		?>
																		<div class="message-body">
																			<div class="message-content">
																				<div class="content">
																					<?= $data['message'] ?>
																				</div>
																			</div>
																		</div>
																		<?php
																		if ($data['id_employe'])
																			{ ?>
																			<div class="ms-2">
																				<img class="img-40 rounded-circle" src="../assets/images/noavatar.png" alt="Avatar de l'employé" />
																			</div>
																			<?php
																			}
																		?>
																	</div>
																</div>
																<?php
															}
															?>
														</div>
													</div>
													<form class="messages-form" action="index.php?do=sendreply&amp;originalid=<?= $id ?>&amp;latestid=<?= $latestid ?>" method="post">
														<div class="messages-form-control">
															<input type="text" name="message" placeholder="Écrire ici" class="form-control input-pill input-solid message-input" />
															<input type="hidden" name="do" value="sendreply" />
															<input type="hidden" name="customerid" value="<?= $customerinfos['id'] ?>" />
															<input type="hidden" name="originalid" value="<?= $id ?>" />
															<input type="hidden" name="latestid" value="<?= $latestid ?>" />
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3">
										<div class="card tab2-card">
											<div class="card-body">
												<div class="row">
													<div class="col-xl-12">
														<h5 class="f-w-600 pb-3">Détails du client</h5>
														<div class="table-responsive profile-table">
															<table class="table table-responsive">
																<tbody>
																	<tr>
																		<td>Client</td>
																		<td><?= $customerinfos['prenom'] ?> <?= $customerinfos['nom'] ?></td>
																	</tr>
																	<tr>
																		<td>Adresse</td>
																		<td><?= $customerinfos['adresse'] ?></td>
																	</tr>
																	<tr>
																		<td>Code postal</td>
																		<td><?= $customerinfos['code_post'] ?></td>
																	</tr>
																	<tr>
																		<td>Ville</td>
																		<td><?= $customerinfos['ville'] ?></td>
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
							</div>
							<!-- / messages listing -->
						</div>

						<?= ViewTemplate::BackFooter() ?>
					</div>
					<!-- / body -->
				</div>

				<?php
				ViewTemplate::BackFoot();

				if ($_SESSION['employee']['messaging']['replied'] === 1)
				{
					ViewTemplate::BackToast('Réponse au message', 'Réponse envoyée avec succès !');
					unset($_SESSION['employee']['messaging']['replied']);
				}
				?>
			</body>
		</html>
		<?php
	}
}

?>
