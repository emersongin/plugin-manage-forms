<?php

    defined( 'ABSPATH' ) || exit;

    class Script_Validator implements Interface_Script_Validator {

        public function validate( Interface_Script $script ) {
            if ( strlen( $script->get_handle_name() ) <= 0 ) {
                return false;

            }

            if ( strlen( $script->get_src() ) <= 0 ) {
                return false;

            }
            
            return  true;

        }

    }
