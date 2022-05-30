<?php

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
 * @param integer $parent ID of the parent.
 *
 * @return void
 */
function InsertCategory($title, $parent)
{
	if (Utils::cando(10))
	{
		global $config;

		$title = trim(strval($title));
		$parent = intval($parent);

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

		if ($parent === 0)
		{
			$categories->set_parentid('null');
		}
		else
		{
			$categories->set_parentid($parent);
		}

		// Save the new category in the database
		if ($categories->saveNewCategory())
		{
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
 * @param integer $parent ID of the parent.
 *
 * @return void
 */
function UpdateCategory($id, $title, $parent)
{
	if (Utils::cando(11))
	{
		global $config;

		$title = trim(strval($title));
		$parent = intval($parent);

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

		if ($parent === 0)
		{
			$categories->set_parentid(null);
		}
		else
		{
			$categories->set_parentid($parent);
		}

		// Save the new category in the database
		if ($categories->saveEditCategory())
		{
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

function DeleteCategory($id)
{
	if (Utils::cando(12))
	{
		global $config;

		$id = intval($id);

		require_once(DIR . '/view/backoffice/ViewCategory.php');
		ViewCategory::CategoryDeleteConfirmation($id);
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

?>