<?php

class ShortcodeContactList
{
    public static function shortcodeContactListMarkup( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $layout = ContactListHelpers::getLayout( $s, $atts );
        $elem_class = ContactListHelpers::createElemClass();
        $exclude = [];
        $group_slug = '';
        $html = '';
        $html .= ContactListHelpers::initLayout( $s, $atts, $elem_class );
        if ( !isset( $s['hide_send_email_button'] ) ) {
            $html .= ContactListHelpers::modalSendMessageMarkup();
        }
        $html .= '<div class="contact-list-container ' . $elem_class . ' ' . (( $layout ? 'contact-list-' . $layout : '' )) . '">';
        
        if ( isset( $atts['contact'] ) || isset( $_GET['contact_id'] ) ) {
            
            if ( ContactListHelpers::isPremium() == 0 ) {
                $html = ContactListPublicHelpers::proFeaturePublicMarkup();
                return $html;
            }
            
            $contact = ( isset( $atts['contact'] ) ? (int) $atts['contact'] : (int) $_GET['contact_id'] );
            
            if ( $contact ) {
                $html .= '<div id="contact-list-search">';
                $html .= '<ul id="all-contacts">';
                $wpb_all_query = new WP_Query( array(
                    'post_type'      => CONTACT_CPT,
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
                    $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __( 'Contact not found', 'contact-list' ) . ' (ID: ' . $contact . ')</p>';
                }
                
                $html .= '</ul>';
                $html .= '</div><hr class="clear" />';
            } else {
                $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __( 'Contact not found', 'contact-list' ) . ' (ID: ' . $contact . ')</p>';
            }
        
        } else {
            $html .= '<div class="contact-list-text-contact" style="display: none;">' . ContactListHelpers::getText( 'text_sr_contact', __( 'contact', 'contact-list' ) ) . '</div>';
            $html .= '<div class="contact-list-text-contacts" style="display: none;">' . ContactListHelpers::getText( 'text_sr_contacts', __( 'contacts', 'contact-list' ) ) . '</div>';
            $html .= '<div class="contact-list-text-found" style="display: none;">' . ContactListHelpers::getText( 'text_sr_found', __( 'found', 'contact-list' ) ) . '</div>';
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
            
            if ( ORDER_BY == '_cl_first_name' && !isset( $atts['order_by'] ) || isset( $atts['order_by'] ) && $atts['order_by'] == 'first_name' ) {
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
            } elseif ( $group_slug ) {
            }
            
            $paged = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
            $posts_per_page = -1;
            if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
                $posts_per_page = $s['contacts_per_page'];
            }
            $wp_query = new WP_Query( array(
                'post_type'      => 'contact',
                'post_status'    => 'publish',
                'posts_per_page' => (int) $posts_per_page,
                'paged'          => $paged,
                'post__not_in'   => $exclude,
                'meta_query'     => $meta_query,
                'tax_query'      => $tax_query,
                'orderby'        => $order_by,
            ) );
            $wp_query_for_filter = new WP_Query( array(
                'post_type'      => 'contact',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'post__not_in'   => $exclude,
                'meta_query'     => $meta_query,
                'tax_query'      => $tax_query,
                'orderby'        => $order_by,
            ) );
            if ( !isset( $atts['hide_search'] ) ) {
                $html .= '<input type="text" id="search-contacts" placeholder="' . (( isset( $s['search_contacts'] ) && $s['search_contacts'] ? $s['search_contacts'] : __( 'Search contacts...', 'contact-list' ) )) . '">';
            }
            if ( !isset( $atts['hide_filters'] ) ) {
                $html .= ContactListPublicHelpers::searchFormMarkup( $atts, $s, $exclude );
            }
            //      $html .= '<div id="contact-list-contacts-found"></div>';
            
            if ( $wp_query_for_filter->have_posts() ) {
                $html .= '<div class="contact-list-basic-nothing-found">';
                $html .= ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) );
                $html .= '</div>';
                $html .= '<div class="contact-list-basic-all-contacts-container">';
                $html .= '<div class="contact-list-basic-contacts-found"></div>';
                $html .= ContactListHelpers::contactListMarkup(
                    $wp_query_for_filter,
                    0,
                    $atts,
                    1
                );
                $html .= '</div>';
            }
            
            
            if ( $wp_query->have_posts() ) {
                $html .= '<div class="contact-list-ajax-results">';
                $html .= ContactListHelpers::contactListMarkup(
                    $wp_query,
                    0,
                    $atts,
                    0
                );
                $html .= '</div>';
                $html .= '<hr class="clear" />';
                $html .= ContactListPublicPagination::getPagination( 1, $wp_query, 'default' );
            }
            
            if ( $wp_query->found_posts == 0 ) {
                $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
            }
        }
        
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}