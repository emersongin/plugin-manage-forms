<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Script_JS {
        public function __construct(             
            Array $script_data, 
            Interface_Script_JS_Register $register, 
            Interface_Script_Validator $validator 
        );
        public function is_footer();
        public function get_object_name();
        public function get_object_params();

    };
    