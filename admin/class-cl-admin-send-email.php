<?php

class ContactListAdminSendEmail
{
    public function register_send_email_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'Send email to contacts', 'contact-list' ),
            __( 'Send email', 'contact-list' ),
            'manage_options',
            'contact-list-send-email',
            [ $this, 'register_send_email_page_callback' ]
        );
    }
    
    public function register_send_email_page_callback()
    {
        $term_id = ( isset( $_GET['group_id'] ) ? $_GET['group_id'] : 0 );
        $tax_query = [];
        if ( $term_id ) {
            $tax_query = array( array(
                'taxonomy'         => 'contact-group',
                'field'            => 'term_id',
                'terms'            => $term_id,
                'include_children' => true,
            ) );
        }
        $wpb_all_query = new WP_Query( array(
            'post_type'      => CONTACT_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'tax_query'      => $tax_query,
        ) );
        $recipient_emails = [];
        if ( $wpb_all_query->have_posts() ) {
            while ( $wpb_all_query->have_posts() ) {
                $wpb_all_query->the_post();
                $c = get_post_custom();
                if ( isset( $c['_cl_email'] ) && sanitize_email( $c['_cl_email'][0] ) ) {
                    $recipient_emails[] = $c['_cl_email'][0];
                }
            }
        }
        wp_reset_postdata();
        ?>
    
    <div class="wrap">

      <form method="post" class="send_email_form" action="" target="send_email">

          <h1><?php 
        echo  __( 'Send email to contacts', 'contact-list' ) ;
        ?></h1>

          <div>
            
              <br />
            
              <span class="restrict-recipients-title"><?php 
        echo  __( 'Restrict recipients to specific group', 'contact-list' ) ;
        ?></span>

              <?php 
        $taxonomies = get_terms( array(
            'taxonomy'   => 'contact-group',
            'hide_empty' => false,
        ) );
        $output = '';
        if ( !empty($taxonomies) ) {
            foreach ( $taxonomies as $category ) {
                
                if ( $category->parent == 0 ) {
                    $output .= '<label class="contact-category"><input type="radio" name="_cl_groups[]" value="' . esc_attr( $category->term_id ) . '" onclick="document.location.href=\'./edit.php?post_type=' . CONTACT_CPT . '&page=contact-list-send-email&group_id=\' + this.value;" ' . (( isset( $_GET['group_id'] ) && $_GET['group_id'] == $category->term_id ? 'checked' : '' )) . ' /> <span class="contact-list-checkbox-title">' . esc_attr( $category->name ) . '</span></label>';
                    foreach ( $taxonomies as $subcategory ) {
                        if ( $subcategory->parent == $category->term_id ) {
                            $output .= '<label class="contact-subcategory"><input type="radio" name="_cl_groups[]" value="' . esc_attr( $subcategory->term_id ) . '" onclick="document.location.href=\'./edit.php?post_type=' . CONTACT_CPT . '&page=contact-list-send-email&group_id=\' + this.value;" ' . (( isset( $_GET['group_id'] ) && $_GET['group_id'] == $subcategory->term_id ? 'checked' : '' )) . ' /> <span class="contact-list-checkbox-title">' . esc_html( $subcategory->name ) . '</span></label>';
                        }
                    }
                }
            
            }
        }
        echo  '<div class="contact-list-restrict-to-groups">' ;
        echo  $output ;
        echo  '</div>' ;
        ?>

          </div>

          <span class="recipients-title"><?php 
        echo  __( 'Recipients', 'contact-list' ) ;
        ?> (<?php 
        echo  __( 'total of', 'contact-list' ) ;
        ?> <?php 
        echo  sizeof( $recipient_emails ) ;
        ?> <?php 
        echo  __( 'contacts with email addresses', 'contact-list' ) ;
        ?>)</span>
          <div><?php 
        echo  implode( ", ", $recipient_emails ) ;
        ?></div>
          <input name="recipient_emails" type="hidden" value="<?php 
        echo  implode( ",", $recipient_emails ) ;
        ?>" />

          <hr class="style-one" />

          <label>
            <span><?php 
        echo  __( 'Subject', 'contact-list' ) ;
        ?></span>
            <input name="subject" value="" />
          </label>

          <?php 
        $user_id = get_current_user_id();
        ?>
          <?php 
        $user = get_userdata( $user_id );
        ?>
          
          <label>
            <span><?php 
        echo  __( 'Sender name', 'contact-list' ) ;
        ?></span>
            <input name="sender_name" value="" />
          </label>

          <label>
            <span><?php 
        echo  __( 'Sender email', 'contact-list' ) ;
        ?></span>
            <input name="sender_email" value="" />
          </label>
    
          <label>
            <span><?php 
        echo  __( 'Message', 'contact-list' ) ;
        ?></span>
            <textarea name="body"></textarea>
          </label>

          <?php 
        ?>

            <?php 
        echo  ContactListHelpers::proFeatureMarkup() ;
        ?>
            
          <?php 
        ?>
          
      </form>

    </div>
    <?php 
    }
    
    public function cl_send_mail()
    {
        $subject = ( isset( $_POST['subject'] ) ? $_POST['subject'] : '' );
        $sender_name = ( isset( $_POST['sender_name'] ) ? $_POST['sender_name'] : '' );
        $sender_email = ( isset( $_POST['sender_email'] ) ? $_POST['sender_email'] : '' );
        $mail_cnt = ( isset( $_POST['mail_cnt'] ) ? $_POST['mail_cnt'] : '' );
        $reply_to = ( isset( $_POST['reply_to'] ) ? $_POST['reply_to'] : '' );
        $body = ( isset( $_POST['body'] ) ? $_POST['body'] : '' );
        $body .= '<br /><br />-- <br />' . __( 'This mail was sent using Contact List Pro', 'contact-list' );
        $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
        if ( $sender_name && $sender_email && is_email( $sender_email ) ) {
            $headers[] .= 'From: ' . $sender_name . ' <' . $sender_email . '>';
        }
        $recipient_emails = ( isset( $_POST['recipient_emails'] ) ? $_POST['recipient_emails'] : '' );
        $resp = wp_mail(
            $recipient_emails,
            $subject,
            $body,
            $headers
        );
        
        if ( $resp ) {
            global  $wpdb ;
            $report = 'Mail successfully processed using <strong>wp_mail</strong>.<br /><br /><strong>Full list of recipient(s):</strong><br />' . str_replace( ',', ', ', $recipient_emails );
            $all_emails = explode( ',', $recipient_emails );
            $mail_cnt = sizeof( $all_emails );
            $wpdb->insert( $wpdb->prefix . 'cl_sent_mail_log', array(
                'subject'      => $subject,
                'sender_name'  => $sender_name,
                'reply_to'     => $reply_to,
                'report'       => $report,
                'sender_email' => $sender_email,
                'mail_cnt'     => $mail_cnt,
            ) );
        }
        
        wp_die();
    }
    
    public function new_contact_send_email( $post_id, $post, $update )
    {
        $post_title = get_the_title( $post_id );
        $s = get_option( 'contact_list_settings' );
        
        if ( isset( $s['send_email'] ) && isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) && $post->post_type == CONTACT_CPT && ($post->post_status == 'pending' || $post->post_status == 'draft') ) {
            $contact_list_admin_url = get_admin_url() . 'edit.php?post_type=' . CONTACT_CPT;
            $data = array(
                'post_title'      => $post_title,
                'recipient_email' => $s['recipient_email'],
                'url'             => $contact_list_admin_url,
            );
            $headers = array( 'Content-Type: text/html; charset=UTF-8' );
            $subject = 'New contact: ' . $post_title;
            $body_html = '';
            $body_html .= '<html><head><title></title></head><body>';
            $body_html .= '<h3 style="color: #000;">New contact was added: ' . $post_title . '</h3>';
            $body_html .= '<p style="color: #000;">See the full details here: ' . $contact_list_admin_url . '</p>';
            $body_html .= '<p style="color: #bbb;">-- <br />This email was sent by Contact List Pro</p>';
            $body_html .= '</body></html>';
            $resp = wp_mail(
                $s['recipient_email'],
                $subject,
                $body_html,
                $headers
            );
            
            if ( $resp ) {
                global  $wpdb ;
                $report = 'Mail successfully processed using <strong>wp_mail</strong>.<br /><br /><strong>Full list of recipient(s):</strong><br />' . $s['recipient_email'];
                $wpdb->insert( $wpdb->prefix . 'cl_sent_mail_log', array(
                    'subject'  => $subject,
                    'report'   => $report,
                    'mail_cnt' => 1,
                ) );
            }
        
        }
    
    }
    
    public function wp_mail_returnpath_phpmailer_init( $phpmailer )
    {
        $s = get_option( 'contact_list_settings' );
        // Set the Sender (return-path)
        if ( isset( $s['set_return_path'] ) ) {
            // && filter_var($params->Sender, FILTER_VALIDATE_EMAIL) !== true) {
            $phpmailer->Sender = $phpmailer->From;
        }
    }

}