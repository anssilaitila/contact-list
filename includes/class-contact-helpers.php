<?php

class ContactListContactHelpers {
    public static function get_fields() {
        $s = get_option( 'contact_list_settings' );
        $fields = array(
            array(
                'name'  => 'name_prefix',
                'title' => sanitize_text_field( __( 'Name prefix', 'contact-list' ) ),
            ),
            array(
                'name'  => 'first_name',
                'title' => sanitize_text_field( __( 'First name', 'contact-list' ) ),
            ),
            array(
                'name'  => 'middle_name',
                'title' => sanitize_text_field( __( 'Middle name', 'contact-list' ) ),
            ),
            array(
                'name'  => 'last_name',
                'title' => sanitize_text_field( __( 'Last Name', 'contact-list' ) ),
            ),
            array(
                'name'  => 'name_suffix',
                'title' => sanitize_text_field( __( 'Name suffix', 'contact-list' ) ),
            ),
            array(
                'name'  => 'job_title',
                'title' => sanitize_text_field( __( 'Job title', 'contact-list' ) ),
            ),
            array(
                'name'  => 'linkedin_url',
                'title' => sanitize_text_field( __( 'LinkedIn URL', 'contact-list' ) ),
            ),
            array(
                'name'  => 'twitter_url',
                'title' => sanitize_text_field( __( 'X URL', 'contact-list' ) ),
            ),
            array(
                'name'  => 'facebook_url',
                'title' => sanitize_text_field( __( 'Facebook URL', 'contact-list' ) ),
            ),
            array(
                'name'  => 'instagram_url',
                'title' => sanitize_text_field( __( 'Instagram URL', 'contact-list' ) ),
            ),
            array(
                'name'  => 'phone',
                'title' => sanitize_text_field( __( 'Phone', 'contact-list' ) ),
            ),
            array(
                'name'  => 'phone_2',
                'title' => sanitize_text_field( __( 'Phone 2', 'contact-list' ) ),
            ),
            array(
                'name'  => 'phone_3',
                'title' => sanitize_text_field( __( 'Phone 3', 'contact-list' ) ),
            ),
            array(
                'name'  => 'email',
                'title' => sanitize_text_field( __( 'Email', 'contact-list' ) ),
            ),
            array(
                'name'  => 'notify_emails',
                'title' => sanitize_text_field( __( 'Notify emails', 'contact-list' ) ),
            ),
            array(
                'name'  => 'country',
                'title' => sanitize_text_field( __( 'Country', 'contact-list' ) ),
            ),
            array(
                'name'  => 'state',
                'title' => sanitize_text_field( __( 'State', 'contact-list' ) ),
            ),
            array(
                'name'  => 'city',
                'title' => sanitize_text_field( __( 'City', 'contact-list' ) ),
            ),
            array(
                'name'  => 'zip_code',
                'title' => sanitize_text_field( __( 'ZIP Code', 'contact-list' ) ),
            ),
            array(
                'name'  => 'address_line_1',
                'title' => sanitize_text_field( __( 'Address Line 1', 'contact-list' ) ),
            ),
            array(
                'name'  => 'address_line_2',
                'title' => sanitize_text_field( __( 'Address Line 2', 'contact-list' ) ),
            ),
            array(
                'name'  => 'address_line_3',
                'title' => sanitize_text_field( __( 'Address Line 3', 'contact-list' ) ),
            ),
            array(
                'name'  => 'address_line_4',
                'title' => sanitize_text_field( __( 'Address Line 4', 'contact-list' ) ),
            ),
            array(
                'name'  => 'custom_url_1',
                'title' => sanitize_text_field( __( 'Custom URL 1', 'contact-list' ) ),
            ),
            array(
                'name'  => 'custom_url_2',
                'title' => sanitize_text_field( __( 'Custom URL 2', 'contact-list' ) ),
            ),
            array(
                'name'  => 'map_iframe',
                'title' => sanitize_text_field( __( 'Google Maps iframe code', 'contact-list' ) ),
            ),
            array(
                'name'  => 'description',
                'title' => sanitize_text_field( __( 'Additional information', 'contact-list' ) ),
            ),
            array(
                'name'  => 'groups',
                'title' => sanitize_text_field( __( 'Group names separated by the character "|", like so: Cats|Dogs|Parrots', 'contact-list' ) ),
            ),
            array(
                'name'  => 'featured_image_id',
                'title' => sanitize_text_field( __( 'Image ID (from media library)', 'contact-list' ) ),
            ),
            array(
                'name'  => 'featured_image_filename',
                'title' => sanitize_text_field( __( 'Filename of image', 'contact-list' ) ),
            )
        );
        $custom_fields_cnt = 20 + 1;
        for ($n = 1; $n < $custom_fields_cnt; $n++) {
            $fields[] = array(
                'name'  => 'custom_field_' . $n,
                'title' => sanitize_text_field( __( 'Custom field', 'contact-list' ) . ' ' . $n ),
            );
        }
        return $fields;
    }

    public static function get_original_import_fields() {
        $fields = [
            'first_name',
            'last_name',
            'job_title',
            'email',
            'phone',
            'linkedin_url',
            'twitter_url',
            'facebook_url',
            'address_line_1',
            'address_line_2',
            'address_line_3',
            'address_line_4',
            'custom_field_1',
            'custom_field_2',
            'custom_field_3',
            'custom_field_4',
            'custom_field_5',
            'custom_field_6',
            'groups',
            'country',
            'state',
            'city',
            'zip_code',
            'instagram_url',
            'phone_2',
            'phone_3',
            'name_prefix',
            'middle_name',
            'name_suffix',
            'featured_image_id',
            'featured_image_filename',
            'custom_url_1',
            'custom_url_2'
        ];
        return $fields;
    }

    public static function getTitleByName( $name ) {
        $array = ContactListContactHelpers::get_fields();
        foreach ( $array as $item ) {
            if ( $item['name'] === $name ) {
                return $item['title'];
            }
        }
        return null;
    }

}
