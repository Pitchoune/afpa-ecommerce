<?php

require_once(DIR . '/view/backoffice/ViewCategory.php');
require_once(DIR . '/model/ModelCategory.php');
use \Ecommerce\Model\ModelCategory;

/**
 * Lists all categories.
 *
 * @return void
 */
function ListCategories()
{
	if (!Utils::cando(9))
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des catégories.');
	}

	global $config;

	$categories = new ModelCategory($config);

	$categorieslist = $categories->listAllCategories();
	$cache = Utils::categoriesCache($categorieslist);
	$categorylist = Utils::constructCategoryChooserOptions($cache, false);

	ViewCategory::CategoryList($categories, $categorieslist, $categorylist);
}

/**
 * Displays a form to add a new category.
 *
 * @return void
 */
function AddCategory()
{
	if (!Utils::cando(10))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des catégories.');
	}

	global $config;

	$categories = new ModelCategory($config);

	$categoryinfos = [
		'nom' => '',
		'displayorder' => 1
	];

	$pagetitle = 'Gestion des catégories';
	$navtitle = 'Ajouter une catégorie';
	$formredirect = 'insertcategory';

	$navbits = [
		'listcategories' => $pagetitle,
		'' => $navtitle
	];

	// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
	$catlist = $categories->listAllCategories();
	$cache = Utils::categoriesCache($catlist);
	$categorylist = Utils::constructCategoryChooserOptions($cache);
	$categoriesselect = Utils::constructCategorySelectOptions($categorylist, $categoryinfos['parent_id']);

	ViewCategory::CategoryAddEdit('', $navtitle, $navbits, $categoryinfos, $categoriesselect, $formredirect, $pagetitle);
}

/**
 * Inserts a new category into the database.
 *
 * @param string $title Title of the category.
 * @param string $parent ID of the parents. Valid values: -1 (string) or any unsigned integer.
 * @param integer $displayorder Display order of the category.
 *
 * @return void
 */
function InsertCategory($title, $parent, $displayorder)
{
	if (!Utils::cando(10))
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des catégories.');
	}

	$title = trim(strval($title));

	if ($parent === '-1')
	{
		$parent = trim(strval($parent));
	}
	else
	{
		$parent = intval($parent);
	}

	$displayorder = intval($displayorder);

	// Validate title
	$validmessage = Utils::datavalidation($title, 'title', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate displayorder
	$validmessage = Utils::datavalidation($displayorder, 'displayorder');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	global $config;

	$categories = new ModelCategory($config);
	$categories->set_name($title);

	// Verify category parent
	$cats = $categories->listAllCategories();
	$categoryCache = Utils::categoriesCache($cats);

	if (count($categoryCache) > 0)
	{
		if (!isset($categoryCache["$parent"]) AND $parent != '-1')
		{
			throw new Exception('La catégorie parente spécifiée n\'est pas valide.');
		}
	}

	$categories->set_parentid($parent);
	$categories->set_displayorder($displayorder);

	// Save the new category in the database
	if ($categories->saveNewCategory())
	{
		// You need to do again listAllCategories method with updated values
		$cats = $categories->listAllCategories();
		$categoryCache = Utils::categoriesCache($cats);
		$parentCache = Utils::buildParentCache($categoryCache);
		Utils::buildCategoryGenealogy($categoryCache, $parentCache);

		$_SESSION['category']['add'] = 1;
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('La catégorie n\'a pas été ajoutée.');
	}
}

/**
 * Displays a form to edit a category.
 *
 * @param integer $id ID of the category to edit.
 *
 * @return void
 */
function EditCategory($id)
{
	if (!Utils::cando(11))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des catégories.');
	}

	$id = intval($id);

	global $config;

	$categories = new ModelCategory($config);

	$categories->set_id($id);
	$categoryinfos = $categories->listCategoryInfos();

	if (!$categoryinfos)
	{
		throw new Exception('La catégorie n\'existe pas.');
	}

	$pagetitle = 'Gestion des catégories';
	$navtitle = 'Modifier une catégorie';
	$formredirect = 'updatecategory';
	$compteur = $categories->getNumberOfProductsInCategory();
	$categoryinfos['compteur'] = $compteur['compteur'];

	$navbits = [
		'listcategories' => $pagetitle,
		'' => $navtitle
	];

	// Create a sort of cache to autobuild categories with depth status to have parent and child categories in the whole system
	$catlist = $categories->listAllCategories();
	$cache = Utils::categoriesCache($catlist);
	$categorylist = Utils::constructCategoryChooserOptions($cache);
	$categoriesselect = Utils::constructCategorySelectOptions($categorylist, $categoryinfos['parent_id']);

	ViewCategory::CategoryAddEdit($id, $navtitle, $navbits, $categoryinfos, $categoriesselect, $formredirect, $pagetitle);
}

