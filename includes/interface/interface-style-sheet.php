<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Style_Sheet {
        public function __construct( Array $style_sheet );
        public function get_media();

    };
    