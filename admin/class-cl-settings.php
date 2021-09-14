<?php

// Premium-only fields are just ads for upgrading, not containing any real functionality
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
        $only_pro = '_FREE_';
        register_setting( 'contact-list', 'contact_list_settings' );
        add_settings_section(
            'contact-list_section_general',
            '',
            array( $this, 'contact_list_settings_general_section_callback' ),
            'contact-list'
        );
        if ( ContactListHelpers::isPremium() == 0 ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'enable_request_update',
                sanitize_text_field( __( 'Enable "request update"-feature', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_section_general',
                array(
                'label_for'   => 'contact-list-' . $only_pro . 'enable_request_update',
                'field_name'  => $only_pro . 'enable_request_update',
                'placeholder' => '',
            )
            );
        }
        add_settings_field(
            'contact-list-order_by',
            sanitize_text_field( __( 'Sort contact list by', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Show last name before first name', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-last_name_before_first_name',
            'field_name' => 'last_name_before_first_name',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'contacts_per_page',
            sanitize_text_field( __( 'Contacts per page (activates pagination)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'contacts_per_page',
            'field_name'  => $only_pro . 'contacts_per_page',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-pagination_type',
            sanitize_text_field( __( 'Pagination type', 'contact-list' ) ),
            array( $this, 'pagination_type_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-pagination_type',
            'field_name' => 'pagination_type',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'group_select',
            sanitize_text_field( __( 'Display group checkboxes on public form', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'group_select',
            'field_name' => $only_pro . 'group_select',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_contacts_from_subgroup',
            sanitize_text_field( __( 'Show contacts from subgroups in the main group view', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_contacts_from_subgroup',
            'field_name' => $only_pro . 'show_contacts_from_subgroup',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'automatically_publish_contacts',
            sanitize_text_field( __( 'Automatically publish user submitted contacts', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section_general',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'automatically_publish_contacts',
            'field_name' => $only_pro . 'automatically_publish_contacts',
        )
        );
        add_settings_field(
            'contact-list-focus_on_search_field',
            sanitize_text_field( __( 'Focus on search field on page load', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide Send message -button from the public list', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Layout', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Card height in pixels', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Card background', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Card border', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Contact image style', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Display shadow below contact image', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-contact_image_shadow',
            'field_name' => 'contact_image_shadow',
        )
        );
        add_settings_field(
            'contact-list-contact_show_groups',
            sanitize_text_field( __( 'Show groups on contact card', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-contact_show_groups',
            'field_name' => 'contact_show_groups',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'move_zip_after_state',
            sanitize_text_field( __( 'Move zip code after state', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'move_zip_after_state',
            'field_name' => $only_pro . 'move_zip_after_state',
        )
        );
        add_settings_field(
            'contact-list-show_contact_images_always',
            sanitize_text_field( __( 'Show contact images when using 3 or 4 columns view', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_contact_images_always',
            'field_name' => 'show_contact_images_always',
        )
        );
        add_settings_field(
            'contact-list-contact_groups_title',
            sanitize_text_field( __( 'Title above the groups', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-contact_groups_title',
            'field_name'  => 'contact_groups_title',
            'placeholder' => 'Groups',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'hide_phone_numbers_from_public_card',
            sanitize_text_field( __( 'Hide phone numbers from public card', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'hide_phone_numbers_from_public_card',
            'field_name' => $only_pro . 'hide_phone_numbers_from_public_card',
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
            sanitize_text_field( __( 'Hide contact email address from contact card', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-hide_contact_email',
            'field_name' => 'hide_contact_email',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'activate_recaptcha',
            sanitize_text_field( __( 'Activate reCAPTCHA', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'activate_recaptcha',
            'field_name' => $only_pro . 'activate_recaptcha',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'recaptcha_key',
            sanitize_text_field( __( 'reCAPTCHA site key', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'recaptcha_site_key',
            'field_name'  => $only_pro . 'recaptcha_site_key',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'recaptcha_secret',
            sanitize_text_field( __( 'reCAPTCHA secret key', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'recaptcha_secret_key',
            'field_name'  => $only_pro . 'recaptcha_secret_key',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'email_sender_contact_card',
            sanitize_text_field( __( 'Sender email for messages sent from contact card', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'email_sender_contact_card',
            'field_name'  => $only_pro . 'email_sender_contact_card',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'email_sender_name_contact_card',
            sanitize_text_field( __( 'Sender name for messages sent from contact card', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'email_sender_name_contact_card',
            'field_name'  => $only_pro . 'email_sender_name_contact_card',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'sender_email_group_send',
            sanitize_text_field( __( 'Sender email for messages sent using the shortcode [contact_list_send_email]', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'sender_email_group_send',
            'field_name'  => $only_pro . 'sender_email_group_send',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'set_return_path',
            sanitize_text_field( __( 'Set Return-Path to same as sender email', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'set_return_path',
            'field_name'  => $only_pro . 'set_return_path',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'send_email',
            sanitize_text_field( __( 'Send an email notify when a contact is added via the public form', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'send_email',
            'field_name' => $only_pro . 'send_email',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'recipient_email',
            sanitize_text_field( __( 'Notification recipient email', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'recipient_email',
            'field_name'  => $only_pro . 'recipient_email',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'remove_email_footer',
            sanitize_text_field( __( 'Remove email footer completely', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'remove_email_footer',
            'field_name' => $only_pro . 'remove_email_footer',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'text_email_footer',
            sanitize_text_field( __( 'Email footer text', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_email_footer',
            'field_name'  => $only_pro . 'text_email_footer',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-disable_mail_log',
            sanitize_text_field( __( 'Disable mail log', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-disable_mail_log',
            'field_name' => 'disable_mail_log',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'disable_recaptcha_from_mail_log',
            sanitize_text_field( __( 'Disable logging for reCAPTCHA errors', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'disable_recaptcha_from_mail_log',
            'field_name' => $only_pro . 'disable_recaptcha_from_mail_log',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'request_update_mail_subject',
            sanitize_text_field( __( 'Request update: mail subject', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'request_update_mail_subject',
            'field_name'  => $only_pro . 'request_update_mail_subject',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'request_update_mail_content',
            sanitize_text_field( __( 'Request update: mail content', 'contact-list' ) ),
            array( $this, 'textarea_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'request_update_mail_content',
            'field_name'  => $only_pro . 'request_update_mail_content',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'request_update_link_text',
            sanitize_text_field( __( 'Request update: update link text', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'request_update_link_text',
            'field_name'  => $only_pro . 'request_update_link_text',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'send_permanent_update_url',
            sanitize_text_field( __( 'Send a permanent update URL to contacts created using the shortcode [contact_list_form]', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'send_permanent_update_url',
            'field_name' => $only_pro . 'send_permanent_update_url',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'permanent_update_url_mail_subject',
            sanitize_text_field( __( 'Permanent update URL: mail subject', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'permanent_update_url_mail_subject',
            'field_name'  => $only_pro . 'permanent_update_url_mail_subject',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'permanent_update_url_mail_content',
            sanitize_text_field( __( 'Permanent update URL: mail content', 'contact-list' ) ),
            array( $this, 'textarea_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'permanent_update_url_mail_content',
            'field_name'  => $only_pro . 'permanent_update_url_mail_content',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'permanent_update_url_link_text',
            sanitize_text_field( __( 'Permanent update URL: update link text', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'permanent_update_url_link_text',
            'field_name'  => $only_pro . 'permanent_update_url_link_text',
            'placeholder' => $placeholder,
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
            sanitize_text_field( __( 'Show country select in search', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Show state select in search', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_state_select_in_search',
            'field_name' => 'show_state_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-show_city_select_in_search',
            sanitize_text_field( __( 'Show city select in search', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_city_select_in_search',
            'field_name' => 'show_city_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'link_country_and_state',
            sanitize_text_field( __( 'Link country, state and city', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'link_country_and_state',
            'field_name' => $only_pro . 'link_country_and_state',
        )
        );
        add_settings_field(
            'contact-list-show_category_select_in_search',
            sanitize_text_field( __( 'Show category / group select in search', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-show_category_select_in_search',
            'field_name' => 'show_category_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_1_select_in_search',
            sanitize_text_field( __( 'Show custom field 1 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_1_select_in_search',
            'field_name' => $only_pro . 'show_cf_1_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_2_select_in_search',
            sanitize_text_field( __( 'Show custom field 2 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_2_select_in_search',
            'field_name' => $only_pro . 'show_cf_2_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_3_select_in_search',
            sanitize_text_field( __( 'Show custom field 3 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_3_select_in_search',
            'field_name' => $only_pro . 'show_cf_3_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_4_select_in_search',
            sanitize_text_field( __( 'Show custom field 4 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_4_select_in_search',
            'field_name' => $only_pro . 'show_cf_4_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_5_select_in_search',
            sanitize_text_field( __( 'Show custom field 5 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_5_select_in_search',
            'field_name' => $only_pro . 'show_cf_5_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'show_cf_6_select_in_search',
            sanitize_text_field( __( 'Show custom field 6 select', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'show_cf_6_select_in_search',
            'field_name' => $only_pro . 'show_cf_6_select_in_search',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'simpler_category_dropdown',
            sanitize_text_field( __( 'Simpler version of category dropdown (without subcategories and numbers of contacts)', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'simpler_category_dropdown',
            'field_name' => $only_pro . 'simpler_category_dropdown',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'search_dropdown_width_auto',
            sanitize_text_field( __( 'Search dropdown width defined based on contents (instead of fixed width)', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'search_dropdown_width_auto',
            'field_name' => $only_pro . 'search_dropdown_width_auto',
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
            sanitize_text_field( __( 'Custom field 1 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-custom_field_1_title',
            'field_name'  => 'custom_field_1_title',
            'placeholder' => sanitize_text_field( __( 'Custom field 1', 'contact-list' ) ),
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_1_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_1_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_1_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-custom_field_1_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-custom_field_1_link_text',
            'field_name'  => 'custom_field_1_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-custom_field_1_icon',
            sanitize_text_field( __( 'Icon for custom field 1', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-custom_field_1_icon',
            'field_name'  => 'custom_field_1_icon',
            'placeholder' => '',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_2_title',
            sanitize_text_field( __( 'Custom field 2 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_2_title',
            'field_name'  => $only_pro . 'custom_field_2_title',
            'placeholder' => $placeholder,
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_2_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_2_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_2_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_2_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_2_link_text',
            'field_name'  => $only_pro . 'custom_field_2_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_2_icon',
            sanitize_text_field( __( 'Icon for custom field 2', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_2_icon',
            'field_name'  => $only_pro . 'custom_field_2_icon',
            'placeholder' => '',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_3_title',
            sanitize_text_field( __( 'Custom field 3 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_3_title',
            'field_name'  => $only_pro . 'custom_field_3_title',
            'placeholder' => $placeholder,
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_3_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_3_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_3_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_3_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_3_link_text',
            'field_name'  => $only_pro . 'custom_field_3_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_3_icon',
            sanitize_text_field( __( 'Icon for custom field 3', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_3_icon',
            'field_name'  => $only_pro . 'custom_field_3_icon',
            'placeholder' => '',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_4_title',
            sanitize_text_field( __( 'Custom field 4 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_4_title',
            'field_name'  => $only_pro . 'custom_field_4_title',
            'placeholder' => $placeholder,
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_4_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_4_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_4_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_4_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_4_link_text',
            'field_name'  => $only_pro . 'custom_field_4_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_4_icon',
            sanitize_text_field( __( 'Icon for custom field 4', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_4_icon',
            'field_name'  => $only_pro . 'custom_field_4_icon',
            'placeholder' => '',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_5_title',
            sanitize_text_field( __( 'Custom field 5 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_5_title',
            'field_name'  => $only_pro . 'custom_field_5_title',
            'placeholder' => $placeholder,
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_5_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_5_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_5_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_5_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_5_link_text',
            'field_name'  => $only_pro . 'custom_field_5_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_5_icon',
            sanitize_text_field( __( 'Icon for custom field 5', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_5_icon',
            'field_name'  => $only_pro . 'custom_field_5_icon',
            'placeholder' => '',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_6_title',
            sanitize_text_field( __( 'Custom field 6 title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_6_title',
            'field_name'  => $only_pro . 'custom_field_6_title',
            'placeholder' => $placeholder,
        )
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'custom_field_6_hide_from_contact_card',
                sanitize_text_field( __( 'Hide from contact card', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_tab_' . $tab,
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'custom_field_6_hide_from_contact_card',
                'field_name' => $only_pro . 'custom_field_6_hide_from_contact_card',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_6_link_text',
            sanitize_text_field( __( 'Link text (only applicable if the custom field content is a URL)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_6_link_text',
            'field_name'  => $only_pro . 'custom_field_6_link_text',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'custom_field_6_icon',
            sanitize_text_field( __( 'Icon for custom field 6', 'contact-list' ) ),
            array( $this, 'icon_render' ),
            'contact-list',
            'contact-list_tab_' . $tab,
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'custom_field_6_icon',
            'field_name'  => $only_pro . 'custom_field_6_icon',
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
            sanitize_text_field( __( 'Search contacts...', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-search_contacts',
            'field_name'  => 'search_contacts',
            'placeholder' => sanitize_text_field( __( 'Search contacts...', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-search_all_contacts',
            sanitize_text_field( __( 'Search all contacts...', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-search_all_contacts',
            'field_name'  => 'search_all_contacts',
            'placeholder' => sanitize_text_field( __( 'Search all contacts...', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_send_message',
            sanitize_text_field( __( 'Send message', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_send_message',
            'field_name'  => $only_pro . 'text_send_message',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-text_select_country',
            sanitize_text_field( __( 'Select country', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_select_country',
            'field_name'  => 'text_select_country',
            'placeholder' => sanitize_text_field( __( 'Select country 1', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-text_select_state',
            sanitize_text_field( __( 'Select state', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_select_state',
            'field_name'  => 'text_select_state',
            'placeholder' => sanitize_text_field( __( 'Select state', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_city',
            sanitize_text_field( __( 'Select city', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_city',
            'field_name'  => $only_pro . 'text_select_city',
            'placeholder' => sanitize_text_field( __( 'Select city', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_1',
            sanitize_text_field( __( 'Select custom field 1', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_1',
            'field_name'  => $only_pro . 'text_select_custom_field_1',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_2',
            sanitize_text_field( __( 'Select custom field 2', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_2',
            'field_name'  => $only_pro . 'text_select_custom_field_2',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_3',
            sanitize_text_field( __( 'Select custom field 3', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_3',
            'field_name'  => $only_pro . 'text_select_custom_field_3',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_4',
            sanitize_text_field( __( 'Select custom field 4', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_4',
            'field_name'  => $only_pro . 'text_select_custom_field_4',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_5',
            sanitize_text_field( __( 'Select custom field 5', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_5',
            'field_name'  => $only_pro . 'text_select_custom_field_5',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'text_select_custom_field_6',
            sanitize_text_field( __( 'Select custom field 6', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'text_select_custom_field_6',
            'field_name'  => $only_pro . 'text_select_custom_field_6',
            'placeholder' => '',
        )
        );
        add_settings_field(
            'contact-list-text_select_category',
            sanitize_text_field( __( 'Select category', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_select_category',
            'field_name'  => 'text_select_category',
            'placeholder' => sanitize_text_field( __( 'Select category', 'contact-list' ) ),
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'category_title',
            sanitize_text_field( __( 'Category (on simple list)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'category_title',
            'field_name'  => $only_pro . 'category_title',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-text_filter_contacts',
            sanitize_text_field( __( 'Filter contacts', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_filter_contacts',
            'field_name'  => 'text_filter_contacts',
            'placeholder' => sanitize_text_field( __( 'Filter contacts', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_contact',
            sanitize_text_field( __( 'Search results: "contact"', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_contact',
            'field_name'  => 'text_sr_contact',
            'placeholder' => sanitize_text_field( __( 'contact', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_contacts',
            sanitize_text_field( __( 'Search results: "contacts"', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_contacts',
            'field_name'  => 'text_sr_contacts',
            'placeholder' => sanitize_text_field( __( 'contacts', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_found',
            sanitize_text_field( __( 'Search results: "found"', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_found',
            'field_name'  => 'text_sr_found',
            'placeholder' => sanitize_text_field( __( 'found', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-text_sr_no_contacts_found',
            sanitize_text_field( __( 'Search results: "No contacts found."', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-text_sr_no_contacts_found',
            'field_name'  => 'text_sr_no_contacts_found',
            'placeholder' => sanitize_text_field( __( 'No contacts found.', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-back_link_title',
            sanitize_text_field( __( '"Back"-link title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-back_link_title',
            'field_name'  => 'back_link_title',
            'placeholder' => sanitize_text_field( __( '<< Back', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-first_name_title',
            sanitize_text_field( __( 'First name', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-first_name_title',
            'field_name'  => 'first_name_title',
            'placeholder' => sanitize_text_field( __( 'First name', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-last_name_title',
            sanitize_text_field( __( 'Last name', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-last_name_title',
            'field_name'  => 'last_name_title',
            'placeholder' => sanitize_text_field( __( 'Last name', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-name_title',
            sanitize_text_field( __( 'Name (simple list title)', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-name_title',
            'field_name'  => 'name_title',
            'placeholder' => sanitize_text_field( __( 'Name', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-job_title_title',
            sanitize_text_field( __( 'Job title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-job_title_title',
            'field_name'  => 'job_title_title',
            'placeholder' => sanitize_text_field( __( 'Job title', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-email_title',
            sanitize_text_field( __( 'Email', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-email_title',
            'field_name'  => 'email_title',
            'placeholder' => sanitize_text_field( __( 'Email', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-phone_title',
            sanitize_text_field( __( 'Phone', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-phone_title',
            'field_name'  => 'phone_title',
            'placeholder' => sanitize_text_field( __( 'Phone', 'contact-list' ) ),
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'phone_2_title',
            sanitize_text_field( __( 'Phone 2', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'phone_2_title',
            'field_name'  => $only_pro . 'phone_2_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'phone_3_title',
            sanitize_text_field( __( 'Phone 3', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'phone_3_title',
            'field_name'  => $only_pro . 'phone_3_title',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-linkedin_url_title',
            sanitize_text_field( __( 'LinkedIn URL', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-linkedin_url_title',
            'field_name'  => 'linkedin_url_title',
            'placeholder' => sanitize_text_field( __( 'LinkedIn URL', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-twitter_url_title',
            sanitize_text_field( __( 'Twitter URL', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-twitter_url_title',
            'field_name'  => 'twitter_url_title',
            'placeholder' => sanitize_text_field( __( 'Twitter URL', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-facebook_url_title',
            sanitize_text_field( __( 'Facebook URL', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-facebook_url_title',
            'field_name'  => 'facebook_url_title',
            'placeholder' => sanitize_text_field( __( 'Facebook URL', 'contact-list' ) ),
        )
        );
        add_settings_field(
            'contact-list-instagram_url_title',
            sanitize_text_field( __( 'Instagram URL', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-instagram_url_title',
            'field_name'  => 'instagram_url_title',
            'placeholder' => sanitize_text_field( __( 'Instagram URL', 'contact-list' ) ),
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'address_title',
            sanitize_text_field( __( 'Address', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'address_title',
            'field_name'  => $only_pro . 'address_title',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'hide_address_title',
            sanitize_text_field( __( 'Hide "Address"-title', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'hide_address_title',
            'field_name' => $only_pro . 'hide_address_title',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'country_title',
            sanitize_text_field( __( 'Country', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'country_title',
            'field_name'  => $only_pro . 'country_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'state_title',
            sanitize_text_field( __( 'State', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'state_title',
            'field_name'  => $only_pro . 'state_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'city_title',
            sanitize_text_field( __( 'City', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'city_title',
            'field_name'  => $only_pro . 'city_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'zip_code_title',
            sanitize_text_field( __( 'ZIP Code', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'zip_code_title',
            'field_name'  => $only_pro . 'zip_code_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'address_line_1_title',
            sanitize_text_field( __( 'Address line 1', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'address_line_1_title',
            'field_name'  => $only_pro . 'address_line_1_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'address_line_2_title',
            sanitize_text_field( __( 'Address line 2', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'address_line_2_title',
            'field_name'  => $only_pro . 'address_line_2_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'address_line_3_title',
            sanitize_text_field( __( 'Address line 3', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'address_line_3_title',
            'field_name'  => $only_pro . 'address_line_3_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'address_line_4_title',
            sanitize_text_field( __( 'Address line 4', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'address_line_4_title',
            'field_name'  => $only_pro . 'address_line_4_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'additional_information_title',
            sanitize_text_field( __( 'Additional information', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'additional_information_title',
            'field_name'  => $only_pro . 'additional_info_title',
            'placeholder' => $placeholder,
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'hide_additional_information_title',
            sanitize_text_field( __( 'Hide "Additional information"-title', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'hide_additional_information_title',
            'field_name' => $only_pro . 'hide_additional_info_title',
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'thank_you_page_title',
            sanitize_text_field( __( 'Thank you page / title', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'thank_you_page_title',
            'field_name'  => $only_pro . 'thank_you_page_title',
            'placeholder' => $placeholder,
        )
        );
        $placeholder = '';
        add_settings_field(
            'contact-list-' . $only_pro . 'thank_you_page_content',
            sanitize_text_field( __( 'Thank you page / content', 'contact-list' ) ),
            array( $this, 'input_render' ),
            'contact-list',
            'contact-list_section',
            array(
            'label_for'   => 'contact-list-' . $only_pro . 'thank_you_page_content',
            'field_name'  => $only_pro . 'thank_you_page_content',
            'placeholder' => $placeholder,
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
            sanitize_text_field( __( 'Hide first name', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide job title', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide email', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide phone', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide LinkedIn URL', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide Twitter URL', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide Facebook URL', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide Instagram URL', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide address', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide custom fields', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide groups', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide additional information', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_admin_form',
            array(
            'label_for'  => 'contact-list-af_hide_additional_info',
            'field_name' => 'af_hide_additional_info',
        )
        );
        add_settings_section(
            'contact-list_public_form',
            '',
            array( $this, 'contact_list_settings_public_form_callback' ),
            'contact-list'
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_first_name',
            sanitize_text_field( __( 'Hide first name', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_first_name',
            'field_name' => $only_pro . 'pf_hide_first_name',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_job_title',
            sanitize_text_field( __( 'Hide job title', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_job_title',
            'field_name' => $only_pro . 'pf_hide_job_title',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_email',
            sanitize_text_field( __( 'Hide email', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_email',
            'field_name' => $only_pro . 'pf_hide_email',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_phone',
            sanitize_text_field( __( 'Hide phone', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_phone',
            'field_name' => $only_pro . 'pf_hide_phone',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_show_phone_2',
            sanitize_text_field( __( 'Show phone 2', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_show_phone_2',
            'field_name' => $only_pro . 'pf_show_phone_2',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_show_phone_3',
            sanitize_text_field( __( 'Show phone 3', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_show_phone_3',
            'field_name' => $only_pro . 'pf_show_phone_3',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_linkedin_url',
            sanitize_text_field( __( 'Hide LinkedIn URL', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_linkedin_url',
            'field_name' => $only_pro . 'pf_hide_linkedin_url',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_twitter_url',
            sanitize_text_field( __( 'Hide Twitter URL', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_twitter_url',
            'field_name' => $only_pro . 'pf_hide_twitter_url',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_facebook_url',
            sanitize_text_field( __( 'Hide Facebook URL', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_facebook_url',
            'field_name' => $only_pro . 'pf_hide_facebook_url',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_instagram_url',
            sanitize_text_field( __( 'Hide Instagram URL', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_instagram_url',
            'field_name' => $only_pro . 'pf_hide_instagram_url',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_photo',
            sanitize_text_field( __( 'Hide photo', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_photo',
            'field_name' => $only_pro . 'pf_hide_photo',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_address',
            sanitize_text_field( __( 'Hide address', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_address',
            'field_name' => $only_pro . 'pf_hide_address',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_country',
            sanitize_text_field( __( 'Hide country', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_country',
            'field_name' => $only_pro . 'pf_hide_country',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_state',
            sanitize_text_field( __( 'Hide state', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_state',
            'field_name' => $only_pro . 'pf_hide_state',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_city',
            sanitize_text_field( __( 'Hide city', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_city',
            'field_name' => $only_pro . 'pf_hide_city',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_address_lines',
            sanitize_text_field( __( 'Hide address lines 1-4', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_address_lines',
            'field_name' => $only_pro . 'pf_hide_address_lines',
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
            add_settings_field(
                'contact-list-' . $only_pro . 'pf_hide_custom_field_' . $n,
                sanitize_text_field( __( 'Hide custom field', 'contact-list' ) . ' ' . $n ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_public_form',
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_custom_field_' . $n,
                'field_name' => $only_pro . 'pf_hide_custom_field_' . $n,
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_groups',
            sanitize_text_field( __( 'Hide groups', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_groups',
            'field_name' => $only_pro . 'pf_hide_groups',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'pf_hide_additional_info',
            sanitize_text_field( __( 'Hide additional information', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_public_form',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'pf_hide_additional_info',
            'field_name' => $only_pro . 'pf_hide_additional_info',
        )
        );
        add_settings_section(
            'contact-list_simple_list_settings',
            '',
            array( $this, 'contact_list_settings_simple_list_settings_callback' ),
            'contact-list'
        );
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'simple_list_modal',
                sanitize_text_field( __( 'Contact names are links to the contact card lightbox', 'contact-list' ) ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_simple_list_settings',
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'simple_list_modal',
                'field_name' => $only_pro . 'simple_list_modal',
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'simple_list_show_titles_for_columns',
            sanitize_text_field( __( 'Show titles for columns', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list_settings',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'simple_list_show_titles_for_columns',
            'field_name' => $only_pro . 'simple_list_show_titles_for_columns',
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
            sanitize_text_field( __( 'Hide job title', 'contact-list' ) ),
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
            sanitize_text_field( __( 'Hide email', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_email',
            'field_name' => 'simple_list_hide_email',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'simple_list_show_send_message',
            sanitize_text_field( __( 'Show send message -button', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'simple_list_show_send_message',
            'field_name' => $only_pro . 'simple_list_show_send_message',
        )
        );
        add_settings_field(
            'contact-list-simple_list_hide_phone_1',
            sanitize_text_field( __( 'Hide phone', 'contact-list' ) . ' 1' ),
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
            sanitize_text_field( __( 'Hide social media links', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_hide_some_links',
            'field_name' => 'simple_list_hide_some_links',
        )
        );
        add_settings_field(
            'contact-list-simple_list_show_city',
            sanitize_text_field( __( 'Show city', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-simple_list_show_city',
            'field_name' => 'simple_list_show_city',
        )
        );
        add_settings_field(
            'contact-list-' . $only_pro . 'simple_list_show_address_line_1',
            sanitize_text_field( __( 'Show address line 1', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'simple_list_show_address_line_1',
            'field_name' => $only_pro . 'simple_list_show_address_line_1',
        )
        );
        $custom_fields = [ 1 ];
        foreach ( $custom_fields as $n ) {
            add_settings_field(
                'contact-list-simple_list_show_custom_field_' . $n,
                sanitize_text_field( __( 'Show custom field', 'contact-list' ) . ' ' . $n ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_simple_list',
                array(
                'label_for'  => 'contact-list-simple_list_show_custom_field_' . $n,
                'field_name' => 'simple_list_show_custom_field_' . $n,
            )
            );
        }
        $custom_fields = [
            2,
            3,
            4,
            5,
            6
        ];
        foreach ( $custom_fields as $n ) {
            add_settings_field(
                'contact-list-' . $only_pro . 'simple_list_show_custom_field_' . $n,
                sanitize_text_field( __( 'Show custom field', 'contact-list' ) . ' ' . $n ),
                array( $this, 'checkbox_render' ),
                'contact-list',
                'contact-list_simple_list',
                array(
                'label_for'  => 'contact-list-' . $only_pro . 'simple_list_show_custom_field_' . $n,
                'field_name' => $only_pro . 'simple_list_show_custom_field_' . $n,
            )
            );
        }
        add_settings_field(
            'contact-list-' . $only_pro . 'simple_list_show_category',
            sanitize_text_field( __( 'Show category / group', 'contact-list' ) ),
            array( $this, 'checkbox_render' ),
            'contact-list',
            'contact-list_simple_list',
            array(
            'label_for'  => 'contact-list-' . $only_pro . 'simple_list_show_category',
            'field_name' => $only_pro . 'simple_list_show_category',
        )
        );
        $tab = 9;
        add_settings_section(
            'contact-list_tab_' . $tab,
            '',
            array( $this, 'contact_list_settings_tab_' . $tab . '_callback' ),
            'contact-list'
        );
        global  $wp_roles ;
        $roles = $wp_roles->get_names();
        foreach ( $roles as $key => $value ) {
            if ( $key && $value ) {
                add_settings_field(
                    'contact-list-' . $only_pro . 'can_edit_contacts_' . $key,
                    $value,
                    array( $this, 'checkbox_render' ),
                    'contact-list',
                    'contact-list_tab_' . $tab,
                    array(
                    'label_for'   => 'contact-list-' . $only_pro . 'can_edit_contacts_' . $key,
                    'field_name'  => $only_pro . 'can_edit_contacts_' . $key,
                    'placeholder' => '',
                )
                );
            }
        }
    }
    
    public function textarea_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            ?>    
  
      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'contact-list-setting-container-free';
                ?>
      <?php 
            }
            
            ?>
  
      <div class="contact-list-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">
  
        <?php 
            
            if ( $free ) {
                ?>
  
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=contact-list-pricing">
            <div class="contact-list-settings-pro-feature-overlay"><div><?php 
                echo  esc_html__( 'All Plans', 'contact-list' ) ;
                ?></div></div>
          </a>
  
        <?php 
            } else {
                ?>
  
          <div class="contact-list-setting">
  
              <textarea class="textarea-field" id="contact-list-<?php 
                echo  esc_attr( $field_name ) ;
                ?>" name="contact_list_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" placeholder="<?php 
                echo  ( $args['placeholder'] ? esc_attr( $args['placeholder'] ) : '' ) ;
                ?>"><?php 
                echo  ( isset( $options[$field_name] ) ? esc_html( $options[$field_name] ) : '' ) ;
                ?></textarea>
  
          </div>
          
        <?php 
            }
            
            ?>
      
      </div>
  
      <?php 
        }
    
    }
    
    public function contact_list_settings_tab_9_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-9">' ;
        echo  '<h2>' . esc_html__( 'Contact edit settings', 'contact-list' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'These settings are valid for shortcodes [contact_list edit=1] and [contact_list_simple edit=1].', 'contact-list' ) . '</p>' ;
        echo  '<p>' . esc_html__( 'The following user roles have the permissions to edit any contact:', 'contact-list' ) . '</p>' ;
    }
    
    public function additional_information_render( $args )
    {
        $options = get_option( 'contact_list_settings' );
        ?>
    <input type="text" class="input-field" id="contact-list-additional_information_title" name="contact_list_settings[additional_information_title]" value="<?php 
        echo  ( isset( $options['additional_information_title'] ) ? esc_attr( $options['additional_information_title'] ) : '' ) ;
        ?>" placeholder="<?php 
        echo  esc_attr__( 'Additional information', 'contact-list' ) ;
        ?>">
    <?php 
    }
    
    public function input_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            ?>

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'contact-list-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="contact-list-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=contact-list-pricing">
            <div class="contact-list-settings-pro-feature-overlay"><div><?php 
                echo  esc_html__( 'All Plans', 'contact-list' ) ;
                ?></div></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="contact-list-setting">
            <input type="text" class="input-field" id="contact-list-<?php 
                echo  esc_attr( $field_name ) ;
                ?>" name="contact_list_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" value="<?php 
                echo  ( isset( $options[$field_name] ) ? esc_attr( $options[$field_name] ) : '' ) ;
                ?>" placeholder="<?php 
                echo  ( $args['placeholder'] ? esc_attr( $args['placeholder'] ) : '' ) ;
                ?>">
          </div>
          
        <?php 
            }
            
            ?>
      
      </div>

      <?php 
        }
    
    }
    
    public function checkbox_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            ?>    

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
      <?php 
            $plan_required = 'All Plans';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'contact-list-setting-container-free';
                ?>
        
        <?php 
                
                if ( $field_name == '_FREE_simple_list_modal' ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( substr( $field_name, 0, strlen( '_FREE_can_edit_contacts_' ) ) === '_FREE_can_edit_contacts_' ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                } elseif ( $field_name == '_FREE_custom_field_1_hide_from_contact_card' || $field_name == '_FREE_custom_field_2_hide_from_contact_card' || $field_name == '_FREE_custom_field_3_hide_from_contact_card' || $field_name == '_FREE_custom_field_4_hide_from_contact_card' || $field_name == '_FREE_custom_field_5_hide_from_contact_card' || $field_name == '_FREE_custom_field_6_hide_from_contact_card' ) {
                    ?>
          <?php 
                    $plan_required = 'Professional';
                    ?>
        <?php 
                }
                
                ?>
        
      <?php 
            }
            
            ?>

      <div class="contact-list-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=contact-list-pricing">
            <div class="contact-list-settings-pro-feature-overlay"><div><?php 
                echo  esc_html( $plan_required ) ;
                ?></div></div>
          </a>
 
        <?php 
            } else {
                ?>
  
          <div class="contact-list-setting">
            <input type="checkbox" id="contact-list-<?php 
                echo  esc_attr( $field_name ) ;
                ?>" name="contact_list_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" <?php 
                echo  ( isset( $options[$field_name] ) ? 'checked="checked"' : '' ) ;
                ?>>
          </div>
          
        <?php 
            }
            
            ?>
      
      </div>

      <?php 
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
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="_cl_last_name"><?php 
            echo  ( isset( $options['_cl_last_name'] ) ? esc_html( $options['_cl_last_name'] ) : esc_html__( 'Last name', 'contact-list' ) ) ;
            ?></option>
          <option value="_cl_first_name" <?php 
            echo  ( $order_by == '_cl_first_name' ? 'selected' : '' ) ;
            ?>><?php 
            echo  ( isset( $options['_cl_first_name'] ) ? esc_html( $options['_cl_first_name'] ) : esc_html__( 'First name', 'contact-list' ) ) ;
            ?></option>
      </select>

      <div class="email-info">
        <b><?php 
            echo  esc_html__( 'Note:' ) ;
            ?></b> <?php 
            echo  esc_html__( 'If "First name" is selected, only the contacts with the first name defined are listed.', 'contact-list' ) ;
            ?>
      </div>

      <?php 
        }
    
    }
    
    public function icon_render( $args )
    {
        
        if ( $field_name = $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $sel = '';
            if ( isset( $options[$field_name] ) ) {
                $sel = $options[$field_name];
            }
            ?>

      <?php 
            $free = 0;
            ?>
      <?php 
            $free_class = '';
            ?>
    
      <?php 
            
            if ( substr( $field_name, 0, strlen( '_FREE_' ) ) === '_FREE_' ) {
                ?>
        <?php 
                $free = 1;
                ?>
        <?php 
                $free_class = 'contact-list-setting-container-free';
                ?>
      <?php 
            }
            
            ?>

      <div class="contact-list-setting-container <?php 
            echo  esc_attr( $free_class ) ;
            ?>">

        <?php 
            
            if ( $free ) {
                ?>
 
          <a href="<?php 
                echo  esc_url( get_admin_url() ) ;
                ?>options-general.php?page=contact-list-pricing">
            <div class="contact-list-settings-pro-feature-overlay"><div>All Plans</div></div>
          </a>
 
        <?php 
            } else {
                ?>
 
          <div class="contact-list-setting">

            <div class="contact-list-current-icon">
              <span><?php 
                echo  esc_html__( 'Current icon (Font Awesome ID):', 'contact-list' ) ;
                ?></span>
              <input type="text" name="contact_list_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" id="contact_list_settings[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" value="<?php 
                echo  esc_attr( $sel ) ;
                ?>" placeholder="<?php 
                echo  esc_html__( '(none)', 'contact-list' ) ;
                ?>">
            </div>

            <div class="contact-list-choose-icon">

              <span><?php 
                echo  esc_html__( 'Choose icon:', 'contact-list' ) ;
                ?></span>

              <?php 
                $checked = '';
                ?>
              <?php 
                $checked_set = 0;
                ?>

              <?php 
                
                if ( $sel == '' ) {
                    ?>
                <?php 
                    $checked = 'checked';
                    ?>
                <?php 
                    $checked_set = 1;
                    ?>
              <?php 
                }
                
                ?> 
 
              <label class="cl-icon-sel"><input type="radio" name="_CL_ICON_[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" value="" <?php 
                echo  esc_attr( $checked ) ;
                ?> onclick="document.getElementById('contact_list_settings[<?php 
                echo  esc_js( $field_name ) ;
                ?>]').value = '';"> <?php 
                echo  esc_html__( 'none', 'contact-list' ) ;
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
                    'caret-right',
                    'globe',
                    'cloud-download',
                    'check',
                    'check-circle',
                    'info',
                    'info-circle'
                ];
                ?>
              
              <?php 
                foreach ( $icons as $icon ) {
                    ?>
              
                <?php 
                    
                    if ( $sel == 'fa-' . $icon ) {
                        ?>
                  <?php 
                        $checked = 'checked';
                        ?>
                  <?php 
                        $checked_set = 1;
                        ?>
                <?php 
                    } else {
                        ?>
                  <?php 
                        $checked = '';
                        ?>
                <?php 
                    }
                    
                    ?>
              
                <label class="cl-icon-sel"><input type="radio" name="_CL_ICON_[<?php 
                    echo  esc_attr( $field_name ) ;
                    ?>]" value="fa-<?php 
                    echo  esc_attr( $icon ) ;
                    ?>" <?php 
                    echo  esc_attr( $checked ) ;
                    ?> onclick="document.getElementById('contact_list_settings[<?php 
                    echo  esc_js( $field_name ) ;
                    ?>]').value = this.value;"> <i class="fa fa-<?php 
                    echo  esc_attr( $icon ) ;
                    ?>" aria-hidden="true"></i></label>

              <?php 
                }
                ?>

              <?php 
                
                if ( !$checked_set ) {
                    ?>
                <?php 
                    $checked = 'checked';
                    ?>
              <?php 
                }
                
                ?>

              <label class="cl-icon-sel"><input type="radio" name="_CL_ICON_[<?php 
                echo  esc_attr( $field_name ) ;
                ?>]" value="fa-<?php 
                echo  esc_attr( $icon ) ;
                ?>" <?php 
                echo  esc_attr( $checked ) ;
                ?>> <?php 
                echo  esc_html__( 'Custom', 'contact-list' ) ;
                ?></label>

              <div style="margin-top: 5px; margin-bottom: 16px;">
              <?php 
                $url = 'https://fontawesome.com/v4.7/cheatsheet/';
                echo  sprintf( wp_kses(
                    /* translators: %s: link to file management */
                    __( 'All available icons are listed here <a href="%s" target="_blank">here</a>.', 'contact-list' ),
                    array(
                        'a' => array(
                        'href'   => array(),
                        'target' => array(),
                    ),
                    )
                ), esc_url( $url ) ) ;
                ?>
              </div>
              
            </div>

          </div>

        <?php 
            }
            
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
                $layout = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'Default list', 'contact-list' ) ;
            ?></option>
          <option value="2-cards-on-the-same-row" <?php 
            echo  ( $layout == '2-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '2 columns', 'contact-list' ) ;
            ?></option>
          <option value="3-cards-on-the-same-row" <?php 
            echo  ( $layout == '3-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '3 columns', 'contact-list' ) ;
            ?> (<?php 
            echo  esc_html__( 'without contact images', 'contact-list' ) ;
            ?>)</option>
          <option value="4-cards-on-the-same-row" <?php 
            echo  ( $layout == '4-cards-on-the-same-row' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( '4 columns', 'contact-list' ) ;
            ?> (<?php 
            echo  esc_html__( 'without contact images', 'contact-list' ) ;
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
                $card_background = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'Transparent', 'contact-list' ) ;
            ?></option>
          <option value="white" <?php 
            echo  ( $card_background == 'white' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'White', 'contact-list' ) ;
            ?></option>
          <option value="light_gray" <?php 
            echo  ( $card_background == 'light_gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Light gray', 'contact-list' ) ;
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
                $card_border = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'None', 'contact-list' ) ;
            ?></option>
          <option value="black" <?php 
            echo  ( $card_border == 'black' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Black', 'contact-list' ) ;
            ?></option>
          <option value="gray" <?php 
            echo  ( $card_border == 'gray' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Gray', 'contact-list' ) ;
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
                $card_image_style = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value=""><?php 
            echo  esc_html__( 'None', 'contact-list' ) ;
            ?></option>
          <option value="sepia" <?php 
            echo  ( $card_image_style == 'sepia' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Sepia', 'contact-list' ) ;
            ?></option>
          <option value="grayscale" <?php 
            echo  ( $card_image_style == 'grayscale' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Grayscale', 'contact-list' ) ;
            ?></option>
      </select>
      <?php 
        }
    
    }
    
    public function pagination_type_render( $args )
    {
        
        if ( $args['field_name'] ) {
            $options = get_option( 'contact_list_settings' );
            $val = '';
            if ( isset( $options[$args['field_name']] ) ) {
                $val = sanitize_text_field( $options[$args['field_name']] );
            }
            ?>    
      <select name="contact_list_settings[<?php 
            echo  esc_attr( $args['field_name'] ) ;
            ?>]">
          <option value="" <?php 
            echo  ( $val == '' ? 'original' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Original', 'contact-list' ) ;
            ?></option>
          <option value="improved" <?php 
            echo  ( $val == 'improved' ? 'selected' : '' ) ;
            ?>><?php 
            echo  esc_html__( 'Improved', 'contact-list' ) ;
            ?></option>
      </select>
  
      <div class="email-info">
        <?php 
            echo  esc_html__( 'Original type means that the page links are in the following url format:', 'contact-list' ) ;
            ?><br />
        <strong>sample-page-name/page/1/, sample-page-name/page/2/, ...</strong><br /><br />
        <?php 
            echo  esc_html__( 'Improved type works via GET parameters:', 'contact-list' ) ;
            ?><br />
        <strong>sample-page-name/?_page=1, sample-page-name/?_page=2, ...</strong><br /><br />
        <?php 
            echo  esc_html__( 'Improved type must be used, if the shortcode is on the front page or various other types of pages of the site. If you are getting 404 from the page links, use the Improved type.', 'contact-list' ) ;
            ?><br />
      </div>
  
      <?php 
        }
    
    }
    
    public function contact_list_settings_general_section_callback()
    {
        echo  '<div class="contact-list-how-to-get-started">' ;
        echo  '<h2>' . esc_html__( 'How to get started', 'contact-list' ) . '</h2>' ;
        echo  '<ol>' ;
        echo  '<li><span>' ;
        $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=contact' );
        echo  sprintf( wp_kses(
            /* translators: %s: link to contact management */
            __( 'Insert contacts from the <a href="%s" target="_blank">contact management</a>.', 'contact-list' ),
            array(
                'a' => array(
                'href'   => array(),
                'target' => array(),
            ),
            )
        ), esc_url( $url ) ) ;
        echo  '</span></li>' ;
        echo  '<li><span>' ;
        echo  wp_kses( __( 'Insert the shortcode <span class="contact-list-mini-shortcode">[contact_list]</span> or <span class="contact-list-mini-shortcode">[contact_list_simple]</span> to the content editor of any page or post.', 'contact-list' ), array(
            'span' => array(
            'class' => array(),
        ),
        ) ) ;
        echo  '</span></li>' ;
        echo  '</ol>' ;
        echo  '</div>' ;
    }
    
    public function contact_list_settings_tab_2_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-2">' ;
    }
    
    public function contact_list_settings_tab_3_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-3">' ;
    }
    
    public function contact_list_settings_tab_4_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-4">' ;
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . esc_html__( 'These settings are for this form in the front-end:', 'contact-list' ) . '<hr class="clear" /><img src="' . esc_url( plugins_url( '../img/search-form-sample.png', __FILE__ ) ) . '" style="box-shadow: 2px 2px 4px #bbb;" />' . '</p>' ;
    }
    
    public function contact_list_settings_tab_5_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-5">' ;
        echo  '<p>' . esc_html__( 'To select any Font Awesome icon, copy the icon ID to the current icon field from here:', 'contact-list' ) . ' ' . '<a href="https://fontawesome.com/v4.7/cheatsheet/" target="_blank">https://fontawesome.com/v4.7/cheatsheet/</a>' . '</p>' ;
    }
    
    public function contact_list_settings_section_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-6">' ;
        echo  '<p>' . esc_html__( 'You may enter alternative titles and texts here. The values defined here will override the default values.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_admin_form_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-7">' ;
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . esc_html__( 'Admin form elements', 'contact-list' ) . '</p>' ;
        echo  '<p>' . esc_html__( 'You may customize the admin form (the one displayed in the WP admin area and the front-end editor) using these settings.', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_public_form_callback()
    {
        echo  '<h2 style="margin-top: 20px;">' . esc_html__( 'Public form elements', 'contact-list' ) . '</h2>' ;
        echo  '<p>' . esc_html__( 'You may customize the public form (the one displayed using the [contact_list_form] shortcode) using these settings.', 'contact-list' ) . '</p>' ;
        echo  '<p>' . esc_html__( 'These choices also affect the form which is used by contacts themselves to update their info (by features "request update" and "permanent update URL")', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_simple_list_settings_callback()
    {
        echo  '</div>' ;
        echo  '<div class="contact-list-settings-tab-8">' ;
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . esc_html__( 'General settings', 'contact-list' ) . '</p>' ;
    }
    
    public function contact_list_settings_simple_list_callback()
    {
        echo  '<p style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">' . esc_html__( 'Fields in simple list', 'contact-list' ) . '</p>' ;
    }
    
    public function settings_page()
    {
        ?>

    <form action="options.php" method="post" class="contact-list-settings-form">

      <h1><?php 
        echo  esc_html__( 'Contact List Settings', 'contact-list' ) ;
        ?></h1>

      <div class="contact-list-settings-tabs-container">
        <ul class="contact-list-settings-tabs">
          <li class="contact-list-settings-tab-1-title" data-settings-container="contact-list-settings-tab-1"><span><?php 
        echo  esc_html__( 'General settings', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-2-title" data-settings-container="contact-list-settings-tab-2"><span><?php 
        echo  esc_html__( 'Layout', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-3-title" data-settings-container="contact-list-settings-tab-3"><span><?php 
        echo  esc_html__( 'reCAPTCHA and email', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-4-title" data-settings-container="contact-list-settings-tab-4"><span><?php 
        echo  esc_html__( 'Search form', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-5-title" data-settings-container="contact-list-settings-tab-5"><span><?php 
        echo  esc_html__( 'Custom fields', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-6-title" data-settings-container="contact-list-settings-tab-6"><span><?php 
        echo  esc_html__( 'Field titles and texts', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-7-title" data-settings-container="contact-list-settings-tab-7"><span><?php 
        echo  esc_html__( 'Hide / show form elements', 'contact-list' ) ;
        ?></span></li>
          <li class="contact-list-settings-tab-8-title" data-settings-container="contact-list-settings-tab-8"><span><?php 
        echo  esc_html__( 'Simple list', 'contact-list' ) ;
        ?></span></li>

          <?php 
        
        if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial( 'pro' ) || cl_fs()->is_plan_or_trial( 'business' ) ) {
            ?>
            <li class="contact-list-settings-tab-9-title" data-settings-container="contact-list-settings-tab-9"><span><?php 
            echo  esc_html__( 'Contact edit', 'contact-list' ) ;
            ?></span></li>
          <?php 
        }
        
        ?>
          
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
        $permalink = 'options-general.php?page=contact-list';
        $menuitem = 'edit.php?post_type=' . CONTACT_LIST_CPT;
        $submenu[$menuitem][] = array( sanitize_text_field( __( 'Settings', 'contact-list' ) ) . '&nbsp;&nbsp;➤', 'manage_options', esc_url_raw( get_admin_url() . $permalink ) );
    }
    
    public function add_upgrade_link()
    {
        global  $submenu ;
        $permalink = 'options-general.php?page=contact-list-pricing';
        $menuitem = 'edit.php?post_type=' . CONTACT_LIST_CPT;
        $submenu[$menuitem][] = array(
            sanitize_text_field( __( 'Upgrade', 'contact-list' ) ) . '&nbsp;&nbsp;➤',
            'manage_options',
            esc_url_raw( get_admin_url() . $permalink ),
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
            // Table for mail log
            $table_name = $wpdb->prefix . 'cl_sent_mail_log';
            $wpdb->query( "CREATE TABLE IF NOT EXISTS " . $table_name . " (\n    \t  id              BIGINT(20) NOT NULL auto_increment,\n    \t  msg_id          VARCHAR(255) NOT NULL,\n    \t  sender_email    VARCHAR(255) NOT NULL,\n    \t  sender_name     VARCHAR(255) NOT NULL,\n    \t  recipient_email VARCHAR(255) NOT NULL,\n    \t  reply_to        VARCHAR(255) NOT NULL,\n    \t  msg_type        VARCHAR(255) NOT NULL,\n    \t  subject         VARCHAR(255) NOT NULL,\n    \t  response        VARCHAR(255) NOT NULL,\n    \t  mail_cnt        MEDIUMINT NOT NULL,\n    \t  report          TEXT NOT NULL,\n    \t  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n    \t  PRIMARY KEY (id)\n    \t) " . $charset_collate . ";" );
            // Table for debug data and general log
            $table_name_log = $wpdb->prefix . 'contact_list_log';
            $wpdb->query( "CREATE TABLE IF NOT EXISTS " . $table_name_log . " (\n        id              BIGINT(20) NOT NULL auto_increment,\n        title           VARCHAR(255) NOT NULL,\n        message         TEXT NOT NULL,\n        created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n        PRIMARY KEY (id)\n      ) " . $charset_collate . ";" );
            update_option( 'contact_list_version', CONTACT_LIST_VERSION );
            ContactListHelpers::writeLog( 'Plugin updated to version ' . CONTACT_LIST_VERSION, '' );
        }
    
    }

}