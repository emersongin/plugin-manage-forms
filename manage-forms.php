<?php
// Silence is golden.
/***
 * Plugin Name:       Manage Forms
 * Plugin URI:        https://google.com/
 * Description:       plugin que adiciona um gerenciador de formulários para captação de dados de cartão.
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Emerson Andrey
 * Author URI:        https://emersonandrey.com.br/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       manage-forms
 * Domain Path:       /languages
 * 
 * @package Manage Forms
***/

defined( 'ABSPATH' ) || exit;

if ( defined( 'MG_FORMS_FILE' ) === false ) {
    define( 'MG_FORMS_FILE', __FILE__ );
    
}

define( 'REQUIRED_WP_VERSION', '5.0.0' );
define( 'REQUIRED_PHP_VERSION', '5.6.0' );

//register hooks
register_activation_hook( MG_FORMS_FILE, 'manage_forms_activate_plugin' );
register_deactivation_hook( MG_FORMS_FILE, 'manage_forms_disabled_plugin' );

function manage_forms_activate_plugin() {
    verify_wp_version();
    verify_php_version();

}

if ( class_exists( 'Plugin_Manager', false ) === false ) {
    require_once plugin_dir_path( MG_FORMS_FILE ) . '/includes/class-plugin-manager.php';
    
}

new Plugin_Manager();

function verify_wp_version() {
    global $wp_version;
    
    if( version_compare( $wp_version, REQUIRED_WP_VERSION, '<' ) ) {
        wp_die( 'Este plugin requer no mínimo a versão: ' . REQUIRED_WP_VERSION . ' do WordPress.' );

    }

}

function verify_php_version() {
    if ( version_compare( PHP_VERSION, REQUIRED_PHP_VERSION, '<' ) ) {
        wp_die( 'Este plugin requer no mínimo a versão: ' . REQUIRED_PHP_VERSION . ' do PHP.' );

    }

}
