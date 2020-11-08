<?php

class ContactListCPT {

  public function create_custom_post_type_contact() {

    register_post_type(CONTACT_CPT,
                       [
                          'labels'        => [
                            'name'          => __('Contact List', 'contact-list'),
                            'singular_name' => __('Contact', 'contact-list'),
                            'add_new_item'  => __('Add New Contact', 'contact-list'),
                            'edit_item'     => __('Edit Contact', 'contact-list'),
                            'not_found'     => ContactListHelpers::getText('text_sr_no_contacts_found', __('No contacts found.', 'contact-list')),
                            'all_items'     => __('All Contacts', 'contact-list'),
                          ],
                          'supports'           => array('title', 'thumbnail', 'page-attributes'),
                          'public'             => false,
                          'show_ui'            => true,
                          'has_archive'        => false,
                          'publicly_queryable' => false,
                          'menu_icon'          => 'dashicons-id',
                          'capability_type'    => 'post'
                       ]
    );

    remove_post_type_support(CONTACT_CPT, 'title');
    remove_post_type_support(CONTACT_CPT, 'editor');

    add_image_size('contact-list-contact', 280, 440);

  }

}
