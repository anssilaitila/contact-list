<?php

class ContactListPrintable {

  public function register_printable_page() {
    add_submenu_page(
      'edit.php?post_type=' . CONTACT_CPT,
      __('Printable list', 'contact-list'),
      __('Printable list', 'contact-list'),
      'manage_options',
      'contact-list-printable',
      [ $this, 'register_printable_page_callback' ]
    );
  }

  public function register_printable_page_callback() {
    ?>
    
    <div class="wrap">

        <h1 class="cl-dont-print"><?= __('Printable list', 'contact-list') ?></h1>

        <p class="cl-dont-print">
          <?= __('When you print this page, only the list below is printed.', 'contact-list') ?>
        </p>

        <p class="cl-dont-print">
          <form method="get" class="cl-dont-print">
            <input type="hidden" name="post_type" value="contact" />
            <input type="hidden" name="page" value="contact-list-printable" />
            
            <?= __('Change card height:', 'contact-list') ?> <input name="card_height" value="<?= (isset($_GET) && isset($_GET['card_height'])) ? $_GET['card_height'] : 340 ?>" style="width: 60px; text-align: right;" /> px <input type="submit" class="contact-list-admin-button" value="<?= __('Submit', 'contact-list') ?>" style="margin-left: 6px;" />
          </form>
        </p>
        
        <p class="cl-dont-print">
          <button onclick="window.print();" style="font-size: 15px; padding: 10px; font-weight: 600;" class="contact-list-admin-button"><?= __('Print contacts', 'contact-list') ?></button>
        </p>
        
        <hr class="style-one cl-dont-print" />

        <?php

          $s = get_option('contact_list_settings');

          $html = '';        
          
          $html .= '<style>.contact-list-container #contact-list-search ul li { margin-bottom: 5px; } </style>';        
          $html .= '<style>.contact-list-contact-container { background: #fff; } </style>';
        
          if (isset($s['card_border']) && $s['card_border']) {
        
            if ($s['card_border'] == 'black') {
              $html .= '<style>.contact-list-contact-container { border: 1px solid #333; border-radius: 10px; padding: 10px; } </style>';
            } elseif ($s['card_border'] == 'gray') {
              $html .= '<style>.contact-list-contact-container { border: 1px solid #bbb; border-radius: 10px; padding: 10px; } </style>';
            }
          }
        
          if (isset($_GET) && isset($_GET['card_height'])) {
            $html .= '<style>.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: ' . $_GET['card_height'] . 'px !important; } </style>';  
            $html .= '<style> @media (max-width: 820px) { .contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: auto; } } </style>';  
          } else {
            $html .= '<style>.contact-list-2-cards-on-the-same-row #all-contacts li .contact-list-contact-container { height: 340px !important; }</style>';
          }
          
          $html .= '<div class="contact-list-container contact-list-2-cards-on-the-same-row">';

          $meta_query = array('relation' => 'AND');

          $meta_query []= array(
            'last_name_clause' => array(
              'key' => '_cl_last_name',
              'compare' => 'EXISTS',
            )
          );

          $order_by = array(
            'menu_order' => 'ASC',
            'last_name_clause' => 'ASC',
            'title' => 'ASC',
          );
            
          if (ORDER_BY == '_cl_first_name') {
        
            $meta_query []= array(
              'first_name_clause' => array(
                'key' => '_cl_first_name',
                'compare' => 'EXISTS',
              )
            );
        
            $order_by = array(
              'menu_order' => 'ASC',
              'first_name_clause' => 'ASC',
              'title' => 'ASC',
            );
        
          }

          $wp_query = new WP_Query(array(
            'post_type' => 'contact',
            'post_status' => 'publish',
            'posts_per_page' => -1,

            'meta_query' => $meta_query,          
            'orderby' => $order_by

          ));
          
          if ($wp_query->have_posts()):
                  
            $html .= '<div class="contact-list-ajax-results">';
            $html .= ContactListHelpers::contactListMarkup($wp_query);
            $html .= '</div>';
    
          endif;

          $html .= '</div>';
          
          echo $html;
        ?>

    </div>
    <?php
  }

}
