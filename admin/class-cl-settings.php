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
            'contact-list-last_name_before_first_name',
            __( 'Show last name before first name', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-last_name_before_first_name',
            'field_name' => 'last_name_before_first_name',
        )
        );
        add_settings_field(
            'contact-list-focus_on_search_field',
            __( 'Focus on search field on page load', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-focus_on_search_field',
            'field_name' => 'focus_on_search_field',
        )
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
        $tab = 2;
        add_settings_section(
            'contact-list_tab_' . $tab,
            '',
            array( $this, 'contact_list_settings_tab_' . $tab . '_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-layout',
            __( 'Layout', 'contact-list' ),
            array( $this, 'layout_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
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
            'contact-list_tab_' . $tab,
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
            'contact-list_tab_' . $tab,
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
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-card_border',
            'field_name' => 'card_border',
        )
        );
        add_settings_field(
            'contact-list-contact_image_style',
            __( 'Contact image style', 'contact-list' ),
            array( $this, 'contact_image_style_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-contact_image_style',
            'field_name' => 'contact_image_style',
        )
        );
        add_settings_field(
            'contact-list-contact_image_shadow',
            __( 'Display shadow below contact image', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-contact_image_shadow',
            'field_name' => 'contact_image_shadow',
        )
        );
        $tab = 3;
        add_settings_section(
            'contact-list_tab_' . $tab,
            '',
            array( $this, 'contact_list_settings_tab_' . $tab . '_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-hide_contact_email',
            __( 'Hide contact email address from contact card', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-hide_contact_email',
            'field_name' => 'hide_contact_email',
        )
        );
        $tab = 4;
        add_settings_section(
            'contact-list_tab_' . $tab,
            '',
            array( $this, 'contact_list_settings_tab_' . $tab . '_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-show_country_select_in_search',
            __( 'Show country select in search', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
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
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_state_select_in_search',
            'field_name' => 'show_state_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-show_category_select_in_search',
            __( 'Show category / group select in search', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_category_select_in_search',
            'field_name' => 'show_category_select_in_search',
        )
        );
        $tab = 5;
        add_settings_section(
            'contact-list_tab_' . $tab,
            '',
            array( $this, 'contact_list_settings_tab_' . $tab . '_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-custom_field_1_title',
            __( 'Custom field 1', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-custom_field_1_title',
            'field_name'  => 'custom_field_1_title',
            'placeholder' => __( 'Custom field 1', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-custom_field_1_icon',
            __( 'Icon for custom field 1', 'contact-list' ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-custom_field_1_icon',
            'field_name'  => 'custom_field_1_icon',
            'placeholder' => '',
        )
        );
        add_settings_section(
            'contact-list_section',
            '',
            array( $this, 'contact_list_settings_section_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-search_contacts',
            __( 'Search contacts...', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-search_contacts',
            'field_name'  => 'search_contacts',
            'placeholder' => __( 'Search contacts...', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-search_all_contacts',
            __( 'Search all contacts...', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-search_all_contacts',
            'field_name'  => 'search_all_contacts',
            'placeholder' => __( 'Search all contacts...', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_select_category',
            __( 'Select category', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_select_category',
            'field_name'  => 'text_select_category',
            'placeholder' => __( 'Select category', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_filter_contacts',
            __( 'Filter contacts', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_filter_contacts',
            'field_name'  => 'text_filter_contacts',
            'placeholder' => __( 'Filter contacts', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_contact',
            __( 'Search results: "contact"', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_contact',
            'field_name'  => 'text_sr_contact',
            'placeholder' => __( 'contact', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_contacts',
            __( 'Search results: "contacts"', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_contacts',
            'field_name'  => 'text_sr_contacts',
            'placeholder' => __( 'contacts', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_found',
            __( 'Search results: "found"', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_found',
            'field_name'  => 'text_sr_found',
            'placeholder' => __( 'found', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_no_contacts_found',
            __( 'Search results: "No contacts found."', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_no_contacts_found',
            'field_name'  => 'text_sr_no_contacts_found',
            'placeholder' => __( 'No contacts found.', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-back_link_title',
            __( '"Back"-link title', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-back_link_title',
            'field_name'  => 'back_link_title',
            'placeholder' => __( '<< Back', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-first_name_title',
            __( 'First name', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-first_name_title',
            'field_name'  => 'first_name_title',
            'placeholder' => __( 'First name', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-last_name_title',
            __( 'Last name', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-last_name_title',
            'field_name'  => 'last_name_title',
            'placeholder' => __( 'Last name', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-job_title_title',
            __( 'Job title', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-job_title_title',
            'field_name'  => 'job_title_title',
            'placeholder' => __( 'Job title', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-email_title',
            __( 'Email', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-email_title',
            'field_name'  => 'email_title',
            'placeholder' => __( 'Email', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-phone_title',
            __( 'Phone', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-phone_title',
            'field_name'  => 'phone_title',
            'placeholder' => __( 'Phone', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-linkedin_url_title',
            __( 'LinkedIn URL', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-linkedin_url_title',
            'field_name'  => 'linkedin_url_title',
            'placeholder' => __( 'LinkedIn URL', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-twitter_url_title',
            __( 'Twitter URL', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-twitter_url_title',
            'field_name'  => 'twitter_url_title',
            'placeholder' => __( 'Twitter URL', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-facebook_url_title',
            __( 'Facebook URL', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-facebook_url_title',
            'field_name'  => 'facebook_url_title',
            'placeholder' => __( 'Facebook URL', 'contact-list' ),
        )
        );
        add_settings_field(
            'contact-list-instagram_url_title',
            __( 'Instagram URL', 'contact-list' ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-instagram_url_title',
            'field_name'  => 'instagram_url_title',
            'placeholder' => __( 'Instagram URL', 'contact-list' ),
        )
        );
        add_settings_section(
            'contact-list_admin_form',
            '',
            array( $this, 'contact_list_settings_admin_form_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-af_hide_first_name',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'first name', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_first_name',
            'field_name' => 'af_hide_first_name',
        )
        );
        add_settings_field(
            'contact-list-af_hide_job_title',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'job title', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_job_title',
            'field_name' => 'af_hide_job_title',
        )
        );
        add_settings_field(
            'contact-list-af_hide_email',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'email', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_email',
            'field_name' => 'af_hide_email',
        )
        );
        add_settings_field(
            'contact-list-af_hide_phone',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'phone', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_phone',
            'field_name' => 'af_hide_phone',
        )
        );
        add_settings_field(
            'contact-list-af_hide_linkedin_url',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'LinkedIn URL', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_linkedin_url',
            'field_name' => 'af_hide_linkedin_url',
        )
        );
        add_settings_field(
            'contact-list-af_hide_twitter_url',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'Twitter URL', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_twitter_url',
            'field_name' => 'af_hide_twitter_url',
        )
        );
        add_settings_field(
            'contact-list-af_hide_facebook_url',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'Facebook URL', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_facebook_url',
            'field_name' => 'af_hide_facebook_url',
        )
        );
        add_settings_field(
            'contact-list-af_hide_instagram_url',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'Instagram URL', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_instagram_url',
            'field_name' => 'af_hide_instagram_url',
        )
        );
        add_settings_field(
            'contact-list-af_hide_address',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'address', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_address',
            'field_name' => 'af_hide_address',
        )
        );
        add_settings_field(
            'contact-list-af_hide_custom_fields',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'custom fields', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_custom_fields',
            'field_name' => 'af_hide_custom_fields',
        )
        );
        add_settings_field(
            'contact-list-af_hide_groups',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'groups', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_groups',
            'field_name' => 'af_hide_groups',
        )
        );
        add_settings_field(
            'contact-list-af_hide_additional_info',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'additional information', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_additional_info',
            'field_name' => 'af_hide_additional_info',
        )
        );
        add_settings_section(
            'contact-list_simple_list',
            '',
            array( $this, 'contact_list_settings_simple_list_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-simple_list_hide_job_title',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'job title', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_job_title',
            'field_name' => 'simple_list_hide_job_title',
        )
        );
        add_settings_field(
            'contact-list-simple_list_hide_email',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'email', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_email',
            'field_name' => 'simple_list_hide_email',
        )
        );
        add_settings_field(
            'contact-list-simple_list_hide_phone_1',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'phone 1', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_phone_1',
            'field_name' => 'simple_list_hide_phone_1',
        )
        );
        add_settings_field(
            'contact-list-simple_list_hide_some_links',
            __( 'Hide', 'contact-list' ) . ' ' . __( 'social media links', 'contact-list' ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_some_links',
            'field_name' => 'simple_list_hide_some_links',
        )
        );
        $custom_fields = [
            1,
            2,
            3,
            4,
            5,
            6
        ];
        foreach ( $custom_fields as $n ) {
            if ( ContactListHelpers::isPremium() == 0 && $n > 1 ) {
                continue;
            }
            add_settings_field(
                'contact-list-simple_list_show_custom_field_' . $n,
                __( 'Show', 'contact-list' ) . ' ' . __( 'custom field', 'contact-list' ) . ' ' . $n,
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_simple_list',
                array(
                'label_for'  => 'contact-list-simple_list_show_custom_field_' . $n,
                'field_name' => 'simple_list_show_custom_field_' . $n,
            )
            );
        }
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
                'arrow-circle-o-right',
                'star',
                'star-o',
                'university',
                'car',
                'circle',
                'circle-o',
                'dot-circle-o',
                'play',
                'chevron-right',
                'caret-right'
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
    
    public function contact_image_style_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $card_image_style = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $card_image_style = $options[$args['field_name']];
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  $args['field_name'] ;
            ?>]">
          <option value=""><?php 
            echo  __( 'None', 'contact-list' ) ;
            ?></option>
          <option value="sepia" <?php 
            echo  ( $card_image_style == 'sepia' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Sepia', 'contact-list' ) ;
            ?></option>
          <option value="grayscale" <?php 
            echo  ( $card_image_style == 'grayscale' ? 'selected' : '' ) ;
            ?>><?php 
            echo  __( 'Grayscale', 'contact-list' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function contact_list_settings_general_section_callback()
    {
        
        if ( ContactListHelpers::isPremium() == 1 ) {
            echo  '' ;
        } else {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
    
    }
    
    public function contact_list_settings_tab_2_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-2">' ;
        
        if ( ContactListHelpers::isPremium() == 1 ) {
            echo  '<p>' . __( '', 'contact-list' ) . '</p>' ;
        } else {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
    
    }
    
    public function contact_list_settings_tab_3_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-3">' ;
        
        if ( ContactListHelpers::isPremium() == 1 ) {
            echo  '<p>' . __( '', 'contact-list' ) . '</p>' ;
        } else {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
    
    }
    
    public function contact_list_settings_tab_4_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-4">' ;
        
        if ( ContactListHelpers::isPremium() == 1 ) {
            echo  '<p>' . __( '', 'contact-list' ) . '</p>' ;
        } else {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
        
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . __( 'These settings are for this form in the front-end:', 'contact-list' ) . '<hr class="clear" /><img src="' . plugins_url( '../img/search-form-sample.png', __FILE__ ) . '" style="box-shadow: 2px 2px 4px #bbb;" />' . '</p>' ;
    }
    
    public function contact_list_settings_tab_5_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-5">' ;
        
        if ( ContactListHelpers::isPremium() == 1 ) {
            echo  '<p>' . __( '', 'contact-list' ) . '</p>' ;
        } else {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
    
    }
    
    public function contact_list_settings_section_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-6">' ;
        if ( ContactListHelpers::isPremium() == 0 ) {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
        echo  '<p>' . __( 'You may enter alternative titles and texts here. The values defined here will override the default values.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_admin_form_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-7">' ;
        if ( ContactListHelpers::isPremium() == 0 ) {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . __( 'Admin form elements', 'contact-list' ) . '</p>' ;
        echo  '<p>' . __( 'You may customize the admin form (the one displayed in the WP admin area) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_public_form_callback()
    {
        echo  '<h2 style="margin-top: 20px;">' . __( 'Public form elements', 'contact-list' ) . '</h2>' ;
        echo  '<p>' . __( 'You may customize the public form (the one displayed using the [contact_list_form] shortcode) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_simple_list_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-8">' ;
        if ( ContactListHelpers::isPremium() == 0 ) {
            echo  ContactListHelpers::proFeatureSettingsMarkup() ;
        }
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . __( 'Fields in simple list', 'contact-list' ) . '</p>' ;
    }
    
    public function settings_page()
    {
        ?>
    <link rel="stylesheet" href="<?php 
        echo  CONTACT_LIST_URI . 'dist/font-awesome-4.7.0/css/font-awesome.min.css' ;
        ?>">

    <form action="options.php" method="post" class="contact-list-settings-form">

      <h1><?php 
        echo  __( 'Contact List Settings', 'contact-list' ) ;
        ?></h1>

      <div class="contact-list-settings-tabs-container">
        <ul class="contact-list-settings-tabs">
          <li class="active" data-settings-container="contact-list-settings-tab-1"><span><?php 
        echo  __( 'General settings', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-2"><span><?php 
        echo  __( 'Layout', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-3"><span><?php 
        echo  __( 'reCAPTCHA and email', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-4"><span><?php 
        echo  __( 'Search form', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-5"><span><?php 
        echo  __( 'Custom fields', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-6"><span><?php 
        echo  __( 'Field titles and texts', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-7"><span><?php 
        echo  __( 'Hide form elements', 'contact-list' ) ;
        ?></span></li>
          <li data-settings-container="contact-list-settings-tab-8"><span><?php 
        echo  __( 'Simple list', 'contact-list' ) ;
        ?></span></li>
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