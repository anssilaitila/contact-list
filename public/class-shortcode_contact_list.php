<?php

class ShortcodeContactList {

  public static function shortcodeContactListMarkup($atts) {
  
    $s = get_option('contact_list_settings');
    
    $layout = '';
    
    if (isset($atts['layout'])) {
      $layout = $atts['layout'];
    } elseif (isset($s['layout']) && $s['layout']) {
      $layout = $s['layout'];
    }
    
    $html = '';
  
    $html .= ContactListHelpers::initLayout($s);
  
    if (!isset($s['hide_send_email_button'])) {
      $html .= ContactListHelpers::modalSendMessageMarkup();
    }
    
    $html .= '<div class="contact-list-container ' . ($layout ? 'contact-list-' . $layout : '') . '">';
      
    if (isset($atts['contact']) || isset($_GET['contact_id'])):

      if (ContactListHelpers::isPremium() == 0) {
        $html = '<div class="pro-feature">' . __('This feature is available in the Pro version.') . '</div>';
        return $html;
      }
    
      $contact = isset($atts['contact']) ? (int) $atts['contact'] : (int) $_GET['contact_id'];
    
      if ($contact):
    
        $html .= '<div id="contact-list-search">';
      
        $html .= '<ul id="all-contacts">';
    
        $wpb_all_query = new WP_Query(array(
          'post_type' => CONTACT_CPT,
          'post_status' => 'publish',
          'posts_per_page' => 1,
          'p' => $contact,
        ));
    
        if ($wpb_all_query->have_posts()):
    
          while ($wpb_all_query->have_posts()): $wpb_all_query->the_post();
    
              $id = get_the_id();
              $html .= ContactListHelpers::singleContactMarkup($id);
    
          endwhile;
        else:
          $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __('Contact not found', 'contact-list') . ' (ID: ' . $contact . ')</p>';
        endif;
    
        $html .= '</ul>';
    
        $html .= '</div><hr class="clear" />';
    
      else:
        $html .= '<p style="background: #f00; color: #fff; padding: 1rem; text-align: center;">' . __('Contact not found', 'contact-list') . ' (ID: ' . $contact . ')</p>';
      endif;
    
    else:
    
      $html .= '<div class="contact-list-text-contact" style="display: none;">' . __('contact', 'contact-list') . '</div>';
      $html .= '<div class="contact-list-text-contacts" style="display: none;">' . __('contacts', 'contact-list') . '</div>';
      $html .= '<div class="contact-list-text-found" style="display: none;">' . __('found', 'contact-list') . '</div>';
  
      $meta_query = array('relation' => 'AND');
    
      $meta_query []= array(
          'last_name_clause' => array(
            'key' => '_cl_last_name',
            'compare' => 'EXISTS',
          )
        );
    
      $order_by = array(
          'menu_order' => 'ASC',
          'last_name_clause' => 'ASC',
          'title' => 'ASC',
        );
        
      if (ORDER_BY == '_cl_first_name') {
    
        $meta_query []= array(
            'first_name_clause' => array(
              'key' => '_cl_first_name',
              'compare' => 'EXISTS',
            )
          );
    
        $order_by = array(
            'menu_order' => 'ASC',
            'first_name_clause' => 'ASC',
            'title' => 'ASC',
          );
    
      }
  
      if (isset($_GET['cl_country']) && $_GET['cl_country']) {
          $meta_query[] = array(
        			'key'		=> '_cl_country',
        			'value'		=> $_GET['cl_country'],
        			'compare'	=> 'LIKE'
      		);
      }
  
      if (isset($_GET['cl_state']) && $_GET['cl_state']) {
          $meta_query[] = array(
        			'key'		=> '_cl_state',
        			'value'		=> $_GET['cl_state'],
        			'compare'	=> 'LIKE'
      		);
      }
      
      $tax_query = [];
  
      if (isset($_GET['cl_cat']) && $_GET['cl_cat']) {
          $tax_query = array(
              'relation' => 'AND',
              array(
          			'taxonomy' => 'contact-group',
          			'field'	 => 'slug',
          			'terms'		 => $_GET['cl_cat']
          		)
      		);
      }
  
      $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
  
      $posts_per_page = -1;
  
      if (isset($s['contacts_per_page']) && $s['contacts_per_page']) {
        $posts_per_page = $s['contacts_per_page'];
      }
    
      $wp_query = new WP_Query(array(
        'post_type' => 'contact',
        'post_status' => 'publish',
        'posts_per_page' => (int) $posts_per_page,
        'paged' => $paged,
    
        'meta_query' => $meta_query,          
        'tax_query' => $tax_query,          
        'orderby' => $order_by
  
      ));
  
      $wp_query_for_filter = new WP_Query(array(
        'post_type' => 'contact',
        'post_status' => 'publish',
        'posts_per_page' => -1,
      ));

      if (!isset($atts['hide_search'])) {
    
        $html .= '<input type="text" id="search-contacts" placeholder="' . (isset($s['search_contacts']) && $s['search_contacts'] ? $s['search_contacts'] : __('Search contacts...', 'contact-list')) . '">';
        
      }

      if (!isset($atts['hide_filters'])) {
  
        $filter_active = 0;
  
        $html .= '<form method="get" action="./" class="contact-list-ajax-form">';
  
        if (isset($s['show_country_select_in_search']) && $s['show_country_select_in_search']) {
  
          $countries = [];
  
          while ($wp_query_for_filter->have_posts()): $wp_query_for_filter->the_post();
            $c = get_post_custom();
            if (isset($c['_cl_country']) && $c['_cl_country'] && !in_array($c['_cl_country'][0], $countries)) {
              $countries []= $c['_cl_country'][0];
            }
          endwhile;

          sort($countries);
  
          $html .= '<select name="cl_country" class="select_v2">';
          $html .= '<option value="">' . __('Select country', 'contact-list') . '</option>';
  
          foreach ($countries as $country) {
            $html .= '<option value="' . $country . '" ' . (isset($_GET['cl_country']) && $_GET['cl_country'] == $country ? 'selected="selected"' : '') . '>' . $country . '</option>';
          }
  
          $html .= '</select>';
  
          $filter_active = 1;
          
        }
  
        if (isset($s['show_state_select_in_search']) && $s['show_state_select_in_search']) {
  
          $states = [];
  
          while ($wp_query_for_filter->have_posts()): $wp_query_for_filter->the_post();
            $c = get_post_custom();
            if (isset($c['_cl_state']) && $c['_cl_state'] && !in_array($c['_cl_state'][0], $states)) {
              $states []= $c['_cl_state'][0];
            }
          endwhile;
          
          sort($states);
  
          $html .= '<select name="cl_state" class="select_v2">';
          $html .= '<option value="">' . __('Select state', 'contact-list') . '</option>';
  
          foreach ($states as $state) {
            $html .= '<option value="' . $state . '" ' . (isset($_GET['cl_state']) && $_GET['cl_state'] == $state ? 'selected="selected"' : '') . '>' . $state . '</option>';
          }
  
          $html .= '</select>';
  
          $filter_active = 1;
          
        }
  
        if (isset($s['show_category_select_in_search']) && $s['show_category_select_in_search']) {
  
          $groups = get_terms(array(
            'taxonomy'   => 'contact-group',
            'hide_empty' => true,
          ));
          
          $html .= '<select name="cl_cat" class="select_v2">';
          $html .= '<option value="">' . __('Select category', 'contact-list') . '</option>';
  
          foreach ($groups as $g) {
            
            $t_id = $g->term_id;
            $custom_fields = get_option("taxonomy_term_$t_id");
            
            if (!isset($custom_fields['hide_group'])) {
              $html .= '<option value="' . $g->slug . '" ' . (isset($_GET['cl_cat']) && $_GET['cl_cat'] == $g->slug ? 'selected="selected"' : '') . '>' . $g->name . '</option>';
            }
          }
  
          $html .= '</select>';
  
          $filter_active = 1;
          
        }
  
        if ($filter_active) {
          
          $html .= '<button type="submit" class="filter-contacts">' . __('Filter contacts', 'contact-list') . '</button>';
          
        }
  
        $html .= '<hr class="clear" /></form>';
        
      }

      $html .= '<div id="contact-list-contacts-found"></div>';
  
      if ($wp_query->have_posts()):
              
        $html .= '<div class="contact-list-ajax-results">';
        $html .= ContactListHelpers::contactListMarkup($wp_query);
        $html .= '</div>';
  
        $pagination_args = array(
              'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
              'total'        => $wp_query->max_num_pages,
              'current'      => max(1, get_query_var('paged')),
              'format'       => '?paged=%#%',
              'show_all'     => true,
              'type'         => 'plain',
              'prev_next'    => false,
              'add_args'     => false,
              'add_fragment' => '',
          );
  
        $html .= '<hr class="clear" />';
        $html .= '<div class="contact-list-pagination">';
        if (paginate_links($pagination_args)) {
          $html .= '<span class="contact-list-more-contacts">' . __('More contacts:', 'contact-list') . '</span>' .
            paginate_links($pagination_args);
        }
  
      endif;
  
      if ($wp_query->found_posts == 0) {
        $html .= '<p>' . __('No contacts found.', 'contact-list') . '</p>';
      }
  
    endif;
  
    $html .= '</div>';
    
    wp_reset_postdata();
   
    return $html; 
  }

}
