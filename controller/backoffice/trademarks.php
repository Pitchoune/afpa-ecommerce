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
	if (Utils::cando(13))
	{
		global $config, $pagenumber;

		$trademarks = new ModelTrademark($config);
		$totaltrademarks = $trademarks->getTotalNumberOfTrademarks();

		$perpage = 10;
		$limitlower = Utils::define_pagination_values($totaltrademarks['nbtrademarks'], $pagenumber, $perpage);

		$trademarkslist = $trademarks->getSomeTrademarks($limitlower, $perpage);

		ViewTrademark::TrademarkList($trademarks, $trademarkslist, $totaltrademarks, $limitlower, $perpage);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à affichier la liste des marques.');
	}
}

/**
 * Displays a form to add a new trademark.
 *
 * @return void
 */
function AddTrademark()
{
	if (Utils::cando(14))
	{
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

		ViewTrademark::TrademarkAddEdit('', $navtitle, $navbits, $trademarkinfos, $formredirect, $pagetitle);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des marques.');
	}
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
	if (Utils::cando(14))
	{
		global $config;

		$name = trim(strval($name));

		$trademarks = new ModelTrademark($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

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

		// Save is correctly done, redirects to the trademarks list
		header('Location: index.php?do=listtrademarks');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des marques.');
	}
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
	if (Utils::cando(15))
	{
		global $config;

		$trademarks = new ModelTrademark($config);

		$id = intval($id);

		$trademarks->set_id($id);
		$trademarkinfos = $trademarks->listTrademarkInfos();

		$pagetitle = 'Gestion des marques';
		$navtitle = 'Modifier une marque';
		$formredirect = 'updatetrademark';

		$navbits = [
			'index.php?do=listtrademarks' => $pagetitle,
			'' => $navtitle
		];

		ViewTrademark::TrademarkAddEdit($id, $navtitle, $navbits, $trademarkinfos, $formredirect, $pagetitle);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des marques.');
	}
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
	if (Utils::cando(15))
	{
		global $config;

		$id = intval($id);
		$name = trim(strval($name));

		$trademarks = new ModelTrademark($config);

		// Verify title
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

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

		// Save is correctly done, redirects to the trademarks list
		header('Location: index.php?do=listtrademarks');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des marques.');
	}
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
	if (Utils::cando(17))
	{
		global $config;

		$trademarks = new ModelTrademark($config);

		$id = intval($id);

		$trademarks->set_id($id);
		$trademark = $trademarks->listTrademarkInfos();

		ViewTrademark::TrademarkDeleteConfirmation($id, $trademark);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des marques.');
	}
}

/**
 * Deletes the given trademark.
 *
 * @param integer $id ID of the trademark.
 *
 * @return void
 */
function KillTrademark($id)
{
	if (Utils::cando(17))
	{
		global $config;

		$id = intval($id);

		$trademarks = new ModelTrademark($config);
		$trademarks->set_id($id);

		// Delete the file first
		$trademarkinfo = $trademarks->listTrademarkInfos();
		$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'trademarks' . DIRECTORY_SEPARATOR . $trademarkinfo['logo'];
		unlink($targetFile);

		if ($trademarks->deleteTrademark())
		{
			$_SESSION['trademark']['delete'] = 1;
		}

		// Save is correctly done, redirects to the trademarks list
		header('Location: index.php?do=listtrademarks');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des marques.');
	}
}

?>