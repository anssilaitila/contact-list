<?php 

class Contact_List_AdminTest extends WP_UnitTestCase {

  public function setUp() {
    parent::setUp();
    $this->class_instance = new Contact_List_Admin('contact-list', '2.9.0');
  }

  public function test_set_custom_contact_list_sortable_columns() {
    $columns = $this->class_instance->set_custom_contact_list_sortable_columns(array());
    $this->assertArrayHasKey('last_name', $columns);
  }

}