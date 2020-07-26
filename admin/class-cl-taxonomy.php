<?php

class ContactListTaxonomy {

  public function create_contact_list_custom_taxonomy() {

    $labels = array(
      'name' => __('Group', 'contact-list'),
      'singular_name' => __('Group', 'contact-list'),
      'search_items' =>  __('Search Groups', 'contact-list'),
      'all_items' => __('All Groups', 'contact-list'),
      'parent_item' => __('Parent Group', 'contact-list'),
      'parent_item_colon' => __('Parent Group:', 'contact-list'),
      'edit_item' => __('Edit Group', 'contact-list'),
      'update_item' => __('Update Group', 'contact-list'),
      'add_new_item' => __('Add New Group', 'contact-list'),
      'menu_name' => __('Groups', 'contact-list'),
      'not_found' => __('No groups found.', 'contact-list'),
    );

    register_taxonomy('contact-group', array(CONTACT_CPT), array(
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'public' => false,
      'rewrite' => array('slug' => 'groups'),
    ));
  }

  function contact_group_taxonomy_custom_fields($tag) {  
    $t_id = $tag->term_id;
    $term_meta = get_option("taxonomy_term_$t_id");
  ?>  
    
  <tr class="form-field">  
    <th scope="row" valign="top">  
      <label for="term_meta[hide_group]"><?= __('Hide group', 'contact-list'); ?></label>  
      <div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 6px;"><?= __('Note: this hides only the group from the front-end views (such as dropdowns and group lists), not the actual contacts that may belong to this group.', 'contact-list') ?></div>
    </th>  
    <td>  
      <input type="checkbox" name="term_meta[hide_group]" id="term_meta[hide_group]" <?= isset($term_meta['hide_group']) ? 'checked="checked"' : ''; ?>>
    </td>  
  </tr>  
    
  <?php  
  }  

  function save_taxonomy_custom_fields($term_id) {  

      $t_id = $term_id;  
      $term_meta = get_option("taxonomy_term_$t_id");  

      if (isset($_POST['term_meta'])) {  
        
        $cat_keys = array_keys($_POST['term_meta']);  

        foreach ($cat_keys as $key) {

          if (isset($_POST['term_meta'][$key])) {
            $term_meta[$key] = $_POST['term_meta'][$key];
          }

        }

      } else {
        $term_meta = array();
      }

      update_option("taxonomy_term_$t_id", $term_meta);  
  }    

}
