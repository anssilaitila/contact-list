<?php

class ContactListShortcodes {

  public function register_shortcodes_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_CPT,
      __('Available shortcodes for Contact List', 'contact-list'),
      __('Shortcodes', 'contact-list'),
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

      <h1><?= __('Available shortcodes for Contact List', 'contact-list'); ?></h1>

      <div class="contact-list-examples">
        <p><?= __('For support using the plugin please contact us at', 'contact-list') . ' <a href="https://www.contactlistpro.com/support/" target="_blank">contactlistpro.com/support/</a>.'; ?></p>
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2><?= __('Default contact list', 'contact-list'); ?></h2>
  
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-1" data-tooltip-class="contact-list-shortcode-1">[contact_list]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-1"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
          </li>
          <li><?= __('Additional parameters', 'contact-list'); ?>
              <ul>
                  <li><?= __('Hide search form:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-2">[contact_list hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-2"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Order by first name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-14">[contact_list order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-14"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Order by last name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-15">[contact_list order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-15"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Layout "2 columns"', 'contact-list') ?>:
                    <span class="contact-list-shortcode contact-list-shortcode-3">[contact_list layout=2-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-3"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Layout "3 columns"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>):
                    <span class="contact-list-shortcode contact-list-shortcode-4">[contact_list layout=3-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-4"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Layout "4 columns"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>):
                    <span class="contact-list-shortcode contact-list-shortcode-5">[contact_list layout=4-columns]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-5"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Multiple parameters:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-6">[contact_list layout=2-columns hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-6"><?= __('Copy', 'contact-list') ?></button>
                  </li>
              </ul>
          </li>
        </ol>
      
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2><?= __('Simple contact list', 'contact-list'); ?></h2>
  
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-7">[contact_list_simple]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-7"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
            <ul>
              <li><?= __('Show filters:', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">Pro</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-18">[contact_list_simple show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-18"><?= __('Copy', 'contact-list') ?></button>
              </li>
              <li><?= __('Show contacts from a specific group:', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">Pro</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-99">[contact_list_simple group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-99"><?= __('Copy', 'contact-list') ?></button>
              </li>
              <li><?= __('Limit contacts per page (activates pagination):', 'contact-list') ?>
                <?php if (ContactListHelpers::isPremium() == 1): ?>  
                  <span class="contact-list-pro-only-inline-inactive">Pro</span>
                <?php else: ?>
                  <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
                <?php endif; ?>
                <span class="contact-list-shortcode contact-list-shortcode-199">[contact_list_simple contacts_per_page=20]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-199"><?= __('Copy', 'contact-list') ?></button>
              </li>
            </ul>
          </li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= __('Parameters for all shortcodes', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>        
        </h2>
  
        <ol>
          <li>
            <?= __('Card height in pixels', 'contact-list') ?>
            <ul>
              <li>card_height=200</li>
            </ul>
          </li>
          <li>
            <?= __('Exclude certain contacts (comma separated list of contact id\'s)', 'contact-list') ?>
            <ul>
              <li>exclude="123,456,789"</li>
            </ul>
          </li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">
      
        <h2>
          <?= __('Contacts with groups', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-8">[contact_list_groups]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-8"><?= __('Copy', 'contact-list') ?></button>        
            <?= __('to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list'); ?></li>
          <li><?= __('Additional parameters', 'contact-list'); ?>
              <ul>
                  <li><?= __('Order by first name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-16">[contact_list_groups order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-16"><?= __('Copy', 'contact-list') ?></button>
                  </li>
                  <li><?= __('Order by last name:', 'contact-list') ?>
                    <span class="contact-list-shortcode contact-list-shortcode-17">[contact_list_groups order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-17"><?= __('Copy', 'contact-list') ?></button>
                  </li>
              </ul>
          </li>
        </ol>

      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= __('Contacts from specific group', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-9">[contact_list_groups group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-9"><?= __('Copy', 'contact-list') ?></button>        
            <?= __('to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list'); ?>
          </li>
          <li><?= __('Additional parameters', 'contact-list'); ?>
            <ul>
              <li><?= __('Show filters', 'contact-list') ?>: <span class="contact-list-shortcode contact-list-shortcode-13">[contact_list_groups group=GROUP_SLUG show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-13"><?= __('Copy', 'contact-list') ?></button></li>
              <li><?= esc_html__('Show contacts that belong to all of these groups (comma separated group slugs)', 'contact-list') ?>: <span class="contact-list-shortcode contact-list-shortcode-139">[contact_list_groups groups__and="group-slug-1,group-slug-2"]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-139"><?= __('Copy', 'contact-list') ?></button></li>
            </ul>
          </li>
        </ol>

      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= __('Single contact', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?>
            <span class="contact-list-shortcode contact-list-shortcode-10">[contact_list contact=CONTACT_ID]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-10"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.' , 'contact-list'); ?></li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= __('Allow visitors to add new contacts', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-11">[contact_list_form]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-11"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the page you wish the form to appear on.', 'contact-list'); ?></li>
          <li><?= __('When a user submits the form, a new contact is saved to the contacts. The status of that contact is "Pending Review" and a site administrator must publish/edit/delete the contact.', 'contact-list'); ?></li>
        </ol>
        
      </div>

      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">

        <h2>
          <?= __('Only a search form that searches from all contacts', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
        </h2>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-12">[contact_list_search]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-12"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the page you wish the view to appear on.', 'contact-list'); ?></li>
        </ol>
        
      </div>
      
      <div class="contact-list-admin-section contact-list-admin-section-shortcodes">
      
        <h2>
          <?= __('Send email to a group', 'contact-list'); ?>
          <?php if (ContactListHelpers::isPremium() == 1): ?>  
            <span class="contact-list-pro-only-inline-inactive">Pro</span>
          <?php else: ?>
            <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
          <?php endif; ?>
          <span class="cl-new-feature-inline"><?= __('New', 'shared-files') ?></span>
        </h2>
        
        <?php $num++ ?>
        <ol>
          <li><?= __('Insert the shortcode', 'contact-list') ?> 
            <span class="contact-list-shortcode contact-list-shortcode-<?= $num ?>">[contact_list_send_email group=GROUP_SLUG]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-<?= $num ?>"><?= __('Copy', 'contact-list') ?></button>
            <?= __('to the page you wish the view to appear on.', 'contact-list'); ?></li>
        </ol>
        
      </div>

      <script src="<?= CONTACT_LIST_URI ?>dist/clipboard.min.js"></script>
  
      <script>
      var clipboard = new ClipboardJS('.contact-list-copy');
  
      clipboard.on('success', function(e) {

        e.clearSelection();

        let clipboardtarget = jQuery(e.trigger).data('clipboard-target');

        jQuery(clipboardtarget).tipso({
          content: "<?= __('Shortcode copied to clipboard!', 'contact-list') ?>",
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
