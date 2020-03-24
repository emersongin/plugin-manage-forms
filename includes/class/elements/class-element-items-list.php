<?php

    class Items_List_Element extends Elements {
        public function __construct( Array $element ) {
            $element['tag'] = 'div';
            parent::__construct( $element );

        }

        public function append() {
            $attributes = $this->get_attributes();
            $class_button = $attributes['id'] . '-add';

            parent::append();
            include( MG_FORMS_DIR . "/template-parts/button-items-list.php" );
            
        }

    }
