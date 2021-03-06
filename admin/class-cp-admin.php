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
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $version  La versión actual del plugin
	 */
    private $build_menupage;

    private $db;

    private $crud_json;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;     
        $this->build_menupage = new CP_Build_Menupage();

        global $wpdb;
        $this->db = $wpdb;

        $this->crud_json = new CP_CRUD_JSON;

    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles($hook) {

        wp_enqueue_media();
        
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
        * cp-wordpress.css
        * Archivo de hoja de estilos principales de la administracion
        */

        wp_enqueue_style( 'cp_wordpress_css', CP_PLUGIN_DIR_URL . 'admin/css/cp-wordpress.css', array(), $this->version, 'all' );

        if($hook != 'toplevel_page_cp_data'){
            return;
        }

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
    public function enqueue_scripts($hook) {
        
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

        if($hook != 'toplevel_page_cp_data'){
            return;
        }

        wp_enqueue_script( 'cp_materialize_admin_js', CP_PLUGIN_DIR_URL . 'helpers/materialize/js/materialize.min.js', ['jquery'], $this->version, true );

        /*
        * Sweet alert
        * http://t4t5.github.io/sweetalert
        */

        wp_enqueue_script( 'cp_sweetalert_js', CP_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.min.js', ['jquery'], $this->version, true );

        wp_enqueue_script( $this->plugin_name, CP_PLUGIN_DIR_URL . 'admin/js/cp-admin.js', ['jquery'], $this->version, true );

        wp_localize_script(
            $this->plugin_name,
            'cpdata',
            [
                'url' => admin_url('admin-ajax.php'),
                'seguridad' => wp_create_nonce('cpdata_seg')
            ]);
        
        }
    /**
	 * Registra la clase para crear el menu
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function add_menu(){

        $this->build_menupage->add_menu_page(
            __('Crud Project', 'jcastaneda-textdomain'),
            __('Crud Project', 'jcastaneda-textdomain'),
            'manage_options',
            'cp_data',
            [$this, 'controlador_display_menu'],
            'dashicons-plugin',
            22
        );

        $this->build_menupage->run();
    }

    public function controlador_display_menu() {

        if($_GET['page'] == 'cp_data' && isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])){
            require_once CP_PLUGIN_DIR_PATH . 'admin/partials/cp-admin-display-edit.php';
        }else{
            require_once CP_PLUGIN_DIR_PATH . 'admin/partials/cp-admin-display.php';
        }

    }

    public function ajax_crud_table(){

        check_ajax_referer('cpdata_seg', 'nonce');

        if(current_user_can('manage_options')){

            extract( $_POST, EXTR_OVERWRITE);

            if($tipo == 'add'){

                $columns = [
                    'nombre' => $nombre,
                    'data' => '',
    
                ];
    
    
                $result = $this->db->insert(CP_TABLE, $columns);
    
                $json = json_encode([
                    'result' => $result,
                    'nombre' => $nombre,
                    'insert_id' => $this->db->insert_id
                ]);

            }

            

            echo $json;
            wp_die();


        }
    }

    public function ajax_crud_json(){

        check_ajax_referer('cpdata_seg', 'nonce');

        if(current_user_can('manage_options')){

            extract( $_POST, EXTR_OVERWRITE);

            $sql = $this->db->prepare('SELECT data FROM ' . CP_TABLE . ' WHERE id = %d', $idtable);
            $resultado = $this->db->get_var($sql);

            if($tipo == 'add'){

                $data = $this->crud_json->add_item($resultado, $nombres, $apellidos, $email, $media);

                $columns = [
                    "data" => json_encode($data)
                ];

                $where = [
                    "id" => $idtable
                ];

                $format = [
                    "%s"
                ];

                $where_format = [
                    "%d"
                ];

                $result_update = $this->db->update(CP_TABLE, $columns, $where, $format, $where_format);
                $items = $data['items'];
                $last_item = end($items);
                $insert_id = $last_item['id'];
                $json = json_encode([
                    'result' =>$result_update,
                    'json' => $data,
                    'insert_id' => $insert_id
                ]);

                

            } elseif($tipo == 'update'){
                $data = $this->crud_json->update_item($resultado, $iduser, $nombres, $apellidos, $email, $media);

                $columns = [
                    "data" => json_encode($data)
                ];

                $where = [
                    "id" => $idtable
                ];

                $format = [
                    "%s"
                ];

                $where_format = [
                    "%d"
                ];

                $result_update = $this->db->update(CP_TABLE, $columns, $where, $format, $where_format);
                
                $json = json_encode([
                    'result' =>$result_update,
                    'json' => $data
                ]);


            } elseif($tipo == 'delete'){

                $data = $this->crud_json->delete_item($resultado, $iduser);

                $columns = [
                    "data" => json_encode($data)
                ];

                $where = [
                    "id" => $idtable
                ];

                $format = [
                    "%s"
                ];

                $where_format = [
                    "%d"
                ];

                $result_update = $this->db->update(CP_TABLE, $columns, $where, $format, $where_format);
                
                $json = json_encode([
                    'result' =>$result_update,
                    'json' => $data
                ]);

            }

            

            echo $json;
            wp_die();


        }
    }
    
}







