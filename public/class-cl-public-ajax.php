<?php

class ContactListPublicAjax
{
    public function cl_get_contacts()
    {
        $html = '';
        $atts = [];
        if ( isset( $_POST['cl_atts'] ) && $_POST['cl_atts'] ) {
            $atts = sanitize_text_field( unserialize( stripslashes( $_POST['cl_atts'] ) ) );
        }
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
        
        if ( CONTACT_LIST_ORDER_BY == '_cl_first_name' ) {
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
        
        if ( isset( $_POST[CONTACT_LIST_CAT1] ) && $_POST[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT1] ),
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT2] ),
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT3] ),
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => sanitize_title( $_POST['cl_cat'] ),
            ),
            );
        }
        $posts_per_page = -1;
        if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
            $posts_per_page = intval( $s['contacts_per_page'] );
        }
        $wp_query = new WP_Query( array(
            'post_type'      => CONTACT_LIST_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListHelpers::contactListMarkup(
                $wp_query,
                0,
                $atts,
                0
            );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        $html_allowed_tags = [
            'div'  => [
            'id'    => [],
            'class' => [],
            'style' => [],
        ],
            'ul'   => [
            'id'    => [],
            'class' => [],
        ],
            'li'   => [
            'id'    => [],
            'class' => [],
        ],
            'span' => [
            'class' => [],
        ],
            'a'    => [
            'href'      => [],
            'data-id'   => [],
            'data-name' => [],
        ],
            'hr'   => [
            'class' => [],
        ],
            'img'  => [
            'src' => [],
            'alt' => [],
        ],
            'i'    => [
            'class'       => [],
            'aria-hidden' => [],
        ],
        ];
        echo  wp_kses( $html, $html_allowed_tags ) ;
    }
    
    public function cl_get_contacts_simple()
    {
        $html = '';
        $atts = [];
        if ( isset( $_POST['cl_atts'] ) && $_POST['cl_atts'] ) {
            $atts = sanitize_text_field( unserialize( stripslashes( $_POST['cl_atts'] ) ) );
        }
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
        
        if ( CONTACT_LIST_ORDER_BY == '_cl_first_name' ) {
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
        
        if ( isset( $_POST[CONTACT_LIST_CAT1] ) && $_POST[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT1] ),
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT2] ),
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT3] ),
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => sanitize_title( $_POST['cl_cat'] ),
            ),
            );
        }
        $posts_per_page = -1;
        if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
            $posts_per_page = intval( $s['contacts_per_page'] );
        }
        $wp_query = new WP_Query( array(
            'post_type'      => CONTACT_LIST_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListPublicHelpers::contactListSimpleMarkup( $wp_query, 0, $atts );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        $html_allowed_tags = [
            'div'  => [
            'class' => [],
        ],
            'span' => [
            'class' => [],
        ],
            'a'    => [
            'href'            => [],
            'class'           => [],
            'data-contact-id' => [],
        ],
            'hr'   => [
            'class' => [],
        ],
            'img'  => [
            'src' => [],
            'alt' => [],
        ],
            'i'    => [
            'class'       => [],
            'aria-hidden' => [],
        ],
        ];
        echo  wp_kses( $html, $html_allowed_tags ) ;
    }

}