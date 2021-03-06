<?php

/**
 * admin panel list
 *
 * @since 1.2.1
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Admin
 * @author Henry Ruhs
 */

function admin_panel_list()
{
	hook(__FUNCTION__ . '_start');

	/* define access variables */

	switch (true)
	{
		case CATEGORIES_NEW == 1:
		case CATEGORIES_EDIT == 1:
		case CATEGORIES_DELETE == 1:
			$categories_access = 1;
		case ARTICLES_NEW == 1:
		case ARTICLES_EDIT == 1:
		case ARTICLES_DELETE == 1:
			$articles_access = 1;
		case EXTRAS_NEW == 1:
		case EXTRAS_EDIT == 1:
		case EXTRAS_DELETE == 1:
			$extras_access = 1;
		case COMMENTS_NEW == 1:
		case COMMENTS_EDIT == 1:
		case COMMENTS_DELETE == 1:
			$comments_access = 1;
			$contents_access = 1;
		case USERS_NEW == 1:
		case USERS_EDIT == 1:
		case USERS_DELETE == 1:
			$users_access = 1;
		case GROUPS_NEW == 1:
		case GROUPS_EDIT == 1:
		case GROUPS_DELETE == 1:
			$groups_access = 1;
			$access_access = 1;
		case MODULES_INSTALL == 1:
		case MODULES_EDIT == 1:
		case MODULES_UNINSTALL == 1:
			$modules_access = 1;
		case SETTINGS_EDIT == 1:
			$settings_access = 1;
			$system_access = 1;
			break;
	}

	/* collect contents output */

	if ($contents_access)
	{
		$output = '<li class="js_item_panel_admin item_panel_admin item_contents"><span>' . l('contents') . '</span><ul class="list_panel_children_admin list_contents">';
		if ($categories_access == 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('categories'), 'admin/view/categories') . '</li>';
		}
		if ($articles_access = 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('articles'), 'admin/view/articles') . '</li>';
		}
		if ($extras_access = 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('extras'), 'admin/view/extras') . '</li>';
		}
		if ($comments_access = 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('comments'), 'admin/view/comments') . '</li>';
		}
		$output .= '</ul></li>';
	}

	/* collect access output */

	if ($access_access)
	{
		$output .= '<li class="js_item_panel_admin item_panel_admin item_access"><span>' . l('access') . '</span><ul class="list_panel_children_admin list_access">';
		if (MY_ID)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('profile'), 'admin/edit/users/' . MY_ID) . '</li>';
		}
		if ($users_access == 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('users'), 'admin/view/users') . '</li>';
		}
		if ($groups_access == 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('groups'), 'admin/view/groups') . '</li>';
		}
		$output .= '</ul></li>';
	}
	else if (MY_ID)
	{
		$output .= '<li>' . anchor_element('internal', '', '', l('profile'), 'admin/edit/users/' . MY_ID) . '</li>';
	}

	/* fetch modules list */

	$admin_panel_list_modules = hook('admin_panel_list_modules');

	/* collect system output */

	if ($system_access || $admin_panel_list_modules)
	{
		$output .= '<li class="js_item_panel_admin item_panel_admin item_system"><span>' . l('system') . '</span><ul class="list_panel_children_admin list_stystem">';
		if ($modules_access == 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('modules'), 'admin/view/modules');

			/* collect modules list */

			if ($admin_panel_list_modules)
			{
				$output .= '<ul class="js_list_panel_children_admin list_panel_children_admin">' . $admin_panel_list_modules . '</ul>';
			}
			$output .= '</li>';
		}
		if ($settings_access == 1)
		{
			$output .= '<li>' . anchor_element('internal', '', '', l('settings'), 'admin/edit/settings') . '</li>';
		}
		$output .= '</ul></li>';
	}

	/* collect profile */

	$output .= '<li class="js_item_panel_admin item_panel_admin item_profile">';
	if (MY_USER && MY_ID)
	{
		$output .= anchor_element('internal', '', '', l('profile'), 'admin/edit/users/' . MY_ID);
	}
	else
	{
		$output .= '<span>' . l('profile') . '</span>';
	}
	$output .= '</li>';

	/* collect logout */

	$output .= '<li class="js_item_panel_admin item_panel_admin item_logout">' . anchor_element('internal', '', '', l('logout'), 'logout') . '</li>';

	/* collect list output */

	if ($output)
	{
		$output = '<ul class="js_list_panel_admin list_panel_admin">' . $output . '</ul>';
	}
	echo $output;
	hook(__FUNCTION__ . '_end');
}

/**
 * admin dock
 *
 * @since 1.2.1
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Admin
 * @author Henry Ruhs
 *
 * @param string $table
 * @param integer $id
 * @return string
 */

