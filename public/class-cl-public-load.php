<?php

class ContactListPublicLoad {

  public function public_inline_scripts() {
  
    $inline_js = $this->get_inline_scripts();
    wp_add_inline_script( 'contact-list', $inline_js );
    
  }

  public function get_inline_scripts() {

    $js = '';
  
    $js .= "jQuery(document).ready(function($) {

      if (typeof ajaxurl === 'undefined') {
        ajaxurl = '" . esc_url_raw( admin_url('admin-ajax.php') ) . "'; // get ajaxurl
      }

    });";
    
    return $js;
  
  }
  
  public function public_inline_styles() {
  
    $styles = $this->get_inline_styles();
    wp_add_inline_style( 'contact-list', $styles );
    
  }
  
  public function get_inline_styles() {
  
    $s = get_option('contact_list_settings');

    $css = '';
    
    if (isset($s['show_contact_images_always'])) {
    
      $css .= 'body .contact-list-container.contact-list-3-cards-on-the-same-row .contact-list-image img { display: inline-block; }';
      $css .= 'body .contact-list-container.contact-list-4-cards-on-the-same-row .contact-list-image img { display: inline-block; }';
      
    }

    if (isset($s['card_background']) && $s['card_background']) {
    
      $css .= '.contact-list-container #contact-list-search ul li { margin-bottom: 5px; }';
    
      if ($s['card_background'] == 'white') {
        $css .= '.contact-list-contact-container { background: #fff; }';
      } elseif ($s['card_background'] == 'light_gray') {
        $css .= '.contact-list-contact-container { background: #f7f7f7; }';
      }
    }
    
    if (isset($s['card_border']) && $s['card_border']) {
    
      if ($s['card_border'] == 'black') {
        $css .= '.contact-list-contact-container { border: 1px solid #333; border-radius: 10px; padding: 10px; }';
      } elseif ($s['card_border'] == 'gray') {
        $css .= '.contact-list-contact-container { border: 1px solid #bbb; border-radius: 10px; padding: 10px; }';
      }
    }
        
    if (isset($s['card_height']) && $s['card_height']) {
      
      $card_height = 380;
    
      if (isset($s['card_height']) && $s['card_height']) {
        $card_height = intval( $s['card_height'] );
      }
      
      $css .= '.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . intval( $card_height ) . 'px; }';  
      $css .= '.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . intval( $card_height ) . 'px; }';  
      $css .= '.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . intval( $card_height ) . 'px; }';  
    }

    $css .= ' @media (max-width: 820px) { .contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } }';  
    $css .= ' @media (max-width: 820px) { .contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } }';  
    $css .= ' @media (max-width: 820px) { .contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } }';  
  
    return $css;
  
  }

}

