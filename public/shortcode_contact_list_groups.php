<?php

function shortcodeContactListGroupsMarkup( $atts )
{
    $s = get_option( 'contact_list_settings' );
    $html = '';
    
    if ( isset( $s['card_background'] ) && $s['card_background'] ) {
        $html .= '<style>.contact-list-container #contact-list-search ul li { margin-bottom: 5px; } </style>';
        
        if ( $s['card_background'] == 'white' ) {
            $html .= '<style>.contact-list-contact-container { background: #fff; } </style>';
        } elseif ( $s['card_background'] == 'light_gray' ) {
            $html .= '<style>.contact-list-contact-container { background: #f7f7f7; } </style>';
        }
    
    }
    
    
    if ( isset( $s['card_height'] ) && $s['card_height'] ) {
        $html .= '<style>.contact-list-container.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
        $html .= '<style>.contact-list-container.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
        $html .= '<style>.contact-list-container.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
    }
    
    $html .= '<div class="contact-list-container">';
    $group_slug = ( isset( $_GET['g'] ) ? $_GET['g'] : '' );
    $include_children = isset( $s['show_contacts_from_subgroup'] ) && $s['show_contacts_from_subgroup'];
    $html .= '<div class="contact-list-text-contact" style="display: none;">' . __( 'contact', 'contact-list' ) . '</div>';
    $html .= '<div class="contact-list-text-contacts" style="display: none;">' . __( 'contacts', 'contact-list' ) . '</div>';
    $html .= '<div class="contact-list-text-found" style="display: none;">' . __( 'found', 'contact-list' ) . '</div>';
    if ( isset( $atts['group'] ) && !$group_slug ) {
        $group_slug = sanitize_title( $atts['group'] );
    }
    
    if ( $group_slug ) {
        if ( !isset( $atts['group'] ) ) {
            $html .= '<a href="javascript:history.back()">' . (( isset( $s['back_link_title'] ) && $s['back_link_title'] ? $s['back_link_title'] : __( '<< Back', 'contact-list' ) )) . '</a>';
        }
        $group = get_term_by( 'slug', $group_slug, 'contact-group' );
        
        if ( $group ) {
            $html .= '<h2 class="contact-list-group-title">' . $group->name . '</h2>';
            $html .= '<div class="contact-list-search-groups">';
            $subgroups = get_terms( array(
                'taxonomy'   => 'contact-group',
                'hide_empty' => false,
                'parent'     => $group->term_id,
            ) );
            
            if ( !$include_children && sizeof( $subgroups ) > 0 ) {
                $html .= '<div class="subgroups-list-container">';
                $html .= '<ul class="contact-list-groups">';
                foreach ( $subgroups as $sg ) {
                    $html .= '<li>';
                    $html .= '<div class="contact-list-searchable-elements">';
                    $html .= '<a href="?g=' . $sg->slug . '">' . $sg->name . '</a>';
                    $html .= '</div>';
                    $html .= '</li>';
                }
                $html .= '</ul>';
                $html .= '</div>';
            }
            
            $meta_query = array(
                'relation'         => 'AND',
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
                $meta_query = array(
                    'relation'          => 'AND',
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
            
            $wp_query = new WP_Query( array(
                'post_type'      => 'contact',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'meta_query'     => $meta_query,
                'tax_query'      => array( array(
                'taxonomy'         => 'contact-group',
                'field'            => 'slug',
                'terms'            => $group_slug,
                'include_children' => false,
            ) ),
                'orderby'        => $order_by,
            ) );
            if ( $wp_query->have_posts() ) {
                $html .= contactListMarkup( $wp_query, $include_children );
            }
            if ( $include_children && sizeof( $subgroups ) > 0 ) {
                foreach ( $subgroups as $sg ) {
                    $html .= '<h2 class="subgroup-title">' . $sg->name . '</h2>';
                    $wp_query = new WP_Query( array(
                        'post_type'      => 'contact',
                        'post_status'    => 'publish',
                        'posts_per_page' => -1,
                        'meta_query'     => $meta_query,
                        'tax_query'      => array( array(
                        'taxonomy'         => 'contact-group',
                        'field'            => 'slug',
                        'terms'            => $sg->slug,
                        'include_children' => false,
                    ) ),
                        'orderby'        => $order_by,
                    ) );
                    if ( $wp_query->have_posts() ) {
                        $html .= contactListMarkup( $wp_query, $include_children );
                    }
                }
            }
            if ( sizeof( $subgroups ) == 0 && !$wp_query->have_posts() ) {
                $html .= '<p>' . __( 'There are no contacts in this group.', 'contact-list' ) . '</p>';
            }
        } else {
            $html .= '<div style="border: 1px dashed #999; padding: 2rem; text-align: center; margin-top: 1rem;">' . __( 'Group not found', 'contact-list' ) . '</div>';
        }
        
        $html .= '</div>';
    } else {
        $html .= '<div class="contact-list-search-groups">';
        $groups = get_terms( array(
            'taxonomy'   => 'contact-group',
            'hide_empty' => false,
            'parent'     => 0,
        ) );
        
        if ( sizeof( $groups ) > 0 ) {
            $html .= '<ul class="contact-list-groups">';
            foreach ( $groups as $g ) {
                $html .= '<li>';
                $html .= '<div class="contact-list-searchable-elements">';
                $html .= '<a href="?g=' . $g->slug . '">' . $g->name . '</a>';
                $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        } else {
            $html .= __( 'There are no groups.', 'contact-list' );
        }
        
        $html .= '</div>';
    }
    
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}
