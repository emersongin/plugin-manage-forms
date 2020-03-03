<?php

    defined( 'ABSPATH' ) || exit;

    class Style_Sheet extends Script {
        private $media = '';

        public function set_src( $uri ) {
            $this->src = MG_FORMS_ASSETS . '/css/' . $uri;

        }

        public function get_media() {
            return $this->media;

        }

        public function set_media( $label ) {
            $this->media = $label;

        }

        public function register() {
            if ( $this->valid() ) {
                $this->register_script();
                add_action( $this->get_action_name(), array( $this, 'register_script' ));

            }

        }

        public function register_script() {
            wp_register_script( 
                $this->get_name(), 
                $this->get_src(), 
                $this->get_dependencies(), 
                $this->get_version(), 
                $this->get_media() 
            );

        }

    }
