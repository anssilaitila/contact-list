<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Contact_List
 * @subpackage Contact_List/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Contact_List
 * @subpackage Contact_List/includes
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Contact_List
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Contact_List_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected  $loader ;
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected  $plugin_name ;
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected  $version ;
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if ( defined( 'CONTACT_LIST_VERSION' ) ) {
            $this->version = CONTACT_LIST_VERSION;
        }
        $this->plugin_name = 'contact-list';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Contact_List_Loader. Orchestrates the hooks of the plugin.
     * - Contact_List_i18n. Defines internationalization functionality.
     * - Contact_List_Admin. Defines all hooks for the admin area.
     * - Contact_List_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-contact-list-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-contact-list-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-contact-list-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-contact-list-settings.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-contact-list-public.php';
        /**
         * The class responsible for defining custom fields for the custom post type
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-contact-list-custom-fields.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-contact-list-helpers.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-shortcode_contact_list.php';
        $this->loader = new Contact_List_Loader();
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Contact_List_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Contact_List_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Contact_List_Admin( $this->get_plugin_name(), $this->get_version() );
        $plugin_settings = new ContactListSettings();
        $plugin_custom_fields = new myCustomFields();
        $this->loader->add_action( 'plugins_loaded', $plugin_settings, 'update_db_check' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_admin, 'create_custom_post_type_contact' );
        $this->loader->add_action(
            'init',
            $plugin_admin,
            'create_contact_list_custom_taxonomy',
            0
        );
        $this->loader->add_action(
            'contact-group_edit_form_fields',
            $plugin_admin,
            'contact_group_taxonomy_custom_fields',
            10,
            2
        );
        $this->loader->add_action(
            'edited_contact-group',
            $plugin_admin,
            'save_taxonomy_custom_fields',
            10,
            2
        );
        $this->loader->add_action( 'pre_get_posts', $plugin_admin, 'contact_list_custom_orderby' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_import_page' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_send_email_page' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_mail_log_page' );
        $this->loader->add_action( 'wp_ajax_cl_send_mail', $plugin_admin, 'cl_send_mail' );
        $this->loader->add_action(
            'wp_insert_post',
            $plugin_admin,
            'new_contact_send_email',
            10,
            3
        );
        $this->loader->add_action( 'phpmailer_init', $plugin_admin, 'wp_mail_returnpath_phpmailer_init' );
        $this->loader->add_action( 'admin_menu', $plugin_settings, 'register_support_page' );
        $this->loader->add_action( 'admin_menu', $plugin_settings, 'add_settings_link' );
        $this->loader->add_action( 'admin_menu', $plugin_settings, 'add_upgrade_link' );
        $this->loader->add_action( 'admin_menu', $plugin_settings, 'contact_list_add_admin_menu' );
        $this->loader->add_action( 'admin_init', $plugin_settings, 'contact_list_settings_init' );
        $this->loader->add_filter( 'request', $plugin_admin, 'alter_the_query' );
        $this->loader->add_filter(
            'wp_insert_post_data',
            $plugin_admin,
            'modify_post_title',
            '99',
            1
        );
        $this->loader->add_filter( 'manage_edit-contact_sortable_columns', $plugin_admin, 'set_custom_contact_list_sortable_columns' );
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Contact_List_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_ajax_nopriv_cl_send_mail_public', $plugin_public, 'cl_send_mail_public' );
        $this->loader->add_action( 'wp_ajax_cl_send_mail_public', $plugin_public, 'cl_send_mail_public' );
        $this->loader->add_action( 'wp_ajax_nopriv_cl_get_contacts', $plugin_public, 'cl_get_contacts' );
        $this->loader->add_action( 'wp_ajax_cl_get_contacts', $plugin_public, 'cl_get_contacts' );
        $this->loader->add_action( 'wp_footer', $plugin_public, 'my_ajax_without_file' );
        $this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Contact_List_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}