<?php

class ContactListAdminInlineScripts {
    public static function inline_scripts( $context = '' ) {
        $current_screen = get_current_screen();
        $current_screen_id = '';
        if ( isset( $current_screen->id ) ) {
            $current_screen_id = $current_screen->id;
        }
        $js = '';
        if ( $context == 'mail-log' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.contact-list-empty-mail-log-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the mail log?', 'contact-list' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'contact-list' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $context == 'search-log' ) {
            $js .= "jQuery( document ).ready( function(\$) {\n\n        \$('.contact-list-empty-search-log-form').submit(function() {\n\n          return confirm('" . esc_js( __( 'Are you sure that you want to empty the search log?', 'contact-list' ) ) . ' ' . esc_js( __( 'This action is irreversible.', 'contact-list' ) ) . "');\n\n        });\n\n      });";
        } elseif ( $current_screen_id === 'edit-contact' || $current_screen_id === 'edit-contact-group' ) {
            $is_premium = 0;
            $js .= "jQuery( document ).ready( function(\$) {";
            if ( !$is_premium ) {
                if ( $current_screen_id === 'edit-contact' ) {
                    $url = 'https://wordpress.org/support/plugin/contact-list/';
                    $support_html = sprintf( wp_kses( 
                        /* translators: %s: link to the support forum */
                        __( 'If you have any questions in mind, please contact the author at <a href="%s" target="_blank">the support forum</a>. The forum is actively monitored and any kind of feedback is welcome.', 'contact-list' ),
                        array(
                            'a' => array(
                                'href'   => array(),
                                'target' => array(),
                            ),
                        )
                     ), esc_url( $url ) );
                    $js .= "\n            \$('.post-type-contact .page-title-action').after(function() {\n\n              return '<div class=\"contact-list-admin-support-box\">" . $support_html . "</div>';\n\n            });\n          ";
                }
                $js .= "\n          \$('.contact-list-copy-paid-only').tipso({\n            content: '" . esc_js( __( 'This feature is available in the Pro version.', 'contact-list' ) ) . "',\n            width: 280,\n            background: '#2271b1',\n          });\n        ";
                $js .= "\n          \$('.contact-list-request-update').tipso({\n            content: '" . esc_js( __( 'This feature is available in the Pro version.', 'contact-list' ) ) . "',\n            width: 280,\n            background: '#2271b1',\n          });\n        ";
                $js .= "\n          \$('.contact-list-request-update').on('click', function(e) {\n            e.preventDefault();\n            \$(this).prop( 'disabled', true );\n          });\n        ";
            }
            $js .= "});";
        }
        return $js;
    }

    public static function box_inline_scripts( $context = '' ) {
        $current_screen = get_current_screen();
        $current_screen_id = '';
        if ( isset( $current_screen->id ) ) {
            $current_screen_id = $current_screen->id;
        }
        $js = '';
        $is_premium = 0;
        $admin_pages = ContactListAdminToolbar::get_admin_pages();
        if ( !$is_premium && in_array( $current_screen_id, $admin_pages ) ) {
            if ( $current_screen_id == 'settings_page_contact-list' ) {
                $js = "\n        jQuery( document ).ready( function(\$) {\n          \$( '.contact-list-admin-pro-features' ).appendTo( '.contact-list-admin-page-content-container' ).css( 'display', 'block' );\n        });\n        ";
            } else {
                $js = "\n        jQuery( document ).ready( function(\$) {\n          \$( '.contact-list-admin-pro-features' ).appendTo( '#wpbody-content .wrap' ).css( 'display', 'block' );\n        });\n        ";
            }
        }
        return $js;
    }

    public static function contact_edit_scripts() {
        $js = '';
        $js .= "jQuery( document ).ready( function(\$) {\n      \$('#post').submit(function() {\n        if (\$('#_cl_last_name').val().length == 0) {\n          alert('" . esc_js( __( 'Please insert at least last name first.', 'contact-list' ) ) . "');\n          return false;\n        }\n      });\n    });";
        return $js;
    }

    public static function help_support_scripts() {
        $js = '';
        $js .= "jQuery( document ).ready( function(\$) {\n      \$('.contact-list-toggle-debug-info').on('click', function() {\n        if (\$('.contact-list-debug-info-container').is(':hidden')) {\n          \$('.contact-list-debug-info-container').show();\n          \$(this).text('" . esc_js( __( 'Close', 'contact-list' ) ) . "');\n        } else {\n          \$('.contact-list-debug-info-container').hide();\n          \$(this).text('" . esc_js( __( 'Open', 'contact-list' ) ) . "');\n        }\n      });\n    });";
        return $js;
    }

}
