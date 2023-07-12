<?php
/*
Plugin Name: Post H2 Adverts
Text Domain: post-h2-adverts
Plugin URI: http://iworks.pl/post-h2-adverts/
Description:
Version: PLUGIN_VERSION
Author: Marcin Pietrzak
Author URI: http://iworks.pl/
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Copyright 2023-PLUGIN_TILL_YEAR Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * static options
 */
define( 'IWORKS_POST_H2_ADVERTS_VERSION', 'PLUGIN_VERSION' );
define( 'IWORKS_POST_H2_ADVERTS_PREFIX', 'iworks_post-h2-adverts_' );
$base   = dirname( __FILE__ );
$vendor = $base . '/includes';

/**
 * require: Iworkspost-h2-adverts Class
 */
if ( ! class_exists( 'iworks_post_h2_adverts' ) ) {
	require_once $vendor . '/iworks/class-post-h2-adverts.php';
}
/**
 * configuration
 */
require_once $base . '/etc/options.php';
/**
 * require: IworksOptions Class
 */
if ( ! class_exists( 'iworks_options' ) ) {
	require_once $vendor . '/iworks/options/options.php';
}

/**
 * i18n
 */
load_plugin_textdomain( 'post-h2-adverts', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

/**
 * load options
 */
global $iworks_post_h2_adverts_options;
$iworks_post_h2_adverts_options = new iworks_options();
$iworks_post_h2_adverts_options->set_option_function_name( 'iworks_post_h2_adverts_options' );
$iworks_post_h2_adverts_options->set_option_prefix( IWORKS_POST_H2_ADVERTS_PREFIX );

function iworks_post_h2_adverts_get_options() {
	global $iworks_post_h2_adverts_options;
	return $iworks_post_h2_adverts_options;
}

function iworks_post_h2_adverts_options_init() {
	global $iworks_post_h2_adverts_options;
	$iworks_post_h2_adverts_options->options_init();
}

function iworks_post_h2_adverts_activate() {
	$iworks_post_h2_adverts_options = new iworks_options();
	$iworks_post_h2_adverts_options->set_option_function_name( 'iworks_post_h2_adverts_options' );
	$iworks_post_h2_adverts_options->set_option_prefix( IWORKS_POST_H2_ADVERTS_PREFIX );
	$iworks_post_h2_adverts_options->activate();
}

function iworks_post_h2_adverts_deactivate() {
	global $iworks_post_h2_adverts_options;
	$iworks_post_h2_adverts_options->deactivate();
}

$iworks_post_h2_adverts = new iworks_post_h2_adverts();

/**
 * install & uninstall
 */
register_activation_hook( __FILE__, 'iworks_post_h2_adverts_activate' );
register_deactivation_hook( __FILE__, 'iworks_post_h2_adverts_deactivate' );
