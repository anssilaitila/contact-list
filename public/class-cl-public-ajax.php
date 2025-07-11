<?php

class ContactListPublicAjax {
    public function search_log() {
        $s = get_option( 'contact_list_settings' );
        if ( isset( $s['enable_search_log'] ) ) {
            $search_term = '';
            $user_ip = '';
            $post_id = 0;
            $permalink = '';
            $user_agent = '';
            $referer_url = '';
            $min_chars = 3;
            if ( isset( $s['esl_search_term_min_chars'] ) && $s['esl_search_term_min_chars'] ) {
                $min_chars = intval( $s['esl_search_term_min_chars'] );
            }
            if ( isset( $s['esl_search_term'] ) ) {
                if ( isset( $_POST['search'] ) && $_POST['search'] ) {
                    $search_term = sanitize_text_field( $_POST['search'] );
                }
            }
            if ( strlen( $search_term ) >= $min_chars ) {
                if ( isset( $s['esl_user_agent'] ) ) {
                    if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
                        $user_agent = sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] );
                    }
                }
                $user_country = '';
                $user_city = '';
                $user_country = '';
                $user_city = '';
                global $wpdb;
                $wpdb->insert( $wpdb->prefix . 'contact_list_search_log', array(
                    'user_ip'      => $user_ip,
                    'user_country' => $user_country,
                    'user_city'    => $user_city,
                    'post_id'      => $post_id,
                    'permalink'    => $permalink,
                    'search'       => $search_term,
                    'user_agent'   => $user_agent,
                    'referer_url'  => $referer_url,
                ) );
                $inserted_id = $wpdb->insert_id;
            }
        }
        echo '';
    }

    public function cl_get_contacts() {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $atts = [];
        $post_params_active = 0;
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
        if ( CONTACT_LIST_ORDER_BY != '_cl_last_name' && !isset( $atts['order_by'] ) ) {
            $meta_query[] = array(
                'custom_clause' => array(
                    'key'     => CONTACT_LIST_ORDER_BY,
                    'compare' => 'EXISTS',
                ),
            );
            $order_by = array(
                'menu_order'    => 'ASC',
                'custom_clause' => 'ASC',
                'title'         => 'ASC',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT1] ) && $_POST[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT1] ),
                'compare' => '=',
            );
            $post_params_active = 1;
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT2] ),
                'compare' => '=',
            );
            $post_params_active = 1;
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT3] ),
                'compare' => '=',
            );
            $post_params_active = 1;
        }
        $atts_group = '';
        if ( isset( $atts['group'] ) && $atts['group'] ) {
            $atts_group = sanitize_title( $atts['group'] );
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
            $post_params_active = 1;
        } elseif ( $atts_group ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'contact-group',
                    'field'    => 'slug',
                    'terms'    => $atts_group,
                ),
            );
        }
        $posts_per_page = -1;
        $wp_query_args = array(
            'post_type'      => CONTACT_LIST_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        );
        $wp_query = new WP_Query($wp_query_args);
        if ( $wp_query->have_posts() ) {
            $html .= ContactListPublicHelpersDefault::contactListMarkup(
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
        echo wp_kses_post( $html );
    }

    public function cl_get_contacts_simple() {
        $s = get_option( 'contact_list_settings' );
        $html = '';
        $atts = [];
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
                'compare' => '=',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT2] ),
                'compare' => '=',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => sanitize_text_field( $_POST[CONTACT_LIST_CAT3] ),
                'compare' => '=',
            );
        }
        $search_for = '';
        $atts_group = '';
        if ( isset( $atts['group'] ) && $atts['group'] ) {
            $atts_group = sanitize_title( $atts['group'] );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $include_children = 1;
            $tax_query = array(
                'relation' => 'AND',
                array(
                    'taxonomy'         => 'contact-group',
                    'field'            => 'slug',
                    'terms'            => sanitize_title( $_POST['cl_cat'] ),
                    'include_children' => $include_children,
                ),
            );
        } elseif ( $atts_group ) {
            $include_children = 1;
            $tax_query = array(
                'relation' => 'AND',
                array(
                    'taxonomy'         => 'contact-group',
                    'field'            => 'slug',
                    'terms'            => $atts_group,
                    'include_children' => $include_children,
                ),
            );
        }
        $posts_per_page = 100;
        $wp_query = new WP_Query(array(
            'post_type'      => CONTACT_LIST_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ));
        if ( $wp_query->have_posts() ) {
            $html .= ContactListPublicHelpersSimple::contactListSimpleMarkup( $wp_query, 0, $atts );
            $html .= '<hr class="clear" />';
        }
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        $html_allowed_tags = [
            'div'      => [
                'class' => [],
            ],
            'span'     => [
                'class' => [],
            ],
            'a'        => [
                'href'            => [],
                'class'           => [],
                'data-contact-id' => [],
                'target'          => [],
                'data-id'         => [],
                'data-name'       => [],
            ],
            'hr'       => [
                'class' => [],
            ],
            'img'      => [
                'src' => [],
                'alt' => [],
            ],
            'i'        => [
                'class'       => [],
                'aria-hidden' => [],
            ],
            'textarea' => [
                'class' => [],
            ],
        ];
        echo wp_kses( $html, $html_allowed_tags );
    }

}
