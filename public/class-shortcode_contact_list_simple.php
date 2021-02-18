<?php

class ShortcodeContactListSimple
{
    public static function view( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $exclude = [];
        $html = '';
        $html .= '<div class="contact-list-simple-container" />';
        $html .= '<div class="contact-list-simple-text-contact" style="display: none;">' . __( 'contact', 'contact-list' ) . '</div>';
        $html .= '<div class="contact-list-simple-text-contacts" style="display: none;">' . __( 'contacts', 'contact-list' ) . '</div>';
        $html .= '<div class="contact-list-simple-text-found" style="display: none;">' . __( 'found', 'contact-list' ) . '</div>';
        $meta_query = array(
            'relation' => 'AND',
        );
        $meta_query[] = array(
            'last_name_clause' => array(
            'key'     => '_cl_last_name',
            'compare' => 'EXISTS',
        ),
        );
        $order_by = array(
            'menu_order'       => 'ASC',
            'last_name_clause' => 'ASC',
            'title'            => 'ASC',
        );
        
        if ( ORDER_BY == '_cl_first_name' ) {
            $meta_query[] = array(
                'first_name_clause' => array(
                'key'     => '_cl_first_name',
                'compare' => 'EXISTS',
            ),
            );
            $order_by = array(
                'menu_order'        => 'ASC',
                'first_name_clause' => 'ASC',
                'title'             => 'ASC',
            );
        }
        
        if ( isset( $_GET[CONTACT_LIST_CAT1] ) && $_GET[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => $_GET[CONTACT_LIST_CAT1],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_GET[CONTACT_LIST_CAT2] ) && $_GET[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => $_GET[CONTACT_LIST_CAT2],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_GET[CONTACT_LIST_CAT3] ) && $_GET[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => $_GET[CONTACT_LIST_CAT3],
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        
        if ( isset( $_GET['cl_cat'] ) && $_GET['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => $_GET['cl_cat'],
            ),
            );
        } elseif ( isset( $atts['group'] ) && $atts['group'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => $atts['group'],
            ),
            );
        }
        
        $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
        $posts_per_page = -1;
        $wp_query = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged,
            'post__not_in'   => $exclude,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        if ( !isset( $atts['hide_search'] ) ) {
            $html .= '<input type="text" class="contact-list-simple-search-contacts" placeholder="' . (( isset( $s['search_contacts'] ) && $s['search_contacts'] ? $s['search_contacts'] : __( 'Search contacts...', 'contact-list' ) )) . '">';
        }
        $html .= '<div class="contact-list-simple-contacts-found"></div>';
        
        if ( $wp_query->have_posts() ) {
            $html .= '<div class="contact-list-simple-ajax-results">';
            $html .= ContactListPublicHelpers::contactListSimpleMarkup( $wp_query );
            $html .= '</div>';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}