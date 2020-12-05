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
          <?= __('When you print this page, only the list of contacts is printed.', 'contact-list') ?>
        </p>

        <p class="cl-dont-print">
          <form method="get" class="cl-dont-print">
            <input type="hidden" name="post_type" value="contact" />
            <input type="hidden" name="page" value="contact-list-printable" />
            <input type="hidden" name="search" value="1" />

            <?php
            $groups = get_terms(array(
              'taxonomy'   => 'contact-group',
              'hide_empty' => true,
            ));
            ?>

            <div>
              <h3><?= __('Select category:', 'contact-list') ?></h3>
              <select name="cl_cat" class="select_v2">
                <option value=""><?= __('All contacts', 'contact-list') ?></option>
        
                <?php
                foreach ($groups as $g) {
                  
                  $t_id = $g->term_id;
                  $custom_fields = get_option("taxonomy_term_$t_id");
                  
                  echo '<option value="' . $g->slug . '" ' . (isset($_GET['cl_cat']) && $_GET['cl_cat'] == $g->slug ? 'selected="selected"' : '') . '>' . $g->name . '</option>';
    
                }
                ?>
              </select>
              <hr class="clear" />
            </div>

            <div>
              <h3><?= __('Select view:', 'contact-list') ?></h3>
              <select name="cl_view" class="select_v2">
                <option value=""><?= __('Default list', 'contact-list') ?></option>
                <option value="simple_list" <?= (isset($_GET['cl_view']) && $_GET['cl_view'] == 'simple_list') ? 'selected' : '' ?>><?= __('Simple list', 'contact-list') ?></option>
              </select>
              <hr class="clear" />
            </div>
            
            <div>
              <h3><?= __('Change card height:', 'contact-list') ?></h3>
              <input name="card_height" value="<?= (isset($_GET) && isset($_GET['card_height'])) ? $_GET['card_height'] : 340 ?>" style="width: 60px; text-align: right;" /> px
            </div>
            
            <div style="background: #fff; margin-top: 20px; padding: 10px 20px;">
              <input type="submit" class="contact-list-admin-button" style="font-size: 15px; padding: 5px 10px; font-weight: 600; border: 1px solid #bbb;" value="<?= __('Show contacts', 'contact-list') ?>" style="margin-left: 6px;" />
              <?php if (isset($_GET['search'])): ?>
                <span class="cl-dont-print">
                  <button onclick="window.print();" class="contact-list-admin-button" style="font-size: 15px; padding: 5px 20px; font-weight: 600; background: mediumseagreen; border: 1px solid mediumseagreen; color: white; text-shadow: 1px 1px 0 #000;" ><?= __('Print contacts', 'contact-list') ?></button>
                </span>
              <?php endif; ?>
            </div>

          </form>
        </p>

        <hr class="style-one cl-dont-print" />

        <?php
          
          if (isset($_GET['search'])) {

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
  
            $tax_query = [];
        
            if (isset($_GET['cl_cat']) && $_GET['cl_cat']) {
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                			'taxonomy' => 'contact-group',
                			'field'	 => 'slug',
                			'terms'		 => $_GET['cl_cat']
                		)
            		);
            }
  
            $wp_query = new WP_Query(array(
              'post_type' => 'contact',
              'post_status' => 'publish',
              'posts_per_page' => -1,
  
              'meta_query' => $meta_query,          
              'tax_query' => $tax_query,          
              'orderby' => $order_by
  
            ));
            
            $html .= '<link rel="stylesheet" href="' . CONTACT_LIST_URI . 'dist/font-awesome-4.7.0/css/font-awesome.min.css">';

            if ($wp_query->have_posts()):

              if (isset($_GET['cl_view']) && $_GET['cl_view'] == 'simple_list'):

                $html .= '<div class="contact-list-simple-ajax-results">';
                $html .= ContactListPublicHelpers::contactListSimpleMarkup($wp_query);
                $html .= '</div>';
                
              else:

                $html .= '<div class="contact-list-ajax-results">';
                $html .= ContactListHelpers::contactListMarkup($wp_query);
                $html .= '</div>';
                
              endif;
    
            endif;
  
            $html .= '</div>';
            
            echo $html;
            
          } else {
            
            echo '<span style="font-size: 1.1rem;">' .  __('First click on the Show contacts -button to get the contacts.', 'contact-list') . '</span>';
            
          }
        ?>

    </div>
    <?php
  }

}
