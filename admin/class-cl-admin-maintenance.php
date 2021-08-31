<?php

class ContactListAdminMaintenance
{
    public function actions()
    {
        $rand_code = sanitize_text_field( md5( uniqid( rand(), true ) ) );
        if ( !get_option( 'contact-list-sc' ) ) {
            add_option(
                'contact-list-sc',
                $rand_code,
                '',
                'yes'
            );
        }
        $s = get_option( 'contact_list_settings' );
        
        if ( $s === false ) {
            $default_settings = [
                'layout'                         => '2-cards-on-the-same-row',
                'card_border'                    => 'black',
                'contact_image_style'            => 'sepia',
                'contact_image_shadow'           => 'on',
                'card_background'                => 'white',
                'show_country_select_in_search'  => 'on',
                'show_state_select_in_search'    => 'on',
                'show_city_select_in_search'     => 'on',
                'show_category_select_in_search' => 'on',
                'show_contact_images_always'     => 'on',
                'pagination_type'                => 'improved',
            ];
            add_option( 'contact_list_settings', $default_settings );
        }
    
    }

}