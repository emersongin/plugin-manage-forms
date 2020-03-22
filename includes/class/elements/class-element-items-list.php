<?php

    class Items_List_Element extends Elements {
        public function __construct( Array $element ) {
            $element['tag'] = 'div';
            parent::__construct( $element );

        }

        public function append() {
            $attributes = $this->get_attributes();
            $id_button = $attributes['id'] . '-add';

            parent::append();

            echo '<button';
                echo ' id="' . $id_button . '" ';
                echo ' type="button" ';
                echo ' class="button-primary" ';
            echo '>';
                echo '<span';
                    echo ' class="dashicons dashicons-plus" ';
                    echo ' style="margin-top: 6px !important" ';
                echo '>';
                echo '</span>';
                echo 'Add item';
            echo '</button>';
            
        }

    }
