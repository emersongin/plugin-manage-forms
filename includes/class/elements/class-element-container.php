<?php

    class Container_Element extends Elements {

        public function __construct( Array $element ) {
            $element['tag'] = 'div';

            parent::__construct( $element );

        }

    }
