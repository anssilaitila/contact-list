<?php

class ContactListForm
{
    public static function shortcodeContactListFormMarkup()
    {
        $html = '';
        $html .= '<div class="pro-feature">' . __( 'This feature is available in the Pro version.' ) . '</div>';
        return $html;
    }

}