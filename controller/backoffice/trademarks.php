<?php

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
		require_once(DIR . '/view/backoffice/ViewTrademark.php');
		ViewTrademark::TrademarkList();
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
		require_once(DIR . '/view/backoffice/ViewTrademark.php');
		ViewTrademark::TrademarkAddEdit();
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

		$trademarks = new ModelTrademark($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

		$trademarks->set_name($name);

		if (Utils::cando(16))
		{
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
		require_once(DIR . '/view/backoffice/ViewTrademark.php');
		ViewTrademark::TrademarkAddEdit($id);
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
 * Deletes the given trademark.
 *
 * @param integer $id ID of the trademark.
 *
 * @return void
 */
function DeleteTrademark($id)
{
	if (Utils::cando(17))
	{
		global $config;

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