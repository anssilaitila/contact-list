<?php

class ContactListHelpers
{
    public static function proFeatureMarkup()
    {
        $html = '';
        $html .= '<div class="pro-feature">';
        $html .= '<span>' . __( 'This feature is available in the Pro version.', 'contact-list' ) . '</span>';
        $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . __( 'Upgrade here', 'contact-list' ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function proFeatureSettingsMarkup()
    {
        $html = '';
        $html .= '<div class="pro-feature">';
        $html .= '<span>' . __( 'More settings available in the Pro version.', 'contact-list' ) . '</span>';
        $html .= '<a href="' . get_admin_url() . 'options-general.php?page=contact-list-pricing">' . __( 'Upgrade here', 'contact-list' ) . '</a>';
        $html .= '</div>';
        return $html;
    }
    
    public static function modalSendMessageMarkup()
    {
        $s = get_option( 'contact_list_settings' );
        
        if ( isset( $s['activate_recaptcha'] ) ) {
            wp_enqueue_script( 'contact-list-recaptcha', 'https://www.google.com/recaptcha/api.js' );
            // async defer
        }
        
        $input = get_site_url();
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim( $input, '/' );
        // If scheme not included, prepend it
        if ( !preg_match( '#^http(s)?://#', $input ) ) {
            $input = 'http://' . $input;
        }
        $urlParts = parse_url( $input );
        // remove www
        $site_url = preg_replace( '/^www\\./', '', $urlParts['host'] );
        $html = '';
        $html .= '<div class="cl-modal-container">';
        $html .= '<div class="cl-modal">';
        $html .= '<div class="close-modal-container">';
        $html .= '<a href="" class="cl-close-modal">x</a>';
        $html .= '</div>';
        $html .= '<h3>' . __( 'Send message', 'contact-list' ) . '</h3>';
        $html .= '<form class="contact-list-send-single">';
        $recaptcha_active = ( isset( $s['activate_recaptcha'] ) ? 1 : 0 );
        $html .= '<input type="hidden" name="recaptcha_active" value="' . $recaptcha_active . '" />';
        if ( $recaptcha_active && isset( $s['recaptcha_site_key'] ) ) {
            $html .= '<div class="g-recaptcha recaptcha-container" data-sitekey="' . $s['recaptcha_site_key'] . '"></div>';
        }
        $html .= '<label for="sender_name">' . __( 'Sender name', 'contact-list' ) . '</label>';
        $html .= '<input class="contact-list-sender-name" name="sender_name" value="" placeholder="' . __( 'Your name', 'contact-list' ) . '" />';
        $html .= '<label for="sender_email">' . __( 'Sender email', 'contact-list' ) . '</label>';
        $html .= '<input class="contact-list-sender-email" name="sender_email" value="" placeholder="' . __( 'Your email', 'contact-list' ) . '" />';
        $html .= '<label for="recipient">' . __( 'Recipient', 'contact-list' ) . '</label>';
        $html .= '<span><span id="recipient" class="contact-list-recipient"></span></span>';
        $html .= '<label for="message">' . __( 'Message', 'contact-list' ) . '</label>';
        $html .= '<textarea name="message" class="contact-list-message" placeholder=""></textarea>';
        $html .= '<div class="contact-list-message-error"></div>';
        $html .= '<input name="contact_id" type="hidden" value="" class="contact-list-contact-id" />';
        $html .= '<input name="site_url" type="hidden" value="' . $site_url . '" />';
        $html .= '<input name="txt_please_msg_first" type="hidden" value="' . __( 'Please write message first.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_msg_sent_to" type="hidden" value="' . __( 'Message sent to recipient.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_sending_please_wait" type="hidden" value="' . __( 'Please wait...', 'contact-list' ) . '" />';
        $html .= '<input name="txt_new_msg_from" type="hidden" value="' . __( 'New message from', 'contact-list' ) . '" />';
        $html .= '<input name="txt_sent_by" type="hidden" value="' . __( 'sent by', 'contact-list' ) . '" />';
        $html .= '<input name="txt_recaptcha_validation_error" type="hidden" value="' . __( 'Please check the &quot;I\'m not a robot&quot;-checkbox first.', 'contact-list' ) . '" />';
        $html .= '<input name="txt_please_sender_details_first" type="hidden" value="' . __( 'Please enter sender information first (name and email).', 'contact-list' ) . '" />';
        $html .= '<input type="submit" name="send_message" class="contact-list-send-single-submit" value="' . __( 'Send', 'contact-list' ) . '" />';
        $html .= '<div class="contact-list-sending-message"></div>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
    
    public static function listAllContactsForSearchMarkup( $wp_query )
    {
        $html = '';
        $html .= '<div id="contact-list-search">';
        $html .= '<ul id="all-contacts" class="contact-list-all-contacts-list">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListHelpers::singleContactMarkup( $id, 1 );
            }
        }
        $html .= '</ul><hr class="clear" />';
        $html .= '<div id="contact-list-nothing-found">';
        $html .= __( 'No contacts found.', 'contact-list' );
        $html .= '</div>';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function contactListMarkup( $wp_query, $include_children = 0 )
    {
        $html = '';
        $html .= '<div id="contact-list-search">';
        $html .= '<ul id="all-contacts">';
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                $id = get_the_id();
                $html .= ContactListHelpers::singleContactMarkup( $id );
            }
        }
        $html .= '</ul><hr class="clear" />';
        $html .= '<div id="contact-list-nothing-found">';
        $html .= __( 'No contacts found.', 'contact-list' );
        $html .= '</div>';
        $html .= '</div>';
        wp_reset_postdata();
        return $html;
    }
    
    public static function singleContactMarkup( $id, $showGroups = 0 )
    {
        $s = get_option( 'contact_list_settings' );
        $c = get_post_custom( $id );
        $featured_img_url = get_the_post_thumbnail_url( $id, 'contact-list-contact' );
        $html = '';
        $html .= '<li id="cl-' . $id . '">';
        $html .= '<div class="contact-list-contact-container">';
        $html .= '<div class="contact-list-main-left ' . (( $featured_img_url ? '' : 'cl-full-width' )) . '"><div class="contact-list-main-elements">';
        
        if ( $showGroups ) {
            $terms = get_the_terms( $id, 'contact-group' );
            
            if ( $terms ) {
                $html .= '<div class="contact-list-contact-groups">';
                foreach ( $terms as $term ) {
                    $t_id = $term->term_id;
                    $custom_fields = get_option( "taxonomy_term_{$t_id}" );
                    if ( !isset( $custom_fields['hide_group'] ) ) {
                        $html .= '<span>' . $term->name . '</span>';
                    }
                }
                $html .= '</div>';
            }
        
        }
        
        $contact_fullname = '';
        
        if ( isset( $s['last_name_before_first_name'] ) ) {
            $contact_fullname = $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' ));
            $html .= '<div style="display: none;">' . (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0] . '</div>';
        } else {
            $contact_fullname = (( isset( $c['_cl_first_name'] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0];
            $html .= '<div style="display: none;">' . $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'] ) ? ' ' . $c['_cl_first_name'][0] : '' )) . '</div>';
        }
        
        $html .= '<span class="contact-list-contact-name">' . $contact_fullname . '</span>';
        if ( isset( $c['_cl_job_title'] ) ) {
            $html .= '<span class="contact-list-job-title">' . $c['_cl_job_title'][0] . '</span>';
        }
        
        if ( isset( $c['_cl_email'] ) ) {
            $mailto = $c['_cl_email'][0];
            $mailto_obs = '';
            for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
            }
            if ( isset( $c['_cl_email'] ) && !isset( $s['hide_contact_email'] ) ) {
                $html .= '<span class="contact-list-email">' . (( $c['_cl_email'][0] ? '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>' : '' )) . '</span>';
            }
        }
        
        if ( isset( $c['_cl_email'] ) || isset( $c['_cl_notify_emails'] ) ) {
            if ( !isset( $s['hide_send_email_button'] ) ) {
                $html .= '<span class="contact-list-send-email cl-dont-print"><a href="" data-id="' . $id . '" data-name="' . $contact_fullname . '">' . __( 'Send message', 'contact-list' ) . ' &raquo;</a></span>';
            }
        }
        
        if ( isset( $c['_cl_phone'] ) ) {
            $phone_href = preg_replace( '/[^0-9]/', '', $c['_cl_phone'][0] );
            $html .= '<span class="contact-list-phone"><a href="tel:' . $phone_href . '">' . $c['_cl_phone'][0] . '</a></span>';
        }
        
        
        if ( isset( $c['_cl_address_line_1'] ) || isset( $c['_cl_country'] ) || isset( $c['_cl_state'] ) ) {
            $html .= '<div class="contact-list-address">';
            if ( !isset( $s['hide_address_title'] ) ) {
                $html .= '<span class="contact-list-address-title">' . (( isset( $s['address_title'] ) && $s['address_title'] ? $s['address_title'] : __( 'Address', 'contact-list' ) )) . '</span>';
            }
            if ( isset( $c['_cl_address_line_1'] ) ) {
                $html .= '<span class="contact-list-address-line-1">' . $c['_cl_address_line_1'][0] . '</span>';
            }
            if ( isset( $c['_cl_address_line_2'] ) ) {
                $html .= '<span class="contact-list-address-line-2">' . $c['_cl_address_line_2'][0] . '</span>';
            }
            if ( isset( $c['_cl_address_line_3'] ) ) {
                $html .= '<span class="contact-list-address-line-3">' . $c['_cl_address_line_3'][0] . '</span>';
            }
            if ( isset( $c['_cl_address_line_4'] ) ) {
                $html .= '<span class="contact-list-address-line-4">' . $c['_cl_address_line_4'][0] . '</span>';
            }
            
            if ( isset( $c['_cl_country'] ) && $c['_cl_country'][0] || isset( $c['_cl_state'] ) && $c['_cl_state'][0] ) {
                $html .= '<span class="contact-list-address-country-and-state">';
                if ( isset( $c['_cl_state'] ) && $c['_cl_state'][0] ) {
                    $html .= $c['_cl_state'][0];
                }
                
                if ( isset( $c['_cl_country'] ) && $c['_cl_country'][0] ) {
                    if ( isset( $c['_cl_state'] ) && $c['_cl_state'][0] ) {
                        $html .= ', ';
                    }
                    $html .= $c['_cl_country'][0];
                }
                
                $html .= '</span>';
            }
            
            $html .= '</div>';
        }
        
        $custom_fields = [
            1,
            2,
            3,
            4,
            5,
            6
        ];
        foreach ( $custom_fields as $n ) {
            if ( $n == 1 ) {
                $html .= '<div class="contact-list-custom-fields-container">';
            }
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
            
            if ( isset( $c['_cl_custom_field_' . $n] ) ) {
                $cf_value = $c['_cl_custom_field_' . $n][0];
                
                if ( is_email( $cf_value ) ) {
                    $mailto = $cf_value;
                    $mailto_obs = '';
                    for ( $i = 0 ;  $i < strlen( $mailto ) ;  $i++ ) {
                        $mailto_obs .= '&#' . ord( $mailto[$i] ) . ';';
                    }
                    $cf_value = '<a href="mailto:' . $mailto_obs . '">' . $mailto_obs . '</a>';
                } else {
                    $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                }
                
                
                if ( $s['custom_field_' . $n . '_icon'] ) {
                    $html .= '<div class="contact-list-custom-field-' . $n . ' contact-list-custom-field-with-icon">';
                    $html .= '<i class="fa ' . $s['custom_field_' . $n . '_icon'] . '" aria-hidden="true"></i><span>' . $cf_value . '</span>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="contact-list-custom-field-' . $n . '">';
                    $html .= ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? '<strong>' . $s['custom_field_' . $n . '_title'] . '</strong>' : '' );
                    $html .= $cf_value;
                    $html .= '</div>';
                }
            
            }
            
            if ( $n == 6 ) {
                $html .= '</div>';
            }
        }
        
        if ( isset( $c['_cl_description'] ) ) {
            $html .= '<div class="contact-list-description">';
            if ( !isset( $s['hide_additional_info_title'] ) ) {
                $html .= '<span class="contact-list-description-title">' . (( isset( $s['additional_info_title'] ) && $s['additional_info_title'] ? $s['additional_info_title'] : __( 'Additional information', 'contact-list' ) )) . '</span>';
            }
            $html .= $c['_cl_description'][0] . '</div>';
        }
        
        $html .= '</div>';
        $html .= '<div class="contact-list-some-elements">';
        if ( isset( $c['_cl_facebook_url'] ) ) {
            $html .= ( $c['_cl_facebook_url'][0] ? '<a href="' . $c['_cl_facebook_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/facebook.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
        }
        if ( isset( $c['_cl_instagram_url'] ) ) {
            $html .= ( $c['_cl_instagram_url'][0] ? '<a href="' . $c['_cl_instagram_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/instagram.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
        }
        if ( isset( $c['_cl_twitter_url'] ) ) {
            $html .= ( $c['_cl_twitter_url'][0] ? '<a href="' . $c['_cl_twitter_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/twitter.png', __FILE__ ) . '" width="28" height="28" alt="" /></a>' : '' );
        }
        if ( isset( $c['_cl_linkedin_url'] ) ) {
            $html .= ( $c['_cl_linkedin_url'][0] ? '<a href="' . $c['_cl_linkedin_url'][0] . '" target="_blank"><img src="' . plugins_url( '../img/linkedin.png', __FILE__ ) . '" width="37" height="28" alt="" /></a>' : '' );
        }
        $html .= '<hr class="clear" /></div>';
        $html .= '</div>';
        if ( $featured_img_url ) {
            $html .= '<div class="contact-list-main-right"><div class="contact-list-image ' . (( isset( $s['contact_image_style'] ) && $s['contact_image_style'] ? 'contact-list-image-' . $s['contact_image_style'] : '' )) . ' ' . (( isset( $s['contact_image_shadow'] ) && $s['contact_image_shadow'] ? 'contact-list-image-shadow' : '' )) . '"><img src="' . $featured_img_url . '" alt="" /></div></div>';
        }
        $html .= '<hr class="clear" />';
        $html .= '</div>';
        $html .= '</li>';
        return $html;
    }
    
    public static function updateContactMarkup( $contact_id )
    {
        
        if ( $_POST ) {
            // if timestamp or nonce is not valid, redirect to homepage
            
            if ( $_POST['valid'] < current_time( 'timestamp', 1 ) || !wp_verify_nonce( $_REQUEST['_wpnonce'], '_CL_UPDATE' ) ) {
                wp_safe_redirect( site_url() );
                exit;
            }
        
        } else {
            $sc = get_option( 'contact-list-sc' );
            // if the nonce fails, redirect to homepage
            
            if ( !isset( $_GET['valid'] ) || !isset( $_GET['sc'] ) || md5( $contact_id . $_GET['valid'] . $sc ) != $_GET['sc'] ) {
                wp_safe_redirect( site_url() );
                exit;
            }
            
            // if timestamp is not valid, redirect to homepage
            
            if ( $_GET['valid'] < current_time( 'timestamp', 1 ) ) {
                wp_safe_redirect( site_url() );
                exit;
            }
        
        }
        
        $html = '';
        $html .= '<html>';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<link rel="profile" href="https://gmpg.org/xfn/11">';
        $html .= '<title>' . __( 'Update contact info', 'contact-info' ) . '</title>';
        //	$html .= '<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '
  <script>
    
    function submitContact(f) {
      f.this_is_empty.value="";
      if (f._cl_last_name.value.length == 0) {
        document.getElementsByClassName("contact-list-form-field-required")[0].style.display = "block";
        return false;
      } else {
        return true;
      }
    }
    
  </script>
    
  <style>
  
    body {
      background: teal;
      font-family: "Roboto", sans-serif;
    }
    
    h1 {
      margin-top: 5px;
    }
  
    .contact-list-update-request-container {
    }
  
    .contact-list-form-field-required {
      display: none;
      margin: 5px 0 20px 0;
      padding: 10px;
      color: red;
      border: 1px solid red;
      text-align: center;
    }
    
    .contact-list-update-request {
      max-width: 600px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
    }
  
    .contact-list-update-request .form-field .form-field-left {
      width: 50%;
      float: left;
      min-height: 40px;
    }
  
    .contact-list-update-request .form-field .form-field-right {
      width: 50%;
      float: left;
      min-height: 40px;
    }
  
    .contact-list-update-request .form-field .form-field-right input {
      width: 100%;
      padding: 5px;
    }
    
    .contact-list-form-submit {
      color: #494949;
      text-transform: uppercase;
      text-decoration: none;
      background: #ffffff;
      padding: 10px 20px;
      border: 2px solid #494949;
      display: inline-block;
      transition: all 0.4s ease 0s;    
      cursor: pointer;
      font-size: 16px;
      margin-bottom: 20px;
    }
  
    .contact-list-form-submit:hover {
      color: #ffffff;
      background: #f6b93b;
      border-color: #f6b93b;
      transition: all 0.4s ease 0s;
    }
  
    @media (max-width: 500px) {
  
      .contact-list-update-request .form-field .form-field-left {
        width: 100%;
        float: none;
        min-height: auto;
        margin-bottom: 5px;
      }
  
      .contact-list-update-request .form-field .form-field-right {
        width: 100%;
        float: none;
        margin-bottom: 8px;
      }
  
    }  
  
  </style>
    ';
        $html .= '<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">';
        $html .= '<link rel="stylesheet" href="/wp-content/plugins/contact-list/public/contact-list-request-update.css?ver=2.4.0" type="text/css" media="all" />';
        //  $html .= $contact_id;
        $s = get_option( 'contact_list_settings' );
        //  if (isset($_POST['_CL_UPDATE']) && wp_verify_nonce($_REQUEST['_wpnonce'], '_CL_UPDATE') && !$_POST['email'] && $_POST['this_is_empty']==''):
        
        if ( isset( $_POST['_CL_UPDATE'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], '_CL_UPDATE' ) ) {
            $contact_id = $_POST['ID'];
            $my_post = array(
                'ID'         => $contact_id,
                'post_title' => sanitize_title( $_POST['_cl_last_name'] . (( isset( $_POST['_cl_first_name'] ) ? ' ' . $_POST['_cl_first_name'] : '' )) ),
                'meta_input' => array(
                '_cl_first_name'     => ( isset( $_POST['_cl_first_name'] ) ? sanitize_text_field( $_POST['_cl_first_name'] ) : '' ),
                '_cl_last_name'      => ( isset( $_POST['_cl_last_name'] ) ? sanitize_text_field( $_POST['_cl_last_name'] ) : '' ),
                '_cl_job_title'      => ( isset( $_POST['_cl_job_title'] ) ? sanitize_text_field( $_POST['_cl_job_title'] ) : '' ),
                '_cl_email'          => ( isset( $_POST['_cl_email'] ) ? sanitize_email( $_POST['_cl_email'] ) : '' ),
                '_cl_phone'          => ( isset( $_POST['_cl_phone'] ) ? sanitize_text_field( $_POST['_cl_phone'] ) : '' ),
                '_cl_linkedin_url'   => ( isset( $_POST['_cl_linkedin_url'] ) ? esc_url_raw( $_POST['_cl_linkedin_url'] ) : '' ),
                '_cl_twitter_url'    => ( isset( $_POST['_cl_twitter_url'] ) ? esc_url_raw( $_POST['_cl_twitter_url'] ) : '' ),
                '_cl_facebook_url'   => ( isset( $_POST['_cl_facebook_url'] ) ? esc_url_raw( $_POST['_cl_facebook_url'] ) : '' ),
                '_cl_address_line_1' => ( isset( $_POST['_cl_address_line_1'] ) ? sanitize_text_field( $_POST['_cl_address_line_1'] ) : '' ),
                '_cl_address_line_2' => ( isset( $_POST['_cl_address_line_2'] ) ? sanitize_text_field( $_POST['_cl_address_line_2'] ) : '' ),
                '_cl_address_line_3' => ( isset( $_POST['_cl_address_line_3'] ) ? sanitize_text_field( $_POST['_cl_address_line_3'] ) : '' ),
                '_cl_address_line_4' => ( isset( $_POST['_cl_address_line_4'] ) ? sanitize_text_field( $_POST['_cl_address_line_4'] ) : '' ),
            ),
            );
            
            if ( $result = wp_update_post( $my_post ) ) {
                
                if ( isset( $_POST['_cl_groups'] ) && is_array( $_POST['_cl_groups'] ) ) {
                    $cl_groups = array();
                    foreach ( $_POST['_cl_groups'] as $each_number ) {
                        $cl_groups[] = (int) $each_number;
                    }
                    wp_set_object_terms( $contact_id, $cl_groups, 'contact-group' );
                }
                
                $html .= '<div class="contact-list-update-request-container">';
                $html .= '<div class="contact-list-update-request">';
                $html .= '<h2 style="text-align: center; margin: 50px 0;">' . (( isset( $s['thank_you_page_title'] ) && $s['thank_you_page_title'] ? $s['thank_you_page_title'] : __( 'Thank you!', 'contact-list' ) )) . '</h2>';
                //      $html .= '<p>' . (isset($s['thank_you_page_content']) && $s['thank_you_page_content'] ? $s['thank_you_page_content'] : __('The form was successfully processed and the contents will be reviewed by site administrator before publishing.', 'contact-list')) . '</p>';
            } else {
                $html .= '<h2>' . __( 'Error processing data.', 'contact-list' ) . '</h2>';
                $html .= '</div>';
                $html .= '</div>';
            }
        
        } else {
            $html .= '<form method="POST" action="./" onsubmit="return submitContact(this);">';
            $html .= '<input name="_CL_UPDATE" value="1" type="hidden" />';
            $html .= '<input name="valid" value="' . $_GET['valid'] . '" type="hidden" />';
            $html .= '<input name="contact" value="' . $_GET['valid'] . '" type="hidden" />';
            //    $html .= '<input name="email" class="input-email" />';
            $html .= '<input name="this_is_empty" type="hidden" value="99999" />';
            $html .= '<input name="ID" type="hidden" value="' . $contact_id . '" />';
            $html .= '<div class="contact-list-update-request-container">';
            $html .= '<div class="contact-list-update-request">';
            $html .= '<h1>' . __( 'Update contact info', 'contact-list' ) . '</h1>';
            $html .= wp_nonce_field(
                '_CL_UPDATE',
                '_wpnonce',
                true,
                false
            );
            
            if ( !isset( $s['pf_hide_first_name'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_first_name">' . (( isset( $s['first_name_title'] ) && $s['first_name_title'] ? $s['first_name_title'] : __( 'First name', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_first_name" id="_cl_first_name" value="' . get_post_meta( $contact_id, '_cl_first_name', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            $html .= '<div class="form-field">';
            $html .= '<div class="form-field-left"><label for="_cl_last_name">' . (( isset( $s['last_name_title'] ) && $s['last_name_title'] ? $s['last_name_title'] : __( 'Last name', 'contact-list' ) )) . '</label></div>';
            $html .= '<div class="form-field-right"><input type="text" name="_cl_last_name" id="_cl_last_name" value="' . get_post_meta( $contact_id, '_cl_last_name', true ) . '" />';
            $html .= '<div class="contact-list-form-field-required">' . __( 'Please insert at least last name first.', 'contact-list' ) . '</div></div>';
            $html .= '</div>';
            
            if ( !isset( $s['pf_hide_job_title'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_job_title">' . (( isset( $s['job_title_title'] ) && $s['job_title_title'] ? $s['job_title_title'] : __( 'Job title', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_job_title" id="_cl_job_title" value="' . get_post_meta( $contact_id, '_cl_job_title', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_email'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_email">Email</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_email" id="_cl_email" value="' . get_post_meta( $contact_id, '_cl_email', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_email'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_phone">' . (( isset( $s['phone_title'] ) && $s['phone_title'] ? $s['phone_title'] : __( 'Phone', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_phone" id="_cl_phone" value="' . get_post_meta( $contact_id, '_cl_phone', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_linkedin_url'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_linkedin_url">' . (( isset( $s['linkedin_url_title'] ) && $s['linkedin_url_title'] ? $s['linkedin_url_title'] : __( 'LinkedIn URL', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_linkedin_url" id="_cl_linkedin_url" value="' . get_post_meta( $contact_id, '_cl_linkedin_url', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_twitter_url'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_twitter_url">' . (( isset( $s['twitter_url_title'] ) && $s['twitter_url_title'] ? $s['twitter_url_title'] : __( 'Twitter URL', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_twitter_url" id="_cl_twitter_url" value="' . get_post_meta( $contact_id, '_cl_twitter_url', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_facebook_url'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_facebook_url">' . (( isset( $s['facebook_url_title'] ) && $s['facebook_url_title'] ? $s['facebook_url_title'] : __( 'Facebook URL', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_facebook_url" id="_cl_facebook_url" value="' . get_post_meta( $contact_id, '_cl_facebook_url', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_address'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<h3>' . (( isset( $s['address_title'] ) && $s['address_title'] ? $s['address_title'] : __( 'Address', 'contact-list' ) )) . '</h3>';
                $html .= '</div>';
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_address_line_1">' . (( isset( $s['address_line_1_title'] ) && $s['address_line_1_title'] ? $s['address_line_1_title'] : __( 'Address line 1', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_address_line_1" id="_cl_address_line_1" value="' . get_post_meta( $contact_id, '_cl_address_line_1', true ) . '" /></div>';
                $html .= '</div>';
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_address_line_2">' . (( isset( $s['address_line_2_title'] ) && $s['address_line_2_title'] ? $s['address_line_2_title'] : __( 'Address line 2', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_address_line_2" id="_cl_address_line_2" value="' . get_post_meta( $contact_id, '_cl_address_line_2', true ) . '" /></div>';
                $html .= '</div>';
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_address_line_3">' . (( isset( $s['address_line_3_title'] ) && $s['address_line_3_title'] ? $s['address_line_3_title'] : __( 'Address line 3', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_address_line_3" id="_cl_address_line_3" value="' . get_post_meta( $contact_id, '_cl_address_line_3', true ) . '" /></div>';
                $html .= '</div>';
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_address_line_4">' . (( isset( $s['address_line_4_title'] ) && $s['address_line_4_title'] ? $s['address_line_4_title'] : __( 'Address line 4', 'contact-list' ) )) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_address_line_4" id="_cl_address_line_4" value="' . get_post_meta( $contact_id, '_cl_address_line_4', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( isset( $s['group_select'] ) && $s['group_select'] ) {
                $taxonomies = get_terms( array(
                    'taxonomy'   => 'contact-group',
                    'hide_empty' => false,
                ) );
                
                if ( !empty($taxonomies) ) {
                    $output = '';
                    foreach ( $taxonomies as $category ) {
                        
                        if ( $category->parent == 0 ) {
                            $output .= '<label class="contact-category"><input type="checkbox" name="_cl_groups[]" value="' . esc_attr( $category->term_id ) . '" /> <span class="contact-list-checkbox-title">' . esc_attr( $category->name ) . '</span></label>';
                            foreach ( $taxonomies as $subcategory ) {
                                if ( $subcategory->parent == $category->term_id ) {
                                    $output .= '<label class="contact-subcategory"><input type="checkbox" name="_cl_groups[]" value="' . esc_attr( $subcategory->term_id ) . '" /> <span class="contact-list-checkbox-title">' . esc_html( $subcategory->name ) . '</span></label>';
                                }
                            }
                        }
                    
                    }
                }
                
                $html .= '<div class="form-field">';
                $html .= '<h3>' . (( isset( $s['groups_title'] ) && $s['groups_title'] ? $s['groups_title'] : __( 'Group(s)', 'contact-list' ) )) . '</h3>';
                $html .= '</div>';
                $html .= '<div class="form-field form-field-categories">';
                $html .= $output;
                $html .= '<hr class="clear" />';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_additional_info'] ) && 0 ) {
                $html .= '<div class="form-field">';
                $html .= '<h3>' . (( isset( $s['additional_info_title'] ) && $s['additional_info_title'] ? $s['additional_info_title'] : __( 'Additional information', 'contact-list' ) )) . '</h3>';
                $html .= '</div>';
                $html .= '<div class="form-field">';
                $settings = array(
                    'media_buttons' => false,
                    'teeny'         => true,
                    'wpautop'       => false,
                    'textarea_rows' => 16,
                    'quicktags'     => false,
                );
                ob_start();
                wp_editor( '', '_cl_description', $settings );
                $editor_contents = ob_get_clean();
                $html .= $editor_contents;
                $html .= '</div>';
                $html .= '<hr class="clear" />';
                $html .= '</div>';
                $html .= '</div>';
            }
            
            $html .= '<input type="submit" class="contact-list-form-submit" value="' . __( 'Submit', 'contact-list' ) . '" />';
            $html .= '</form>';
        }
        
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }
    
    public static function initLayout( $s )
    {
        $html = '';
        
        if ( isset( $s['card_background'] ) && $s['card_background'] ) {
            $html .= '<style>.contact-list-container #contact-list-search ul li { margin-bottom: 5px; } </style>';
            
            if ( $s['card_background'] == 'white' ) {
                $html .= '<style>.contact-list-contact-container { background: #fff; } </style>';
            } elseif ( $s['card_background'] == 'light_gray' ) {
                $html .= '<style>.contact-list-contact-container { background: #f7f7f7; } </style>';
            }
        
        }
        
        if ( isset( $s['card_border'] ) && $s['card_border'] ) {
            
            if ( $s['card_border'] == 'black' ) {
                $html .= '<style>.contact-list-contact-container { border: 1px solid #333; border-radius: 10px; padding: 10px; } </style>';
            } elseif ( $s['card_border'] == 'gray' ) {
                $html .= '<style>.contact-list-contact-container { border: 1px solid #bbb; border-radius: 10px; padding: 10px; } </style>';
            }
        
        }
        
        if ( isset( $s['card_height'] ) && $s['card_height'] ) {
            $html .= '<style>.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style>.contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $s['card_height'] . 'px; } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-3-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
            $html .= '<style> @media (max-width: 820px) { .contact-list-4-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';
        }
        
        return $html;
    }
    
    public static function isPremium()
    {
        $is_premium = 0;
        return $is_premium;
    }

}