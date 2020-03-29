<?php

    defined( 'ABSPATH' ) || exit;

    class Data_Manager {
        private $database = array();

        public function __construct() {
            //post types
            $this->database['post-types']['auth-forms'] = 
                $this->load_data( 'post-types/post-type-authforms.json' );

            //meta boxes
            $this->database['meta-boxes']['service'] = 
                $this->load_data( 'meta-boxes/meta-boxes-auth-service.json' );
            $this->database['meta-boxes']['setting'] = 
                $this->load_data( 'meta-boxes/meta-boxes-auth-settings.json' );

            //meta fields
            $this->database['meta-fields']['title'] = 
                $this->load_data( 'meta-fields/input-service-title.json' );
            $this->database['meta-fields']['items-list'] = 
                $this->load_data( 'meta-fields/itemslist-service.json' );
            $this->database['meta-fields']['select-exp-time'] = 
                $this->load_data( 'meta-fields/select-expiration-time.json' );
            $this->database['meta-fields']['select-parcel'] = 
                $this->load_data( 'meta-fields/select-parcel.json' );
            $this->database['meta-fields']['select-terms'] = 
                $this->load_data( 'meta-fields/select-terms.json' );

        }

        public function get_data( $index ) {
            return $this->database[ $index ];

        }

        private function load_data( $path ) {
            $content = json_decode( file_get_contents( MGF_DIR_DATA . $path ), true );

            if ( isset( $content['scripts'] ) ) {
                new Script_JS( $content['scripts'], new Script_JS_Register(), new Script_Validator() );

            }

            if ( isset( $content['styles'] ) ) {
                new Style_Sheet( $content['scripts'], new Style_Sheet_Register(), new Script_Validator() );

            }

            return $content;

        }

    }
