<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.contactlistpro.com
 * @since             1.0.0
 * @package           Contact_List
 *
 * @wordpress-plugin
 * Plugin Name:       Contact List
 * Description:       Easily display contact information on your site with this simple plugin.
 * Version:           2.9.23
 * Author:            Tammersoft
 * Author URI:        https://www.tammersoft.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       contact-list
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

if ( function_exists( 'cl_fs' ) ) {
    cl_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'cl_fs' ) ) {
        // Create a helper function for easy SDK access.
        function cl_fs()
        {
            global  $cl_fs ;
            
            if ( !isset( $cl_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $cl_fs = fs_dynamic_init( array(
                    'id'             => '5106',
                    'slug'           => 'contact-list',
                    'premium_slug'   => 'contact-list-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_9808753bcf234f1feef91bd833ab6',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 14,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'    => 'contact-list',
                    'contact' => false,
                    'parent'  => array(
                    'slug' => 'options-general.php',
                ),
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $cl_fs;
        }
        
        // Init Freemius.
        cl_fs();
        // Signal that SDK was initiated.
        do_action( 'cl_fs_loaded' );
    }
    
    function cl_fs_custom_connect_message( $message, $user_first_name )
    {
        return sprintf( __( 'Hey %1$s' ) . ',<br>' . __( 'never miss an important update -- opt-in to our security and feature updates notifications, and non-sensitive diagnostic tracking with freemius.com.' ), $user_first_name );
    }
    
    cl_fs()->add_filter(
        'connect_message',
        'cl_fs_custom_connect_message',
        10,
        6
    );
    function cl_fs_custom_connect_message_on_update(
        $message,
        $user_first_name,
        $plugin_title,
        $user_login,
        $site_link,
        $freemius_link
    )
    {
        return sprintf(
            __( 'Hey %1$s' ) . ',<br>' . __( 'Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.' ),
            $user_first_name,
            '<b>' . $plugin_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }
    
    cl_fs()->add_filter(
        'connect_message_on_update',
        'cl_fs_custom_connect_message_on_update',
        10,
        6
    );
    $s = get_option( 'contact_list_settings' );
    $order_by = '_cl_last_name';
    if ( isset( $s['order_by'] ) && $s['order_by'] ) {
        $order_by = $s['order_by'];
    }
    define( 'ORDER_BY', $order_by );
    define( 'CONTACT_LIST_VERSION', '2.9.23' );
    define( 'CONTACT_LIST_URI', plugin_dir_url( __FILE__ ) );
    define( 'CONTACT_LIST_PATH', plugin_dir_path( __FILE__ ) );
    define( 'CONTACT_CPT', 'contact' );
    define( 'CONTACT_LIST_CAT1', 'cl_1' );
    define( 'CONTACT_LIST_CAT2', 'cl_2' );
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-contact-list-activator.php
     */
    function activate_contact_list()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-list-activator.php';
        Contact_List_Activator::activate();
    }
    
    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-contact-list-deactivator.php
     */
    function deactivate_contact_list()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-contact-list-deactivator.php';
        Contact_List_Deactivator::deactivate();
    }
    
    register_activation_hook( __FILE__, 'activate_contact_list' );
    register_deactivation_hook( __FILE__, 'deactivate_contact_list' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-contact-list.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_contact_list()
    {
        $plugin = new Contact_List();
        $plugin->run();
    }
    
    run_contact_list();
}
