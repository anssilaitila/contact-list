<?php

class ContactListAdminSendEmail {
    public function register_send_email_page() {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_LIST_CPT,
            sanitize_text_field( __( 'Send email to contacts', 'contact-list' ) ),
            sanitize_text_field( __( 'Send email', 'contact-list' ) ),
            'manage_options',
            'contact-list-send-email',
            [$this, 'register_send_email_page_callback']
        );
    }

    public function register_send_email_page_callback() {
        $s = get_option( 'contact_list_settings' );
        $term_id = ( isset( $_GET['group_id'] ) ? intval( $_GET['group_id'] ) : 0 );
        $wpb_all_query = new WP_Query(array(
            'post_type'      => CONTACT_LIST_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ));
        $recipient_emails = [];
        if ( $wpb_all_query->have_posts() ) {
            while ( $wpb_all_query->have_posts() ) {
                $wpb_all_query->the_post();
                $c = get_post_custom();
                if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) ) {
                    $recipient_emails[] = sanitize_email( $c['_cl_email'][0] );
                }
            }
        }
        wp_reset_postdata();
        ?>

    <div class="wrap contact-list-admin-page">

      <form method="post" class="contact-list-admin-send-email-form" action="" target="send_email">

        <?php 
        $is_premium = 0;
        ?>

        <?php 
        if ( ContactListHelpers::isPremium() == 0 ) {
            ?>
          <?php 
            echo ContactListHelpers::proFeatureMarkup();
            ?>
          <br />
        <?php 
        }
        ?>

        <div>

          <div class="contact-list-admin-send-message-to">

            <div class="contact-list-admin-send-message-to-title">
              <span><?php 
        echo esc_html__( 'Send message to:', 'contact-list' );
        ?></span>
            </div>

            <div class="contact-list-admin-send-message-to-contacts">

              <?php 
        $taxonomy_slug = 'contact-group';
        if ( get_taxonomy( $taxonomy_slug ) ) {
            if ( has_term( '', $taxonomy_slug ) ) {
                wp_dropdown_categories( [
                    'show_option_all' => sanitize_text_field( __( 'All contacts', 'contact-list' ) ),
                    'hide_empty'      => 1,
                    'hierarchical'    => 1,
                    'show_count'      => 0,
                    'orderby'         => 'name',
                    'name'            => $taxonomy_slug,
                    'value_field'     => 'id',
                    'taxonomy'        => $taxonomy_slug,
                ] );
            } else {
                echo '<span>' . esc_html__( 'All contacts', 'contact-list' ) . '</span>';
            }
        }
        ?>

            </div>

          </div>

        </div>

        <div class="contact-list-admin-recipients-container">

          <?php 
        if ( sizeof( $recipient_emails ) > 0 ) {
            ?>

            <span class="contact-list-admin-recipients-title">
              <?php 
            echo esc_html__( 'Currently sending message to', 'contact-list' );
            ?>
              <?php 
            echo sizeof( $recipient_emails );
            ?>

              <?php 
            if ( sizeof( $recipient_emails ) == 1 ) {
                ?>
                <?php 
                echo esc_html__( 'contact', 'contact-list' );
                ?>:
              <?php 
            } else {
                ?>
                <?php 
                echo esc_html__( 'contacts', 'contact-list' );
                ?>:
              <?php 
            }
            ?>
            </span>

            <div class="contact-list-admin-recipients-content"><?php 
            echo implode( ', ', $recipient_emails );
            ?></div>

            <input name="recipient_emails" type="hidden" value="<?php 
            echo esc_attr( implode( ',', $recipient_emails ) );
            ?>" />

          <?php 
        } else {
            ?>

            <div class="contact-list-admin-no-contacts-found">

              <?php 
            echo ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found in this group.', 'contact-list' ) );
            ?>

              <?php 
            $url = esc_url_raw( get_admin_url() . 'edit.php?post_type=' . CONTACT_LIST_CPT );
            echo sprintf( wp_kses( 
                /* translators: %s: link to contact management */
                __( 'You may add contacts and assign them to groups from <a href="%s">contact management</a>.', 'contact-list' ),
                array(
                    'a' => array(
                        'href' => array(),
                    ),
                )
             ), esc_url( $url ) );
            ?>

            </div>

          <?php 
        }
        ?>

        </div>

        <p>
        <?php 
        $url = esc_url_raw( get_admin_url() . 'options-general.php?page=contact-list#contact-list-settings-tab-15' );
        echo sprintf( wp_kses( 
            /* translators: %s: link to contact management */
            __( 'Default values for the fields below can be changed from <a href="%s">the settings</a>.', 'contact-list' ),
            array(
                'a' => array(
                    'href' => array(),
                ),
            )
         ), esc_url( $url ) );
        ?>
        </p>

        <?php 
        $wp_admin_email_subject = '';
        $wp_admin_email_sender_name = '';
        $wp_admin_email_sender_email = '';
        $wp_admin_email_message = '';
        ?>

        <div class="contact-list-admin-send-message-container">

          <label>
            <span><?php 
        echo esc_html__( 'Subject', 'contact-list' );
        ?></span>
            <input name="subject" type="text" value="<?php 
        echo esc_attr( $wp_admin_email_subject );
        ?>" required />
          </label>

          <?php 
        $user_id = intval( get_current_user_id() );
        ?>
          <?php 
        $user = get_userdata( $user_id );
        ?>

          <label>
            <span><?php 
        echo esc_html__( 'Sender name', 'contact-list' );
        ?></span>
            <input name="sender_name" type="text" value="<?php 
        echo esc_attr( $wp_admin_email_sender_name );
        ?>" required />
          </label>

          <label>
            <span><?php 
        echo esc_html__( 'Sender email', 'contact-list' );
        ?></span>
            <input name="sender_email" type="email" value="<?php 
        echo esc_attr( $wp_admin_email_sender_email );
        ?>" required />
          </label>

          <label>
            <span><?php 
        echo esc_html__( 'Message', 'contact-list' );
        ?></span>
            <textarea name="body" required><?php 
        echo esc_html( $wp_admin_email_message );
        ?></textarea>
          </label>

          <input type="submit" class="contact-list-admin-send-message-submit contact-list-admin-default-btn" value="<?php 
        echo esc_attr__( 'Send', 'contact-list' );
        ?>" <?php 
        if ( sizeof( $recipient_emails ) == 0 || ContactListHelpers::isPremium() == 0 ) {
            echo 'disabled';
        }
        ?> />

          <div class="contact-list-admin-send-email-status">
          </div>

        </div>

      </form>

    </div>

    <?php 
    }

}
