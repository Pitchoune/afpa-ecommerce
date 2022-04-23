<?php

/**
 * Class to display default HTML code for all necessary pages in back.
 *
 * @date $Date$
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
		<link rel="icon" href="../assets/images/favicon/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="../assets/images/favicon/favicon.png" type="image/x-icon">

		<!--Google font-->
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

		<!-- Font Awesome-->
		<link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.css">

		<!-- Flag icon-->
		<link rel="stylesheet" type="text/css" href="../assets/css/flag-icon.css">

		<!-- ico-font-->
		<link rel="stylesheet" type="text/css" href="../assets/css/icofont.css">

		<!-- Prism css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/prism.css">

		<!-- Chartist css -->
		<link rel="stylesheet" type="text/css" href="../assets/css/chartist.css">

		<!-- vector map css -->
		<link rel="stylesheet" type="text/css" href="../assets/css/vector-map.css">

		<!-- slick icon-->
		<link rel="stylesheet" type="text/css" href="../assets/css/slick.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/slick-theme.css">

		<!-- tablegrid css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/tablegrid.css">

		<!-- Dropzone css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/dropzone.css">

		<!-- Bootstrap css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">

		<!-- App css-->
		<link rel="stylesheet" type="text/css" href="../assets/css/admin.css">
		<?php
	}

	/**
	 * Returns the HTML code of the header.
	 *
	 * @return void
	 */
	public static function BackHeader()
	{
		?>
		<div class="page-main-header">
			<div class="main-header-left">
				<div class="logo-wrapper"><a href="index.php"><img class="blur-up lazyloaded" src="../assets/images/layout-2/logo/logo.png" alt=""></a></div>
			</div>
			<div class="main-header-right ">
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
									<input class="form-control-plaintext" type="search" placeholder="Recherche.."><span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
								</div>
							</form>
						</li>
						<li class="onhover-dropdown"><a class="txt-dark" href="javascript:void(0)">
							<h6>FR</h6></a>
							<ul class="language-dropdown onhover-show-div p-20">
								<li><a href="javascript:void(0)" data-lng="pt"><i class="flag-icon flag-icon-pt"></i> Portugais</a></li>
								<li><a href="javascript:void(0)" data-lng="es"><i class="flag-icon flag-icon-es"></i> Espagnol</a></li>
								<li><a href="javascript:void(0)" data-lng="en"><i class="flag-icon flag-icon-us"></i> Anglais</a></li>
								<li><a href="javascript:void(0)" data-lng="fr"><i class="flag-icon flag-icon-fr"></i> Français</a></li>
							</ul>
						</li>
						<li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
						<li class="onhover-dropdown"><i data-feather="bell"></i><span class="badge badge-pill badge-primary pull-right notification-badge">3</span><span class="dot"></span>
							<ul class="notification-dropdown custom-scrollbar onhover-show-div p-0">
								<li>
									<div class="media">
										<div class="notification-icons bg-success me-3"><i data-feather="thumbs-up"></i></div>
										<div class="media-body">
											<h6 class="font-success">Someone Likes Your Posts</h6>
											<p class="mb-0"> 2 Hours Ago</p>
										</div>
									</div>
								</li>
								<li>
									<div class="media">
										<div class="notification-icons bg-info me-3"><i data-feather="message-circle"></i></div>
										<div class="media-body">
											<h6 class="font-info">3 New Comments</h6>
											<p class="mb-0"> 1 Hours Ago</p>
										</div>
									</div>
								</li>
								<li>
									<div class="media">
										<div class="notification-icons bg-secondary me-3"><i data-feather="download"></i></div>
										<div class="media-body">
											<h6 class="font-secondary">Download Complete</h6>
											<p class="mb-0"> 3 Days Ago</p>
										</div>
									</div>
								</li>
								<li>
									<div class="media">
										<div class="notification-icons bg-success bg-warning me-3">
											<i data-feather="gift"></i>
										</div>
										<div class="media-body">
											<h6 class="font-secondary">New Order Recieved</h6>
											<p class="mb-0"> 4 Days Ago</p>
										</div>
									</div>
								</li>
								<li>
									<div class="media">
										<div class="notification-icons bg-success me-3">
											<i data-feather="airplay"></i>
										</div>
										<div class="media-body">
											<h6 class="font-secondary">Apps are ready for update</h6>
											<p class="mb-0"> 3 Minutes Ago</p>
										</div>
									</div>
								</li>
								<li>
									<div class="media">
										<div class="notification-icons bg-info me-3">
											<i data-feather="alert-circle"></i>
										</div>
										<div class="media-body">
											<h6 class="font-secondary">Server Warning</h6>
											<p class="mb-0"> Just Now</p>
										</div>
									</div>
								</li>

								<li class="bg-light txt-dark"><a href="javascript:void(0)" data-original-title="" title="">Toutes </a> les notifications</li>
							</ul>
						</li>
						<li class="onhover-dropdown">
							<div class="media align-items-center"><img class="align-self-center pull-right img-50 rounded-circle blur-up lazyloaded" src="../assets/images/dashboard/man.png" alt="header-user">
								<div class="dotted-animation"><span class="animate-circle"></span><span class="main-circle"></span></div>
							</div>
							<ul class="profile-dropdown onhover-show-div p-20 profile-dropdown-hover">
								<li><a href="javascript:void(0)">Profil<span class="pull-right"><i data-feather="user"></i></span></a></li>
								<li><a href="javascript:void(0)">Messages<span class="pull-right"><i data-feather="mail"></i></span></a></li>
								<li><a href="javascript:void(0)">Tâches<span class="pull-right"><i data-feather="file-text"></i></span></a></li>
								<li><a href="javascript:void(0)">Paramètres<span class="pull-right"><i data-feather="settings"></i></span></a></li>
								<li><a href="index.php?do=logout">Se déconnecter<span class="pull-right"><i data-feather="log-out"></i></span></a></li>
							</ul>
						</li>
					</ul>
					<div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
				</div>
			</div>
		</div>
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
		<div class="page-sidebar">
			<div class="sidebar custom-scrollbar">
				<div class="sidebar-user text-center">
					<div><img class="img-60 rounded-circle lazyloaded blur-up" src="../assets/images/dashboard/man.png" alt="#">
					</div>
					<h6 class="mt-3 f-14"><?= $employee['prenom'] . ' ' . $employee['nom'] ?></h6>
					<p><?= $employee['rolename'] ?></p>
				</div>
				<ul class="sidebar-menu">
					<li><a class="sidebar-header" href="index.php?do=index"><i data-feather="home"></i><span>Tableau de bord</span></a></li>
					<?php
					if (Utils::cando(1) OR Utils::cando(2))
					{
					?>
					<li><a class="sidebar-header" href="javascript:void(0)"><i data-feather="user-check"></i><span>Rôles</span><i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascript:void(0)"><i data-feather="users"></i><span>Employés</span><i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascript:void(0)"><i data-feather="list"></i><span>Catégories</span><i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascrpt:void(0)"><i data-feather="trello"></i><span>Marques</span><i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascrpt:void(0)"><i data-feather="truck"></i><span>Transporteur</span><i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascript:void(0)"><i data-feather="box"></i>Produits<i class="fa fa-angle-right pull-right"></i></a>
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
					<li><a class="sidebar-header" href="javascript:void(0)"><i data-feather="user-plus"></i><span>Clients</span><i class="fa fa-angle-right pull-right"></i></a>
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
						</ul>
					</li>
					<?php
					}
					?>
					<li><a class="sidebar-header" href=""><i data-feather="settings" ></i><span>Settings</span><i class="fa fa-angle-right pull-right"></i></a>
						<ul class="sidebar-submenu">
							<li><a href="index.php?do=profile"><i class="fa fa-circle"></i>Profile</a></li>
						</ul>
					</li>
					<li><a class="sidebar-header" href="index.php?do=logout"><i data-feather="log-out"></i><span>Logout</span></a>
					</li>
				</ul>
			</div>
		</div>
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
		<!-- breadcrumb start -->
		<div class="container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-6">
						<div class="page-header-left">
							<h3><?= $title ?><small>Bigdeal Admin panel</small></h3>
						</div>
					</div>
					<div class="col-lg-6">
						<ol class="breadcrumb pull-right">
							<li class="breadcrumb-item"><a href="index.php"><i data-feather="home"></i></a></li>
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
									<li class="<?= $elementtype; ?>"><?php isset($nav_url) ? '<a href="index.php?do=' . $nav_url . '">' : '' ?><?= $nav_title ?><?php isset($nav_url) ? '</a>' : '' ?></li>
									<?php
								}
							}

							?>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- breadcrumb End -->
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
		<!-- footer start-->
		<footer class="footer">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6 footer-copyright">
						<p class="mb-0">Copyright 2019 © Bigdeal All rights reserved.</p>
					</div>
					<div class="col-md-6">
						<p class="pull-right mb-0">Hand crafted & made with<i class="fa fa-heart"></i></p>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer end-->
		<?php
	}

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
}

?>
