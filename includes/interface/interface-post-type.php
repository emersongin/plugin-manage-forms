<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Post_type {
        public function __construct( Array $post_type_data, Interface_Elements_Factory $elements_factory );

    }
