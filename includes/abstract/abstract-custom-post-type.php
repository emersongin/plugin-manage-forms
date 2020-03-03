<?php

    defined( 'ABSPATH' ) || exit;

    abstract class Custom_Post_Type  {
        private $name = '';
        private $labels = array();
        private $description = '';
        private $public = true;
        private $menu_position = 20;
        private $menu_icon = 'none';
        private $supports = array();

        public function register() {
            register_post_type( 
                $this->get_name(), 
                array(
                    'labels' => $this->get_labels(),
                    'description' => $this->get_description(),
                    'public' => $this->is_public(),
                    'menu_position' => $this->get_menu_position(),
                    'menu_icon' => $this->get_menu_icon(),
                    'supports' => $this->get_supports(),
                )
            );

        }

        public function set_name( $name ) {
            $name = sanitize_key( $name );

            if ( strlen( $name ) > 20 ) {
                $name = substr( $name, 0, 20 );

            }

            $this->name = $name;

        }

        public function get_name() {
            return $this->name;

        }

        public function set_labels( $labels ) {
            $this->labels = $labels;

        }

        public function add_label( $label ) {
            $this->labels[ $label->key ] = $label->value;

        }

        public function get_labels() {
            return $this->labels;

        }

        public function set_description( $description ) {
            $this->description = $description;

        }

        public function get_description() {
            return $this->description;

        }

        public function enable_public() {
            $this->public = true;

        }

        public function disable_public() {
            $this->public = false;

        }

        public function is_public() {
            return $this->public;

        }

        public function set_menu_position( $number ) {
            if ( $this->is_show_in_menu() ) {
                $this->menu_position = intval( $number );
                
            } else {
                $this->menu_position = 20;

            }
            
        }

        public function get_menu_position() {
            return $this->menu_position;

        }

        public function set_menu_icon( $dashicons_class = 'none' ) {
            $this->menu_icon = $dashicons_class;

        }

        public function get_menu_icon() {
            return $this->menu_icon;

        }  
        
        public function set_supports( $list ) {
            $this->supports = $list;

        }

        public function add_support( $label ) {
            $this->supports[] = $label;
            
        }

        public function get_supports() {
            return $this->supports;

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