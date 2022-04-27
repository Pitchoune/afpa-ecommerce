<?php

use \Ecommerce\Model\ModelDeliver;

/**
 * Lists all delivers.
 *
 * @return void
 */
function ListDelivers()
{
	if (Utils::cando(18))
	{
		require_once(DIR . '/view/backoffice/ViewDeliver.php');
		ViewDeliver::DeliverList();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des transporteurs.');
	}
}

/**
 * Displays a form to add a new deliver.
 *
 * @return void
 */
function AddDeliver()
{
	if (Utils::cando(19))
	{
		require_once(DIR . '/view/backoffice/ViewDeliver.php');
		ViewDeliver::DeliverAddEdit();
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des trasporteurs.');
	}
}

/**
 * Inserts a new deliver into the database.
 *
 * @return void
 */
function InsertDeliver($name)
{
	if (Utils::cando(19))
	{
		global $config;

		require_once(DIR . '/model/ModelDeliver.php');
		$delivers = new \Ecommerce\Model\ModelDeliver($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

		$delivers->set_name($name);

		if (Utils::cando(21))
		{
			// Do the file upload
			if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
			{
				// Specify the allowed extensions list
				$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];
				require_once(DIR . '/controller/Utils.php');

				// Do the upload
				$upload = Utils::upload($extensions, $_FILES['file'], 'delivers');

				// Do some last stuff if the upload is correctly done
				if ($upload)
				{
					// Save the filename in the database
					$delivers->set_logo($upload);

					// Save the trademark in the database
					if ($delivers->saveNewDeliverWithLogo())
					{
						$_SESSION['deliver']['add'] = 1;
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
				if ($delivers->saveNewDeliverWithoutLogo())
				{
					$_SESSION['deliver']['add'] = 1;
				}
			}
		}
		else
		{
			// Save the trademark in the database
			if ($delivers->saveNewDeliverWithoutLogo())
			{
				$_SESSION['deliver']['add'] = 1;
			}
		}

		// Save is correctly done, redirects to the delivers list
		header('Location: index.php?do=listdelivers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des transporteurs.');
	}
}

/**
 * Displays a form to edit a deliver.
 *
 * @return void
 */
function EditDeliver($id)
{
	if (Utils::cando(20))
	{
		require_once(DIR . '/view/backoffice/ViewDeliver.php');
		ViewDeliver::DeliverAddEdit($id);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des transporteurs.');
	}
}

/**
 * Updates the given deliver into the database.
 *
 * @return void
 */
function UpdateDeliver($id, $name)
{
	if (Utils::cando(20))
	{
		global $config;

		require_once(DIR . '/model/ModelDeliver.php');
		$delivers = new \Ecommerce\Model\ModelDeliver($config);

		// Verify title
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

		$delivers->set_id($id);
		$delivers->set_name($name);

		if (Utils::cando(21))
		{
			// Do the file upload
			if (($_FILES['file']['error'] > 0 AND $_FILES['file']['error'] != 4) OR $_FILES['file']['error'] == 0)
			{
				// Delete the previous file
				$deliverinfo = $delivers->listDeliverInfos($id);
				$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . $deliverinfo['logo'];
				unlink($targetFile);

				// Specify the allowed extensions list
				$extensions = ['.apng', '.avif', 'gif', 'jpeg', 'jpg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg', 'webp', 'bmp', 'ico', 'cur', 'tif', 'tiff'];
				require_once(DIR . '/controller/Utils.php');

				// Do the upload
				$upload = Utils::upload($extensions, $_FILES['file'], 'delivers');

				// Do some last stuff if the upload is correctly done
				if ($upload)
				{
					// Save the filename in the database
					$delivers->set_logo($upload);

					// Save the $deliver in the database
					if ($delivers->saveEditDeliverWithLogo())
					{
						$_SESSION['deliver']['edit'] = 1;
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
				if ($delivers->saveNewDeliverWithoutLogo())
				{
					$_SESSION['deliver']['edit'] = 1;;
				}
			}
		}
		else
		{
			// Save the $deliver in the database
			if ($delivers->saveEditDeliverWithoutLogo())
			{
				$_SESSION['deliver']['edit'] = 1;
			}
		}

		// Save is correctly done, redirects to the delivers list
		header('Location: index.php?do=listdelivers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des transporteurs.');
	}
}

/**
 * Deletes the given deliver.
 *
 * @param integer $id ID of the deliver to delete.
 *
 * @return void
 */
function DeleteDeliver($id)
{
	if (Utils::cando(22))
	{
		global $config;

		require_once(DIR . '/model/ModelDeliver.php');
		$delivers = new \Ecommerce\Model\ModelDeliver($config);

		$delivers->set_id($id);

		// Delete the file first
		$deliverinfo = $delivers->listDeliverInfos();
		$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'delivers' . DIRECTORY_SEPARATOR . $deliverinfo['logo'];
		unlink($targetFile);

		if ($delivers->deleteDeliver())
		{
			$_SESSION['deliver']['delete'] = 1;
		}

		// Save is correctly done, redirects to the delivers list
		header('Location: index.php?do=listdelivers');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des transporteurs.');
	}
}

?>