<?php

class ContactListAdminList {

  function contact_custom_columns($defaults) {

    $options = get_option('contact_list_settings');

    $defaults['contact_id'] = 'ID';

    if (!isset($options['af_hide_first_name'])) {
      $defaults['first_name'] = isset($options['first_name_title']) && $options['first_name_title'] ? $options['first_name_title'] : __('First name', 'contact-list');
    }

    $defaults['last_name'] = isset($options['last_name_title']) && $options['last_name_title'] ? $options['last_name_title'] : __('Last name', 'contact-list');
    $defaults['menu_order'] = __('Order');

    if (!isset($options['af_hide_job_title'])) {
      $defaults['job_title'] = isset($options['job_title_title']) && $options['job_title_title'] ? $options['job_title_title'] : __('Job title', 'contact-list');
    }

    if (!isset($options['af_hide_email'])) {
      $defaults['email'] = __('Email', 'contact-list');
    }

    if (!isset($options['af_hide_phone'])) {
      $defaults['phone'] = isset($options['phone_title']) && $options['phone_title'] ? $options['phone_title'] : __('Phone', 'contact-list');
    }
    
    if (!isset($options['af_hide_linkedin_url'])) {
      $defaults['linkedin_url'] = isset($options['linkedin_url_title']) && $options['linkedin_url_title'] ? $options['linkedin_url_title'] : '<img src="'  . plugins_url('../img/linkedin.png', __FILE__) . '" width="37" height="28" alt="" />';
    }
    
    if (!isset($options['af_hide_twitter_url'])) {
      $defaults['twitter_url']  = isset($options['twitter_url_title']) && $options['twitter_url_title'] ? $options['twitter_url_title'] : '<img src="' . plugins_url('../img/twitter.png', __FILE__) . '" width="28" height="28" alt="" />';
    }
    
    if (!isset($options['af_hide_facebook_url'])) {
      $defaults['facebook_url'] = isset($options['facebook_url_title']) && $options['facebook_url_title'] ? $options['facebook_url_title'] : '<img src="' . plugins_url('../img/facebook.png', __FILE__) . '" width="28" height="28" alt="" />';
    }

    if (!isset($options['af_hide_instagram_url'])) {
      $defaults['instagram_url'] = isset($options['instagram_url_title']) && $options['instagram_url_title'] ? $options['instagram_url_title'] : '<img src="' . plugins_url('../img/instagram.png', __FILE__) . '" width="28" height="28" alt="" />';
    }

    return $defaults;

  }

  function contact_custom_columns_content($column_name, $post_ID) {

    global $post;

    if ($column_name == 'contact_id') {
      echo $post_ID;
    }
    if ($column_name == 'first_name') {
      echo get_post_meta($post_ID, '_cl_first_name', true) . '';
    }
    if ($column_name == 'last_name') {
      echo get_post_meta($post_ID, '_cl_last_name', true);
      echo '<span class="contact-list-shortcode-admin-list contact-list-shortcode-admin-list-contact contact-list-shortcode-' . $post_ID . '" title="[contact_list contact=' . $post_ID . ']">[contact_list contact=' . $post_ID . ']</span>';
      echo '<button class="contact-list-copy contact-list-copy-admin-list" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-' . $post_ID . '">' . __('Copy', 'contact-list') . '</button>';
    }
    if ($column_name == 'menu_order') {
      echo $post->menu_order;
    }
    if ($column_name == 'job_title') {
      echo get_post_meta($post_ID, '_cl_job_title', true);
    }
    if ($column_name == 'email') {
      $email = get_post_meta($post_ID, '_cl_email', true);

      if ($email) {
        echo $email;

        echo '<button class="contact-list-request-update contact-list-request-update-' . $post_ID . '" data-contact-id="' . $post_ID . '">' . esc_html__('Request update') . '</button><div class="contact-list-request-update-info contact-list-request-update-info-' . $post_ID . '"></div>';
      }

    }
    if ($column_name == 'phone') {
      echo get_post_meta($post_ID, '_cl_phone', true);
    }
    if ($column_name == 'linkedin_url') {
      
      if (get_post_meta($post_ID, '_cl_linkedin_url', true)) {
        echo '<div style="text-align: center;">x</div>';
      }
    }
    if ($column_name == 'twitter_url') {

      if (get_post_meta($post_ID, '_cl_twitter_url', true)) {
        echo '<div style="text-align: center;">x</div>';
      }        
    }
    if ($column_name == 'facebook_url') {

      if (get_post_meta($post_ID, '_cl_facebook_url', true)) {
        echo '<div style="text-align: center;">x</div>';
      }
    }
    if ($column_name == 'instagram_url') {

      if (get_post_meta($post_ID, '_cl_instagram_url', true)) {
        echo '<div style="text-align: center;">x</div>';
      }
    }
  }

  function set_custom_contact_list_sortable_columns($columns) {
    $columns['last_name']  = 'last_name';
    $columns['menu_order'] = 'menu_order';
    return $columns;
  }

  function contact_list_custom_orderby($query) {

    if (!is_admin()) {
      return;
    }

    $orderby = $query->get('orderby');
    $order = $query->get('order') == 'asc' ? 'ASC' : 'DESC';

    if ($orderby == 'last_name') {

      $query->set('meta_query', array(
        'relation' => 'AND',
        'last_name_clause' => array(
          'key' => '_cl_last_name',
          'compare' => 'EXISTS',
        )
      ));

      $query->set('orderby', array(
        'last_name_clause' => $order,
        'title' => $order,
      ));

    }
  }

}
