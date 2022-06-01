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
	if (Utils::cando(9))
	{
		global $config;

		$categories = new ModelCategory($config);

		$categorieslist = $categories->listAllCategories();
		$cache = Utils::categoriesCache($categorieslist);
		$categorylist = Utils::constructCategoryChooserOptions($cache, false);

		ViewCategory::CategoryList($categories, $categorieslist, $categorylist);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des catégories.');
	}
}

/**
 * Displays a form to add a new category.
 *
 * @return void
 */
function AddCategory()
{
	if (Utils::cando(10))
	{
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
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des catégories.');
	}
}

/**
 * Inserts a new category into the database.
 *
 * @param string $title Title of the category.
 * @param string $parent ID of the parent.
 * @param integer $displayorder Display order of the category.
 *
 * @return void
 */
function InsertCategory($title, $parent, $displayorder)
{
	if (Utils::cando(10))
	{
		global $config;

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

		$categories = new ModelCategory($config);

		// Verify title
		if ($title === '')
		{
			throw new Exception('Le titre est vide.');
		}

		if (!preg_match('/^[\p{L}\s-]{2,}$/u', $title))
		{
			throw new Exception('L\'intitulé de la catégorie contient des caractères interdits.');
		}

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
		}
		else
		{
			throw new Exception('La catégorie n\'a pas été ajoutée.');
		}

		// Save is correctly done, redirects to the category list
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des catégories.');
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
	if (Utils::cando(11))
	{
		global $config;

		$categories = new ModelCategory($config);

		$categories->set_id($id);
		$categoryinfos = $categories->listCategoryInfos();

		$pagetitle = 'Gestion des catégories';
		$navtitle = 'Modifier une catégorie';
		$formredirect = 'updatecategory';
		$compteur = $categories->getNumberOfProductsInCategory();
		$categoryinfos['compteur'] = $compteur['compteur'];

		if ($categoryinfos)
		{
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
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des catégories.');
	}
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
	if (Utils::cando(11))
	{
		global $config;

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

		$categories = new ModelCategory($config);

		// Verify title
		if ($title === '')
		{
			throw new Exception('Le titre est vide.');
		}

		if (!preg_match('/^[\p{L}\s-]{2,}$/u', $title))
		{
			throw new Exception('L\'intitulé de la catégorie contient des caractères interdits.');
		}

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
		}
		else
		{
			throw new Exception('La catégorie n\'a pas été enregistrée.');
		}

		// Save is correctly done, redirects to the category list
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des catégories.');
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
	if (Utils::cando(12))
	{
		global $config;

		$id = intval($id);

		$categories = new ModelCategory($config);

		$categories->set_id($id);
		$category = $categories->listCategoryInfos();

		ViewCategory::CategoryDeleteConfirmation($id, $category);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des catégories.');
	}
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
	if (Utils::cando(12))
	{
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
		}
		else
		{
			throw new Exception('La catégorie n\'a pas été supprimée.');
		}

		// Save is correctly done, redirects to the category list
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des catégories.');
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
			if (!isset($order["$value[id]"]))
			{
				continuer;
			}

			$displayorder = intval($order["$value[id]"]);

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