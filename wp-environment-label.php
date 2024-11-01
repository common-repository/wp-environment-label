<?php
/**
 * @package WP Environment Label
 * @version 1.0
 */
/*
Plugin Name: WP Environment Label
Description: WP Environment Label - shows label with current server/environment name defined by config or admin-panel
Author: Konrad Wocko
Version: 1.1
License: GPLv2 or later
Text Domain: wp-environment-label
*/

require_once(plugin_dir_path(__FILE__) . 'classes/EnvironmentLabel.php');

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
	//this php version is too old
	add_action('admin_notices', ['EnvironmentLabel', 'php_version_too_old_message']);
	return;
}

if (version_compare(get_bloginfo('version'), '4.7', '<')) {
	//this wordpress version is too old
	add_action('admin_notices', ['EnvironmentLabel', 'wordpress_version_too_old_message']);
	return;
}

if (!wp_doing_ajax()) {
	add_action('init', ['EnvironmentLabel', 'init']);
}

register_activation_hook(__FILE__, ['EnvironmentLabel', 'onActivate']);
register_deactivation_hook(__FILE__, ['EnvironmentLabel', 'onDeactivate']);