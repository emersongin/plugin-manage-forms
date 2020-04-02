<?php

    defined( 'ABSPATH' ) || exit;

    class Post_Type_Register implements Interface_Post_Type_Register {

        public function register( Interface_Post_Type $post_type ) {
            register_post_type( 
                $post_type->get_name(), 
                array(
                    'labels' => $post_type->get_labels(),
                    'description' => $post_type->get_description(),
                    'public' => $post_type->is_public(),
                    'menu_position' => $post_type->get_menu_position(),
                    'menu_icon' => $post_type->get_menu_icon(),
                    'supports' => $post_type->get_supports(),
                )
            );

        }

    }
