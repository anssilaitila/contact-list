<?php

class ContactListHelpSupport
{
    public function register_support_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . CONTACT_CPT,
            __( 'How to use Contact List', 'contact-list' ),
            __( 'Help / Support', 'contact-list' ),
            'manage_options',
            'contact-list-support',
            [ $this, 'register_support_page_callback' ]
        );
    }
    
    public function register_support_page_callback()
    {
        ?>
    
    <div class="wrap">

      <h1><?php 
        echo  __( 'How to use Contact List', 'contact-list' ) ;
        ?></h1>

      <div class="contact-list-examples">
          <p><?php 
        echo  __( 'Some examples on how you can use different views available at', 'contact-list' ) ;
        ?> <a href="https://www.contactlistpro.com/contact-list/" target="_blank"><?php 
        echo  __( 'contactlistpro.com', 'contact-list' ) ;
        ?></a>.</p>
          <p><?php 
        echo  __( 'Any feedback is welcome. You may contact the author at', 'contact-list' ) . ' <a href="https://anssilaitila.fi/" target="_blank">anssilaitila.fi</a> ' . __( 'or by email:', 'contact-list' ) . ' <a href="mailto:&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;">&#97;&#110;&#115;&#115;&#105;&#46;&#108;&#97;&#105;&#116;&#105;&#108;&#97;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;</a>' ;
        ?></p>
      </div>

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
        <li><?php 
        echo  __( 'Additional parameters', 'contact-list' ) ;
        ?>
            <ul class="contact-list-admin-ul">
                <li><?php 
        echo  __( 'Hide search form:', 'contact-list' ) ;
        ?> <span class="contact-list-shortcode">[contact_list hide_search=1]</span></li>
                <li><?php 
        echo  __( 'Layout "2 cards on the same row"', 'contact-list' ) ;
        ?>: <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Layout "3 cards on the same row"', 'contact-list' ) ;
        ?> (<?php 
        echo  __( 'without contact images', 'contact-list' ) ;
        ?>): <span class="contact-list-shortcode">[contact_list layout=3-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Layout "4 cards on the same row"', 'contact-list' ) ;
        ?> (<?php 
        echo  __( 'without contact images', 'contact-list' ) ;
        ?>): <span class="contact-list-shortcode">[contact_list layout=4-cards-on-the-same-row]</span></li>
                <li><?php 
        echo  __( 'Multiple parameters:', 'contact-list' ) ;
        ?> <span class="contact-list-shortcode">[contact_list layout=2-cards-on-the-same-row hide_search=1]</span></li>
            </ul>
        </li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Contacts with groups', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
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

      <h2>
        <?php 
        echo  __( 'Contacts from specific group', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_groups group=GROUP_SLUG]</span>' . __( 'to the content editor of any page you wish the contact list to appear. Replace GROUP_SLUG with the appropriate slug that can be found from group management.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Single contact', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list contact=CONTACT_ID]</span>' . __( 'to the content editor of any page you wish the contact to appear. Replace CONTACT_ID with the appropriate id that can be found from contact management. There\'s a column "ID" in the All Contacts -page, which contains the numeric value.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h2>
        <?php 
        echo  __( 'Allow visitors to add new contacts', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_form]</span>' . __( 'to the page you wish the form to appear on.', 'contact-list' ) ;
        ?></li>
        <li><?php 
        echo  __( 'When a user submits the form, a new contact is saved to the contacts. The status of that contact is "Pending Review" and a site administrator must publish/edit/delete the contact.', 'contact-list' ) ;
        ?></li>
      </ol>

      <h3>
        <?php 
        echo  __( 'Only a search form that searches from all contacts', 'contact-list' ) ;
        ?>
        <?php 
        ?>
          <a href="<?php 
        echo  get_admin_url() ;
        ?>options-general.php?page=contact-list-pricing" class="contact-list-pro-only-inline">Pro</a>
        <?php 
        ?>
      </h2>
      <ol>
        <li><?php 
        echo  __( 'Insert the shortcode', 'contact-list' ) . '<span class="contact-list-shortcode">[contact_list_search]</span>' . __( 'to the page you wish the view to appear on.', 'contact-list' ) ;
        ?></li>
      </ol>

    </div>
    <?php 
    }

}