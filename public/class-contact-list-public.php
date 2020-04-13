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
class Contact_List_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct( $plugin_name, $version ) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {
    wp_enqueue_style($this->plugin_name, CONTACT_LIST_URI . 'dist/css/main.css', array(), $this->version, 'all');
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_enqueue_script($this->plugin_name, CONTACT_LIST_URI . 'dist/js/main.js', array('jquery'), $this->version, false);
  }

  /**
   * Register the shortcodes.
   *
   * @since    1.0.0
   */
  public function register_shortcodes() {
    add_shortcode('contact_list', array('Contact_List_Public', 'contact_list'));
    add_shortcode('contact_list_groups', array('Contact_List_Public', 'contact_list_groups'));
    add_shortcode('contact_list_form', array('Contact_List_Public', 'contact_list_form'));
    add_shortcode('contact_list_search', array('Contact_List_Public', 'contact_list_search'));
  }

  /**
   * Public contact list view.
   *
   * @since    1.0.0
   */
  public static function contact_list($atts = [], $content = null, $tag = '') {

    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER);

    $html = '';
    $html .= ShortcodeContactList::shortcodeContactListMarkup($atts);

    return $html;
  }

  /**
   * Public groups list view.
   *
   * @since    2.0.0
   */
  public static function contact_list_groups($atts = [], $content = null, $tag = '') {

    // normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER);

    $html = '';
    $html .= ContactListGroups::shortcodeContactListGroupsMarkup($atts);

    return $html;
  }

  /**
   * Public form
   *
   * @since    2.0.0
   */
  public static function contact_list_form() {

    $html = '';
    $html .= ContactListForm::shortcodeContactListFormMarkup();

    return $html;
  }

  public static function contact_list_search($atts = [], $content = null, $tag = '') {

    $html = '';
    $html .= ShortcodeContactListSearch::view($atts);

    return $html;
  }

  public function cl_send_mail_public() {

    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $sender_name = isset($_POST['sender_name']) ? $_POST['sender_name'] : '';
    $sender_email = isset($_POST['sender_email']) ? $_POST['sender_email'] : '';
    $mail_cnt = isset($_POST['mail_cnt']) ? $_POST['mail_cnt'] : '';

    $reply_to = isset($_POST['reply_to']) ? $_POST['reply_to'] : '';

    $body = '';

    if ($sender_name) {
      $body .= __('Sent by:', 'contact-list') . $sender_name;
    }
    
    if ($sender_email) {
      $body .= " <" . $sender_email . ">";
    }

    if ($sender_name || $sender_email) {
      $body .= "\n\n";
    }

    $body .= isset($_POST['body']) ? $_POST['body'] : '';
    $body .= "\n\n-- \n" . __('This mail was sent using Contact List Pro', 'contact-list');
    
    $recipient_emails = isset($_POST['recipient_emails']) ? $_POST['recipient_emails'] : '';

    $resp = wp_mail($recipient_emails, $subject, $body);
    
    wp_die();
  }

  public function my_ajax_without_file() { ?>
  
      <script type="text/javascript" >
      jQuery(document).ready(function($) {
        ajaxurl = "<?= admin_url('admin-ajax.php') ?>"; // get ajaxurl
      });
      </script> 
      <?php
  }

}

