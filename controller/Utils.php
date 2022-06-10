<?php

require_once(DIR . '/model/ModelCategory.php');
use \Ecommerce\Model\ModelCategory;

/**
 * Utility class to perform various actions across the whole system
 *
 * @Date: $Date$
 */
class Utils
{
	/**
	 * Method to upload any file.
	 *
	 * @param array $extensions Array of allowed extensions file for the uploading media.
	 * @param file $fichier The uploaded file.
	 * @param string $module The module to upload the file. Defines the final subdirectory into the upload folder. Valid values: 'delivers', 'products', 'trademarks'.
	 *
	 * @return mixed If upload is correctly done, returns the file name to save into the database.
	 */
	public static function upload($extensions, $fichier, $module)
	{
		$file_name = $fichier['name'];
		$file_size = $fichier['size'];
		$file_tmp = $fichier['tmp_name'];
		$file_ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));

		// Upload is via ./admin only, we're storing attachments at ./, we need to go 1 directory back
		$path = str_replace('/admin/..', '', DIR);

		$pattern = "/^[\p{L}\w\s\-\.]{3,}$/";

		if (!preg_match($pattern, $file_name))
		{
			throw new Exception('Le nom de fichier n\'est pas valide.');
		}

		if (!in_array($file_ext, $extensions))
		{
			throw new Exception('L\'extension n\'est pas autorisée.');
		}

		$maxupload = ini_get('upload_max_filesize');

		if ($file_size > self::return_bytes($maxupload))
		{
			throw new Exception('La taille du fichier ne doit pas dépasser ' . self::return_bytes($maxupload) . '.');
		}

		$file_name = substr(md5($fichier['name']), 10) . '.' . $file_ext;

		while (file_exists($path . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $file_name))
		{
			$file_name = substr(md5($file_name), 10) . '.' . $file_ext;
		}

		$targetFile =  $path . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $file_name;

		if (move_uploaded_file($file_tmp, $targetFile))
		{
			return $file_name;
		}
		else
		{
			throw new Exception('Echec de l\'upload.');
		}
	}

	/**
	 * Converts a size data into full size. This allows to convert a value like 3M to 3145728.
	 *
	 * @param string $val Value to convert.
	 *
	 * @return integer Value converted in full length.
	 */
	private static function return_bytes($val)
	{
		$val = trim($val);
		$last = strtolower($val[strlen($val) - 1]);

		switch($last)
		{
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}

	/**
	 * Verifies if the input value uses a correct format.
	 *
	 * @param string $str Value to verify.
	 * @param string $type Type of value to verify.
	 * @param string $text More text to display next of the main error message.
	 * @param string $confirm Used to pass confirm password field only.
	 * @param boolean $empty Can be empty? Useful for the advanced search.
	 *
	 * @return string Error message to display into a try/catch.
	 */
	public static function datavalidation($str, $type, $text = '', $confirm = '', $empty = false)
	{
		$tabRegex = [
			"firstname" => "/^[\p{L}\d\s-]{2,}$/u",
			"lastname" => "/^[\p{L}\d\s-]{2,}$/u",
			"title" => "/^[\p{L}\d\s-]{2,}$/u",
			"name" => "/^[\p{L}\d\s-]{2,}$/u",
			"mail" => "/^[a-z0-9.!#$%&\'*+\-\/=?^_`{|}~]+@([0-9.]+|([^\s\'\"<>@,;]+\.+[a-z]{2,63}))$/si",
			"telephone" => "/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/",
			"address" => "/^[\d\w\-\s]{5,100}$/",
			"city" => "/^([a-zA-Z]+(?:[\s-][a-zA-Z]+)*){1,}$/u",
			"zipcode" => "/^[a-z0-9][a-z0-9\- ]{0,10}[a-z0-9]$/",
			"pass" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/",
			"ref" => "/^[\p{L}\s-]{2,}$/u",
			"description" => "/^[\p{L}\d\s_~\-!@#:\"\'=\.,;\$%\^&\*\(\)\[\]<>]{2,}$/u",
			"quantity" => "/^[0-9]{1,}$/",
			"price" => "/^[0-9]{1,5}\.[0-9]{2}$/",
			"displayorder" => "/^[0-9]+$/",
			"message" => "/^[\p{L}\d\s_~\-!@#:\"\'=\.,;\$%\^&\*\(\)\[\]<>]{2,}$/u",
			"query" => "/^[\p{L}\d\s_~\-!@#:\"\'=\.,;\$%\^&\*\(\)\[\]]{2,}$/u",
			"deliver" => "/^[0-9]{1,}$/",
			"delivermode" => "/^[0-9]{1,}$/u",
			"doaction" => "/^[a-z0-9&?=]{1,}$/",
			"pricemin" => "/^[0-9]{1,5}$/",
			"pricemax" => "/^[0-9]{1,5}$/",
			"product" => "/^[\p{L}\d\s-]{2,}$/u",
		];

		// Proceed here only if we're not in the search in top
		if ($type !== 'query')
		{
			if (!$empty)
			{
				// Check if empty
				if ($str === '' OR empty($str))
				{
					return 'Le champ \'' . ucfirst($type) . '\' ne peut pas être vide.';
				}


				// Check for the specific password case with confirm password
				if ($confirm)
				{
					if ($str !== $confirm)
					{
						return 'Les mots de passe ne correspondent pas.';
					}
				}

				// Check if valid
				if (!preg_match($tabRegex[$type], $str))
				{
					return 'Le champ de la recherche n\'est pas au format demandé.' . ($text ? ' ' . $text : '');
				}
			}
		}
		else
		{
			if (!$empty)
			{
				// Check if empty
				if ($str === '' OR empty($str))
				{
					return 'Le champ \'' . ucfirst($type) . '\' ne peut pas être vide.';
				}

				// Check if valid
				if (!preg_match($tabRegex[$type], $str))
				{
					return 'Le champ de la recherche n\'est pas au format demandé.' . ($text ? ' ' . $text : '');
				}
			}
		}
	}

	/**
	 * Verifies if the permission id is in the array of values in $_SESSION.
	 *
	 * @param integer $pid Permission ID found in table 'permission'.
	 *
	 * @return boolean True if found (allow the user), false if not found (disallow the user)
	 */
	public static function cando($pid)
	{
		return in_array($pid, $_SESSION['employee']['permissions']);
	}

	/**
	 * Returns an array of values passed through print_r with some formatting. Useful to debug arrays.
	 *
	 * @param array $value Array of values to debug.
	 * @param boolean $exit Do we stop the script process just after its execution?
	 *
	 * @return void
	 */
	public static function printr($value, $exit = false)
	{
		echo '<div><pre>';
		print_r($value);
		echo '</pre></div>';

		if ($exit)
		{
			exit;
		}
	}

	/**
	 * Defines the limit lower for the query for the pagination.
	 *
	 * @param integer $totalitems Total number of items in the database.
	 * @param integer $pagenumber Number of the current page.
	 * @param integer $perpage Number of items per page to display
	 *
	 * @return integer Lower limit value to query the database for pagination.
	 */
	public static function define_pagination_values($totalitems, $pagenumber = 1, $perpage = 20)
	{
		Utils::sanitize_pageresults($totalitems, $pagenumber, $perpage, 200, 20);

		$limitlower = ($pagenumber - 1) * $perpage;
		$limitupper = ($pagenumber) * $perpage;

		if ($limitupper > $totalitems)
		{
			$limitupper = $totalitems;

			if ($limitlower > $totalitems)
			{
				$limitlower = ($totalitems - $perpage) - 1;
			}
		}

		if ($limitlower < 0)
		{
			$limitlower = 0;
		}

		return $limitlower;
	}

	/**
	 * Returns the HTML for multi-page navigation for backoffice.
	 *
	 * @param integer $pagenumber Page number being displayed.
	 * @param integer $perpage Number of items to be displayed per page.
	 * @param integer $results Total number of items found.
	 * @param string $address Base address to append the page number.
	 * @param string $type Type of page navigation. Valid values: 'back', 'front'.
	 * @param string $address2 Part of the URL to add after. It can be the sorting direction or the number of elements per page.
	 *
	 * @return string Page navigation HTML
	 */
	public static function construct_page_nav($pagenumber, $perpage, $results, $address, $type = 'back', $address2 = '')
	{
		$curpage = 0;
		$pagenavarr = array();
		$firstlink = '';
		$prevlink = '';
		$lastlink = '';
		$nextlink = '';

		$total = number_format($results);
		$totalpages = ceil($results / $perpage);

		if ($results <= $perpage)
		{
			$totalpages = 1;
		}

		$firstaddress = $prevaddress = $nextaddress = $lastaddress = '';

		if ($pagenumber > 1)
		{
			$prevpage = $pagenumber - 1;
			$prevnumbers = self::fetch_start_end_total_array($prevpage, $perpage, $results);
			$prevaddress = $address . '&page=' . $prevpage;
		}

		if ($pagenumber < $totalpages)
		{
			$nextpage = $pagenumber + 1;
			$nextnumbers = self::fetch_start_end_total_array($nextpage, $perpage, $results);
			$nextaddress = $address . '&page=' . $nextpage;
		}

		// create array of possible relative links that we might have (eg. +10, +20, +50, etc.)
		$pagenavsarr = [10, 50, 100, 500, 1000];

		$pages = array(1, $pagenumber, $totalpages);

		if (3 > 0)
		{

			for ($i = 1; $i <= 3; $i++)
			{
				$pages[] = $pagenumber + $i;
				$pages[] = $pagenumber - $i;
			}

			foreach ($pagenavsarr AS $relpage)
			{
				$pages[] = $pagenumber + $relpage;
				$pages[] = $pagenumber - $relpage;
			}
		}
		else
		{
			for ($i = 2; $i < $totalpages; $i++)
			{
				$pages[] = $i;
			}
		}

		$show_prior_elipsis = $show_after_elipsis = ($totalpages > 3) ? 1 : 0;

		$pages = array_unique($pages);
		sort($pages);

		foreach ($pages AS $foo => $curpage)
		{
			if ($curpage < 1 OR $curpage > $totalpages)
			{
				continue;
			}

			if ($pagenumber != 1)
			{
				$firstnumbers = self::fetch_start_end_total_array(1, $perpage, $results);
				$firstaddress = $address . '&page=1' . $address2;
			}

			if ($pagenumber != $totalpages)
			{
				$lastnumbers = self::fetch_start_end_total_array($totalpages, $perpage, $results);
				$lastaddress = $address . '&page=' . $totalpages . $address2;
			}

			if (abs($curpage - $pagenumber) >= 3 AND 3 != 0)
			{
				// generate relative links (eg. +10,etc).
				if (in_array(abs($curpage - $pagenumber), $pagenavsarr) AND $curpage != 1 AND $curpage != $totalpages)
				{
					$pagenumbers = self::fetch_start_end_total_array($curpage, $perpage, $results);
					$relpage = $curpage - $pagenumber;

					if ($relpage > 0)
					{
						$relpage = '+' . $relpage;
					}

					if ($type === 'back')
					{
						$pagenavarr[] = '<span class="tablegrid-pager-page"><a href="' . $address . '&page=' . $curpage . '" title="Affichage des résultats ' . $pagenumbers['first'] .' à ' . $pagenumbers['last'] .' sur ' . $total . '"><!-- ' . $relpage . ' -->' . $curpage .'</a></a></span>';
					}
					else if ($type === 'front')
					{
						$pagenavarr[] = '<li class="page-item"><a class="page-link" href="' . $address . '&page=' . $curpage . '" title="Affichage des résultats ' . $pagenumbers['first'] .' à ' . $pagenumbers['last'] .' sur ' . $total . '"><!-- ' . $relpage . ' -->' . $curpage .'</a></a></li>';
					}
				}
			}
			else
			{
				// if appropriate, hide the ellipses
				if ($curpage == 1)
				{
					$show_prior_elipsis = 0;
				}
				else if ($curpage == $totalpages)
				{
					$show_after_elipsis = 0;
				}

				if ($curpage == $pagenumber)
				{
					$numbers = self::fetch_start_end_total_array($curpage, $perpage, $results);

					if ($type === 'back')
					{
						$pagenavarr[] = '<span class="tablegrid-pager-page tablegrid-pager-current-page"><a href="' . $address . '&page=' . $curpage . $address2 . '" title="Affichage des résultats ' . $numbers['first'] .' à ' . $numbers['last'] .' sur ' . $total . '">' . $curpage .'</a></span>';
					}
					else if ($type === 'front')
					{
						$pagenavarr[] = '<li class="page-item"><a class="page-link" href="' . $address . '&page=' . $curpage . $address2 . '" title="Affichage des résultats ' . $numbers['first'] .' à ' . $numbers['last'] .' sur ' . $total . '">' . $curpage .'</a></li>';
					}
				}
				else
				{
					$pagenumbers = self::fetch_start_end_total_array($curpage, $perpage, $results);

					if ($type === 'back')
					{
						$pagenavarr[] = '<span class="tablegrid-pager-page"><a href="' . $address . '&page=' . $curpage . $address2 . '" title="Affichage des résultats ' . $pagenumbers['first'] .' à ' . $pagenumbers['last'] .' sur ' . $total . '">' . $curpage .'</a></a></span>';
					}
					else if ($type === 'front')
					{
						$pagenavarr[] = '<li class="page-item"><a class="page-link" href="' . $address . '&page=' . $curpage . $address2 . '" title="Affichage des résultats ' . $pagenumbers['first'] .' à ' . $pagenumbers['last'] .' sur ' . $total . '">' . $curpage .'</a></a></li>';
					}
				}
			}
		}

		$pagenav = implode('', $pagenavarr);

		if ($type === 'back')
		{
			$return = '<div class="tablegrid-pager-container">
				<div class="tablegrid-pager">
					Pages:
					' . ($firstaddress ? '<span class="tablegrid-pager-nav-button"><a href="' . $firstaddress . '">Première</a></span>' : '') . '
					' . ($prevaddress ? '<span class="tablegrid-pager-nav-button"><a href="' . $prevaddress . '">Précédente</a></span>' : '') . '
					' . (($show_prior_elipsis AND $prevaddress AND $firstaddress) ? '<span>...</span>' : '') . '
					' . $pagenav . '
					' . (($show_after_elipsis AND $nextaddress AND $lastaddress) ? '<span>...</span>' : '') . '
					' . ($nextaddress ? '<span class="tablegrid-pager-nav-button"><a href="' . $nextaddress . '">Suivante</a></span>' : '') . '
					' . ($lastaddress ? '<span class="tablegrid-pager-nav-button"><a href="' . $lastaddress . '">Dernière</a></span>' : '') . '
					&nbsp;&nbsp;' . $pagenumber . ' sur ' . $totalpages . '
				</div>
			</div>';
		}
		else if ($type === 'front')
		{
			$return = '<div class="product-pagination">
			<div class="theme-paggination-block">
				<div class="container-fluid p-0">
					<div class="row">
						<div class="col-xl-6 col-md-6 col-sm-12">
							<nav aria-label="Page navigation">
								<ul class="pagination">
									' . ($firstaddress ? '<li class="page-item"><a class="page-link" href="' . $firstaddress . '" aria-label="Première">Première</a></li>' : '') . '
									' . ($prevaddress ? '<li class="page-item"><a class="page-link" href="' . $prevaddress . '" aria-label="Précédente"><span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> <span class="sr-only">Précédente</span></a></li>' : '') . '
									' . (($show_prior_elipsis AND $prevaddress AND $firstaddress) ? '<li class="page-item"><a class="page-link" href="javascript:void(0)" role="link" attribute aria-disabled="true">...</a></li>' : '') . '
									' . $pagenav . '
									' . (($show_after_elipsis AND $nextaddress AND $lastaddress) ? '<li class="page-item"><a class="page-link" href="javascript:void(0)" role="link" attribute aria-disabled="true">...</a></li>' : '') . '
									' . ($nextaddress ? '<li class="page-item"><a class="page-link" href="' . $nextaddress . '" aria-label="Suivante"><span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Suivante</span></a></li>' : '') . '
									' . ($lastaddress ? '<li class="page-item"><a class="page-link" href="' . $lastaddress . '" aria-label="Dernière">Dernière</a></li>' : '') . '
								</ul>
							</nav>
						</div>
						<div class="col-xl-6 col-md-6 col-sm-12">
							<div class="product-search-count-bottom">
								<h5>Affichage de la page ' . $pagenumber . ' sur ' . $totalpages . '</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';
		}

		echo $return;
	}

	/**
	 *
	 */
	public static function parse_url($url, $component = -1)
	{
		// Taken from /rfc3986#section-2
		$safechars =array(':', '/', '?', '#', '[', ']', '@', '!', '$', '&', '\'' ,'(', ')', '*', '+', ',', ';', '=');
		$trans = array('%3A', '%2F', '%3F', '%23', '%5B', '%5D', '%40', '%21', '%24', '%26', '%27', '%28', '%29', '%2A', '%2B', '%2C', '%3B', '%3D');
		$encodedurl = str_replace($trans, $safechars, urlencode($url));

		$parsed = @parse_url($encodedurl, $component);

		if (is_array($parsed))
		{
			foreach ($parsed AS $index => $element)
			{
				$parsed[$index] = urldecode($element);
			}
		}
		else
		{
			$parsed = urldecode($parsed);
		}

		return $parsed;
	}

	/**
	 * Returns an array so you can print 'Showing results $arr[first] to $arr[last] of $totalresults'.
	 *
	 * @param integer $pagenumber Current page number
	 * @param integer $perpage Results to show per-page
	 * @param integer $total Total results found
	 *
	 * @return	array	In the format of - array('first' => x, 'last' => y)
	 */
	public static function fetch_start_end_total_array($pagenumber, $perpage, $total)
	{
		$first = $perpage * ($pagenumber - 1);
		$last = $first + $perpage;

		if ($last > $total)
		{
			$last = $total;
		}

		$first++;

		return array('first' => number_format($first), 'last' => number_format($last));
	}

	/**
	 * Ensures that the variables for a multi-page display are sane
	 *
	 * @param integer $numresults Total number of items to be displayed
	 * @param integer $page (ref) Current page number
	 * @param integer $perpage (ref) Desired number of results to show per-page
	 * @param integer $maxperpage Maximum allowable results to show per-page
	 * @param integer $$defaultperpage Default number of results to show per-page
	 */
	public static function sanitize_pageresults($numresults, &$page, &$perpage, $maxperpage = 20, $defaultperpage = 20)
	{
		$perpage = intval($perpage);

		if ($perpage < 1)
		{
			$perpage = $defaultperpage;
		}

		if ($perpage > $maxperpage)
		{
			$perpage = $maxperpage;
		}

		$numpages = ceil($numresults / $perpage);

		if ($numpages == 0)
		{
			$numpages = 1;
		}

		if ($page < 1)
		{
			$page = 1;
		}
		else if ($page > $numpages)
		{
			$page = $numpages;
		}
	}

	/**
	 * Returns an array of categories values with an addition of depth for parent/child relation.
	 *
 	 * @return array Array of data.
	 */
	public static function categoriesCache($content)
	{
		$array = [];

		foreach ($content AS $key => $data)
		{
			$array["$data[id]"] = $data;
			$array["$data[id]"]['depth'] = substr_count($array["$data[id]"]['parentlist'], ',') - 1;
		}

		return $array;
	}

	/**
	 * Returns a list of <option> fields, optionally with one selected.
	 *
	 * @param array $array Array of value => text pairs representing '&lt;option value="$key">$value</option>' fields.
	 * @param string $selectedid Selected option.
	 *
	 * @return string List of &lt;option> tags.
	 */
	public static function constructCategorySelectOptions($array, $selectedid = '')
	{
		if (is_array($array))
		{
			$options = '';

			foreach ($array AS $key => $value)
			{
				if (is_array($value))
				{
					$options .= "\t\t<optgroup label=\"" . $key . "\">/n";
					$options .= self::constructCategorySelectOptions($value, $selectedid);
					$options .= "\t\t</optgroup>\n";
				}
				else
				{
					if (is_array($selectedid))
					{
						$selected = (in_array($key, $selectedid) ? ' selected' : '');
					}
					else
					{

						$selected = ($key == $selectedid ? ' selected' : '');
					}

					$options .= "\t\t<option value=\"" . $key . "\"$selected>$value</option>\n";
				 }
			 }
		 }

		 return $options;
	 }

	/**
	 * Returns an array representing the list of categories.
	 *
	 * @param array $categorycache A valid category cache in form of array[id] => data.
	 * @param boolean $norootcat Specifies if we add the line with id -1.
	 * @param string $type Defines which root &lt;option> to show. Valid values: 'front', 'back'.
	 *
	 * @return array Array representing the list of categories.
	 */
	public static function constructCategoryChooserOptions($categorycache, $norootcat = true, $type = 'back')
	{
		$selectoptions = [];

		if ($norootcat)
		{
			if ($type == 'back')
			{
				$selectoptions[-1] = 'Selectionnez une catégorie parente. Pas de sélection = pas de parent.';
			}
			else if ($type == 'front')
			{
				$selectoptions[0] = 'Toutes les catégories';
			}
		}

		$startdepth = '';

		// Pass a sort of cache of category to parse
		foreach ($categorycache AS $categoryid => $category)
		{
			$depthmark = '';

			for ($i = 0; $i < $category['depth']; $i++)
			{
				$depthmark .= '--';
			}

			$selectoptions["$categoryid"] = $depthmark . ' ' . $category['nom'];
		}

		return $selectoptions;
	}

	/**
	 * Builds a cache with parents informations to create parentlist and childlist.
	 *
	 * @param array $array Array of all existing categories.
	 *
	 * @return array Array of parents informations.
	 */
	public static function buildParentCache($array)
	{
		$return = [];

		foreach ($array AS $key => $newcategory)
		{
			$return["$newcategory[parent_id]"]["$newcategory[id]"] = $newcategory['id'];
		}

		return $return;
	}

	/**
	 * Recalculates category parent and child lists, then saves them back to the category table.
	 *
	 * @param array $categoriesCache Array of categories informations.
	 * @param array $parentCache Array of parents informations.
	 *
	 * @return void
	 */
	public static function buildCategoryGenealogy($categoriesCache, $parentCache)
	{
		global $config;

		// build parent/child lists
		foreach ($categoriesCache AS $categoryid => $category)
		{
			// parent list
			$i = 0;
			$curid = $categoryid;

			$categoriesCache["$categoryid"]['parentlist'] = '';

			while ($curid != -1 AND $i++ < 1000)
			{
				if ($curid)
				{
					$categoriesCache["$categoryid"]['parentlist'] .= $curid . ',';
					$curid = $categoriesCache["$curid"]['parent_id'];
				}
				else
				{
					if ($curid !== '0')
					{
						throw new Exception('La définition des parents des catégories est non valide.');
					}
				}
			}

			$categoriesCache["$categoryid"]['parentlist'] .= '-1';

			// child list
			$categoriesCache["$categoryid"]['childlist'] = $categoryid;
			self::fetchCategoryChildList($categoryid, $categoryid, $categoriesCache, $parentCache);
			$categoriesCache["$categoryid"]['childlist'] .= ',-1';
		}

		foreach ($categoriesCache AS $categoryid => $category)
		{
			$cats = new ModelCategory($config);
			$cats->set_parentlist($category['parentlist']);
			$cats->set_childlist($category['childlist']);
			$cats->set_id($categoryid);

			if (!$cats->updateCategoriesGenealogy())
			{
				throw new Exception('Une erreur est survenue pendant la mise à jour de la généalogie des catégories.');
			}
		}
	}

	/**
	* Recursive function to populate the category cache with correct child list fields.
	*
	* @param integer $maincategoryid Category ID to be updated.
	* @param integer $parentid Parent category ID.
	*
	* @return void
	*/
	private static function fetchCategoryChildList($maincategoryid, $parentid, &$categoriesCache, $parentCache)
	{
		if (!empty($parentCache["$parentid"]) AND is_array($parentCache["$parentid"]))
		{
			foreach ($parentCache["$parentid"] AS $categoryid => $categoryparentid)
			{
				$categoriesCache["$maincategoryid"]['childlist'] .= ',' . $categoryid;
				self::fetchCategoryChildList($maincategoryid, $categoryid, $categoriesCache, $parentCache);
			}
		}
	}

	/**
	 * Creates a list of countries to display in the customer profile. Not used actually, maybe added later.
	 *
	 * @param string $selected Value stored in the database for the customer.
	 *
	 * @return string Returns string with all values stored in &lt;option> tags
	 */
	public static function createCountryList($selected = '')
	{
		$return = '';

		$countries = [
			'AF' => 'Afghanistan', 'ZA' => 'Afrique du Sud', 'AL' => 'Albanie', 'DZ' => 'Algérie', 'AD' => 'Andorre', 'AO' => 'Angola',
			'AI' => 'Anguilla', 'DE' => 'Allemagne', 'AQ' => 'Antarctique', 'AG' => 'Antigua-et-Barbuda', 'SA' => 'Arabie saoudite',
			'AR' => 'Argentine', 'AM' => 'Arménie', 'AW' => 'Aruba', 'AU' => 'Australie', 'AT' => 'Autriche', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas',
			'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbade', 'BE' => 'Belgique', 'BZ' => 'Bélize', 'BJ' => 'Bénin', 'BM' => 'Bermudes',
			'BT' => 'Bhoutan', 'BY' => 'Biélorussie', 'BO' => 'Bolivie', 'BA' => 'Bosnie Herzégovine', 'BW' => 'Botswana', 'BR' => 'Brésil',
			'BN' => 'Brunei Darussalam', 'BG' => 'Bulgarie', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodge', 'CM' => 'Cameroun',
			'CA' => 'Canada', 'CV' => 'Cap Vert', 'VA' => 'Cité du Vatican', 'CL' => 'Chili', 'CN' => 'Chine', 'CO' => 'Colombie', 'KM' => 'Comores',
			'CG' => 'Congo - Brazzaville', 'CD' => 'Congo - Kinshasa', 'CR' => 'Costa Rica', 'KP' => 'Corée du Nord', 'KR' => 'Corée du Sud',
			'CI' => 'Côte d’Ivoire', 'HR' => 'Croatie', 'CU' => 'Cuba', 'CY' => 'Chypre', 'DK' => 'Danemark', 'DJ' => 'Djibouti', 'DM' => 'Dominique',
			'EG' => 'Egypte', 'SV' => 'El Salvador', 'AE' => 'Émirats arabes unis', 'EC' => 'Équateur', 'ER' => 'Érythrée', 'ES' => 'Espagne',
			'EE' => 'Estonie', 'SZ' => 'Eswatini', 'US' => 'États-Unis', 'ET' => 'Ethiopie', 'FJ' => 'Fidji', 'FI' => 'Finlande', 'FR' => 'France',
			'GA' => 'Gabon', 'GM' => 'Gambie', 'GE' => 'Géorgie', 'GS' => 'Géorgie du Sud et les Îles Sandwich du Sud', 'GH' => 'Ghana',
			'GI' => 'Gibraltar', 'GR' => 'Grèce', 'GD' => 'Grenade', 'GL' => 'Groenland', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala',
			'GG' => 'Guernesey', 'GN' => 'Guinée', 'GQ' => 'Guinée équatoriale', 'GW' => 'Guinée-Bissau', 'GY' => 'Guyane', 'GF' => 'Guyane française',
			'HT' => 'Haiti', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hongrie', 'BV' => 'Île Bouvet', 'CX' => 'Île Christmas',
			'IM' => 'Île de Man', 'NF' => 'Île Norfolk', 'AX' => 'Îles Åland', 'KY' => 'Îles Caïmans', 'CC' => 'Îles Cocos (Keeling)', 'CK' => 'Îles Cook',
			'FK' => 'Îles Falkland (Malvinas)', 'FO' => 'Îles Féroé', 'HM' => 'Îles Heard et McDonald', 'MP' => 'Îles Mariannes du Nord',
			'MH' => 'Îles Marshall', 'UM' => 'Îles mineures éloignées des États-Unis', 'PN' => 'Îles Pitcairn', 'SB' => 'Îles Salomon',
			'TC' => 'Îles Turks et Caïques', 'VG' => 'Îles Vierges britanniques', 'VI' => 'Îles Vierges des États-Unis', 'IN' => 'Inde',
			'ID' => 'Indonésie', 'IR' => 'Iran', 'IQ' => 'Irak', 'IE' => 'Irlande', 'IS' => 'Islande', 'IL' => 'Israël', 'IT' => 'Italie',
			'JM' => 'Jamaïque', 'JP' => 'Japon', 'JE' => 'Jersey', 'JO' => 'Jordanie', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati',
			'KW' => 'Koweit', 'KG' => 'Kirghizistan', 'LA' => 'Laos', 'LS' => 'Lesotho', 'LV' => 'Lettonie', 'LB' => 'Liban', 'LR' => 'Libéria',
			'LY' => 'Libye', 'LI' => 'Liechtenstein', 'LT' => 'Lituanie', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macédoine du Nord',
			'MG' => 'Madagascar', 'MY' => 'Malaisie', 'MW' => 'Malawi', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malte', 'MQ' => 'Martinique',
			'MU' => 'Maurice', 'MR' => 'Mauritanie', 'YT' => 'Mayotte', 'MX' => 'Mexique', 'FM' => 'Micronésie', 'MD' => 'Moldavie', 'MC' => 'Monaco',
			'MN' => 'Mongolie', 'ME' => 'Monténégro', 'MS' => 'Montserrat', 'MA' => 'Maroc', 'MZ' => 'Mozambique', 'MM' => 'Myanmar (Birmanie)',
			'NA' => 'Namibie', 'NR' => 'Nauru', 'NP' => 'Népal', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niué', 'NO' => 'Norvège',
			'NC' => 'Nouvelle-Calédonie', 'NZ' => 'Nouvelle-Zélande', 'OM' => 'Oman', 'UG' => 'Ouganda', 'UZ' => 'Ouzbékistan', 'PK' => 'Pakistan',
			'PW' => 'Palaos', 'PA' => 'Panama', 'PG' => 'Papouasie Nouvelle Guinée', 'PY' => 'Paraguay', 'NL' => 'Pays-Bas', 'PE' => 'Pérou',
			'PH' => 'Philippines', 'PL' => 'Pologne', 'PF' => 'Polynésie française', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar',
			'CF' => 'République centrafricaine', 'DO' => 'République dominicaine', 'RE' => 'Réunion', 'RO' => 'Roumanie', 'GB' => 'Royaume-Uni',
			'RU' => 'Russie', 'RW' => 'Rwanda', 'EH' => 'Sahara occidental', 'BL' => 'Saint-Barthélemy', 'KN' => 'Saint-Kitts-et-Nevis',
			'MF' => 'Saint-Martin', 'PM' => 'Saint-Pierre-et-Miquelon', 'VC' => 'Saint-Vincent et les Grenadines', 'SH' => 'Sainte-Hélène',
			'LC' => 'Sainte-Lucie', 'WS' => 'Samoa', 'AS' => 'Samoa américaines', 'SM' => 'San Marin', 'ST' => 'Sao Tomé-et-Principe', 'SN' => 'Sénégal',
			'RS' => 'Serbie', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapour', 'SK' => 'Slovaquie', 'SI' => 'Slovénie', 'SO' => 'Somalie',
			'LK' => 'Sri Lanka', 'SD' => 'Soudan', 'SR' => 'Suriname', 'SE' => 'Suède', 'CH' => 'Suisse', 'SJ' => 'Svalbard et Jan Mayen', 'SY' => 'Syrie',
			'TJ' => 'Tadjikistan', 'TW' => 'Taiwan', 'TZ' => 'Tanzanie', 'TD' => 'Tchad', 'CZ' => 'Tchéquie',
			'TF' => 'Terres australes et antarctiques françaises', 'IO' => 'Territoire britannique de l\'océan Indien', 'PS' => 'Territoires palestiniens',
			'TH' => 'Thaïlande', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinité-et-Tobago', 'TN' => 'Tunisie',
			'TM' => 'Turkménistan', 'TR' => 'Turquie', 'TV' => 'Tuvalu', 'UA' => 'Ukraine', 'UY' => 'Uruguay', 'VU' => 'Vanuatu', 'VE' => 'Vénézuela',
			'VN' => 'Vietnam', 'WF' => 'Wallis et Futuna', 'YE' => 'Yémen', 'ZM' => 'Zambie', 'ZW' => 'Zimbabwe'
		];

		foreach ($countries AS $key => $value)
		{
			$return .= '<option value="' . $key . '"' . ($key === $selected ? ' selected' : '') . '>' . $value . '</option>';
		}

		return $return;
	}

	/**
	 * Unicode-safe version of htmlspecialchars().
	 *
	 * @param string $text Text to be made html-safe.
	 * @param boolean $entities Convert entities?
	 *
	 * @return string Text.
	 */
	public static function htmlSpecialCharsUni($text, $entities = true)
	{
		if ($entities)
		{
			$text = preg_replace_callback('/&((#([0-9]+)|[a-z]+);)?/si', array(__CLASS__, 'htmlSpecialCharsUniCallback'), $text);
		}
		else
		{
			$text = preg_replace('/&(?!(#[0-9]+|[a-z]+);)/si', '&amp;', $text);
		}

		$text = str_replace( array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $text);
		$text = str_replace('&lt;br /&gt;', '<br />', $text);
		return $text;
	}

	/**
	 * Callback for htmlSpecialCharsUni.
	 *
	 * @param array $matches Matching parts of the regex.
	 *
	 * @return string Text.
	 */
	protected static function htmlSpecialCharsUniCallback($matches)
	{
		if (count($matches) == 1)
		{
			return '&amp;';
		}

		if (strpos($matches[2], '#') === false)
		{
			// &gt; like
			if ($matches[2] == 'shy')
			{
				return '&shy;';
			}
			else
			{
				return "&amp;$matches[2];";
			}
		}
		else
		{
			// Only convert chars that are in ISO-8859-1
			if (($matches[3] >= 32 AND $matches[3] <= 126) OR ($matches[3] >= 160 AND $matches[3] <= 255))
			{
				return "&amp;#$matches[3];";
			}
			else
			{
				return "&#$matches[3];";
			}
		}
	}
}

?>
