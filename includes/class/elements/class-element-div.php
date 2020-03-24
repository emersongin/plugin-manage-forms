<?php

    defined( 'ABSPATH' ) || exit;

    class Div_Element extends Elements {

        public function __construct( Array $element ) {
            $element['tag'] = 'div';
            parent::__construct( $element );

        }

    }
