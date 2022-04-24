<?php

/**
 * Class to display default HTML code for all necessary pages in front.
 *
 * @date $Date$
 */
class ViewTemplate
{
	/**
	 * Returns the HTML code to display the frontoffice <head>
	 *
	 * @return void
	 */
	public static function FrontHead($pagetitle = 'Titre')
	{
		?>
		<meta charset="utf-8" />
		<title><?= $pagetitle ?></title>
		<link rel="icon" href="assets/images/favicon/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="assets/images/favicon/favicon.png" type="image/x-icon">

		<!--Google font-->
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

		<!--icon css-->
		<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
		<link rel="stylesheet" type="text/css" href="assets/css/themify.css">

		<!--Slick slider css-->
		<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
		<link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">

		<!--Animate css-->
		<link rel="stylesheet" type="text/css" href="assets/css/animate.css">

		<!-- Bootstrap css -->
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">

		<!-- Theme css -->
		<link rel="stylesheet" type="text/css" href="assets/css/color2.css" media="screen" id="color">
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice header.
	 *
	 * @return void
	 */
	public static function FrontHeader()
	{
		global $config;

		require_once(DIR . '/model/ModelCategory.php');
		$categories = new \Ecommerce\Model\ModelCategory($config);
		$listcategories = $categories->listAllCategories();

		// Create 2 lists of categories without the same values to fill a 'more categories' part with a link to display them.
		$category1 = $category2 = '';

		for ($i = 0; $i < (count($listcategories) <= 9 ? count($listcategories) : 9); $i++)
		{
			$category1 .= '<li> <a href="index.php?do=viewcategory&amp;id=' . $listcategories[$i]['id'] . '"><img src="assets/images/layout-1/nav-img/0' . ($i + 1) . '.png" alt="category-product"> ' . $listcategories[$i]['nom'] .'</a></li>';
		}

		if (isset($listcategories) AND count($listcategories) > 10)
		{
			for ($i = 10; $i < 10000; $i++)
			{
				$category2 .= '<li> <a href="index.php?do=viewcategory&amp;id=' . $listcategories[$i]['id'] . '"><img src="assets/images/layout-1/nav-img/' . ($i + 1) . '.png" alt="category-product"> ' . $listcategories[$i]['nom'] .'</a></li>';
			}
		}

		?>
		<!--header start-->
		<header id="stickyheader">
			<div class="mobile-fix-option"></div>
			<div class="top-header">
				<div class="custom-container">
					<div class="row">
						<div class="col-xl-5 col-md-7 col-sm-6">
							<div class="top-header-left">
								<div class="shpping-order"><h6>Frais de ports offerts dès 99€</h6></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="layout-header2">
				<div class="container">
					<div class="col-md-12">
						<div class="main-menu-block">
							<div class="header-left">
								<div class="brand-logo logo-sm-center">
									<a href="index.php"><img src="assets/images/layout-2/logo/logo.png" class="img-fluid" alt="logo"></a>
								</div>
							</div>
							<div class="input-block">
								<div class="input-box">
									<form class="big-deal-form" action="index.php?do=search" method="post">
										<input type="hidden" name="do" value="search" />
										<div class="input-group">
											<div class="input-group-text">
												<span class="search"><i class="fa fa-search"></i></span>
											</div>
											<input type="search" class="form-control" placeholder="Rechercher un produit" name="query">
											<div class="input-group-text">
												<select name="category">
													<option value="0">Toutes les catégories</option>
													<?php
													foreach ($listcategories AS $key => $value)
													{
														?>
														<option value="<?= $value['id'] ?>"><?= $value['nom'] ?></option>
														<?php
													}
													?>
												</select>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="header-right">
								<div class="icon-block">
									<ul>
										<li class="mobile-search">
											<a href="javascript:void(0)">
											<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
												 viewBox="0 0 612.01 612.01" style="enable-background:new 0 0 612.01 612.01;"
												 xml:space="preserve">
											<g>
												<g>
													<g>
													<path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0
													  C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586
													  l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8
													  c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407
													  S377.82,467.8,257.493,467.8z"/>
													</g>
												</g>
											</g>
											</svg>
											</a>
										</li>
										<li class="mobile-user "onclick="openAccount()">
											<a href="javascript:void(0)">
												<svg version="1.1"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
													<g>
														<g>
															<path d="M256,0c-74.439,0-135,60.561-135,135s60.561,135,135,135s135-60.561,135-135S330.439,0,256,0z M256,240
															c-57.897,0-105-47.103-105-105c0-57.897,47.103-105,105-105c57.897,0,105,47.103,105,105C361,192.897,313.897,240,256,240z" />
														</g>
													</g>
													<g>
														<g>
															<path d="M297.833,301h-83.667C144.964,301,76.669,332.951,31,401.458V512h450V401.458C435.397,333.05,367.121,301,297.833,301z
															M451.001,482H451H61v-71.363C96.031,360.683,152.952,331,214.167,331h83.667c61.215,0,118.135,29.683,153.167,79.637V482z" />
														</g>
													</g>
												</svg>
											</a>
										</li>
										<li class="mobile-setting" onclick="openSetting()">
											<a href="javascript:void(0)">
												<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m272.066 512h-32.133c-25.989 0-47.134-21.144-47.134-47.133v-10.871c-11.049-3.53-21.784-7.986-32.097-13.323l-7.704 7.704c-18.659 18.682-48.548 18.134-66.665-.007l-22.711-22.71c-18.149-18.129-18.671-48.008.006-66.665l7.698-7.698c-5.337-10.313-9.792-21.046-13.323-32.097h-10.87c-25.988 0-47.133-21.144-47.133-47.133v-32.134c0-25.989 21.145-47.133 47.134-47.133h10.87c3.531-11.05 7.986-21.784 13.323-32.097l-7.704-7.703c-18.666-18.646-18.151-48.528.006-66.665l22.713-22.712c18.159-18.184 48.041-18.638 66.664.006l7.697 7.697c10.313-5.336 21.048-9.792 32.097-13.323v-10.87c0-25.989 21.144-47.133 47.134-47.133h32.133c25.989 0 47.133 21.144 47.133 47.133v10.871c11.049 3.53 21.784 7.986 32.097 13.323l7.704-7.704c18.659-18.682 48.548-18.134 66.665.007l22.711 22.71c18.149 18.129 18.671 48.008-.006 66.665l-7.698 7.698c5.337 10.313 9.792 21.046 13.323 32.097h10.87c25.989 0 47.134 21.144 47.134 47.133v32.134c0 25.989-21.145 47.133-47.134 47.133h-10.87c-3.531 11.05-7.986 21.784-13.323 32.097l7.704 7.704c18.666 18.646 18.151 48.528-.006 66.665l-22.713 22.712c-18.159 18.184-48.041 18.638-66.664-.006l-7.697-7.697c-10.313 5.336-21.048 9.792-32.097 13.323v10.871c0 25.987-21.144 47.131-47.134 47.131zm-106.349-102.83c14.327 8.473 29.747 14.874 45.831 19.025 6.624 1.709 11.252 7.683 11.252 14.524v22.148c0 9.447 7.687 17.133 17.134 17.133h32.133c9.447 0 17.134-7.686 17.134-17.133v-22.148c0-6.841 4.628-12.815 11.252-14.524 16.084-4.151 31.504-10.552 45.831-19.025 5.895-3.486 13.4-2.538 18.243 2.305l15.688 15.689c6.764 6.772 17.626 6.615 24.224.007l22.727-22.726c6.582-6.574 6.802-17.438.006-24.225l-15.695-15.695c-4.842-4.842-5.79-12.348-2.305-18.242 8.473-14.326 14.873-29.746 19.024-45.831 1.71-6.624 7.684-11.251 14.524-11.251h22.147c9.447 0 17.134-7.686 17.134-17.133v-32.134c0-9.447-7.687-17.133-17.134-17.133h-22.147c-6.841 0-12.814-4.628-14.524-11.251-4.151-16.085-10.552-31.505-19.024-45.831-3.485-5.894-2.537-13.4 2.305-18.242l15.689-15.689c6.782-6.774 6.605-17.634.006-24.225l-22.725-22.725c-6.587-6.596-17.451-6.789-24.225-.006l-15.694 15.695c-4.842 4.843-12.35 5.791-18.243 2.305-14.327-8.473-29.747-14.874-45.831-19.025-6.624-1.709-11.252-7.683-11.252-14.524v-22.15c0-9.447-7.687-17.133-17.134-17.133h-32.133c-9.447 0-17.134 7.686-17.134 17.133v22.148c0 6.841-4.628 12.815-11.252 14.524-16.084 4.151-31.504 10.552-45.831 19.025-5.896 3.485-13.401 2.537-18.243-2.305l-15.688-15.689c-6.764-6.772-17.627-6.615-24.224-.007l-22.727 22.726c-6.582 6.574-6.802 17.437-.006 24.225l15.695 15.695c4.842 4.842 5.79 12.348 2.305 18.242-8.473 14.326-14.873 29.746-19.024 45.831-1.71 6.624-7.684 11.251-14.524 11.251h-22.148c-9.447.001-17.134 7.687-17.134 17.134v32.134c0 9.447 7.687 17.133 17.134 17.133h22.147c6.841 0 12.814 4.628 14.524 11.251 4.151 16.085 10.552 31.505 19.024 45.831 3.485 5.894 2.537 13.4-2.305 18.242l-15.689 15.689c-6.782 6.774-6.605 17.634-.006 24.225l22.725 22.725c6.587 6.596 17.451 6.789 24.225.006l15.694-15.695c3.568-3.567 10.991-6.594 18.244-2.304z"/><path d="m256 367.4c-61.427 0-111.4-49.974-111.4-111.4s49.973-111.4 111.4-111.4 111.4 49.974 111.4 111.4-49.973 111.4-111.4 111.4zm0-192.8c-44.885 0-81.4 36.516-81.4 81.4s36.516 81.4 81.4 81.4 81.4-36.516 81.4-81.4-36.515-81.4-81.4-81.4z"/></svg>
											</a>
										</li>
										<li class="mobile-cart item-count" onclick="openCart()">
											<a href="javascript:void(0)">
												<div class="cart-block">
													<div class="cart-icon">
														<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="m497 401.667c-415.684 0-397.149.077-397.175-.139-4.556-36.483-4.373-34.149-4.076-34.193 199.47-1.037-277.492.065 368.071.065 26.896 0 47.18-20.377 47.18-47.4v-203.25c0-19.7-16.025-35.755-35.725-35.79l-124.179-.214v-31.746c0-17.645-14.355-32-32-32h-29.972c-17.64 0-31.99 14.351-31.99 31.99v31.594l-133.21-.232-9.985-54.992c-2.667-14.694-15.443-25.36-30.378-25.36h-68.561c-8.284 0-15 6.716-15 15s6.716 15 15 15c72.595 0 69.219-.399 69.422.719 16.275 89.632 5.917 26.988 49.58 306.416l-38.389.2c-18.027.069-32.06 15.893-29.81 33.899l4.252 34.016c1.883 15.06 14.748 26.417 29.925 26.417h26.62c-18.8 36.504 7.827 80.333 49.067 80.333 41.221 0 67.876-43.813 49.067-80.333h142.866c-18.801 36.504 7.827 80.333 49.067 80.333 41.22 0 67.875-43.811 49.066-80.333h31.267c8.284 0 15-6.716 15-15s-6.716-15-15-15zm-209.865-352.677c0-1.097.893-1.99 1.99-1.99h29.972c1.103 0 2 .897 2 2v111c0 8.284 6.716 15 15 15h22.276l-46.75 46.779c-4.149 4.151-10.866 4.151-15.015 0l-46.751-46.779h22.277c8.284 0 15-6.716 15-15v-111.01zm-30 61.594v34.416h-25.039c-20.126 0-30.252 24.394-16.014 38.644l59.308 59.342c15.874 15.883 41.576 15.885 57.452 0l59.307-59.342c14.229-14.237 4.13-38.644-16.013-38.644h-25.039v-34.254l124.127.214c3.186.005 5.776 2.603 5.776 5.79v203.25c0 10.407-6.904 17.4-17.18 17.4h-299.412l-35.477-227.039zm-56.302 346.249c0 13.877-11.29 25.167-25.167 25.167s-25.166-11.29-25.166-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167zm241 0c0 13.877-11.289 25.167-25.166 25.167s-25.167-11.29-25.167-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167z"/></g></svg>
													</div>
													<div class="cart-item">
														<h5>panier</h5>
													</div>
												</div>
											</a>
											<div class="item-count-contain total-count"></div>
										</li>
									</ul>
								</div>
								<div class="menu-nav">
									<span class="toggle-nav"><i class="fa fa-bars "></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="searchbar-input">
					<div class="input-group">
						<span class="input-group-text">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28.931px" height="28.932px" viewBox="0 0 28.931 28.932" style="enable-background:new 0 0 28.931 28.932;" xml:space="preserve"><g><path d="M28.344,25.518l-6.114-6.115c1.486-2.067,2.303-4.537,2.303-7.137c0-3.275-1.275-6.355-3.594-8.672C18.625,1.278,15.543,0,12.266,0C8.99,0,5.909,1.275,3.593,3.594C1.277,5.909,0.001,8.99,0.001,12.266c0,3.276,1.275,6.356,3.592,8.674c2.316,2.316,5.396,3.594,8.673,3.594c2.599,0,5.067-0.813,7.136-2.303l6.114,6.115c0.392,0.391,0.902,0.586,1.414,0.586c0.513,0,1.024-0.195,1.414-0.586C29.125,27.564,29.125,26.299,28.344,25.518z M6.422,18.111c-1.562-1.562-2.421-3.639-2.421-5.846S4.86,7.983,6.422,6.421c1.561-1.562,3.636-2.422,5.844-2.422s4.284,0.86,5.845,2.422c1.562,1.562,2.422,3.638,2.422,5.845s-0.859,4.283-2.422,5.846c-1.562,1.562-3.636,2.42-5.845,2.42S7.981,19.672,6.422,18.111z"/></g></svg>
						</span>
						<input type="text" class="form-control" placeholder="search your product">
						<span class="input-group-text close-searchbar">
							<svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
						</span>
					</div>
				</div>
			</div>
			<div class="category-header-2">
				<div class="custom-container">
					<div class="row">
						<div class="col-12">
							<div class="navbar-menu">
								<div class="logo-block">
									<div class="brand-logo logo-sm-center">
										<a href="index.html"><img src="assets/images/layout-2/logo/logo.png" class="img-fluid" alt="logo"></a>
									</div>
								</div>
								<div class="nav-block">
									<div class="nav-left">
										<nav class="navbar" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent">
											<button class="navbar-toggler" type="button">
												<span class="navbar-icon"><i class="fa fa-arrow-down"></i></span>
											</button>
											<h5 class="mb-0 text-white title-font">Liste des catégories</h5>
										</nav>
										<div class="collapse nav-desk" id="navbarToggleExternalContent">
											<ul class="nav-cat title-font">
												<?= $category1 ?>
												<li>
													<ul class="mor-slide-open">
														<?=  $category2 ?>
													</ul>
												</li>
												<?php
												if ($category2)
												{
													?>
													<li>
													<a class="mor-slide-click">moar category <i class="fa fa-angle-down pro-down"></i><i class="fa fa-angle-up pro-up"></i></a>
													</li>
													<?php
												}
												?>
											</ul>
										</div>
									</div>
								</div>
								<div class="menu-block">
									<nav id="main-nav">
										<div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
										<ul id="main-menu" class="sm pixelstrap sm-horizontal">
											<li>
												<div class="mobile-back text-right">Back<i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
											</li>
										</ul>
									</nav>
								</div>
								<div class="icon-block">
									<ul>
										<li class="mobile-search">
											<a href="javascript:void(0)">
												<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 612.01 612.01" style="enable-background:new 0 0 612.01 612.01;" xml:space="preserve">
													<g>
														<g>
															<g>
																<path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0
																	C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586
																	l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8
																	c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407
																	S377.82,467.8,257.493,467.8z"/>
															</g>
														</g>
													</g>
												</svg>
											</a>
										</li>
										<li class="mobile-user onhover-dropdown" onclick="openAccount()">
											<a href="javascript:void(0)">
												<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
													<g>
														<g>
															<path d="M256,0c-74.439,0-135,60.561-135,135s60.561,135,135,135s135-60.561,135-135S330.439,0,256,0z M256,240 c-57.897,0-105-47.103-105-105c0-57.897,47.103-105,105-105c57.897,0,105,47.103,105,105C361,192.897,313.897,240,256,240z"/>
														</g>
													</g>
													<g>
														<g>
															<path d="M297.833,301h-83.667C144.964,301,76.669,332.951,31,401.458V512h450V401.458C435.397,333.05,367.121,301,297.833,301z M451.001,482H451H61v-71.363C96.031,360.683,152.952,331,214.167,331h83.667c61.215,0,118.135,29.683,153.167,79.637V482z"/>
														</g>
													</g>
												</svg>
											</a>
										</li>
										<li class="mobile-setting" onclick="openSetting()">
											<a href="javascript:void(0)">
												<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m272.066 512h-32.133c-25.989 0-47.134-21.144-47.134-47.133v-10.871c-11.049-3.53-21.784-7.986-32.097-13.323l-7.704 7.704c-18.659 18.682-48.548 18.134-66.665-.007l-22.711-22.71c-18.149-18.129-18.671-48.008.006-66.665l7.698-7.698c-5.337-10.313-9.792-21.046-13.323-32.097h-10.87c-25.988 0-47.133-21.144-47.133-47.133v-32.134c0-25.989 21.145-47.133 47.134-47.133h10.87c3.531-11.05 7.986-21.784 13.323-32.097l-7.704-7.703c-18.666-18.646-18.151-48.528.006-66.665l22.713-22.712c18.159-18.184 48.041-18.638 66.664.006l7.697 7.697c10.313-5.336 21.048-9.792 32.097-13.323v-10.87c0-25.989 21.144-47.133 47.134-47.133h32.133c25.989 0 47.133 21.144 47.133 47.133v10.871c11.049 3.53 21.784 7.986 32.097 13.323l7.704-7.704c18.659-18.682 48.548-18.134 66.665.007l22.711 22.71c18.149 18.129 18.671 48.008-.006 66.665l-7.698 7.698c5.337 10.313 9.792 21.046 13.323 32.097h10.87c25.989 0 47.134 21.144 47.134 47.133v32.134c0 25.989-21.145 47.133-47.134 47.133h-10.87c-3.531 11.05-7.986 21.784-13.323 32.097l7.704 7.704c18.666 18.646 18.151 48.528-.006 66.665l-22.713 22.712c-18.159 18.184-48.041 18.638-66.664-.006l-7.697-7.697c-10.313 5.336-21.048 9.792-32.097 13.323v10.871c0 25.987-21.144 47.131-47.134 47.131zm-106.349-102.83c14.327 8.473 29.747 14.874 45.831 19.025 6.624 1.709 11.252 7.683 11.252 14.524v22.148c0 9.447 7.687 17.133 17.134 17.133h32.133c9.447 0 17.134-7.686 17.134-17.133v-22.148c0-6.841 4.628-12.815 11.252-14.524 16.084-4.151 31.504-10.552 45.831-19.025 5.895-3.486 13.4-2.538 18.243 2.305l15.688 15.689c6.764 6.772 17.626 6.615 24.224.007l22.727-22.726c6.582-6.574 6.802-17.438.006-24.225l-15.695-15.695c-4.842-4.842-5.79-12.348-2.305-18.242 8.473-14.326 14.873-29.746 19.024-45.831 1.71-6.624 7.684-11.251 14.524-11.251h22.147c9.447 0 17.134-7.686 17.134-17.133v-32.134c0-9.447-7.687-17.133-17.134-17.133h-22.147c-6.841 0-12.814-4.628-14.524-11.251-4.151-16.085-10.552-31.505-19.024-45.831-3.485-5.894-2.537-13.4 2.305-18.242l15.689-15.689c6.782-6.774 6.605-17.634.006-24.225l-22.725-22.725c-6.587-6.596-17.451-6.789-24.225-.006l-15.694 15.695c-4.842 4.843-12.35 5.791-18.243 2.305-14.327-8.473-29.747-14.874-45.831-19.025-6.624-1.709-11.252-7.683-11.252-14.524v-22.15c0-9.447-7.687-17.133-17.134-17.133h-32.133c-9.447 0-17.134 7.686-17.134 17.133v22.148c0 6.841-4.628 12.815-11.252 14.524-16.084 4.151-31.504 10.552-45.831 19.025-5.896 3.485-13.401 2.537-18.243-2.305l-15.688-15.689c-6.764-6.772-17.627-6.615-24.224-.007l-22.727 22.726c-6.582 6.574-6.802 17.437-.006 24.225l15.695 15.695c4.842 4.842 5.79 12.348 2.305 18.242-8.473 14.326-14.873 29.746-19.024 45.831-1.71 6.624-7.684 11.251-14.524 11.251h-22.148c-9.447.001-17.134 7.687-17.134 17.134v32.134c0 9.447 7.687 17.133 17.134 17.133h22.147c6.841 0 12.814 4.628 14.524 11.251 4.151 16.085 10.552 31.505 19.024 45.831 3.485 5.894 2.537 13.4-2.305 18.242l-15.689 15.689c-6.782 6.774-6.605 17.634-.006 24.225l22.725 22.725c6.587 6.596 17.451 6.789 24.225.006l15.694-15.695c3.568-3.567 10.991-6.594 18.244-2.304z"/><path d="m256 367.4c-61.427 0-111.4-49.974-111.4-111.4s49.973-111.4 111.4-111.4 111.4 49.974 111.4 111.4-49.973 111.4-111.4 111.4zm0-192.8c-44.885 0-81.4 36.516-81.4 81.4s36.516 81.4 81.4 81.4 81.4-36.516 81.4-81.4-36.515-81.4-81.4-81.4z"/></svg>
											</a>
										</li>
										<li class="mobile-cart item-count" onclick="openCart()">
											<a href="javascript:void(0)">
												<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="m497 401.667c-415.684 0-397.149.077-397.175-.139-4.556-36.483-4.373-34.149-4.076-34.193 199.47-1.037-277.492.065 368.071.065 26.896 0 47.18-20.377 47.18-47.4v-203.25c0-19.7-16.025-35.755-35.725-35.79l-124.179-.214v-31.746c0-17.645-14.355-32-32-32h-29.972c-17.64 0-31.99 14.351-31.99 31.99v31.594l-133.21-.232-9.985-54.992c-2.667-14.694-15.443-25.36-30.378-25.36h-68.561c-8.284 0-15 6.716-15 15s6.716 15 15 15c72.595 0 69.219-.399 69.422.719 16.275 89.632 5.917 26.988 49.58 306.416l-38.389.2c-18.027.069-32.06 15.893-29.81 33.899l4.252 34.016c1.883 15.06 14.748 26.417 29.925 26.417h26.62c-18.8 36.504 7.827 80.333 49.067 80.333 41.221 0 67.876-43.813 49.067-80.333h142.866c-18.801 36.504 7.827 80.333 49.067 80.333 41.22 0 67.875-43.811 49.066-80.333h31.267c8.284 0 15-6.716 15-15s-6.716-15-15-15zm-209.865-352.677c0-1.097.893-1.99 1.99-1.99h29.972c1.103 0 2 .897 2 2v111c0 8.284 6.716 15 15 15h22.276l-46.75 46.779c-4.149 4.151-10.866 4.151-15.015 0l-46.751-46.779h22.277c8.284 0 15-6.716 15-15v-111.01zm-30 61.594v34.416h-25.039c-20.126 0-30.252 24.394-16.014 38.644l59.308 59.342c15.874 15.883 41.576 15.885 57.452 0l59.307-59.342c14.229-14.237 4.13-38.644-16.013-38.644h-25.039v-34.254l124.127.214c3.186.005 5.776 2.603 5.776 5.79v203.25c0 10.407-6.904 17.4-17.18 17.4h-299.412l-35.477-227.039zm-56.302 346.249c0 13.877-11.29 25.167-25.167 25.167s-25.166-11.29-25.166-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167zm241 0c0 13.877-11.289 25.167-25.166 25.167s-25.167-11.29-25.167-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167z"/></g></svg>
											</a>
											<div class="item-count-contain total-count"></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="searchbar-input">
					<div class="input-group">
						<span class="input-group-text">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28.931px" height="28.932px" viewBox="0 0 28.931 28.932" style="enable-background:new 0 0 28.931 28.932;" xml:space="preserve"><g><path d="M28.344,25.518l-6.114-6.115c1.486-2.067,2.303-4.537,2.303-7.137c0-3.275-1.275-6.355-3.594-8.672C18.625,1.278,15.543,0,12.266,0C8.99,0,5.909,1.275,3.593,3.594C1.277,5.909,0.001,8.99,0.001,12.266c0,3.276,1.275,6.356,3.592,8.674c2.316,2.316,5.396,3.594,8.673,3.594c2.599,0,5.067-0.813,7.136-2.303l6.114,6.115c0.392,0.391,0.902,0.586,1.414,0.586c0.513,0,1.024-0.195,1.414-0.586C29.125,27.564,29.125,26.299,28.344,25.518z M6.422,18.111c-1.562-1.562-2.421-3.639-2.421-5.846S4.86,7.983,6.422,6.421c1.561-1.562,3.636-2.422,5.844-2.422s4.284,0.86,5.845,2.422c1.562,1.562,2.422,3.638,2.422,5.845s-0.859,4.283-2.422,5.846c-1.562,1.562-3.636,2.42-5.845,2.42S7.981,19.672,6.422,18.111z"/></g></svg>
						</span>
						<input type="text" class="form-control" placeholder="search your product">
						<span class="input-group-text close-searchbar">
							<svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
						</span>
					</div>
				</div>
			</div>
		</header>
		<!--header end-->
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice breadcrumb.
	 *
	 * @param string $itemname Name of the item.
	 * @param array $navbits Array of breadcrumb items to show.
	 *
	 * @return void
	 */
	public static function FrontBreadcrumb($itemname, $navbits = '')
	{
		?>
		<!-- breadcrumb start -->
		<div class="breadcrumb-main">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumb-contain">
							<div>
								<h2><?= $itemname; ?></h2>
								<ul>
									<li><a href="index.php">Accueil</a></li>
									<?php
									if (is_array($navbits))
									{
										foreach ($navbits AS $key => $value)
										{
											?>
											<li><i class="fa fa-angle-double-right"></i></li>
											<li><a href="index.php?do=<?= $key; ?>"><?= $value; ?></a></li>
											<?php
										}
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- breadcrumb End -->
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice footer.
	 *
	 * @return void
	 */
	public static function FrontFooter()
	{
		?>
		<!-- footer start -->
		<footer>
			<div class="footer1">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="footer-main">
								<div class="footer-box">
									<div class="footer-title mobile-title">
										<h5>about</h5>
									</div>
									<div class="footer-contant">
										<div class="footer-logo">
											<a href="index.html">
												<img src="assets/images/layout-2/logo/logo.png" class="img-fluid" alt="logo">
											</a>
										</div>
										<p>Contrairement à la croyance, le Lorem Ipsum n'est pas du simple texte aléatoire. Il a ses racines dans un morceau de littérature latine datant de -45.</p>
										<ul class="paymant">
											<li><a href="https://www.visa.com/"><img src="assets/images/layout-1/pay/1.png" class="img-fluid" alt="VISA" /></a></li>
											<li><a href="https://www.mastercard.com/"><img src="assets/images/layout-1/pay/2.png" class="img-fluid" alt="MasterCard" /></a></li>
											<li><a href="https://www.paypal.com/"><img src="assets/images/layout-1/pay/3.png" class="img-fluid" alt="PayPal" /></a></li>
											<li><a href="https://www.americanexpress.com/"><img src="assets/images/layout-1/pay/4.png" class="img-fluid" alt="American Express" /></a></li>
											<li><a href="https://www.discover.com/"><img src="assets/images/layout-1/pay/5.png" class="img-fluid" alt="Discover" /></a></li>
										</ul>
									</div>
								</div>
								<div class="footer-box">
									<div class="footer-title">
										<h5>Mon compte</h5>
									</div>
									<div class="footer-contant">
										<ul>
											<li><a href="javascript:void(0)">about us</a></li>
											<li><a href="javascript:void(0)">contact us</a></li>
											<li><a href="javascript:void(0)">terms &amp; conditions</a></li>
											<li><a href="javascript:void(0)">returns &amp; exchanges</a></li>
											<li><a href="javascript:void(0)">shipping &amp; delivery</a></li>
										</ul>
									</div>
								</div>
								<div class="footer-box">
									<div class="footer-title">
										<h5>Nous contacter</h5>
									</div>
									<div class="footer-contant">
										<ul class="contact-list">
											<li><i class="fa fa-map-marker"></i>big deal store demo store <br> india-<span>3654123</span></li>
											<li><i class="fa fa-phone"></i>call us: <span>123-456-7898</span></li>
											<li><i class="fa fa-envelope-o"></i>email us: support@bigdeal.com</li>
											<li><i class="fa fa-fax"></i>fax <span>123456</span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="subfooter dark-footer ">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-md-8 col-sm-12">
							<div class="footer-left">
								<p><?= date('Y') ?> Copyright par Themeforest Édité par pixel strap</p>
							</div>
						</div>
						<div class="col-xl-6 col-md-4 col-sm-12">
							<div class="footer-right">
								<ul class="sosiyal">
									<li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
									<li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
									<li><a href="javascript:void(0)"><i class="fa fa-instagram"></i></a></li>
									<li><a href="javascript:void(0)"><i class="fa fa-rss"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer end -->

		<!-- Add to cart bar -->
		<div id="cart_side" class="add_to_cart top">
			<a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
			<div class="cart-inner">
				<div class="cart_top">
					<h3>my cart</h3>
					<div class="close-cart">
						<a href="javascript:void(0)" onclick="closeCart()"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="cart_media">
					<ul class="cart_product">

					</ul>
					<ul class="cart_total">
						<li>subtotal : <span class="total-cart"></span></li>
						<li><div class="total">total<span class="total-cart"></span></div></li>
						<li>
							<div class="buttons">
								<a href="index.php?do=viewcart" class="btn btn-solid btn-sm">view cart</a>
								<a href="index.php?do=viewcheckout" class="btn btn-solid btn-sm">checkout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Add to cart bar end-->

		<!-- My account bar start-->
		<div id="myAccount" class="add_to_cart right account-bar">
			<a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
			<div class="cart-inner">
				<div class="cart_top">
					<h3>Mon compte</h3>
					<div class="close-cart">
						<a href="javascript:void(0)" onclick="closeAccount()"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</div>
				<?php
				if ($_SESSION['user']['loggedin'] !== true)
				{
			 	?>
				<form class="theme-form" action="index.php?do=dologin" method="post">
					<div class="form-group">
						<label for="email">Adresse email</label>
						<input type="text" class="form-control" id="email" name="email" placeholder="Insérez votre adresse email" required />
					</div>
					<div class="form-group">
						<label for="review">Mot de passe</label>
						<input type="password" class="form-control" id="review" name="password" placeholder="Insérez votre mot de passe" required />
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-solid btn-md btn-block" value="S'identifier" />
					</div>
					<div class="accout-fwd">
						<a href="index.php?do=forgotpassword" class="d-block"><h5>Oublié votre mot de passe ?</h5></a>
						<a href="index.php?do=register" class="d-block"><h6 >Vous n'avez pas de compte ?<span>Inscrivez-vous maintenant</span></h6></a>
					</div>
				</form>
				<?php
				}
				else
				{
				?>
				<div class="setting-block">
					<div class="setting-element">Mon compte</div>
					<div class="setting-element"><a href="index.php?do=profile">Tableau de bord</a></div>
					<div class="setting-element"><a href="index.php?do=editprofile">Modifier mon profil</a></div>
					<div class="setting-element"><a href="index.php?do=editpassword">Modifier mon mot de passe</a></div>
					<div class="setting-element"><a href="index.php?do=logout">Se déconnecter</a></div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
		<!-- Add to account bar end-->

		<!-- cookie bar start -->
		<div class="cookie-bar">
			<p>We use cookies to improve our site and your shopping experience. By continuing to browse our site you accept our cookie policy.</p>
			<a href="javascript:void(0)" class="btn btn-solid btn-xs">accept</a>
			<a href="javascript:void(0)" class="btn btn-solid btn-xs">decline</a>
		</div>
		<!-- cookie bar end -->
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice notifications.
	 *
	 * Notifications here are made with bootstrap-notify.
	 *
	 * @param string $title Title of the notification.
	 * @param string $message Message of the notification.
	 * @param string $type Type of notification. Accepted values: 'success' (green), 'info' (blue), 'warning' (yellow), 'danger' (red).
	 *
	 * @return void
	 */
	public static function FrontNotify($title, $message, $type)
	{
		?>
		<script>
		$(document).ready(function () {
			$.notify({
				icon: 'fa fa-check',
				title: '<?= $title ?>',
				message: '<?= $message ?>'
			},{
				element: 'body',
				position: null,
				type: '<?= $type ?>',
				allow_dismiss: true,
				newest_on_top: false,
				showProgressbar: true,
				placement: {
					from: "bottom",
					align: "right"
				},
				offset: 20,
				spacing: 10,
				z_index: 1031,
				delay: 5000,
				animate: {
					enter: 'animated fadeInDown',
					exit: 'animated fadeOutUp'
				},
				icon_type: 'class',
				template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
					'<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
					'<span data-notify="icon"></span> ' +
					'<span data-notify="title"><strong>{1}</strong></span><br /> ' +
					'<span data-notify="message">{2}</span>' +
					'<div class="progress" data-notify="progressbar">' +
					'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
					'</div>' +
					'<a href="{3}" target="{4}" data-notify="url"></a>' +
					'</div>'
				});
			});
		</script>
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice input validation code.
	 *
	 * @param string $id ID of the submit button of the form.
	 * @param integer $number Number of form items to remove from the end (submit and reset buttons, more items to remove?)
	 * @param integer $position The position of the form across all forms visible.
	 *
	 * @return void
	 */
	public static function FrontFormValidation($id = 'valider', $number = 2, $position = 1)
	{
		?>
			<script>
				$(document).on("click", "#<?= $id ?>", function(e)
				{
					e.preventDefault();
					let regexListe =
					{
						firstname: /^[\p{L}\s]{2,}$/u,
						lastname: /^[\p{L}\s]{2,}$/u,
						mail: /^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,24}))$/si,
						telephone: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
						address: /^[\d\w\-\s]{5,100}$/,
						city: /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/u,
						zipcode: /^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/,
						pass: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/,
					};

					$("small").text("");
					error = false;

					let formElements = $("form")[<?= $position ?>]; // grab form elements

					// formElements.length - x to not use 'submit', 'reset' and any other 'hidden' types at the end of the form
					for (let i = 0; i < formElements.length - <?= $number ?>; i++)
					{
						// radio cleaning
						if ($(formElements[i]).attr("type") === "radio")
						{
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
						}
						else
						{
							// input text cleaning
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
}

?>