<?php

class ContactListHelpers
{
    public static function writeLog( $title = '', $message = '' )
    {
        global  $wpdb ;
        $wpdb->insert( $wpdb->prefix . 'contact_list_log', array(
            'title'   => $title,
            'message' => $message,
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
                        'guid'           => $image_url,
                        'post_mime_type' => $uploaded_type,
                        'post_title'     => $filename,
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
        $text = $default_text;
        if ( isset( $s[$text_id] ) && $s[$text_id] ) {
            $text = $s[$text_id];
        }
        return esc_html( $text );
    }
    
    public static function getTextV2( $text_id, $translatable_text )
    {
        $s = get_option( 'contact_list_settings' );
        $text = '';
        // Text defined in the settings
        
        if ( isset( $s[$text_id] ) && $s[$text_id] ) {
            $text = esc_html( $s[$text_id] );
            // Default text
        } else {
            $text = esc_html__( $translatable_text, 'contact-list' );
        }
        
        return $text;
    }
    
    public static function proFeatureMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . __( 'This feature is available in the Pro version.', 'contact-list' ) . '</span>';
        $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . __( 'Upgrade here', 'contact-list' ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function proFeatureMarkupV2( $text = '' )
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . $text . '</span>';
        $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . esc_html__( 'Upgrade here', 'contact-list' ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function proFeatureSettingsMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-pro-feature">';
        $html .= '<span>' . esc_html__( 'More settings available in the Pro version.', 'contact-list' ) . '</span>';
        $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . esc_html__( 'Upgrade here', 'contact-list' ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function modalContactMarkup( $id )
    {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $html .= '<div class="cl-modal-container cl-modal-container-contact cl-modal-container-' . $id . '">';
        $html .= '<div class="cl-modal">';
        $html .= '<div class="close-modal-container">';
        $html .= '<a href="" class="cl-close-modal">&#10006;</a>';
        $html .= '</div>';
        $html .= '<ul>';
        $html .= ContactListHelpers::singleContactMarkup( $id );
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function modalSendMessageMarkup()
    {
        $s = get_option( 'contact_list_settings' );
        
        if ( isset( $s['activate_recaptcha'] ) ) {
            wp_enqueue_script( 'contact-list-recaptcha', 'https://www.google.com/recaptcha/api.js' );
            // async defer
        }
        
        $input = get_site_url();
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
        $recaptcha_active = ( isset( $s['activate_recaptcha'] ) ? 1 : 0 );
        $html .= '<input type="hidden" name="recaptcha_active" value="' . $recaptcha_active . '" />';
        if ( $recaptcha_active && isset( $s['recaptcha_site_key'] ) ) {
            $html .= '<div class="g-recaptcha recaptcha-container" data-sitekey="' . $s['recaptcha_site_key'] . '"></div>';
        }
        $html .= '<label for="sender_name">' . esc_html__( 'Sender name', 'contact-list' ) . '</label>';
        $html .= '<input class="contact-list-sender-name" name="sender_name" value="" placeholder="' . esc_html__( 'Your name', 'contact-list' ) . '" />';
        $html .= '<label for="sender_email">' . esc_html__( 'Sender email', 'contact-list' ) . '</label>';
        $html .= '<input class="contact-list-sender-email" name="sender_email" value="" placeholder="' . esc_html__( 'Your email', 'contact-list' ) . '" />';
        $html .= '<label for="recipient">' . esc_html__( 'Recipient', 'contact-list' ) . '</label>';
        $html .= '<span><span id="recipient" class="contact-list-recipient"></span></span>';
        $html .= '<label for="message">' . esc_html__( 'Message', 'contact-list' ) . '</label>';
        $html .= '<textarea name="message" class="contact-list-message" placeholder=""></textarea>';
        $html .= '<div class="contact-list-message-error"></div>';
        $html .= '<input name="contact_id" type="hidden" value="" class="contact-list-contact-id" />';
        $html .= '<input name="site_url" type="hidden" value="' . $site_url . '" />';
        $html .= '<input name="txt_please_msg_first" type="hidden" value="' . esc_html__( 'Please write message first.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_msg_sent_to" type="hidden" value="' . esc_html__( 'Message sent to recipient.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_sending_please_wait" type="hidden" value="' . esc_html__( 'Please wait...', 'contact-list' ) . '" />';
        $html .= '<input name="txt_new_msg_from" type="hidden" value="' . esc_html__( 'New message from', 'contact-list' ) . '" />';
        $html .= '<input name="txt_sent_by" type="hidden" value="' . esc_html__( 'sent by', 'contact-list' ) . '" />';
        $html .= '<input name="txt_recaptcha_validation_error" type="hidden" value="' . esc_html__( 'Please check the &quot;I\'m not a robot&quot;-checkbox first.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_please_sender_details_first" type="hidden" value="' . esc_html__( 'Please enter sender information first (name and email).', 'contact-list' ) . '" />';
        $html .= '<input type="submit" name="send_message" class="contact-list-send-single-submit" value="' . esc_html__( 'Send', 'contact-list' ) . '" />';
        $html .= '<div class="contact-list-sending-message"></div>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function listAllContactsForSearchMarkup( $wp_query, $elem_class = 'cuid-none' )
    {
        $html = '';
        $html .= '<div id="contact-list-search">';
        $html .= '<ul id="all-contacts" class="contact-list-all-contacts-list cl-all-contacts-' . $elem_class . '">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListHelpers::singleContactMarkup( $id, 1 );
            }
        }
        $html .= '</ul><hr class="clear" />';
        $html .= '<div id="contact-list-nothing-found" class="contact-list-nothing-found-' . $elem_class . '">';
        $html .= ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) );
        $html .= '</div>';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function contactListMarkup( $wp_query, $include_children = 0 )
    {
        $html = '';
        $html .= '<div id="contact-list-search">';
        $html .= '<ul id="all-contacts">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListHelpers::singleContactMarkup( $id );
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
    
    public static function singleContactMarkup( $id, $showGroups = 0 )
    {
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $featured_img_url = get_the_post_thumbnail_url( $id, 'contact-list-contact' );
        $html = '';
        $html .= '<li id="cl-' . $id . '">';
        $html .= '<div class="contact-list-contact-container">';
        $html .= '<div class="contact-list-main-left ' . (( $featured_img_url ? '' : 'cl-full-width' )) . '"><div class="contact-list-main-elements">';
        
        if ( $showGroups && !isset( $s['contact_show_groups'] ) ) {
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<div class="contact-list-contact-groups">';
                foreach ( $terms as $term ) {
                    $t_id = $term->term_id;
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . $term->name . '</span>';
                    }
                }
                $html .= '</div>';
            }
        
        }
        
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $text = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $html .= '<div style="display: none;">' . esc_html( $text ) . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $text = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $html .= '<div style="display: none;">' . esc_html( $text ) . '</div>';
        }
        
        $html .= '<span class="contact-list-contact-name">' . esc_html( $contact_fullname ) . '</span>';
        if ( isset( $c['_cl_job_title'] ) ) {
            $html .= '<span class="contact-list-job-title">' . esc_html( $c['_cl_job_title'][0] ) . '</span>';
        }
        
        if ( isset( $c['_cl_email'] ) ) {
            $mailto = $c['_cl_email'][0];
            $mailto_obs = '';
            for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
            }
            if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
                $html .= '<span class="contact-list-email">' . (( $c['_cl_email'][0] ? '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>' : '' )) . '</span>';
            }
        }
        
        if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) || isset( $c['_cl_notify_emails'] ) && $c['_cl_notify_emails'] ) {
            if ( !isset( $s['hide_send_email_button'] ) ) {
                $html .= '<span class="contact-list-send-email cl-dont-print"><a href="" data-id="' . $id . '" data-name="' . $contact_fullname . '">' . ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) . ' &raquo;</a></span>';
            }
        }
        
        if ( !isset( $s['hide_phone_numbers_from_public_card'] ) ) {
            
            if ( isset( $c['_cl_phone'] ) ) {
                $phone_href = preg_replace( '/[^0-9\\,]/', '', $c['_cl_phone'][0] );
                $html .= '<span class="contact-list-phone"><a href="tel:' . $phone_href . '">' . esc_html( $c['_cl_phone'][0] ) . '</a></span>';
            }
            
            
            if ( isset( $c['_cl_phone_2'] ) ) {
                $phone_href = preg_replace( '/[^0-9\\,]/', '', $c['_cl_phone_2'][0] );
                $html .= '<span class="contact-list-phone"><a href="tel:' . $phone_href . '">' . esc_html( $c['_cl_phone_2'][0] ) . '</a></span>';
            }
            
            
            if ( isset( $c['_cl_phone_3'] ) ) {
                $phone_href = preg_replace( '/[^0-9\\,]/', '', $c['_cl_phone_3'][0] );
                $html .= '<span class="contact-list-phone"><a href="tel:' . $phone_href . '">' . esc_html( $c['_cl_phone_3'][0] ) . '</a></span>';
            }
        
        }
        
        
        if ( isset( $s['contact_show_groups'] ) ) {
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<span class="contact-list-contact-groups-v2-title">' . ContactListHelpers::getText( 'contact_groups_title', __( 'Groups', 'contact-list' ) ) . '</span>';
                $html .= '<div class="contact-list-contact-groups-v2">';
                foreach ( $terms as $term ) {
                    $t_id = $term->term_id;
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . $term->name . '</span>';
                    }
                }
                $html .= '</div>';
            }
        
        }
        
        
        if ( isset( $c['_cl_address_line_1'] ) || isset( $c['_cl_country'] ) || isset( $c['_cl_state'] ) ) {
            $html .= '<div class="contact-list-address">';
            if ( !isset( $s['hide_address_title'] ) ) {
                $html .= '<span class="contact-list-address-title">' . (( isset( $s['address_title'] ) && $s['address_title'] ? $s['address_title'] : esc_html__( 'Address', 'contact-list' ) )) . '</span>';
            }
            if ( isset( $c['_cl_address_line_1'] ) ) {
                $html .= '<span class="contact-list-address-line-1">' . esc_html( $c['_cl_address_line_1'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_2'] ) ) {
                $html .= '<span class="contact-list-address-line-2">' . esc_html( $c['_cl_address_line_2'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_3'] ) ) {
                $html .= '<span class="contact-list-address-line-3">' . esc_html( $c['_cl_address_line_3'][0] ) . '</span>';
            }
            if ( isset( $c['_cl_address_line_4'] ) ) {
                $html .= '<span class="contact-list-address-line-4">' . esc_html( $c['_cl_address_line_4'][0] ) . '</span>';
            }
            
            if ( isset( $c['_cl_country'] ) && $c['_cl_country'][0] || isset( $c['_cl_state'] ) && $c['_cl_state'][0] || isset( $c['_cl_city'] ) && $c['_cl_city'][0] ) {
                $html .= '<span class="contact-list-address-country-and-state">';
                $zip_code_exists = 0;
                
                if ( isset( $c['_cl_zip_code'] ) && $c['_cl_zip_code'][0] ) {
                    $html .= esc_html( $c['_cl_zip_code'][0] );
                    $zip_code_exists = 1;
                }
                
                
                if ( isset( $c['_cl_city'] ) && $c['_cl_city'][0] ) {
                    if ( $zip_code_exists ) {
                        $html .= ' ';
                    }
                    $html .= esc_html( $c['_cl_city'][0] );
                }
                
                
                if ( isset( $c['_cl_state'] ) && $c['_cl_state'][0] ) {
                    if ( isset( $c['_cl_city'] ) && $c['_cl_city'][0] ) {
                        $html .= ', ';
                    }
                    $html .= esc_html( $c['_cl_state'][0] );
                }
                
                
                if ( isset( $c['_cl_country'] ) && $c['_cl_country'][0] ) {
                    
                    if ( isset( $c['_cl_state'] ) && $c['_cl_state'][0] ) {
                        $html .= ', ';
                    } elseif ( isset( $c['_cl_city'] ) && $c['_cl_city'][0] ) {
                        $html .= ', ';
                    }
                    
                    $html .= esc_html( $c['_cl_country'][0] );
                }
                
                $html .= '</span>';
            }
            
            $html .= '</div>';
        }
        
        $custom_fields = [
            1,
            2,
            3,
            4,
            5,
            6
        ];
        foreach ( $custom_fields as $n ) {
            if ( $n == 1 ) {
                $html .= '<div class="contact-list-custom-fields-container">';
            }
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
            
            if ( isset( $c['_cl_custom_field_' . $n] ) ) {
                $cf_value = $c['_cl_custom_field_' . $n][0];
                
                if ( is_email( $cf_value ) ) {
                    $mailto = $cf_value;
                    $mailto_obs = '';
                    for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                        $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
                    }
                    $cf_value = '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>';
                } else {
                    $link_title = '';
                    if ( isset( $s['custom_field_' . $n . '_link_text'] ) && $s['custom_field_' . $n . '_link_text'] ) {
                        $link_title = $s['custom_field_' . $n . '_link_text'];
                    }
                    
                    if ( $link_title ) {
                        $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">' . $link_title . '</a>', $cf_value );
                    } else {
                        $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                    }
                
                }
                
                
                if ( $s['custom_field_' . $n . '_icon'] ) {
                    $html .= '<div class="contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                    $html .= '<i class="fa ' . $s['custom_field_' . $n . '_icon'] . '" aria-hidden="true"></i><span>' . $cf_value . '</span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="contact-list-custom-field-' . $n . '">';
                    $html .= ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? '<strong>' . $s['custom_field_' . $n . '_title'] . '</strong>' : '' );
                    $html .= $cf_value;
                    $html .= '</div>';
                }
            
            }
            
            if ( $n == 6 ) {
                $html .= '</div>';
            }
        }
        
        if ( isset( $c['_cl_description'] ) ) {
            $html .= '<div class="contact-list-description">';
            if ( !isset( $s['hide_additional_info_title'] ) ) {
                $html .= '<span class="contact-list-description-title">' . (( isset( $s['additional_info_title'] ) && $s['additional_info_title'] ? $s['additional_info_title'] : esc_html__( 'Additional information', 'contact-list' ) )) . '</span>';
            }
            $html .= $c['_cl_description'][0] . '</div>';
        }
        
        $html .= '</div>';
        $html .= '<div class="contact-list-some-elements">';
        if ( isset( $c['_cl_facebook_url'] ) ) {
            $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . $c['_cl_facebook_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/facebook.png', __FILE__ ) . '" width="28" height="28" alt="' . esc_html__( 'Facebook', 'contact-list' ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_instagram_url'] ) ) {
            $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . $c['_cl_instagram_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/instagram.png', __FILE__ ) . '" width="28" height="28" alt="' . esc_html__( 'Instagram', 'contact-list' ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_twitter_url'] ) ) {
            $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . $c['_cl_twitter_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/twitter.png', __FILE__ ) . '" width="28" height="28" alt="' . esc_html__( 'Twitter', 'contact-list' ) . '" /></a>' : '' );
        }
        if ( isset( $c['_cl_linkedin_url'] ) ) {
            $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . $c['_cl_linkedin_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/linkedin.png', __FILE__ ) . '" width="37" height="28" alt="' . esc_html__( 'LinkedIn', 'contact-list' ) . '" /></a>' : '' );
        }
        $html .= '<hr class="clear" /></div>';
        $html .= '</div>';
        
        if ( $featured_img_url ) {
            $featured_img_id = get_post_thumbnail_id( $id );
            $featured_img_alt = get_post_meta( $featured_img_id, '_wp_attachment_image_alt', true );
            $html .= '<div class="contact-list-main-right"><div class="contact-list-image ' . (( isset( $s['contact_image_style'] ) && $s['contact_image_style'] ? 'contact-list-image-' . $s['contact_image_style'] : '' )) . ' ' . (( isset( $s['contact_image_shadow'] ) && $s['contact_image_shadow'] ? 'contact-list-image-shadow' : '' )) . '"><img src="' . $featured_img_url . '" alt="' . esc_html( $featured_img_alt ) . '" /></div></div>';
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
    
    public static function initLayout( $s, $atts, $elem_class = 'cuid-none' )
    {
        $html = '';
        
        if ( isset( $s['card_background'] ) && $s['card_background'] ) {
            $html .= '<style>.contact-list-container #contact-list-search ul li { margin-bottom: 5px; } </style>';
            
            if ( $s['card_background'] == 'white' ) {
                $html .= '<style>.contact-list-contact-container { background: #fff; } </style>';
            } elseif ( $s['card_background'] == 'light_gray' ) {
                $html .= '<style>.contact-list-contact-container { background: #f7f7f7; } </style>';
            }
        
        }
        
        if ( isset( $s['card_border'] ) && $s['card_border'] ) {
            
            if ( $s['card_border'] == 'black' ) {
                $html .= '<style>.contact-list-contact-container { border: 1px solid #333; border-radius: 10px; padding: 10px; } </style>';
            } elseif ( $s['card_border'] == 'gray' ) {
                $html .= '<style>.contact-list-contact-container { border: 1px solid #bbb; border-radius: 10px; padding: 10px; } </style>';
            }
        
        }
        
        if ( isset( $s['card_height'] ) && $s['card_height'] || isset( $atts['card_height'] ) ) {
            $card_height = 380;
            
            if ( isset( $atts['card_height'] ) ) {
            } elseif ( isset( $s['card_height'] ) && $s['card_height'] ) {
                $card_height = $s['card_height'];
            }
            
            $html .= '<style>.' . $elem_class . '.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $card_height . 'px; } </style>';
            $html .= '<style>.' . $elem_class . '.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $card_height . 'px; } </style>';
            $html .= '<style>.' . $elem_class . '.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $card_height . 'px; } </style>';
            $html .= '<style> @media (max-width: 820px) { .' . $elem_class . '.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .' . $elem_class . '.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .' . $elem_class . '.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
        }
        
        return $html;
    }
    
    public static function isPremium()
    {
        $is_premium = 0;
        return $is_premium;
    }

}