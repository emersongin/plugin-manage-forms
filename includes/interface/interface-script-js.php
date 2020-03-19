<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Script_JS {
        public function __construct( Array $script );
        public function is_footer();
        public function get_object_name();
        public function get_object_params();

    };
    