<?php

    defined( 'ABSPATH' ) || exit;

    class JS_Script extends Script {
        private $footer = false;
        private $object_name = ''; 
        private $object_params = array();

        public function set_src( $uri ) {
            $this->src = MG_FORMS_ASSETS . '/js/' . $uri;

        }

        public function is_footer() {
            return $this->footer;

        }

        public function insert_footer( $footer ) {
            $this->footer = $footer;

        }

        public function get_object_name() {
            return $this->object_name;

        }

        public function set_object_name( $name ) {
            $this->object_name = $name;

        }

        public function get_object_params() {
            return $this->object_params;

        }

        public function add_param( $param ) {
            $this->object_params[] = $param;

        }

        public function register() {
            if ( $this->valid() ) {
                $this->register_script();
                add_action( $this->get_action_name(), array( $this, 'register_script' ));

            }

        }

        public function include_params() {
            if ( $this->valid() ) {  
                $this->include_script_params();    
                add_action( $this->get_action_name(), array( $this, 'include_script_params' ));
                
            }

        }

        public function register_script() {
            wp_register_script( 
                $this->get_name(), 
                $this->get_src(), 
                $this->get_dependencies(), 
                $this->get_version(), 
                $this->is_footer() 
            );

        }

        public function include_script_params() {
            wp_localize_script( 
                $this->get_name(), 
                $this->get_object_name(), 
                $this->get_object_params()
            );  

        }

    }
