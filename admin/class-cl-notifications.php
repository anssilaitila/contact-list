<?php

class ContactListNotifications
{
    public function notifications_html()
    {
        $cl_rating_show_notice = get_option( 'contact_list_rating_show_notice' );
        $cl_rating_notice_option = get_option( 'contact_list_rating_notice' );
        $cl_rating_notice_waiting = get_transient( 'contact_list_rating_notice_waiting' );
        $should_show_rating_notice = $cl_rating_show_notice && $cl_rating_notice_waiting !== 'waiting' && $cl_rating_notice_option !== 'dismissed';
        
        if ( $should_show_rating_notice && current_user_can( 'administrator' ) ) {
            $dismiss_url = add_query_arg( 'cl_ignore_rating_notice_notify', '1' );
            $later_url = add_query_arg( 'cl_ignore_rating_notice_notify', 'later' );
            echo  "\n        <div class='cl_notice cl_review_notice'>\n          <img src='" . esc_url( CONTACT_LIST_URI ) . 'img/cl-sunrise.jpg' . "' alt='" . esc_html__( 'Contact List', 'contact-list' ) . "'>\n          <div class='contact-list-notice-text'>\n            <p style='padding-top: 4px;'>" . sprintf( __( "It's great to see that you've been using the %sContact List%s plugin for a while now. Hopefully you're happy with it!&nbsp; If so, would you consider leaving a positive review? It really helps to support the plugin and helps others to discover it too!" ), '<strong style=\'font-weight: 700;\'>', '</strong>' ) . "</p>\n            <p class='links'>\n              <a class='cl_notice_dismiss' href='https://wordpress.org/support/plugin/contact-list/reviews/#new-post' target='_blank'>" . esc_html__( 'Sure, I\'d love to!', 'contact-list' ) . "</a>\n              &middot;\n              <a class='cl_notice_dismiss' href='" . esc_url( $dismiss_url ) . "'>" . esc_html__( 'No thanks', 'contact-list' ) . "</a>\n              &middot;\n              <a class='cl_notice_dismiss' href='" . esc_url( $dismiss_url ) . "'>" . esc_html__( 'I\'ve already given a review', 'contact-list' ) . "</a>\n              &middot;\n              <a class='cl_notice_dismiss' href='" . esc_url( $later_url ) . "'>" . esc_html__( 'Ask Me Later', 'contact-list' ) . "</a>\n            </p>\n          </div>\n          <a class='cl_notice_close' href='" . esc_url( $dismiss_url ) . "'>x</a>\n        </div>" ;
        }
        
        $screen = get_current_screen();
        
        if ( isset( $screen->id ) && $screen->id == 'edit-contact' ) {
            $how_to_show_notice = get_option( 'contact_list_how_to_show_notice' );
            
            if ( $how_to_show_notice ) {
                $dismiss_how_to_url = add_query_arg( 'contact_list_ignore_how_to_notify', '1' );
                echo  '<div class="contact-list-notice-how-to-get-started">' ;
                echo  '<div class="contact-list-notice-how-to-get-started-title">' ;
                echo  '<h2>' . esc_html__( 'How to get started', 'contact-list' ) . '</h2>' ;
                echo  "<a class='contact-list-notice-how-to-get-dismiss' href='" . esc_url( $dismiss_how_to_url ) . "'>&#10005;</a>" ;
                echo  '</div>' ;
                echo  '<div class="contact-list-notice-how-to-get-started-content">' ;
                echo  '<ol>' ;
                echo  '<li>' . esc_html__( 'Add some contacts from the contact management below (click the Add New button)', 'contact-list' ) . '</li>' ;
                echo  '<li>' ;
                echo  esc_html__( 'Insert one of these shortcodes to any page or post on your site', 'contact-list' ) ;
                echo  '<ul>' ;
                echo  '<li>' ;
                echo  '<h3>' . esc_html__( 'List of all contacts', 'contact-list' ) . '</h3>' ;
                echo  '<span class="contact-list-shortcode-admin-list contact-list-shortcode-admin-list-file contact-list-shortcode-info-1" title="[contact_list]">[contact_list]</span>' ;
                echo  '<button class="contact-list-copy contact-list-copy-for-all contact-list-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-info-1">' . esc_html__( 'Copy', 'contact-list' ) . '</button>' ;
                echo  '</li>' ;
                echo  '<li>' ;
                echo  '<h3>' . esc_html__( 'List of all contacts, simpler view', 'contact-list' ) . '</h3>' ;
                echo  '<span class="contact-list-shortcode-admin-list contact-list-shortcode-admin-list-file contact-list-shortcode-info-2" title="[contact_list_simple]">[contact_list_simple]</span>' ;
                echo  '<button class="contact-list-copy contact-list-copy-for-all contact-list-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-info-2">' . esc_html__( 'Copy', 'contact-list' ) . '</button>' ;
                echo  '</li>' ;
                echo  '</ul>' ;
                echo  '</li>' ;
                echo  '<li>' ;
                $url = esc_url_raw( get_admin_url() . 'options-general.php?page=contact-list' );
                echo  sprintf( wp_kses(
                    /* translators: %s: link to the plugin settings */
                    __( 'Check the <a href="%s">plugin settings</a> for some customization options', 'contact-list' ),
                    array(
                        'a' => array(
                        'href'   => array(),
                        'target' => array(),
                    ),
                    )
                ), esc_url( $url ) ) ;
                echo  '</li>' ;
                echo  '<li>' ;
                $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=contact&page=contact-list-shortcodes' );
                echo  sprintf( wp_kses(
                    /* translators: %s: link to the shortcodes page */
                    __( 'List of all available shortcodes <a href="%s">here</a>', 'contact-list' ),
                    array(
                        'a' => array(
                        'href'   => array(),
                        'target' => array(),
                    ),
                    )
                ), esc_url( $url ) ) ;
                echo  '</li>' ;
                echo  '</ol>' ;
                echo  '</div>' ;
                echo  '</div>' ;
            }
        
        }
    
    }
    
