<?php

class ContactListPublicSendMail {

  public function cl_send_mail_public() {

    global $wpdb;

    $s = get_option('contact_list_settings');
    $contact_id = isset($_POST['contact_id']) ? $_POST['contact_id'] : '';
    $c = get_post_custom($contact_id);


    // Preprocess & format mail data

    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $sender_name = isset($_POST['sender_name']) ? $_POST['sender_name'] : '';
    $sender_email = isset($_POST['sender_email']) ? $_POST['sender_email'] : '';
    $mail_cnt = isset($_POST['mail_cnt']) ? $_POST['mail_cnt'] : '';
    
    $body = '';
    
    if ($sender_name) {
      $body .= __('Sent by:', 'contact-list') . ' ' . $sender_name;
    }
    
    if ($sender_email) {
      $body .= " &lt;" . $sender_email . "&gt;";
    }
    
    if ($sender_name || $sender_email) {
      $body .= "<br /><br />";
    }
    
    //    $body .= isset($_POST['body']) ? $_POST['body'] : '';
    $body .= isset($_POST['body']) ? nl2br( esc_html( stripslashes( $_POST['body'] ) ) ) : '';
    
    if (!isset($s['remove_email_footer'])) {
      $body .= "<br /><br />-- <br />" . ContactListHelpers::getText('text_email_footer', __('Sent by Contact List Pro', 'contact-list'));
    }
    
    $recipient_emails = '';
    $recipient_emails_array = [];
    
    if (isset($c['_cl_email'])) {
      $recipient_emails_array []= $c['_cl_email'][0];
    }
    
    if (isset($c['_cl_notify_emails'])) {
      
      $notify_emails = explode(',', $c['_cl_notify_emails'][0]);
      
      foreach ($notify_emails as $email) {
    
        if (is_email($email)) {
          $recipient_emails_array []= $email;
        }
        
      }
      
    }
    
    $recipient_emails = implode(',', $recipient_emails_array);
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    $reply_to = '';
    
    if ($sender_name && is_email($sender_email)) {
      $reply_to = $sender_name . ' <' . $sender_email . '>';
    } elseif (is_email($sender_email)) {
      $reply_to = '<' . $sender_email . '>';
    }
    
    if ($reply_to) {
      $headers[] = 'Reply-To: ' . $reply_to;
    }
    
    $from = '';
    
    if (isset($s['email_sender_contact_card']) && is_email($s['email_sender_contact_card'])) {
      
      if (isset($s['email_sender_name_contact_card']) && $s['email_sender_name_contact_card']) {
        $from = $s['email_sender_name_contact_card'] . ' <' . $s['email_sender_contact_card'] . '>';
      } else {
        $from = $s['email_sender_contact_card'];
      }
    }
    
    if ($from) {
      $headers[] = 'From: ' . $from;
    }

    $all_emails = explode(',', $recipient_emails);
    $mail_cnt = sizeof($all_emails);


    // recaptcha check

    if (isset($s['activate_recaptcha']) && isset($s['recaptcha_secret_key'])) {

      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $recaptcha_response = isset($_POST['recaptcha_response']) ? $_POST['recaptcha_response'] : '';
      $data = array('secret' => $s['recaptcha_secret_key'], 'response' => $recaptcha_response);
      
      $options = array(
        'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
        )
      );
  
      $context = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

      $msg = $url . "\n\n" . $recaptcha_response . "\n\n" . $s['recaptcha_secret_key'] . "\n\n" . $context . "\n\n" . $result;
      ContactListHelpers::writeLog('recaptcha check', $msg);
      
      if ($result) {
        $recaptcha_validation = json_decode($result);
  
        if (!$recaptcha_validation->{'success'}) {
          // Invalid reCAPTCHA challenge

          if (!isset($s['disable_recaptcha_from_mail_log'])) {

            $report = '<span style="color: crimson;"><strong>RECAPTCHA ERROR:</strong><br />' . serialize( $recaptcha_validation ) . '<br /><br /><strong>Mail WAS NOT sent to:</strong><br />' . ($recipient_emails ? str_replace(',', ', ', $recipient_emails) : '(no recipient emails defined)') . '</span>';
            
            $wpdb->insert($wpdb->prefix . 'cl_sent_mail_log', array(
               'subject' => $subject,
               'sender_name' => $sender_name,
               'reply_to' => $reply_to,
               'report' => $report,
               'sender_email' => $from,
               'mail_cnt' => 0
            ));

          }

          echo 'Invalid reCAPTCHA challenge';
          die();
          // wp_die();
        }
      } else {
        // Invalid reCAPTCHA challenge

        if (!isset($s['disable_recaptcha_from_mail_log'])) {
        
          $report = '<span style="color: crimson;"><strong>RECAPTCHA ERROR:</strong><br />No data returned<br /><br /><strong>Mail WAS NOT sent to:</strong><br />' . ($recipient_emails ? str_replace(',', ', ', $recipient_emails) : '(no recipient emails defined)') . '</span>';
          
          $wpdb->insert($wpdb->prefix . 'cl_sent_mail_log', array(
             'subject' => $subject,
             'sender_name' => $sender_name,
             'reply_to' => $reply_to,
             'report' => $report,
             'sender_email' => $from,
             'mail_cnt' => 0
          ));
        
        }

        $msg = $url . "\n\n" . $recaptcha_response . "\n\n" . $s['recaptcha_secret_key'] . "\n\n" . $context . "\n\n" . $result;
        ContactListHelpers::writeLog('RECAPTCHA ERROR: No data returned', $msg);

        echo 'Invalid reCAPTCHA challenge';
        die();

//        wp_die();
      }
      
    }

    // Send the mail

    $resp = wp_mail($recipient_emails, $subject, $body, $headers);


    // Write log

    if (!isset($s['disable_mail_log'])) {

      if ($resp && $recipient_emails) {
        
        $report = 'Mail successfully processed using <strong>wp_mail</strong>.<br /><br /><strong>Mail sent to:</strong><br />' . str_replace(',', ', ', $recipient_emails);
        
        $wpdb->insert($wpdb->prefix . 'cl_sent_mail_log', array(
           'subject' => $subject,
           'sender_name' => $sender_name,
           'reply_to' => $reply_to,
           'report' => $report,
           'sender_email' => $from,
           'mail_cnt' => $mail_cnt
        ));
  
      } else {
  
        $report = '<span style="color: crimson;">ERROR processing mail using <strong>wp_mail</strong>.<br /><br /><strong>Mail WAS NOT sent to:</strong><br />' . ($recipient_emails ? str_replace(',', ', ', $recipient_emails) : '(no recipient emails defined)') . '</span>';
  
        $wpdb->insert($wpdb->prefix . 'cl_sent_mail_log', array(
           'subject' => $subject,
           'sender_name' => $sender_name,
           'reply_to' => $reply_to,
           'report' => $report,
           'sender_email' => $from,
           'mail_cnt' => 0
        ));
  
      }
    
    }

    // Return message

    if ($resp && $recipient_emails) {
      echo 'OK';
    } else {
      echo 'Error processing mail';
    }

    die();

  }

}
