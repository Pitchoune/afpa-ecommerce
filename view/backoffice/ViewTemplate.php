<?php

require_once(DIR . '/model/ModelMessage.php');
use \Ecommerce\Model\ModelMessage;

/**
 * Class to display default HTML code for all necessary pages in back.
 */
class ViewTemplate
{
	/**
	 * Returns the HTML code of the <head> part.
	 *
	 * @param string $title Title in the <head>.
	 *
	 * @return void
	 */
	public static function BackHead($pagetitle = 'Admin')
	{
		?>
		<meta charset="utf-8" />
		<title><?= $pagetitle ?></title>
		<link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">

		<!-- google fonts -->
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

		<!-- font awesome-->
		<link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css" />

		<!-- slick icons -->
		<link rel="stylesheet" type="text/css" href="../assets/css/slick.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/slick-theme.css" />

		<!-- tablegrid -->
		<link rel="stylesheet" type="text/css" href="../assets/css/tablegrid.css" />

		<!-- bootstrap css -->
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" />

		<!-- App css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/admin.css" />
		<?php
	}

	/**
	 * Returns the HTML code of the header.
	 *
	 * @return void
	 */
	public static function BackHeader()
	{
		global $config;

		?>
		<!-- header -->
		<header class="page-main-header">
			<div class="main-header-left">
				<div class="logo-wrapper"><a href="index.php"><img src="../assets/images/NRS.png" alt=""></a></div>
			</div>
			<div class="main-header-right">
				<div class="mobile-sidebar">
					<div class="media-body text-end switch-sm">
						<label class="switch">
							<input id="sidebar-toggle" type="checkbox" checked="checked"><span class="switch-state"></span>
						</label>
					</div>
				</div>
				<div class="nav-right col">
					<ul class="nav-menus">
						<li>
							<form class="form-inline search-form">
								<div class="form-group">
									<input class="form-control-plaintext" type="search" placeholder="Recherche..."><span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
								</div>
							</form>
						</li>
						<li>
							<a class="text-dark" href="javascript:void(0)" onclick="javascript:toggleFullScreen()">
								<i data-feather="maximize"></i>
							</a>
						</li>
						<?php
						// Put this part of code here to have the notifications total
						$messages = new ModelMessage($config);
						$messages->set_type('notif');
						$messagecount = $messages->countMessagesFromType();
						?>
						<li class="onhover-dropdown"><i data-feather="bell"></i><span class="badge badge-pill badge-primary pull-right notification-badge"><?= $messagecount['count'] ?></span><span class="dot"></span>
							<ul class="notification-dropdown custom-scrollbar onhover-show-div p-0">
								<?php
								$messagelist = $messages->getAllMessagesFromType();

								foreach ($messagelist AS $key => $value)
								{
									?>
									<li>
										<div class="media">
											<div class="notification-icons bg-success me-3"><i data-feather="thumbs-up"></i></div>
											<div class="media-body">
												<h6 class="font-success"><?= $value['message'] ?></h6>
											</div>
										</div>
									</li>
									<?php
								}
								?>
							</ul>
						</li>
						<li class="onhover-dropdown">
							<div class="media align-items-center">
								<img class="align-self-center pull-right img-50 rounded-circle" src="../assets/images/noavatar.png" alt="header-user" />
								<div class="dotted-animation">
									<span class="animate-circle"></span>
									<span class="main-circle"></span>
								</div>
							</div>
							<ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">
								<li>
									<a href="index.php?do=profile">
										Profil
										<span class="pull-right">
											<i data-feather="user"></i>
										</span>
									</a>
								</li>
								<li>
									<a href="index.php?do=listmessages">
										Messages
										<span class="pull-right">
											<i data-feather="mail"></i>
										</span>
									</a>
								</li>
								<li>
									<a href="index.php?do=logout">
										Se déconnecter
										<span class="pull-right">
											<i data-feather="log-out"></i>
										</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
				</div>
			</div>
		</header>
		<!-- / header -->
		<?php
	}

