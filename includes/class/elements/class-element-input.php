<?php

    class Input_Element extends Elements {
        private $label = '';

        public function __construct( Array $element ) {
            $element['tag'] = 'input';

            if ( isset( $element['label'] ) ) {
                $this->label = $element['label'];

            }

            parent::__construct( $element );

        }

        public function append() {

            echo "<label "; 
                echo "for=" . $this->get_attributes()['id'] . ">";
                    echo $this->label;
            echo "</label>";

            parent::append();
            
        }


    }
