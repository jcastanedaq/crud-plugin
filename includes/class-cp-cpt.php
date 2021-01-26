<?php

class CP_CPT {
    
    public function beziercode() {
        $labels = [
            'name' => __( 'Plurar', 'jcastaneda-textdomain' ),
            'singular_name' => __( 'Singular', 'jcastaneda-textdomain' ),
            'add_new' => __( 'Agregar nuevo', 'jcastaneda-textdomain' ),
            'add_new_item' => __( 'Agregar nuevo item', 'jcastaneda-textdomain' ),
            'edit_item' => __( 'Editar items', 'jcastaneda-textdomain' ),
            'view_item' => __( 'Ver items', 'jcastaneda-textdomain' ),
            'featured_image' => __( 'Imagen de portada items', 'jcastaneda-textdomain' ),
            'set_featured_image' => __( 'Definir portada item', 'jcastaneda-textdomain' ),
            'remove_featured_image' => __( 'Remover imagen del item', 'jcastaneda-textdomain' ),
            'use_featured_image' => __( 'Usar como imagen de item', 'jcastaneda-textdomain' ),
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'supports' => [ 'title', 'editor', 'thumbnail' ],
            'capability_type' => 'post',
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_admin_bar' => false,
            'rewrite' => [ 'slug' => 'items' ],
        ];

        register_post_type( 'beziercode_post_type', $args );

        flush_rewrite_rules();
    }
        
}