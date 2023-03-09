<?php

class ContactListPublicHelpersDefault
{
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
                $html .= ContactListPublicHelpersDefault::singleContactMarkup( $id, 0, $atts );
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
        
        if ( isset( $atts['card_height'] ) ) {
            $card_height_markup .= 'style="height: ' . intval( $atts['card_height'] ) . 'px;"';
        } elseif ( isset( $s['card_height'] ) && $s['card_height'] ) {
        }
        
        $html = '';
        $html .= '<li id="cl-' . $id . '">';
        $html .= ContactListPublicHooks::get_action_content( 'contact_list_before_contact_card' );
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
            if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
                $html .= '<span class="contact-list-email">' . (( $c['_cl_email'][0] ? '<a href="' . esc_url_raw( 'mailto:' . antispambot( $mailto ) ) . '">' . sanitize_text_field( antispambot( $mailto ) ) . '</a>' : '' )) . '</span>';
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
                $html .= '<span class="contact-list-phone contact-list-phone-1">';
                if ( isset( $s['show_titles_above_phone_numbers'] ) ) {
                    $html .= '<span class="contact-list-phone-title">' . ContactListHelpers::getText( 'phone_title', __( 'Phone', 'contact-list' ) ) . '</span>';
                }
                $html .= '<a href="tel:' . $phone_href . '">' . $phone_org . '</a>';
                $html .= '</span>';
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
                    $html .= sanitize_text_field( $c['_cl_zip_code'][0] );
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
        $html .= '<div class="contact-list-custom-fields-container">';
        foreach ( $custom_fields as $n ) {
            if ( isset( $s['custom_field_' . $n . '_hide_from_contact_card'] ) ) {
                continue;
            }
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
            
            if ( isset( $c['_cl_custom_field_' . $n][0] ) && $c['_cl_custom_field_' . $n][0] ) {
                $cf_value = $c['_cl_custom_field_' . $n][0];
                
                if ( is_email( $cf_value ) ) {
                    $mailto = sanitize_email( $cf_value );
                    $mailto_obs = antispambot( $mailto );
                    $cf_value = '<a href="mailto:' . sanitize_text_field( $mailto_obs ) . '">' . sanitize_text_field( $mailto_obs ) . '</a>';
                } else {
                    $link_title = '';
                    if ( isset( $s['custom_field_' . $n . '_link_text'] ) && $s['custom_field_' . $n . '_link_text'] ) {
                        $link_title = sanitize_text_field( $s['custom_field_' . $n . '_link_text'] );
                    }
                    $disable_automatic_linking = 0;
                    if ( !$disable_automatic_linking ) {
                        
                        if ( $link_title ) {
                            $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">' . $link_title . '</a>', $cf_value );
                        } else {
                            $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                        }
                    
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
        
        }
        $html .= '</div>';
        
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
            $featured_img_id = intval( get_post_thumbnail_id( $id ) );
            $featured_img_alt = sanitize_text_field( get_post_meta( $featured_img_id, '_wp_attachment_image_alt', true ) );
            $html .= '<div class="contact-list-main-right"><div class="contact-list-image ' . (( isset( $s['contact_image_style'] ) && $s['contact_image_style'] ? 'contact-list-image-' . ContactListHelpers::sanitize_attr_value( $s['contact_image_style'] ) : '' )) . ' ' . (( isset( $s['contact_image_shadow'] ) && $s['contact_image_shadow'] ? 'contact-list-image-shadow' : '' )) . '"><img src="' . esc_url_raw( $featured_img_url ) . '" alt="' . ContactListHelpers::sanitize_attr_value( $featured_img_alt ) . '" /></div></div>';
        }
        
        $html .= '<hr class="clear" />';
        $html .= '</div>';
        $html .= ContactListPublicHooks::get_action_content( 'contact_list_after_contact_card' );
        $html .= '</li>';
        return $html;
    }

}