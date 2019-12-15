<?php

class Contact_List_Settings
{
    public function contact_list_add_admin_menu()
    {
        add_options_page(
            'Contact List Settings',
            'Contact List',
            'manage_options',
            'contact-list',
            array( $this, 'settings_page' )
        );
    }
    
    public function contact_list_settings_init()
    {
        register_setting( 'contact-list', 'contact_list_settings' );
        add_settings_section(
            'contact-list_section_general',
            __( 'General settings', 'contact-list' ),
            array( $this, 'contact_list_settings_general_section_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-order_by',
            __( 'Sort contact list by', 'contact-list' ),
            array( $this, 'select_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-order_by',
            'field_name' => 'order_by',
        )
        );
    }
    
    public function additional_information_render( $args )
    {
        $options = get_option( 'contact_list_settings' );
        ?>
    <input type="text" class="input-field" id="contact-list-additional_information_title" name="contact_list_settings[additional_information_title]" value="<?php 
        echo  ( isset( $options['additional_information_title'] ) ? $options['additional_information_title'] : '' ) ;
        ?>" placeholder="<?php 
        echo  __( 'Additional information', 'contact-list' ) ;
        ?>">
    <?php 
    }
    
    public function input_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            ?>    
      <input type="text" class="input-field" id="contact-list-<?php 
            echo  $args['field_name'] ;
            ?>" name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]" value="<?php 
            echo  ( isset( $options[$args['field_name']] ) ? $options[$args['field_name']] : '' ) ;
            ?>" placeholder="<?php 
            echo  ( $args['placeholder'] ? $args['placeholder'] : '' ) ;
            ?>">
      <?php 
        }
    
    }
    
    public function checkbox_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            ?>    
      <input type="checkbox" id="contact-list-<?php 
            echo  $args['field_name'] ;
            ?>" name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]" <?php 
            echo  ( isset( $options[$args['field_name']] ) ? 'checked="checked"' : '' ) ;
            ?>>
      
      <?php 
            
            if ( $args['field_name'] == 'send_email' ) {
                ?>
        <div class="email-info">
          <b><?php 
                echo  __( 'Note:' ) ;
                ?></b> <?php 
                echo  __( 'By activating this you agree that the email sending is handled by the plugin developers own server and using <a href="https://www.mailgun.com" target="_blank">Mailgun</a>. The server is a DigitalOcean Droplet hosted in the EU. This method was chosen to ensure reliable mail delivery.', 'contact-list' ) ;
                ?>
        </div>
      <?php 
            }
            
            ?>
      <?php 
        }
    
    }
    
    public function select_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $order_by = '_cl_last_name';
            if ( isset( $options[$args['field_name']] ) ) {
                $order_by = $options[$args['field_name']];
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value="_cl_last_name"><?php 
            echo  ( isset( $options['_cl_last_name'] ) ? $options['_cl_last_name'] : __( 'Last name', 'contact-list' ) ) ;
            ?></option>
          <option value="_cl_first_name" <?php 
            echo  ( $order_by == '_cl_first_name' ? 'selected' : '' ) ;
            ?>><?php 
            echo  ( isset( $options['_cl_first_name'] ) ? $options['_cl_first_name'] : __( 'First name', 'contact-list' ) ) ;
            ?></option>
      </select>

        <div class="email-info">
          <b><?php 
            echo  __( 'Note:' ) ;
            ?></b> <?php 
            echo  __( 'If "First name" is selected, only the contacts with the first name defined are listed.', 'contact-list' ) ;
            ?>
        </div>

      <?php 
        }
    
    }
    
    public function layout_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $layout = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $layout = $options[$args['field_name']];
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value=""><?php 
            echo  __( 'Default list', 'contact-list' ) ;
            ?></option>
          <option value="2-cards-on-the-same-row" <?php 
            echo  ( $layout == '2-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '2 cards on the same row', 'contact-list' ) ;
            ?></option>
          <option value="3-cards-on-the-same-row" <?php 
            echo  ( $layout == '3-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '3 cards on the same row', 'contact-list' ) ;
            ?></option>
          <option value="4-cards-on-the-same-row" <?php 
            echo  ( $layout == '4-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '4 cards on the same row', 'contact-list' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function card_background_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $card_background = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_background = $options[$args['field_name']];
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value=""><?php 
            echo  __( 'Transparent', 'contact-list' ) ;
            ?></option>
          <option value="white" <?php 
            echo  ( $card_background == 'white' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'White', 'contact-list' ) ;
            ?></option>
          <option value="light_gray" <?php 
            echo  ( $card_background == 'light_gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Light gray', 'contact-list' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function contact_list_settings_section_callback()
    {
        echo  '<p>' . __( 'You may enter alternative titles and texts here. The values defined here will override the default values.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_admin_form_callback()
    {
        echo  '<p>' . __( 'You may customize the admin form (the one displayed in the WP admin area) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_public_form_callback()
    {
        echo  '<p>' . __( 'You may customize the public form (the one displayed using the [contact_list_form] shortcode) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_general_section_callback()
    {
        echo  proFeatureSettingsMarkup() ;
    }
    
    public function settings_page()
    {
        ?>
    <style>
      h1 {
        margin-bottom: 2rem;
      }
      .input-field {
        width: 300px;
      }
      #contact-list-thank_you_page_content {
        width: 800px;
      }
      .form-table td,
      .form-table th {
        padding: 0.5rem;
      }
      p {
        margin-bottom: 1rem;
      }
      .email-info {
        background: #eee;
        border: 1px solid #bbb;
        max-width: 600px;
        padding: .5rem;
        margin-top: .5rem;
        font-size: .8rem;
      }
    </style>
    <form action="options.php" method="post">

      <h1><?php 
        echo  __( 'Contact List Settings', 'contact-list' ) ;
        ?></h1>

      <?php 
        settings_fields( 'contact-list' );
        do_settings_sections( 'contact-list' );
        submit_button();
        ?>

    </form>
    <?php 
    }

}