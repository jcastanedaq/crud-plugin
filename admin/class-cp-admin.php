<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       http://misitioweb.com
 * @since      1.0.0
 *
 * @package    Beziercode_blank
 * @subpackage Beziercode_blank/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    Beziercode-Blank
 * @subpackage Beziercode-Blank/admin
 * @author     Gilbert Rodríguez <email@example.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class CP_Admin {
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;     
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */

        /*
        * Framework materialize css
        * https://fonts.googleapis.com/icon?family=Material+Icons
        * Material Icons Google
        */

        wp_enqueue_style( 'cp_materialize_admin_css', CP_PLUGIN_DIR_URL . 'helpers/materialize/css/materialize.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'cp_materialize_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '0.100.1', 'all' );

        /*
        * Sweet alert
        * http://t4t5.github.io/sweetalert
        */

        wp_enqueue_style( 'cp_sweetalert_css', CP_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.css', array(), $this->version, 'all' );

        /*
        * cp-admin.css
        * Archivo de hoja de estilos principales de la administracion
        */

        wp_enqueue_style( $this->plugin_name, CP_PLUGIN_DIR_URL . 'admin/css/cp-admin.css', array(), $this->version, 'all' );
        
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */

        /*
        * Framework materialize js
        * https://fonts.googleapis.com/icon?family=Material+Icons
        * Material Icons Google
        */

        wp_enqueue_script( 'cp_materialize_admin_js', CP_PLUGIN_DIR_URL . 'helpers/materialize/js/materialize.min.js', array(), $this->version, true );

        /*
        * Sweet alert
        * http://t4t5.github.io/sweetalert
        */

        wp_enqueue_script( 'cp_sweetalert_js', CP_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.min.js', array(), $this->version, true );

        wp_enqueue_script( $this->plugin_name, CP_PLUGIN_DIR_URL . 'admin/js/cp-admin.js', ['jquery'], $this->version, true );
        
    }
    
}







