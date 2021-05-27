<?php

/**
 * Custom fields related to contact custom post type
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Contact_List
 * @subpackage Contact_List/includes
 */

class myCustomFields {

    public $prefix = '_cl_';
    public $postTypes = array( "contact" );

    public $customFields = array(
        array(
            "name"          => "first_name",
            "title"         => "First name",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "last_name",
            "title"         => "Last Name",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "job_title",
            "title"         => "Job title",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "phone",
            "title"         => "Phone 1",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "phone_2",
            "title"         => "Phone 2",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "phone_3",
            "title"         => "Phone 3",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "email",
            "title"         => "Email",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
          'name'          => 'notify_emails',
          'title'         => 'Notify emails',
          'description'   => '',
          'type'          => 'text',
          'scope'         => array(CONTACT_CPT),
          'capability'    => 'edit_posts',
          'descr'         => 'Email addresses defined here (comma separated) also receive the emails that are sent to the primary email address using the front-end form.'
        ),
        array(
            "name"          => "linkedin_url",
            "title"         => "LinkedIn URL",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "twitter_url",
            "title"         => "Twitter URL",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "facebook_url",
            "title"         => "Facebook URL",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "instagram_url",
            "title"         => "Instagram URL",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

        array(
            "name"          => "address",
            "title"         => "Address",
            "description"   => "",
            "type"          => "title",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

        array(
            "name"          => "country",
            "title"         => "Country",
            "description"   => "",
            "type"          => "country",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "state",
            "title"         => "State",
            "description"   => "",
            "type"          => "state",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "city",
            "title"         => "City",
            "description"   => "",
            "type"          => "city",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

        array(
            "name"          => "address_line_1",
            "title"         => "Address Line 1",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "address_line_2",
            "title"         => "Address Line 2",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "address_line_3",
            "title"         => "Address Line 3",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "address_line_4",
            "title"         => "Address Line 4",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

        array(
            "name"          => "custom_fields",
            "title"         => "Custom fields",
            "description"   => "",
            "type"          => "title",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

        array(
            "name"          => "custom_field_1",
            "title"         => "Custom field 1",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "custom_field_2",
            "title"         => "Custom field 2",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "custom_field_3",
            "title"         => "Custom field 3",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "custom_field_4",
            "title"         => "Custom field 4",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "custom_field_5",
            "title"         => "Custom field 5",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        array(
            "name"          => "custom_field_6",
            "title"         => "Custom field 6",
            "description"   => "",
            "type"          => "text",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        
        array(
            "name"          => "additional_info",
            "title"         => "Additional information",
            "description"   => "",
            "type"          => "title",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),
        
        array(
            "name"          => "description",
            "title"         => "Description",
            "description"   => "",
            "type"          => "wysiwyg_v2",
            "scope"         => array( "contact" ),
            "capability"    => "edit_posts"
        ),

    );

    function __construct() {
        add_action('admin_menu', array($this, 'createCustomFields'));
        add_action('save_post', array($this, 'saveCustomFields'), 1, 2);
        add_action('do_meta_boxes', array($this, 'removeDefaultCustomFields'), 10, 3);
    }

    /**
    * Remove the default Custom Fields meta box
    */
    function removeDefaultCustomFields($type, $context, $post) {
        foreach (array('normal', 'advanced', 'side') as $context) {
            foreach($this->postTypes as $postType) {
                remove_meta_box('postcustom', $postType, $context);
            }
        }
    }

    /**
    * Create the new Custom Fields meta box
    */
    function createCustomFields() {

        if (function_exists('add_meta_box')) {
            foreach ($this->postTypes as $postType) {
                add_meta_box('my-custom-fields', __('Contact Details', 'contact-list'), array($this, 'displayCustomFields'), $postType, 'normal', 'high');
            }
        }
    }

    /**
    * Display the new Custom Fields meta box
    */
    function displayCustomFields() {
        global $post;

        $options = get_option('contact_list_settings');

        ?>

        <?php
  			$html = "
  			<script>
  			    jQuery( document ).ready( function($) {
                $('#post').submit(function() {
                    if ($('#_cl_last_name').val().length == 0) {
                        alert('Please insert at least last name first.');
                        return false;
                    }
                });
            });
        </script>
  			";
        echo $html;
        ?>

        <style>
          .form-wrap .form-field-type-text {
            width: 50%;
            float: left;
          }
          .form-wrap .form-field-type-country {
            width: 33%;
            float: left;
          }
          .form-wrap .form-field-type-state {
            width: 33%;
            float: left;
          }
          .form-wrap .form-field-type-city {
            width: 33%;
            float: left;
          }
          .form-wrap .form-field-type-title {
            clear: both;
            margin-bottom: 0;
          }
          .form-wrap .form-field-type-title h3 {
            border-bottom: 1px solid #eee;
            padding-top: 16px;
            padding-bottom: 10px;
            margin-right: 10px;
            margin-bottom: 0;
          }
          hr.clear {
            	background: none;
            	border: 0;
            	clear: both;
            	display: block;
            	float: none;
            	font-size: 0;
            	margin: 0;
            	padding: 0;
            	overflow: hidden;
            	visibility: hidden;
            	width: 0;
            	height: 0;
          }

          <?php if (isset($options['af_hide_groups'])): ?>
              #contact-groupdiv {
                display: none;
              }
          <?php endif; ?>

        </style>

        <div class="form-wrap">

            <?php
            wp_nonce_field('my-custom-fields', 'my-custom-fields_wpnonce', false, true);

            foreach ($this->customFields as $customField) {

                if ($customField['name'] == 'first_name' && isset($options['af_hide_first_name'])) {
                  continue;
                } elseif ($customField['name'] == 'job_title' && isset($options['af_hide_job_title'])) {
                  continue;
                } elseif ($customField['name'] == 'email' && isset($options['af_hide_email'])) {
                  continue;
                } elseif (($customField['name'] == 'phone' || $customField['name'] == 'phone_2' || $customField['name'] == 'phone_3') && isset($options['af_hide_phone'])) {
                  continue;
                } elseif ($customField['name'] == 'linkedin_url' && isset($options['af_hide_linkedin_url'])) {
                  continue;
                } elseif ($customField['name'] == 'twitter_url' && isset($options['af_hide_twitter_url'])) {
                  continue;
                } elseif ($customField['name'] == 'facebook_url' && isset($options['af_hide_facebook_url'])) {
                  continue;
                } elseif ($customField['name'] == 'instagram_url' && isset($options['af_hide_instagram_url'])) {
                  continue;
                } elseif (($customField['name'] == 'address' || $customField['name'] == 'address_line_1' || $customField['name'] == 'address_line_2' || $customField['name'] == 'address_line_3' || $customField['name'] == 'address_line_4') && isset($options['af_hide_address'])) {
                  continue;
                } elseif (($customField['name'] == 'custom_fields' || $customField['name'] == 'custom_field_1' || $customField['name'] == 'custom_field_2' || $customField['name'] == 'custom_field_3' || $customField['name'] == 'custom_field_4' || $customField['name'] == 'custom_field_5' || $customField['name'] == 'custom_field_6') && isset($options['af_hide_custom_fields'])) {
                  continue;
                } elseif (($customField['name'] == 'additional_info' || $customField['name'] == 'description') && isset($options['af_hide_additional_info'])) {
                  continue;
                }

                // Check scope
                $scope = $customField['scope'];
                $output = false;
                $custom_fields_notify = 0;
                $additional_info_notify = 0;
                
                foreach ($scope as $scopeItem) {

                  switch ($scopeItem) {
                    default: {
                      if ($post->post_type == $scopeItem)
                        $output = true;
                      break;
                    }
                  }

                  if ($output) {
                    break;
                  }
                  
                }
                
                // Check capability
                if (!current_user_can($customField['capability'], $post->ID)) {
                  $output = false;
                }

                if (ContactListHelpers::isPremium() == 1) {
                  $output = true;
                } elseif ($customField['name'] == 'phone_2' || $customField['name'] == 'phone_3' || $customField['name'] == 'custom_field_2' || $customField['name'] == 'custom_field_3' || $customField['name'] == 'custom_field_4' || $customField['name'] == 'custom_field_5' || $customField['name'] == 'custom_field_6' || $customField['name'] == 'description' || $customField['name'] == 'website_url') {
                  $output = true;
                  $customField['name'] = '_FREE_' . $customField['name'];
                } elseif ($customField['name'] == 'description') {
                  $customField['name'] = '_FREE_' . $customField['name'];
                  $additional_info_notify = 1;
                }  

                // Output if allowed
                if ($output) { ?>

                    <div class="form-field form-required form-field-type-<?= $customField['type'] ?>">

                      <?php if (substr($customField['name'], 0, strlen('_FREE_')) === '_FREE_'): ?>
                      
                        <div class="contact-list-field-in-pro-container">

                          <?php if ($customField['name'] != '_FREE_description'): ?>
                            <label><b><?= __($customField['title'], 'contact-list') ?></b></label>
                          <?php endif; ?>
                      
                          <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing">
                            <div class="contact-list-settings-pro-feature-overlay"><span>Pro</span></div>
                          </a>
                      
                        </div>
                          
                      <?php else: ?>

                        <?php
                        switch ( $customField[ 'type' ] ) {
                            case "checkbox": {
                                // Checkbox
                                echo '<label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . __($customField['title'], 'contact-list') . '</b></label>';
                                echo '<input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
                                if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
                                    echo ' checked="checked"';
                                echo '" style="width: auto;" />';
                                break;
                            }

                            case "textarea":

                            case "wysiwyg": {
                                // Text area
                                echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . __($customField['title'], 'contact-list') . '</b></label>';
                                echo '<textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
                                // WYSIWYG
                                if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
                                    <script type="text/javascript">
                                        jQuery( document ).ready( function() {
                                            jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
                                            if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
                                                tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
                                            }
                                        });
                                    </script>
                                <?php }
                                break;
                            }

                            case "wysiwyg_v2":
                                $options_field = $customField['name'] . '_title';
                                $description = get_post_meta(get_the_ID(), $this->prefix . $customField['name'], true);
                                $settings = array('media_buttons' => false, 'teeny' => true, 'wpautop' => false,  'textarea_rows' => 16);
                                wp_editor($description, $this->prefix . $customField['name'], $settings);
                                break;

                            case "title":

                                $options_field = $customField['name'] . '_title';
                                echo '<h3>' . (isset($options[$options_field]) && $options[$options_field] ? $options[$options_field] : __($customField['title'], 'contact-list')) . '</h3>';
                                break;

                            case "country":
                                $options_field = $customField['name'] . '_title';
                                echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . (isset($options[$options_field]) && $options[$options_field] ? $options[$options_field] : __($customField['title'], 'contact-list')) . '</b></label>';
                                echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                break;

                            case "state":
                                $options_field = $customField['name'] . '_title';
                                echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . (isset($options[$options_field]) && $options[$options_field] ? $options[$options_field] : __($customField['title'], 'contact-list')) . '</b></label>';
                                echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                break;

                            default: {
                                // Plain text field
                                $options_field = $customField['name'] . '_title';
                                echo '<label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . (isset($options[$options_field]) && $options[$options_field] ? $options[$options_field] : __($customField['title'], 'contact-list')) . '</b></label>';
                                echo '<input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
                                if (isset($customField['descr'])) {
                                  echo '<div style="background: rgb(251, 251, 251); border: 1px solid #eee; padding: 5px 7px; margin-top: 8px; width: 90%; font-size: 11px;">' . $customField['descr'] . '</div>';
                                }
                                break;

                            }
                        }
                        ?>

                        <?php endif; ?>

                        <?php if ($customField['description']) echo '<p>' . $customField['description'] . '</p>'; ?>

                    </div>
                <?php
                }
            } ?>
            <hr class="clear" />
        </div>
        <?php
    }

  /**
  * Save the new Custom Fields values
  */
  function saveCustomFields($post_id, $post) {

    if (!isset($_POST['my-custom-fields_wpnonce']) || !wp_verify_nonce($_POST['my-custom-fields_wpnonce'], 'my-custom-fields')) {
      return;
    }

    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    if (!in_array($post->post_type, $this->postTypes)) {
      return;
    }

    foreach ($this->customFields as $customField) {

      if (current_user_can($customField['capability'], $post_id)) {

        if (isset($_POST[$this->prefix . $customField['name']]) && trim($_POST[$this->prefix . $customField['name']])) {

          $value = $_POST[$this->prefix . $customField['name']];

          if ($customField['type'] == 'wysiwyg') {
            sanitize_text_field(  );
          }

          // Auto-paragraphs for any WYSIWYG
          if ($customField['type'] == 'wysiwyg' || $customField['type'] == 'wysiwyg_v2') {
            $value = wpautop($value);
          } else {
            $value = sanitize_text_field( $value );
          }

          if ($customField['type'] == 'wysiwyg_v2') {
            $value = balanceTags(wp_kses_post($value), 1);
          }

          update_post_meta($post_id, $this->prefix . $customField['name'], $value);

        } else {

          delete_post_meta($post_id, $this->prefix . $customField['name']);

        }
      }
    }
  }

}
