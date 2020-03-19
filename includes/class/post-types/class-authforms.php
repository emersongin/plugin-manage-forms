<?php

    defined( 'ABSPATH' ) || exit;

    class AuthForms_Post_Type extends Custom_Post_Type {

        public function __construct( Array $post_type_data ) {
            parent::__construct( $post_type_data );

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

                        $script_data = array(
                            'name' => 'admin-items-list-js',
                            'src' => 'admin-items-list.js',
                            'dependencies' => array(),
                            'version' => '1.0',
                            'object_name' => 'itemsList',
                            'action_name' => 'admin_enqueue_scripts',
                            'object_params' => array(),
                            'in_footer' => true
                        );

                        $list->set_title( $value['title'] );
                        $list->load_script( new JS_Script( $script_data ) );
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






    class MGF_Post_Types {

        private function authforms_post_type() {
            add_filter( 'manage_authforms_posts_columns', array( $this, 'header_wp_list_authforms' ) );
            add_action( 'manage_authforms_posts_custom_column', array( $this, 'columns_wp_list_authforms' ), 10, 2 );
            add_filter( 'manage_edit-authforms_sortable_columns', array( $this, 'authforms_table_sorting' ) );
            add_filter( 'request', array( $this, 'authforms_value_column_orderby' ) );

        }

        public function header_wp_list_authforms( $defaults ) {
            $new = array();

            $new['id'] =  __( 'ID', TEXT_DOMAIN );
            $new['status'] =  __( 'Status', TEXT_DOMAIN );
            $new['title'] =  __( 'Client Name', TEXT_DOMAIN );
            $new['value'] = __( 'Value', TEXT_DOMAIN );
            $new['expiration'] = __( 'Expires In', TEXT_DOMAIN );
            $new['actions'] = __( 'Actions', TEXT_DOMAIN );
            $new['created'] = __( 'Created by', TEXT_DOMAIN );
            $new['date'] =  __( 'In', TEXT_DOMAIN );

            return $new;

        }

        public function columns_wp_list_authforms( $column_name, $post_id ) {            
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

        function authforms_table_sorting( $columns ) {

            $columns['value'] = 'value';

            return $columns;
        }

        function authforms_value_column_orderby( $vars ) {
            if ( isset( $vars['orderby'] ) && 'value' == $vars['orderby'] ) {
                $vars = array_merge( $vars, array(
                    'meta_key' => '_doc_value',
                    'orderby' => 'meta_value'
                ) );
            }
        
            return $vars;
        }

        private function colum_action_buttons( $id ) {
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