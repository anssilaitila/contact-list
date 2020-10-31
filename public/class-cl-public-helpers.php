<?php

class ContactListPublicHelpers
{
    public static function searchFormMarkup( $atts, $s )
    {
        $html = '';
        $filter_active = 0;
        $wp_query_for_filter = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ) );
        $html .= '<form method="get" action="./" class="contact-list-ajax-form">';
        
        if ( isset( $s['show_country_select_in_search'] ) && $s['show_country_select_in_search'] ) {
            $countries = [];
            while ( $wp_query_for_filter->have_posts() ) {
                $wp_query_for_filter->the_post();
                $c = get_post_custom();
                if ( isset( $c['_cl_country'] ) && $c['_cl_country'] && !in_array( $c['_cl_country'][0], $countries ) ) {
                    $countries[] = $c['_cl_country'][0];
                }
            }
            sort( $countries );
            $html .= '<select name="cl_country" class="select_v2">';
            $html .= '<option value="">' . __( 'Select country', 'contact-list' ) . '</option>';
            foreach ( $countries as $country ) {
                $html .= '<option value="' . $country . '" ' . (( isset( $_GET['cl_country'] ) && $_GET['cl_country'] == $country ? 'selected="selected"' : '' )) . '>' . $country . '</option>';
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
            sort( $states );
            $html .= '<select name="cl_state" class="select_v2">';
            $html .= '<option value="">' . __( 'Select state', 'contact-list' ) . '</option>';
            foreach ( $states as $state ) {
                $html .= '<option value="' . $state . '" ' . (( isset( $_GET['cl_state'] ) && $_GET['cl_state'] == $state ? 'selected="selected"' : '' )) . '>' . $state . '</option>';
            }
            $html .= '</select>';
            $filter_active = 1;
        }
        
        
        if ( isset( $s['show_category_select_in_search'] ) && $s['show_category_select_in_search'] ) {
            $groups = get_terms( array(
                'taxonomy'   => 'contact-group',
                'hide_empty' => true,
            ) );
            $html .= '<select name="cl_cat" class="select_v2">';
            $html .= '<option value="">' . __( 'Select category', 'contact-list' ) . '</option>';
            $atts_group = ( isset( $atts['group'] ) ? $atts['group'] : '' );
            $current_cat = ( isset( $_GET['cl_cat'] ) ? $_GET['cl_cat'] : $atts_group );
            foreach ( $groups as $g ) {
                $t_id = $g->term_id;
                $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                if ( !isset( $custom_fields['hide_group'] ) ) {
                    $html .= '<option value="' . $g->slug . '" ' . (( $current_cat == $g->slug ? 'selected="selected"' : '' )) . '>' . $g->name . '</option>';
                }
            }
            $html .= '</select>';
            $filter_active = 1;
        }
        
        if ( $filter_active ) {
            $html .= '<button type="submit" class="filter-contacts">' . __( 'Filter contacts', 'contact-list' ) . '</button>';
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
        $html .= __( 'No contacts found.', 'contact-list' );
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
        $html .= '<div class="contact-list-simple-list-col"><span>';
        
        if ( isset( $c['_cl_phone'] ) ) {
            $phone_href = preg_replace( '/[^0-9]/', '', $c['_cl_phone'][0] );
            $html .= '<a href="tel:' . $phone_href . '">' . $c['_cl_phone'][0] . '</a>';
        }
        
        $html .= '</span></div>';
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
        $html .= '</div>';
        return $html;
    }

}