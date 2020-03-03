<?php

defined( 'ABSPATH' ) || exit;

class Plugin_Manager {
    function __construct() {
        $this->setup();

    }

    public function setup() {
        $this->load_constants();
        $this->load_class();
        $this->load_libraries();
        $this->load_settings();

    }

    public function load_constants() {
        define( 'MG_FORMS_URL', plugins_url( '', MG_FORMS_FILE ) );
        define( 'MG_FORMS_DIR', plugin_dir_path( MG_FORMS_FILE ) );
        define( 'MG_FORMS_ADMIN_URL', admin_url( '', MG_FORMS_FILE ) );
        
        define( 'MG_FORMS_ASSETS', MG_FORMS_URL . '/assets' );

        define( 'TEXT_DOMAIN', 'plugin-manage-forms' );

    }

    public function load_class() {
        //interfaces
        require_once MG_FORMS_DIR . '/includes/interface/interface-elements.php';
        require_once MG_FORMS_DIR . '/includes/interface/interface-script.php';

        //abstracts
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-elements.php';
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-script.php';
        require_once MG_FORMS_DIR . '/includes/abstract/abstract-custom-post-type.php';

        //class
        require_once MG_FORMS_DIR . '/includes/class/class-script-js.php';
        require_once MG_FORMS_DIR . '/includes/class/class-style-sheet.php';

        //class post types
        require_once MG_FORMS_DIR . '/includes/class/post-types/class-authforms.php';
        require_once MG_FORMS_DIR . '/includes/class/post-types/class-terms.php';

        //class elements
        require_once MG_FORMS_DIR . '/includes/class/elements/class-element.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-input.php';
        require_once MG_FORMS_DIR . '/includes/class/elements/class-items-list.php';

    }

    public function load_libraries() {
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_enqueue_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'load_wp_enqueue_scripts' ) );

    }

    public function load_admin_enqueue_scripts() {
        $this->load_admin_fonts();
        $this->load_admin_css();

    }

    public function load_wp_enqueue_scripts() {
        $this->load_plugin_css();
        $this->load_plugin_scripts();

    }

    public function load_admin_fonts() {
        $font_awesome = new Style_Sheet();

        $font_awesome->set_name( 'fonts-awesome' );
        $font_awesome->set_version( '5.12.0' );
        $font_awesome->set_src( 'fontawesome-free-5.12.0-web/css/all.min.css' );
        $font_awesome->set_media( 'all' );
        $font_awesome->register();
        $font_awesome->enqueue();

    }

    public function load_admin_css() {
        $style = new Style_Sheet();

        $style->set_name( 'admin-style-css' );
        $style->set_version( '1.0' );
        $style->set_src( 'admin-style.css' );
        $style->set_media( 'all' );
        $style->register();
        $style->enqueue();
    }

    public function load_plugin_css() {
        $bootstrap = new JS_Script();
        $style = new JS_Script();

        $bootstrap->set_name( 'bootstrap-4-css' );
        $bootstrap->set_version( '4.4.1' );
        $bootstrap->set_src( 'bootstrap/bootstrap.min.css' );
        $bootstrap->insert_footer( true );
        $bootstrap->register();
        $bootstrap->enqueue();
        
        $style->set_name( 'mgf-style-css' );
        $style->set_version( '1.0' );
        $style->set_src( 'mgf-style.css' );
        $style->insert_footer( true );
        $style->register();
        $style->enqueue();

    }

    public function load_plugin_scripts() {
        $bootstrap = new JS_Script();

        $bootstrap->set_name( 'bootstrap-4-js' );
        $bootstrap->set_version( '4.4.1' );
        $bootstrap->set_src( 'bootstrap/bootstrap.min.js' );
        $bootstrap->add_dependecy( 'jquery' );
        $bootstrap->insert_footer( true );
        $bootstrap->register();
        $bootstrap->enqueue();

    }

    public function load_settings() {
        $this->load_post_types();

    }

    public function load_post_types() {
        add_action( 'init', array( $this, 'load_authforms_post_type' ) );

    }

    public function load_authforms_post_type() {
        $post_type = new AuthForms_Post_Type();

        $post_type->set_name( 'authforms' );
        $post_type->set_menu_icon( 'dashicons-admin-page' );
        $post_type->set_labels( array(
            'name' => __( 'Forms', TEXT_DOMAIN ),
            'singular_name' => __( 'Form', TEXT_DOMAIN ),
            'all_items' => __( 'All forms', TEXT_DOMAIN )
        ));
        $post_type->add_support( 'title' );
        $post_type->add_support( 'editor' );

        $post_type->register();

    }

}
