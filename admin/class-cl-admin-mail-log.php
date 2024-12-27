<?php

class ContactListAdminMailLog {

  public function register_mail_log_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_LIST_CPT,
      sanitize_text_field( __('Mail log', 'contact-list') ),
      sanitize_text_field( __('Mail log', 'contact-list') ),
      'manage_options',
      'contact-list-mail-log',
      [ $this, 'register_mail_log_page_callback' ]
    );
  }

  public function register_mail_log_page_callback() {

    $s = get_option('contact_list_settings');

    $term_id = isset($_GET['group_id']) ? intval( $_GET['group_id'] ) : 0;

    $tax_query = [];

    if ($term_id) {

      $tax_query = array(

        array(
          'taxonomy'          => 'contact-group',
          'field'             => 'term_id',
          'terms'             => $term_id,
          'include_children'  => true
        ));

    }

    $wpb_all_query = new WP_Query(array(
      'post_type'       => CONTACT_LIST_CPT,
      'post_status'     => 'publish',
      'posts_per_page'  => -1,

      'tax_query' => $tax_query
    ));

    $recipient_emails = [];

    if ($wpb_all_query->have_posts()) {

      while ($wpb_all_query->have_posts()) {

        $wpb_all_query->the_post();

        $c = get_post_custom();

        if (isset($c['_cl_email'][0]) && is_email($c['_cl_email'][0])) {
          $recipient_emails []= sanitize_email( $c['_cl_email'][0] );
        }

      }

    }

    wp_reset_postdata();

    ?>

    <div class="wrap contact-list-admin-page">

      <h1 style="margin-bottom: 20px; display: none;"><?php echo esc_html__('Log of sent mail', 'contact-list'); ?></h1>

      <div class="contact-list-admin-section">

        <h2><?php echo esc_html__('Mail log', 'contact-list') ?></h2>

        <?php if ( isset( $s['disable_mail_log'] ) ): ?>

          <div class="contact-list-black-box"><?php echo esc_html__('Mail log is currently disabled and can be activated from the plugin settings.', 'contact-list'); ?></div>

        <?php endif; ?>

        <?php if (isset($_GET['mail_id'])): ?>

          <?php

          $mail_id = (int) $_GET['mail_id'];

          global $wpdb;
          $msg = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cl_sent_mail_log WHERE id = " . $mail_id);

          ?>

          <a href="javascript:history.go(-1)" style="margin-top: 18px; font-weight: 700; display: inline-block;">&lt;&lt; <?php echo esc_html__('Back', 'contact-list') ?></a>

          <?php foreach ($msg as $row): ?>

            <table class="contact-list-mail-log-msg-details">
            <tr>
              <td><?php echo esc_html__('Message sent', 'contact-list') ?></td>
              <td><?php echo esc_html( $row->created_at ) ?></td>
            </tr>
            <tr>
              <td><?php echo esc_html__('Sender email', 'contact-list') ?></td>
              <td>
                <?php if (isset($row->sender_email)): ?>
                  <?php echo esc_html( $row->sender_email ) ?>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td><?php echo esc_html__('Sender name', 'contact-list') ?></td>
              <td><?php echo esc_html( $row->sender_name ) ?></td>
            </tr>
            <tr>
              <td><?php echo esc_html__('Reply-to', 'contact-list') ?></td>
              <td>
                <?php if (isset($row->reply_to)): ?>
                  <?php echo esc_html( $row->reply_to ) ?>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td><?php echo esc_html__('Subject', 'contact-list') ?></td>
              <td><?php echo esc_html( $row->subject ) ?></td>
            </tr>
            <tr>
              <td><?php echo esc_html__('Message count', 'contact-list') ?></td>
              <td><?php echo esc_html( $row->mail_cnt ) ?></td>
            </tr>
            </table>

            <h3><?php echo esc_html__('Mail report:', 'contact-list') ?></h3>

            <div class="contact-list-mail-log-recipients-container">
              <?php echo wp_kses_post( $row->report ) ?>
            </div>

          <?php endforeach; ?>

        <?php else: ?>

          <?php if (isset($_GET['mail_log_emptied'])): ?>

            <?php echo '<div class="contact-list-mail-log-success">' . esc_html__('Mail log successfully emptied.', 'contact-list') . '</div>'; ?>

          <?php elseif (isset($_GET['mail_log_emptied_error'])): ?>

            <?php echo '<div class="contact-list-mail-log-success-error">' . esc_html__('Mail log not emptied.', 'contact-list') . '</div>'; ?>

          <?php else: ?>

            <form method="post" class="contact-list-empty-mail-log-form">
            <input type="hidden" name="_contact_list_empty_mail_log" value="1" />

            <?php echo wp_nonce_field('_contact-list-empty-mail-log', '_wpnonce', true, false) ?>

            <input type="submit" value="<?php echo esc_attr__('Empty mail log', 'contact-list') ?>" class="contact-list-empty-mail-log" />
            </form>

          <?php endif; ?>

          <?php

          global $wpdb;

          $items_per_page = 200;
          $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
          $offset = ( $page * $items_per_page ) - $items_per_page;

          $query = "SELECT * FROM {$wpdb->prefix}cl_sent_mail_log";

          $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
          $total = $wpdb->get_var( $total_query );

          $results = $wpdb->get_results( $query . ' ORDER BY id DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

          ?>

          <table class="contact-list-admin-log">
          <tr>
            <th><?php echo esc_html__('Date', 'contact-list') ?></th>
            <th><?php echo esc_html__('Sender', 'contact-list') ?></th>
            <th><?php echo esc_html__('Reply-to', 'contact-list') ?></th>
            <th><?php echo esc_html__('Subject', 'contact-list') ?></th>
            <th><?php echo esc_html__('Recipients', 'contact-list') ?></th>
          </tr>

          <?php if (sizeof($results) > 0): ?>

            <?php foreach ($results as $row): ?>

              <tr>
                <td>
                  <?php echo esc_html( $row->created_at ) ?>
                </td>
                <td>

                  <?php echo esc_html( $row->sender_name ) ?><br />

                  <?php if (isset($row->sender_email)): ?>
                    <?php echo esc_html( $row->sender_email ) ?>
                  <?php endif; ?>

                </td>
                <td>
                  <?php if (isset($row->reply_to)): ?>
                    <?php echo esc_html( $row->reply_to ) ?>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="./edit.php?post_type=<?php echo CONTACT_LIST_CPT ?>&page=contact-list-mail-log&mail_id=<?php echo esc_attr( $row->id ) ?>"><?php echo esc_html( $row->subject ) ?></a>
                </td>
                <td>
                  <?php if ($row->mail_cnt == 0): ?>

                    <span style="color: red; font-weight: bold;"><?php echo esc_html__('ERROR', 'contact-list') ?></span>

                  <?php else: ?>

                    <?php echo esc_html( $row->mail_cnt ) ?>

                  <?php endif; ?>
                </td>
              </tr>

            <?php endforeach; ?>

          <?php else: ?>

            <tr>
              <td colspan="7">
                <?php echo esc_html__('No mail sent yet.', 'contact-list') ?>
              </td>
            </tr>

          <?php endif; ?>

          </table>

          <div class="contact-list-admin-pagination-container">

            <?php
            echo paginate_links( array(
              'base' => add_query_arg( 'log-page', '%#%' ),
              'format' => '',
              'prev_text' => __('&laquo;'),
              'next_text' => __('&raquo;'),
              'total' => ceil($total / $items_per_page),
              'current' => $page
            ));
            ?>

          </div>

        <?php endif; ?>

      </div>

    </div>

    <?php
  }

}
