<?php

    defined( 'ABSPATH' ) || exit;

    class P_Element extends Elements {
        
        public function __construct( Array $element ) {
            $element['tag'] = 'p';
            parent::__construct( $element );

        }

    }
