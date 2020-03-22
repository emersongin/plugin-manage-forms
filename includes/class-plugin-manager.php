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
        define( 'MG_FORMS_URL', plugins_url( '', MG_FORMS_FILE ) );
        define( 'MG_FORMS_DIR', plugin_dir_path( MG_FORMS_FILE ) );
        define( 'MG_FORMS_ADMIN_URL', admin_url( '', MG_FORMS_FILE ) );
        define( 'MG_FORMS_ASSETS', MG_FORMS_URL . '/assets' );
        define( 'TEXT_DOMAIN', 'plugin-manage-forms' );

    }

    private function create_class() {
        //interfaces
        require_once MG_FORMS_DIR . '/includes/interface/interface-script.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-script-validator.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-script-js-register.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-script-js.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-style-sheet-register.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-style-sheet.php';

        require_once MG_FORMS_DIR . '/includes/interface/interface-post-type-register.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-post-type.php';

        require_once MG_FORMS_DIR . '/includes/interface/interface-elements-factory.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-elements.php';

        //abstracts
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-elements.php';
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-custom-post-type.php';
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-script.php';
        
        //class
        require_once MG_FORMS_DIR . '/includes/class/scripts/class-script-validator.php';
        require_once MG_FORMS_DIR . '/includes/class/scripts/class-script-js-register.php';
        require_once MG_FORMS_DIR . '/includes/class/scripts/class-script-js.php';
        require_once MG_FORMS_DIR . '/includes/class/scripts/class-style-sheet-register.php';
        require_once MG_FORMS_DIR . '/includes/class/scripts/class-style-sheet.php';

        require_once MG_FORMS_DIR . '/includes/class/post-types/class-post-type-register.php';
        require_once MG_FORMS_DIR . '/includes/class/post-types/class-authforms.php';
        // require_once MG_FORMS_DIR . '/includes/class/post-types/class-terms.php';

        require_once MG_FORMS_DIR . '/includes/class/elements/class-elements-factory.php';

        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-container.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-input.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-items-list.php';

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
        $post_type_data = array(
            'name' => 'authforms',
            'menu_icon' => 'dashicons-admin-page',
            'menu_position' => 20,
            'labels' => array(
                'name' => __( 'Forms', TEXT_DOMAIN ),
                'singular_name' => __( 'Form', TEXT_DOMAIN ),
                'all_items' => __( 'All forms', TEXT_DOMAIN )
            ),
            'description' => 'Any things...',
            'public' => true,
            'supports' => array(
                'title', 'editor'
            ),
            'meta_boxes' => array(
                array(
                    'id' => 'services_meta_box',
                    'title' => __( 'Services', TEXT_DOMAIN ),
                    'post_type' => 'authforms',
                    'context' => 'normal',
                    'priority' => 'default',
                    'meta_fields' => array(
                        array(
                            'tag' => 'container',
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(
                                array(
                                    'tag' => 'input',
                                    'label' => __( 'Service Title', TEXT_DOMAIN ),
                                    'attributes' => array(
                                        'id' => 'service-title',
                                        'name' => 'service-title',
                                        'type' => 'text',
                                        'class' => array(
                                            'large-text'
                                        ),
                                        'placeholder' => 'title text',
                                        'required' => true
                                    ),
                                    'inner_elements' => array(
                                        
                                    )
                                )
                            )
                        ),
                        array(
                            'tag' => 'container',
                            'text' => 'Items List',
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(
                                array(
                                    'tag' => 'itemslist',
                                    'attributes' => array(
                                        'id' => 'list-items'
                                    ),
                                    'script' => new Script_JS( 
                                        array(
                                            'name' => 'admin-items-list-js',
                                            'src' => 'elements-items-list.js',
                                            'dependencies' => array(),
                                            'version' => '1.0',
                                            'in_footer' => true,
                                            'object_name' => 'itemsList',
                                            'object_params' => array(
                                                array(
                                                    'text' => 'item 1',
                                                    'value' => 200
                                                ),
                                                array(
                                                    'text' => 'item 2',
                                                    'value' => 150
                                                ),
                                                array(
                                                    'text' => 'item 3',
                                                    'value' => 10.5
                                                ),
                                            )
                                        ),
                                        new Script_JS_Register(),
                                        new Script_Validator()
                                    ),
                                    'inner_elements' => array(
                                        
                                    )
                                )
                            )
                        )
                    )
                )
                // array(
                //     'id' => 'services_meta_box',
                //     'title' => __( 'Services', TEXT_DOMAIN ),
                //     'post_type' => 'authforms',
                //     'context' => 'normal',
                //     'priority' => 'default',
                //     'meta_fields' => array(
                //         array(
                //             'tag' => 'input',
                //             'title' => __( 'Service Title', TEXT_DOMAIN ),
                //             'input' => array(
                //                 'id' => 'service_title',
                //                 'name' => 'service_title',
                //                 'type' => 'text',
                //                 'class' => array(
                //                     'large-text'
                //                 ),
                //                 'value' => '',
                //                 'placeholder' => 'title text',
                //                 'required' => true
                //             )                            
                //         ),
                //         array(
                //             'tag' => 'list',
                //             'items' => array(
                //                 //array( 'text' => 'item 1', 'value' => 250 )
                //             ),
                //             'title' => __( 'Service Items', TEXT_DOMAIN )
                //         )
                //     )
                // ),
                // array(
                //     'id' => 'settings_meta_box',
                //     'title' => __( 'Settings', TEXT_DOMAIN ),
                //     'post_type' => 'authforms',
                //     'context' => 'normal',
                //     'priority' => 'default',
                //     'meta_fields' => array(
                //         array(
                //             'name' => 'expiration_time',
                //             'tag' => 'select'
                //         ),
                //         array(
                //             'name' => 'service_parcel',
                //             'tag' => 'select'
                //         ),
                //         array(
                //             'name' => 'contract_id',
                //             'tag' => 'select'
                //         ),
                //     )
                // )
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
            )
        );
        $post_type = new AuthForms_Post_Type( $post_type_data, new Elements_Factory() );

        $register = new Post_Type_Register();
        $register->register( $post_type );

        add_action( 'add_meta_boxes', array( $post_type, 'create_meta_boxes' ) );

    }

}
