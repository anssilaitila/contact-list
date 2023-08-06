<li id="cl-<?php 
echo  intval( $id ) ;
?>">

<?php 
echo  ContactListPublicHooks::get_action_content( 'contact_list_before_contact_card' ) ;
?>

<div class="contact-list-contact-container" <?php 
echo  sanitize_text_field( $card_height_markup ) ;
?>>

  <div class="contact-list-main-left <?php 
echo  ( $featured_img_url ? '' : 'cl-full-width' ) ;
?>">
    
    <div class="contact-list-main-elements">
  
      <?php 

if ( $showGroups && !isset( $s['contact_show_groups'] ) ) {
    ?>
        
        <?php 
    $terms = get_the_terms( $id, 'contact-group' );
    ?>
        
        <?php 
    
    if ( $terms ) {
        ?>
      
          <div class="contact-list-contact-groups">';
      
            <?php 
        foreach ( $terms as $term ) {
            ?>
        
              <?php 
            $t_id = intval( $term->term_id );
            $custom_fields = get_option( "taxonomy_term_{$t_id}" );
            ?>
              
              <?php 
            
            if ( !isset( $custom_fields['hide_group'] ) ) {
                ?>
                <?php 
                $term_name = sanitize_text_field( $term->name );
                ?>
                <span><?php 
                echo  esc_html( $term_name ) ;
                ?></span>
              <?php 
            }
            
            ?>
        
            <?php 
        }
        ?>
      
          </div>
      
        <?php 
    }
    
    ?>
      
      <?php 
}

?>
      
      <?php 
$contact_fullname = '';

if ( isset( $s['contact_card_title'] ) && $s['contact_card_title'] ) {
    $contact_fullname = ContactListPublicHelpersDefault::singleContactFullname( $c );
} elseif ( isset( $s['last_name_before_first_name'] ) ) {
    $contact_fullname = sanitize_text_field( $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'][0] ) ? ' ' . $c['_cl_first_name'][0] : '' )) );
    $text = sanitize_text_field( (( isset( $c['_cl_first_name'][0] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0] );
    ?>
        
        <div class="contact-list-hidden-name"><?php 
    echo  esc_html( $text ) ;
    ?></div>
        
        <?php 
} else {
    $contact_fullname = sanitize_text_field( (( isset( $c['_cl_first_name'][0] ) ? $c['_cl_first_name'][0] . ' ' : '' )) . $c['_cl_last_name'][0] );
    $text = sanitize_text_field( $c['_cl_last_name'][0] . (( isset( $c['_cl_first_name'][0] ) ? ' ' . $c['_cl_first_name'][0] : '' )) );
    ?>
        
        <div class="contact-list-hidden-name"><?php 
    echo  esc_html( $text ) ;
    ?></div>
      
      <?php 
}

?>
      
      <span class="contact-list-contact-name"><?php 
echo  esc_html( $contact_fullname ) ;
?></span>
      
      <?php 

if ( isset( $c['_cl_job_title'][0] ) && $c['_cl_job_title'][0] ) {
    ?>
        <?php 
    $job_title = sanitize_text_field( $c['_cl_job_title'][0] );
    ?>
        <span class="contact-list-job-title"><?php 
    echo  esc_html( $job_title ) ;
    ?></span>
      <?php 
}

?>
      
      <?php 

if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) ) {
    ?>
      
        <?php 
    $mailto = sanitize_email( $c['_cl_email'][0] );
    ?>
      
        <?php 
    
    if ( isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] ) && !isset( $s['hide_contact_email'] ) ) {
        ?>
          <span class="contact-list-email"><?php 
        echo  ( $c['_cl_email'][0] ? '<a href="' . esc_url_raw( 'mailto:' . antispambot( $mailto ) ) . '">' . esc_html( antispambot( $mailto ) ) . '</a>' : '' ) ;
        ?></span>
        <?php 
    }
    
    ?>
      
      <?php 
}

?>
      
      <?php 
