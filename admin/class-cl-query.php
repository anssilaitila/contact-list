<?php

class ContactListQuery {

  public function modify_post_title($data) {

    if (isset($_POST) && $data['post_type'] == CONTACT_CPT && !isset($_POST['_cl_last_name']) && $data['post_content'] == 'imported') {
      // ...      
    } elseif (isset($_POST) && $data['post_type'] == CONTACT_CPT) {
      $data['post_title'] = (isset($_POST['_cl_first_name']) ? $_POST['_cl_first_name'] : '') . ' ' . (isset($_POST['_cl_last_name']) ? $_POST['_cl_last_name'] : '');
    }

    return $data;
  }

  public function alter_the_query($request) {

    global $wp;
    $url = home_url($wp->request);
    $cl_query = 0;
    $cl_sub = 0;
    $url_parts = parse_url($url);

    if (isset($url_parts['path'])) {
      $path_parts = explode('/', $url_parts['path']);
    }

    if (isset($path_parts[2]) && $path_parts[2] == '_cl_update-contact') {
      $cl_query = 1;
      $cl_sub = 1;
    } else if (isset($path_parts[1]) && $path_parts[1] == '_cl_update-contact') {
      $cl_query = 1;
    }

    if ($cl_query) {

      $contact_id = 0;
      
      if ($cl_sub) {
        $contact_id = isset($path_parts[3]) ? (int) $path_parts[3] : 0;
      } else {
        $contact_id = isset($path_parts[2]) ? (int) $path_parts[2] : 0;
      }

      if ($contact_id) {

        $html = ContactListUpdateContact::updateContactMarkup($contact_id);
        print_r($html);
        die();

      }

    }

    return $request;
  }

}
