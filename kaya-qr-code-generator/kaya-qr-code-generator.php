<?php
/*
 * Plugin Name: Kaya QR Code Generator
 * Description: Generate QR codes using shortcodes, the Gutenberg block or widget, with no third-party services or dependencies.
 * Tags: QR Code, qrcode, QR, QR Code Generator, Shortcode
 * Author: Kaya Studio
 * Author URI:  https://kayastudio.fr
 * Donate link: https://dotkaya.org/a-propos/
 * Contributors: kayastudio
 * Requires at least: 5.0.0
 * Tested up to: 7.1
 * Stable tag: 1.7.2
 * Version: 1.7.2
 * Requires PHP: 5.4
 * Text Domain: kaya-qr-code-generator
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly
}

if (!defined('WPKQCG_VERSION'))				define('WPKQCG_VERSION', '1.7.2');
if (!defined('WPKQCG_FILE'))				define('WPKQCG_FILE', plugin_basename(__FILE__));
if (!defined('WPKQCG_PLUGIN_URL'))			define('WPKQCG_PLUGIN_URL', plugin_dir_url(__FILE__));
if (!defined('WPKQCG_PLUGIN_PATH'))			define('WPKQCG_PLUGIN_PATH', plugin_dir_path(__FILE__));
if (!defined('WPKQCG_QRCODE_GENERATOR_DB'))	define('WPKQCG_QRCODE_GENERATOR_DB', 'wpkqcg_qrcode_generator');

// Include the main functions
require_once(WPKQCG_PLUGIN_PATH . 'lib/functions.php');
// Include the forms class.
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.forms.php');
// Include the QRCode forms class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.forms_qrcode.php');
// Include the Shortcodes class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.shortcodes_qrcodeshortcode.php');
// Include the Widgets class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.widgets_qrcodewidget.php');
// Include the Metabox class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.metabox_qrcodemetabox.php');

// Include Kaya Studio Admin Dashboard class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.admin_dashboard_kayastudio.php');
// Include Kaya Studio Admin Plugins Dashboard class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.admin_dashboard_kayastudio_plugins.php');
// Include Kaya QR Code Generator Dashboard class
require_once(WPKQCG_PLUGIN_PATH . 'lib/class.admin_dashboard_wpkqcg.php');

// Include the main admin functions
require_once(WPKQCG_PLUGIN_PATH . 'lib/functions-admin.php');

/**
 * Load Localisation files.
 *
 * @since 1.0.1
 */
function wpkqcg_plugin_loadLocalisation()
{
	load_plugin_textdomain('kaya-qr-code-generator', false, dirname(WPKQCG_FILE) . '/languages/');
}
add_action('plugins_loaded', 'wpkqcg_plugin_loadLocalisation');


/**
 * Install database setup on plugin activation.
 *
 * @since 1.5.0
 */
function wpkqcg_plugin_doActivation()
{
	require_once(WPKQCG_PLUGIN_PATH . 'lib/functions-database.php');
	wpkqcg_database_installSetup();
}
register_activation_hook(__FILE__, 'wpkqcg_plugin_doActivation');


/**
 * Install database setup on new site creation in multisite.
 *
 * @param WP_Site $new_site New site object.
 *
 * @since 1.5.0
 */
function wpkqcg_plugin_doNewSite($new_site)
{
	require_once(WPKQCG_PLUGIN_PATH . 'lib/functions-database.php');
	wpkqcg_database_installSetupNewSite($new_site);
}
add_action('wp_initialize_site', 'wpkqcg_plugin_doNewSite', 20, 1);


/**
 * Register the Kaya QR Code JavaScripts
 *
 * @since 1.7.0
 */
function wpkqcg_plugin_register_all_scripts()
{
	wp_register_script('wpkqcg-asset', WPKQCG_PLUGIN_URL . 'assets/qrcode-v2.min.js', array(), WPKQCG_VERSION, true);
	wp_register_script('wpkqcg-pkg', WPKQCG_PLUGIN_URL . 'js/wpkqcg-pkg.min.js', array(), WPKQCG_VERSION, true);

	wp_register_script('wpkqcg-display', WPKQCG_PLUGIN_URL . 'js/wpkqcg-display.min.js', array('jquery', 'wpkqcg-asset', 'wpkqcg-pkg'), WPKQCG_VERSION, true);
}
add_action('init', 'wpkqcg_plugin_register_all_scripts');


