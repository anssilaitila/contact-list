<?php

class ContactListHelpers
{
    public static function sanitize_attr_value( $str )
    {
        $str = sanitize_text_field( $str );
        $str = htmlspecialchars( $str );
        return $str;
    }
    
    public static function getSearchDropdownClass( $title = '', $message = '' )
    {
        $s = get_option( 'contact_list_settings' );
        $dd_class = 'cl_select_v2';
        return $dd_class;
    }
    
    public static function writeLog( $title = '', $message = '' )
    {
        global  $wpdb ;
        $wpdb->insert( $wpdb->prefix . 'contact_list_log', array(
            'title'   => sanitize_text_field( $title ),
            'message' => sanitize_textarea_field( $message ),
        ) );
    }
    
    public static function addFeaturedImage(
        $contact_id,
        $upload,
        $uploaded_type,
        $filename
    )
    {
        
        if ( $contact_id && $upload && $uploaded_type && $filename ) {
            $contact_id = intval( $contact_id );
            if ( !function_exists( 'wp_crop_image' ) ) {
                include ABSPATH . 'wp-admin/includes/image.php';
            }
            switch ( $uploaded_type ) {
                case 'image/jpeg':
                case 'image/png':
                case 'image/gif':
                    $image_url = $upload['file'];
                    // Prepare an array of post data for the attachment.
                    $attachment = array(
                        'guid'           => esc_url_raw( $image_url ),
                        'post_mime_type' => sanitize_text_field( $uploaded_type ),
                        'post_title'     => sanitize_text_field( $filename ),
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    );
                    $attach_id = wp_insert_attachment( $attachment, $image_url, $contact_id );
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $image_url );
                    wp_update_attachment_metadata( $attach_id, $attach_data );
                    set_post_thumbnail( $contact_id, $attach_id );
                    break;
            }
        }
    
    }
    
    public static function getText( $text_id, $default_text )
    {
        $s = get_option( 'contact_list_settings' );
        $text = sanitize_text_field( $default_text );
        if ( isset( $s[$text_id] ) && $s[$text_id] ) {
            $text = sanitize_text_field( $s[$text_id] );
        }
        return $text;
    }
    
    public static function getTextV2( $text_id, $translatable_text )
    {
        $s = get_option( 'contact_list_settings' );
        $text = '';
        // Text defined in the settings
        
        if ( isset( $s[$text_id] ) && $s[$text_id] ) {
            $text = sanitize_text_field( $s[$text_id] );
            // Default text
        } else {
            $text = sanitize_text_field( __( $translatable_text, 'contact-list' ) );
        }
        
        return $text;
    }
    
    public static function proFeatureMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . sanitize_text_field( __( 'This feature is available in the Pro version.', 'contact-list' ) ) . '</span>';
        $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=contact-list-pricing">' . sanitize_text_field( __( 'Upgrade here', 'contact-list' ) ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function proFeatureMarkupV2( $text = '' )
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . sanitize_text_field( $text ) . '</span>';
        $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=contact-list-pricing">' . sanitize_text_field( __( 'Upgrade here', 'contact-list' ) ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function proFeatureSettingsMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . sanitize_text_field( __( 'More settings available in the Pro version.', 'contact-list' ) ) . '</span>';
        $html .= '<a href="' . esc_url_raw( get_admin_url() ) . 'options-general.php?page=contact-list-pricing">' . sanitize_text_field( __( 'Upgrade here', 'contact-list' ) ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function modalSendMessageMarkup()
    {
        $s = get_option( 'contact_list_settings' );
        $input = esc_url_raw( get_site_url() );
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim( $input, '/' );
        // If scheme not included, prepend it
        if ( !preg_match( '#^http(s)?://#', $input ) ) {
            $input = 'http://' . $input;
        }
        $urlParts = parse_url( $input );
        // remove www
        $site_url = preg_replace( '/^www\\./', '', $urlParts['host'] );
        $html = '';
        $html .= '<div class="cl-modal-container cl-modal-container-send-message">';
        $html .= '<div class="cl-modal">';
        $html .= '<div class="close-modal-container">';
        $html .= '<a href="" class="cl-close-modal">&#10006;</a>';
        $html .= '</div>';
        $html .= '<h3>' . ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) . '</h3>';
        $html .= '<form class="contact-list-send-single">';
        $html .= '<label for="sender_name">' . sanitize_text_field( __( 'Sender name', 'contact-list' ) ) . '</label>';
        $html .= '<input class="contact-list-sender-name" name="sender_name" value="" placeholder="' . ContactListHelpers::sanitize_attr_value( __( 'Your name', 'contact-list' ) ) . '" />';
        $html .= '<label for="sender_email">' . sanitize_text_field( __( 'Sender email', 'contact-list' ) ) . '</label>';
        $html .= '<input class="contact-list-sender-email" name="sender_email" value="" placeholder="' . ContactListHelpers::sanitize_attr_value( __( 'Your email', 'contact-list' ) ) . '" />';
        $html .= '<label for="recipient">' . sanitize_text_field( __( 'Recipient', 'contact-list' ) ) . '</label>';
        $html .= '<span><span id="recipient" class="contact-list-recipient"></span></span>';
        $html .= '<label for="message">' . sanitize_text_field( __( 'Message', 'contact-list' ) ) . '</label>';
        $html .= '<textarea name="message" class="contact-list-message" placeholder=""></textarea>';
        $html .= '<div class="contact-list-message-error"></div>';
        $html .= '<input name="contact_id" type="hidden" value="" class="contact-list-contact-id" />';
        $html .= '<input name="site_url" type="hidden" value="' . esc_url_raw( $site_url ) . '" />';
        $html .= '<input name="txt_please_msg_first" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'Please write message first.', 'contact-list' ) ) . '" />';
        $html .= '<input name="txt_msg_sent_to" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'Message sent to recipient.', 'contact-list' ) ) . '" />';
        $html .= '<input name="txt_sending_please_wait" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'Please wait...', 'contact-list' ) ) . '" />';
        $html .= '<input name="txt_new_msg_from" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'New message from', 'contact-list' ) ) . '" />';
        $html .= '<input name="txt_sent_by" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'sent by', 'contact-list' ) ) . '" />';
        $html .= '<input name="txt_please_sender_details_first" type="hidden" value="' . ContactListHelpers::sanitize_attr_value( __( 'Please enter sender information first (name and email).', 'contact-list' ) ) . '" />';
        $html .= '<input type="submit" name="send_message" class="contact-list-send-single-submit" value="' . ContactListHelpers::sanitize_attr_value( __( 'Send', 'contact-list' ) ) . '" />';
        $html .= '<div class="contact-list-sending-message"></div>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function contactListMarkup(
        $wp_query,
        $include_children = 0,
        $atts = array(),
        $output_modals = 0
    )
    {
        $html = '';
        $html .= '<div id="contact-list-search">';
        $html .= '<ul id="all-contacts">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = intval( get_the_id() );
                $html .= ContactListHelpers::singleContactMarkup( $id, 0, $atts );
            }
        }
        $html .= '</ul><hr class="clear" />';
        $html .= '<div id="contact-list-nothing-found">';
        $html .= ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) );
        $html .= '</div>';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function singleContactMarkup( $id, $showGroups = 0, $atts = array() )
    {
        $id = intval( $id );
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $featured_img_url = esc_url_raw( get_the_post_thumbnail_url( $id, 'contact-list-contact' ) );
        $card_height_markup = '';
        if ( isset( $s['card_height'] ) && $s['card_height'] ) {
            $card_height_markup .= 'style="height: ' . intval( $s['card_height'] ) . 'px;"';
        }
        $html = '';
        $html .= '<li id="cl-' . $id . '">';
        $html .= '<div class="contact-list-contact-container" ' . $card_height_markup . '>';
        $html .= '<div class="contact-list-main-left ' . (( $featured_img_url ? '' : 'cl-full-width' )) . '"><div class="contact-list-main-elements">';
        
        if ( $showGroups && !isset( $s['contact_show_groups'] ) ) {
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<div class="contact-list-contact-groups">';
                foreach ( $terms as $term ) {
                    $t_id = intval( $term->term_id );
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . sanitize_text_field( $term->name ) . '</span>';
                    }
                }
                $html .= '</div>';
            }
        
        }
        
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'][0] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $text = (( isset( $c['_cl_first_name'][0] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $html .= '<div class="contact-list-hidden-name">' . sanitize_text_field( $text ) . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'][0] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $text = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'][0] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $html .= '<div class="contact-list-hidden-name">' . sanitize_text_field( $text ) . '</div>';
        }
        
        $html .= '<span class="contact-list-contact-name">' . sanitize_text_field( $contact_fullname ) . '</span>';
        if ( isset( $c['_cl_job_title'][0] ) && $c['_cl_job_title'][0] ) {
            $html .= '<span class="contact-list-job-title">' . sanitize_text_field( $c['_cl_job_title'][0] ) . '</span>';
        }
        
        if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) ) {
            $mailto = sanitize_email( $c['_cl_email'][0] );
            $mailto_obs = '';
            for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
            }
            if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
                $html .= '<span class="contact-list-email">' . (( $c['_cl_email'][0] ? '<a href="mailto:' . sanitize_text_field( $mailto_obs ) . '">' . sanitize_text_field( $mailto_obs ) . '</a>' : '' )) . '</span>';
            }
        }
        
        if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) || isset( $c['_cl_notify_emails'] ) && $c['_cl_notify_emails'] ) {
            if ( !isset( $s['hide_send_email_button'] ) ) {
                $html .= '<span class="contact-list-send-email cl-dont-print"><a href="" data-id="' . $id . '" data-name="' . ContactListHelpers::sanitize_attr_value( $contact_fullname ) . '">' . ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) . ' &raquo;</a></span>';
            }
        }
        $hide_phone_numbers = 0;
        if ( !$hide_phone_numbers ) {
            
            if ( isset( $c['_cl_phone'][0] ) && $c['_cl_phone'][0] ) {
                $phone_org = sanitize_text_field( $c['_cl_phone'][0] );
                $phone_href = preg_replace( '/[^0-9\\,]/', '', $phone_org );
                $html .= '<span class="contact-list-phone contact-list-phone-1"><a href="tel:' . $phone_href . '">' . $phone_org . '</a></span>';
            }
        
        }
        
        if ( isset( $s['contact_show_groups'] ) ) {
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<span class="contact-list-contact-groups-v2-title">' . ContactListHelpers::getText( 'contact_groups_title', __( 'Groups', 'contact-list' ) ) . '</span>';
                $html .= '<div class="contact-list-contact-groups-v2">';
                foreach ( $terms as $term ) {
                    $t_id = intval( $term->term_id );
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . sanitize_text_field( $term->name ) . '</span>';
                    }
                }
                $html .= '</div>';
            }
        
        }
        
        
        if ( isset( $c['_cl_address_line_1'][0] ) || isset( $c['_cl_country'][0] ) || isset( $c['_cl_state'][0] ) ) {
            $html .= '<div class="contact-list-address">';
            if ( !isset( $s['hide_address_title'] ) ) {
                $html .= '<span class="contact-list-address-title">' . (( isset( $s['address_title'] ) && $s['address_title'] ? sanitize_text_field( $s['address_title'] ) : sanitize_text_field( __( 'Address', 'contact-list' ) ) )) . '</span>';
            }
            if ( isset( $c['_cl_address_line_1'][0] ) && $c['_cl_address_line_1'][0] ) {
                $html .= '<span class="contact-list-address-line-1">' . sanitize_text_field( $c['_cl_address_line_1'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_2'][0] ) && $c['_cl_address_line_2'][0] ) {
                $html .= '<span class="contact-list-address-line-2">' . sanitize_text_field( $c['_cl_address_line_2'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_3'][0] ) && $c['_cl_address_line_3'][0] ) {
                $html .= '<span class="contact-list-address-line-3">' . sanitize_text_field( $c['_cl_address_line_3'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_4'][0] ) && $c['_cl_address_line_4'][0] ) {
                $html .= '<span class="contact-list-address-line-4">' . sanitize_text_field( $c['_cl_address_line_4'][0] ) . '</span>';
            }
            
            if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] || isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] || isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] || isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
                $html .= '<span class="contact-list-address-country-and-state">';
                $zip_code_first = 0;
                $zip_code_last = 0;
                
                if ( !isset( $s['move_zip_after_state'] ) && isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
                    $html .= sanitize_text_field( $c['_cl_zip_code'][0] );
                    $zip_code_first = 1;
                }
                
                
                if ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                    if ( $zip_code_first ) {
                        $html .= ' ';
                    }
                    $html .= sanitize_text_field( $c['_cl_city'][0] );
                }
                
                
                if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
                    if ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                        $html .= ', ';
                    }
                    $html .= sanitize_text_field( $c['_cl_state'][0] );
                }
                
                
                if ( isset( $s['move_zip_after_state'] ) && isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
                        $html .= ' ';
                    }
                    $html .= esc_html( $c['_cl_zip_code'][0] );
                    $zip_code_last = 1;
                }
                
                
                if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] ) {
                    
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
                        $html .= ', ';
                    } elseif ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                        $html .= ', ';
                    }
                    
                    $html .= sanitize_text_field( $c['_cl_country'][0] );
                }
                
                $html .= '</span>';
            }
            
            $html .= '</div>';
        }
        
        $custom_fields = [ 1 ];
        foreach ( $custom_fields as $n ) {
            if ( $n == 1 ) {
                $html .= '<div class="contact-list-custom-fields-container">';
            }
            if ( isset( $s['custom_field_' . $n . '_hide_from_contact_card'] ) ) {
                continue;
            }
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
            
            if ( isset( $c['_cl_custom_field_' . $n][0] ) && $c['_cl_custom_field_' . $n][0] ) {
                $cf_value = $c['_cl_custom_field_' . $n][0];
                
                if ( is_email( $cf_value ) ) {
                    $mailto = sanitize_email( $cf_value );
                    $mailto_obs = '';
                    for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                        $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
                    }
                    $cf_value = '<a href="mailto:' . sanitize_text_field( $mailto_obs ) . '">' . sanitize_text_field( $mailto_obs ) . '</a>';
                } else {
                    $link_title = '';
                    if ( isset( $s['custom_field_' . $n . '_link_text'] ) && $s['custom_field_' . $n . '_link_text'] ) {
                        $link_title = sanitize_text_field( $s['custom_field_' . $n . '_link_text'] );
                    }
                    
                    if ( $link_title ) {
                        $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">' . $link_title . '</a>', $cf_value );
                    } else {
                        $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                    }
                
                }
                
                
                if ( isset( $s['custom_field_' . $n . '_icon'] ) && $s['custom_field_' . $n . '_icon'] ) {
                    $html .= '<div class="contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                    $html .= '<i class="fa ' . sanitize_html_class( $s['custom_field_' . $n . '_icon'] ) . '" aria-hidden="true"></i><span>' . wp_kses_post( $cf_value ) . '</span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="contact-list-custom-field-' . $n . '">';
                    $html .= ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? '<strong>' . sanitize_text_field( $s['custom_field_' . $n . '_title'] ) . '</strong>' : '' );
                    $html .= wp_kses_post( $cf_value );
                    $html .= '</div>';
                }
            
            }
            
            if ( $n == 6 ) {
                $html .= '</div>';
            }
        }
        
        if ( isset( $c['_cl_description'][0] ) && $c['_cl_description'][0] ) {
            $html .= '<div class="contact-list-description">';
            if ( !isset( $s['hide_additional_info_title'] ) ) {
                $html .= '<span class="contact-list-description-title">' . (( isset( $s['additional_info_title'] ) && $s['additional_info_title'] ? sanitize_text_field( $s['additional_info_title'] ) : sanitize_text_field( __( 'Additional information', 'contact-list' ) ) )) . '</span>';
            }
            $html .= wp_kses_post( $c['_cl_description'][0] ) . '</div>';
        }
        
        $html .= '</div>';
        $html .= '<div class="contact-list-some-elements">';
        if ( isset( $c['_cl_facebook_url'][0] ) && $c['_cl_facebook_url'][0] ) {
            $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_facebook_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/facebook.svg', __FILE__ ) ) . '"  alt="' . ContactListHelpers::sanitize_attr_value( __( 'Facebook', 'contact-list' ) ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_instagram_url'][0] ) && $c['_cl_instagram_url'][0] ) {
            $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_instagram_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/instagram.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( __( 'Instagram', 'contact-list' ) ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_twitter_url'][0] ) && $c['_cl_twitter_url'][0] ) {
            $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_twitter_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/twitter.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( __( 'Twitter', 'contact-list' ) ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_linkedin_url'][0] ) && $c['_cl_linkedin_url'][0] ) {
            $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_linkedin_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/linkedin.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( __( 'LinkedIn', 'contact-list' ) ) . '" /></a>' : '' );
        }
        $html .= '<hr class="clear" /></div>';
        $html .= '</div>';
        
        if ( $featured_img_url ) {
            $featured_img_id = get_post_thumbnail_id( $id );
            $featured_img_alt = get_post_meta( $featured_img_id, '_wp_attachment_image_alt', true );
            $html .= '<div class="contact-list-main-right"><div class="contact-list-image ' . (( isset( $s['contact_image_style'] ) && $s['contact_image_style'] ? 'contact-list-image-' . ContactListHelpers::sanitize_attr_value( $s['contact_image_style'] ) : '' )) . ' ' . (( isset( $s['contact_image_shadow'] ) && $s['contact_image_shadow'] ? 'contact-list-image-shadow' : '' )) . '"><img src="' . esc_url_raw( $featured_img_url ) . '" alt="' . ContactListHelpers::sanitize_attr_value( $featured_img_alt ) . '" /></div></div>';
        }
        
        $html .= '<hr class="clear" />';
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }
    
    public static function getLayout( $s, $atts )
    {
        $layout = '';
        
        if ( isset( $atts['layout'] ) ) {
            $layout = $atts['layout'];
            
            if ( $layout == '2-columns' ) {
                $layout = '2-cards-on-the-same-row';
            } elseif ( $layout == '3-columns' ) {
                $layout = '3-cards-on-the-same-row';
            } elseif ( $layout == '4-columns' ) {
                $layout = '4-cards-on-the-same-row';
            }
        
        } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
            $layout = $s['layout'];
        }
        
        return $layout;
    }
    
    public static function createElemClass()
    {
        $elem_class = 'cuid-' . uniqid();
        return $elem_class;
    }
    
    public static function isPremium()
    {
        $is_premium = 0;
        return $is_premium;
    }

}