<?php

/*
Plugin Name:     wp-block-boilerplate
Plugin URI:      https://github.com/RRZE-Webteam/wp-block-boilerplate
Description:     Plugin Description
Version:         1.0.0
Author:          RRZE Webteam
Author URI:      https://blogs.fau.de/webworking/
License:         GNU General Public License v3
License URI:     http://www.gnu.org/licenses/gpl-3.0.html
Domain Path:     /languages
Text Domain:     wp-block-boilerplate
*/

namespace RRZE\WpBlockBoilerplate;

defined('ABSPATH') || exit('No direct script access allowed');

use RRZE\WpBlockBoilerplate\Main;

// Define plugin version requirements.
const RRZE_PHP_VERSION = '8.0';
const RRZE_WP_VERSION = '6.0';
const WPBLOCKBOILERPLATE_VERSION = '1.0.0';

// Autoloads plugin classes.
spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__;
    $base_dir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Register activation and deactivation hooks.
register_activation_hook(__FILE__, __NAMESPACE__ . '\activation');

add_action('plugins_loaded', __NAMESPACE__ . '\loaded');

/**
 * Loads the plugin text domain for translation.
 * @return void
 */
function loadTextdomain()
{
    load_plugin_textdomain('wp-block-boilerplate', false, sprintf('%s/languages/', dirname(plugin_basename(__FILE__))));
}

/**
 * Checks system requirements like PHP and WordPress version.
 * 
 * @return string Error message if requirements are not met.
 */
function systemRequirements()
{
    $error = '';

    if (version_compare(PHP_VERSION, RRZE_PHP_VERSION, '<')) {
        $error = sprintf(__('The server is running PHP version %1$s. The Plugin requires at least PHP version %2$s.', 'wp-block-boilerplate'), PHP_VERSION, RRZE_PHP_VERSION);
    } elseif (version_compare($GLOBALS['wp_version'], RRZE_WP_VERSION, '<')) {
        $error = sprintf(__('The server is running WordPress version %1$s. The Plugin requires at least WordPress version %2$s.', 'wp-block-boilerplate'), $GLOBALS['wp_version'], RRZE_WP_VERSION);
    }

    return $error;
}

/**
 * Plugin activation callback
 */
function activation()
{
    loadTextdomain();

    if ($error = systemRequirements()) {
        deactivate_plugins(plugin_basename(__FILE__), false, true);
        wp_die($error);
    }
}

/**
 * Plugin loaded actions including system requirement checks and initialization.
 * @return void
 */
function loaded()
{
    loadTextdomain();

    if ($error = systemRequirements()) {
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data(__FILE__);
        $plugin_name = $plugin_data['Name'];
        $tag = is_network_admin() ? 'network_admin_notices' : 'admin_notices';
        add_action($tag, function () use ($plugin_name, $error) {
            printf('<div class="notice notice-error"><p>%1$s: %2$s</p></div>', esc_html($plugin_name), esc_html($error));
        });
    } else {
        new Main(__FILE__);
    }
}
