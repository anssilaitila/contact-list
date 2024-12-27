<?php

class ContactListAdminImportLog {

  public function register_import_log_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_LIST_CPT,
      sanitize_text_field( __('Import log', 'contact-list') ),
      sanitize_text_field( __('Import log', 'contact-list') ),
      'manage_options',
      'contact-list-import-log',
      [ $this, 'register_import_log_page_callback' ]
    );
  }

  public static function write_log($title = '', $message = '') {

    global $wpdb;

    $wpdb->insert($wpdb->prefix . 'contact_list_import_log', array(
      'title'   => sanitize_text_field( $title ),
      'message' => sanitize_textarea_field( $message ),
    ));

  }

  public function register_import_log_page_callback() {

    $s = get_option('contact_list_settings');

    ?>

    <div class="wrap contact-list-admin-page">

      <h1 style="margin-bottom: 20px; display: none;"><?php echo esc_html__('Import log', 'contact-list'); ?></h1>

      <div class="contact-list-admin-section">

        <h2><?php echo esc_html__('Import log', 'contact-list') ?></h2>

        <?php if (isset($_GET['import_log_emptied'])): ?>

          <?php echo '<div class="contact-list-import-log-success">' . esc_html__('Import log successfully emptied.', 'contact-list') . '</div>'; ?>

        <?php elseif (isset($_GET['import_log_emptied_error'])): ?>

          <?php echo '<div class="contact-list-import-log-success-error">' . esc_html__('Import log not emptied.', 'contact-list') . '</div>'; ?>

        <?php else: ?>

          <form method="post" class="contact-list-empty-import-log-form">
          <input type="hidden" name="_contact_list_empty_import_log" value="1" />

          <?php echo wp_nonce_field('_contact-list-empty-import-log', '_wpnonce', true, false) ?>

          <input type="submit" value="<?php echo esc_attr__('Empty import log', 'contact-list') ?>" class="contact-list-empty-import-log" />
          </form>

        <?php endif; ?>

        <?php

        global $wpdb;

        $items_per_page = 200;
        $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
        $offset = ( $page * $items_per_page ) - $items_per_page;

        $query = "SELECT * FROM {$wpdb->prefix}contact_list_import_log";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );

        $results = $wpdb->get_results( $query . ' ORDER BY id DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

        ?>

        <table class="contact-list-admin-log">
        <tr>
          <th><?php echo esc_html__('Date', 'contact-list') ?></th>
          <th><?php echo esc_html__('Event', 'contact-list') ?></th>
        </tr>

        <?php if (sizeof($results) > 0): ?>

          <?php foreach ($results as $row): ?>

            <tr>
              <td>
                <?php echo esc_html( $row->created_at ) ?>
              </td>
              <td>

                <?php echo esc_html( $row->title ) ?>

                <?php if ( $row->message ): ?>
                  <br /><?php echo esc_html( $row->message ) ?>
                <?php endif; ?>

              </td>
            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="7">
              <?php echo esc_html__('No imports logged yet.', 'contact-list') ?>
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

      </div>

    </div>

    <?php
  }

}
