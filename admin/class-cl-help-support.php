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
    
    <?php $num = 0 ?>

    <link rel="stylesheet" href="<?= CONTACT_LIST_URI ?>dist/tipso.min.css">
    <script src="<?= CONTACT_LIST_URI ?>dist/tipso.min.js"></script>
    
    <div class="wrap">

      <h1><?= __('How to use Contact List', 'contact-list'); ?></h1>

      <div class="contact-list-examples">
          <p><?= __('Some examples on how you can use different views available at', 'contact-list') ?> <a href="https://www.contactlistpro.com/contact-list/" target="_blank"><?= __('contactlistpro.com', 'contact-list') ?></a>.</p>
          <p><?= __('Any kind of feedback is welcome. You may contact the author at', 'contact-list') . ' <a href="https://www.contactlistpro.com/support/" target="_blank">contactlistpro.com/support/</a>.'; ?></p>
      </div>

      <div class="contact-list-admin-section">
        <h2><?= __('Instructions for basic usage', 'contact-list') ?></h2>
        <ol>
          <li>
            <?php
            $url = get_admin_url() . 'edit.php?post_type=contact';
            $text = sprintf(
              wp_kses(
                /* translators: %s: link to file management */
                __('Add the contacts from the <a href="%s" target="_blank">contact management</a>. You can add categories, country, state and city directly to the contact.', 'contact-list'),
                array('a' => array('href' => array(), 'target' => array()))
              ),
              esc_url($url) 
            );
            echo $text;
            ?>
          </li>
          <li>
            <?= __('Insert either one of these shortcodes to any page or post:', 'contact-list'); ?><br />
        
            <ul class="contact-list-admin-ul-v2">
              <li><?= __('The default contact list:', 'contact-list') ?><br /><?php $num++ ?><span class="contact-list-shortcode contact-list-shortcode-only contact-list-shortcode-<?= $num ?>" data-tooltip-class="contact-list-shortcode-<?= $num ?>">[contact_list]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-<?= $num ?>"><?= __('Copy', 'contact-list') ?></button></li>
              <li><?= __('A simpler list of contacts:', 'contact-list') ?><br /><?php $num++ ?><span class="contact-list-shortcode contact-list-shortcode-only contact-list-shortcode-<?= $num ?>" data-tooltip-class="contact-list-shortcode-<?= $num ?>">[contact_list_simple]</span><button class="contact-list-copy" data-clipboard-action="copy" data-clipboard-target=".contact-list-shortcode-<?= $num ?>"><?= __('Copy', 'contact-list') ?></button></li>
            </ul>
  
            <strong>
            <?php
            $url = get_admin_url() . 'edit.php?post_type=contact&page=contact-list-shortcodes';
            $text = sprintf(
              wp_kses(
                /* translators: %s: link to the list of available shortcodes */
                __('A complete list of available shortcodes can be found <a href="%s">here</a>.', 'contact-list'),
                array('a' => array('href' => array(), 'target' => array()))
              ),
              esc_url($url) 
            );
            echo $text;
            ?>
            </strong>
            
          </li>
        </ol>
      </div>

      <div class="contact-list-admin-section">
      
        <h2><?= esc_html__('Ratings & Reviews', 'contact-list') ?></h2>
      
        <p>
          <?php
          $text = sprintf(
            wp_kses(
              __('If you like <strong>Contact List</strong> please consider leaving a ★★★★★ rating.', 'contact-list'),
              array('strong' => array())
            )
          );
          echo $text;
          ?>
      
        </p>
        <p>
          <?= esc_html__('A huge thanks in advance!', 'contact-list'); ?>
        </p>
      
        <a href="https://wordpress.org/support/view/plugin-reviews/contact-list?filter=5#postform" target="_blank" class="button-primary"><?= esc_html__('Leave a rating', 'contact-list'); ?></a>
        
      </div>

      <script>
        jQuery(function ($) {
          $('.contact-list-toggle-debug-info').on('click', function() {
            if ($('.contact-list-debug-info-container').is(':hidden')) {
              $('.contact-list-debug-info-container').show();
              $(this).text("<?= esc_js( __('Close', 'shared-files') ) ?>");
            } else {
              $('.contact-list-debug-info-container').hide();
              $(this).text("<?= esc_js( __('Open', 'shared-files') ) ?>");
            }
          });
        });
      </script>

      <div class="contact-list-admin-section">
      
        <h2><?= esc_html__('Debug Info', 'contact-list'); ?> <button class="contact-list-toggle-debug-info"><?= esc_html__('Open', 'contact-list'); ?></button></h2>
      
        <div class="contact-list-debug-info-container">
      
          <div class="contact-list-info-small">
            <p><?= esc_html__('This section contains some debug info, which may be useful when trying to solve abnormal behaviour of the plugin.', 'contact-list') ?></a></p>
          </div>
      
          <?php
          global $wpdb;
          $table_name = $wpdb->prefix . 'contact_list_log';
          $msg = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 200");
          ?>
          
          <table class="contact-list-mail-log" style="min-width: 400px;">

          <tr>
            <th><?= esc_html__('Date', 'contact-list') ?></th>
            <th><?= esc_html__('Title', 'contact-list') ?></th>
            <th><?= esc_html__('Message', 'contact-list') ?></th>
          </tr>
          
          <?php if (sizeof($msg) > 0): ?>

            <?php foreach ($msg as $row): ?>
              <tr>

                <td style="white-space: nowrap;">
                  <?= $row->created_at ?>
                </td>

                <td>
                  <?= $row->title ?><br />
                </td>

                <td>
                  <?php if (isset($row->message)): ?>
                    <?= nl2br( $row->message ) ?>
                  <?php endif; ?>
                </td>

              </tr>
            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="3">
                <?= __('No data logged yet.', 'contact-list') ?>
              </td>
            </tr>

          <?php endif; ?>
      
      
      
        </div>
        
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
