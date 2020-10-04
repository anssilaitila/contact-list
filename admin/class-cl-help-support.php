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
    
    <div class="wrap">

      <h1><?= __('How to use Contact List', 'contact-list'); ?></h1>

      <div class="contact-list-examples">
          <p><?= __('Some examples on how you can use different views available at', 'contact-list') ?> <a href="https://www.contactlistpro.com/contact-list/" target="_blank"><?= __('contactlistpro.com', 'contact-list') ?></a>.</p>
          <p><?= __('Any feedback is welcome. You may contact the author at', 'contact-list') . ' <a href="https://www.tammersoft.com/" target="_blank">tammersoft.com</a> ' . __('or by email:', 'contact-list') ?> <a href="javascript:location='mailto:\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d';void 0"><script type="text/javascript">document.write('\u0063\u006f\u006e\u0074\u0061\u0063\u0074\u0040\u0074\u0061\u006d\u006d\u0065\u0072\u0073\u006f\u0066\u0074\u002e\u0063\u006f\u006d')</script></a></p>
      </div>

      <span class="contact-list-shortcodes-link"><?= __('A complete list of available shortcodes can be found at', 'shared-files') ?> <a href="https://www.contactlistpro.com/support/shortcodes/" target="_blank">https://www.contactlistpro.com/support/shortcodes/</a></span>

      <h2><?= __('Only contacts, no groups', 'contact-list'); ?></h2>

      <ol>
        <li><?= __('Add the contacts via the All Contacts page.', 'contact-list'); ?></li>
        <li><?= __('Insert the shortcode <span class="contact-list-shortcode">[contact_list]</span> to the content editor of any page you wish the contact list to appear.', 'contact-list'); ?></li>
        <li><?= __('Additional parameters', 'contact-list'); ?>
            <ul class="contact-list-admin-ul">
                <li><?= __('Hide search form:', 'contact-list') ?> <span class="contact-list-shortcode">[contact_list hide_search=1]</span></li>
                <li><?= __('Layout "2 cards on the same row"', 'contact-list') ?>: <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row]</span></li>
                <li><?= __('Layout "3 cards on the same row"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>): <span class="contact-list-shortcode">[contact_list layout=3-cards-on-the-same-row]</span></li>
                <li><?= __('Layout "4 cards on the same row"', 'contact-list') ?> (<?= __('without contact images', 'contact-list') ?>): <span class="contact-list-shortcode">[contact_list layout=4-cards-on-the-same-row]</span></li>
                <li><?= __('Multiple parameters:', 'contact-list') ?> <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row hide_search=1]</span></li>
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
        <li><?= __('Insert the shortcode <span class="contact-list-shortcode">[contact_list_groups]</span> to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list'); ?></li>
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
        <li><?= __('Insert the shortcode', 'contact-list') . '<span class="contact-list-shortcode">[contact_list_groups group=GROUP_SLUG]</span>' . __('to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list'); ?></li>
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
        <li><?= __('Insert the shortcode', 'contact-list') . '<span class="contact-list-shortcode">[contact_list contact=CONTACT_ID]</span>' . __('to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.' , 'contact-list'); ?></li>
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
        <li><?= __('Insert the shortcode', 'contact-list') . '<span class="contact-list-shortcode">[contact_list_form]</span>' . __('to the page you wish the form to appear on.', 'contact-list'); ?></li>
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
        <li><?= __('Insert the shortcode', 'contact-list') . '<span class="contact-list-shortcode">[contact_list_search]</span>' . __('to the page you wish the view to appear on.', 'contact-list'); ?></li>
      </ol>

    </div>
    <?php
  }

}
