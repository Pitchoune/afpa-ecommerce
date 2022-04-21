<?php

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
		require_once(DIR . '/view/backoffice/ViewCategory.php');
		ViewCategory::CategoryList();
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
		require_once(DIR . '/view/backoffice/ViewCategory.php');
		ViewCategory::CategoryAddEdit();
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
 * @param string $parentcategory ID of the parent. Can be -1 if the category is at root level.
 * @param string $status Status ID of the status. It's saved in the db in an enum, so a string is required between 0 and 1.
 *
 * @return void
 */
function InsertCategory($title, $parentcategory, $status)
{
	if (Utils::cando(10))
	{
		global $config;

		require_once(DIR . '/model/ModelCategory.php');
		$categories = new \Ecommerce\Model\ModelCategory($config);

		// Verify title
		if ($title === '')
		{
			throw new Exception('Le titre est vide.');
		}

		// Verify category parent
		$categoryCache = $categories->categoriesCache();

		if (count($categoryCache) > 0)
		{
			if (!isset($categoryCache["$parentcategory"]) AND $parentcategory != '-1')
			{
				throw new Exception('La catégorie parente spécifiée n\'est pas valide.');
			}
		}

		$categories->set_name($title);
		$categories->set_parentid($parentcategory);
		$categories->set_status($status);

		// Save the new category in the database
		$newid = $categories->saveNewCategory();

		if (!$newid)
		{
			throw new Exception('La catégorie n\'a pas été ajoutée.');
		}
		else
		{
			$cats = $categories->listAllCategories();

			$categoryCache = Utils::categoriesCache($cats);
			$parentCache = Utils::buildParentCache($categoryCache);
			Utils::buildCategoryGenealogy($categoryCache, $parentCache);

			$_SESSION['category']['add'] = 1;
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
		require_once(DIR . '/view/backoffice/ViewCategory.php');
		ViewCategory::CategoryAddEdit($id);
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
 * @param string $parentcategory Parent ID of the category to update. Can be -1 if the category is at root level.
 * @param string $status Status ID of the category to update.  It's saved in the db in an enum, so a string is required between 0 and 1.
 *
 * @return void
 */
function UpdateCategory($id, $title, $parentcategory, $status)
{
	if (Utils::cando(11))
	{
		global $config;

		require_once(DIR . '/model/ModelCategory.php');
		$categories = new \Ecommerce\Model\ModelCategory($config);

		// Verify title
		if ($title === '')
		{
			throw new Exception('Le titre est vide.');
		}

		// Verify category parent
		$cats = $categories->listAllCategories();

		$categoryCache = Utils::categoriesCache($cats);

		if (count($categoryCache) > 0 AND $parentcategory !== 0)
		{
			if (!isset($categoryCache["$parentcategory"]) AND $parentcategory !== '-1')
			{
				throw new Exception('La catégorie parente spécifiée n\'est pas valide.');
			}
		}

		$categories->set_id($id);
		$categories->set_name($title);
		$categories->set_parentid($parentcategory);
		$categories->set_status($status);

		// Save the new category in the database
		$newid = $categories->saveEditCategory();

		if (!$newid)
		{
			throw new Exception('La catégorie n\'a pas été enregistrée.');
		}
		else
		{
			$cats = $categories->listAllCategories();

			$categoryCache = Utils::categoriesCache($cats);
			$parentCache = Utils::buildParentCache($categoryCache);
			Utils::buildCategoryGenealogy($categoryCache, $parentCache);

			$_SESSION['category']['edit'] = 1;
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
 * Deletes the given category.
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

		require_once(DIR . '/model/ModelCategory.php');
		$categories = new \Ecommerce\Model\ModelCategory($config);

		$categories->set_id($id);
		$newid = $categories->deleteCategory();

		if (!$newid)
		{
			throw new Exception('La catégorie n\'a pas été supprimée.');
		}
		else
		{
			$cats = $categories->listAllCategories();

			$categoryCache = Utils::categoriesCache($cats);
			$parentCache = Utils::buildParentCache($categoryCache);
			Utils::buildCategoryGenealogy($categoryCache, $parentCache);

			$_SESSION['category']['delete'] = 1;
		}

		// Save is correctly done, redirects to the category list
		header('Location: index.php?do=listcategories');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des catégories.');
	}
}

?>