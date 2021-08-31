<?php

class ContactListAdminSendEmail
{
    public function register_send_email_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_LIST_CPT,
            sanitize_text_field( __( 'Send email to contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Send email', 'contact-list' ) ),
            'manage_options',
            'contact-list-send-email',
            [ $this, 'register_send_email_page_callback' ]
        );
    }
    
    public function register_send_email_page_callback()
    {
        $is_premium = 0;
        ?>

    <?php 
        
        if ( !$is_premium ) {
            ?>
      <?php 
            echo  ContactListHelpers::proFeatureMarkup() ;
            ?>
    <?php 
        }
        
        ?>
    
    <?php 
    }

}