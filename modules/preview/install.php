<?php

/**
 * preview install
 *
 * @since 1.2.1
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

function preview_install()
{
	$query = 'INSERT INTO ' . PREFIX . 'modules (name, alias, author, description, version, status, access) VALUES (\'Preview\', \'preview\', \'Redaxmedia\', \'Previews current template\', \'2.0\', 1, 0)';
	mysql_query($query);
}

/**
 * preview uninstall
 *
 * @since 1.2.1
 * @deprecated 2.0
 *
 * @package Redaxscript
 * @category Modules
 * @author Henry Ruhs
 */

function preview_uninstall()
{
	$query = 'DELETE FROM ' . PREFIX . 'modules WHERE alias = \'preview\' LIMIT 1';
	mysql_query($query);
}
?>