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
            $html .= sprintf( '<li>%s</li>' . "\n", get_previous_posts_link( sanitize_text_field( __( 'Previous contacts', 'contact-list' ) ) ) );
        }
        
        if ( !in_array( 1, $links ) ) {
            $class = ( 1 == $paged ? ' class="active"' : '' );
            $html .= sprintf(
                '<li%s><a href="%s">%s</a></li>' . "\n",
                $class,
                esc_url_raw( get_pagenum_link( 1 ) ),
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
                esc_url_raw( get_pagenum_link( $link ) ),
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
                esc_url_raw( get_pagenum_link( $max ) ),
                $max
            );
        }
        
        if ( get_next_posts_link( null, 999999999 ) ) {
            $html .= sprintf( '<li>%s</li>' . "\n", get_next_posts_link( sanitize_text_field( __( 'Next contacts', 'contact-list' ), 999999999 ) ) );
        }
        $html .= '</ul></div>' . "\n";
        return $html;
    }
    
    public static function proFeaturePublicMarkup()
    {
        $html = '';
        $html .= '<div class="contact-list-public-pro-feature">';
        $html .= '<span class="contact-list-public-pro-feature-title">';
        $html .= sanitize_text_field( __( 'This feature is available in the paid plans.', 'contact-list' ) );
        $html .= '</span>';
        $html .= '<span>';
        $html .= sanitize_text_field( __( 'You can use the shortcodes', 'contact-list' ) ) . ' [[contact_list]] ' . sanitize_text_field( __( 'and', 'contact-list' ) ) . ' [[contact_list_simple]].';
        $html .= '</span>';
        $html .= '<span>';
        $html .= sanitize_text_field( __( 'More info on shortcodes', 'contact-list' ) ) . ' <a href="' . esc_url( get_admin_url( null, 'edit.php?post_type=contact&page=contact-list-shortcodes' ) ) . '" target="_blank">here</a>.';
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
            $html .= '<input type="hidden" name="cl_atts" value=\'' . ContactListHelpers::sanitize_attr_value( serialize( $atts ) ) . '\'>';
        }
        
        if ( isset( $s['show_country_select_in_search'] ) && $s['show_country_select_in_search'] ) {
            $countries = [];
            $states = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                
                if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] && is_array( $countries ) && !in_array( $c['_cl_country'][0], $countries ) ) {
                    $countries[] = sanitize_text_field( $c['_cl_country'][0] );
                    $countries_for_dd[] = sanitize_text_field( $c['_cl_country'][0] );
                }
                
                
                if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] ) {
                    $country_temp = sanitize_text_field( $c['_cl_country'][0] );
                    $country = ( isset( $countries[$country_temp] ) ? $countries[$country_temp] : [] );
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] && is_array( $country ) && !in_array( $c['_cl_state'][0], $country ) ) {
                        $countries[$country_temp][] = sanitize_text_field( $c['_cl_state'][0] );
                    }
                    
                    if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] && isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                        $state = sanitize_text_field( $c['_cl_state'][0] );
                        $city = sanitize_text_field( $c['_cl_city'][0] );
                        
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
            $html .= '<select name="' . CONTACT_LIST_CAT1 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat1-sel" data-link-country-and-state="' . intval( $link_country_and_state ) . '">';
            $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_country', __( 'Select country', 'contact-list' ) ) . '</option>';
            if ( isset( $countries_for_dd ) && is_array( $countries_for_dd ) ) {
                foreach ( $countries_for_dd as $country ) {
                    $html .= '<option value="' . ContactListHelpers::sanitize_attr_value( $country ) . '" ' . (( isset( $_GET[CONTACT_LIST_CAT1] ) && $_GET[CONTACT_LIST_CAT1] == $country ? 'selected="selected"' : '' )) . '>' . sanitize_text_field( $country ) . '</option>';
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
                if ( isset( $c['_cl_state'] ) && $c['_cl_state'] && is_array( $states ) && !in_array( $c['_cl_state'][0], $states ) ) {
                    $states[] = sanitize_text_field( $c['_cl_state'][0] );
                }
            }
            if ( isset( $states ) && is_array( $states ) ) {
                sort( $states );
            }
            $html .= '<select name="' . CONTACT_LIST_CAT2 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat2-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_state', __( 'Select state', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT2] ) ? ContactListHelpers::sanitize_attr_value( $_GET[CONTACT_LIST_CAT2] ) : '' )) . '">';
            
            if ( !isset( $s['link_country_and_state'] ) ) {
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_state', __( 'Select state', 'contact-list' ) ) . '</option>';
                if ( isset( $states ) && is_array( $states ) ) {
                    foreach ( $states as $state ) {
                        $html .= '<option value="' . ContactListHelpers::sanitize_attr_value( $state ) . '" ' . (( isset( $_GET[CONTACT_LIST_CAT2] ) && $_GET[CONTACT_LIST_CAT2] == $state ? 'selected="selected"' : '' )) . '>' . sanitize_text_field( $state ) . '</option>';
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
                if ( isset( $c['_cl_city'] ) && $c['_cl_city'] && is_array( $cities ) && !in_array( $c['_cl_city'][0], $cities ) ) {
                    $cities[] = sanitize_text_field( $c['_cl_city'][0] );
                }
            }
            if ( isset( $cities ) && is_array( $cities ) ) {
                sort( $cities );
            }
            $html .= '<select name="' . CONTACT_LIST_CAT3 . '" class="' . ContactListHelpers::getSearchDropdownClass() . ' contact-list-cat3-sel" data-select-value="' . ContactListHelpers::getText( 'text_select_city', __( 'Select city', 'contact-list' ) ) . '" data-current-value="' . (( isset( $_GET[CONTACT_LIST_CAT3] ) ? ContactListHelpers::sanitize_attr_value( $_GET[CONTACT_LIST_CAT3] ) : '' )) . '">';
            
            if ( !isset( $s['link_country_and_state'] ) ) {
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_city', __( 'Select city', 'contact-list' ) ) . '</option>';
                if ( isset( $cities ) && is_array( $cities ) ) {
                    foreach ( $cities as $city ) {
                        $html .= '<option value="' . ContactListHelpers::sanitize_attr_value( $city ) . '" ' . (( isset( $_GET[CONTACT_LIST_CAT3] ) && $_GET[CONTACT_LIST_CAT3] == $city ? 'selected="selected"' : '' )) . '>' . sanitize_text_field( $city ) . '</option>';
                    }
                }
            }
            
            $html .= '</select>';
            $filter_active = 1;
        }
        
        
        if ( isset( $s['show_category_select_in_search'] ) && $s['show_category_select_in_search'] ) {
            $category_select_shown = 0;
            
            if ( !$category_select_shown && (ContactListHelpers::isPremium() == 0 || isset( $s['simpler_category_dropdown'] )) ) {
                $exclude_groups = [];
                $groups = get_terms( array(
                    'taxonomy'   => 'contact-group',
                    'hide_empty' => true,
                    'exclude'    => $exclude_groups,
                ) );
                $html .= '<select name="cl_cat" class="' . esc_attr( ContactListHelpers::getSearchDropdownClass() ) . '">';
                $html .= '<option value="">' . ContactListHelpers::getText( 'text_select_category', __( 'Select category', 'contact-list' ) ) . '</option>';
                foreach ( $groups as $g ) {
                    $t_id = intval( $g->term_id );
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<option value="' . sanitize_title( $g->slug ) . '" ' . (( isset( $_GET['cl_cat'] ) && $_GET['cl_cat'] == $g->slug ? 'selected="selected"' : '' )) . '>' . sanitize_text_field( $g->name ) . '</option>';
                    }
                }
                $html .= '</select>';
            } elseif ( !$category_select_shown ) {
            }
            
            $filter_active = 1;
        }
        
        $html .= '<hr class="clear" /></form>';
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
        if ( isset( $s['simple_list_show_titles_for_columns'] ) ) {
            $html .= ContactListPublicHelpers::contactListSimpleMarkupTitles( $atts );
        }
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
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function contactListSimpleMarkupTitles( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $html .= '<div class="contact-list-simple-list-row">';
        $simple_list_fields_default_titles = [
            'full_name'      => sanitize_text_field( __( 'Full name', 'contact-list' ) ),
            'first_name'     => sanitize_text_field( __( 'First name', 'contact-list' ) ),
            'last_name'      => sanitize_text_field( __( 'Last Name', 'contact-list' ) ),
            'job_title'      => sanitize_text_field( __( 'Job title', 'contact-list' ) ),
            'phone'          => sanitize_text_field( __( 'Phone 1', 'contact-list' ) ),
            'phone_2'        => sanitize_text_field( __( 'Phone 2', 'contact-list' ) ),
            'phone_3'        => sanitize_text_field( __( 'Phone 3', 'contact-list' ) ),
            'email'          => sanitize_text_field( __( 'Email', 'contact-list' ) ),
            'some_icons'     => sanitize_text_field( __( 'Some icons', 'contact-list' ) ),
            'country'        => sanitize_text_field( __( 'Country', 'contact-list' ) ),
            'state'          => sanitize_text_field( __( 'State', 'contact-list' ) ),
            'city'           => sanitize_text_field( __( 'City', 'contact-list' ) ),
            'zip_code'       => sanitize_text_field( __( 'ZIP Code', 'contact-list' ) ),
            'address_line_1' => sanitize_text_field( __( 'Address Line 1', 'contact-list' ) ),
            'address_line_2' => sanitize_text_field( __( 'Address Line 2', 'contact-list' ) ),
            'address_line_3' => sanitize_text_field( __( 'Address Line 3', 'contact-list' ) ),
            'address_line_4' => sanitize_text_field( __( 'Address Line 4', 'contact-list' ) ),
            'custom_field_1' => sanitize_text_field( __( 'Custom field 1', 'contact-list' ) ),
            'custom_field_2' => sanitize_text_field( __( 'Custom field 2', 'contact-list' ) ),
            'custom_field_3' => sanitize_text_field( __( 'Custom field 3', 'contact-list' ) ),
            'custom_field_4' => sanitize_text_field( __( 'Custom field 4', 'contact-list' ) ),
            'custom_field_5' => sanitize_text_field( __( 'Custom field 5', 'contact-list' ) ),
            'custom_field_6' => sanitize_text_field( __( 'Custom field 6', 'contact-list' ) ),
            'description'    => sanitize_text_field( __( 'Additional information', 'contact-list' ) ),
            'category'       => sanitize_text_field( __( 'Category', 'contact-list' ) ),
            'send_message'   => sanitize_text_field( __( 'Send message', 'contact-list' ) ),
        ];
        $simple_list_fields = [];
        
        if ( sizeof( $simple_list_fields ) > 1 ) {
        } else {
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
            
            
            if ( isset( $s['simple_list_show_zip_code'] ) ) {
                $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
                $html .= ContactListHelpers::getText( 'zip_code_title', __( 'ZIP Code', 'contact-list' ) );
                $html .= '</span></div>';
            }
            
            
            if ( !isset( $s['simple_list_hide_some_links'] ) ) {
                $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-some contact-list-simple-list-col-title"><span>';
                $html .= sanitize_text_field( __( 'Social media', 'contact-list' ) );
                $html .= '</span></div>';
            }
            
            $custom_fields = [ 1 ];
            foreach ( $custom_fields as $n ) {
                
                if ( isset( $s['simple_list_show_custom_field_' . $n] ) ) {
                    $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-title"><span>';
                    $cf_field_title = ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? $s['custom_field_' . $n . '_title'] : '' );
                    $html .= sanitize_text_field( $cf_field_title );
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
        
        }
        
        $html .= '</div>';
        return $html;
    }
    
    public static function singleContactSimpleMarkup( $id, $showGroups = 0, $atts = array() )
    {
        $id = intval( $id );
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $html = '';
        $html .= '<div class="contact-list-simple-list-row contact-list-simple-list-row-data">';
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $contact_fullname = sanitize_text_field( $contact_fullname );
            $html .= '<div class="contact-list-hidden-name">' . (( isset( $c['_cl_first_name'] ) ? sanitize_text_field( $c['_cl_first_name'][0] ) . ' ' : '' )) . sanitize_text_field( $c['_cl_last_name'][0] ) . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $contact_fullname = sanitize_text_field( $contact_fullname );
            $html .= '<div class="contact-list-hidden-name">' . sanitize_text_field( $c['_cl_last_name'][0] ) . (( isset( $c['_cl_first_name'] ) ? ' ' . sanitize_text_field( $c['_cl_first_name'][0] ) : '' )) . '</div>';
        }
        
        $simple_list_fields = explode( ' ', 'full_name job_title email phone phone_2 phone_3 address_line_1 city zip_code some_icons custom_field_1 custom_field_2 custom_field_3 custom_field_4 custom_field_5 custom_field_6 category send_message' );
        $override = 0;
        if ( sizeof( $simple_list_fields ) > 0 ) {
            foreach ( $simple_list_fields as $f ) {
                $f = sanitize_title( $f );
                $field_name = $f;
                $field_name_db = '_cl_' . $f;
                switch ( $field_name ) {
                    case 'full_name':
                        $simple_list_modal = 0;
                        
                        if ( !$simple_list_modal ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-name contact-list-simple-list-col-' . $field_name . '"><span>';
                            $html .= sanitize_text_field( $contact_fullname );
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'job_title':
                        $show_data = 1;
                        if ( isset( $s['simple_list_hide_job_title'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            if ( isset( $c[$field_name_db] ) ) {
                                $html .= sanitize_text_field( $c[$field_name_db][0] );
                            }
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'phone':
                        $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                        $show_data = 1;
                        if ( isset( $s['simple_list_hide_phone_1'] ) ) {
                            $show_data = 0;
                        }
                        if ( $override || $show_data ) {
                            
                            if ( isset( $c['_cl_phone'] ) ) {
                                $phone_org = sanitize_text_field( $c['_cl_phone'][0] );
                                $phone_href = preg_replace( '/[^0-9\\,]/', '', $phone_org );
                                
                                if ( isset( $s['simple_list_call_button'] ) ) {
                                    $call_title = sanitize_text_field( __( 'Call', 'contact-list' ) );
                                    if ( isset( $s['simple_list_call_button_title'] ) ) {
                                        $call_title = sanitize_text_field( $s['simple_list_call_button_title'] );
                                    }
                                    $html .= '<a href="tel:' . $phone_href . '" class="contact-list-simple-list-call-button">' . $call_title . '</a>';
                                } else {
                                    $html .= '<a href="tel:' . $phone_href . '">' . $phone_org . '</a>';
                                }
                            
                            }
                        
                        }
                        $html .= '</span></div>';
                        break;
                    case 'phone_2':
                        break;
                    case 'phone_3':
                        break;
                    case 'email':
                        $show_data = 1;
                        if ( isset( $s['simple_list_hide_email'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            
                            if ( isset( $c['_cl_email'][0] ) ) {
                                $mailto = sanitize_email( $c['_cl_email'][0] );
                                $mailto_obs = antispambot( $mailto );
                                if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
                                    $html .= ( $c['_cl_email'][0] ? '<a href="mailto:' . sanitize_text_field( $mailto_obs ) . '">' . sanitize_text_field( $mailto_obs ) . '</a>' : '' );
                                }
                            }
                            
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'some_icons':
                        $show_data = 1;
                        if ( isset( $s['simple_list_hide_some_links'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-some contact-list-simple-list-col-' . $field_name . '"><span>';
                            $html .= '<div class="contact-list-simple-list-some-icons-container">';
                            $html .= '<div class="contact-list-simple-list-some-icons">';
                            if ( isset( $c['_cl_facebook_url'] ) ) {
                                $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_facebook_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/facebook.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( 'Facebook', 'contact-list' ) . '" /></a>' : '' );
                            }
                            if ( isset( $c['_cl_instagram_url'] ) ) {
                                $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_instagram_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/instagram.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( 'Instagram', 'contact-list' ) . '" /></a>' : '' );
                            }
                            if ( isset( $c['_cl_twitter_url'] ) ) {
                                $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_twitter_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/twitter.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( 'Twitter', 'contact-list' ) . '" /></a>' : '' );
                            }
                            if ( isset( $c['_cl_linkedin_url'] ) ) {
                                $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_linkedin_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/linkedin.svg', __FILE__ ) ) . '" alt="' . ContactListHelpers::sanitize_attr_value( 'LinkedIn', 'contact-list' ) . '" /></a>' : '' );
                            }
                            $html .= '</div>';
                            $html .= '</div>';
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'city':
                        $show_data = 1;
                        if ( !isset( $s['simple_list_show_city'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            if ( isset( $c['_cl_city'] ) ) {
                                $html .= sanitize_text_field( $c['_cl_city'][0] );
                            }
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'zip_code':
                        $show_data = 1;
                        if ( !isset( $s['simple_list_show_zip_code'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            if ( isset( $c['_cl_zip_code'] ) ) {
                                $html .= sanitize_text_field( $c['_cl_zip_code'][0] );
                            }
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'address_line_1':
                        $show_data = 1;
                        if ( !isset( $s['simple_list_show_address_line_1'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            if ( isset( $c['_cl_address_line_1'] ) ) {
                                $html .= sanitize_text_field( $c['_cl_address_line_1'][0] );
                            }
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'custom_field_1':
                        $show_data = 1;
                        if ( !isset( $s['simple_list_show_custom_field_1'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            $html .= ContactListPublicHelpers::singleContactSimpleCustomFieldMarkup( 1, $c );
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'custom_field_2':
                        break;
                    case 'custom_field_3':
                        break;
                    case 'custom_field_4':
                        break;
                    case 'custom_field_5':
                        break;
                    case 'custom_field_6':
                        break;
                    case 'category':
                        $show_data = 1;
                        if ( !isset( $s['simple_list_show_category'] ) ) {
                            $show_data = 0;
                        }
                        
                        if ( $override || $show_data ) {
                            $terms = get_the_terms( $id, 'contact-group' );
                            $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                            
                            if ( $terms ) {
                                $html .= '<div class="contact-list-simple-contact-groups">';
                                foreach ( $terms as $term ) {
                                    $t_id = intval( $term->term_id );
                                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                                    if ( !isset( $custom_fields['hide_group'] ) ) {
                                        $html .= '<span>' . sanitize_text_field( $term->name ) . '</span>';
                                    }
                                }
                                $html .= '</div>';
                            }
                            
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'send_message':
                        $show_data = 1;
                        
                        if ( !isset( $s['simple_list_show_send_message'] ) ) {
                            $show_data = 0;
                        } elseif ( isset( $s['hide_send_email_button'] ) ) {
                            $show_data = 0;
                        }
                        
                        
                        if ( $override || $show_data ) {
                            $html .= '<div class="contact-list-simple-list-col cl-align-right contact-list-simple-list-col-' . $field_name . '"><span>';
                            if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) || isset( $c['_cl_notify_emails'] ) && $c['_cl_notify_emails'] ) {
                                $html .= '<span class="contact-list-send-email contact-list-simple-send-email cl-dont-print"><a href="" data-id="' . ContactListHelpers::sanitize_attr_value( $id ) . '" data-name="' . ContactListHelpers::sanitize_attr_value( $contact_fullname ) . '">' . ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) . ' &raquo;</a></span>';
                            }
                            $html .= '</span></div>';
                        }
                        
                        break;
                    case 'description':
                        $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                        if ( isset( $c[$field_name_db] ) ) {
                            $html .= wp_kses_post( $c[$field_name_db][0] );
                        }
                        $html .= '</span></div>';
                    default:
                        $html .= '<div class="contact-list-simple-list-col contact-list-simple-list-col-' . $field_name . '"><span>';
                        if ( isset( $c[$field_name_db] ) ) {
                            $html .= sanitize_text_field( $c[$field_name_db][0] );
                        }
                        $html .= '</span></div>';
                }
            }
        }
        $html .= '</div>';
        return $html;
    }
    
    public static function singleContactSimpleCustomFieldMarkup( $n, $c )
    {
        $html = '';
        
        if ( isset( $c['_cl_custom_field_' . $n] ) ) {
            $s = get_option( 'contact_list_settings' );
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
            $cf_value = sanitize_text_field( $c['_cl_custom_field_' . $n][0] );
            
            if ( is_email( $cf_value ) ) {
                $mailto = $cf_value;
                $mailto_obs = antispambot( $mailto );
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
            
            
            if ( isset( $s['custom_field_' . $n . '_icon'] ) && $s['custom_field_' . $n . '_icon'] && $cf_value ) {
                $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                $html .= '<i class="fa ' . sanitize_html_class( $s['custom_field_' . $n . '_icon'] ) . '" aria-hidden="true"></i><span>' . balanceTags( wp_kses_post( $cf_value ) ) . '</span>';
                $html .= '</div>';
            } else {
                $html .= '<div class="contact-list-custom-field-simple-list contact-list-custom-field-' . $n . '">';
                $html .= balanceTags( wp_kses_post( $cf_value ) );
                $html .= '</div>';
            }
        
        }
        
        return $html;
    }

}