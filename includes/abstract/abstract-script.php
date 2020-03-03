<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Script implements Interface_Scripts {
        private $handle_name = '';
        protected $src = '';
        private $dependencies = array();
        private $version = '';
        private $action_name = '';

        public function get_name() {
            return $this->handle_name;

        }

        public function set_name( $name ) {
            $this->handle_name = sanitize_key( $name );

        }

        public function get_src() {
            return $this->src;

        }

        public function get_dependencies() {
            return $this->dependencies;

        }

        public function set_dependencies( $dependencies ) {
            $this->dependencies = $dependencies;

        }

        public function add_dependecy( $dependency ) {
            $this->dependencies[] = $dependency;

        }

        public function get_version() {
            return $this->version;

        }

        public function set_version( $version ) {
            $this->version = $version;

        }

        public function get_action_name() {
            return $this->action_name;

        }

        public function set_action_name( $name ) {
            $this->action_name = sanitize_key( $name );

        }

        public function valid() {
            return strlen( $this->get_name() ) > 0 and strlen( $this->get_src() ) > 0 ? true : false;

        }

        public function enqueue() {
            if ( $this->valid() ) {
                $this->enqueue_script();
                add_action( $this->get_action_name(), array( $this, 'enqueue_script' ));                
                
            }
            
        }

        public function enqueue_script() {
            wp_enqueue_script( $this->get_name() );

        }

    }
    