<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Script {
        private $handle_name = '';
        private $src = '';
        private $dependencies = array();
        private $version = '';

        public function __construct( Array $script ) {
            $this->handle_name = sanitize_key( $script['name'] );
            $this->src = $script['src'];
            $this->dependencies = $script['dependencies'];
            $this->version = $script['version'];

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
    