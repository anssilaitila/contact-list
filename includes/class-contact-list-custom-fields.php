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
class ContactListCustomFields
{
    public  $prefix = '' ;
    public  $postTypes = array() ;
    public  $customFields = array() ;
    function __construct()
    {
        $this->prefix = '_cl_';
        $this->postTypes = array( 'contact' );
        $this->customFields = array(
            array(
            'name'        => 'first_name',
            'title'       => sanitize_text_field( __( 'First name', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'last_name',
            'title'       => sanitize_text_field( __( 'Last Name', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'job_title',
            'title'       => sanitize_text_field( __( 'Job title', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'phone',
            'title'       => sanitize_text_field( __( 'Phone 1', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'phone_2',
            'title'       => sanitize_text_field( __( 'Phone 2', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'phone_3',
            'title'       => sanitize_text_field( __( 'Phone 3', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'email',
            'title'       => sanitize_text_field( __( 'Email', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'notify_emails',
            'title'       => sanitize_text_field( __( 'Notify emails', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( CONTACT_LIST_CPT ),
            'capability'  => 'edit_posts',
            'descr'       => sanitize_text_field( __( 'Email addresses defined here (comma separated) also receive the emails that are sent to the primary email address using the front-end form.', 'contact-list' ) ),
        ),
            array(
            'name'        => 'linkedin_url',
            'title'       => sanitize_text_field( __( 'LinkedIn URL', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'twitter_url',
            'title'       => sanitize_text_field( __( 'Twitter URL', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'facebook_url',
            'title'       => sanitize_text_field( __( 'Facebook URL', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'instagram_url',
            'title'       => sanitize_text_field( __( 'Instagram URL', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'address',
            'title'       => sanitize_text_field( __( 'Address', 'contact-list' ) ),
            'description' => '',
            'type'        => 'title',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'country',
            'title'       => sanitize_text_field( __( 'Country', 'contact-list' ) ),
            'description' => '',
            'type'        => 'country',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'state',
            'title'       => sanitize_text_field( __( 'State', 'contact-list' ) ),
            'description' => '',
            'type'        => 'state',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'city',
            'title'       => sanitize_text_field( __( 'City', 'contact-list' ) ),
            'description' => '',
            'type'        => 'city',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'zip_code',
            'title'       => sanitize_text_field( __( 'ZIP Code', 'contact-list' ) ),
            'description' => '',
            'type'        => 'city',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'address_line_1',
            'title'       => sanitize_text_field( __( 'Address Line 1', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'address_line_2',
            'title'       => sanitize_text_field( __( 'Address Line 2', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'address_line_3',
            'title'       => sanitize_text_field( __( 'Address Line 3', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'address_line_4',
            'title'       => sanitize_text_field( __( 'Address Line 4', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_fields',
            'title'       => sanitize_text_field( __( 'Custom fields', 'contact-list' ) ),
            'description' => '',
            'type'        => 'title',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_1',
            'title'       => sanitize_text_field( __( 'Custom field 1', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_2',
            'title'       => sanitize_text_field( __( 'Custom field 2', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_3',
            'title'       => sanitize_text_field( __( 'Custom field 3', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_4',
            'title'       => sanitize_text_field( __( 'Custom field 4', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_5',
            'title'       => sanitize_text_field( __( 'Custom field 5', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'custom_field_6',
            'title'       => sanitize_text_field( __( 'Custom field 6', 'contact-list' ) ),
            'description' => '',
            'type'        => 'text',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'additional_info',
            'title'       => sanitize_text_field( __( 'Additional information', 'contact-list' ) ),
            'description' => '',
            'type'        => 'title',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        ),
            array(
            'name'        => 'description',
            'title'       => sanitize_text_field( __( 'Description', 'contact-list' ) ),
            'description' => '',
            'type'        => 'wysiwyg_v2',
            'scope'       => array( 'contact' ),
            'capability'  => 'edit_posts',
        )
        );
        add_action( 'admin_menu', array( $this, 'createCustomFields' ) );
        add_action(
            'save_post',
            array( $this, 'saveCustomFields' ),
            1,
            2
        );
        add_action(
            'do_meta_boxes',
            array( $this, 'removeDefaultCustomFields' ),
            10,
            3
        );
    }
    
    /**
     * Remove the default Custom Fields meta box
     */
    function removeDefaultCustomFields( $type, $context, $post )
    {
        foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
            foreach ( $this->postTypes as $postType ) {
                remove_meta_box( 'postcustom', $postType, $context );
            }
        }
    }
    
    /**
     * Create the new Custom Fields meta box
     */
    function createCustomFields()
    {
        if ( function_exists( 'add_meta_box' ) ) {
            foreach ( $this->postTypes as $postType ) {
                add_meta_box(
                    'contact-list-custom-fields',
                    sanitize_text_field( __( 'Contact Details', 'contact-list' ) ),
                    array( $this, 'displayCustomFields' ),
                    $postType,
                    'normal',
                    'high'
                );
            }
        }
    }
    
    /**
     * Display the new Custom Fields meta box
     */
    function displayCustomFields()
    {
        global  $post ;
        $options = get_option( 'contact_list_settings' );
        ?>

        <div class="form-wrap">

            <?php 
        wp_nonce_field(
            'contact-list-custom-fields',
            'contact-list-custom-fields_wpnonce',
            false,
            true
        );
        foreach ( $this->customFields as $customField ) {
            
            if ( $customField['name'] == 'first_name' && isset( $options['af_hide_first_name'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'job_title' && isset( $options['af_hide_job_title'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'email' && isset( $options['af_hide_email'] ) ) {
                continue;
            } elseif ( ($customField['name'] == 'phone' || $customField['name'] == 'phone_2' || $customField['name'] == 'phone_3') && isset( $options['af_hide_phone'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'linkedin_url' && isset( $options['af_hide_linkedin_url'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'twitter_url' && isset( $options['af_hide_twitter_url'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'facebook_url' && isset( $options['af_hide_facebook_url'] ) ) {
                continue;
            } elseif ( $customField['name'] == 'instagram_url' && isset( $options['af_hide_instagram_url'] ) ) {
                continue;
            } elseif ( ($customField['name'] == 'address' || $customField['name'] == 'address_line_1' || $customField['name'] == 'address_line_2' || $customField['name'] == 'address_line_3' || $customField['name'] == 'address_line_4') && isset( $options['af_hide_address'] ) ) {
                continue;
            } elseif ( ($customField['name'] == 'custom_fields' || $customField['name'] == 'custom_field_1' || $customField['name'] == 'custom_field_2' || $customField['name'] == 'custom_field_3' || $customField['name'] == 'custom_field_4' || $customField['name'] == 'custom_field_5' || $customField['name'] == 'custom_field_6') && isset( $options['af_hide_custom_fields'] ) ) {
                continue;
            } elseif ( ($customField['name'] == 'additional_info' || $customField['name'] == 'description') && isset( $options['af_hide_additional_info'] ) ) {
                continue;
            }
            
            // Check scope
            $scope = $customField['scope'];
            $output = false;
            $custom_fields_notify = 0;
            $additional_info_notify = 0;
            foreach ( $scope as $scopeItem ) {
                switch ( $scopeItem ) {
                    default:
                        if ( $post->post_type == $scopeItem ) {
                            $output = true;
                        }
                        break;
                }
                if ( $output ) {
                    break;
                }
            }
            // Check capability
            if ( !current_user_can( $customField['capability'], intval( $post->ID ) ) ) {
                $output = false;
            }
            $is_premium = 0;
            // Premium-only fields are just ads for upgrading, not containing any real functionality
            if ( !$is_premium ) {
                
                if ( $customField['name'] == 'phone_2' || $customField['name'] == 'phone_3' || $customField['name'] == 'custom_field_2' || $customField['name'] == 'custom_field_3' || $customField['name'] == 'custom_field_4' || $customField['name'] == 'custom_field_5' || $customField['name'] == 'custom_field_6' || $customField['name'] == 'description' || $customField['name'] == 'zip_code' ) {
                    $output = true;
                    $customField['name'] = '_FREE_' . $customField['name'];
                } elseif ( $customField['name'] == 'description' ) {
                    $customField['name'] = '_FREE_' . $customField['name'];
                    $additional_info_notify = 1;
                }
            
            }
            // Output if allowed
            
            if ( $output ) {
                ?>

                    <div class="form-field form-required form-field-type-<?php 
                echo  sanitize_html_class( $customField['type'] ) ;
                ?>">

                      <?php 
                
                if ( substr( $customField['name'], 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                    ?>
                      
                        <div class="contact-list-field-in-pro-container">

                          <?php 
                    
                    if ( $customField['name'] != '_FREE_description' ) {
                        ?>
                            <label><b><?php 
                        echo  esc_html( $customField['title'] ) ;
                        ?></b></label>
                          <?php 
                    }
                    
                    ?>
                      
                          <a href="<?php 
                    echo  esc_url( get_admin_url() ) ;
                    ?>options-general.php?page=contact-list-pricing">
                            <div class="contact-list-settings-pro-feature-overlay"><span>Pro</span></div>
                          </a>
                      
                        </div>
                          
                      <?php 
                } else {
                    ?>

                        <?php 
                    switch ( $customField['type'] ) {
                        case "checkbox":
                            // Checkbox
                            echo  '<label for="' . esc_attr( $this->prefix . $customField['name'] ) . '" style="display:inline;"><b>' . esc_html( $customField['title'] ) . '</b></label>' ;
                            echo  '<input type="checkbox" name="' . esc_attr( $this->prefix . $customField['name'] ) . '" id="' . esc_attr( $this->prefix . $customField['name'] ) . '" value="yes"' ;
                            if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" ) {
                                echo  ' checked="checked"' ;
                            }
                            echo  '" style="width: auto;" />' ;
                            break;
                        case "textarea":
                        case "wysiwyg_v2":
                            $options_field = $customField['name'] . '_title';
                            $description = wp_kses_post( get_post_meta( intval( get_the_ID() ), $this->prefix . $customField['name'], true ) );
                            $settings = array(
                                'media_buttons' => false,
                                'teeny'         => true,
                                'wpautop'       => false,
                                'textarea_rows' => 16,
                            );
                            wp_editor( $description, $this->prefix . $customField['name'], $settings );
                            break;
                        case "title":
                            $options_field = $customField['name'] . '_title';
                            echo  '<h3>' . (( isset( $options[$options_field] ) && $options[$options_field] ? esc_html( $options[$options_field] ) : esc_html( $customField['title'] ) )) . '</h3>' ;
                            break;
                        case "country":
                            $options_field = $customField['name'] . '_title';
                            echo  '<label for="' . esc_attr( $this->prefix . $customField['name'] ) . '"><b>' . (( isset( $options[$options_field] ) && $options[$options_field] ? esc_html( $options[$options_field] ) : esc_html( $customField['title'] ) )) . '</b></label>' ;
                            echo  '<input type="text" name="' . esc_attr( $this->prefix . $customField['name'] ) . '" id="' . esc_attr( $this->prefix . $customField['name'] ) . '" value="' . esc_attr( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) ) . '" />' ;
                            break;
                        case "state":
                            $options_field = $customField['name'] . '_title';
                            echo  '<label for="' . esc_attr( $this->prefix . $customField['name'] ) . '"><b>' . (( isset( $options[$options_field] ) && $options[$options_field] ? esc_html( $options[$options_field] ) : esc_html( $customField['title'] ) )) . '</b></label>' ;
                            echo  '<input type="text" name="' . esc_attr( $this->prefix . $customField['name'] ) . '" id="' . esc_attr( $this->prefix . $customField['name'] ) . '" value="' . esc_attr( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) ) . '" />' ;
                            break;
                        default:
                            // Plain text field
                            $options_field = $customField['name'] . '_title';
                            echo  '<label for="' . esc_attr( $this->prefix . $customField['name'] ) . '"><b>' . (( isset( $options[$options_field] ) && $options[$options_field] ? esc_html( $options[$options_field] ) : esc_html( $customField['title'] ) )) . '</b></label>' ;
                            echo  '<input type="text" name="' . esc_attr( $this->prefix . $customField['name'] ) . '" id="' . esc_attr( $this->prefix . $customField['name'] ) . '" value="' . esc_attr( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) ) . '" />' ;
                            if ( isset( $customField['descr'] ) ) {
                                echo  '<div style="background: rgb(251, 251, 251); border: 1px solid #eee; padding: 5px 7px; margin-top: 8px; width: 90%; font-size: 11px;">' . esc_html( $customField['descr'] ) . '</div>' ;
                            }
                            break;
                    }
                    ?>

                        <?php 
                }
                
                ?>

                        <?php 
                
                if ( $customField['description'] ) {
                    ?>
                          <?php 
                    echo  '<p>' . esc_html( $customField['description'] ) . '</p>' ;
                    ?>
                        <?php 
                }
                
                ?>

                    </div>
                <?php 
            }
        
        }
        ?>
            <hr class="clear" />
        </div>
        <?php 
    }
    
    /**
     * Save the new Custom Fields values
     */
    function saveCustomFields( $post_id, $post )
    {
        $post_id = intval( $post_id );
        $wpnonce = '';
        if ( isset( $_POST['contact-list-custom-fields_wpnonce'] ) ) {
            $wpnonce = sanitize_text_field( $_POST['contact-list-custom-fields_wpnonce'] );
        }
        if ( !$wpnonce ) {
            return;
        }
        if ( !wp_verify_nonce( $wpnonce, 'contact-list-custom-fields' ) ) {
            return;
        }
        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        if ( !in_array( $post->post_type, $this->postTypes ) ) {
            return;
        }
        foreach ( $this->customFields as $customField ) {
            
            if ( current_user_can( $customField['capability'], $post_id ) ) {
                $custom_field_name = sanitize_title( $this->prefix . $customField['name'] );
                
                if ( isset( $_POST[$custom_field_name] ) && trim( $_POST[$custom_field_name] ) ) {
                    $value = $_POST[$custom_field_name];
                    // Auto-paragraphs for any wysiwyg field
                    
                    if ( $customField['type'] == 'wysiwyg_v2' ) {
                        $value = balanceTags( wp_kses_post( $value ), 1 );
                    } else {
                        $value = sanitize_text_field( $value );
                    }
                    
                    update_post_meta( $post_id, $custom_field_name, $value );
                } else {
                    delete_post_meta( $post_id, $custom_field_name );
                }
            
            }
        
        }
    }

}