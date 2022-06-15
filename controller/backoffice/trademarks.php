<?php

require_once(DIR . '/view/backoffice/ViewTrademark.php');
require_once(DIR . '/model/ModelTrademark.php');
use \Ecommerce\Model\ModelTrademark;

/**
 * Lists all trademarks.
 *
 * @return void
 */
function ListTrademarks()
{
	if (!Utils::cando(13))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des marques.');
	}

	global $config, $pagenumber;

	$trademarks = new ModelTrademark($config);
	$totaltrademarks = $trademarks->getTotalNumberOfTrademarks();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totaltrademarks['nbtrademarks'], $pagenumber, $perpage);

	$trademarkslist = $trademarks->getSomeTrademarks($limitlower, $perpage);

	ViewTrademark::TrademarkList($trademarks, $trademarkslist, $totaltrademarks, $limitlower, $perpage);
}

/**
 * Displays a form to add a new trademark.
 *
 * @return void
 */
function AddTrademark()
{
	if (!Utils::cando(14))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des marques.');
	}

	global $config;

	$trademarks = new ModelTrademark($config);

	$trademarkinfos = [
		'nom' => ''
	];

	$pagetitle = 'Gestion des marques';
	$navtitle = 'Ajouter une marque';
	$formredirect = 'inserttrademark';

	$navbits = [
		'index.php?do=listtrademarks' => $pagetitle,
		'' => $navtitle
	];

	ViewTrademark::TrademarkAddEdit($navtitle, $navbits, $trademarkinfos, $formredirect, $pagetitle);
}

/**
 * Inserts a new trademark into the database.
 *
 * @param string $name Name of the trademark.
 *
 * @return void
 */
function InsertTrademark($name)
{
	if (!Utils::cando(14))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des marques.');
	}

	$name = trim(strval($name));

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	global $config;

	$trademarks = new ModelTrademark($config);
	$trademarks->set_name($name);

	if (Utils::cando(16))
	{
		// $_FILES validation
		if (is_array($_FILES['file']))
		{
			if (is_array($_FILES['file']['name']))
			{
				$files = count($_FILES['file']['name']);

				for ($index = 0; $index < $files; $index++)
				{
					$_FILES['file']['name']["$index"] = trim(strval($_FILES['file']['name']["$index"]));
					$_FILES['file']['type']["$index"] = trim(strval($_FILES['file']['type']["$index"]));
					$_FILES['file']['tmp_name']["$index"] = trim(strval($_FILES['file']['tmp_name']["$index"]));
					$_FILES['file']['error']["$index"] = intval($_FILES['file']['error']["$index"]);
					$_FILES['file']['size']["$index"] = intval($_FILES['file']['size']["$index"]);
				}
			}
			else
			{
				$_FILES['name'] = trim(strval($_FILES['name']));
				$_FILES['type'] = trim(strval($_FILES['type']));
				$_FILES['tmp_name'] = trim(strval($_FILES['tmp_name']));
				$_FILES['error'] = intval($_FILES['error']);
				$_FILES['size'] = intval($_FILES['size']);
			}
		}

		// Do the file upload
		if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
		{
			// Specify the allowed extensions list
			$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];
			require_once(DIR . '/controller/Utils.php');

			// Do the upload
			$upload = Utils::upload($extensions, $_FILES['file'], 'trademarks');

			// Do some last stuff if the upload is correctly done
			if ($upload)
			{
				// Save the filename in the database
				$trademarks->set_logo($upload);

				// Save the trademark in the database
				if ($trademarks->saveNewTrademarkWithLogo())
				{
					$_SESSION['trademark']['add'] = 1;
				}
			}
			else
			{
				throw new Exception('Une erreur inattendue est survenue pendant l\'upload. Veuillez recommancer.');
			}
		}
		else
		{
			// Save the trademark in the database
			if ($trademarks->saveEditTrademarkWithoutLogo())
			{
				$_SESSION['trademark']['add'] = 1;
			}
		}
	}
	else
	{
		// Save the trademark in the database
		if ($trademarks->saveNewTrademarkWithoutLogo())
		{
			$_SESSION['trademark']['add'] = 1;
		}
	}

	header('Location: index.php?do=listtrademarks');
}

/**
 * Displays a form to edit a trademark.
 *
 * @param integer $id ID of the trademark.
 *
 * @return void
 */
