<?php

class ShortcodeContactListSearch
{
    public static function view( $atts )
    {
        $s = get_option( 'contact_list_settings' );
        $layout = '';
        
        if ( isset( $atts['layout'] ) ) {
            $layout = $atts['layout'];
        } elseif ( isset( $s['layout'] ) && $s['layout'] ) {
            $layout = $s['layout'];
        }
        
        $layout = '';
        $html = '';
        return $html;
        $html = '';
        $html .= ContactListHelpers::initLayout( $s );
        if ( cl_fs()->is__premium_only() && !isset( $s['hide_send_email_button'] ) ) {
            $html .= ContactListHelpers::modalSendMessageMarkup();
        }
        $html .= '<div class="contact-list-container ' . (( $layout ? 'contact-list-' . $layout : '' )) . '">';
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
        
        $wp_query = new WP_Query( array(
            'post_type'      => 'contact',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => $meta_query,
            'orderby'        => $order_by,
        ) );
        $html .= '<input type="text" class="search-all-contacts" placeholder="' . (( isset( $s['search_all_contacts'] ) && $s['search_all_contacts'] ? $s['search_all_contacts'] : __( 'Search all contacts...', 'contact-list' ) )) . '">';
        $html .= '<div class="contact-list-all-contacts-contacts-found"></div>';
        $html .= '<div class="contact-list-all-contacts-nothing-found">' . __( 'No contacts found.', 'contact-list' ) . '</div>';
        $html .= '<div class="contact-list-all-contacts-search">';
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListHelpers::listAllContactsForSearchMarkup( $wp_query );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . __( 'No contacts found.' ) . '</p>';
        }
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }

}