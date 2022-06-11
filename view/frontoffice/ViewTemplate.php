<?php

require_once(DIR . '/model/ModelCategory.php');
use \Ecommerce\Model\ModelCategory;

/**
 * Class to display default HTML code for all necessary pages in front.
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
		<link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
		<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- google fonts -->
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

		<!-- font awesome css -->
		<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

		<!-- slick slider css -->
		<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
		<link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">

		<!-- bootstrap css -->
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

		<!-- theme css -->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen" id="color">
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice header.
	 *
	 * @return void
	 */
	public static function FrontHeader($address = '')
	{
		global $config;

		$categories = new ModelCategory($config);
		$listcategories = $categories->listAllCategoriesWithoutParents();

		// Create a list of categories without parents as root categories.
		$category = '';

		foreach ($listcategories AS $cat1)
		{
			if ($cat1['childlist'] == $cat1['id'] . ',-1')
			{
				// No child category - render category link as usual
				$category .= '<li><a class="dark-item-menu" href="index.php?do=viewcategory&ampid=' . $cat1['id'] . '">' . $cat1['nom'] .'</a>';
			}
			else
			{
				$category .= '<li><a class="dark-item-menu" href="javascript:void(0)">' . $cat1['nom'] .'</a>';
			}

			// Remove ',-1' part from the list
			$value = str_replace(',-1', '', $cat1['childlist']);

			// Remove the current category id from the list
			$value = str_replace($cat1['id'] . ',', '', $value);

			// Parent with no children don't need to run this part
			if (strpos($value, ',') !== false)
			{
				$listsubcategories = $categories->listChildrenCategoryInfos($value);

				if ($listsubcategories)
				{
					$category .= '<ul>';

					foreach ($listsubcategories AS $cat2)
					{
						$category .= '<li><a href="index.php?do=viewcategory&amp;id=' . $cat2['id'] . $address . '">' . $cat2['nom'] .'</a>';
					}

					$category .= '</ul>';
				}
			}

			$category .= '</li>';
		}

		?>
		<!-- loader -->
		<div class="loader-wrapper">
			<div>
				<img src="assets/images/loader2.gif" alt="loader">
			</div>
		</div>
		<!-- / loader -->

		<!-- header -->
		<header id="stickyheader">
			<div class="mobile-fix-option"></div>
			<div class="top-header">
				<div class="container">
					<div class="col-md-12">
						<div class="main-menu-block">
							<div class="header-left">
								<div class="brand-logo logo-sm-center">
									<a href="index.php">
										<img src="assets/images/NRS.png" class="img-fluid" alt="logo">
									</a>
								</div>
							</div>
							<div class="input-block">
								<div class="input-box">
									<form class="quicksearchform" action="index.php?do=search" method="get">
										<input type="hidden" name="do" value="search" />
										<div class="input-group">
											<div class="input-group-text">
												<span class="search">
													<i class="fa fa-search"></i>
												</span>
											</div>
											<input type="text" class="form-control autosuggest" placeholder="Rechercher un produit" name="query">
											<div class="input-group-text">
												<a href="index.php?do=advancedsearch">
													Recherche avancée
												</a>
											</div>
										</div>
									</form>
									<ul class="list-group predictivesearch hide"></ul>
								</div>
							</div>
							<div class="header-right">
								<div class="icon-block">
									<ul>
										<li class="mobile-search">
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
										</li>
										<li class="mobile-user "onclick="openAccount()">
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
										</li>
										<li class="mobile-cart item-count" onclick="openCart()">
											<div class="cart-block">
												<div class="cart-icon">
													<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><path d="m497 401.667c-415.684 0-397.149.077-397.175-.139-4.556-36.483-4.373-34.149-4.076-34.193 199.47-1.037-277.492.065 368.071.065 26.896 0 47.18-20.377 47.18-47.4v-203.25c0-19.7-16.025-35.755-35.725-35.79l-124.179-.214v-31.746c0-17.645-14.355-32-32-32h-29.972c-17.64 0-31.99 14.351-31.99 31.99v31.594l-133.21-.232-9.985-54.992c-2.667-14.694-15.443-25.36-30.378-25.36h-68.561c-8.284 0-15 6.716-15 15s6.716 15 15 15c72.595 0 69.219-.399 69.422.719 16.275 89.632 5.917 26.988 49.58 306.416l-38.389.2c-18.027.069-32.06 15.893-29.81 33.899l4.252 34.016c1.883 15.06 14.748 26.417 29.925 26.417h26.62c-18.8 36.504 7.827 80.333 49.067 80.333 41.221 0 67.876-43.813 49.067-80.333h142.866c-18.801 36.504 7.827 80.333 49.067 80.333 41.22 0 67.875-43.811 49.066-80.333h31.267c8.284 0 15-6.716 15-15s-6.716-15-15-15zm-209.865-352.677c0-1.097.893-1.99 1.99-1.99h29.972c1.103 0 2 .897 2 2v111c0 8.284 6.716 15 15 15h22.276l-46.75 46.779c-4.149 4.151-10.866 4.151-15.015 0l-46.751-46.779h22.277c8.284 0 15-6.716 15-15v-111.01zm-30 61.594v34.416h-25.039c-20.126 0-30.252 24.394-16.014 38.644l59.308 59.342c15.874 15.883 41.576 15.885 57.452 0l59.307-59.342c14.229-14.237 4.13-38.644-16.013-38.644h-25.039v-34.254l124.127.214c3.186.005 5.776 2.603 5.776 5.79v203.25c0 10.407-6.904 17.4-17.18 17.4h-299.412l-35.477-227.039zm-56.302 346.249c0 13.877-11.29 25.167-25.167 25.167s-25.166-11.29-25.166-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167zm241 0c0 13.877-11.289 25.167-25.166 25.167s-25.167-11.29-25.167-25.167 11.29-25.167 25.167-25.167 25.166 11.291 25.166 25.167z"/></g></svg>
												</div>
												<div class="cart-item">
													<h5>Panier</h5>
												</div>
											</div>
											<div class="item-count-contain total-count"></div>
										</li>
									</ul>
								</div>
								<div class="menu-nav">
									<span class="toggle-nav">
										<i class="fa fa-bars "></i>
									</span>
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
						<input type="text" class="form-control" placeholder="Rechercher un produit">
						<span class="input-group-text close-searchbar">
							<svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
						</span>
					</div>
				</div>
			</div>
			<div class="category-header">
				<div class="custom-container">
					<div class="row">
						<div class="col-12">
							<div class="navbar-menu">
								<div class="logo-block">
									<div class="brand-logo logo-sm-center">
										<a href="index.php">
											<img src="assets/images/NRS.png" alt="logo">
										</a>
									</div>
								</div>
								<div class="menu-block">
									<nav id="main-nav">
										<div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
										<ul id="main-menu" class="sm categories-menu sm-horizontal">
											<li>
												<div class="mobile-back text-right">Fermer<i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
											</li>
											<?= $category ?>
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
						<input type="text" class="form-control" placeholder="Rechercher un produit">
						<span class="input-group-text close-searchbar">
							<svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"/></svg>
						</span>
					</div>
				</div>
			</div>
		</header>
		<!-- / header -->
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice breadcrumb.
	 *
	 * @param string $itemname Name of the item.
	 * @param array $navbits Array of breadcrumb items to show.
	 * @param bool $displaywelcome Display the 'Welcome' link?
	 *
	 * @return void
	 */
	public static function FrontBreadcrumb($itemname, $navbits = '', $displaywelcome = true)
	{
		?>
		<!-- breadcrumb -->
		<div class="breadcrumb-main">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="breadcrumb-contain">
							<div>
								<h2><?= ($itemname ? $itemname : '') ?></h2>
								<?php
								if ($displaywelcome)
								{
								?>
									<ul>
										<li><a href="index.php">Accueil</a></li>
										<?php
										if (is_array($navbits))
										{
											foreach ($navbits AS $key => $value)
											{
												?>
												<li><i class="fa fa-angle-double-right"></i></li>
												<li><a href="index.php?do=<?= $key ?>"><?= $value ?></a></li>
												<?php
											}
										}
										?>
									</ul>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- / breadcrumb -->
		<?php
	}

	/**
	 * Returns the HTML code to display the frontoffice footer.
	 *
	 * @return void
	 */
	public static function FrontFooter()
	{
		global $do, $antiCSRF;
		?>
		<!-- footer -->
		<footer>
			<div class="footer">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="footer-main">
								<div class="footer-box">
									<div class="footer-title mobile-title">
										<h5>À propos</h5>
									</div>
									<div class="footer-content">
										<div class="footer-logo">
											<a href="index.php">
												<img src="assets/images/NRS.png" alt="logo">
											</a>
										</div>
										<p>Ce site de vente n'est pas un vrai site de vente mais une démonstration des capacités de son créateur.<br />Toutes les marques citées appartiennent à leurs auteurs respectifs.</p>
										<ul class="payment">
											<li><a href="https://www.visa.com/"><img src="assets/images/footervisa.png" class="img-fluid" alt="VISA" /></a></li>
											<li><a href="https://www.mastercard.com/"><img src="assets/images/footermastercard.png" class="img-fluid" alt="MasterCard" /></a></li>
											<li><a href="https://www.americanexpress.com/"><img src="assets/images/footeraa.png" class="img-fluid" alt="American Express" /></a></li>
											<li><a href="https://www.discover.com/"><img src="assets/images/footerdiscover.png" class="img-fluid" alt="Discover" /></a></li>
										</ul>
									</div>
								</div>
								<div class="footer-box">
									<div class="footer-title">
										<h5>Mon compte</h5>
									</div>
									<div class="footer-content">
										<ul>
											<li><a href="javascript:void(0)">À propos</a></li>
											<li><a href="index.php?do=contact">Nous contacter</a></li>
											<li><a href="javascript:void(0)">Termes &amp; Conditions</a></li>
											<li><a href="javascript:void(0)">Retours &amp; Échanges</a></li>
											<li><a href="javascript:void(0)">Livraison &amp; Transports</a></li>
										</ul>
									</div>
								</div>
								<div class="footer-box">
									<div class="footer-title">
										<h5>Nous contacter</h5>
									</div>
									<div class="footer-content">
										<ul class="contact-list">
											<li><i class="fa fa-map-marker"></i>Nintendo retro shop demo <br /> inconnu -<span>3654123</span></li>
											<li><i class="fa fa-phone"></i>Appelez-nous : <span>123-456-7898</span></li>
											<li><i class="fa fa-envelope-o"></i>Écrivez-nous : support@unknown.com</li>
											<li><i class="fa fa-fax"></i>Fax <span>123456</span></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="subfooter dark-footer">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-md-8 col-sm-12">
							<div class="footer-left">
								<p><?= date('Y') ?> Copyright par moi-même.</p>
							</div>
						</div>
						<div class="col-xl-6 col-md-4 col-sm-12">
							<div class="footer-right">
								<ul class="social">
									<li class="fb-color"><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
									<li class="twt-color"><a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>
									<li class="insta-color"><a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a></li>
									<li class="linkedin-color"><a href="https://www.linkedin.com.com/"><i class="fab fa-linkedin-in"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- / footer -->

		<!-- / cart bar -->
		<div id="cart_side" class="add_to_cart top">
			<a href="javascript:void(0)" class="overlay" onclick="closeCart()"></a>
			<div class="cart-inner">
				<div class="cart_top">
					<h3>Mon panier</h3>
					<div class="close-cart">
						<a href="javascript:void(0)" onclick="closeCart()"><i class="fa fa-times" aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="cart_media">
					<ul class="cart_product">

					</ul>
					<ul class="cart_total">
						<li>Sous-total : <span class="total-cart"></span></li>
						<li><div class="total">Total<span class="total-cart"></span></div></li>
						<li>
							<div class="buttons">
								<a href="index.php?do=viewcart" class="btn btn-solid btn-sm">Afficher le panier</a>
								&nbsp;&nbsp;
								<a href="index.php?do=viewcheckout" class="btn btn-solid btn-sm">Passer la commande</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- / cart bar -->

		<!-- my account bar -->
		<div id="myAccount" class="account-bar right">
			<a href="javascript:void(0)" class="overlay" onclick="closeAccount()"></a>
			<div class="account-inner">
				<div class="account-top">
					<h3>Mon compte</h3>
					<div class="close-account">
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
						<label for="password">Mot de passe</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Insérez votre mot de passe" required />
					</div>
					<div class="form-group">
						<input type="hidden" name="doaction" value="<?= $_SERVER['QUERY_STRING'] ?>" />
						<?= $antiCSRF->insertHiddenToken() ?>
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
					<div class="setting-element"><a href="index.php?do=dashboard">Tableau de bord</a></div>
					<div class="setting-element"><a href="index.php?do=editprofile">Modifier mon profil</a></div>
					<div class="setting-element"><a href="index.php?do=editpassword">Modifier mon mot de passe</a></div>
					<div class="setting-element"><a href="index.php?do=logout">Se déconnecter</a></div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
		<!-- / my account bar-->

		<!-- cookie bar -->
		<div class="cookie-bar">
			<p>Nous utilisons des cookies pour améliorer notre site ainsi que votre expérience d'achat. En continuant, vous acceptez notre politique sur les cookies.</p>
			<a href="javascript:void(0)" class="btn btn-solid btn-xs cookie-accept">Accepter</a>
			<a href="javascript:void(0)" class="btn btn-solid btn-xs">Refuser</a>
		</div>
		<!-- / cookie bar -->

		<!-- jquery js -->
		<script src="assets/js/jquery-3.6.0.min.js"></script>

		<!-- slick js -->
		<script src="assets/js/slick.js"></script>

		<!-- smartmenus js -->
		<script src="assets/js/menu.js"></script>

		<!-- bootstrap js -->
		<script src="assets/js/bootstrap.bundle.min.js"></script>

		<!-- font awesome js -->
		<script src="assets/js/fontawesome.js"></script>

		<!-- bootstrap-notify js -->
		<script src="assets/js/bootstrap-notify.min.js"></script>

		<!-- theme js-->
		<script src="assets/js/script.js"></script>
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
			<!-- bs-notify -->
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
			<!-- / bs-notify -->
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
			<!-- client-side validation -->
			<script>
				$(document).on("click", "#<?= $id ?>", function(e)
				{
					e.preventDefault();
					let regexListe =
					{
						firstname: /^[\p{L}\d\s\-]{2,}$/u,
						lastname: /^[\p{L}\d\s\-]{2,}$/u,
						title: /^[\p{L}\d\s\-]{2,}$/u,
						name: /^[\p{L}\d\s\-]{2,}$/u,
						mail: /^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'"<>@,;]+\.+[a-z]{2,63}))$/si,
						telephone: /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/,
						address: /^[\d\w\-\s]{5,100}$/,
						city: /^([a-zA-Z]+(?:[\s\-][a-zA-Z]+)*){1,}$/u,
						zipcode: /^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/,
						country: /^[A-Z]{2}$/,
						pass: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/,
						ref: /^[\p{L}\d\s\-]{2,}$/u,
						description: /^[\p{L}\d\s_~\-!@#:\\"'=\.,;\$%\^&\*\(\)\[\]<>]{2,}$/u,
						quantity: /^[0-9]{2,}$/,
						price: /^[0-9]{1,5}\.[0-9]{2}$/,
						displayorder: /^[0-9]+$/,
						message: /^[\p{L}\d\s_~\-!@#:\\"'=\.,;\$%\^&\*\(\)\[\]<>]{2,}$/um,
						query: /^[\p{L}\d\s_~\-!@#:\\"'=\.,;\$%\^&\*\(\)\[\]]{2,}$/u,
						deliver: /^[0-9]{1,}$/,
						delivermode: /^[0-9]{1,}$/u,
						doaction: /^[a-z0-9&?=]{1,}$/,
						pricemin: /^[0-9]{1,5}$/,
						pricemax: /^[0-9]{1,5}$/,
						product: /^[\p{L}\d\s-]{2,}$/u,
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
						else if ($(formElements[i]).prop("tagName").toLowerCase() === "textarea")
						{
							// textarea cleaning
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
						else
						{
							// input text cleaning
							$(formElements[i]).removeClass("is-invalid");
							$(formElements[i]).next().html("");

							const type = $(formElements[i]).attr("id");
							const pattern = regexListe[type];
console.log(type);
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
			<!-- / client-side validation -->
		<?php
	}
}

?>
