<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Script {
        private $handle_name = '';
        protected $src = '';
        private $dependencies = array();
        private $version = '';
        protected $register = null;
        protected $validator = null;

        public function __construct( 
            Array $script,
            $register, 
            Interface_Script_Validator $validator 
            ) {
            $this->handle_name = sanitize_key( $script['name'] );
            $this->src = $script['src'];
            $this->dependencies = $script['dependencies'];
            $this->version = $script['version'];
            $this->register = $register;
            $this->validator = $validator;

        }

        public function registration() {
            if( $this->validator->validate( $this ) ) {
                $this->register->register( $this );
                $this->register->enqueue( $this );
    
            }
            
        }

        public function get_handle_name() {
            return $this->handle_name;

        }

        public function get_src() {
            return $this->src;

        }

        public function get_dependencies() {
            return $this->dependencies;

        }

        public function get_version() {
            return $this->version;

        }

    }
    