$email_valid = isset( $c['_cl_email'][0] ) && is_email( $c['_cl_email'][0] );
$notify_emails = isset( $c['_cl_notify_emails'] ) && $c['_cl_notify_emails'][0];
if ( $email_valid || $notify_emails ) {
    
    if ( !isset( $s['hide_send_email_button'] ) ) {
        ?>
          <span class="contact-list-send-email cl-dont-print"><a href="" data-id="<?php 
        echo  intval( $id ) ;
        ?>" data-name="<?php 
        echo  esc_attr( $contact_fullname ) ;
        ?>"><?php 
        echo  ContactListHelpers::getTextV2( 'text_send_message', 'Send message' ) ;
        ?> &raquo;</a></span>
          <?php 
    }

}
$hide_phone_numbers = 0;
if ( !$hide_phone_numbers ) {
    
    if ( isset( $c['_cl_phone'][0] ) && $c['_cl_phone'][0] ) {
        $phone_org = sanitize_text_field( $c['_cl_phone'][0] );
        $phone_href = preg_replace( '/[^0-9\\,]/', '', $phone_org );
        ?>
  
          <span class="contact-list-phone contact-list-phone-1">
  
            <?php 
        
        if ( isset( $s['show_titles_above_phone_numbers'] ) ) {
            ?>
              <span class="contact-list-phone-title"><?php 
            echo  ContactListHelpers::getText( 'phone_title', __( 'Phone', 'contact-list' ) ) ;
            ?></span>
            <?php 
        }
        
        ?>
            
            <a href="tel:<?php 
        echo  esc_attr( $phone_href ) ;
        ?>"><?php 
        echo  esc_html( $phone_org ) ;
        ?></a>
          
          </span>
          
        <?php 
    }

}

if ( isset( $s['contact_show_groups'] ) ) {
    $terms = get_the_terms( $id, 'contact-group' );
    
    if ( $terms ) {
        ?>
          <span class="contact-list-contact-groups-v2-title"><?php 
        echo  ContactListHelpers::getText( 'contact_groups_title', __( 'Groups', 'contact-list' ) ) ;
        ?></span>
      
          <div class="contact-list-contact-groups-v2">';
      
            <?php 
        foreach ( $terms as $term ) {
            $t_id = intval( $term->term_id );
            $custom_fields = get_option( "taxonomy_term_{$t_id}" );
            
            if ( !isset( $custom_fields['hide_group'] ) ) {
                ?>
                <span><?php 
                echo  sanitize_text_field( $term->name ) ;
                ?></span>
                <?php 
            }
        
        }
        ?>
      
          </div>
          
        <?php 
    }

}


if ( isset( $c['_cl_address_line_1'][0] ) || isset( $c['_cl_country'][0] ) || isset( $c['_cl_state'][0] ) ) {
    ?>
      
        <div class="contact-list-address">
      
          <?php 
    
    if ( !isset( $s['hide_address_title'] ) ) {
        ?>
            <?php 
        $address_title = ( isset( $s['address_title'] ) && $s['address_title'] ? sanitize_text_field( $s['address_title'] ) : sanitize_text_field( __( 'Address', 'contact-list' ) ) );
        ?>
            <span class="contact-list-address-title"><?php 
        echo  esc_html( $address_title ) ;
        ?></span>
          <?php 
    }
    
    ?>
        
          <?php 
    
    if ( isset( $c['_cl_address_line_1'][0] ) && $c['_cl_address_line_1'][0] ) {
        ?>
            <?php 
        $address_line_1 = sanitize_text_field( $c['_cl_address_line_1'][0] );
        ?>
            <span class="contact-list-address-line-1"><?php 
        echo  esc_html( $address_line_1 ) ;
        ?></span>
          <?php 
    }
    
    ?>
        
          <?php 
    
    if ( isset( $c['_cl_address_line_2'][0] ) && $c['_cl_address_line_2'][0] ) {
        ?>
            <?php 
        $address_line_2 = sanitize_text_field( $c['_cl_address_line_2'][0] );
        ?>
            <span class="contact-list-address-line-2"><?php 
        echo  esc_html( $address_line_2 ) ;
        ?></span>
          <?php 
    }
    
    ?>
          
          <?php 
    
    if ( isset( $c['_cl_address_line_3'][0] ) && $c['_cl_address_line_3'][0] ) {
        ?>
            <?php 
        $address_line_3 = sanitize_text_field( $c['_cl_address_line_3'][0] );
        ?>
            <span class="contact-list-address-line-3"><?php 
        echo  esc_html( $address_line_3 ) ;
        ?></span>
          <?php 
    }
    
    ?>
        
          <?php 
    
    if ( isset( $c['_cl_address_line_4'][0] ) && $c['_cl_address_line_4'][0] ) {
        ?>
            <?php 
        $address_line_4 = sanitize_text_field( $c['_cl_address_line_4'][0] );
        ?>
            <span class="contact-list-address-line-4"><?php 
        echo  esc_html( $address_line_4 ) ;
        ?></span>
          <?php 
    }
    
    ?>
          
          <?php 
    
    if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] || isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] || isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] || isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
        ?>
        
            <span class="contact-list-address-country-and-state">
              
            <?php 
        $zip_code_first = 0;
        $zip_code_last = 0;
        
        if ( !isset( $s['move_zip_after_state'] ) && isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
            echo  sanitize_text_field( $c['_cl_zip_code'][0] ) ;
            $zip_code_first = 1;
        }
        
        
        if ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
            if ( $zip_code_first ) {
                echo  ' ' ;
            }
            echo  sanitize_text_field( $c['_cl_city'][0] ) ;
        }
        
        
        if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
            if ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                echo  ', ' ;
            }
            echo  sanitize_text_field( $c['_cl_state'][0] ) ;
        }
        
        
        if ( isset( $s['move_zip_after_state'] ) && isset( $c['_cl_zip_code'][0] ) && $c['_cl_zip_code'][0] ) {
            if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
                echo  ' ' ;
            }
            echo  sanitize_text_field( $c['_cl_zip_code'][0] ) ;
            $zip_code_last = 1;
        }
        
        
        if ( isset( $c['_cl_country'][0] ) && $c['_cl_country'][0] ) {
            
            if ( isset( $c['_cl_state'][0] ) && $c['_cl_state'][0] ) {
                echo  ', ' ;
            } elseif ( isset( $c['_cl_city'][0] ) && $c['_cl_city'][0] ) {
                echo  ', ' ;
            }
            
            echo  sanitize_text_field( $c['_cl_country'][0] ) ;
        }
        
        echo  '</span>' ;
    }
    
    ?>
          
        </div>

      <?php 
}

