<?php

class ContactListAdminOperations {

  public function operations() {

    if (isset($_POST) && isset($_POST['_contact_list_empty_mail_log']) && is_super_admin()) {

      global $wpdb;
      $table_name = $wpdb->prefix . 'cl_sent_mail_log';
      $delete = $wpdb->query("TRUNCATE TABLE `" . $table_name . "`");
     
      wp_redirect(get_admin_url(null, './edit.php?post_type=' . CONTACT_CPT . '&page=contact-list-mail-log&mail_log_emptied=1'));
      
      wp_redirect($goto_url);
      exit;

    }
    
  }

}
