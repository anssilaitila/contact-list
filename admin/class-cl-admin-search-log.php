<?php

class ContactListAdminSearchLog {

  public function register_search_log_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_LIST_CPT,
      sanitize_text_field( __('Search log', 'contact-list') ),
      sanitize_text_field( __('Search log', 'contact-list') ),
      'manage_options',
      'contact-list-search-log',
      [ $this, 'register_search_log_page_callback' ]
    );
  }

  public function register_search_log_page_callback() {

    $s = get_option('contact_list_settings');

    ?>

    <div class="wrap contact-list-admin-page">

      <h1 style="margin-bottom: 20px; display: none;"><?php echo esc_html__('Search log', 'contact-list'); ?></h1>

      <div class="contact-list-admin-section">

        <h2><?php echo esc_html__('Search log', 'contact-list') ?></h2>

        <?php if ( !isset( $s['enable_search_log'] ) ): ?>

          <div class="contact-list-black-box"><?php echo esc_html__('Search log is currently disabled and can be activated from the plugin settings.', 'contact-list'); ?></div>

        <?php endif; ?>

        <?php if (isset($_GET['search_log_emptied'])): ?>

          <?php echo '<div class="contact-list-search-log-success">' . esc_html__('Search log successfully emptied.', 'contact-list') . '</div>'; ?>

        <?php elseif (isset($_GET['search_log_emptied_error'])): ?>

          <?php echo '<div class="contact-list-search-log-success-error">' . esc_html__('Search log not emptied.', 'contact-list') . '</div>'; ?>

        <?php else: ?>

          <form method="post" class="contact-list-empty-search-log-form">
          <input type="hidden" name="_contact_list_empty_search_log" value="1" />

          <?php echo wp_nonce_field('_contact-list-empty-search-log', '_wpnonce', true, false) ?>

          <input type="submit" value="<?php echo esc_attr__('Empty search log', 'contact-list') ?>" class="contact-list-empty-search-log" />
          </form>

        <?php endif; ?>

        <?php

        global $wpdb;

        $items_per_page = 200;
        $page = isset( $_GET['log-page'] ) ? abs( (int) $_GET['log-page'] ) : 1;
        $offset = ( $page * $items_per_page ) - $items_per_page;

        $query = "SELECT * FROM {$wpdb->prefix}contact_list_search_log";

        $total_query = "SELECT COUNT(1) FROM ({$query}) AS combined_table";
        $total = $wpdb->get_var( $total_query );

        $results = $wpdb->get_results( $query . ' ORDER BY id DESC LIMIT ' . $offset . ', ' .  $items_per_page, OBJECT );

        ?>

        <table class="contact-list-admin-log">
        <tr>
          <th><?php echo esc_html__('Date', 'contact-list') ?></th>
          <th><?php echo esc_html__('Search term', 'contact-list') ?></th>
          <th><?php echo esc_html__('Search container', 'contact-list') ?></th>
          <th><?php echo esc_html__('User IP', 'contact-list') ?></th>
          <th><?php echo esc_html__('Referer URL', 'contact-list') ?></th>
          <th><?php echo esc_html__('User agent', 'contact-list') ?></th>
        </tr>

        <?php if (sizeof($results) > 0): ?>

          <?php foreach ($results as $row): ?>

            <tr>
              <td>
                <?php echo esc_html( $row->created_at ) ?>
              </td>
              <td>
                <?php if (isset($row->search)): ?>
                  <?php echo esc_html( $row->search ) ?>
                <?php endif; ?>
              </td>
              <td>

                <?php

                  if (isset($row->post_id) && $post_id = $row->post_id) {
                    $current_permalink = esc_url_raw( get_permalink( $post_id ) );
                    $edit_url = esc_url_raw( get_admin_url(null, './post.php?post=' . $post_id . '&action=edit') );
                    echo '<div>' . esc_url( $row->permalink ) . '</div>';
                    echo '<a class="contact-list-admin-log-edit-btn" href="' . esc_url( $edit_url ) . '">' . esc_html__('Edit', 'contact-list') . '</a>';

                  }

                ?>

              </td>

              <td>
                <?php if (isset($row->user_ip)): ?>
                  <?php echo esc_html( $row->user_ip ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->referer_url)): ?>
                  <?php echo esc_html( $row->referer_url ) ?>
                <?php endif; ?>
              </td>
              <td>
                <?php if (isset($row->user_agent)): ?>
                  <?php echo esc_html( $row->user_agent ) ?>
                <?php endif; ?>
              </td>
            </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr>
            <td colspan="7">
              <?php echo esc_html__('No search log stored yet.', 'contact-list') ?>
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
