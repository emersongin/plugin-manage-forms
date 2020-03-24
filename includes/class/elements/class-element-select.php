<?php

    class Select_Element extends Elements {
        public function __construct( Array $element ) {
            $element['tag'] = 'select';
            parent::__construct( $element );

        }

    }