    public function process_notifications()
    {
        global  $current_user ;
        $user_id = intval( $current_user->ID );
        $cl_statuses_option = get_option( 'cl_statuses', array() );
        // Rating notice
        /*
        
            if (!get_option('contact_list_rating_notice_date')) {
        
              $dt = new DateTime('+8 weeks');
        
              if ($dt !== false && !array_sum($dt::getLastErrors())) {
                $notify_date = $dt;
                update_option('contact_list_rating_notice_date', $notify_date, false);
              }
        
            } else {
        
              $notify_date = get_option('contact_list_rating_notice_date');
        
              if ($notify_date instanceof DateTime) {
                $dt_now = new DateTime('now');
                
                if ($notify_date <= $dt_now) {
                  update_option('contact_list_rating_show_notice', 1, false);
                }
        
              }
              
            }
        */
        
        if ( isset( $_GET['cl_ignore_rating_notice_notify'] ) ) {
            
            if ( (int) $_GET['cl_ignore_rating_notice_notify'] === 1 ) {
                update_option( 'contact_list_rating_notice', 'dismissed', false );
                $cl_statuses_option['rating_notice_dismissed'] = $this->cl_get_current_time();
                update_option( 'cl_statuses', $cl_statuses_option, false );
            } elseif ( $_GET['cl_ignore_rating_notice_notify'] === 'later' ) {
                set_transient( 'contact_list_rating_notice_waiting', 'waiting', 2 * WEEK_IN_SECONDS );
                update_option( 'contact_list_rating_notice', 'pending', false );
            }
        
        } elseif ( isset( $_GET['contact_list_ignore_how_to_notify'] ) ) {
            update_option( 'contact_list_how_to_show_notice', 0, false );
        }
    
    }
    
    public function cl_get_current_time()
    {
        $current_time = time();
        return $current_time;
    }

}