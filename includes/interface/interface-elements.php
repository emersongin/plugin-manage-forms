<?php

    interface Interface_Element_HTML {
        public function load_style_sheet( Style_Sheet $style );
        public function load_script( JS_Script $script );
        public function app_end();

    }
