<?php
/**
 * Archivo del plugin 
 * Este archivo es leído por WordPress para generar la información del plugin
 * en el área de administración del complemento. Este archivo también incluye 
 * todas las dependencias utilizadas por el complemento, registra las funciones 
 * de activación y desactivación y define una función que inicia el complemento.
 *
 * @link                http://jcastaneda.com
 * @since               1.0.0
 * @package             Crud Project
 *
 * @wordpress-plugin
 * Plugin Name:         Crud Project
 * Plugin URI:          http://jcastaneda.com
 * Description:         Descripción corta de nuestro plugin
 * Version:             1.0.0
 * Author:              Jorge Castañeda
 * Author URI:          http://jcastaneda.com
 * License:             GPL2
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         jcastaneda-textdomain
 * Domain Path:         /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
global $wpdb;
define( 'CP_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'CP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'CP_TABLE', "{$wpdb->prefix}beziercode_data" );

/**
 * Código que se ejecuta en la activación del plugin
 */
function activate_crud_project() {
    require_once CP_PLUGIN_DIR_PATH . 'includes/class-cp-activator.php';
	CP_Activator::activate();
}

/**
 * Código que se ejecuta en la desactivación del plugin
 */
function deactivate_crud_project() {
    require_once CP_PLUGIN_DIR_PATH . 'includes/class-cp-deactivator.php';
	CP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_crud_project' );
register_deactivation_hook( __FILE__, 'deactivate_crud_project' );

require_once CP_PLUGIN_DIR_PATH . 'includes/class-cp-master.php';

function run_cp_master() {
    $cp_master = new CP_Master;
    $cp_master->run();
}

run_cp_master();
























