<?php

class ContactListPublicHelpers
{
    public static function proFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-public-pro-feature">';
        $html .= '<span class="contact-list-public-pro-feature-title">';
        $html .= __( 'This feature is available in the Pro version.', 'contact-list' );
        $html .= '</span>';
        $html .= '<span>';
        $html .= __( 'You can use the shortcodes', 'contact-list' ) . ' [contact_list] ' . __( 'and', 'contact-list' ) . ' [contact_list_simple].';
        $html .= '</span>';
        $html .= '<span>';
        $html .= __( 'More info on shortcodes at', 'contact-list' ) . ' <a href="https://www.contactlistpro.com/support/shortcodes/" target="_blank">contactlistpro.com</a>.';
        $html .= '</span>';
        $html .= '</div>';
        return $html;
    }
    
    public static function searchFormMarkup( $atts, $s, $exclude = array() )
    {
        $html = '';
        $filter_active = 0;
        $wp_query_for_filter = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'post__not_in'   => $exclude,
        ) );
        $html .= '<form method="get" action="./" class="contact-list-ajax-form">';
        
        if ( isset( $s['show_country_select_in_search'] ) && $s['show_country_select_in_search'] ) {
            $countries = [];
            $states = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                
                if ( isset( $c['_cl_country'] ) && $c['_cl_country'] && !in_array( $c['_cl_country'][0], $countries ) ) {
                    $countries[] = $c['_cl_country'][0];
                    $countries_for_dd[] = $c['_cl_country'][0];
                }
                
                
                if ( isset( $c['_cl_country'][0] ) ) {
                    $country = ( isset( $countries[$c['_cl_country'][0]] ) ? $countries[$c['_cl_country'][0]] : [] );
                    if ( isset( $c['_cl_state'] ) && $c['_cl_state'] && !in_array( $c['_cl_state'][0], $country ) ) {
                        $countries[$c['_cl_country'][0]][] = $c['_cl_state'][0];
                    }
                    
                    if ( isset( $c['_cl_state'] ) && $c['_cl_state'] && isset( $c['_cl_city'] ) && $c['_cl_city'] ) {
                        $state = $c['_cl_state'][0];
                        $city = $c['_cl_city'][0];
                        
                        if ( !in_array( $c['_cl_state'][0], $states ) ) {
                            $states[] = $state;
                            $states[$state] = [];
                        }
                        
                        if ( !in_array( $city, $states[$state] ) ) {
                            $states[$state][] = $city;
                        }
                    }
                
                }
            
            }
            $link_country_and_state = 0;
            if ( isset( $countries_for_dd ) && is_array( $countries_for_dd ) ) {
                sort( $countries_for_dd );
            }
            $html .= '<select name="' . CONTACT_LIST_CAT1 . '" class="cl_select_v2 contact-list-cat1-sel" data-link-country-and-state="' . $link_country_and_state . '">';
            $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_country', __( 'Select country', 'contact-list' ) ) . '</option>';
            if ( isset( $countries_for_dd ) && is_array( $countries_for_dd ) ) {
                foreach ( $countries_for_dd as $country ) {
                    $html .= '<option value="' . $country . '" ' . (( isset( $_GET[CONTACT_LIST_CAT1] ) && $_GET[CONTACT_LIST_CAT1] == $country ? 'selected="selected"' : '' )) . '>' . $country . '</option>';
                }
            }
            $html .= '</select>';
            $filter_active = 1;
        }
        
        
        if ( isset( $s['show_state_select_in_search'] ) && $s['show_state_select_in_search'] ) {
            $states = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                if ( isset( $c['_cl_state'] ) && $c['_cl_state'] && !in_array( $c['_cl_state'][0], $states ) ) {
                    $states[] = $c['_cl_state'][0];
                }
            }
            if ( isset( $states ) && is_array( $states ) ) {
                sort( $states );
            }
            $html .= '<select name="' . CONTACT_LIST_CAT2 . '" class="cl_select_v2 contact-list-cat2-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_state', __( 'Select state', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT2] ) ? $_GET[CONTACT_LIST_CAT2] : '' )) . '">';
            
            if ( !isset( $s['link_country_and_state'] ) ) {
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_state', __( 'Select state', 'contact-list' ) ) . '</option>';
                if ( isset( $states ) && is_array( $states ) ) {
                    foreach ( $states as $state ) {
                        $html .= '<option value="' . $state . '" ' . (( isset( $_GET[CONTACT_LIST_CAT2] ) && $_GET[CONTACT_LIST_CAT2] == $state ? 'selected="selected"' : '' )) . '>' . $state . '</option>';
                    }
                }
            }
            
            $html .= '</select>';
            $filter_active = 1;
        }
        
        
        if ( isset( $s['show_city_select_in_search'] ) && $s['show_city_select_in_search'] ) {
            $cities = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                if ( isset( $c['_cl_city'] ) && $c['_cl_city'] && !in_array( $c['_cl_city'][0], $cities ) ) {
                    $cities[] = $c['_cl_city'][0];
                }
            }
            if ( isset( $cities ) && is_array( $cities ) ) {
                sort( $cities );
            }
            $html .= '<select name="' . CONTACT_LIST_CAT3 . '" class="cl_select_v2 contact-list-cat3-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_city', __( 'Select city', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT3] ) ? $_GET[CONTACT_LIST_CAT3] : '' )) . '">';
            
            if ( !isset( $s['link_country_and_state'] ) ) {
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_city', __( 'Select city', 'contact-list' ) ) . '</option>';
                if ( isset( $cities ) && is_array( $cities ) ) {
                    foreach ( $cities as $city ) {
                        $html .= '<option value="' . $city . '" ' . (( isset( $_GET[CONTACT_LIST_CAT3] ) && $_GET[CONTACT_LIST_CAT3] == $city ? 'selected="selected"' : '' )) . '>' . $city . '</option>';
                    }
                }
            }
            
            $html .= '</select>';
            $filter_active = 1;
        }
        
        
        if ( isset( $s['show_category_select_in_search'] ) && $s['show_category_select_in_search'] ) {
            
            if ( ContactListHelpers::isPremium() == 0 || isset( $s['simpler_category_dropdown'] ) ) {
                $groups = get_terms( array(
                    'taxonomy'   => 'contact-group',
                    'hide_empty' => true,
                ) );
                $html .= '<select name="cl_cat" class="cl_select_v2">';
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_category', __( 'Select category', 'contact-list' ) ) . '</option>';
                foreach ( $groups as $g ) {
                    $t_id = $g->term_id;
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<option value="' . $g->slug . '" ' . (( isset( $_GET['cl_cat'] ) && $_GET['cl_cat'] == $g->slug ? 'selected="selected"' : '' )) . '>' . $g->name . '</option>';
                    }
                }
                $html .= '</select>';
            } else {
                $taxonomy_slug = 'contact-group';
                $html .= wp_dropdown_categories( [
                    'show_option_all' => ' ',
                    'hide_empty'      => 1,
                    'hierarchical'    => 1,
                    'show_count'      => 1,
                    'orderby'         => 'name',
                    'name'            => 'cl_cat',
                    'value_field'     => 'slug',
                    'taxonomy'        => $taxonomy_slug,
                    'echo'            => 0,
                    'class'           => 'cl_select_v2',
                    'show_option_all' => ContactListHelpers::getText( 'text_select_category', __( 'Select category', 'contact-list' ) ),
                ] );
            }
            
            $filter_active = 1;
        }
        
        if ( $filter_active ) {
            $html .= '<button type="submit" class="filter-contacts">' . ContactListHelpers::getText( 'text_filter_contacts', __( 'Filter contacts', 'contact-list' ) ) . '</button>';
        }
        $html .= '<hr class="clear" /></form>';
        return $html;
    }
    
    public static function searchFormSimpleMarkup( $atts, $s )
    {
        $html = '';
        return $html;
    }
    
    public static function contactListSimpleMarkup( $wp_query, $include_children = 0 )
    {
        $html = '';
        $html .= '<div class="contact-list-search">';
        $html .= '<div class="contact-list-simple-list">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListPublicHelpers::singleContactSimpleMarkup( $id );
            }
        }
        $html .= '</div><hr class="clear" />';
        $html .= '<div class="contact-list-simple-nothing-found">';
        $html .= ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) );
        $html .= '</div>';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function singleContactSimpleMarkup( $id, $showGroups = 0 )
    {
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $html = '';
        $html .= '<div class="contact-list-simple-list-row">';
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $html .= '<div style="display: none;">' . (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0] . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $html .= '<div style="display: none;">' . $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' )) . '</div>';
        }
        
        $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-name"><span>' . $contact_fullname . '</span></div>';
        $html .= '<div class="contact-list-simple-list-col"><span>';
        if ( isset( $c['_cl_job_title'] ) ) {
            $html .= $c['_cl_job_title'][0];
        }
        $html .= '</span></div>';
        
        if ( !isset( $s['simple_list_hide_email'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            
            if ( isset( $c['_cl_email'] ) ) {
                $mailto = $c['_cl_email'][0];
                $mailto_obs = '';
                for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                    $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
                }
                if ( isset( $c['_cl_email'] ) && !isset( $s['hide_contact_email'] ) ) {
                    $html .= ( $c['_cl_email'][0] ? '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>' : '' );
                }
            }
            
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_phone_1'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            
            if ( isset( $c['_cl_phone'] ) ) {
                $phone_href = preg_replace( '/[^0-9]/', '', $c['_cl_phone'][0] );
                $html .= '<a href="tel:' . $phone_href . '">' . $c['_cl_phone'][0] . '</a>';
            }
            
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_some_links'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-some">';
            $html .= '<div class="contact-list-simple-list-some-icons-container">';
            $html .= '<div class="contact-list-simple-list-some-icons">';
            if ( isset( $c['_cl_facebook_url'] ) ) {
                $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . $c['_cl_facebook_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/facebook.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
            }
            if ( isset( $c['_cl_instagram_url'] ) ) {
                $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . $c['_cl_instagram_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/instagram.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
            }
            if ( isset( $c['_cl_twitter_url'] ) ) {
                $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . $c['_cl_twitter_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/twitter.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
            }
            if ( isset( $c['_cl_linkedin_url'] ) ) {
                $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . $c['_cl_linkedin_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/linkedin.png', __FILE__ ) . '" width="37" height="28" alt="" /></a>' : '' );
            }
            $html .= '</div>';
            $html .= '</div>';
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
            
            if ( isset( $s['simple_list_show_custom_field_' . $n] ) ) {
                $html .= '<div class="contact-list-simple-list-col"><span>';
                
                if ( isset( $c['_cl_custom_field_' . $n] ) ) {
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
                            $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                        }
                        
                        
                        if ( $s['custom_field_' . $n . '_icon'] ) {
                            $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                            $html .= '<i class="fa ' . $s['custom_field_' . $n . '_icon'] . '" aria-hidden="true"></i><span>' . $cf_value . '</span>';
                            $html .= '</div>';
                        } else {
                            $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . '">';
                            $html .= ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? '<strong>' . $s['custom_field_' . $n . '_title'] . '</strong>' : '' );
                            $html .= $cf_value;
                            $html .= '</div>';
                        }
                    
                    }
                
                }
                
                $html .= '</span></div>';
            }
        
        }
        
        if ( isset( $s['simple_list_show_send_message'] ) ) {
            $html .= '<div class="contact-list-simple-list-col cl-align-right"><span>';
            if ( isset( $c['_cl_email'] ) || isset( $c['_cl_notify_emails'] ) ) {
                if ( !isset( $s['hide_send_email_button'] ) ) {
                    $html .= '<span class="contact-list-send-email contact-list-simple-send-email cl-dont-print"><a href="" data-id="' . $id . '" data-name="' . $contact_fullname . '">' . __( 'Send message', 'contact-list' ) . ' &raquo;</a></span>';
                }
            }
            $html .= '</span></div>';
        }
        
        $html .= '</div>';
        return $html;
    }

}