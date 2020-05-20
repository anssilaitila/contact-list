<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Contact_List
 * @subpackage Contact_List/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Contact_List
 * @subpackage Contact_List/public
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Contact_List_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            CONTACT_LIST_URI . 'dist/css/main.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            CONTACT_LIST_URI . 'dist/js/main.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    /**
     * Register the shortcodes.
     *
     * @since    1.0.0
     */
    public function register_shortcodes()
    {
        add_shortcode( 'contact_list', array( 'Contact_List_Public', 'contact_list' ) );
        add_shortcode( 'contact_list_groups', array( 'Contact_List_Public', 'contact_list_groups' ) );
        add_shortcode( 'contact_list_form', array( 'Contact_List_Public', 'contact_list_form' ) );
        add_shortcode( 'contact_list_search', array( 'Contact_List_Public', 'contact_list_search' ) );
    }
    
    /**
     * Public contact list view.
     *
     * @since    1.0.0
     */
    public static function contact_list( $atts = array(), $content = null, $tag = '' )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $html = '';
        $html .= ShortcodeContactList::shortcodeContactListMarkup( $atts );
        return $html;
    }
    
    /**
     * Public groups list view.
     *
     * @since    2.0.0
     */
    public static function contact_list_groups( $atts = array(), $content = null, $tag = '' )
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $html = '';
        $html .= '<div class="pro-feature">' . __( 'This feature is available in the Pro version.' ) . '</div>';
        return $html;
    }
    
    /**
     * Public form
     *
     * @since    2.0.0
     */
    public static function contact_list_form()
    {
        $html = '';
        $html .= '<div class="pro-feature">' . __( 'This feature is available in the Pro version.' ) . '</div>';
        return $html;
    }
    
    public static function contact_list_search( $atts = array(), $content = null, $tag = '' )
    {
        $html = '';
        $html .= '<div class="pro-feature">' . __( 'This feature is available in the Pro version.' ) . '</div>';
        return $html;
    }
    
    public function cl_get_contacts()
    {
        $meta_query = array(
            'relation' => 'AND',
        );
        $meta_query[] = array(
            'last_name_clause' => array(
            'key'     => '_cl_last_name',
            'compare' => 'EXISTS',
        ),
        );
        $order_by = array(
            'menu_order'       => 'ASC',
            'last_name_clause' => 'ASC',
            'title'            => 'ASC',
        );
        
        if ( ORDER_BY == '_cl_first_name' ) {
            $meta_query[] = array(
                'first_name_clause' => array(
                'key'     => '_cl_first_name',
                'compare' => 'EXISTS',
            ),
            );
            $order_by = array(
                'menu_order'        => 'ASC',
                'first_name_clause' => 'ASC',
                'title'             => 'ASC',
            );
        }
        
        if ( isset( $_POST['cl_country'] ) && $_POST['cl_country'] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => $_POST['cl_country'],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST['cl_state'] ) && $_POST['cl_state'] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => $_POST['cl_state'],
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => $_POST['cl_cat'],
            ),
            );
        }
        $posts_per_page = -1;
        if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
            $posts_per_page = $s['contacts_per_page'];
        }
        $wp_query = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'paged'          => $paged,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListHelpers::contactListMarkup( $wp_query );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . __( 'No contacts found.' ) . '</p>';
        }
        echo  $html ;
    }
    
    public function cl_send_mail_public()
    {
        $s = get_option( 'contact_list_settings' );
        
        if ( isset( $s['activate_recaptcha'] ) && isset( $s['recaptcha_secret_key'] ) ) {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_response = ( isset( $_POST['recaptcha_response'] ) ? $_POST['recaptcha_response'] : '' );
            $data = array(
                'secret'   => $s['recaptcha_secret_key'],
                'response' => $recaptcha_response,
            );
            $options = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query( $data ),
            ),
            );
            $context = stream_context_create( $options );
            $result = file_get_contents( $url, false, $context );
            
            if ( $result ) {
                $recaptcha_validation = json_decode( $result );
                if ( !$recaptcha_validation->{'success'} ) {
                    // Invalid reCAPTCHA challenge
                    //          $t = wp_mail('anssi.laitila@gmail.com', 'INVALID RECAPTCHA 1', 'INVALID RECAPTCHA 1');
                    wp_die();
                }
            } else {
                // Invalid reCAPTCHA challenge
                //        $t = wp_mail('anssi.laitila@gmail.com', 'INVALID RECAPTCHA 2', 'INVALID RECAPTCHA 2');
                wp_die();
            }
        
        }
        
        $subject = ( isset( $_POST['subject'] ) ? $_POST['subject'] : '' );
        $sender_name = ( isset( $_POST['sender_name'] ) ? $_POST['sender_name'] : '' );
        $sender_email = ( isset( $_POST['sender_email'] ) ? $_POST['sender_email'] : '' );
        $mail_cnt = ( isset( $_POST['mail_cnt'] ) ? $_POST['mail_cnt'] : '' );
        $body = '';
        if ( $sender_name ) {
            $body .= __( 'Sent by:', 'contact-list' ) . ' ' . $sender_name;
        }
        if ( $sender_email ) {
            $body .= " <" . $sender_email . ">";
        }
        if ( $sender_name || $sender_email ) {
            $body .= "<br /><br />";
        }
        $body .= ( isset( $_POST['body'] ) ? $_POST['body'] : '' );
        $body .= "<br /><br />-- <br />" . __( 'This mail was sent using Contact List Pro', 'contact-list' );
        $recipient_emails = ( isset( $_POST['recipient_emails'] ) ? $_POST['recipient_emails'] : '' );
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $reply_to = '';
        
        if ( $sender_name && is_email( $sender_email ) ) {
            $reply_to = $sender_name . ' <' . $sender_email . '>';
        } elseif ( is_email( $sender_email ) ) {
            $reply_to = '<' . $sender_email . '>';
        }
        
        if ( $reply_to ) {
            $headers[] = 'Reply-To: ' . $reply_to;
        }
        $from = '';
        if ( isset( $s['email_sender_contact_card'] ) && is_email( $s['email_sender_contact_card'] ) ) {
            
            if ( isset( $s['email_sender_name_contact_card'] ) ) {
                $from = $s['email_sender_name_contact_card'] . ' <' . $s['email_sender_contact_card'] . '>';
            } else {
                $from = $s['email_sender_contact_card'];
            }
        
        }
        if ( $from ) {
            $headers[] = 'From: ' . $from;
        }
        $resp = wp_mail(
            $recipient_emails,
            $subject,
            $body,
            $headers
        );
        global  $wpdb ;
        $all_emails = explode( ',', $recipient_emails );
        $mail_cnt = sizeof( $all_emails );
        
        if ( $resp ) {
            $report = 'Mail successfully processed using <strong>wp_mail</strong>.<br /><br /><strong>Mail sent to:</strong><br />' . str_replace( ',', ', ', $recipient_emails );
            $wpdb->insert( 'wp_cl_sent_mail_log', array(
                'subject'      => $subject,
                'sender_name'  => $sender_name,
                'reply_to'     => $reply_to,
                'report'       => $report,
                'sender_email' => $from,
                'mail_cnt'     => $mail_cnt,
            ) );
        } else {
            $report = '<span style="color: crimson;">ERROR processing mail using <strong>wp_mail</strong>.<br /><br /><strong>Mail WAS NOT sent to:</strong><br />' . str_replace( ',', ', ', $recipient_emails ) . '</span>';
            $wpdb->insert( 'wp_cl_sent_mail_log', array(
                'subject'      => $subject,
                'sender_name'  => $sender_name,
                'reply_to'     => $reply_to,
                'report'       => $report,
                'sender_email' => $from,
                'mail_cnt'     => 0,
            ) );
        }
        
        wp_die();
    }
    
    public function my_ajax_without_file()
    {
        ?>
  
      <script type="text/javascript" >
      jQuery(document).ready(function($) {
        ajaxurl = "<?php 
        echo  admin_url( 'admin-ajax.php' ) ;
        ?>"; // get ajaxurl
      });
      </script> 
      <?php 
    }

}