<?php

    class Elements_Factory implements Interface_Elements_Factory {

        public function create_container ( Array $meta_box ) {
            return new Container_Element( $meta_box );

        }

        public function create_input ( Array $meta_box ) {
            return new Input_Element( $meta_box );

        }

        public function create_items_list ( Array $meta_box ) {
            return new Items_List_Element( $meta_box, $meta_box['script'] );

        }

        public function create_select ( Array $meta_box ) {
            return new Select_Element( $meta_box, $meta_box['script'] );

        }

    }
    