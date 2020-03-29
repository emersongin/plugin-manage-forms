<?php

    defined( 'ABSPATH' ) || exit;

    class AuthForms_Post_Type extends Custom_Post_Type {

        public function __construct( Array $post_type_data, Interface_Elements_Factory $elements_factory ) {
            parent::__construct( $post_type_data, $elements_factory );

        }

        public function create_meta_boxes() {    
            foreach ( $this->get_meta_boxes() as $meta_box ) {
                add_meta_box( 
                    $meta_box['id'], 
                    $meta_box['title'], 
                    array( $this, 'render_meta_boxes' ), 
                    $meta_box['post_type'], 
                    $meta_box['context'],
                    $meta_box['priority'],
                    $meta_box['meta_fields']
                );

            }

        }

        public function render_meta_boxes( $post, $meta_box ) {
            $field = null;
            $data = array();

            foreach ( $meta_box['args'] as $key => $meta_field ) {
                if ( $meta_field['tag'] ) {
                    $field = $this->create_element( $meta_field );
                    $field->append();

                }

            }   

            $data = array(
                'name' => "fill-admin-auth-forms-js",
                'src' => "fill-admin-auth-forms.js",
                'dependencies' => array(),
                'version' => "1.0",
                'in_footer' => true,
                'object_name' => "postTypeData",
                'object_params' => array(
                    "id" => "list-items",
                    'items' => [
                        array(
                            'key' => 'service-title',
                            'value' => get_post_meta( $post->ID, '_service_title', true )
                        )
                    ]
                )
            );

            new Script_JS( $data, new Script_JS_Register(), new Script_Validator() );

        }

        private function create_element( $meta_field ) {
            $element = null;

            switch ( $meta_field['tag'] ) {
                case 'div':
                    $element = $this->elements_factory->create_div( $meta_field ); 

                    break;
                case 'p':
                    $element = $this->elements_factory->create_p( $meta_field ); 

                    break;
                case 'label':
                    $element = $this->elements_factory->create_label( $meta_field ); 

                    break;
                case 'input':
                    $element = $this->elements_factory->create_input( $meta_field ); 

                    break;
                case 'button':
                    $element = $this->elements_factory->create_button( $meta_field ); 

                    break;
                case 'span':
                    $element = $this->elements_factory->create_span( $meta_field ); 

                    break;
                case 'select':
                    $element = $this->elements_factory->create_select( $meta_field ); 

                    break;
                case 'option':
                    $element = $this->elements_factory->create_option( $meta_field ); 

                    break;
                default:
                    # code...
                    break;
            }

            if ( isset( $meta_field['inner_elements'] ) and count( $meta_field['inner_elements'] ) ) {
                foreach ( $meta_field['inner_elements'] as $key => $inner_field ) {
                    $element->add_element( $this->create_element( $inner_field ) );
    
                }

            }

            return $element;

        }


    }

    // add_action( 'admin_menu', array( $this, 'add_submenu_pages' ) );
    // public function add_submenu_pages() {        
    //     add_submenu_page(
    //         'edit.php?post_type=authforms',
    //         __( 'Terms', TEXT_DOMAIN ),
    //         __( 'Terms', TEXT_DOMAIN ),
    //         'manage_options',
    //         'mgf_term_menu',
    //         'mgf_render_term_page'
    //     );

    //     add_submenu_page(
    //         'edit.php?post_type=authforms',
    //         __( 'Config', TEXT_DOMAIN ),
    //         __( 'Config', TEXT_DOMAIN ),
    //         'manage_options',
    //         'mgf_config_menu',
    //         'mgf_render_config_page'
    //     );
    // }