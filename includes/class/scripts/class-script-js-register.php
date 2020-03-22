<?php

    defined( 'ABSPATH' ) || exit;

    class Script_JS_Register implements Interface_Script_JS_Register {

        public function enqueue(  Interface_Script $script  ) {
            wp_enqueue_script( $script->get_handle_name() );    
            
        }

        public function register( Interface_Script_JS $script ) {
            wp_register_script( 
                $script->get_handle_name(), 
                $script->get_src(), 
                $script->get_dependencies(), 
                $script->get_version(), 
                $script->is_footer() 
            );

        }

        public function include_params( Interface_Script_JS $script ) {
            wp_localize_script( 
                $script->get_handle_name(), 
                $script->get_object_name(), 
                $script->get_object_params()
            );  

        }

    }
