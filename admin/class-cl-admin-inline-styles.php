<?php

class ContactListAdminInlineStyles {

  public function inline_styles() {

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
    echo '#menu-posts-contact > ul > li:nth-of-type(9) {';
    echo 'border-bottom: 1px solid rgb(110, 110, 110);';      
    echo '}';
    echo '#menu-posts-contact > ul > li:nth-of-type(10) {';
    echo 'padding-top: 7px;';
    echo '}';
    echo '</style>';

  }

}
