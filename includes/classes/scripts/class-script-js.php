<?php

    defined( 'ABSPATH' ) || exit;

    class Script_JS extends Script implements Interface_Script_JS, Interface_Script {
        private $footer = false;
        private $object_name = ''; 
        private $object_params = array();

        public function __construct( 
            Array $script_data, 
            $register, 
            Interface_Script_Validator $validator 
            ) {

            parent::__construct( $script_data, $register, $validator );

            $this->src = MGF_DIR_ASSETS . 'js/' . $script_data['src'];
            $this->footer = $script_data['in_footer'];
            $this->object_name = $script_data['object_name'];
            $this->object_params = $script_data['object_params'];

            $this->registration();

        }

        public function registration() {
            if( $this->validator->validate( $this ) ) {
                $this->register->register( $this );
                $this->register->include_params( $this );
                $this->register->enqueue( $this );
    
            }
            
        }

        public function is_footer() {
            return $this->footer;

        }

        public function get_object_name() {
            return $this->object_name;

        }

        public function get_object_params() {
            return $this->object_params;

        }

    }
