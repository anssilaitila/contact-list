<?php

function proFeatureMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('This feature is available in the Pro version.', 'contact-list') . '</span>';
    $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
    $html .= '</div>';
    
    return $html;
  
}

function proFeatureSettingsMarkup() {

    $html = '';
  
    $html .= '<div class="pro-feature">';
    $html .= '<span>' . __('More settings available in the Pro version.', 'contact-list') . '</span>';
    $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . __('Upgrade here', 'contact-list') . '</a>';
    $html .= '</div>';
    
    return $html;
  
}

function listAllContactsForSearchMarkup($wp_query) {

  $html = '';

  $html .= '<div id="contact-list-search">';
  
  $html .= '<ul id="all-contacts" class="contact-list-all-contacts-list">';
  
  if ($wp_query->have_posts()):
  
    while ($wp_query->have_posts()): $wp_query->the_post();
  
      $id = get_the_id();
      $html .= singleContactMarkup($id, 1);
  
    endwhile;
  endif;
  
  $html .= '</ul>';
  
  $html .= '<div id="contact-list-nothing-found">';
  $html .= __('No contacts found.', 'contact-list');
  $html .= '</div>';
  
  $html .= '</div>';
  
  wp_reset_postdata();
  
  return $html;

}

function contactListMarkup($wp_query, $include_children = 0) {

  $html = '';
  
  $html .= '<div id="contact-list-search">';
  
  $html .= '<ul id="all-contacts">';
  
  if ($wp_query->have_posts()):
  
    while ($wp_query->have_posts()): $wp_query->the_post();

      $id = get_the_id();
      $html .= singleContactMarkup($id);
  
    endwhile;
  endif;
  
  $html .= '</ul>';
  
  $html .= '<div id="contact-list-nothing-found">';
  $html .= __('No contacts found.', 'contact-list');
  $html .= '</div>';
  
  $html .= '</div>';

  wp_reset_postdata();
  
  return $html;
  
}

