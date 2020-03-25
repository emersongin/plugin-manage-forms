<?php

defined( 'ABSPATH' ) || exit;

class Plugin_Manager {
    public function __construct() {
        $this->setup();

    }

    private function setup() {
        $this->create_constants();
        $this->create_class();
        $this->create_libraries();
        $this->create_settings();

    }

    private function create_constants() {
        define( 'MGF_URL', plugins_url( '', MG_FORMS_FILE ) );
        define( 'MGF_DIR', plugin_dir_path( MG_FORMS_FILE ) );
        define( 'MGF_ADMIN_URL', admin_url( '', MG_FORMS_FILE ) );

        define( 'MGF_DIR_ABSTRACT', MGF_DIR . '/includes/abstract/' );
        define( 'MGF_DIR_CLASS', MGF_DIR . '/includes/class/' );
        define( 'MGF_DIR_INTERFACE', MGF_DIR . '/includes/interface/' );
        define( 'MGF_DIR_DATA', MGF_DIR . '/includes/data/' );
        
        define( 'MGF_DIR_ASSETS', MGF_URL . '/assets/' );
        define( 'TEXT_DOMAIN', 'plugin-manage-forms' );

    }

    private function create_class() {
        //interfaces
        require_once MGF_DIR_INTERFACE . 'interface-script.php';
        require_once MGF_DIR_INTERFACE . 'interface-script-validator.php';
        require_once MGF_DIR_INTERFACE . 'interface-script-js-register.php';
        require_once MGF_DIR_INTERFACE . 'interface-script-js.php';
        require_once MGF_DIR_INTERFACE . 'interface-style-sheet-register.php';
        require_once MGF_DIR_INTERFACE . 'interface-style-sheet.php';

        require_once MGF_DIR_INTERFACE . 'interface-post-type-register.php';
        require_once MGF_DIR_INTERFACE . 'interface-post-type.php';

        require_once MGF_DIR_INTERFACE . 'interface-elements-factory.php';
        require_once MGF_DIR_INTERFACE . 'interface-elements.php';

        //abstracts
        require_once MGF_DIR_ABSTRACT . 'abstract-elements.php';
        require_once MGF_DIR_ABSTRACT . 'abstract-custom-post-type.php';
        require_once MGF_DIR_ABSTRACT . 'abstract-script.php';
        
        //class
        require_once MGF_DIR_CLASS . 'scripts/class-script-validator.php';
        require_once MGF_DIR_CLASS . 'scripts/class-script-js-register.php';
        require_once MGF_DIR_CLASS . 'scripts/class-script-js.php';
        require_once MGF_DIR_CLASS . 'scripts/class-style-sheet-register.php';
        require_once MGF_DIR_CLASS . 'scripts/class-style-sheet.php';

        require_once MGF_DIR_CLASS . 'post-types/class-post-type-register.php';
        require_once MGF_DIR_CLASS . 'post-types/class-authforms.php';
        // require_once MGF_DIR_CLASS . 'post-types/class-terms.php';

        require_once MGF_DIR_CLASS . 'elements/class-elements-factory.php';

        require_once MGF_DIR_CLASS . 'elements/class-element-div.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-p.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-label.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-input.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-button.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-span.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-select.php';
        require_once MGF_DIR_CLASS . 'elements/class-element-option.php';

    }

    private function create_libraries() {
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'load_wp_enqueue_scripts' ) );

    }

    public function load_admin_enqueue_scripts() {
        $this->load_admin_css();

    }

    public function load_wp_enqueue_scripts() {
        $this->load_plugin_css();
        $this->load_plugin_scripts();

    }

    public function load_admin_css() {
        $style_data = array(
            'name' => 'admin-style-css',
            'src' => 'admin-style.css',
            'dependencies' => array(),
            'version' => '1.0',
            'media' => 'all'
        );
        $style = new Style_Sheet( 
            $style_data, 
            new Style_Sheet_Register(), 
            new Script_Validator() 
        );
    }

    public function load_plugin_css() {
        $bootstrap_data = array(
            'name' => 'bootstrap-4-css',
            'src' => 'bootstrap/bootstrap.min.css',
            'dependencies' => array(),
            'version' => '4.4.1',
            'media' => 'all'
        );
        $style_data = array(
            'name' => 'mgf-style-css',
            'src' => 'mgf-style.css',
            'dependencies' => array(),
            'version' => '1.0',
            'media' => 'all'
        );

        $bootstrap = new Style_Sheet( 
            $bootstrap_data, 
                new Style_Sheet_Register(), 
                new Script_Validator() 
            );
        $style = new Style_Sheet( 
            $style_data, 
            new Style_Sheet_Register(), 
            new Script_Validator() 
        );

    }

    public function load_plugin_scripts() {
        $bootstrap_data = array(
            'name' => 'bootstrap-4-js',
            'src' => 'bootstrap/bootstrap.min.js',
            'dependencies' => array( 'jquery' ),
            'version' => '4.4.1',
            'in_footer' => true,
            'object_name' => '',
            'object_params' => array()
        );
        $bootstrap = new Script_JS( 
            $bootstrap_data,
            new Script_JS_Register(),
            new Script_Validator()
        );

    }

    public function create_settings() {
        $this->create_post_types();

    }

    public function create_post_types() {
        $this->create_auth_forms();


    }

    public function create_auth_forms() {
        add_action( 'init', array( $this, 'create_post_type_authforms' ) );

    }

    public function create_post_type_authforms() {
        $post_type = $this->get_data( 'post-types/post-type-authforms.json' ); 
        
        $metabox_service = $this->get_data( 'meta-boxes/meta-boxes-auth-service.json' );
        $metabox_setting = $this->get_data( 'meta-boxes/meta-boxes-auth-settings.json' );

        $metafield_title = $this->get_data( 'meta-fields/input-service-title.json' );
        $metafield_items_list = $this->get_data( 'meta-fields/itemslist-service.json' );

        new Script_JS( $metafield_items_list['script'], new Script_JS_Register(), new Script_Validator());

        $metafield_select_time = $this->get_data( 'meta-fields/select-expiration-time.json' );
        $metafield_select_parcel = $this->get_data( 'meta-fields/select-parcel.json' );
        $metafield_select_term = $this->get_data( 'meta-fields/select-terms.json' );

        $metabox_setting['meta_fields'] = [
            $metafield_select_time,
            $metafield_select_parcel,
            $metafield_select_term
        ];

        $metabox_service['meta_fields'] = [
            $metafield_title,
            $metafield_items_list
        ];

        $post_type['meta_boxes'] = [
            $metabox_service,
            $metabox_setting
        ];


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

        $post_type = new AuthForms_Post_Type( $post_type, new Elements_Factory() );

        $register = new Post_Type_Register();
        $register->register( $post_type );

        add_action( 'add_meta_boxes', array( $post_type, 'create_meta_boxes' ) );


    }

    public function get_data( $path ) {
        return json_decode( file_get_contents( MGF_DIR_DATA . $path ), true );

    }

}
