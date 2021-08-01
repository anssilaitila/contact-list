<?php

class ContactListFrontendContactEdit
{
    public static function editContact( $contact_id )
    {
        $s = get_option( 'contact_list_settings' );
        $can_edit_contacts = 0;
        $html = '';
        return $html;
    }
    
    public function contact_update( $request )
    {
        return $request;
    }

}