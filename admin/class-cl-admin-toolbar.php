<?php

class ContactListAdminToolbar {

  public static function get_admin_pages() {

    $admin_pages = [
      'edit-contact',
      'contact',
      'edit-contact-group',
      'contact_page_contact-list-import',
      'contact_page_contact-list-export',
      'contact_page_contact-list-printable',
      'contact_page_contact-list-send-email',
      'contact_page_contact-list-mail-log',
      'contact_page_contact-list-search-log',
      'contact_page_contact-list-shortcodes',
      'contact_page_contact-list-support',
      'settings_page_contact-list',
      'settings_page_contact-list-account'
    ];

    return $admin_pages;

  }

  public function admin_body_class( $classes ) {

    $screen = get_current_screen();

    $add_class = 0;

    if ( isset( $screen->id ) && $screen_id = $screen->id ) {

      $admin_pages = ContactListAdminToolbar::get_admin_pages();

      if ( in_array( $screen_id, $admin_pages ) ) {

        $add_class = 1;

      } else {

        $add_class = 0;

      }


    }

    if ( $add_class ) {
      $classes .= ' contact-list-admin-page';
    }

    return $classes;

  }

  public function admin_header() {

    $screen = get_current_screen();

    $admin_pages = ContactListAdminToolbar::get_admin_pages();

    $current_admin_page = '';

    $show_toolbar = 0;

    if ( isset( $screen->id ) && $screen_id = $screen->id ) {

      if ( in_array( $screen_id, $admin_pages ) ) {

        $show_toolbar = 1;
        $current_admin_page = $screen_id;

      } else {

        $show_toolbar = 0;

      }


    }


    ?>

    <?php if ( $show_toolbar ): ?>

      <div class="contact-list-admin-toolbar">

        <div class="contact-list-admin-toolbar-left">

          <div class="contact-list-admin-toolbar-left-plugin-title">

            <span class="contact-list-admin-toolbar-plugin-title">
              <?php echo esc_html__( 'Contact List', 'contact-list' ); ?>
              <?php if ( contact_list_fs()->is_plan_or_trial('business') ): ?>
                PRO
              <?php elseif ( contact_list_fs()->is_plan_or_trial('pro') ): ?>
                PRO
              <?php elseif ( contact_list_fs()->is_plan_or_trial('personal') ): ?>
                PRO
              <?php endif; ?>
            </span>

            <?php if ( contact_list_fs()->is_plan_or_trial('business') ): ?>
              <span class="contact-list-admin-plan-small">MAX</span>
            <?php elseif ( contact_list_fs()->is_plan_or_trial('pro') ): ?>
              <?php // ... ?>
            <?php elseif ( contact_list_fs()->is_plan_or_trial('personal') ): ?>
              <span class="contact-list-admin-plan-small">LITE</span>
            <?php endif; ?>

          </div>

          <div class="contact-list-admin-toolbar-left-links">
            <a href="<?php echo esc_url_raw( get_admin_url(null, './edit.php?post_type=' . CONTACT_LIST_CPT) ) ?>"><?php echo esc_html__('All contacts', 'contact-list'); ?></a>
            <a href="<?php echo esc_url_raw( get_admin_url(null, './post-new.php?post_type=' . CONTACT_LIST_CPT) ) ?>"><?php echo esc_html__('Add new contact', 'contact-list'); ?></a>
            <a href="<?php echo esc_url_raw( get_admin_url(null, './edit-tags.php?taxonomy=contact-group&post_type=' . CONTACT_LIST_CPT) ) ?>"><?php echo esc_html__('Groups', 'contact-list'); ?></a>
            <a href="<?php echo esc_url_raw( get_admin_url(null, './edit.php?post_type=contact&page=contact-list-shortcodes') ) ?>"><?php echo esc_html__('Shortcodes', 'contact-list'); ?></a>
            <a href="<?php echo esc_url_raw( get_admin_url(null, './edit.php?post_type=contact&page=contact-list-support') ) ?>"><?php echo esc_html__('Support', 'contact-list'); ?></a>
            <a class="contact-list-btn-alt" href="<?php echo esc_url_raw( get_admin_url(null, './options-general.php?page=contact-list') ) ?>"><?php echo esc_html__('Settings', 'contact-list'); ?></a>

            <?php $freemius_user = contact_list_fs()->get_user(); ?>

            <?php if ( $freemius_user ): ?>

              <a class="contact-list-btn-alt" href="<?php echo esc_url_raw( get_admin_url(null, './options-general.php?page=contact-list-account') ) ?>"><?php echo esc_html__('Account', 'contact-list'); ?></a>

            <?php endif; ?>

          </div>
        </div>

        <div class="contact-list-admin-toolbar-right">

          <?php if (ContactListHelpers::isPremium() == 0): ?>

            <a href="https://www.contactlistpro.com/pricing/?utm_source=Contact+List+Free&utm_medium=wpadminplugin&utm_campaign=Contact+List+upgrade&utm_content=header" target="_blank">
              <?php echo esc_html__( 'Unlock Extra Features with Contact List PRO', 'contact-list' ); ?> ➜
            </a>

          <?php endif; ?>

        </div>

      </div>

      <?php

      $page_title = sanitize_text_field( __('Contact List', 'contact-list') );

      switch ( $current_admin_page ) {

        case 'edit-contact':
          $page_title = sanitize_text_field( __('All contacts', 'contact-list') );
          break;
        case 'contact':

          if ( isset($_GET['action']) && $_GET['action'] == 'edit') {
            $page_title = sanitize_text_field( __('Edit contact', 'contact-list') );
          } else {
            $page_title = sanitize_text_field( __('Add new contact', 'contact-list') );
          }

          break;
        case 'edit-contact-group':
          $page_title = sanitize_text_field( __('Groups', 'contact-list') );
          break;
        case 'contact_page_contact-list-import':
          $page_title = sanitize_text_field( __('Import contacts', 'contact-list') );
          break;
        case 'contact_page_contact-list-export':
          $page_title = sanitize_text_field( __('Export contacts', 'contact-list') );
          break;
        case 'contact_page_contact-list-printable':
          $page_title = sanitize_text_field( __('Printable list', 'contact-list') );
          break;
        case 'contact_page_contact-list-send-email':
          $page_title = sanitize_text_field( __('Send email to contacts', 'contact-list') );
          break;
        case 'contact_page_contact-list-mail-log':
          $page_title = sanitize_text_field( __('Log of sent mail', 'contact-list') );
          break;
        case 'contact_page_contact-list-search-log':
          $page_title = sanitize_text_field( __('Search log', 'contact-list') );
          break;
        case 'contact_page_contact-list-shortcodes':
          $page_title = sanitize_text_field( __('Shortcodes', 'contact-list') );
          break;
        case 'contact_page_contact-list-support':
          $page_title = sanitize_text_field( __('Support', 'contact-list') );
          break;
        case 'settings_page_contact-list':
          $page_title = sanitize_text_field( __('Settings', 'contact-list') );
          break;
        case 'settings_page_contact-list-account':
          $page_title = sanitize_text_field( __('Account', 'contact-list') );
          break;
        default:
          break;

      }

      ?>

      <div class="contact-list-admin-titlebar">
        <h1><?php echo esc_html( $page_title ); ?></h1>
      </div>

    <?php endif; ?>

    <?php

  }

  public function admin_footer() {

    if ( ContactListHelpers::isPremium() == 1 ) {
      return;
    }

    $screen = get_current_screen();

    $admin_pages = ContactListAdminToolbar::get_admin_pages();

    $show_box = 0;

    if ( isset( $screen->id ) && $screen_id = $screen->id ) {

      $screen_post_type = '';

      if ( isset($screen->post_type) ) {
        $screen_post_type = $screen->post_type;
      }

      if ( $screen_post_type == 'contact' && $screen_id == 'edit-post_tag' ) {
        $show_box = 1;
      } elseif ( in_array( $screen_id, $admin_pages ) ) {
        $show_box = 1;
      } else {
        $show_box = 0;
      }

    }

    ?>

    <?php if ( $show_box ): ?>

      <div class="contact-list-admin-pro-features">
      </div>

    <?php endif; ?>

    <?php

  }

}
