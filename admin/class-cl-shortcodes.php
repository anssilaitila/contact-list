<?php

class ContactListShortcodes {

  public function register_shortcodes_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_CPT,
      esc_html__('Available shortcodes for Contact List', 'contact-list'),
      esc_html__('Shortcodes', 'contact-list'),
      'manage_options',
      'contact-list-shortcodes',
      [ $this, 'register_shortcodes_page_callback' ]
    );
  }

  public function register_shortcodes_page_callback() {
    ?>

    <?php $num = 1000; ?>

    <link rel="stylesheet" href="<?= CONTACT_LIST_URI ?>dist/tipso.min.css">
    <script src="<?= CONTACT_LIST_URI ?>dist/tipso.min.js"></script>
    
    <div class="wrap">

      <h1><?= esc_html__('Available shortcodes for Contact List', 'contact-list'); ?></h1>

      <div class="contact-list-examples">
        <p><?= esc_html__('For support using the plugin please contact us at', 'contact-list') . ' <a href="https://www.contactlistpro.com/support/" target="_blank">contactlistpro.com/support/</a>.'; ?></p>
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2><?= esc_html__('Default contact list', 'contact-list'); ?></h2>
  
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-1" data-tooltip-class="contact-list-shortcode-1">[contact_list]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-1"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
          </li>
          <li><?= esc_html__('Additional parameters', 'contact-list'); ?>
              <ul>
                  <li><?= esc_html__('Hide search form:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-2">[contact_list hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-2"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Order by first name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-14">[contact_list order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-14"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Order by last name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-15">[contact_list order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-15"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Layout "2 columns"', 'contact-list') ?>:
                    <span class="contact-list-shortcode contact-list-shortcode-3">[contact_list layout=2-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-3"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Layout "3 columns"', 'contact-list') ?> (<?= esc_html__('without contact images', 'contact-list') ?>):
                    <span class="contact-list-shortcode contact-list-shortcode-4">[contact_list layout=3-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-4"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Layout "4 columns"', 'contact-list') ?> (<?= esc_html__('without contact images', 'contact-list') ?>):
                    <span class="contact-list-shortcode contact-list-shortcode-5">[contact_list layout=4-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-5"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>

                  <?php if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial('pro') || cl_fs()->is_plan_or_trial('business') ): ?>

                    <li><?= esc_html__('Shows contacts in the defined group, and the group filter contains only that group and it\'s subgroups', 'contact-list') ?>: <span class="cl-new-feature-inline"><?= esc_html__('New', 'contact-list') ?></span>
                    
                      <?php if (ContactListHelpers::isPremium() == 1): ?>  
                        <span class="contact-list-pro-only-inline-inactive">Professional</span>
                      <?php else: ?>
                        <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Professional</a>
                      <?php endif; ?>
                      
                      <span class="contact-list-shortcode contact-list-shortcode-000">[contact_list group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-000"><?= esc_html__('Copy', 'contact-list') ?></button>
                    </li>

                    <li><?= esc_html__('Filter by custom field values, any number of fields', 'contact-list') ?>: <span class="cl-new-feature-inline"><?= esc_html__('New', 'contact-list') ?></span>
                    
                      <?php if (ContactListHelpers::isPremium() == 1): ?>  
                        <span class="contact-list-pro-only-inline-inactive">Professional</span>
                      <?php else: ?>
                        <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Professional</a>
                      <?php endif; ?>
                    
                      <span class="contact-list-shortcode contact-list-shortcode-001">[contact_list custom_field_1="Value 1" custom_field_2="Value 2"]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-001"><?= esc_html__('Copy', 'contact-list') ?></button>
                    </li>
                    
                  <?php endif; ?>
                    
                  <li><?= esc_html__('Multiple parameters:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-6">[contact_list layout=2-columns hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-6"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
              </ul>
          </li>
        </ol>
      
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2><?= esc_html__('Simple contact list', 'contact-list'); ?></h2>
  
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-7">[contact_list_simple]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-7"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
            <ul>
              <li><?= esc_html__('Show filters:', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">All Plans</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-18">[contact_list_simple show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-18"><?= esc_html__('Copy', 'contact-list') ?></button>
              </li>
              <li><?= esc_html__('Show contacts from a specific group:', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">All Plans</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-99">[contact_list_simple group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-99"><?= esc_html__('Copy', 'contact-list') ?></button>
              </li>
              <li><?= esc_html__('Limit contacts per page (activates pagination):', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">All Plans</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-199">[contact_list_simple contacts_per_page=20]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-199"><?= esc_html__('Copy', 'contact-list') ?></button>
              </li>

              <?php if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial('pro') || cl_fs()->is_plan_or_trial('business') ): ?>

                <li><?= esc_html__('Filter by custom field values, any number of fields', 'contact-list') ?>: <span class="cl-new-feature-inline"><?= esc_html__('New', 'contact-list') ?></span>
                  <?php if (ContactListHelpers::isPremium() == 1): ?>  
                    <span class="contact-list-pro-only-inline-inactive">Professional</span>
                  <?php else: ?>
                    <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Professional</a>
                  <?php endif; ?>
                  <span class="contact-list-shortcode contact-list-shortcode-002">[contact_list_simple custom_field_1="Value 1" custom_field_2="Value 2"]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-002"><?= esc_html__('Copy', 'contact-list') ?></button>
                </li>
                
              <?php endif; ?>

            </ul>
          </li>
        </ol>
        
      </div>

      <?php if ( cl_fs()->is_free_plan() || cl_fs()->is_plan_or_trial('pro') || cl_fs()->is_plan_or_trial('business') ): ?>

        <div class="contact-list-admin-section contact-list-admin-section-shortcodes">      
                      
          <h2>
            <?= esc_html__('Enable front-end editor for all contacts') ?>
        
            <?php if (ContactListHelpers::isPremium() == 1): ?>
              <span class="contact-list-pro-only-inline-inactive">Professional</span>
            <?php else: ?>
              <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Professional</a>
            <?php endif; ?>
        
          </h2>
        
          <p><?= esc_html__('Enable front-end edit using the following shortcodes (user roles must also be activated from the plugin settings):', 'contact-list') ?></p>
        
          <ul>  
           <li>
              <span class="contact-list-shortcode contact-list-shortcode-003" data-tooltip-class="contact-list-shortcode-003">[contact_list edit=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-003"><?= esc_html__('Copy', 'contact-list') ?></button></span>
           </li>
           <li>
              <span class="contact-list-shortcode contact-list-shortcode-004" data-tooltip-class="contact-list-shortcode-004">[contact_list_simple edit=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-004"><?= esc_html__('Copy', 'contact-list') ?></button></span>
            </li>
          </ul>
        </div>
        
      <?php endif; ?>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= esc_html__('Parameters for all shortcodes', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>        
        </h2>
  
        <ol>
          <li>
            <?= esc_html__('Card height in pixels', 'contact-list') ?>
            <ul>
              <li>card_height=200</li>
            </ul>
          </li>
          <li>
            <?= esc_html__('Exclude certain contacts (comma separated list of contact id\'s)', 'contact-list') ?>
            <ul>
              <li>exclude="123,456,789"</li>
            </ul>
          </li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">
      
        <h2>
          <?= esc_html__('Contacts with groups', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-8">[contact_list_groups]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-8"><?= esc_html__('Copy', 'contact-list') ?></button>        
            <?= esc_html__('to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list'); ?></li>
          <li><?= esc_html__('Additional parameters', 'contact-list'); ?>
              <ul>
                  <li><?= esc_html__('Order by first name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-16">[contact_list_groups order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-16"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= esc_html__('Order by last name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-17">[contact_list_groups order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-17"><?= esc_html__('Copy', 'contact-list') ?></button>
                  </li>
              </ul>
          </li>
        </ol>

      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= esc_html__('Contacts from specific group', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-9">[contact_list_groups group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-9"><?= esc_html__('Copy', 'contact-list') ?></button>        
            <?= esc_html__('to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list'); ?>
          </li>
          <li><?= esc_html__('Additional parameters', 'contact-list'); ?>
            <ul>
              <li><?= esc_html__('Show filters', 'contact-list') ?>: <span class="contact-list-shortcode contact-list-shortcode-13">[contact_list_groups group=GROUP_SLUG show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-13"><?= esc_html__('Copy', 'contact-list') ?></button></li>
              <li><?= esc_html__('Show contacts that belong to all of these groups (comma separated group slugs)', 'contact-list') ?>: <span class="contact-list-shortcode contact-list-shortcode-139">[contact_list_groups groups__and="group-slug-1,group-slug-2"]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-139"><?= esc_html__('Copy', 'contact-list') ?></button></li>
            </ul>
          </li>
        </ol>

      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= esc_html__('Single contact', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-10">[contact_list contact=CONTACT_ID]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-10"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.' , 'contact-list'); ?></li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= esc_html__('Allow visitors to add new contacts', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-11">[contact_list_form]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-11"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the page you wish the form to appear on.', 'contact-list'); ?></li>
          <li><?= esc_html__('When a user submits the form, a new contact is saved to the contacts. The status of that contact is "Pending Review" and a site administrator must publish/edit/delete the contact.', 'contact-list'); ?></li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= esc_html__('Only a search form that searches from all contacts', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-12">[contact_list_search]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-12"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the page you wish the view to appear on.', 'contact-list'); ?></li>
        </ol>
        
      </div>
      
      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">
      
        <h2>
          <?= esc_html__('Send email to a group', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">All Plans</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">All Plans</a>
          <?php endif; ?>
          <span class="cl-new-feature-inline"><?= esc_html__('New', 'contact-list') ?></span>
        </h2>
        
        <?php $num++ ?>
        <ol>
          <li><?= esc_html__('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-<?= $num ?>">[contact_list_send_email group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-<?= $num ?>"><?= esc_html__('Copy', 'contact-list') ?></button>
            <?= esc_html__('to the page you wish the view to appear on.', 'contact-list'); ?></li>
        </ol>
        
      </div>

      <script src="<?= CONTACT_LIST_URI ?>dist/clipboard.min.js"></script>
  
      <script>
      var clipboard = new ClipboardJS('.contact-list-copy');
  
      clipboard.on('success', function(e) {

        e.clearSelection();

        let clipboardtarget = jQuery(e.trigger).data('clipboard-target');

        jQuery(clipboardtarget).tipso({
          content: "<?= esc_js( __('Shortcode copied to clipboard!', 'contact-list') ) ?>",
          width: 240
        });

        jQuery(clipboardtarget).tipso('show');
        
        setTimeout(function () {
          showpanel(clipboardtarget);
        }, 2000);
        
        function showpanel(clipboardtarget) {
          jQuery(clipboardtarget).tipso('hide');
          jQuery(clipboardtarget).tipso('destroy');
        }
        
      });
  
      clipboard.on('error', function(e) {
//        console.log(e);
      });
      </script>

    </div>
    <?php
  }

}
