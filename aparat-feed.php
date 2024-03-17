<?php
/**
 * Plugin Name: Latest Aparat Videos
 * Description: Displaying the latest Aparat videos
 * Plugin URI: https://dedidata.com
 * Author: DediData
 * Author URI: https://dedidata.com
 * Version: 1.2.8
 * Requires at least: 6.0
 * Tested up to: 6.4
 * Requires PHP: 7.0
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: aparat-feed
 * 
 * @package Aparat_Feed
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( '\DediData\Plugin_Autoloader' ) ) {
	require 'includes/DediData/class-plugin-autoloader.php';
}
// Set name spaces we use in this plugin
new \DediData\Plugin_Autoloader( array( 'DediData', 'AparatFeed', 'AparatFeedWidget' ) );
/**
 * The function APARAT_FEED returns an instance of the Aparat_Feed class.
 *
 * @return object an instance of the \AparatFeed\Aparat_Feed class.
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
function APARAT_FEED() { // phpcs:ignore Squiz.Functions.GlobalFunction.Found, WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return \AparatFeed\Aparat_Feed::get_instance( __FILE__ );
}
APARAT_FEED();
