<?php

    defined( 'ABSPATH' ) || exit;

    class AuthForms_Post_Type extends Custom_Post_Type {
        private $meta_boxes = array();

        public function __construct() {
            $this->meta_boxes = array(
                array(
                    'id' => 'services_meta_box',
                    'title' => __( 'Services', TEXT_DOMAIN ),
                    'post_type' => $this->get_name(),
                    'context' => 'normal',
                    'priority' => 'default',
                    'meta_fields' => array(
                        array(
                            'tag' => 'input',
                            'title' => __( 'Service Title', TEXT_DOMAIN ),
                            'input' => array(
                                'id' => 'service_title',
                                'name' => 'service_title',
                                'type' => 'text',
                                'class' => array(
                                    'large-text'
                                ),
                                'value' => '',
                                'placeholder' => 'title text',
                                'required' => true
                            )                            
                        ),
                        array(
                            'tag' => 'list',
                            'items' => array(
                                //array( 'text' => 'item 1', 'value' => 250 )
                            ),
                            'title' => __( 'Service Items', TEXT_DOMAIN )
                        )
                    )
                ),
                array(
                    'id' => 'settings_meta_box',
                    'title' => __( 'Settings', TEXT_DOMAIN ),
                    'post_type' => $this->get_name(),
                    'context' => 'normal',
                    'priority' => 'default',
                    'meta_fields' => array(
                        array(
                            'name' => 'expiration_time',
                            'tag' => 'select'
                        ),
                        array(
                            'name' => 'service_parcel',
                            'tag' => 'select'
                        ),
                        array(
                            'name' => 'contract_id',
                            'tag' => 'select'
                        ),
                    )
                )
                // 'title',
                // 'content',
                // 'status',
                // 'expiration_time',
                // 'secret_key',
                // 'service_title',
                // 'service_items',
                // 'service_parcel',
                // 'contract_id',
                // 'origin',
                // 'document_create_by',
                // 'document_create_at'
            );

            add_action( 'add_meta_boxes', array( $this, 'create_meta_boxes' ) );

        }

        public function create_meta_boxes() {    
            foreach ( $this->meta_boxes as $meta_box ) {
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
            foreach ( $meta_box['args'] as $key => $value) {

                switch ( $value['tag'] ) {
                    case 'input':
                        $input = new Input( $value['input'] );

                        $input->set_title( $value['title'] );
                        $input->create_elements( 'Element' );
                        $input->app_end();

                        break;
                    case 'list':
                        $list = new Items_List( $value['items'] );

                        $list->set_title( $value['title'] );
                        $list->load_script( new JS_Script() );
                        $list->create_elements( 'Element' );
                        $list->app_end();

                        break;
                    default:
                        echo 'others';
                        break;
                }

            }   
        }

    }