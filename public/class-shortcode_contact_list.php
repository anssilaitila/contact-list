<?php

class ShortcodeContactList
{
    public static function shortcodeContactListMarkup( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $layout = '';
        
        if ( isset( $atts['layout'] ) ) {
            $layout = $atts['layout'];
        } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
            $layout = $s['layout'];
        }
        
        $layout = '';
        // 2-cards-on-the-same-row
        // 3-cards-on-the-same-row
        // 4-cards-on-the-same-row
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
                $html .= '<style>.contact-list-contact-container { border: 1px solid #333; } </style>';
            } elseif ( $s['card_border'] == 'gray' ) {
                $html .= '<style>.contact-list-contact-container { border: 1px solid #bbb; } </style>';
            }
        
        }
        
        if ( isset( $s['card_height'] ) && $s['card_height'] ) {
            $html .= '<style>.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
        }
        
        if ( cl_fs()->is__premium_only() && !isset( $s['hide_send_email_button'] ) ) {
            $html .= ContactListHelpers::modalSendMessageMarkup();
        }
        $html .= '<div class="contact-list-container ' . (( $layout ? 'contact-list-' . $layout : '' )) . '">';
        
        if ( isset( $atts['contact'] ) ) {
            $contact = (int) $atts['contact'];
            
            if ( $contact ) {
                $html .= '<div id="contact-list-search">';
                $html .= '<ul id="all-contacts">';
                $wpb_all_query = new WP_Query( array(
                    'post_type'      => 'contact',
                    'post_status'    => 'publish',
                    'posts_per_page' => 1,
                    'p'              => $contact,
                ) );
                
                if ( $wpb_all_query->have_posts() ) {
                    while ( $wpb_all_query->have_posts() ) {
                        $wpb_all_query->the_post();
                        $id = get_the_id();
                        $html .= ContactListHelpers::singleContactMarkup( $id );
                    }
                } else {
                    $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __( 'Contact not found' ) . ' (ID: ' . $contact . ')</p>';
                }
                
                $html .= '</ul>';
                $html .= '</div>';
            } else {
                $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __( 'Contact not found' ) . ' (ID: ' . $contact . ')</p>';
            }
        
        } else {
            $html .= '<div class="contact-list-text-contact" style="display: none;">' . __( 'contact', 'contact-list' ) . '</div>';
            $html .= '<div class="contact-list-text-contacts" style="display: none;">' . __( 'contacts', 'contact-list' ) . '</div>';
            $html .= '<div class="contact-list-text-found" style="display: none;">' . __( 'found', 'contact-list' ) . '</div>';
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
            
            if ( isset( $_GET['cl_country'] ) && $_GET['cl_country'] ) {
                $meta_query[] = array(
                    'key'     => '_cl_country',
                    'value'   => $_GET['cl_country'],
                    'compare' => 'LIKE',
                );
            }
            if ( isset( $_GET['cl_state'] ) && $_GET['cl_state'] ) {
                $meta_query[] = array(
                    'key'     => '_cl_state',
                    'value'   => $_GET['cl_state'],
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
            }
            $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
            $posts_per_page = 40;
            if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
                $posts_per_page = $s['contacts_per_page'];
            }
            $wp_query = new WP_Query( array(
                'post_type'      => 'contact',
                'post_status'    => 'publish',
                'posts_per_page' => (int) $posts_per_page,
                'paged'          => $paged,
                'meta_query'     => $meta_query,
                'tax_query'      => $tax_query,
                'orderby'        => $order_by,
            ) );
            $wp_query_for_filter = new WP_Query( array(
                'post_type'      => 'contact',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
            ) );
            
            if ( $wp_query->have_posts() ) {
                $html .= ContactListHelpers::contactListMarkup( $wp_query );
                $pagination_args = array(
                    'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                    'total'        => $wp_query->max_num_pages,
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'format'       => '?paged=%#%',
                    'show_all'     => true,
                    'type'         => 'plain',
                    'prev_next'    => false,
                    'add_args'     => false,
                    'add_fragment' => '',
                );
                $html .= '<hr class="clear" />';
                $html .= '<div class="contact-list-pagination">';
                if ( paginate_links( $pagination_args ) ) {
                    $html .= '<span class="contact-list-more-contacts">' . __( 'More contacts:', 'contact-list' ) . '</span>' . paginate_links( $pagination_args );
                }
            }
            
            if ( $wp_query->found_posts == 0 ) {
                $html .= '<p>' . __( 'No contacts found.' ) . '</p>';
            }
        }
        
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}