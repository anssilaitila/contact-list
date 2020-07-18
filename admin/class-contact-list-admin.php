<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://anssilaitila.fi
 * @since      1.0.0
 *
 * @package    Contact_List
 * @subpackage Contact_List/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Contact_List
 * @subpackage Contact_List/admin
 * @author     Anssi Laitila <anssi.laitila@gmail.com>
 */
class Contact_List_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name ;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version ;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->plugin_name,
            CONTACT_LIST_URI . 'dist/css/main.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            CONTACT_LIST_URI . 'dist/js/main.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    public function modify_post_title( $data )
    {
        
        if ( isset( $_POST ) && $data['post_type'] == CONTACT_CPT && !isset( $_POST['_cl_last_name'] ) && $data['post_content'] == 'imported' ) {
            // ...
        } elseif ( isset( $_POST ) && $data['post_type'] == CONTACT_CPT ) {
            $data['post_title'] = (( isset( $_POST['_cl_first_name'] ) ? $_POST['_cl_first_name'] : '' )) . ' ' . (( isset( $_POST['_cl_last_name'] ) ? $_POST['_cl_last_name'] : '' ));
        }
        
        return $data;
    }
    
    public function create_custom_post_type_contact()
    {
        register_post_type( CONTACT_CPT, [
            'labels'             => [
            'name'          => __( 'Contact List', 'contact-list' ),
            'singular_name' => __( 'Contact', 'contact-list' ),
            'add_new_item'  => __( 'Add New Contact', 'contact-list' ),
            'edit_item'     => __( 'Edit Contact', 'contact-list' ),
            'not_found'     => __( 'No contacts found.', 'contact-list' ),
            'all_items'     => __( 'All Contacts', 'contact-list' ),
        ],
            'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
            'public'             => false,
            'show_ui'            => true,
            'has_archive'        => false,
            'publicly_queryable' => false,
            'menu_icon'          => 'dashicons-id',
            'capability_type'    => 'post',
        ] );
        remove_post_type_support( CONTACT_CPT, 'title' );
        remove_post_type_support( CONTACT_CPT, 'editor' );
        add_image_size( 'contact-list-contact', 160, 200 );
        add_filter( 'manage_contact_posts_columns', 'contact_custom_columns', 10 );
        add_action(
            'manage_contact_posts_custom_column',
            'contact_custom_columns_content',
            10,
            2
        );
        function contact_custom_columns( $defaults )
        {
            $options = get_option( 'contact_list_settings' );
            $defaults['contact_id'] = __( 'ID', 'contact-list' );
            if ( !isset( $options['af_hide_first_name'] ) ) {
                $defaults['first_name'] = ( isset( $options['first_name_title'] ) && $options['first_name_title'] ? $options['first_name_title'] : __( 'First name', 'contact-list' ) );
            }
            $defaults['last_name'] = ( isset( $options['last_name_title'] ) && $options['last_name_title'] ? $options['last_name_title'] : __( 'Last name', 'contact-list' ) );
            $defaults['menu_order'] = __( 'Order' );
            if ( !isset( $options['af_hide_job_title'] ) ) {
                $defaults['job_title'] = ( isset( $options['job_title_title'] ) && $options['job_title_title'] ? $options['job_title_title'] : __( 'Job title', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_email'] ) ) {
                $defaults['email'] = __( 'Email', 'contact-list' );
            }
            if ( !isset( $options['af_hide_phone'] ) ) {
                $defaults['phone'] = ( isset( $options['phone_title'] ) && $options['phone_title'] ? $options['phone_title'] : __( 'Phone', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_linkedin_url'] ) ) {
                $defaults['linkedin_url'] = ( isset( $options['linkedin_url_title'] ) && $options['linkedin_url_title'] ? $options['linkedin_url_title'] : __( 'LinkedIn', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_twitter_url'] ) ) {
                $defaults['twitter_url'] = ( isset( $options['twitter_url_title'] ) && $options['twitter_url_title'] ? $options['twitter_url_title'] : __( 'Twitter', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_facebook_url'] ) ) {
                $defaults['facebook_url'] = ( isset( $options['facebook_url_title'] ) && $options['facebook_url_title'] ? $options['facebook_url_title'] : __( 'Facebook', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_instagram_url'] ) ) {
                $defaults['instagram_url'] = ( isset( $options['instagram_url_title'] ) && $options['instagram_url_title'] ? $options['instagram_url_title'] : __( 'IG', 'contact-list' ) );
            }
            return $defaults;
        }
        
        function contact_custom_columns_content( $column_name, $post_ID )
        {
            global  $post ;
            if ( $column_name == 'contact_id' ) {
                echo  $post_ID ;
            }
            if ( $column_name == 'first_name' ) {
                echo  get_post_meta( $post_ID, '_cl_first_name', true ) . '' ;
            }
            if ( $column_name == 'last_name' ) {
                echo  get_post_meta( $post_ID, '_cl_last_name', true ) ;
            }
            if ( $column_name == 'menu_order' ) {
                echo  $post->menu_order ;
            }
            if ( $column_name == 'job_title' ) {
                echo  get_post_meta( $post_ID, '_cl_job_title', true ) ;
            }
            
            if ( $column_name == 'email' ) {
                $email = get_post_meta( $post_ID, '_cl_email', true );
                
                if ( $email ) {
                    echo  $email ;
                    $valid_period = 60 * 60 * 24 * 2;
                    // 60 minutes * 24 * 2
                    $expiry = current_time( 'timestamp', 1 ) + $valid_period;
                    // current_time( 'timestamp' ) for your blog local timestamp
                    $url = site_url( '/_cl_update-contact/' . $post_ID . '/' );
                    $url = add_query_arg( 'valid', $expiry, $url );
                    // Adding the timestamp to the url with the "valid" arg
                    $nonce_url = wp_nonce_url( $url, 'contact_link_uid_' . $expiry, 'contact' );
                    // Adding our nonce to the url with a unique id made from the expiry timestamp
                    $update_url = $nonce_url;
                    echo  '<button class="contact-list-request-update contact-list-request-update-' . $post_ID . '" data-contact-id="' . $post_ID . '" data-email="' . get_post_meta( $post_ID, '_cl_email', true ) . '" data-site-url="' . get_site_url() . '" data-update-url="' . $update_url . '">' . __( 'Request update' ) . '</button><div class="contact-list-request-update-info contact-list-request-update-info-' . $post_ID . '"></div>' ;
                }
            
            }
            
            if ( $column_name == 'phone' ) {
                echo  get_post_meta( $post_ID, '_cl_phone', true ) ;
            }
            if ( $column_name == 'linkedin_url' ) {
                if ( get_post_meta( $post_ID, '_cl_linkedin_url', true ) ) {
                    echo  'x' ;
                }
            }
            if ( $column_name == 'twitter_url' ) {
                if ( get_post_meta( $post_ID, '_cl_twitter_url', true ) ) {
                    echo  'x' ;
                }
            }
            if ( $column_name == 'facebook_url' ) {
                if ( get_post_meta( $post_ID, '_cl_facebook_url', true ) ) {
                    echo  'x' ;
                }
            }
            if ( $column_name == 'instagram_url' ) {
                if ( get_post_meta( $post_ID, '_cl_instagram_url', true ) ) {
                    echo  'x' ;
                }
            }
        }
    
    }
    
    function set_custom_contact_list_sortable_columns( $columns )
    {
        $columns['last_name'] = 'last_name';
        $columns['menu_order'] = 'menu_order';
        return $columns;
    }
    
    function contact_list_custom_orderby( $query )
    {
        if ( !is_admin() ) {
            return;
        }
        $orderby = $query->get( 'orderby' );
        $order = ( $query->get( 'order' ) == 'asc' ? 'ASC' : 'DESC' );
        
        if ( $orderby == 'last_name' ) {
            $query->set( 'meta_query', array(
                'relation'         => 'AND',
                'last_name_clause' => array(
                'key'     => '_cl_last_name',
                'compare' => 'EXISTS',
            ),
            ) );
            $query->set( 'orderby', array(
                'last_name_clause' => $order,
                'title'            => $order,
            ) );
        }
    
    }
    
    /**
     * Adds a submenu page under a custom post type parent.
     *
     * @since    1.0.0
     */
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
    
    public function register_mail_log_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'Mail log', 'contact-list' ),
            __( 'Mail log', 'contact-list' ),
            'manage_options',
            'contact-list-mail-log',
            [ $this, 'register_mail_log_page_callback' ]
        );
    }
    
    public function register_import_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'Import contacts', 'contact-list' ),
            __( 'Import contacts', 'contact-list' ),
            'manage_options',
            'contact-list-import',
            [ $this, 'register_import_page_callback' ]
        );
    }
    
    public function register_export_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'Export contacts', 'contact-list' ),
            __( 'Export contacts', 'contact-list' ),
            'manage_options',
            'contact-list-export',
            [ $this, 'register_export_page_callback' ]
        );
    }
    
    public function create_contact_list_custom_taxonomy()
    {
        $labels = array(
            'name'              => __( 'Group', 'contact-list' ),
            'singular_name'     => __( 'Group', 'contact-list' ),
            'search_items'      => __( 'Search Groups', 'contact-list' ),
            'all_items'         => __( 'All Groups', 'contact-list' ),
            'parent_item'       => __( 'Parent Group', 'contact-list' ),
            'parent_item_colon' => __( 'Parent Group:', 'contact-list' ),
            'edit_item'         => __( 'Edit Group', 'contact-list' ),
            'update_item'       => __( 'Update Group', 'contact-list' ),
            'add_new_item'      => __( 'Add New Group', 'contact-list' ),
            'menu_name'         => __( 'Groups', 'contact-list' ),
            'not_found'         => __( 'No groups found.', 'contact-list' ),
        );
        register_taxonomy( 'contact-group', array( CONTACT_CPT ), array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'public'            => false,
            'rewrite'           => array(
            'slug' => 'groups',
        ),
        ) );
    }
    
    function contact_group_taxonomy_custom_fields( $tag )
    {
        $t_id = $tag->term_id;
        $term_meta = get_option( "taxonomy_term_{$t_id}" );
        ?>  
    
  <tr class="form-field">  
    <th scope="row" valign="top">  
      <label for="term_meta[hide_group]"><?php 
        echo  __( 'Hide group', 'contact-list' ) ;
        ?></label>  
      <div style="font-weight: 400; font-style: italic; font-size: 12px; margin-top: 6px;"><?php 
        echo  __( 'Note: this hides only the group, not the actual contacts that may belong to this group' ) ;
        ?></div>
    </th>  
    <td>  
      <input type="checkbox" name="term_meta[hide_group]" id="term_meta[hide_group]" <?php 
        echo  ( isset( $term_meta['hide_group'] ) ? 'checked="checked"' : '' ) ;
        ?>>
    </td>  
  </tr>  
    
  <?php 
    }
    
    function save_taxonomy_custom_fields( $term_id )
    {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_{$t_id}" );
        
        if ( isset( $_POST['term_meta'] ) ) {
            $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ) {
                if ( isset( $_POST['term_meta'][$key] ) ) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
            }
        } else {
            $term_meta = array();
        }
        
        update_option( "taxonomy_term_{$t_id}", $term_meta );
    }
    
    /**
     * Display callback for the submenu page.
     *
     * @since    1.0.0
     */
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
    
    public function register_mail_log_page_callback()
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

      <h1><?php 
        echo  __( 'Log of sent mail', 'contact-list' ) ;
        ?></h1>

      <?php 
        
        if ( isset( $_GET['mail_id'] ) ) {
            ?>

        <?php 
            $mail_id = (int) $_GET['mail_id'];
            global  $wpdb ;
            $table_name = $wpdb->prefix . "cl_sent_mail_log";
            $msg = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE id = " . $mail_id );
            ?>
        
        <a href="javascript:history.go(-1)">&lt;&lt; Back</a>
        
        <?php 
            foreach ( $msg as $row ) {
                ?>

          <table class="contact-list-mail-log-msg-details">
          <tr>
            <td><?php 
                echo  __( 'Message sent', 'contact-list' ) ;
                ?></td>
            <td><?php 
                echo  $row->created_at ;
                ?></td>
          </tr>
          <tr>
            <td><?php 
                echo  __( 'Sender email', 'contact-list' ) ;
                ?></td>
            <td>
              <?php 
                
                if ( isset( $row->sender_email ) ) {
                    ?>
                <?php 
                    echo  htmlspecialchars( $row->sender_email ) ;
                    ?>
              <?php 
                }
                
                ?>
            </td>
          </tr>
          <tr>
            <td><?php 
                echo  __( 'Sender name', 'contact-list' ) ;
                ?></td>
            <td><?php 
                echo  $row->sender_name ;
                ?></td>
          </tr>
          <tr>
            <td><?php 
                echo  __( 'Reply-to', 'contact-list' ) ;
                ?></td>
            <td>
              <?php 
                
                if ( isset( $row->reply_to ) ) {
                    ?>
                <?php 
                    echo  htmlspecialchars( $row->reply_to ) ;
                    ?>
              <?php 
                }
                
                ?>
            </td>
          </tr>
          <tr>
            <td><?php 
                echo  __( 'Subject', 'contact-list' ) ;
                ?></td>
            <td><?php 
                echo  $row->subject ;
                ?></td>
          </tr>
          <tr>
            <td><?php 
                echo  __( 'Message count', 'contact-list' ) ;
                ?></td>
            <td><?php 
                echo  $row->mail_cnt ;
                ?></td>
          </tr>
          </table>
          
          <h3><?php 
                echo  __( 'Mail report:', 'contact-list' ) ;
                ?></h3>
          
          <div class="contact-list-mail-log-recipients-container">
            <?php 
                echo  $row->report ;
                ?>
          </div>

        <?php 
            }
            ?>

      <?php 
        } else {
            ?>
      
        <?php 
            global  $wpdb ;
            $table_name = $wpdb->prefix . 'cl_sent_mail_log';
            $msg = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY created_at DESC LIMIT 200" );
            ?>
        
        <table class="contact-list-mail-log">
        <tr>
          <th><?php 
            echo  __( 'Date', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Sender email', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Sender name', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Reply-to', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Subject', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Recipients', 'contact-list' ) ;
            ?></th>
          <th><?php 
            echo  __( 'Report', 'contact-list' ) ;
            ?></th>
        </tr>

        <?php 
            
            if ( sizeof( $msg ) > 0 ) {
                ?>
          <?php 
                foreach ( $msg as $row ) {
                    ?>
            <tr>
              <td>
                <?php 
                    echo  $row->created_at ;
                    ?>
              </td>
              <td>
                <?php 
                    
                    if ( isset( $row->sender_email ) ) {
                        ?>
                  <?php 
                        echo  htmlspecialchars( $row->sender_email ) ;
                        ?>
                <?php 
                    }
                    
                    ?>
              </td>
              <td>
                <?php 
                    echo  $row->sender_name ;
                    ?>
              </td>
              <td>
                <?php 
                    
                    if ( isset( $row->reply_to ) ) {
                        ?>
                  <?php 
                        echo  htmlspecialchars( $row->reply_to ) ;
                        ?>
                <?php 
                    }
                    
                    ?>
              </td>
              <td>
                <?php 
                    echo  $row->subject ;
                    ?>
              </td>
              <td>
                <?php 
                    echo  $row->mail_cnt ;
                    ?>
              </td>
              <td>
                <a href="./edit.php?post_type=<?php 
                    echo  CONTACT_CPT ;
                    ?>&page=contact-list-mail-log&mail_id=<?php 
                    echo  $row->id ;
                    ?>"><?php 
                    echo  __( 'Open', 'contact-list' ) ;
                    ?>&nbsp;&raquo;</a>
              </td>
            </tr>
          <?php 
                }
                ?>
        <?php 
            } else {
                ?>
          <tr>
            <td colspan="7">
              <?php 
                echo  __( 'No mail sent yet.', 'contact-list' ) ;
                ?>
            </td>
          </tr>
        <?php 
            }
            
            ?>
        
        </table>
        
      <?php 
        }
        
        ?>

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
    
    public function register_import_page_callback()
    {
        ?>
    
    <div class="wrap">

        <h1><?php 
        echo  __( 'Import contacts', 'contact-list' ) ;
        ?></h1>

        <p>
            <?php 
        echo  __( 'You may import contacts from csv file using this form. There should be one contact per row, columns separated by comma.', 'contact-list' ) ;
        ?>
        </p>
        
        <hr class="style-one" />

          <?php 
        ?>

            <?php 
        echo  ContactListHelpers::proFeatureMarkup() ;
        ?>
        
        <?php 
        ?>
          

        <hr class="style-one" />

        <p>
            <strong><?php 
        echo  __( 'The columns should be in this order:', 'contact-list' ) ;
        ?></strong>
            <ol>
                <li><?php 
        echo  __( 'First name', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Last name', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Job title', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Email', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Phone', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'LinkedIn URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Twitter URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Facebook URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 1', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 2', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 3', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 4', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 1', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 2', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 3', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 4', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 5', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 6', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Groups', 'contact-list' ) ;
        ?><i><br /><?php 
        echo  __( 'Group names separated by the character "|", like so: Cats|Dogs|Parrots', 'contact-list' ) ;
        ?></i></li>
                <li><?php 
        echo  __( 'Country', 'contact-list' ) ;
        ?> <span class="new-feature-inline"><?php 
        echo  __( 'New', 'contact-list' ) ;
        ?></span></li>
                <li><?php 
        echo  __( 'State', 'contact-list' ) ;
        ?> <span class="new-feature-inline"><?php 
        echo  __( 'New', 'contact-list' ) ;
        ?></span></li>
            </ol>
        </p>

    </div>
    <?php 
    }
    
    public function register_export_page_callback()
    {
        ?>
    
    <div class="wrap">

        <h1><?php 
        echo  __( 'Export contacts', 'contact-list' ) ;
        ?></h1>

        <p>
            <?php 
        echo  __( 'You may export contacts to a csv file. There will be one contact per row, columns separated by comma.', 'contact-list' ) ;
        ?>
        </p>
        
        <hr class="style-one" />

          <?php 
        ?>

            <?php 
        echo  ContactListHelpers::proFeatureMarkup() ;
        ?>
        
        <?php 
        ?>
          

        <hr class="style-one" />

        <p>
            <strong><?php 
        echo  __( 'The columns are in this order:', 'contact-list' ) ;
        ?></strong>
            <ol>
                <li><?php 
        echo  __( 'First name', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Last name', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Job title', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Email', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Phone', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'LinkedIn URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Twitter URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Facebook URL', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 1', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 2', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 3', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Address line 4', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 1', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 2', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 3', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 4', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 5', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Custom field 6', 'contact-list' ) ;
        ?></li>
                <li><?php 
        echo  __( 'Groups', 'contact-list' ) ;
        ?><i><br /><?php 
        echo  __( 'Group names separated by the character "|", like so: Cats|Dogs|Parrots', 'contact-list' ) ;
        ?></i></li>
                <li><?php 
        echo  __( 'Country', 'contact-list' ) ;
        ?> <span class="new-feature-inline"><?php 
        echo  __( 'New', 'contact-list' ) ;
        ?></span></li>
                <li><?php 
        echo  __( 'State', 'contact-list' ) ;
        ?> <span class="new-feature-inline"><?php 
        echo  __( 'New', 'contact-list' ) ;
        ?></span></li>
            </ol>
        </p>

    </div>
    <?php 
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
    
    public function alter_the_query( $request )
    {
        global  $wp ;
        $url = home_url( $wp->request );
        $cl_query = 0;
        $cl_sub = 0;
        $url_parts = parse_url( $url );
        if ( isset( $url_parts['path'] ) ) {
            $path_parts = explode( '/', $url_parts['path'] );
        }
        
        if ( isset( $path_parts[2] ) && $path_parts[2] == '_cl_update-contact' ) {
            $cl_query = 1;
            $cl_sub = 1;
        } else {
            if ( isset( $path_parts[1] ) && $path_parts[1] == '_cl_update-contact' ) {
                $cl_query = 1;
            }
        }
        
        
        if ( $cl_query ) {
            $contact_id = 0;
            
            if ( $cl_sub ) {
                $contact_id = ( isset( $path_parts[3] ) ? (int) $path_parts[3] : 0 );
            } else {
                $contact_id = ( isset( $path_parts[2] ) ? (int) $path_parts[2] : 0 );
            }
            
            
            if ( $contact_id ) {
                $html = ContactListHelpers::updateContactMarkup( $contact_id );
                print_r( $html );
                die;
            }
        
        }
        
        return $request;
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