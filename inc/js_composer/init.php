<?php

/**
 * Initialize Visual Composer
 */

if ( class_exists( 'Vc_Manager', false ) ) {
    add_action( 'vc_before_init', 'ct_vcSetAsTheme' );
    function ct_vcSetAsTheme() {
        vc_set_as_theme(true);
    }

    if ( function_exists( 'vc_disable_frontend' ) ) :
      vc_disable_frontend();
    endif;

    add_action( 'vc_before_init', 'ct_load_js_composer' );

    function ct_load_js_composer() {
        require_once CT_INC_DIR . '/js_composer/js_composer.php';
    }

    if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
        vc_set_shortcodes_templates_dir( CT_INC_DIR . '/js_composer/vc_templates' );
    }
}

