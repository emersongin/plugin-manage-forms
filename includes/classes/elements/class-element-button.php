<?php

    defined( 'ABSPATH' ) || exit;

    class Button_Element extends Elements {
        
        public function __construct( Array $element ) {
            $element['tag'] = 'button';
            parent::__construct( $element );

        }

    }
