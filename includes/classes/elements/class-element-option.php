<?php

    defined( 'ABSPATH' ) || exit;

    class Option_Element extends Elements {
        
        public function __construct( Array $element ) {
            $element['tag'] = 'option';
            parent::__construct( $element );

        }

    }