/**
 * Updates the given category into the database.
 *
 * @param integer $id ID of the category to update.
 * @param string $title Title of the category to update.
 * @param integer $parent ID of the parent.
 * @param integer $displayorder Display order of the category.
 *
 * @return void
 */
function UpdateCategory($id, $title, $parent, $displayorder)
{
	if (!Utils::cando(11))
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des catégories.');
	}

	$title = trim(strval($title));

	if ($parent === '-1')
	{
		$parent = trim(strval($parent));
	}
	else
	{
		$parent = intval($parent);
	}

	$displayorder = intval($displayorder);

	// Validate title
	$validmessage = Utils::datavalidation($title, 'title', 'Les caractères suivants sont autorisés :<br /><br />- Lettres<br />- Chiffres<br />- -');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	// Validate displayorder
	$validmessage = Utils::datavalidation($displayorder, 'displayorder');

	if ($validmessage)
	{
		throw new Exception($validmessage);
	}

	global $config;

	$categories = new ModelCategory($config);
	$categories->set_id($id);
	$categories->set_name($title);

	// Verify category parent
	$cats = $categories->listAllCategories();
	$categoryCache = Utils::categoriesCache($cats);

	if (count($categoryCache) > 0 AND $parent !== 0)
	{
		if (!isset($categoryCache["$parent"]) AND $parent !== '-1')
		{
			throw new Exception('La catégorie parente spécifiée n\'est pas valide.');
		}
	}

	$categories->set_parentid($parent);
	$categories->set_displayorder($displayorder);

	// Save the new category in the database
	if ($categories->saveEditCategory())
	{
		$categoryCache = Utils::categoriesCache($cats);
		$parentCache = Utils::buildParentCache($categoryCache);
		Utils::buildCategoryGenealogy($categoryCache, $parentCache);

		$_SESSION['category']['edit'] = 1;
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('La catégorie n\'a pas été enregistrée.');
	}
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the category to delete.
 *
 * @return void
 */
function DeleteCategory($id)
{
	if (!Utils::cando(12))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des catégories.');
	}

	global $config;

	$id = intval($id);

	$categories = new ModelCategory($config);

	$categories->set_id($id);
	$category = $categories->listCategoryInfos();

	if (!$category)
	{
		throw new Exception('La catégorie n\'existe pas.');
	}

	ViewCategory::CategoryDeleteConfirmation($id, $category);
}

/**
 * Deletes the given category.
 *
 * @param integer $id ID of the category to delete.
 *
 * @return void
 */
function KillCategory($id)
{
	if (!Utils::cando(12))
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des catégories.');
	}

	global $config;

	$id = intval($id);

	$categories = new ModelCategory($config);
	$categories->set_id($id);

	// Delete the category from the database
	if ($categories->deleteCategory())
	{
		$cats = $categories->listAllCategories();

		$categoryCache = Utils::categoriesCache($cats);
		$parentCache = Utils::buildParentCache($categoryCache);
		Utils::buildCategoryGenealogy($categoryCache, $parentCache);

		$_SESSION['category']['delete'] = 1;
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('La catégorie n\'a pas été supprimée.');
	}
}

/**
 * Updates display order for each changed category.
 *
 * @param array $order Array of display orders.
 *
 * @return void
 */
function UpdateCategoriesOrder($order)
{
	global $config;

	$categories = new ModelCategory($config);

	if (is_array($order))
	{
		$listcategories = $categories->listAllCategories();

		foreach ($listcategories AS $key => $value)
		{
			$value['id'] = intval($value['id']);
			$value['displayorder'] = intval($value['displayorder']);

			// Validate displayorder
			$validmessage = Utils::datavalidation($value['displayorder'], 'displayorder');

			if ($validmessage)
			{
				throw new Exception($validmessage);
			}

			if (!isset($order["$value[id]"]))
			{
				continue;
			}

			$displayorder = intval($order["$value[id]"]);

			// Validate displayorder
			$validmessage = Utils::datavalidation($displayorder, 'displayorder');

			if ($validmessage)
			{
				throw new Exception($validmessage);
			}

			if ($value['displayorder'] != $displayorder)
			{
				// update orders
				$categories->set_id($value['id']);
				$categories->set_displayorder($displayorder);

				$categories->UpdateCategoryDisplayOrder();
			}
		}
	}

	$cats = $categories->listAllCategories();

	$categoryCache = Utils::categoriesCache($cats);
	$parentCache = Utils::buildParentCache($categoryCache);
	Utils::buildCategoryGenealogy($categoryCache, $parentCache);

	$_SESSION['category']['orders'] = 1;
	header('Location: index.php?do=listcategories');
}

?>