function singleContactMarkup($id, $showGroups = 0) {
  
  $s = get_option('contact_list_settings');
  $c = get_post_custom($id);
  
  $html = '';
  
  $html .= '<li>';
  $html .= '<div class="contact-list-contact-container">';
  $html .= '<div class="contact-list-main-elements">';

  $featured_img_url = get_the_post_thumbnail_url($id, 'contact-list-contact'); 
  
  if ($featured_img_url) {
    $html .= '<div class="contact-list-image-container"><div class="contact-list-image"><img src="' . $featured_img_url . '" /></div></div>';
  }

  if ($showGroups) {  
    $terms = get_the_terms($id, 'contact-group');
    
    if ($terms) {
      $html .= '<div class="contact-list-contact-groups">';
      foreach ($terms as $term) {
        $html .=  '<span>' . $term->name . '</span>';
      }
      $html .= '</div>';
    }
  }
  
  $html .= '<h3>' . (isset($c['_cl_first_name']) ? $c['_cl_first_name'][0] . ' ' : '') . $c['_cl_last_name'][0] . '</h3>';
  
  if (isset($c['_cl_job_title'])) {
    $html .= '<span class="contact-list-job-title">' . $c['_cl_job_title'][0] . '</span>';
  }
  
  if (isset($c['_cl_email'])) {
  
    $mailto = $c['_cl_email'][0];
    $mailto_obs = '';
    for ($i = 0; $i < strlen($mailto); $i++) {
      $mailto_obs .= '&#' . ord($mailto[$i]) . ';';
    }
  
    $html .= '<span class="contact-list-email">' . ($c['_cl_email'][0] ? '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>' : '') . '</span>';
  
  }
  
  if (isset($c['_cl_phone'])) {
    $phone_href = preg_replace('/[^0-9]/', '', $c['_cl_phone'][0]);
    $html .= '<span class="contact-list-phone"><a href="tel:' . $phone_href . '">' . $c['_cl_phone'][0] . '</a></span>';
  }
  
  if (isset($c['_cl_address_line_1'])) {
    $html .= '<div class="contact-list-address">';
  
    if (!isset($s['hide_address_title'])) {
      $html .= '<span class="contact-list-address-title">' . (isset($s['address_title']) && $s['address_title'] ? $s['address_title'] : __('Address', 'contact-list')) . '</span>';
    }
  
    $html .= '<span class="contact-list-address-line-1">' . $c['_cl_address_line_1'][0] . '</span>';
    if (isset($c['_cl_address_line_2'])) {
      $html .= '<span class="contact-list-address-line-2">' . $c['_cl_address_line_2'][0] . '</span>';
    }
    if (isset($c['_cl_address_line_3'])) {
      $html .= '<span class="contact-list-address-line-3">' . $c['_cl_address_line_3'][0] . '</span>';
    }
    if (isset($c['_cl_address_line_4'])) {
      $html .= '<span class="contact-list-address-line-4">' . $c['_cl_address_line_4'][0] . '</span>';
    }
    $html .= '</div>';
  }
  
  if (isset($c['_cl_custom_field_1'])) {
    $html .= '<div class="contact-list-custom-field-1">' . (isset($s['custom_field_1_title']) && $s['custom_field_1_title'] ? '<strong>' . $s['custom_field_1_title'] . '</strong>' : '') . $c['_cl_custom_field_1'][0] . '</div>';
  }
  if (isset($c['_cl_custom_field_2'])) {
    $html .= '<div class="contact-list-custom-field-2">' . (isset($s['custom_field_2_title']) && $s['custom_field_2_title'] ? '<strong>' . $s['custom_field_2_title'] . '</strong>' : '') . $c['_cl_custom_field_2'][0] . '</div>';
  }
  if (isset($c['_cl_custom_field_3'])) {
    $html .= '<div class="contact-list-custom-field-3">' . (isset($s['custom_field_3_title']) && $s['custom_field_3_title'] ? '<strong>' . $s['custom_field_3_title'] . '</strong>' : '') . $c['_cl_custom_field_3'][0] . '</div>';
  }
  if (isset($c['_cl_custom_field_4'])) {
    $html .= '<div class="contact-list-custom-field-4">' . (isset($s['custom_field_4_title']) && $s['custom_field_4_title'] ? '<strong>' . $s['custom_field_4_title'] . '</strong>' : '') . $c['_cl_custom_field_4'][0] . '</div>';
  }
  
  if (isset($c['_cl_description'])) {
    $html .= '<div class="contact-list-description">';
  
    if (!isset($s['hide_additional_info_title'])) {
      $html .= '<span class="contact-list-description-title">' . (isset($s['additional_info_title']) && $s['additional_info_title'] ? $s['additional_info_title'] : __('Additional information', 'contact-list')) . '</span>';
    }
  
    $html .= $c['_cl_description'][0] . '</div>';
  }
  
  $html .= '</div>';
  
  $html .= '<div class="contact-list-some-elements">';
  
  if (isset($c['_cl_facebook_url'])) {
    $html .= $c['_cl_facebook_url'][0] ? '<a href="' . $c['_cl_facebook_url'][0] . '" target="_blank"><img src="' . plugins_url('../img/facebook.png', __FILE__) . '" width="28" height="28" /></a>' : '';
  }
  
  if (isset($c['_cl_twitter_url'])) {
    $html .= $c['_cl_twitter_url'][0] ? '<a href="' . $c['_cl_twitter_url'][0] . '" target="_blank"><img src="' . plugins_url('../img/twitter.png', __FILE__) . '" width="28" height="28" /></a>' : '';
  }
  
  if (isset($c['_cl_linkedin_url'])) {
    $html .= $c['_cl_linkedin_url'][0] ? '<a href="' . $c['_cl_linkedin_url'][0] . '" target="_blank"><img src="'  . plugins_url('../img/linkedin.png', __FILE__) . '" width="37" height="28" /></a>' : '';
  }
  
  $html .= '<hr class="clear" /></div>';
  
  $html .= '<hr class="clear" />';
  $html .= '</div>';
  $html .= '</li>';
  
  return $html;

}  
