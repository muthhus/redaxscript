<?php

/**
 * fb group install
 */

function fb_group_install()
{
	$query = 'INSERT INTO ' . PREFIX . 'modules (name, alias, author, description, version, status, access) VALUES (\'Facebook group\', \'fb_group\', \'Redaxmedia\', \'Integrates a facebook group\', \'2.0\', 1, 0)';
	mysql_query($query);
}

/**
 * fb group uninstall
 */

function fb_group_uninstall()
{
	$query = 'DELETE FROM ' . PREFIX . 'modules WHERE alias = \'fb_group\' LIMIT 1';
	mysql_query($query);
}
?>