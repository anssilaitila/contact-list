<?php

class ContactListPublicLoad {
  
  public function public_inline_styles() {
  
    $styles = $this->get_inline_styles();
    wp_add_inline_style( 'contact-list', $styles );
    
  }
  
  public function get_inline_styles() {
  
    $s = get_option('contact_list_settings');

    $out = '';
    
    if (isset($s['show_contact_images_always'])) {
    
      $out .= 'body .contact-list-container.contact-list-3-cards-on-the-same-row .contact-list-image img { display: inline-block; }';
      $out .= 'body .contact-list-container.contact-list-4-cards-on-the-same-row .contact-list-image img { display: inline-block; }';
      
    }
  
    return $out;
  
  }

}

