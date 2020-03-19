<?php

    defined( 'ABSPATH' ) || exit;

    class Style_Sheet_Register extends Script_Register implements Interface_Style_Register {

        public function enqueue(  Interface_Script $script  ) {
            wp_enqueue_style( $script->get_handle_name() );    
            
        }

        public function register( Interface_Style_Sheet $style_sheet ) {
            wp_register_style( 
                $style_sheet->get_handle_name(), 
                $style_sheet->get_src(), 
                $style_sheet->get_dependencies(), 
                $style_sheet->get_version(), 
                $style_sheet->get_media() 
            );

        }

    }
