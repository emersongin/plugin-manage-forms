<?php

    defined( 'ABSPATH' ) || exit;

    class Style_Sheet extends Script implements Interface_Style_Sheet, Interface_Script {
        private $media = '';

        public function __construct( 
            Array $style_data,
            $register, 
            Interface_Script_Validator $validator 
            ) {
            parent::__construct( $style_data, $register, $validator );

            $this->src = MG_FORMS_ASSETS . '/css/' . $style_data['src'];
            $this->media = $style_data['media'];

            $this->registration();

        }

        public function get_media() {
            return $this->media;

        }

    }
