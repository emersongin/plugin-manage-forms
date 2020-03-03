<?php

    abstract class Element_HTML implements Interface_Element_HTML {
        private $tag = '';
        private $inner_text = '';
        private $inner_elements = array();
        private $attributes = array();
        protected $js_script = null;
        protected $css_style_sheet = null;

        public function __construct( $tag ) {
            $this->set_tag( $tag );

        }

        public function get_tag() {
            return $this->tag;

        }

        public function set_tag( $tag ) {
            $this->tag = $tag;

        }

        public function get_inner_text() {
            return $this->inner_text;

        }

        public function set_inner_text( $inner_text ) {
            $this->inner_text = $inner_text;

        }

        public function get_inner_elements() {
            return $this->inner_elements;

        }

        public function add_inner_element( $element ) {
            $this->inner_elements[] = $element;

        }

        public function get_attributes() {
            return $this->attributes;

        }

        public function set_attributes( $attributes ) {
            $this->attributes = $attributes;

        }

        public function add_attribute( $key, $attribute ) {
            $this->attributes[ $key ] = $attribute;

        }

        public function get_script() {
            return $this->js_script;

        }

        public function set_script( $js_script ) {
            $this->js_script = $js_script;

        }

        public function get_style_sheet() {
            return $this->css_style_sheet;

        }

        public function set_style_sheet( $css_style_sheet ) {
            $this->css_style_sheet = $css_style_sheet;

        }

        public function load_style_sheet( Style_Sheet $style ) {}
        public function load_script( JS_Script $script ) {}

        public function app_end() {
            echo "<" . $this->get_tag(); 

            if ( count( $this->get_attributes() ) ) {
                foreach ( $this->get_attributes() as $tag_attr => $attributes ) {
                    if( $tag_attr ) {
                        echo " " . $tag_attr;

                        if( is_array( $attributes ) and count( $attributes ) ) {
                            echo '="';
                                foreach ( $attributes as $attribute ) {
                                    echo " " . $attribute;
                                }
                            echo ' "';
                        } else if ( is_string( $attributes ) ) {
                            echo '="';
                                echo $attributes;
                            echo '"';
                        }
                        
                    }
    
                }
            }               
            echo " >"; 

            if ( count( $this->get_inner_elements() ) ) {
                foreach ( $this->get_inner_elements() as $element ) {
                    $element->app_end();

                }

            }
            
            if ( $this->get_inner_text() ) {
                echo $this->get_inner_text();

            }
            
            echo '</';
                echo $this->get_tag();
            echo '>';
            
        }

    }
    