<?php
/**
 * Plugin Name: WP Get Directions
 * Description: Provides an input where your customers can enter any location and get real-time directions on Google Maps to your business/location.
 * Version: 1.0.1
 * Author: Blaze Concepts
 * Author URI: https://www.blazeconcepts.co.uk/
 * License: GPLv3
 * Text Domain: wp-get-directions
 */

if (!defined('ABSPATH'))
    exit;

// PLUGIN GLOBAL VARIABLES
// Plugin Paths
if (!defined('BLZ_GD_PLUGIN_NAME'))
    define('BLZ_GD_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('BLZ_GD_PLUGIN_DIR'))
    define('BLZ_GD_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . BLZ_GD_PLUGIN_NAME);

// REQUIRES
include_once BLZ_GD_PLUGIN_DIR . '/inc/shortcode.php'; // Shortcode
include_once BLZ_GD_PLUGIN_DIR . '/inc/options.php'; // Options page class


// REGISTER SETTINGS
// Register options page
if (is_admin()) {
    $blz_get_directions_settings_page = new BlzGetDirections();
}

// Add Settings link on Plugins page
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'blz_get_directions_settings_link');
function blz_get_directions_settings_link($links) {
    $settings_link = '<a href="admin.php?page=blz_get_directions">' . __('Settings', 'wp-get-directions') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Set up languages
function blz_get_directions_load_plugin_textdomain() {
    $domain = 'wp-get-directions';
    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    load_plugin_textdomain($domain, FALSE, basename(dirname(__FILE__)) . '/languages/');
}
add_action('init', 'blz_get_directions_load_plugin_textdomain');
