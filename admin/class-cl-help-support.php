<?php

class ContactListHelpSupport {

  public function register_support_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_CPT,
      __('How to use Contact List', 'contact-list'),
      __('Help / Support', 'contact-list'),
      'manage_options',
      'contact-list-support',
      [ $this, 'register_support_page_callback' ]
    );
  }

  public function register_support_page_callback() {
    ?>

    <link rel="stylesheet" href="<?= CONTACT_LIST_URI ?>dist/tipso.min.css">
    <script src="<?= CONTACT_LIST_URI ?>dist/tipso.min.js"></script>
    
    <div class="wrap">

      <h1><?= __('How to use Contact List', 'contact-list'); ?></h1>

      <div class="contact-list-examples">
          <p><?= __('Some examples on how you can use different views available at', 'contact-list') ?> <a href="https://www.contactlistpro.com/contact-list/" target="_blank"><?= __('contactlistpro.com', 'contact-list') ?></a>.</p>
          <p><?= __('Any feedback is welcome. You may contact the author at', 'contact-list') . ' <a href="https://www.contactlistpro.com/support/" target="_blank">contactlistpro.com/support/</a> ' . __('or by email:', 'contact-list') ?> <a href="javascript:location='mailto:\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d';void 0"><script type="text/javascript">document.write('\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d')</script></a></p>
      </div>

      <span class="contact-list-shortcodes-link"><?= __('A complete list of available shortcodes can be found at', 'contact-list') ?> <a href="https://www.contactlistpro.com/support/shortcodes/" target="_blank">https://www.contactlistpro.com/support/shortcodes/</a></span>

      <h2><?= __('Default contact list', 'contact-list'); ?></h2>

      <ol>
        <li><?= __('Add the contacts via the All Contacts page.', 'contact-list'); ?></li>
        <li><?= __('Insert the shortcode', 'contact-list') ?>
          <span class="contact-list-shortcode contact-list-shortcode-1" data-tooltip-class="contact-list-shortcode-1">[contact_list]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-1"><?= __('Copy', 'contact-list') ?></button>
          <?= __('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
        </li>
        <li><?= __('Additional parameters', 'contact-list'); ?>
            <ul class="contact-list-admin-ul">
                <li><?= __('Hide search form:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-2">[contact_list hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-2"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Order by first name:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-14">[contact_list order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-14"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Order by last name:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-15">[contact_list order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-15"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Layout "2 cards on the same row"', 'contact-list') ?>:
                  <span class="contact-list-shortcode contact-list-shortcode-3">[contact_list layout=2-cards-on-the-same-row]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-3"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Layout "3 cards on the same row"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>):
                  <span class="contact-list-shortcode contact-list-shortcode-4">[contact_list layout=3-cards-on-the-same-row]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-4"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Layout "4 cards on the same row"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>):
                  <span class="contact-list-shortcode contact-list-shortcode-5">[contact_list layout=4-cards-on-the-same-row]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-5"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Multiple parameters:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-6">[contact_list layout=2-cards-on-the-same-row hide_search=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-6"><?= __('Copy', 'contact-list') ?></button>
                </li>
            </ul>
        </li>
      </ol>

      <h2><?= __('Simple contact list', 'contact-list'); ?></h2>

      <ol>
        <li><?= __('Add the contacts via the All Contacts page.', 'contact-list'); ?></li>
        <li><?= __('Insert the shortcode', 'contact-list') ?>
          <span class="contact-list-shortcode contact-list-shortcode-7">[contact_list_simple]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-7"><?= __('Copy', 'contact-list') ?></button>
          <?= __('to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?>
          <ul class="contact-list-admin-ul">
            <li><?= __('Show filters:', 'contact-list') ?>
              <?php if (ContactListHelpers::isPremium() == 1): ?>  
                <span class="contact-list-pro-only-inline-inactive">Pro</span>
              <?php else: ?>
                <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
              <?php endif; ?>
              <span class="contact-list-shortcode contact-list-shortcode-18">[contact_list_simple show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-18"><?= __('Copy', 'contact-list') ?></button>
            </li>
          </ul>
        </li>
      </ol>

      <h2>
        <?= __('Contacts with groups', 'contact-list'); ?>
        <?php if (ContactListHelpers::isPremium() == 1): ?>  
          <span class="contact-list-pro-only-inline-inactive">Pro</span>
        <?php else: ?>
          <a href="<?= get_admin_url() ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php endif; ?>
      </h2>
      <ol>
        <li><?= __('Add the groups via the Groups page. There may be groups under groups (hierarchial groups, 2 or more levels).', 'contact-list'); ?></li>
        <li><?= __('Add the contacts via the All Contacts page. You may select the appropriate group(s) at this point.', 'contact-list'); ?></li>
        <li><?= __('Insert the shortcode', 'contact-list') ?>
          <span class="contact-list-shortcode contact-list-shortcode-8">[contact_list_groups]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-8"><?= __('Copy', 'contact-list') ?></button>        
          <?= __('to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list'); ?></li>
        <li><?= __('Additional parameters', 'contact-list'); ?>
            <ul class="contact-list-admin-ul">
                <li><?= __('Order by first name:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-16">[contact_list_groups order_by=first_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-16"><?= __('Copy', 'contact-list') ?></button>
                </li>
                <li><?= __('Order by last name:', 'contact-list') ?>
                  <span class="contact-list-shortcode contact-list-shortcode-17">[contact_list_groups order_by=last_name]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-17"><?= __('Copy', 'contact-list') ?></button>
                </li>
            </ul>
        </li>
      </ol>

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
          <ul class="contact-list-admin-ul">
            <li><?= __('Show filters', 'contact-list') ?>: <span class="contact-list-shortcode contact-list-shortcode-13">[contact_list_groups group=GROUP_SLUG show_filters=1]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-13"><?= __('Copy', 'contact-list') ?></button></li>
          </ul>
        </li>
      </ol>

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

      <h3>
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
