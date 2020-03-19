<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Style_Register {
        public function enqueue( Interface_Script $script );
        public function register( Interface_Style_Sheet $script );
        
    }
