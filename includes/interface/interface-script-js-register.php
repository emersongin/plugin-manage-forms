<?php

    defined( 'ABSPATH' ) || exit;

    interface Interface_Script_JS_Register {
        public function enqueue( Interface_Script $script );
        public function register( Interface_Script_JS $script );
        public function include_params( Interface_Script_JS $script );

    }
