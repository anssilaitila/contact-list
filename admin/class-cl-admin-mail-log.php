<?php

class ContactListAdminMailLog {

  public function register_mail_log_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_CPT,
      __('Mail log', 'contact-list'),
      __('Mail log', 'contact-list'),
      'manage_options',
      'contact-list-mail-log',
      [ $this, 'register_mail_log_page_callback' ]
    );
  }

  public function register_mail_log_page_callback() {

    $term_id = isset($_GET['group_id']) ? $_GET['group_id'] : 0;

    $tax_query = [];

    if ($term_id) {
      $tax_query = array(
        array(
          'taxonomy' => 'contact-group',
          'field' => 'term_id',
          'terms' => $term_id,
          'include_children' => true
        ));
    }
    
    $wpb_all_query = new WP_Query(array(
      'post_type' => CONTACT_CPT,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      
      'tax_query' => $tax_query
    ));

    $recipient_emails = [];

    if ($wpb_all_query->have_posts()):
      while ($wpb_all_query->have_posts()): $wpb_all_query->the_post();
        $c = get_post_custom();
        if (isset($c['_cl_email']) && sanitize_email($c['_cl_email'][0])) {
          $recipient_emails []= $c['_cl_email'][0];
        }
      endwhile;
    endif;

    wp_reset_postdata();
    
    ?>
    
    <div class="wrap">

      <h1><?= __('Log of sent mail', 'contact-list'); ?></h1>

      <?php if (isset($_GET['mail_id'])): ?>

        <?php
          $mail_id = (int) $_GET['mail_id'];
          
          global $wpdb;
          $table_name = $wpdb->prefix . "cl_sent_mail_log";
          $msg = $wpdb->get_results("SELECT * FROM $table_name WHERE id = " . $mail_id);
        ?>
        
        <a href="javascript:history.go(-1)">&lt;&lt; Back</a>
        
        <?php foreach ($msg as $row): ?>

          <table class="contact-list-mail-log-msg-details">
          <tr>
            <td><?= __('Message sent', 'contact-list') ?></td>
            <td><?= $row->created_at ?></td>
          </tr>
          <tr>
            <td><?= __('Sender email', 'contact-list') ?></td>
            <td>
              <?php if (isset($row->sender_email)): ?>
                <?= htmlspecialchars($row->sender_email) ?>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td><?= __('Sender name', 'contact-list') ?></td>
            <td><?= $row->sender_name ?></td>
          </tr>
          <tr>
            <td><?= __('Reply-to', 'contact-list') ?></td>
            <td>
              <?php if (isset($row->reply_to)): ?>
                <?= htmlspecialchars($row->reply_to) ?>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td><?= __('Subject', 'contact-list') ?></td>
            <td><?= $row->subject ?></td>
          </tr>
          <tr>
            <td><?= __('Message count', 'contact-list') ?></td>
            <td><?= $row->mail_cnt ?></td>
          </tr>
          </table>
          
          <h3><?= __('Mail report:', 'contact-list') ?></h3>
          
          <div class="contact-list-mail-log-recipients-container">
            <?= $row->report ?>
          </div>

        <?php endforeach; ?>

      <?php else: ?>

        <?php if (isset($_GET['mail_log_emptied'])): ?>        
          <?php echo '<h2 style="color: green;">' . esc_html__('Mail log successfully emptied.', 'contact-list') . '</h2>'; ?>
        <?php else: ?>
          <form method="post" onsubmit="return confirm('<?php echo esc_attr__('Are you sure that you want to empty the mail log?', 'shared-files') ?>\n<?php echo esc_attr__('This action is irreversible.', 'shared-files') ?>')">
          <input type="hidden" name="_contact_list_empty_mail_log" value="1" />
          <input type="submit" value="Empty mail log" class="contact-list-empty-mail-log" />
          </form>
        <?php endif; ?>
            
        <?php
          global $wpdb;
          $table_name = $wpdb->prefix . 'cl_sent_mail_log';
          $msg = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 200");
        ?>
        
        <table class="contact-list-mail-log">
        <tr>
          <th><?= __('Date', 'contact-list') ?></th>
          <th><?= __('Sender', 'contact-list') ?></th>
          <th><?= __('Reply-to', 'contact-list') ?></th>
          <th><?= __('Subject', 'contact-list') ?></th>
          <th><?= __('Recipients', 'contact-list') ?></th>
        </tr>

        <?php if (sizeof($msg) > 0): ?>
          <?php foreach ($msg as $row): ?>
            <tr>
              <td>
                <?= $row->created_at ?>
              </td>
              <td>
                <?= $row->sender_name ?><br />
                <?php if (isset($row->sender_email)): ?>
                  <?= htmlspecialchars($row->sender_email) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->reply_to)): ?>
                  <?= htmlspecialchars($row->reply_to) ?>
                <?php endif; ?>
              </td>
              <td>
                <a href="./edit.php?post_type=<?= CONTACT_CPT ?>&page=contact-list-mail-log&mail_id=<?= $row->id ?>"><?= $row->subject ?></a>
              </td>
              <td>
                <?php if ($row->mail_cnt == 0): ?>
                  <span style="color: red; font-weight: bold;"><?= __('ERROR', 'contact-list') ?></span>
                <?php else: ?>
                  <?= $row->mail_cnt ?>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">
              <?= __('No mail sent yet.', 'contact-list') ?>
            </td>
          </tr>
        <?php endif; ?>
        
        </table>
        
      <?php endif; ?>

    </div>
    <?php
  }

}
