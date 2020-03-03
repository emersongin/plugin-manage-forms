<?php

    class Input extends Element_HTML {
        private $title = '';
        private $input_data = array();

        public function __construct( $input_data = array() ) {
            $this->set_tag( 'div' ); 
            $this->input_data = $input_data;

        }

        public function get_title() {
            return $this->title;

        }

        public function set_title( $title ) {
            $this->title = $title;

        }

        public function get_input_data() {
            return $this->input_data;

        }

        public function set_input_data( $input_data ) {
            $this->input_data = $input_data;

        }

        public function create_elements( $element ) {
            $attributes = $this->get_input_data();

            $p = new $element( 'p' );
            $label = new $element( 'label' );
            $div_wrap = new $element( 'div' );
            $input = new $element( 'input' );

            if ( $this->get_title() ) {
                $label->add_attribute( 'for', $attributes['name'] );
                $label->set_inner_text( $this->get_title() );

                $p->add_inner_element( $label );
                $this->add_inner_element( $p );

            }
            
            $input->add_attribute( 'type', $attributes['type'] );
            $input->add_attribute( 'id', $attributes['id'] );
            $input->add_attribute( 'name', $attributes['name'] );
            $input->add_attribute( 'class', $attributes['class'] );
            $input->add_attribute( 'value', $attributes['value'] );
            $input->add_attribute( 'placeholder', $attributes['placeholder'] );
            $input->add_attribute( 'required', $attributes['required'] );

            $div_wrap->add_attribute( 'class', array( 'wrap' ) );

            $div_wrap->add_inner_element( $input );
            $this->add_inner_element( $div_wrap );

        } 

    }
