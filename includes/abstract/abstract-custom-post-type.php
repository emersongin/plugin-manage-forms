<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Custom_Post_Type implements Interface_Post_type {
        private $name = '';
        private $labels = array();
        private $description = '';
        private $public = true;
        private $menu_position = 20;
        private $menu_icon = 'none';
        private $supports = array();
        private $meta_boxes = array();

        public function __construct( Array $post_type_data ) {
            $this->name = substr( sanitize_key( $post_type_data['name'] ), 0, 20 );
            $this->labels = $post_type_data['labels'];
            $this->description = $post_type_data['description'];
            $this->public = $post_type_data['public'];
            $this->menu_position = $post_type_data['menu_position'];
            $this->menu_icon = $post_type_data['menu_icon'];
            $this->supports = $post_type_data['supports'];
            $this->meta_boxes = $post_type_data['meta_boxes'];

        }

        public function get_name() {
            return $this->name;

        }

        public function get_labels() {
            return $this->labels;

        }

        public function get_description() {
            return $this->description;

        }

        public function is_public() {
            return $this->public;

        }

        public function get_menu_position() {
            return $this->menu_position;

        }

        public function get_menu_icon() {
            return $this->menu_icon;

        }  
        
        public function get_supports() {
            return $this->supports;

        }

        public function get_meta_boxes() {
            return $this->meta_boxes;

        }

    }
