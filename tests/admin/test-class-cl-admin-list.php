<?php 

class Contact_List_AdminTest extends WP_UnitTestCase {

  public function setUp() {
    parent::setUp();

    $this->admin_user_id = $this->factory->user->create(['role' => 'admin']);
    wp_set_current_user($this->admin_user_id);

    $this->class_instance = new Contact_List_Admin('contact-list', '2.9.6');
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function test_plugin_loaded_success() {
    $this->assertTrue(class_exists('Contact_List_Admin'), "Class 'Contact_List_Admin' not found.");
  }

  public function test_create_post_success() {

    $post = $this->factory->post->create_and_get([
      'post_type'    => 'contact',
//      'post_title'   => 'Toimiiko737468',

      'meta_input'    => array(
        '_cl_first_name'   => 'Etu',
        '_cl_last_name'    => 'Suku',
      )

    ]);
    
    $this->assertTrue($post->ID > 0, 'Post did not get created successfully.');

    $post_title = get_the_title($post->ID);
    $last_name = get_post_meta($post->ID, '_cl_last_name', true);

    $this->assertEquals('Suku', $last_name, "Incorrect last name.");
    
//    $this->assertEquals('Toimiiko737468', $post_title, 'Incorrect post name.');

  }

}