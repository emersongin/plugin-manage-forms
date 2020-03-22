<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Style_Sheet {
        public function __construct( 
            Array $style_data,
            Interface_Style_Register $register, 
            Interface_Script_Validator $validator  
        );
        public function get_media();

    };
    