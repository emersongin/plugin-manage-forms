<?php

    defined( 'ABSPATH' ) || exit;

    class Elements_Factory implements Interface_Elements_Factory {

        public function create_div ( Array $meta_box ) {
            return new Div_Element( $meta_box );

        }

        public function create_p ( Array $meta_box ) {
            return new P_Element( $meta_box );

        }

        public function create_label ( Array $meta_box ) {
            return new Label_Element( $meta_box );

        }

        public function create_input ( Array $meta_box ) {
            return new Input_Element( $meta_box );

        }

        public function create_button ( Array $meta_box ) {
            return new Button_Element( $meta_box );

        }

        public function create_span ( Array $meta_box ) {
            return new Span_Element( $meta_box );

        }

        public function create_select ( Array $meta_box ) {
            return new Select_Element( $meta_box );

        }

        public function create_option ( Array $meta_box ) {
            return new Option_Element( $meta_box );

        }

    }
    