	/**
	 * Returns the HTML code of the left sidebar.
	 *
	 * @return void
	 */
	public static function Sidebar()
	{
		global $employee;
		?>
		<!-- sidebar -->
		<div class="page-sidebar">
			<div class="sidebar custom-scrollbar">
				<div class="sidebar-user text-center">
					<div>
						<img class="img-60 rounded-circle" src="../assets/images/noavatar.png" alt="Avatar de l'employé" />
					</div>
					<h6 class="mt-3 f-14"><?= $employee['prenom'] . ' ' . $employee['nom'] ?></h6>
					<p><?= $employee['rolename'] ?></p>
				</div>
				<ul class="sidebar-menu">
					<li>
						<a class="sidebar-header" href="index.php?do=index">
							<i data-feather="home"></i>
							<span>Tableau de bord</span>
						</a>
					</li>
					<?php
					if (Utils::cando(1) OR Utils::cando(2))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="user-check"></i>
							<span>Rôles</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(1))
							{
								?>
								<li><a href="index.php?do=listroles"><i class="fa fa-circle"></i>Liste des rôles</a></li>
								<?php
							}

							if (Utils::cando(2))
							{
								?>
								<li><a href="index.php?do=addrole"><i class="fa fa-circle"></i>Ajouter un rôle</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(5) OR Utils::cando(6))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="users"></i>
							<span>Employés</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(5))
							{
								?>
								<li><a href="index.php?do=listemployees"><i class="fa fa-circle"></i>Liste des employés</a></li>
								<?php
							}

							if (Utils::cando(6))
							{
								?>
								<li><a href="index.php?do=addemployee"><i class="fa fa-circle"></i>Ajouter un employé</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(9) OR Utils::cando(10))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="list"></i>
							<span>Catégories</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(9))
							{
								?>
								<li><a href="index.php?do=listcategories"><i class="fa fa-circle"></i>Liste des catégories</a></li>
								<?php
							}

							if (Utils::cando(10))
							{
								?>
								<li><a href="index.php?do=addcategory"><i class="fa fa-circle"></i>Ajouter une catégorie</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(13) OR Utils::cando(14))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascrpt:void(0)">
							<i data-feather="trello"></i>
							<span>Marques</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(13))
							{
								?>
								<li><a href="index.php?do=listtrademarks"><i class="fa fa-circle"></i>Liste des marques</a></li>
								<?php
							}

							if (Utils::cando(14))
							{
								?>
								<li><a href="index.php?do=addtrademark"><i class="fa fa-circle"></i>Ajouter une marque</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(18) OR Utils::cando(19))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascrpt:void(0)">
							<i data-feather="truck"></i>
							<span>Transporteurs</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(18))
							{
								?>
								<li><a href="index.php?do=listdelivers"><i class="fa fa-circle"></i>Liste des transporteurs</a></li>
								<?php
							}

							if (Utils::cando(19))
							{
								?>
								<li><a href="index.php?do=adddeliver"><i class="fa fa-circle"></i>Ajouter un transporteur</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(23) OR Utils::cando(24))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="box"></i>
							<span>Produits</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(23))
							{
								?>
								<li><a href="index.php?do=listproducts"><i class="fa fa-circle"></i>Liste des produits</a></li>
								<?php
							}

							if (Utils::cando(24))
							{
								?>
								<li><a href="index.php?do=addproduct"><i class="fa fa-circle"></i>Ajouter un produit</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(28) OR Utils::cando(29))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="user-plus"></i>
							<span>Clients</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(28))
							{
								?>
								<li><a href="index.php?do=listcustomers"><i class="fa fa-circle"></i>Liste des clients</a></li>
								<?php
							}

							if (Utils::cando(29))
							{
								?>
								<li><a href="index.php?do=addcustomer"><i class="fa fa-circle"></i>Ajouter un client</a></li>
								<?php
							}
							?>
							<li><a href="index.php?do=listorders"><i class="fa fa-circle"></i>Liste des commandes</a></li>
						</ul>
					</li>
					<?php
					}

					if (Utils::cando(36))
					{
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="message-circle"></i>
							<span>Messages</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<?php
							if (Utils::cando(36))
							{
							?>
							<li><a href="index.php?do=listmessages"><i class="fa fa-circle"></i>Liste des messages</a></li>
							<?php
							}
							?>
						</ul>
					</li>
					<?php
					}
					?>
					<li>
						<a class="sidebar-header" href="javascript:void(0)">
							<i data-feather="settings"></i>
							<span>Paramètres</span>
							<i class="fa fa-angle-right pull-right"></i>
						</a>
						<ul class="sidebar-submenu">
							<li><a href="index.php?do=profile"><i class="fa fa-circle"></i>Mon profil</a></li>
						</ul>
					</li>
					<li>
						<a class="sidebar-header" href="index.php?do=logout">
							<i data-feather="log-out"></i>
							<span>Se déconnecter</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- / sidebar -->
		<?php
	}

	/**
	 * Returns the HTML code of the breadcrumb.
	 *
	 * @param string $title Title in the breadcrumb.
	 * @param array $navbits Array of items to create the breadcrumb navigation in format url => item.
	 *
	 * @return void
	 */
	public static function Breadcrumb($title, $navbits)
	{
		?>
		<!-- breadcrumb -->
		<div class="container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-12">
						<div class="page-header-left">
							<h3><?= $title ?></h3>
						</div>
					</div>
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="index.php">
									<i data-feather="home"></i>
								</a>
							</li>
							<?php

							$lastelement = (isset($navbits) AND sizeof($navbits));
							$counter = 0;

							if (is_array($navbits))
							{
								foreach($navbits AS $nav_url => $nav_title)
								{
									$elementtype = (++$counter == $lastelement) ? 'breadcrumb-item active' : 'breadcrumb-item';

									if (empty($nav_title))
									{
										continue;
									}

									?>
									<li class="<?= $elementtype; ?>"><?= !empty($nav_url) ? '<a href="index.php?do=' . $nav_url . '">' : '' ?><?= $nav_title ?><?= !empty($nav_url) ? '</a>' : '' ?></li>
									<?php
								}
							}

							?>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- / breadcrumb -->
		<?php
	}

	/**
	 * Returns the HTML code of the footer.
	 *
	 * @return void
	 */
	public static function BackFooter()
	{
		?>
		<!-- footer -->
		<footer class="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 footer-copyright">
						<p class="mb-0">Copyright 2022 par moi-même.</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- / footer -->
		<?php
	}

	/**
	 * Returns the HTML code to display the basic necessary Javascript files to include to each page.
	 *
	 * @return void
	 */
	public static function BackFoot()
	{
		?>
		<!-- jquery -->
		<script src="../assets/js/jquery-3.6.0.min.js"></script>

		<!-- bootstrap js -->
		<script src="../assets/js/bootstrap.bundle.min.js"></script>

		<!-- feather icon js -->
		<script src="../assets/js/feather.min.js"></script>
		<script src="../assets/js/feather-icon.js"></script>

		<!-- slick -->
		<script src="../assets/js/slick.js"></script>

		<!-- script admin -->
		<script src="../assets/js/admin-script.js"></script>
		<?php
	}

	/**
	 * Returns the HTML code to display the backoffice Bootstrap toast.
	 *
	 * @param string $title Title to insert into the toast.
	 * @param string $message Message to insert into the toast.
	 *
	 * @return void
	 */
	public static function BackToast($title, $message)
	{
		?>
		<div style="position: absolute; bottom: 20px; right: 20px; z-index: 9999;">
			<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto"><?= $title ?></strong>
					<small>À l'instant</small>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Fermer"></button>
				</div>
				<div class="toast-body">
					<?= $message ?>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function()
			{
				$('.toast').toast('show');
			});
		</script>
		<?php
	}

	/**
	 * Returns the HTML code to display the backoffice input validation code.
	 *
	 * @param string $id ID of the submit button of the form.
	 * @param integer $number Number of form items to remove from the end (submit and reset buttons, more items to remove?)
	 * @param integer $position The position of the form across all forms visible.
	 *
	 * @return void
	 */
	public static function BackFormValidation($id = 'valider', $number = 2, $position = 1)
	{
		?>
			<script>
				$(document).on("click", "#<?= $id ?>", function(e)
				{
					e.preventDefault();
					let regexListe =
					{
						firstname: /^[\p{L}\s-]{2,}$/u,
						lastname: /^[\p{L}\s-]{2,}$/u,
						title: /^[\p{L}\s-]{2,}$/u,
						name: /^[\p{L}\s-]{2,}$/u,
						mail: /^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si,
						telephone: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
						address: /^[\d\w\-\s]{5,100}$/,
						city: /^([a-zA-Z]+(?:[\s-][a-zA-Z]+)*){1,}$/u,
						zipcode: /^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/,
						pass: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/,
						ref: /^[\p{L}\s-]{2,}$/u,
						description: /^[\p{L}\s-]{2,}$/u,
						quantity: /^[0-9]{2,}$/,
						price: /^[0-9]{1,5}\.[0-9]{2}$/,
						displayorder: /^[0-9]+$/
					};

					$("small").text("");
					error = false;

					let formElements = $("form")[<?= $position ?>]; // grab form elements

					// formElements.length - x to not use 'submit', 'reset' and any other 'hidden' types at the end of the form
					for (let i = 0; i < formElements.length - <?= $number ?>; i++)
					{
						if ($(formElements[i]).attr("type") === "radio")
						{
							// radio cleaning
							$("#" + $(formElements[i]).attr("aria-describedby")).html("");

							if ($("input[name='" + $(formElements[i]).attr("name") + "']:checked").length === 0)
							{
								error = true;
								$("#" + $(formElements[i]).attr("aria-describedby")).html(`<p class="invalid-text">${$(formElements[i]).attr("data-message")}</p>`);
							}
						}
						else if ($(formElements[i]).attr("type") === "password")
						{
							// password cleaning
							$("#password").removeClass("is-invalid");
							$("#newpassword").removeClass("is-invalid");
							$("#confirmpassword").removeClass("is-invalid");

							const pattern = regexListe["pass"];

							if (pattern.test(formElements[i].value) === false)
							{
								error = true;
								$("#password").addClass("is-invalid");
								$("#newpassword").addClass("is-invalid");
								$("#confirmpassword").addClass("is-invalid");
								$("#" + $(formElements[i]).attr("aria-describedby")).html(`<p class="invalid-text">${$(formElements[i]).attr("data-message")}</p>`);
							}

							if ($("#newpassword").val() !== $("#confirmpassword").val())
							{
								error = true;
								$("#password").removeClass("is-invalid");
								$("#newpassword").addClass("is-invalid");
								$("#confirmpassword").addClass("is-invalid");
								$("#newpasswordHelp").html(`<p class="invalid-text">Les deux mot de passes doivent etre identiques</p>`);
							}
						}
						else if ($(formElements[i]).prop("tagName").toLowerCase() === "select")
						{
							// select cleaning
							$(formElements[i]).removeClass("is-invalid");
							$(formElements[i]).next().html("");

							if (formElements[i].value === "")
							{
								error = true;
								$(formElements[i]).addClass("is-invalid");
								$(formElements[i]).next().html(`<p class="invalid-text">${$(formElements[i]).attr("data-message")}</p>`);
							}

							/*if (parseInt(formElements[i].value) === 0)
							{
								error = true;
								$(formElements[i]).addClass("is-invalid");
								$(formElements[i]).next().html(`<p class="invalid-text">${$(formElements[i]).attr("data-message")}</p>`);
							}*/
						}
						else if ($(formElements[i]).attr("type") === "file")
						{
							// Don't check files upload
						}
						else
						{
							// any other input cleaning
							$(formElements[i]).removeClass("is-invalid");
							$(formElements[i]).next().html("");

							const type = $(formElements[i]).attr("id");
							const pattern = regexListe[type];

							if (pattern.test(formElements[i].value) === false)
							{
								error = true;
								$(formElements[i]).addClass("is-invalid");
								$(formElements[i]).next().html(`<p class="invalid-text">${$(formElements[i]).attr("data-message")}</p>`);
							}
						}
					}

					if (!error)
					{
						$("form")[<?= $position ?>].submit();
					}
				});
			</script>
		<?php
	}

	/**
	 * Returns the HTML code to display the backoffice delete confirmation.
	 *
	 * @param array $data Array of informations to use in the delete confirmation form.
	 *
	 * @return void
	 */
	public static function PrintDeleteConfirmation($data = [])
	{
		?>
		<!-- content deletion confirmation -->
		<div class="container-fluid">
			<div class="row product-adding">
				<div class="col">
					<div class="card">
						<div class="card-header">
							<h5><?= $data['navtitle'] ?> « <?= $data['itemname'] ?> »</h5>
						</div>
						<div class="card-body">
							<form class="digital-add" method="post" action="index.php?do=<?= $data['redirect'] ?>">
								<div class="form-group">
									<div>Êtes-vous <strong>certain</strong> de vouloir supprimer <?= $data['typetext'] ?> « <?= $data['itemname'] ?> » ?<br />
										<small>(id : <?= $data['id'] ?>)</small>
										<br /><br />Cette action est irréversible.</div>
								</div>

								<div class="form-group mb-0">
									<div class="product-buttons text-center">
										<input type="hidden" name="do" value="<?= $data['redirect'] ?>" />
										<input type="hidden" name="id" value="<?= $data['id'] ?>" />
										<input type="submit" class="btn btn-primary" value="Supprimer" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- / content deletion confirmation -->
		<?php
	}
}

?>
