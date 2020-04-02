<?php

    defined( 'ABSPATH' ) || exit;

    class Label_Element extends Elements {

        public function __construct( Array $element ) {
            $element['tag'] = 'label';
            parent::__construct( $element );

        }

    }
