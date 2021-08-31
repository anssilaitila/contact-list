<?php

class ContactListImportExport
{
    public function register_import_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . esc_attr( CONTACT_LIST_CPT ),
            sanitize_text_field( __( 'Import contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Import contacts', 'contact-list' ) ),
            'manage_options',
            'contact-list-import',
            [ $this, 'register_import_page_callback' ]
        );
    }
    
    public function register_export_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . esc_attr( CONTACT_LIST_CPT ),
            sanitize_text_field( __( 'Export contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Export contacts', 'contact-list' ) ),
            'manage_options',
            'contact-list-export',
            [ $this, 'register_export_page_callback' ]
        );
    }
    
    public function register_import_page_callback()
    {
        ?>
    
    <div class="wrap">

        <h1><?php 
        echo  esc_html__( 'Import contacts', 'contact-list' ) ;
        ?></h1>

        <?php 
        ?>

        <?php 
        
        if ( ContactListHelpers::isPremium() == 0 ) {
            ?>
          <?php 
            echo  ContactListHelpers::proFeatureMarkup() ;
            ?>
        <?php 
        }
        
        ?>

    </div>
    <?php 
    }
    
    public function register_export_page_callback()
    {
        ?>
    
    <div class="wrap">

        <h1><?php 
        echo  esc_html__( 'Export contacts', 'contact-list' ) ;
        ?></h1>

        <?php 
        ?>

        <?php 
        
        if ( ContactListHelpers::isPremium() == 0 ) {
            ?>
          <?php 
            echo  ContactListHelpers::proFeatureMarkup() ;
            ?>
        <?php 
        }
        
        ?>

    </div>
    <?php 
    }

}