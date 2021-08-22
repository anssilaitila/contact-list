<?php

class ContactListPublicHelpers
{
    public static function pagination( $wp_query )
    {
        $html = '';
        if ( $wp_query->max_num_pages <= 1 ) {
            return;
        }
        $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
        $max = intval( $wp_query->max_num_pages );
        if ( $paged >= 1 ) {
            $links[] = $paged;
        }
        /** Add the pages around the current page to the array */
        
        if ( $paged >= 3 ) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }
        
        
        if ( $paged + 2 <= $max ) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }
        
        $html .= '<div class="contact-list-navigation"><ul>' . "\n";
        if ( get_previous_posts_link() ) {
            $html .= sprintf( '<li>%s</li>' . "\n", get_previous_posts_link( esc_html__( 'Previous contacts', 'contact-list' ) ) );
        }
        
        if ( !in_array( 1, $links ) ) {
            $class = ( 1 == $paged ? ' class="active"' : '' );
            $html .= sprintf(
                '<li%s><a href="%s">%s</a></li>' . "\n",
                $class,
                esc_url( get_pagenum_link( 1 ) ),
                '1'
            );
            if ( !in_array( 2, $links ) ) {
                $html .= '<li>…</li>';
            }
        }
        
        sort( $links );
        foreach ( (array) $links as $link ) {
            $class = ( $paged == $link ? ' class="active"' : '' );
            $html .= sprintf(
                '<li%s><a href="%s">%s</a></li>' . "\n",
                $class,
                esc_url( get_pagenum_link( $link ) ),
                $link
            );
        }
        
        if ( !in_array( $max, $links ) ) {
            if ( !in_array( $max - 1, $links ) ) {
                $html .= '<li>…</li>' . "\n";
            }
            $class = ( $paged == $max ? ' class="active"' : '' );
            $html .= sprintf(
                '<li%s><a href="%s">%s</a></li>' . "\n",
                $class,
                esc_url( get_pagenum_link( $max ) ),
                $max
            );
        }
        
        if ( get_next_posts_link( null, 999999999 ) ) {
            $html .= sprintf( '<li>%s</li>' . "\n", get_next_posts_link( esc_html__( 'Next contacts', 'contact-list' ), 999999999 ) );
        }
        $html .= '</ul></div>' . "\n";
        return $html;
    }
    
    public static function proFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-public-pro-feature">';
        $html .= '<span class="contact-list-public-pro-feature-title">';
        $html .= esc_html__( 'This feature is available in the Pro version.', 'contact-list' );
        $html .= '</span>';
        $html .= '<span>';
        $html .= esc_html__( 'You can use the shortcodes', 'contact-list' ) . ' [contact_list] ' . __( 'and', 'contact-list' ) . ' [contact_list_simple].';
        $html .= '</span>';
        $html .= '<span>';
        $html .= esc_html__( 'More info on shortcodes at', 'contact-list' ) . ' <a href="https://www.contactlistpro.com/support/shortcodes/" target="_blank">contactlistpro.com</a>.';
        $html .= '</span>';
        $html .= '</div>';
        return $html;
    }
    
    public static function searchFormMarkup( $atts, $s, $exclude = array() )
    {
        $html = '';
        $group_slug = '';
        $filter_active = 0;
        $wp_query_for_filter = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'post__not_in'   => $exclude,
        ) );
        $html .= '<form method="get" action="./" class="contact-list-ajax-form">';
        if ( isset( $atts ) ) {
            $html .= '<input type="hidden" name="cl_atts" value=\'' . serialize( $atts ) . '\'>';
        }
        
        if ( isset( $s['show_country_select_in_search'] ) && $s['show_country_select_in_search'] ) {
            $countries = [];
            $states = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                
                if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] && !in_array( $c['_cl_country'][0], $countries ) ) {
                    $countries[] = $c['_cl_country'][0];
                    $countries_for_dd[] = $c['_cl_country'][0];
                }
                
                
                if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] ) {
                    $country = ( isset( $countries[$c['_cl_country'][0]] ) ? $countries[$c['_cl_country'][0]] : [] );
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] && !in_array( $c['_cl_state'][0], $country ) ) {
                        $countries[$c['_cl_country'][0]][] = $c['_cl_state'][0];
                    }
                    
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] && isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
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
            $html .= '<select name="' . CONTACT_LIST_CAT1 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat1-sel" data-link-country-and-state="' . $link_country_and_state . '">';
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
            $html .= '<select name="' . CONTACT_LIST_CAT2 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat2-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_state', __( 'Select state', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT2] ) ? $_GET[CONTACT_LIST_CAT2] : '' )) . '">';
            
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
            $html .= '<select name="' . CONTACT_LIST_CAT3 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat3-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_city', __( 'Select city', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT3] ) ? $_GET[CONTACT_LIST_CAT3] : '' )) . '">';
            
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
            
            if ( $group_slug && (cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' )) ) {
            } elseif ( ContactListHelpers::isPremium() == 0 || isset( $s['simpler_category_dropdown'] ) ) {
                $groups = get_terms( array(
                    'taxonomy'   => 'contact-group',
                    'hide_empty' => true,
                ) );
                $html .= '<select name="cl_cat" class="' . ContactListHelpers::getSearchDropdownClass() . '">';
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
    
    public static function contactListSimpleMarkup(
        $wp_query,
        $include_children = 0,
        $atts = array(),
        $generate_modals = 0
    )
    {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $html .= '<div class="contact-list-search">';
        $html .= '<div class="contact-list-simple-list-container">';
        $html .= '<div class="contact-list-simple-list">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListPublicHelpers::singleContactSimpleMarkup( $id, 0, $atts );
            }
        }
        $html .= '</div>';
        $html .= '</div><hr class="clear" />';
        $html .= '<div class="contact-list-simple-nothing-found">';
        $html .= ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) );
        $html .= '</div>';
        if ( isset( $s['simple_list_modal'] ) && $generate_modals ) {
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function contactListSimpleMarkupTitles( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $html .= '<div class="contact-list-simple-list-row">';
        $contact_fullname = '';
        $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-name contact-list-simple-list-col-title"><span>' . ContactListHelpers::getText( 'name_title', __( 'Name', 'contact-list' ) ) . '</span></div>';
        
        if ( !isset( $s['simple_list_hide_job_title'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'job_title_title', __( 'Job title', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_email'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'email_title', __( 'Email', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_phone_1'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'phone_title', __( 'Phone', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_address_line_1'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'address_title', __( 'Address', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_city'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'city_title', __( 'City', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_some_links'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-some contact-list-simple-list-col-title"><span>';
            $html .= __( 'Social media', 'contact-list' );
            $html .= '</span></div>';
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
                $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
                $cf_field_title = ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? $s['custom_field_' . $n . '_title'] : '' );
                $html .= esc_html( $cf_field_title );
                $html .= '</span></div>';
            }
        
        }
        
        if ( isset( $s['simple_list_show_category'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
            $html .= ContactListHelpers::getText( 'category_title', __( 'Category', 'contact-list' ) );
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_send_message'] ) ) {
            $html .= '<div class="contact-list-simple-list-col cl-align-right"><span>';
            $html .= '';
            $html .= '</span></div>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    public static function singleContactSimpleMarkup( $id, $showGroups = 0, $atts = array() )
    {
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $html = '';
        $html .= '<div class="contact-list-simple-list-row contact-list-simple-list-row-data">';
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $html .= '<div style="display: none;">' . (( isset( $c['_cl_first_name'] ) ? esc_html( $c['_cl_first_name'][0] ) . ' ' : '' )) . esc_html( $c['_cl_last_name'][0] ) . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $html .= '<div style="display: none;">' . esc_html( $c['_cl_last_name'][0] ) . (( isset( $c['_cl_first_name'] ) ? ' ' . esc_html( $c['_cl_first_name'][0] ) : '' )) . '</div>';
        }
        
        $simple_list_modal = 0;
        if ( isset( $s['simple_list_modal'] ) ) {
        }
        if ( !$simple_list_modal ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-name"><span>' . esc_html( $contact_fullname ) . '</span></div>';
        }
        
        if ( !isset( $s['simple_list_hide_job_title'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            if ( isset( $c['_cl_job_title'] ) ) {
                $html .= esc_html( $c['_cl_job_title'][0] );
            }
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_email'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            
            if ( isset( $c['_cl_email'][0] ) ) {
                $mailto = $c['_cl_email'][0];
                $mailto_obs = '';
                for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                    $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
                }
                if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
                    $html .= ( $c['_cl_email'][0] ? '<a href="mailto:' . esc_attr( $mailto_obs ) . '">' . esc_html( $mailto_obs ) . '</a>' : '' );
                }
            }
            
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_phone_1'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            
            if ( isset( $c['_cl_phone'] ) ) {
                $phone_href = preg_replace( '/[^0-9\\,]/', '', $c['_cl_phone'][0] );
                $html .= '<a href="tel:' . esc_attr( $phone_href ) . '">' . esc_html( $c['_cl_phone'][0] ) . '</a>';
            }
            
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_address_line_1'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            if ( isset( $c['_cl_address_line_1'] ) ) {
                $html .= esc_html( $c['_cl_address_line_1'][0] );
            }
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_city'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            if ( isset( $c['_cl_city'] ) ) {
                $html .= esc_html( $c['_cl_city'][0] );
            }
            $html .= '</span></div>';
        }
        
        
        if ( !isset( $s['simple_list_hide_some_links'] ) ) {
            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-some">';
            $html .= '<div class="contact-list-simple-list-some-icons-container">';
            $html .= '<div class="contact-list-simple-list-some-icons">';
            if ( isset( $c['_cl_facebook_url'] ) ) {
                $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . esc_url( $c['_cl_facebook_url'][0] ) . '" target="_blank"><img src="' . plugins_url( '../img/facebook.svg', __FILE__ ) . '" alt="' . __( 'Facebook', 'contact-list' ) . '" /></a>' : '' );
            }
            if ( isset( $c['_cl_instagram_url'] ) ) {
                $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . esc_url( $c['_cl_instagram_url'][0] ) . '" target="_blank"><img src="' . plugins_url( '../img/instagram.svg', __FILE__ ) . '" alt="' . __( 'Instagram', 'contact-list' ) . '" /></a>' : '' );
            }
            if ( isset( $c['_cl_twitter_url'] ) ) {
                $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . esc_url( $c['_cl_twitter_url'][0] ) . '" target="_blank"><img src="' . plugins_url( '../img/twitter.svg', __FILE__ ) . '" alt="' . __( 'Twitter', 'contact-list' ) . '" /></a>' : '' );
            }
            if ( isset( $c['_cl_linkedin_url'] ) ) {
                $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . esc_url( $c['_cl_linkedin_url'][0] ) . '" target="_blank"><img src="' . plugins_url( '../img/linkedin.svg', __FILE__ ) . '" alt="' . __( 'LinkedIn', 'contact-list' ) . '" /></a>' : '' );
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
                            $cf_value = '<a href="mailto:' . esc_attr( $mailto_obs ) . '">' . esc_html( $mailto_obs ) . '</a>';
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
                            $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                            $html .= '<i class="fa ' . esc_attr( $s['custom_field_' . $n . '_icon'] ) . '" aria-hidden="true"></i><span>' . balanceTags( wp_kses_post( $cf_value ) ) . '</span>';
                            $html .= '</div>';
                        } else {
                            $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . '">';
                            $html .= balanceTags( wp_kses_post( $cf_value ) );
                            $html .= '</div>';
                        }
                    
                    }
                
                }
                
                $html .= '</span></div>';
            }
        
        }
        
        if ( isset( $s['simple_list_show_category'] ) ) {
            $html .= '<div class="contact-list-simple-list-col"><span>';
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<div class="contact-list-simple-contact-groups">';
                foreach ( $terms as $term ) {
                    $t_id = $term->term_id;
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . esc_html( $term->name ) . '</span>';
                    }
                }
                $html .= '</div>';
            }
            
            $html .= '</span></div>';
        }
        
        
        if ( isset( $s['simple_list_show_send_message'] ) ) {
            $html .= '<div class="contact-list-simple-list-col cl-align-right"><span>';
            if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) || isset( $c['_cl_notify_emails'] ) && $c['_cl_notify_emails'] ) {
                if ( !isset( $s['hide_send_email_button'] ) ) {
                    $html .= '<span class="contact-list-send-email contact-list-simple-send-email cl-dont-print"><a href="" data-id="' . esc_attr( $id ) . '" data-name="' . esc_attr( $contact_fullname ) . '">' . ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) . ' &raquo;</a></span>';
                }
            }
            $html .= '</span></div>';
        }
        
        $html .= '</div>';
        return $html;
    }

}