function admin_dock($table = '', $id = '')
{
	hook(__FUNCTION__ . '_start');

	/* define access variables */

	$edit = constant(strtoupper($table) . '_EDIT');
	$delete = constant(strtoupper($table) . '_DELETE');

	/* collect output */

	if ($edit == 1 || $delete == 1)
	{
		$output = '<div class="wrapper_dock_admin"><div class="js_dock_admin box_dock_admin clear_fix">';
		if ($edit == 1)
		{
			$output .= anchor_element('internal', '', 'js_link_dock_admin link_dock_admin link_unpublish', l('unpublish'), 'admin/unpublish/' . $table . '/' . $id . '/' . TOKEN);
			$output .= '<span class="divider">' . s('divider') . '</span>';
			$output .= anchor_element('internal', '', 'js_link_dock_admin link_dock_admin link_edit', l('edit'), 'admin/edit/' . $table . '/' . $id);
		}
		if ($edit == 1 && $delete == 1)
		{
			$output .= '<span class="divider">' . s('divider') . '</span>';
		}
		if ($delete == 1)
		{
			$output .= anchor_element('internal', '', 'js_confirm js_link_dock_admin link_dock_admin link_delete', l('delete'), 'admin/delete/' . $table . '/' . $id . '/' . TOKEN);
		}
		$output .= '</div></div>';
	}
	return $output;
	hook(__FUNCTION__ . '_end');
}

/**
 * admin notification
 *
 * @since 1.2.1
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Admin
 * @author Henry Ruhs
 */

function admin_notification()
{
	hook(__FUNCTION__ . '_start');

	/* insecure file warning */

	if (MY_ID == 1)
	{
		if (file_exists('install.php'))
		{
			$output = '<div class="box_note note_warning">' . l('file_remove') . l('colon') . ' install.php' . l('point') . '</div>';
		}
		if (is_writable('config.php'))
		{
			$output .= '<div class="box_note note_warning">' . l('file_permission_revoke') . l('colon') . ' config.php' . l('point') . '</div>';
		}
	}
	echo $output;
	hook(__FUNCTION__ . '_end');
}

/**
 * admin control
 *
 * @since 2.0
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Admin
 * @author Henry Ruhs
 *
 * @param string $type
 * @param string $table
 * @param integer $id
 * @param string $alias
 * @param integer $status
 * @param string $new
 * @param string $edit
 * @param string $delete
 * @return string
 */

function admin_control($type = '', $table = '', $id = '', $alias = '', $status = '', $new = '', $edit = '', $delete = '')
{
	hook(__FUNCTION__ . '_start');

	/* define access variables */

	if ($type == 'access' && $id == 1)
	{
		$delete = 0;
	}
	if ($type == 'modules_not_installed')
	{
		$edit = $delete = 0;
	}

	/* collect modules output */

	if ($new == 1 && $type == 'modules_not_installed')
	{
		$output .= '<li class="item_control_admin link_install">' . anchor_element('internal', '', 'install', l('install'), 'admin/install/' . $table . '/' . $alias . '/' . TOKEN) . '</li>';
	}

	/* collect contents output */

	if ($type == 'contents')
	{
		if ($status == 2)
		{
			$output .= '<li class="item_control_admin item_future_posting"><span>' . l('future_posting') . '</span></li>';
		}
		if ($edit == 1)
		{
			if ($status == 1)
			{
				$output .= '<li class="item_control_admin item_unpublish">' . anchor_element('internal', '', '', l('unpublish'), 'admin/unpublish/' . $table . '/' . $id . '/' . TOKEN) . '</li>';
			}
			else if ($status == 0)
			{
				$output .= '<li class="item_control_admin item_publish">' . anchor_element('internal', '', '', l('publish'), 'admin/publish/' . $table . '/' . $id . '/' . TOKEN) . '</li>';
			}
		}
	}

	/* collect access and system output */

	if ($edit == 1 && ($type == 'access' && $id > 1 || $type == 'modules_installed'))
	{
		if ($status == 1)
		{
			$output .= '<li class="item_control_admin item_disable">' . anchor_element('internal', '', '', l('disable'), 'admin/disable/' . $table . '/' . $id . '/' . TOKEN) . '</li>';
		}
		else if ($status == 0)
		{
			$output .= '<li class="item_control_admin item_enable">' . anchor_element('internal', '', '', l('enable'), 'admin/enable/' . $table . '/' . $id . '/' . TOKEN) . '</li>';
		}
	}

	/* collect general edit and delete output */

	if ($edit == 1)
	{
		$output .= '<li class="item_control_admin item_edit">' . anchor_element('internal', '', '', l('edit'), 'admin/edit/' . $table  . '/' . $id) . '</li>';
	}
	if ($delete == 1)
	{
		if ($type == 'modules_installed')
		{
			$output .= '<li class="item_control_admin item_uninstall">' . anchor_element('internal', '', 'js_confirm', l('uninstall'), 'admin/uninstall/' . $table  . '/' . $alias . '/' . TOKEN) . '</li>';
		}
		else
		{
			$output .= '<li class="item_control_admin item_delete">' . anchor_element('internal', '', 'js_confirm', l('delete'), 'admin/delete/' . $table  . '/' . $id . '/' . TOKEN) . '</li>';
		}
	}

	/* collect list output */

	if ($output)
	{
		$output = '<ul class="list_control_admin">' . $output . '</ul>';
	}
	return $output;
	hook(__FUNCTION__ . '_end');
}
?>