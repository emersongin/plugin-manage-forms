<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Custom_Post_Type implements Interface_Post_type {
        private $name = '';
        private $labels = array();
        private $description = '';
        private $public = true;
        private $menu_position = 20;
        private $menu_icon = 'none';
        private $supports = array();
        private $meta_boxes = array();
        private $save_post_fields = array();
        protected $elements_factory = null;

        public function __construct( Array $post_type_data, Interface_Elements_Factory $elements_factory ) {
            $this->name = substr( sanitize_key( $post_type_data['name'] ), 0, 20 );
            $this->labels = $post_type_data['labels'];
            $this->description = $post_type_data['description'];
            $this->public = $post_type_data['public'];
            $this->menu_position = $post_type_data['menu_position'];
            $this->menu_icon = $post_type_data['menu_icon'];
            $this->supports = $post_type_data['supports'];
            $this->meta_boxes = $post_type_data['meta_boxes'];
            $this->wp_list = $post_type_data['wp_list'];
            $this->save_post_fields = $post_type_data['save_post'];
            $this->elements_factory = $elements_factory;

            add_filter( "manage_{$this->name}_posts_columns", array( $this, 'wp_list_header' ) );
            add_action( "manage_{$this->name}_posts_custom_column", array( $this, 'wp_list_columns' ), 10, 2 );
            add_filter( "manage_edit-{$this->name}_sortable_columns", array( $this, 'wp_list_table_sorting' ) );
            add_filter( 'request', array( $this, 'wp_list_value_column_orderby' ) );
            add_action( "save_post_{$this->name}", array( $this, 'save_post_type' ) );

        }

        public function get_name() {
            return $this->name;

        }

        public function get_labels() {
            return $this->labels;

        }

        public function get_description() {
            return $this->description;

        }

        public function is_public() {
            return $this->public;

        }

        public function get_menu_position() {
            return $this->menu_position;

        }

        public function get_menu_icon() {
            return $this->menu_icon;

        }  
        
        public function get_supports() {
            return $this->supports;

        }

        public function get_meta_boxes() {
            return $this->meta_boxes;

        }

        public function wp_list_header( $defaults ) {
            //$new = array();

            // $new['id'] =  __( 'ID', TEXT_DOMAIN );
            // $new['status'] =  __( 'Status', TEXT_DOMAIN );
            // $new['title'] =  __( 'Client Name', TEXT_DOMAIN );
            // $new['value'] = __( 'Value', TEXT_DOMAIN );
            // $new['expiration'] = __( 'Expires In', TEXT_DOMAIN );
            // $new['actions'] = __( 'Actions', TEXT_DOMAIN );
            // $new['created'] = __( 'Created by', TEXT_DOMAIN );
            // $new['date'] =  __( 'In', TEXT_DOMAIN );

            return $this->wp_list['header'];

        }

        public function wp_list_columns( $column_name, $post_id ) {            
            switch ( $column_name ) {
                case 'id':
                    echo $post_id;

                    break;
                case 'status':
                    $status = get_post_meta( $post_id, '_doc_status', true );
                    echo $status;

                    break;
                case 'value':
                    $value = get_post_meta( $post_id, '_doc_value', true );
                    echo $value;

                    break;
                case 'expiration':
                    $expiration = get_post_meta( $post_id, '_doc_expiration', true );
                    echo $expiration;

                    break;
                case 'actions':
                    echo $this->colum_action_buttons( $post_id );

                    break;
                case 'created':
                    $create_by = get_post_meta( $post_id, '_doc_create_by', true );
                    echo $create_by;

                    break;
                default:
                    # code...
                    break;
            }
        
        }

        public function wp_list_table_sorting( $columns ) {
            $columns['value'] = 'value';

            return $columns;
        }

        public function wp_list_value_column_orderby( $vars ) {
            if ( isset( $vars['orderby'] ) && 'value' == $vars['orderby'] ) {
                $vars = array_merge( $vars, array(
                    'meta_key' => '_doc_value',
                    'orderby' => 'meta_value'
                ) );
            }
        
            return $vars;
        }

        public function colum_action_buttons( $id ) {
            $class = "button action deb-m-0-5";
            $data = " data-button='{$id}' disabled ";
    
            return  
                "<div style='position: relative !important'>".
                "<div class='div-block'><div class='lds-dual-ring'></div></div>".    
                "<button {$data}class='btn-edit {$class}' title='Editar'><i class='fas fa-edit'></i></button>".
                "<button {$data}class='btn-reac {$class}' title='Reativar'><i class='far fa-clock'></i></button>". 
                "<button {$data}class='btn-disb {$class}' title='Desativar'><i class='fas fa-times-circle'></i></button>". 
                "<button {$data}class='btn-link {$class}' title='Link'><i class='fas fa-link'></i></button>". 
                "<button {$data}class='btn-file {$class}' title='Arquivo'><i class='fas fa-file'></i></button>".
                "<div>";
    
        }

        public function save_post_type( $post_id ) {
            global $post;
            $post_fields = array();
            $item_list = array();

            if ( isset( $post->post_type ) and $post->post_type != $this->name ) {
                return;
            }

            if ( isset( $_POST['hidden_post_status'] ) ) {
                $post_fields = $this->save_post_fields[ $_POST[ 'hidden_post_status' ] ];

                foreach ( $post_fields as $post_field ) {
                    switch ( $post_field ) {
                        case 'service_items':
                            if ( isset( $_POST['item_service_text'] ) and count( $_POST['item_service_text'] ) ) {
                
                                foreach ( $_POST['item_service_text'] as $key => $value ) {
                                    $item_list[] = array(
                                        'text' => $value,
                                        'value' => $_POST['item_service_value'][$key]
                                    );
                
                                }
                
                            }

                            if ( count( $item_list ) ) {
                                update_post_meta( $post_id, '_list_items', $item_list );
                
                            }

                            break;
                        
                        default:
                            if ( isset( $_POST[ $post_field ] ) ) {
                                update_post_meta( $post_id, "_{$post_field}", $_POST[ $post_field ] );
                
                            }
                            break;

                    }
                }

            }

        }

    }
