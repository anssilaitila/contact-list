<?php

class ContactListAdminInlineStyles {

  public function inline_styles() {

    $s = get_option('contact_list_settings');

    echo '<style>';
    echo '#menu-posts-contact > ul > li:nth-of-type(5):before { ';
    echo 'display: block;';
    echo "content: '" . __('Tools', 'contact-list') . "';";
    echo 'color: #fff;';
    echo 'padding: 7px 12px 3px 12px;';
    echo 'border-bottom: 1px solid rgb(90, 90, 90);';
    echo '}';
    echo '@media (max-width: 782px) {';
    echo '#menu-posts-contact > ul > li:nth-of-type(5):before {';
    echo 'padding-left: 20px;';
    echo 'padding-bottom: 7px;';
    echo 'font-size: 15px;';
    echo '}';
    echo '}';

    if (isset($s['disable_mail_log'])) {
      $num_1 = 8;
      $num_2 = 9;
    } else {
      $num_1 = 9;
      $num_2 = 10;
    }

    echo '#menu-posts-contact > ul > li:nth-of-type(' . $num_1 . ') {';
    echo 'border-bottom: 1px solid rgb(110, 110, 110);';      
    echo '}';
    echo '#menu-posts-contact > ul > li:nth-of-type(' . $num_2 . ') {';
    echo 'padding-top: 7px;';
    echo '}';
    echo '</style>';

  }

}
