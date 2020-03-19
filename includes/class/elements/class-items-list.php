<?php

    class Items_List extends Element_HTML {
        private $title = '';
        private $items = array();

        public function __construct( $items = array() ) {
            $this->set_tag( 'div' );
            $this->set_items( $items );

        }

        public function get_title() {
            return $this->title;

        }

        public function set_title( $title ) {
            $this->title = $title;

        }

        public function get_items() {
            return $this->items;

        }

        public function set_items( $items ) {
            $this->items = $items;

        }

        public function load_script( JS_Script $script ) {
            $this->set_script( $script );

            $this->create_script( $script_data );
            $this->create_params();
            $this->enqueue_script();

        }

        public function create_script( $script_data ) {
            if ( count( $script_data ) ) {

                
            }

        }

        public function create_params() {
            $items = $this->get_items();
            
            if ( is_array( $items ) ) {
                if ( count( $items ) == false ) {
                    $items[] = array( 'text' => '', 'value' => 0 );

                }

                foreach ( $items as $item ) {
                    $this->js_script->add_param( $item );

                }
                
            }

        }

        public function enqueue_script() {
            $this->js_script->register();
            $this->js_script->include_params();
            $this->js_script->enqueue();

        }

        public function create_elements( $element ) {
            $p = new $element( 'p' );
            $label = new $element( 'label' );

            if ( $this->get_title() ) {
                $label->set_inner_text( $this->get_title() );
                $label->add_attribute( 'for','div-list-items' );

                $p->add_inner_element( $label );
                $this->add_inner_element( $p );

            }

            $div_wrap = new $element( 'div' );
            $div_items_list = new $element( 'div' );

            $div_wrap->add_attribute( 'class', 'wrap' );
            $div_items_list->add_attribute( 'id', 'div-list-items' );

            $div_wrap->add_inner_element( $div_items_list );
            $this->add_inner_element( $div_wrap );

            $button = new $element( 'button' );
            $span = new $element( 'span' );
            $button->add_attribute( 'type','button' );
            $button->add_attribute( 'id','add-item-list' );
            $button->add_attribute( 'class', 'button-primary' );

            $span->add_attribute( 'class', array( 'dashicons', 'dashicons-plus' ));
            $span->add_attribute( 'style', 'margin-top: 6px !important' );

            $button->add_inner_element( $span );
            $button->set_inner_text( ' Add item' );

            $this->add_inner_element( $button );

        } 

    }
