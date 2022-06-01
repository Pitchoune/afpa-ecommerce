<?php

require_once(DIR . '/view/backoffice/ViewRole.php');
require_once(DIR . '/model/ModelRole.php');
use \Ecommerce\Model\ModelRole;

/**
 * Lists all roles.
 *
 * @return void
 */
function ListRoles()
{
	if (Utils::cando(1))
	{
		global $config;

		$roles = new ModelRole($config);

		$totalroles = $roles->getTotalNumberOfRoles();

		// Number max per page
		$perpage = 10;
		$limitlower = Utils::define_pagination_values($totalroles['nbroles'], $pagenumber, $perpage);

		$roleslist = $roles->getSomeRoles($limitlower, $perpage);

		ViewRole::RoleList($roles, $roleslist, $totalroles, $limitlower, $perpage);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à afficher la liste des rôles.');
	}
}

/**
 * Displays a form to add a new role.
 *
 * @return void
 */
function AddRole()
{
	if (Utils::cando(2))
	{
		global $config;

		$roles = new ModelRole($config);

		$roleinfos = [
			'nom' => ''
		];

		$pagetitle = 'Gestion des rôles';
		$navtitle = 'Ajouter un rôle';
		$formredirect = 'insertrole';

		$navbits = [
			'index.php?do=listroles' => $pagetitle,
			'' => $navtitle
		];

		ViewRole::RoleAddEdit('', $navtitle, $navbits, $roleinfos, $formredirect, $pagetitle);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des rôles.');
	}
}

/**
 * Inserts a new role into the database.
 *
 * @param string $name Name of the role.
 *
 * @return void
 */
function InsertRole($name)
{
	if (Utils::cando(2))
	{
		global $config;

		$name = trim(strval($name));

		$roles = new ModelRole($config);

		// Verify name
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

		$roles->set_name($name);

		// Save the new role in the database
		if ($roles->saveNewRole())
		{
			$_SESSION['role']['add'] = 1;
		}

		// Save is correctly done, redirects to the roles list
		header('Location: index.php?do=listroles');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à ajouter des rôles.');
	}
}

/**
 * Displays a form to edit a role.
 *
 * @param integer $id ID of the role.
 *
 * @return void
 */
function EditRole($id)
{
	if (Utils::cando(3))
	{
		global $config;

		$id = intval($id);

		$roles = new ModelRole($config);

		$roles->set_id($id);
		$roleinfos = $roles->listRoleInfos();

		$pagetitle = 'Gestion des rôles';
		$navtitle = 'Modifier un rôle';
		$formredirect = 'updaterole';

		$navbits = [
			'index.php?do=listroles' => $pagetitle,
			'' => $navtitle
		];

		$roles->set_id($id);

		// Build all roles array
		$rolespermslist = $roles->getAllRolePermissions();

		$permissions = [];

		foreach ($rolespermslist AS $key => $value)
		{
			$permissions["$value[module]"]["$value[id]"] = $value['description'];
		}

		// Build employee roles
		$rolepermissions = $roles->getRolePermissions();

		$perms = [];

		foreach ($rolepermissions AS $key => $value)
		{
			$perms["$value[module]"]["$value[id]"] = 1;
		}

		ViewRole::RoleAddEdit($id, $navtitle, $navbits, $roleinfos, $formredirect, $pagetitle, $permissions, $perms);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des rôles.');
	}
}

/**
 * Updates the given role into the database.
 *
 * @param integer $id ID of the role.
 * @param string $name Name of the role.
 *
 * @return void
 */
function UpdateRole($id, $name)
{
	if (Utils::cando(3))
	{
		global $config;

		$id = intval($id);
		$name = trim(strval($name));

		$roles = new ModelRole($config);

		// Verify title
		if ($name === '')
		{
			throw new Exception('Le nom est vide.');
		}

		$roles->set_id($id);
		$roles->set_name($name);

		// Save the role in the database
		if ($roles->saveEditRole())
		{
			$_SESSION['role']['edit'] = 1;
		}

		// Save is correctly done, redirects to the roles list
		header('Location: index.php?do=listroles');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier des rôles.');
	}
}

/**
 * Updates the role permissions.
 *
 * @param integer $id ID of the role.
 * @param array $permissions Permission values of the role.
 *
 * @return void
 */
function UpdateRolePerms($id, $permissions)
{
	global $config;

	$id = intval($id);

	(is_array($permissions) ? $permissions : []);

	// Only the superadmin can edit roles, it's role ID is to be specified in the config.php file for $config['Misc']['superadminid']
	// This condition different than all other is to prevent to be locked out and no one can edit them later
	if ($config['Misc']['superadminid'] == $_SESSION['employee']['roleid'])
	{
		$roles = new ModelRole($config);

		// Delete all roles from the given role
		$roles->set_id($id);
		$roles->deleteAllRolePerms();

		// Perform the permissions now
		foreach ($permissions AS $key => $value)
		{
			// Now add all roles with $value === 1
			if ($value === 1)
			{
				$roles->set_id($key);
				$roles->set_perms($id);
				$roles->insertRolePerm();
			}
		}

		$_SESSION['role']['editperm'] = 1;

		// Save is correctly done, redirects to the roles list
		header('Location: index.php?do=listroles');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à modifier les permissions des rôles.');
	}
}

/**
 * Displays a delete confirmation.
 *
 * @param integer $id ID of the role to delete.
 *
 * @return void
 */
function DeleteRole($id)
{
	if (Utils::cando(4))
	{
		global $config;

		$roles = new ModelRole($config);

		$id = intval($id);

		$roles->set_id($id);
		$role = $roles->listRoleInfos();

		ViewRole::RoleDeleteConfirmation($id, $role);
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des rôles.');
	}
}

/**
 * Deletes the given role.
 *
 * @param integer $id ID of the role.
 *
 * @return void
 */
function KillRole($id)
{
	if (Utils::cando(4))
	{
		global $config;

		$id = intval($id);

		$roles = new ModelRole($config);

		$count = $roles->getTotalNumberOfRoles();

		// Don't delete the super admin defined in the config.php file
		if ($config['Misc']['superadminid'] == $_SESSION['user']['roleid'])
		{
			throw new Exception('Vous ne pouvez pas supprimer ce rôle. Veuillez modifier la valeur de la variable $config[\'Misc\'][\'superadminid\'] avant de recommencer.');
		}

		// Don't delete the latest role, which should be the highest power level of the system
		if ($count === 1)
		{
			throw new Exception('Vous ne pouvez pas supprimer le dernier rôle du système. Veuillez en créer un autre avant de supprimer ce rôle.');
		}

		$roles->set_id($id);

		// Delete all related permission
		$roles->deleteAllRolePerms();

		// Delete now the role itself
		if ($roles->deleteRole())
		{
			$_SESSION['role']['delete'] = 1;
		}

		// Save is correctly done, redirects to the roles list
		header('Location: index.php?do=listroles');
	}
	else
	{
		throw new Exception('Vous n\'êtes pas autorisé à supprimer des rôles.');
	}
}

?>