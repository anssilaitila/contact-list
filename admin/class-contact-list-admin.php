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
            plugin_dir_url( __FILE__ ) . 'contact-list-admin.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'contact-list-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    public function modify_post_title( $data )
    {
        if ( $_POST && $data['post_type'] == 'contact' ) {
            $data['post_title'] = (( isset( $_POST['_cl_first_name'] ) ? $_POST['_cl_first_name'] : '' )) . ' ' . (( isset( $_POST['_cl_last_name'] ) ? $_POST['_cl_last_name'] : '' ));
        }
        return $data;
    }
    
    public function create_custom_post_type_contact()
    {
        register_post_type( 'contact', [
            'labels'             => [
            'name'          => __( 'Contact List', 'contact-list' ),
            'singular_name' => __( 'Contact', 'contact-list' ),
            'add_new_item'  => __( 'Add New Contact', 'contact-list' ),
            'edit_item'     => __( 'Edit Contact', 'contact-list' ),
            'not_found'     => __( 'No contacts found.', 'contact-list' ),
            'all_items'     => __( 'All Contacts', 'contact-list' ),
        ],
            'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
            'public'             => true,
            'has_archive'        => false,
            'publicly_queryable' => false,
        ] );
        remove_post_type_support( 'contact', 'title' );
        remove_post_type_support( 'contact', 'editor' );
        add_image_size( 'contact-list-contact', 160, 200 );
        /**
         * Custom columns for shared files (admin)
         */
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
                $defaults['linkedin_url'] = ( isset( $options['linkedin_url_title'] ) && $options['linkedin_url_title'] ? $options['linkedin_url_title'] : __( 'LinkedIn URL', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_twitter_url'] ) ) {
                $defaults['twitter_url'] = ( isset( $options['twitter_url_title'] ) && $options['twitter_url_title'] ? $options['twitter_url_title'] : __( 'Twitter URL', 'contact-list' ) );
            }
            if ( !isset( $options['af_hide_facebook_url'] ) ) {
                $defaults['facebook_url'] = ( isset( $options['facebook_url_title'] ) && $options['facebook_url_title'] ? $options['facebook_url_title'] : __( 'Facebook URL', 'contact-list' ) );
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
                echo  get_post_meta( $post_ID, '_cl_email', true ) ;
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
            'edit.php?post_type=contact',
            __( 'Send email to contacts', 'contact-list' ),
            __( 'Send email', 'contact-list' ),
            'manage_options',
            'contact-list-send-email',
            [ $this, 'register_send_email_page_callback' ]
        );
    }
    
    /**
     * Adds a submenu page under a custom post type parent.
     *
     * @since    1.0.0
     */
    public function register_support_page()
    {
        add_submenu_page(
            'edit.php?post_type=contact',
            __( 'How to use the Contact List plugin', 'contact-list' ),
            __( 'Help / Support', 'contact-list' ),
            'manage_options',
            'contact-list-support',
            [ $this, 'register_support_page_callback' ]
        );
    }
    
    public function register_import_page()
    {
        add_submenu_page(
            'edit.php?post_type=contact',
            __( 'Import contacts', 'contact-list' ),
            __( 'Import contacts', 'contact-list' ),
            'manage_options',
            'contact-list-import',
            [ $this, 'register_import_page_callback' ]
        );
    }
    
    public function add_settings_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=contact-list';
        $submenu['edit.php?post_type=contact'][] = array( __( 'Settings', 'contact-list' ), 'manage_options', $permalink );
    }
    
    public function add_upgrade_link()
    {
        global  $submenu ;
        $permalink = './options-general.php?page=contact-list-pricing';
        $submenu['edit.php?post_type=contact'][] = array(
            __( 'Upgrade&nbsp;&nbsp;➤', 'contact-list' ),
            'manage_options',
            $permalink,
            '',
            'contact-list-upgrade'
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
        register_taxonomy( 'contact-group', array( 'contact' ), array(
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
    
    /**
     * Display callback for the submenu page.
     *
     * @since    1.0.0
     */
    public function register_send_email_page_callback()
    {
        $term_id = $_GET['group_id'];
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
            'post_type'      => 'contact',
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

      <form method="post" class="send_email_form" action="https://mail.anssilaitila.fi/contact-list/" target="send_email">

          <h1><?php 
        echo  __( 'Send email to contacts', 'contact-list' ) ;
        ?></h1>

          <div class="email-info">
            <b><?php 
        echo  __( 'Note:' ) ;
        ?></b> <?php 
        echo  __( 'The emails are sent by the plugin developers own server and using <a href="https://www.mailgun.com" target="_blank">Mailgun</a>. The server is a DigitalOcean Droplet hosted in the EU. This method was chosen to ensure reliable mail delivery.', 'contact-list' ) ;
        ?>
          </div>

          <div class="sender-info"><?php 
        echo  __( 'The sender of the message is' ) ;
        ?> <b>no-reply@contactlistpro.com</b>.</div>
    
          <label>
            <span><?php 
        echo  __( 'Subject', 'contact-list' ) ;
        ?></span>
            <input name="subject" value="" />
          </label>
    
          <label>
            <span><?php 
        echo  __( 'Message', 'contact-list' ) ;
        ?></span>
            <textarea name="body"></textarea>
          </label>

          <div>
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
                    $output .= '<label class="contact-category"><input type="radio" name="_cl_groups[]" value="' . esc_attr( $category->term_id ) . '" onclick="document.location.href=\'./edit.php?post_type=contact&page=contact-list-send-email&group_id=\' + this.value;" ' . (( isset( $_GET['group_id'] ) && $_GET['group_id'] == $category->term_id ? 'checked' : '' )) . ' /> <span class="contact-list-checkbox-title">' . esc_attr( $category->name ) . '</span></label>';
                    foreach ( $taxonomies as $subcategory ) {
                        if ( $subcategory->parent == $category->term_id ) {
                            $output .= '<label class="contact-subcategory"><input type="radio" name="_cl_groups[]" value="' . esc_attr( $subcategory->term_id ) . '" onclick="document.location.href=\'./edit.php?post_type=contact&page=contact-list-send-email&group_id=\' + this.value;" ' . (( isset( $_GET['group_id'] ) && $_GET['group_id'] == $subcategory->term_id ? 'checked' : '' )) . ' /> <span class="contact-list-checkbox-title">' . esc_html( $subcategory->name ) . '</span></label>';
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

          <?php 
        ?>

            <?php 
        echo  proFeatureMarkup() ;
        ?>
            
          <?php 
        ?>
          
      </form>

      <?php 
        ?>

    </div>
    <?php 
    }
    
    /**
     * Display callback for the submenu page.
     *
     * @since    1.0.0
     */
    public function register_support_page_callback()
    {
        ?>
    
    <style>
      .contact-list-feedback-form-container {
        padding: 10px;
        background: #fff;
      }
      hr.style-one {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #bbb, #333, #bbb);
        margin: 2rem 0;
      }
      .contact-list-shortcode {
        background: #fff;
        padding: 2px 6px;
        margin: 0 5px;
      }
    </style>
    
    <div class="wrap">

      <h1><?php 
        echo  __( 'How to use the Contact List plugin', 'contact-list' ) ;
        ?></h1>
      <h2><?php 
        echo  __( 'Only contacts, no groups', 'contact-list' ) ;
        ?></h2>

      <ol>
        <li><?php 
        echo  __( 'Add the contacts via the All Contacts page.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Insert the shortcode <span class="contact-list-shortcode">[contact_list]</span> to the content editor of any page you wish the contact list to appear.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2><?php 
        echo  __( 'Contacts with groups', 'contact-list' ) ;
        ?></h2>
      <ol>
        <li><?php 
        echo  __( 'Add the groups via the Groups page. There may be groups under groups (hierarchial groups, 2 or more levels).', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Add the contacts via the All Contacts page. You may select the appropriate group(s) at this point.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'Insert the shortcode <span class="contact-list-shortcode">[contact_list_groups]</span> to the content editor of any page you wish the group list to appear. When a user selects a group, then a list of contacts belonging to that group is displayed. Also, if there are subgroups under that group, those will be displayed.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2><?php 
        echo  __( 'Contacts from specific group', 'contact-list' ) ;
        ?></h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_groups group=GROUP_SLUG]</span>' . __( 'to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h3><?php 
        echo  __( 'Single contact', 'contact-list' ) ;
        ?></h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list contact=CONTACT_ID]</span>' . __( 'to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h3><?php 
        echo  __( 'Allow visitors to add new contacts', 'contact-list' ) ;
        ?></h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_form]</span>' . __( 'to the page you wish the form to appear on.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'When a user submits the form, a new contact is saved to the contacts. The status of that contact is "Pending Review" and a site administrator must publish/edit/delete the contact.', 'contact-list' ) ;
        ?></li>
      </ol>

      <hr class="style-one" />

      <h2><?php 
        echo  __( 'Send feedback', 'contact-list' ) ;
        ?></h2>
      <p><?php 
        echo  __( 'Any feedback is welcome. You may contact the author at', 'contact-list' ) . ' <a href="https://anssilaitila.fi/" target="_blank">anssilaitila.fi</a> ' . __( 'or e-mail directly:', 'contact-list' ) . ' <a href="mailto:&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;"> &#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a>' ;
        ?></p>

      <h2><?php 
        echo  __( 'Give a rating for the plugin', 'contact-list' ) ;
        ?></h2>
      <p><?php 
        echo  __( "Whether it's 1 star or 5 stars, I'm grateful for your rating. You may rate the plugin", 'contact-list' ) ;
        ?> <a href="https://wordpress.org/support/plugin/contact-list/reviews/" target="_blank"><?php 
        echo  __( 'here', 'contact-list' ) ;
        ?></a>.</p>

      <h2><?php 
        echo  __( 'Send direct feedback to the author', 'contact-list' ) ;
        ?></h2>
      <p><?php 
        echo  __( 'Fill out the form below to send feedback or questions to the author. Only the information provided below is sent. Thanks!', 'contact-list' ) ;
        ?></p>

      <div class="contact-list-feedback-form-container">
        <iframe src='https://anssilaitila.fi/form-builder/wp-contact-list/' id='FormBuilderViewport_wp-contact-list' class='FormBuilderViewport' data-form='wp-contact-list' title='wp-contact-list' frameborder='0' allowTransparency='true' style='width: 100%; height: 560px;'></iframe>
      </div>

    </div>
    <?php 
    }
    
    public function register_import_page_callback()
    {
        ?>
    
    <style>
      .contact-list-feedback-form-container {
        padding: 10px;
        background: #fff;
      }
      hr.style-one {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #bbb, #333, #bbb);
        margin: 2rem 0;
      }
      .btn-submit {
        font-size: 1.1rem;
        padding: .25rem 2rem;
        margin-top: 1rem;
      }
      .import-finished {
        border: #333;
        background: #fff;
        padding: 2rem;
        margin-top: 1rem;
        line-height: 1.2;
      }
      .import-finished h3 {
        margin-top: 0;
      }
    </style>
    
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
        echo  proFeatureMarkup() ;
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
            </ol>
        </p>

    </div>
    <?php 
    }
    
    public function new_contact_send_email( $post_id, $post, $update )
    {
        $post_title = get_the_title( $post_id );
        $s = get_option( 'contact_list_settings' );
        
        if ( isset( $s['send_email'] ) && isset( $s['recipient_email'] ) && is_email( $s['recipient_email'] ) && $post->post_type == 'contact' && $post->post_status == 'pending' ) {
            $url = 'https://mail.anssilaitila.fi';
            $contact_list_admin_url = get_admin_url() . 'edit.php?post_type=contact';
            $data = array(
                'post_title'      => $post_title,
                'recipient_email' => $s['recipient_email'],
                'url'             => $contact_list_admin_url,
            );
            $options = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query( $data ),
            ),
            );
            $context = stream_context_create( $options );
            $result = file_get_contents( $url, false, $context );
            $data_final = array(
                'post_title'      => $post_title,
                'recipient_email' => $s['recipient_email'],
                'url'             => $contact_list_admin_url,
                's'               => $result,
            );
            $options_final = array(
                'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query( $data_final ),
            ),
            );
            $context_final = stream_context_create( $options_final );
            $result_final = file_get_contents( $url, false, $context_final );
        }
    
    }

}