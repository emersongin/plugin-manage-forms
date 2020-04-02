<?php

    defined( 'ABSPATH' ) || exit;

    class Span_Element extends Elements {
        
        public function __construct( Array $element ) {
            $element['tag'] = 'span';
            parent::__construct( $element );

        }

    }
