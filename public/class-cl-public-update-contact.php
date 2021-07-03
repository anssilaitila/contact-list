<?php

class ContactListUpdateContact
{
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
        $html .= '<title>' . esc_html__( 'Update contact info', 'contact-info' ) . '</title>';
        $html .= '<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>';
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

.contact-list-update-request .form-field {
  display: flex;
}

.contact-list-update-request .form-field.form-field-categories {
  flex-direction: column;
}

.contact-list-update-request .form-field.form-field-categories .contact-category {
  padding: 4px 0;
}

.contact-list-update-request .form-field.form-field-categories .contact-subcategory {
  padding: 4px 0 4px 16px;
}

.contact-list-update-request .form-field .form-field-left {
  width: 50%;
  min-height: 40px;
}

.contact-list-update-request .form-field .form-field-right {
  width: 50%;
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
  margin-top: 16px;
  margin-bottom: 10px;
}

.contact-list-form-submit:hover {
  color: #ffffff;
  background: #f6b93b;
  border-color: #f6b93b;
  transition: all 0.4s ease 0s;
}

.clear {
  background: none;
  border: 0;
  clear: both;
  display: block;
  float: none;
  font-size: 0;
  margin: 0;
  padding: 0;
  overflow: hidden;
  visibility: hidden;
  width: 0;
  height: 0;
  margin: 0;
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
        $s = get_option( 'contact_list_settings' );
        
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
                '_cl_instagram_url'  => ( isset( $_POST['_cl_instagram_url'] ) ? esc_url_raw( $_POST['_cl_instagram_url'] ) : '' ),
                '_cl_country'        => ( isset( $_POST['_cl_country'] ) ? sanitize_text_field( $_POST['_cl_country'] ) : '' ),
                '_cl_state'          => ( isset( $_POST['_cl_state'] ) ? sanitize_text_field( $_POST['_cl_state'] ) : '' ),
                '_cl_city'           => ( isset( $_POST['_cl_city'] ) ? sanitize_text_field( $_POST['_cl_city'] ) : '' ),
                '_cl_address_line_1' => ( isset( $_POST['_cl_address_line_1'] ) ? sanitize_text_field( $_POST['_cl_address_line_1'] ) : '' ),
                '_cl_address_line_2' => ( isset( $_POST['_cl_address_line_2'] ) ? sanitize_text_field( $_POST['_cl_address_line_2'] ) : '' ),
                '_cl_address_line_3' => ( isset( $_POST['_cl_address_line_3'] ) ? sanitize_text_field( $_POST['_cl_address_line_3'] ) : '' ),
                '_cl_address_line_4' => ( isset( $_POST['_cl_address_line_4'] ) ? sanitize_text_field( $_POST['_cl_address_line_4'] ) : '' ),
                '_cl_custom_field_1' => ( isset( $_POST['_cl_custom_field_1'] ) ? sanitize_text_field( $_POST['_cl_custom_field_1'] ) : '' ),
                '_cl_custom_field_2' => ( isset( $_POST['_cl_custom_field_2'] ) ? sanitize_text_field( $_POST['_cl_custom_field_2'] ) : '' ),
                '_cl_custom_field_3' => ( isset( $_POST['_cl_custom_field_3'] ) ? sanitize_text_field( $_POST['_cl_custom_field_3'] ) : '' ),
                '_cl_custom_field_4' => ( isset( $_POST['_cl_custom_field_4'] ) ? sanitize_text_field( $_POST['_cl_custom_field_4'] ) : '' ),
                '_cl_custom_field_5' => ( isset( $_POST['_cl_custom_field_5'] ) ? sanitize_text_field( $_POST['_cl_custom_field_5'] ) : '' ),
                '_cl_custom_field_6' => ( isset( $_POST['_cl_custom_field_6'] ) ? sanitize_text_field( $_POST['_cl_custom_field_6'] ) : '' ),
            ),
            );
            
            if ( $result = wp_update_post( $my_post ) ) {
                
                if ( isset( $_FILES['_CONTACT_IMAGE']['tmp_name'] ) && $_FILES['_CONTACT_IMAGE']['tmp_name'] ) {
                    // Get the file type of the upload
                    $arr_file_type = wp_check_filetype( basename( $_FILES['_CONTACT_IMAGE']['name'] ) );
                    $uploaded_type = $arr_file_type['type'];
                    // Use the WordPress API to upload the file
                    $upload = wp_upload_bits( $_FILES['_CONTACT_IMAGE']['name'], null, file_get_contents( $_FILES['_CONTACT_IMAGE']['tmp_name'] ) );
                    if ( isset( $upload['error'] ) && $upload['error'] ) {
                        wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
                    }
                    $filename = substr( strrchr( $upload['file'], "/" ), 1 );
                    ContactListHelpers::addFeaturedImage(
                        $contact_id,
                        $upload,
                        $uploaded_type,
                        $filename
                    );
                }
                
                
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
            } else {
                $html .= '<h2>' . __( 'Error processing data.', 'contact-list' ) . '</h2>';
                $html .= '</div>';
                $html .= '</div>';
            }
        
        } else {
            $html .= '<form method="POST" action="./" onsubmit="return submitContact(this);" enctype="multipart/form-data">';
            $html .= '<input name="_CL_UPDATE" value="1" type="hidden" />';
            $html .= '<input name="valid" value="' . $_GET['valid'] . '" type="hidden" />';
            $html .= '<input name="contact" value="' . $_GET['valid'] . '" type="hidden" />';
            $html .= '<input name="this_is_empty" type="hidden" value="99999" />';
            $html .= '<input name="ID" type="hidden" value="' . $contact_id . '" />';
            $html .= '<div class="contact-list-update-request-container">';
            $html .= '<div class="contact-list-update-request">';
            $html .= '<h1>' . esc_html__( 'Update contact info', 'contact-list' ) . '</h1>';
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
            
            
            if ( !isset( $s['pf_hide_phone'] ) ) {
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
            
            
            if ( !isset( $s['pf_hide_instagram_url'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<div class="form-field-left"><label for="_cl_instagram_url">' . esc_html( ( isset( $s['instagram_url_title'] ) && $s['instagram_url_title'] ? $s['instagram_url_title'] : __( 'Instagram URL', 'contact-list' ) ) ) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="text" name="_cl_instagram_url" id="_cl_instagram_url" value="' . get_post_meta( $contact_id, '_cl_instagram_url', true ) . '" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_photo'] ) ) {
                $html .= '<div class="form-field" style="margin-bottom: 12px;">';
                $html .= '<div class="form-field-left"><label for="_cl_image">' . esc_html__( 'Photo', 'contact-list' ) . '</label></div>';
                $html .= '<div class="form-field-right"><input type="file" name="_CONTACT_IMAGE" id="_cl_image" /></div>';
                $html .= '</div>';
            }
            
            
            if ( !isset( $s['pf_hide_address'] ) ) {
                $html .= '<div class="form-field">';
                $html .= '<h3>' . (( isset( $s['address_title'] ) && $s['address_title'] ? $s['address_title'] : __( 'Address', 'contact-list' ) )) . '</h3>';
                $html .= '</div>';
                
                if ( !isset( $s['pf_hide_city'] ) ) {
                    $html .= '<div class="form-field">';
                    $html .= '<div class="form-field-left"><label for="_cl_city">' . esc_html( ( isset( $s['city_title'] ) && $s['city_title'] ? $s['city_title'] : __( 'City', 'contact-list' ) ) ) . '</label></div>';
                    $html .= '<div class="form-field-right"><input type="text" name="_cl_city" id="_cl_city" value="' . get_post_meta( $contact_id, '_cl_city', true ) . '" /></div>';
                    $html .= '</div>';
                }
                
                
                if ( !isset( $s['pf_hide_state'] ) ) {
                    $html .= '<div class="form-field">';
                    $html .= '<div class="form-field-left"><label for="_cl_state">' . esc_html( ( isset( $s['state_title'] ) && $s['state_title'] ? $s['state_title'] : __( 'State', 'contact-list' ) ) ) . '</label></div>';
                    $html .= '<div class="form-field-right"><input type="text" name="_cl_state" id="_cl_state" value="' . get_post_meta( $contact_id, '_cl_state', true ) . '" /></div>';
                    $html .= '</div>';
                }
                
                
                if ( !isset( $s['pf_hide_country'] ) ) {
                    $html .= '<div class="form-field">';
                    $html .= '<div class="form-field-left"><label for="_cl_country">' . esc_html( ( isset( $s['country_title'] ) && $s['country_title'] ? $s['country_title'] : __( 'Country', 'contact-list' ) ) ) . '</label></div>';
                    $html .= '<div class="form-field-right"><input type="text" name="_cl_country" id="_cl_country" value="' . get_post_meta( $contact_id, '_cl_country', true ) . '" /></div>';
                    $html .= '</div>';
                }
                
                
                if ( !isset( $s['pf_hide_address_lines'] ) ) {
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
            
            }
            
            $html .= '<br />';
            $pro_active = 0;
            
            if ( !$pro_active ) {
                $custom_fields = [ 1 ];
                foreach ( $custom_fields as $n ) {
                    
                    if ( !isset( $s['pf_hide_custom_field_' . $n] ) ) {
                        $html .= '<div class="form-field">';
                        $html .= '<div class="form-field-left"><label for="_cl_custom_field_' . $n . '">' . esc_html( ( isset( $s['custom_field_' . $n . '_title'] ) && $s['custom_field_' . $n . '_title'] ? $s['custom_field_' . $n . '_title'] : __( 'Custom field', 'contact-list' ) . ' ' . $n ) ) . '</label></div>';
                        $html .= '<div class="form-field-right"><input type="text" name="_cl_custom_field_' . $n . '" id="_cl_custom_field_' . $n . '" value="' . get_post_meta( $contact_id, '_cl_custom_field_' . $n, true ) . '" /></div>';
                        $html .= '</div>';
                    }
                
                }
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
                            $checked = '';
                            if ( has_term( $category->term_id, 'contact-group', $contact_id ) ) {
                                $checked = 'checked';
                            }
                            $output .= '<label class="contact-category"><input type="checkbox" name="_cl_groups[]" value="' . esc_attr( $category->term_id ) . '" ' . $checked . ' /> <span class="contact-list-checkbox-title">' . esc_attr( $category->name ) . '</span></label>';
                            foreach ( $taxonomies as $subcategory ) {
                                $checked = '';
                                if ( has_term( $subcategory->term_id, 'contact-group', $contact_id ) ) {
                                    $checked = 'checked';
                                }
                                if ( $subcategory->parent == $category->term_id ) {
                                    $output .= '<label class="contact-subcategory"><input type="checkbox" name="_cl_groups[]" value="' . esc_attr( $subcategory->term_id ) . '" ' . $checked . ' /> <span class="contact-list-checkbox-title">' . esc_html( $subcategory->name ) . '</span></label>';
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
                $html .= '</div>';
            }
            
            $html .= '<input type="submit" class="contact-list-form-submit" value="' . __( 'Submit', 'contact-list' ) . '" />';
            $html .= '</form>';
        }
        
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }

}