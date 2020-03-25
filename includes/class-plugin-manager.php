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

        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-div.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-p.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-label.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-input.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-button.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-span.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-select.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element-option.php';

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
                            'tag' => 'div',
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(
                                array(
                                    'tag' => 'label',
                                    'text' => array(
                                        'value' => __( 'Service Title', TEXT_DOMAIN ),
                                        'priority' => 'before'
                                    ),
                                    'attributes' => array(
                                        'for' => 'service-title'
                                    )
                                ),
                                array(
                                    'tag' => 'input',
                                    'attributes' => array(
                                        'id' => 'service-title',
                                        'name' => 'service-title',
                                        'type' => 'text',
                                        'class' => array(
                                            'large-text',
                                            'wrap'
                                        ),
                                        'placeholder' => 'title text',
                                        'required' => true
                                    )
                                )
                            )
                        ),
                        array(
                            'tag' => 'div',
                            'text' => array(
                                'value' => 'Items List',
                                'priority' => 'before'
                            ),
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                                'style' => array(
                                    'background-color: #B4B9BE;',
                                    'border-radius: 4px;',
                                    'padding: 6px;'
                                )
                            ),
                            'inner_elements' => array(
                                array(
                                    'tag' => 'div',
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
                                                'id' => 'list-items',
                                                'items' => array(
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
                                                    )
                                                )
                                            )
                                        ),
                                        new Script_JS_Register(),
                                        new Script_Validator()
                                    )
                                ),
                                array(
                                    'tag' => 'button',
                                    'text' => array(
                                        'value' => 'Add item',
                                        'priority' => 'after'
                                    ),
                                    'attributes' => array(
                                        'id' => 'list-items-add',
                                        'type' => 'button',
                                        'class' => array(
                                            'button-primary'
                                        )
                                    ),
                                    'inner_elements' => array(
                                        array(
                                            'tag' => 'span',
                                            'attributes' => array(
                                                'style' => 'margin-top: 6px;',
                                                'class' => array(
                                                    'dashicons',
                                                    'dashicons-plus'
                                                )
                                            )
                                        )
                                    )
                                ),
                                array(
                                    'tag' => 'div',
                                    'text' => array(
                                        'value' => 'Total 0,00',
                                        'priority' => 'before'
                                    ),
                                    'attributes' => array(
                                        'id' => 'list-items-total',
                                        'style' => array(
                                            'float: right;',
                                            'padding: 4px;',
                                            'background-color: white;',
                                            'border-radius: 2px;',
                                            'font-weight: 800'
                                        )
                                    )
                                )
                            )
                        )
                    )
                ),
                array(
                    'id' => 'settings_meta_box',
                    'title' => __( 'Settings', TEXT_DOMAIN ),
                    'post_type' => 'authforms',
                    'context' => 'normal',
                    'priority' => 'default',
                    'meta_fields' => array(
                        array(
                            'tag' => 'div',
                            'text' => array(
                                'value' => 'Expiration Time',
                                'priority' => 'before'
                            ),
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(  
                                array(
                                    'tag' => 'p',
                                    'attributes' => array(
                                        'class' => 'wrap'
                                    ),
                                    'inner_elements' => array(  
                                        array(
                                            'tag' => 'select',
                                            'attributes' => array(
                                                'id' => 'expiration_time',
                                                'style' => array(
                                                    'width: 300px;'
                                                )
                                            ),
                                            'inner_elements' => array(
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => 'Selecione a duração',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '',
                                                        'disabled' => 'true',
                                                        'selected' => 'true'
                                                    )
                                                ),
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => '30 Minutos',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '1'
                                                    )
                                                ),
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => '1 Hora',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '2'
                                                    )
                                                ),
                                            )
                                        )
                                    )
                                )
                            )
                        ),
                        array(
                            'tag' => 'div',
                            'text' => array(
                                'value' => 'Service Parcel',
                                'priority' => 'before'
                            ),
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(  
                                array(
                                    'tag' => 'p',
                                    'attributes' => array(
                                        'class' => 'wrap'
                                    ),
                                    'inner_elements' => array(  
                                        array(
                                            'tag' => 'select',
                                            'attributes' => array(
                                                'id' => 'service_parcel',
                                                'style' => array(
                                                    'width: 300px;'
                                                )
                                            ),
                                            'inner_elements' => array(
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => 'Selecione quantidade de parcelas',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '',
                                                        'disabled' => 'true',
                                                        'selected' => 'true'
                                                    )
                                                ),
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => '( 1x parcela ) à vista ',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '1'
                                                    )
                                                ),
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => '( 2x parcela )',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '2'
                                                    )
                                                ),
                                            )
                                        )
                                    )
                                )
                            )
                        ),
                        array(
                            'tag' => 'div',
                            'text' => array(
                                'value' => 'Contract ID',
                                'priority' => 'before'
                            ),
                            'attributes' => array(
                                'class' => array(
                                    'wrap'
                                ),
                            ),
                            'inner_elements' => array(  
                                array(
                                    'tag' => 'p',
                                    'attributes' => array(
                                        'class' => 'wrap'
                                    ),
                                    'inner_elements' => array(  
                                        array(
                                            'tag' => 'select',
                                            'attributes' => array(
                                                'id' => 'contract_id',
                                                'style' => array(
                                                    'width: 300px;'
                                                )
                                            ),
                                            'inner_elements' => array(
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => 'Selecione o termo',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '',
                                                        'disabled' => 'true',
                                                        'selected' => 'true'
                                                    )
                                                ),
                                                array(
                                                    'tag' => 'option',
                                                    'text' => array(
                                                        'value' => 'termo 01',
                                                        'priority' => 'before'
                                                    ),
                                                    'attributes' => array(
                                                        'value' => '1'
                                                    )
                                                ),
                                            )
                                        )
                                    )
                                )
                            )
                        )
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
            )
        );
        $post_type = new AuthForms_Post_Type( $post_type_data, new Elements_Factory() );

        $register = new Post_Type_Register();
        $register->register( $post_type );

        add_action( 'add_meta_boxes', array( $post_type, 'create_meta_boxes' ) );

    }

}
