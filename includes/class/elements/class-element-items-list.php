<?php

    class Items_List_Element extends Elements {
        private $items = array();

        public function __construct( Array $element ) {
            $element['tag'] = 'div';

            if ( isset( $element['items'] ) ) {
                $this->items = $element['items'];

            }
            
            parent::__construct( $element );

        }

        public function load_script( JS_Script $script ) {
            $this->set_script( $script );

            $this->create_script( $script_data );
            $this->create_params();
            $this->enqueue_script();

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
