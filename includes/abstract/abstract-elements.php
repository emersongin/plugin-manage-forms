<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Elements implements Interface_Elements {
        private $tag = '';
        private $inner_text = '';
        private $attributes = array();
        private $inner_elements = array();

        protected $script = null;
        protected $style_sheet = null;

        public function __construct( Array $element ) {
            if ( isset( $element['tag'] ) ) {
                $this->tag = $element['tag'];

            }

            if ( isset( $element['text'] ) ) {
                $this->inner_text = $element['text'];

            }

            if ( isset( $element['attributes'] ) ) {
                $this->attributes = $element['attributes'];

            }

        }

        public function get_tag() {
            return $this->tag;

        }

        public function get_text() {
            return $this->inner_text;

        }

        public function get_attributes() {
            return $this->attributes;

        }

        public function get_elements() {
            return $this->inner_elements;

        }

        public function add_element( $element ) {
            $this->inner_elements[] = $element;

        }

        public function append() {
            $tag = $this->get_tag();
            $text = $this->get_text();
            $attributes = $this->get_attributes();
            $elements = $this->get_elements();

            echo "<" . $tag; 

            if ( count( $attributes ) ) {
                foreach ( $attributes as $attribute => $flags ) {
                    if( $attribute ) {
                        echo " " . $attribute;

                        if( is_array( $flags ) and count( $flags ) ) {

                            echo '="';
                                foreach ( $flags as $flag ) {
                                    echo " " . $flag;

                                }
                            echo ' "';

                        } else if ( is_string( $flags ) ) {

                            echo '="';
                                echo $flags;
                            echo '"';
                            
                        }
                        
                    }
    
                }
            }               
            echo " >"; 
            
            if ( $text ) { echo $text; }

            if ( count( $elements ) ) {
                foreach ( $elements as $element ) {
                    $element->append();

                }

            }
            
            echo "</";
                echo $tag;
            echo ">";
            
        }

    }
    