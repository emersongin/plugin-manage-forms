<?php

    interface Interface_Scripts {
        public function get_name();
        public function set_name( $name );
        public function get_src();
        public function set_src( $uri );
        public function get_version();
        public function set_version( $version );
        public function get_dependencies();
        public function set_dependencies( $dependencies );
        public function get_action_name();
        public function set_action_name( $action_name );
        public function register();
        public function valid();
        public function enqueue();

    };
    