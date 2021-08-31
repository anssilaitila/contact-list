<?php

class ContactListCPT {

  public function create_custom_post_type_contact() {

    register_post_type(CONTACT_LIST_CPT,
                       [
                          'labels'        => [
                            'name'          => sanitize_text_field( __('Contact List', 'contact-list') ),
                            'singular_name' => sanitize_text_field( __('Contact', 'contact-list') ),
                            'add_new_item'  => sanitize_text_field( __('Add New Contact', 'contact-list') ),
                            'edit_item'     => sanitize_text_field( __('Edit Contact', 'contact-list') ),
                            'not_found'     => ContactListHelpers::getText('text_sr_no_contacts_found', __('No contacts found.', 'contact-list')),
                            'all_items'     => sanitize_text_field( __('All Contacts', 'contact-list') ),
                          ],
                          'supports'            => array('title', 'thumbnail', 'page-attributes'),
                          'public'              => false,
                          'show_ui'             => true,
                          'has_archive'         => false,
                          'publicly_queryable'  => false,
                          'menu_icon'           => 'dashicons-id',
                          'capability_type'     => 'post',
                          'exclude_from_search' => true
                       ]
    );

    remove_post_type_support(CONTACT_LIST_CPT, 'title');
    remove_post_type_support(CONTACT_LIST_CPT, 'editor');

    add_image_size('contact-list-contact', 280, 440);

  }

}
