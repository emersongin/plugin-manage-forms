<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Script {
        public function __construct( 
            Array $script,
            $register, 
            Interface_Script_Validator $validator 
        );
        public function registration();
        public function get_handle_name();
        public function get_src();
        public function get_dependencies();
        public function get_version();

    };
    