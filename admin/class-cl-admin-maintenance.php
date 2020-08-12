<?php

class ContactListAdminMaintenance {

  public function actions() {

    if (!get_option('contact-list-sc')) {
      add_option('contact-list-sc', md5(uniqid(rand(), true)), '', 'yes');
    }
    
  }

}
