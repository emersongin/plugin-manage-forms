<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Elements {
        public function __construct( Array $element );
        // public function load_style_sheet( Interface_Style_Sheet $style );
        // public function load_script( Interface_Script_JS $script );
        public function append();

    }
