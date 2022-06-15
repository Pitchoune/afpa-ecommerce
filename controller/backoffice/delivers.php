<?php

require_once(DIR . '/view/backoffice/ViewDeliver.php');
require_once(DIR . '/model/ModelDeliver.php');
use \Ecommerce\Model\ModelDeliver;

/**
 * Lists all delivers.
 *
 * @return void
 */
function ListDelivers()
{
	if (!Utils::cando(18))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des transporteurs.');
	}

	global $config, $pagenumber;

	$delivers = new ModelDeliver($config);
	$totaldelivers = $delivers->getTotalNumberOfDelivers();

	$perpage = 10;
	$limitlower = Utils::define_pagination_values($totaldelivers['nbdelivers'], $pagenumber, $perpage);

	$deliverlist = $delivers->getSomeDelivers($limitlower, $perpage);

	ViewDeliver::DeliverList($delivers, $deliverlist, $totaldelivers, $limitlower, $perpage);
}

/**
 * Displays a form to add a new deliver.
 *
 * @return void
 */
function AddDeliver()
{
	if (!Utils::cando(19))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des transporteurs.');
	}

	global $config;

	$delivers = new ModelDeliver($config);

	$deliverinfos = [
		'nom' => ''
	];

	$pagetitle = 'Gestion des transporteurs';
	$navtitle = 'Ajouter un transporteur';
	$formredirect = 'insertdeliver';

	$navbits = [
		'listdelivers' => $pagetitle,
		'' => $navtitle
	];

	ViewDeliver::DeliverAddEdit($navtitle, $navbits, $deliverinfos, $formredirect, $pagetitle);
}

/**
 * Inserts a new deliver into the database.
 *
 * @param string $name Name of the deliver.
 *
 * @return void
 */
function InsertDeliver($name)
{
	if (!Utils::cando(19))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des transporteurs.');
	}

	global $config;

	$name = trim(strval($name));

	$delivers = new ModelDeliver($config);

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	$delivers->set_name($name);

	if (Utils::cando(21))
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

/**
 * Displays a form to edit a deliver.
 *
 * @param integer $id ID of the deliver to edit.
 *
 * @return void
 */
function EditDeliver($id)
{
	if (!Utils::cando(20))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des transporteurs.');
	}

	global $config;

	$delivers = new ModelDeliver($config);

	$id = intval($id);

	$delivers->set_id($id);
	$deliverinfos = $delivers->listDeliverInfos();

	if (!$deliverinfos)
	{
		throw new Exception('Le transporteur n\'existe pas.');
	}

	$pagetitle = 'Gestion des transporteurs';
	$navtitle = 'Modifier un transporteur';
	$formredirect = 'updatedeliver';

	$navbits = [
		'listdelivers' => $pagetitle,
		'' => $navtitle
	];

	ViewDeliver::DeliverAddEdit($navtitle, $navbits, $deliverinfos, $formredirect, $pagetitle, $id);
}

/**
 * Updates the given deliver into the database.
 *
 * @param integer $id ID of the deliver.
 * @param string $name Name of the deliver.
 *
 * @return void
 */
function UpdateDeliver($id, $name)
{
	if (!Utils::cando(20))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des transporteurs.');
	}

	global $config;

	$id = intval($id);
	$name = trim(strval($name));

	$delivers = new ModelDeliver($config);

	// Validate name
	$validmessage = Utils::datavalidation($name, 'name', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	$delivers->set_id($id);
	$delivers->set_name($name);

	if (Utils::cando(21))
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

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the deliver to delete.
 *
 * @return void
 */
function DeleteDeliver($id)
{
	if (!Utils::cando(22))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des transporteurs.');
	}

	global $config;

	$id = intval($id);

	$delivers = new ModelDeliver($config);

	$delivers->set_id($id);
	$deliver = $delivers->listDeliverInfos();

	if (!$deliver)
	{
		throw new Exception('Le transporteur n\'existe pas.');
	}

	ViewDeliver::DeliverDeleteConfirmation($id, $deliver);
}

/**
 * Deletes the given deliver.
 *
 * @param integer $id ID of the deliver to delete.
 *
 * @return void
 */
function KillDeliver($id)
{
	if (Utils::cando(22))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des transporteurs.');
	}

	global $config;

	$id = intval($id);

	$delivers = new ModelDeliver($config);

	$delivers->set_id($id);

	// Delete the file first
	$deliverinfo = $delivers->listDeliverInfos();

	if (!$deliverinfo)
	{
		throw new Exception('Le transporteur n\'existe pas.');
	}

	$targetFile =  str_replace('/admin/..', '', DIR) . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'delivers' . DIRECTORY_SEPARATOR . $deliverinfo['logo'];
	unlink($targetFile);

	if ($delivers->deleteDeliver())
	{
		$_SESSION['deliver']['delete'] = 1;
		header('Location: index.php?do=listdelivers');
	}
}

?>
