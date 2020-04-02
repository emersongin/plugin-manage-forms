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

            //echo "post: " . get_post_meta( $post->ID, "_post", true ) . "<br>";
            
            echo "title: " . get_the_title() . "<br>";
            echo "content: " . get_post_meta( $post->ID, "_content", true ) . "<br>";
            echo "status: " . get_post_meta( $post->ID, "_status", true ) . "<br>";
            echo "expiration_time: " . get_post_meta( $post->ID, "_expiration_time", true ) . "<br>";
            echo "secret_key: " . get_post_meta( $post->ID, "_secret_key", true ) . "<br>";
            echo "service_title: " . get_post_meta( $post->ID, "_service_title", true ) . "<br>";
            echo "service_items: " . json_encode( get_post_meta( $post->ID, "_service_items", true ) ) . "<br>";
            echo "service_expiration_time: " . get_post_meta( $post->ID, "_service_expiration_time", true ) . "<br>";
            echo "service_parcel: " . get_post_meta( $post->ID, "_service_parcel", true ) . "<br>";
            echo "contract_id: " . get_post_meta( $post->ID, "_contract_id", true ) . "<br>";
            echo "origin: " . json_encode( get_post_meta( $post->ID, "_origin", true ) ) . "<br>";
            echo "document_create_by: " . get_post_meta( $post->ID, "_document_create_by", true ) . "<br>";
            echo "document_create_at: " . get_post_meta( $post->ID, "_document_create_at", true ) . "<br>";

            foreach ( $meta_box['args'] as $key => $meta_field ) {
                if ( $meta_field['tag'] ) {
                    $field = $this->create_element( $post, $meta_field );
                    $field->append();
                    
                }

            }   

        }

        private function create_element( $post, $meta_field ) {
            $element = null;

            if ( isset( $meta_field['insert_value'] ) ) {
                $meta_field = $this->add_value( $post, $meta_field );

                if ( isset( $meta_field['scripts'] ) ) {
                    new Script_JS( $meta_field['scripts'], new Script_JS_Register(), new Script_Validator() );
    
                }
    
                if ( isset( $meta_field['styles'] ) ) {
                    new Style_Sheet( $meta_field['scripts'], new Style_Sheet_Register(), new Script_Validator() );
    
                }

            }

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
                    $element->add_element( $this->create_element( $post, $inner_field ) );
    
                }

            }

            return $element;

        }

        private function add_value( $post, $meta_field ) {
            $data = '';

            switch ( $meta_field['insert_value'] ) {
                case 'value':
                    $slug = $meta_field['attributes']['id'];
                    $data = get_post_meta( $post->ID, "_{$slug}", true );
                    $meta_field['attributes']['value'] = $data;
                    break;

                case 'script':
                    $slug = $meta_field['attributes']['id'];
                    $data = get_post_meta( $post->ID, "_{$slug}", true );
                    $meta_field['scripts']['object_params']['items'] = $data;
                    break;

                case 'select':
                    $slug = $meta_field['attributes']['id'];
                    $data = get_post_meta( $post->ID, "_{$slug}", true );

                    for ( $index = 0; $index < count( $meta_field['inner_elements'] ); $index++) { 
                        if ( $meta_field['inner_elements'][$index]['attributes']['value'] == $data ) {
                            $meta_field['inner_elements'][$index]['attributes']['selected'] = true;

                        } 

                    }

                    break;

                case 'select-wp-list':

                    break;
                default:
                    # code...
                    break;
            }
            

            return $meta_field;

        }

        protected function save_meta_type( $post_id, $post_status, $post_field ) {
            switch ( $post_field ) {
                case 'service_items':
                    $item_list = array();

                    if ( isset( $_POST['item_service_text'] ) and count( $_POST['item_service_text'] ) ) {
                        foreach ( $_POST['item_service_text'] as $key => $value ) {
                            $item_list[] = array(
                                'text' => $value,
                                'value' => $_POST['item_service_value'][$key]
                            );
                        }
                    }
        
                    if ( count( $item_list ) ) {
                        update_post_meta( $post_id, "_{$post_field}", $item_list );
        
                    }
        
                    break;
                case 'status':
                    if ( $post_status == 'draft' ) {
                        update_post_meta( $post_id, "_{$post_field}", 'A' );

                    }

                    break;

                case 'expiration_time':
                    $exp_time = $this->get_expiration_time( $_POST['service_expiration_time'] );
                    update_post_meta( $post_id, "_{$post_field}", $exp_time );
                    
                    break;
                case 'secret_key':
                    $hash_key = hash( 'adler32' , rand( 0, strtotime("now") ) );
                    update_post_meta( $post_id, "_{$post_field}", $hash_key );

                    break;
                case 'origin':
                    $data_origin = array(
                        'ip' => User_Info::get_ip(),
                        'os' => User_Info::get_os(),
                        'browser' => User_Info::get_browser(),
                        'device' => User_Info::get_device()
                    );
                    update_post_meta( $post_id, "_{$post_field}", $data_origin );

                    break;
                case 'document_create_by':
                    $user_now = get_userdata( get_current_user_id() )->user_login;
                    update_post_meta( $post_id, "_{$post_field}", $user_now );
                    
                    break;
                case 'document_create_at':
                    $time_now = strtotime( "now" );
                    update_post_meta( $post_id, "_{$post_field}", $time_now );

                    break;
                default:
                    if ( isset( $_POST[ $post_field ] ) ) {
                        update_post_meta( $post_id, "_{$post_field}", $_POST[ $post_field ] );
        
                    }

                    break;
        
            }

            // "title",
            // "content",
            // "status",
            // "expiration_time",
            // "secret_key",
            // "service_title",
            // "service_items",
            // "service_expiration_time",
            // "service_parcel",
            // "contract_id",
            // "origin",
            // "document_create_by",
            // "document_create_at"
        }

        private function get_expiration_time( $choice ) {
            $time_now = strtotime("now");

            switch ( $choice ) {
                case '1':
                    return $time_now + ( 30 * MINUTE_IN_SECONDS );
                break;

                case '2':
                    return $time_now + HOUR_IN_SECONDS;
                break;

                case '3':
                    return $time_now + ( 3 * HOUR_IN_SECONDS );
                break;

                case '4':
                    return $time_now + ( 12 * HOUR_IN_SECONDS );
                break;

                case '5':
                    return $time_now + DAY_IN_SECONDS;
                break;

                case '6':
                    return $time_now + ( 3 * DAY_IN_SECONDS );
                break;

                case '7':
                    return $time_now + WEEK_IN_SECONDS;
                break;

                case '8':
                    return $time_now + ( 15 * DAY_IN_SECONDS );
                break;

                case '9':
                    return $time_now + MONTH_IN_SECONDS;
                break;

                default:
                    return $time_now + ( 30 * MINUTE_IN_SECONDS );
                break;

            }
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