$custom_fields = [ 1 ];
echo  '<div class="contact-list-custom-fields-container">' ;
foreach ( $custom_fields as $n ) {
    if ( isset( $s['custom_field_' . $n . '_hide_from_contact_card'] ) ) {
        continue;
    }
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\\w]+\\.)+([^\\s\\.]+[^\\s]*)+[^,.\\s])@';
    
    if ( isset( $c['_cl_custom_field_' . $n][0] ) && $c['_cl_custom_field_' . $n][0] ) {
        $cf_value = $c['_cl_custom_field_' . $n][0];
        
        if ( is_email( $cf_value ) ) {
            $mailto = sanitize_email( $cf_value );
            $mailto_obs = antispambot( $mailto );
            $cf_value = '<a href="mailto:' . sanitize_text_field( $mailto_obs ) . '">' . sanitize_text_field( $mailto_obs ) . '</a>';
        } else {
            $link_title = '';
            if ( isset( $s['custom_field_' . $n . '_link_text'] ) && $s['custom_field_' . $n . '_link_text'] ) {
                $link_title = sanitize_text_field( $s['custom_field_' . $n . '_link_text'] );
            }
            $disable_automatic_linking = 0;
            if ( !$disable_automatic_linking ) {
                
                if ( $link_title ) {
                    $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">' . $link_title . '</a>', $cf_value );
                } else {
                    $cf_value = preg_replace( $url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $cf_value );
                }
            
            }
        }
        
        
        if ( isset( $s['custom_field_' . $n . '_icon'] ) && $s['custom_field_' . $n . '_icon'] ) {
            echo  '<div class="contact-list-custom-field-' . intval( $n ) . ' contact-list-custom-field-with-icon">' ;
            echo  '<i class="fa ' . sanitize_html_class( $s['custom_field_' . $n . '_icon'] ) . '" aria-hidden="true"></i><span>' . wp_kses_post( $cf_value ) . '</span>' ;
            echo  '</div>' ;
        } else {
            $field_name = 'custom_field_' . $n . '_title';
            echo  '<div class="contact-list-custom-field-' . intval( $n ) . '">' ;
            echo  ( isset( $s[$field_name] ) && $s[$field_name] ? '<strong>' . esc_html( $s[$field_name] ) . '</strong>' : '' ) ;
            echo  wp_kses_post( $cf_value ) ;
            echo  '</div>' ;
        }
    
    }

}
echo  '</div>' ;
if ( isset( $c['_cl_description'][0] ) && $c['_cl_description'][0] ) {
    
    if ( isset( $s['contact_card_additional_info_only_in_modal'] ) && !$is_modal ) {
        // Don't show
    } else {
        echo  '<div class="contact-list-description">' ;
        
        if ( !isset( $s['hide_additional_info_title'] ) ) {
            $description_title = ( isset( $s['additional_info_title'] ) && $s['additional_info_title'] ? sanitize_text_field( $s['additional_info_title'] ) : sanitize_text_field( __( 'Additional information', 'contact-list' ) ) );
            echo  '<span class="contact-list-description-title">' . esc_html( $description_title ) . '</span>' ;
        }
        
        echo  wp_kses_post( $c['_cl_description'][0] ) . '</div>' ;
    }

}
?>
    
    </div>
    
    <div class="contact-list-some-elements">
      
      <?php 
