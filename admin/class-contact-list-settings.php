<?php

class ContactListSettings
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
            '',
            array( $this, 'contact_list_settings_general_section_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-hide_send_email_button',
            __( 'Hide Send message -button from the public list', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-hide_send_email_button',
            'field_name' => 'hide_send_email_button',
        )
        );
        add_settings_field(
            'contact-list-hide_contact_email',
            __( 'Hide contact email from contact card', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-hide_contact_email',
            'field_name' => 'hide_contact_email',
        )
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
        add_settings_field(
            'contact-list-layout',
            __( 'Layout', 'contact-list' ),
            array( $this, 'layout_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-layout',
            'field_name' => 'layout',
        )
        );
        add_settings_field(
            'contact-list-card_height',
            __( 'Card height in pixels', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'   => 'contact-list-card_height',
            'field_name'  => 'card_height',
            'placeholder' => '380',
        )
        );
        add_settings_field(
            'contact-list-card_background',
            __( 'Card background', 'contact-list' ),
            array( $this, 'card_background_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-card_background',
            'field_name' => 'card_background',
        )
        );
        add_settings_field(
            'contact-list-card_border',
            __( 'Card border', 'contact-list' ),
            array( $this, 'card_border_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-card_border',
            'field_name' => 'card_border',
        )
        );
        add_settings_field(
            'contact-list-show_country_select_in_search',
            __( 'Show country select in search', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-show_country_select_in_search',
            'field_name' => 'show_country_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-show_state_select_in_search',
            __( 'Show state select in search', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-show_state_select_in_search',
            'field_name' => 'show_state_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-show_category_select_in_search',
            __( 'Show category select in search', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-show_category_select_in_search',
            'field_name' => 'show_category_select_in_search',
        )
        );
        add_settings_section(
            'contact-list_section',
            '',
            array( $this, 'contact_list_settings_section_callback' ),
            'contact-list'
        );
        add_settings_section(
            'contact-list_admin_form',
            '',
            array( $this, 'contact_list_settings_admin_form_callback' ),
            'contact-list'
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
            
            if ( $args['field_name'] == 'activate_recaptcha' ) {
                ?>
          <div class="general-info">
            <b><?php 
                echo  __( 'Note:', 'contact-list' ) ;
                ?></b>
            <?php 
                echo  __( 'The plugin currently supports reCAPTCHA v2 ("I\'m not a robot" checkbox). When you create your keys, you must choose this type. More information on this at', 'contact-list' ) ;
                ?> <a href="https://developers.google.com/recaptcha/docs/versions" target="_blank">https://developers.google.com/recaptcha/docs/versions</a>.
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
    
    public function icon_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $sel = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $sel = $options[$args['field_name']];
            }
            ?>    

      <label class="cl-icon-sel"><input type="radio" name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]"  value="" <?php 
            echo  ( $sel == '' ? 'checked' : '' ) ;
            ?>> <?php 
            echo  __( 'none', 'contact-list' ) ;
            ?></label>

      <?php 
            $icons = [
                'phone',
                'phone-square',
                'mobile',
                'envelope',
                'envelope-o',
                'envelope-square',
                'fax',
                'hand-o-right',
                'check-square',
                'arrow-circle-o-right'
            ];
            ?>
      
      <?php 
            foreach ( $icons as $icon ) {
                ?>
          <label class="cl-icon-sel"><input type="radio" name="contact_list_settings[<?php 
                echo  $args['field_name'] ;
                ?>]"  value="fa-<?php 
                echo  $icon ;
                ?>" <?php 
                echo  ( $sel == 'fa-' . $icon ? 'checked' : '' ) ;
                ?>> <i class="fa fa-<?php 
                echo  $icon ;
                ?>" aria-hidden="true"></i></label>
      <?php 
            }
            ?>

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
            ?> (<?php 
            echo  __( 'without contact images', 'contact-list' ) ;
            ?>)</option>
          <option value="4-cards-on-the-same-row" <?php 
            echo  ( $layout == '4-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( '4 cards on the same row', 'contact-list' ) ;
            ?> (<?php 
            echo  __( 'without contact images', 'contact-list' ) ;
            ?>)</option>
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
    
    public function card_border_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $card_border = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_border = $options[$args['field_name']];
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value=""><?php 
            echo  __( 'None', 'contact-list' ) ;
            ?></option>
          <option value="black" <?php 
            echo  ( $card_border == 'black' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Black', 'contact-list' ) ;
            ?></option>
          <option value="gray" <?php 
            echo  ( $card_border == 'gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Gray', 'contact-list' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function contact_list_settings_general_section_callback()
    {
        echo  ContactListHelpers::proFeatureSettingsMarkup() ;
    }
    
    public function contact_list_settings_section_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-2">' ;
        echo  ContactListHelpers::proFeatureSettingsMarkup() ;
    }
    
    public function contact_list_settings_admin_form_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-3">' ;
        echo  ContactListHelpers::proFeatureSettingsMarkup() ;
    }
    
    public function contact_list_settings_public_form_callback()
    {
        echo  '<h2>' . __( 'Public form elements', 'contact-list' ) . '</h2>' ;
        echo  '<p>' . __( 'You may customize the public form (the one displayed using the [contact_list_form] shortcode) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function settings_page()
    {
        ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">

    <form action="options.php" method="post" class="contact-list-settings-form">

      <h1><?php 
        echo  __( 'Contact List Settings', 'contact-list' ) ;
        ?></h1>

      <div class="contact-list-settings-tabs-container">
        <ul class="contact-list-settings-tabs">
          <li class="active" data-settings-container="contact-list-settings-tab-1"><?php 
        echo  __( 'General settings', 'contact-list' ) ;
        ?></li>
          <li data-settings-container="contact-list-settings-tab-2"><?php 
        echo  __( 'Field titles, icons and texts', 'contact-list' ) ;
        ?></li>
          <li data-settings-container="contact-list-settings-tab-3"><?php 
        echo  __( 'Hide form elements', 'contact-list' ) ;
        ?></li>
          <hr class="clear" />
        </ul>
      </div>

      <div class="contact-list-settings-container">

        <div class="contact-list-settings-tab-1">
          <?php 
        settings_fields( 'contact-list' );
        ?>
          <?php 
        do_settings_sections( 'contact-list' );
        ?>  
        </div>
        
        <?php 
        submit_button();
        ?>
      
      </div>

    </form>
    <?php 
    }
    
    public function register_support_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'How to use Contact List', 'contact-list' ),
            __( 'Help / Support', 'contact-list' ),
            'manage_options',
            'contact-list-support',
            [ $this, 'register_support_page_callback' ]
        );
    }
    
    public function add_settings_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=contact-list';
        $menuitem = 'edit.php?post_type=' . CONTACT_CPT;
        $submenu[$menuitem][] = array( __( 'Settings&nbsp;&nbsp;➤', 'contact-list' ), 'manage_options', $permalink );
    }
    
    public function add_upgrade_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=contact-list-pricing';
        $menuitem = 'edit.php?post_type=' . CONTACT_CPT;
        $submenu[$menuitem][] = array(
            __( 'Upgrade&nbsp;&nbsp;➤', 'contact-list' ),
            'manage_options',
            $permalink,
            '',
            'contact-list-upgrade'
        );
    }
    
    public function register_support_page_callback()
    {
        ?>
    
    <div class="wrap">

      <h1><?php 
        echo  __( 'How to use Contact List', 'contact-list' ) ;
        ?></h1>

      <div class="contact-list-examples">
          <p><?php 
        echo  __( 'Some examples on how you can use different views available at', 'contact-list' ) ;
        ?> <a href="https://www.contactlistpro.com/contact-list/" target="_blank"><?php 
        echo  __( 'contactlistpro.com', 'contact-list' ) ;
        ?></a>.</p>
          <p><?php 
        echo  __( 'Any feedback is welcome. You may contact the author at', 'contact-list' ) . ' <a href="https://anssilaitila.fi/" target="_blank">anssilaitila.fi</a> ' . __( 'or by email:', 'contact-list' ) . ' <a href="mailto:&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a>' ;
        ?></p>
      </div>

      <h2><?php 
        echo  __( 'Only contacts, no groups', 'contact-list' ) ;
        ?></h2>

      <ol>
        <li><?php 
        echo  __( 'Add the contacts via the All Contacts page.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Insert the shortcode <span class="contact-list-shortcode">[contact_list]</span> to the content editor of any page you wish the contact list to appear.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Additional parameters', 'contact-list' ) ;
        ?>
            <ul class="contact-list-admin-ul">
                <li><?php 
        echo  __( 'Hide search form:', 'contact-list' ) ;
        ?> <span class="contact-list-shortcode">[contact_list hide_search=1]</span></li>
                <li><?php 
        echo  __( 'Layout "2 cards on the same row"', 'contact-list' ) ;
        ?>: <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Layout "3 cards on the same row"', 'contact-list' ) ;
        ?> (<?php 
        echo  __( 'without contact images', 'contact-list' ) ;
        ?>): <span class="contact-list-shortcode">[contact_list layout=3-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Layout "4 cards on the same row"', 'contact-list' ) ;
        ?> (<?php 
        echo  __( 'without contact images', 'contact-list' ) ;
        ?>): <span class="contact-list-shortcode">[contact_list layout=4-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Multiple parameters:', 'contact-list' ) ;
        ?> <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row hide_search=1]</span></li>
            </ul>
        </li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Contacts with groups', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Add the groups via the Groups page. There may be groups under groups (hierarchial groups, 2 or more levels).', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Add the contacts via the All Contacts page. You may select the appropriate group(s) at this point.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Insert the shortcode <span class="contact-list-shortcode">[contact_list_groups]</span> to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Contacts from specific group', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_groups group=GROUP_SLUG]</span>' . __( 'to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Single contact', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list contact=CONTACT_ID]</span>' . __( 'to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Allow visitors to add new contacts', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_form]</span>' . __( 'to the page you wish the form to appear on.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'When a user submits the form, a new contact is saved to the contacts. The status of that contact is "Pending Review" and a site administrator must publish/edit/delete the contact.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h3>
        <?php 
        echo  __( 'Only a search form that searches from all contacts', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_search]</span>' . __( 'to the page you wish the view to appear on.', 'contact-list' ) ;
        ?></li>
      </ol>

      <hr class="style-one" />

      <h2><?php 
        echo  __( 'Give a rating for the plugin', 'contact-list' ) ;
        ?></h2>
      <p><?php 
        echo  __( "Whether it's 1 star or 5 stars, I'm grateful for your rating. You may rate the plugin", 'contact-list' ) ;
        ?> <a href="https://wordpress.org/support/plugin/contact-list/reviews/" target="_blank"><?php 
        echo  __( 'here', 'contact-list' ) ;
        ?></a>.</p>

    </div>
    <?php 
    }
    
    public function update_db_check()
    {
        $installed_version = get_site_option( 'contact_list_version' );
        
        if ( $installed_version != CONTACT_LIST_VERSION ) {
            global  $wpdb ;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'cl_sent_mail_log';
            $wpdb->query( "CREATE TABLE IF NOT EXISTS " . $table_name . " (\n    \t  id              BIGINT(20) NOT NULL auto_increment,\n    \t  msg_id          VARCHAR(255) NOT NULL,\n    \t  sender_email    VARCHAR(255) NOT NULL,\n    \t  sender_name     VARCHAR(255) NOT NULL,\n    \t  recipient_email VARCHAR(255) NOT NULL,\n    \t  reply_to        VARCHAR(255) NOT NULL,\n    \t  msg_type        VARCHAR(255) NOT NULL,\n    \t  subject         VARCHAR(255) NOT NULL,\n    \t  response        VARCHAR(255) NOT NULL,\n    \t  mail_cnt        MEDIUMINT NOT NULL,\n    \t  report          TEXT NOT NULL,\n    \t  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n    \t  PRIMARY KEY (id)\n    \t) " . $charset_collate . ";" );
            update_option( 'contact_list_version', CONTACT_LIST_VERSION );
        }
    
    }

}