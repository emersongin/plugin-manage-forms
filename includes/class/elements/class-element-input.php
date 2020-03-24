<?php

    defined( 'ABSPATH' ) || exit;

    class Input_Element extends Elements {
        
        public function __construct( Array $element ) {
            $element['tag'] = 'input';
            parent::__construct( $element );

        }

    }