/**
 * Add attributes to the Kaya QR Code Gutenberg block
 *
 * @since 1.7.0
 */
function wpkqcg_plugin_filter_block_type_metadata($metadata)
{
	if (
		!isset($metadata['name'])
		|| $metadata['name'] !== 'kaya-qrcode-generator/qrcode'
	)
	{
		return $metadata;
	}

	$gutenberg_data = WPKQCG_Forms_QRCode::get_gutenberg_fields();

	if (!empty($gutenberg_data['attributes']))
	{
		$metadata['attributes'] = $gutenberg_data['attributes'];
	}

	if (!empty($gutenberg_data['description']))
	{
		$metadata['description'] = $gutenberg_data['description'];
	}

	return $metadata;
}
add_filter('block_type_metadata', 'wpkqcg_plugin_filter_block_type_metadata');


/**
 * Register the Kaya QR Code Gutenberg block
 *
 * @since 1.7.0
 */
function wpkqcg_plugin_register_block_qrcode()
{
	$block_type = register_block_type(
		WPKQCG_PLUGIN_PATH . '/blocks/qrcode',
		array(
			'script_handles' => array('wpkqcg-display')
		)
	);

	if (!$block_type) return;

	if (!empty($block_type->editor_script_handles))
	{
		$script_handle = $block_type->editor_script_handles[0];
		$gutenberg_data = WPKQCG_Forms_QRCode::get_gutenberg_fields();

		wp_localize_script(
			$script_handle,
			'WPKQCGQRCodeFields',
			$gutenberg_data
		);
	}
}
add_action('init', 'wpkqcg_plugin_register_block_qrcode', 20);


/**
 * Show action links on the plugin screen.
 *
 * @param mixed $links Plugin action links.
 * @param mixed $file Plugin base file.
 *
 * @return array Custom plugin action links.
 */
function wpkqcg_plugin_displayActionLinks($links, $file)
{
	if (WPKQCG_FILE === $file)
	{
		$actionLinks = array(
			'ks_panel'		=> '<a href="' . esc_url(admin_url('admin.php?page=' . WPKQCG_Admin_Dashboard::$_pageSlug)) . '" title="' . esc_html__('QR Code Generator settings', 'kaya-qr-code-generator') . '">' . esc_html__('Settings', 'kaya-qr-code-generator') . '</a>',
			'ks_plugins'	=> '<a href="' . esc_url('https://profiles.wordpress.org/kayastudio#content-plugins') . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__('Other plugins by Kaya Studio', 'kaya-qr-code-generator') . '">' . esc_html__('Other plugins', 'kaya-qr-code-generator') . '</a>',
		);

		return array_merge($actionLinks, $links);
	}

	return (array) $links;
}
add_filter('plugin_action_links', 'wpkqcg_plugin_displayActionLinks', 10, 2);


/**
 * Show row meta on the plugin screen.
 *
 * @param mixed $links	Plugin row Meta.
 * @param mixed $file	Plugin base file.
 *
 * @return array Custom plugin Meta.
 */
function wpkqcg_plugin_displayMetaLinks($links, $file)
{
	if (WPKQCG_FILE === $file)
	{
		$metaLinks = array(
			'ks_rate'	=> '<a href="' . esc_url('https://wordpress.org/support/plugin/kaya-qr-code-generator/reviews/?rate=5#new-post') . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__('Rate and review this plugin at WordPress.org', 'kaya-qr-code-generator') . '">' . esc_html__('Rate this plugin', 'kaya-qr-code-generator') . '&nbsp;&#9733;</a>',
			'ks_donate'	=> '<a href="' . esc_url('https://dotkaya.org/a-propos/') . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__('Donate to support the advancement of this plugin', 'kaya-qr-code-generator') . '">' . esc_html__('Donate to this plugin', 'kaya-qr-code-generator') . '&nbsp;&#9829;</a>',
		);

		return array_merge($links, $metaLinks);
	}

	return (array) $links;
}
add_filter('plugin_row_meta', 'wpkqcg_plugin_displayMetaLinks', 10, 2);