if ( isset( $c['_cl_facebook_url'][0] ) && $c['_cl_facebook_url'][0] ) {
    echo  ( $c['_cl_facebook_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_facebook_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/facebook.svg', __FILE__ ) ) . '"  alt="' . esc_attr( __( 'Facebook', 'contact-list' ) ) . '" /></a>' : '' ) ;
}
if ( isset( $c['_cl_instagram_url'][0] ) && $c['_cl_instagram_url'][0] ) {
    echo  ( $c['_cl_instagram_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_instagram_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/instagram.svg', __FILE__ ) ) . '" alt="' . esc_attr( __( 'Instagram', 'contact-list' ) ) . '" /></a>' : '' ) ;
}
if ( isset( $c['_cl_twitter_url'][0] ) && $c['_cl_twitter_url'][0] ) {
    echo  ( $c['_cl_twitter_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_twitter_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/twitter.svg', __FILE__ ) ) . '" alt="' . esc_attr( __( 'Twitter', 'contact-list' ) ) . '" /></a>' : '' ) ;
}
if ( isset( $c['_cl_linkedin_url'][0] ) && $c['_cl_linkedin_url'][0] ) {
    echo  ( $c['_cl_linkedin_url'][0] ? '<a href="' . esc_url_raw( $c['_cl_linkedin_url'][0] ) . '" target="_blank"><img src="' . esc_url_raw( plugins_url( '../img/linkedin.svg', __FILE__ ) ) . '" alt="' . esc_attr( __( 'LinkedIn', 'contact-list' ) ) . '" /></a>' : '' ) ;
}
?>
      
      <hr class="clear" />

    </div>
    
    <?php 

if ( !$is_modal && isset( $s['contact_card_show_modal_button'] ) && isset( $c['_cl_description'][0] ) && $c['_cl_description'][0] ) {
    ?>
      <a href="" class="contact-list-show-contact contact-list-show-contact-button cl-dont-print" data-contact-id="<?php 
    echo  intval( $id ) ;
    ?>"><?php 
    echo  esc_html( ContactListHelpers::getTextV2( 'text_contact_card_modal_button', __( 'More info', 'contact-list' ) ) ) ;
    ?></a>
    <?php 
}

?>
  
  </div>
  
  <?php 

if ( $featured_img_url ) {
    ?>
  
    <?php 
    $featured_img_id = intval( get_post_thumbnail_id( $id ) );
    $featured_img_alt = sanitize_text_field( get_post_meta( $featured_img_id, '_wp_attachment_image_alt', true ) );
    ?>
  
    <div class="contact-list-main-right">
      <div class="contact-list-image <?php 
    echo  (( isset( $s['contact_image_style'] ) && $s['contact_image_style'] ? 'contact-list-image-' . esc_attr( $s['contact_image_style'] ) : '' )) . ' ' . (( isset( $s['contact_image_shadow'] ) && $s['contact_image_shadow'] ? 'contact-list-image-shadow' : '' )) ;
    ?>">
        <img src="<?php 
    echo  esc_url_raw( $featured_img_url ) ;
    ?>" alt="<?php 
    echo  esc_attr( $featured_img_alt ) ;
    ?>" />
      </div>
    </div>
  
  <?php 
}

?>
  
  <hr class="clear" />

</div>

<?php 
echo  ContactListPublicHooks::get_action_content( 'contact_list_after_contact_card' ) ;
?>

</li>
