<?php

class ContactListAdminInlineScripts {

  public static function inline_scripts($context) {

    $js = '';
    
    if ($context == 'mail-log') {

      $js .= "jQuery( document ).ready( function($) {
        
        $('.contact-list-empty-mail-log-form').submit(function() {

          return confirm('" . esc_js( __('Are you sure that you want to empty the mail log?', 'contact-list') ) . ' ' . esc_js( __('This action is irreversible.', 'contact-list') ) . "');

        });

      });";

    }

    return $js;

  }
  

  public static function contact_edit_scripts() {

    $js = '';

    $js .= "jQuery( document ).ready( function($) {
      $('#post').submit(function() {
        if ($('#_cl_last_name').val().length == 0) {
          alert('" . esc_js( __('Please insert at least last name first.', 'contact-list') ) . "');
          return false;
        }
      });
    });";
    
    return $js;

  }

  public static function help_support_scripts() {
  
    $js = '';
  
    $js .= "jQuery( document ).ready( function($) {
      $('.contact-list-toggle-debug-info').on('click', function() {
        if ($('.contact-list-debug-info-container').is(':hidden')) {
          $('.contact-list-debug-info-container').show();
          $(this).text('" . esc_js( __('Close', 'contact-list') ) . "');
        } else {
          $('.contact-list-debug-info-container').hide();
          $(this).text('" . esc_js( __('Open', 'contact-list') ) . "');
        }
      });
    });";
    
    return $js;
  
  }

}