function EditTrademark($id)
{
	if (!Utils::cando(15))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des marques.');
	}

	$id = intval($id);

	global $config;

	$trademarks = new ModelTrademark($config);
	$trademarks->set_id($id);
	$trademarkinfos = $trademarks->listTrademarkInfos();

	if (!$trademarkinfos)
	{
		throw new Exception('La marque n\'existe pas.');
	}

	$pagetitle = 'Gestion des marques';
	$navtitle = 'Modifier une marque';
	$formredirect = 'updatetrademark';

	$navbits = [
		'index.php?do=listtrademarks' => $pagetitle,
		'' => $navtitle
	];

	ViewTrademark::TrademarkAddEdit($navtitle, $navbits, $trademarkinfos, $formredirect, $pagetitle, $id);
}

/**
 * Updates the given trademark into the database.
 *
 * @param integer $id ID of the deliver.
 * @param string $name Name of the deliver.
 *
 * @return void
 */
function UpdateTrademark($id, $name)
{
	if (!Utils::cando(15))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des marques.');
	}

	$id = intval($id);
	$name = trim(strval($name));

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	global $config;

	$trademarks = new ModelTrademark($config);
	$trademarks->set_id($id);
	$trademarks->set_name($name);

	if (Utils::cando(16))
	{
		// $_FILES validation
		if (is_array($_FILES['file']))
		{
			if (is_array($_FILES['file']['name']))
			{
				$files = count($_FILES['file']['name']);

				for ($index = 0; $index < $files; $index++)
				{
					$_FILES['file']['name']["$index"] = trim(strval($_FILES['file']['name']["$index"]));
					$_FILES['file']['type']["$index"] = trim(strval($_FILES['file']['type']["$index"]));
					$_FILES['file']['tmp_name']["$index"] = trim(strval($_FILES['file']['tmp_name']["$index"]));
					$_FILES['file']['error']["$index"] = intval($_FILES['file']['error']["$index"]);
					$_FILES['file']['size']["$index"] = intval($_FILES['file']['size']["$index"]);
				}
			}
			else
			{
				$_FILES['name'] = trim(strval($_FILES['name']));
				$_FILES['type'] = trim(strval($_FILES['type']));
				$_FILES['tmp_name'] = trim(strval($_FILES['tmp_name']));
				$_FILES['error'] = intval($_FILES['error']);
				$_FILES['size'] = intval($_FILES['size']);
			}
		}

		// Do the file upload
		if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
		{
			// Delete the previous file
			$trademarkinfo = $trademarks->listTrademarkInfos($id);
			$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $trademarkinfo['logo'];
			unlink($targetFile);

			// Specify the allowed extensions list
			$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];
			require_once(DIR . '/controller/Utils.php');

			// Do the upload
			$upload = Utils::upload($extensions, $_FILES['file'], 'trademarks');

			// Do some last stuff if the upload is correctly done
			if ($upload)
			{
				// Save the filename in the database
				$trademarks->set_logo($upload);

				// Save the trademark in the database
				if ($trademarks->saveEditTrademarkWithLogo())
				{
					$_SESSION['trademark']['edit'] = 1;
				}
			}
			else
			{
				throw new Exception('Une erreur inattendue est survenue pendant l\'upload. Veuillez recommancer.');
			}
		}
		else
		{
			// Save the trademark in the database
			if ($trademarks->saveEditTrademarkWithoutLogo())
			{
				$_SESSION['trademark']['edit'] = 1;
			}
		}
	}
	else
	{
		// Save the trademark in the database
		if ($trademarks->saveEditTrademarkWithoutLogo())
		{
			$_SESSION['trademark']['edit'] = 1;
		}
	}

	header('Location: index.php?do=listtrademarks');
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the trademark to delete.
 *
 * @return void
 */
function DeleteTrademark($id)
{
	if (!Utils::cando(17))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des marques.');
	}

	$id = intval($id);

	global $config;

	$trademarks = new ModelTrademark($config);
	$trademarks->set_id($id);
	$trademark = $trademarks->listTrademarkInfos();

	if (!$trademark)
	{
		throw new Exception('La marque n\'existe pas.');
	}

	ViewTrademark::TrademarkDeleteConfirmation($id, $trademark);
}

/**
 * Deletes the given trademark.
 *
 * @param integer $id ID of the trademark to delete.
 *
 * @return void
 */
function KillTrademark($id)
{
	if (!Utils::cando(17))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des marques.');
	}

	$id = intval($id);

	global $config;

	$trademarks = new ModelTrademark($config);
	$trademarks->set_id($id);

	$trademarkinfo = $trademarks->listTrademarkInfos();

	if (!$trademarkinfo)
	{
		throw new Exception('La marque n\'existe pas.');
	}

	$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'trademarks' . DIRECTORY_SEPARATOR . $trademarkinfo['logo'];
	unlink($targetFile);

	if ($trademarks->deleteTrademark())
	{
		$_SESSION['trademark']['delete'] = 1;
		header('Location: index.php?do=listtrademarks');
	}
}

?>
