<?php

class ContactListPublicAjax
{
    public function cl_get_contacts()
    {
        $html = '';
        $meta_query = array(
            'relation' => 'AND',
        );
        $meta_query[] = array(
            'last_name_clause' => array(
            'key'     => '_cl_last_name',
            'compare' => 'EXISTS',
        ),
        );
        $order_by = array(
            'menu_order'       => 'ASC',
            'last_name_clause' => 'ASC',
            'title'            => 'ASC',
        );
        
        if ( ORDER_BY == '_cl_first_name' ) {
            $meta_query[] = array(
                'first_name_clause' => array(
                'key'     => '_cl_first_name',
                'compare' => 'EXISTS',
            ),
            );
            $order_by = array(
                'menu_order'        => 'ASC',
                'first_name_clause' => 'ASC',
                'title'             => 'ASC',
            );
        }
        
        if ( isset( $_POST[CONTACT_LIST_CAT1] ) && $_POST[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => $_POST[CONTACT_LIST_CAT1],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => $_POST[CONTACT_LIST_CAT2],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => $_POST[CONTACT_LIST_CAT3],
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => $_POST['cl_cat'],
            ),
            );
        }
        $posts_per_page = -1;
        if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
            $posts_per_page = $s['contacts_per_page'];
        }
        $wp_query = new WP_Query( array(
            'post_type'      => CONTACT_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListHelpers::contactListMarkup( $wp_query );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        echo  $html ;
    }
    
    public function cl_get_contacts_simple()
    {
        $html = '';
        $meta_query = array(
            'relation' => 'AND',
        );
        $meta_query[] = array(
            'last_name_clause' => array(
            'key'     => '_cl_last_name',
            'compare' => 'EXISTS',
        ),
        );
        $order_by = array(
            'menu_order'       => 'ASC',
            'last_name_clause' => 'ASC',
            'title'            => 'ASC',
        );
        
        if ( ORDER_BY == '_cl_first_name' ) {
            $meta_query[] = array(
                'first_name_clause' => array(
                'key'     => '_cl_first_name',
                'compare' => 'EXISTS',
            ),
            );
            $order_by = array(
                'menu_order'        => 'ASC',
                'first_name_clause' => 'ASC',
                'title'             => 'ASC',
            );
        }
        
        if ( isset( $_POST[CONTACT_LIST_CAT1] ) && $_POST[CONTACT_LIST_CAT1] ) {
            $meta_query[] = array(
                'key'     => '_cl_country',
                'value'   => $_POST[CONTACT_LIST_CAT1],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT2] ) && $_POST[CONTACT_LIST_CAT2] ) {
            $meta_query[] = array(
                'key'     => '_cl_state',
                'value'   => $_POST[CONTACT_LIST_CAT2],
                'compare' => 'LIKE',
            );
        }
        if ( isset( $_POST[CONTACT_LIST_CAT3] ) && $_POST[CONTACT_LIST_CAT3] ) {
            $meta_query[] = array(
                'key'     => '_cl_city',
                'value'   => $_POST[CONTACT_LIST_CAT3],
                'compare' => 'LIKE',
            );
        }
        $tax_query = [];
        if ( isset( $_POST['cl_cat'] ) && $_POST['cl_cat'] ) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                'taxonomy' => 'contact-group',
                'field'    => 'slug',
                'terms'    => $_POST['cl_cat'],
            ),
            );
        }
        $posts_per_page = -1;
        if ( isset( $s['contacts_per_page'] ) && $s['contacts_per_page'] ) {
            $posts_per_page = $s['contacts_per_page'];
        }
        $wp_query = new WP_Query( array(
            'post_type'      => CONTACT_CPT,
            'post_status'    => 'publish',
            'posts_per_page' => (int) $posts_per_page,
            'meta_query'     => $meta_query,
            'tax_query'      => $tax_query,
            'orderby'        => $order_by,
        ) );
        
        if ( $wp_query->have_posts() ) {
            $html .= ContactListPublicHelpers::contactListSimpleMarkup( $wp_query );
            $html .= '<hr class="clear" />';
        }
        
        if ( $wp_query->found_posts == 0 ) {
            $html .= '<p>' . ContactListHelpers::getText( 'text_sr_no_contacts_found', __( 'No contacts found.', 'contact-list' ) ) . '</p>';
        }
        echo  $html ;
    }
    
    public function my_ajax_without_file()
    {
        ?>
  
      <script type="text/javascript" >
      jQuery(document).ready(function($) {
        ajaxurl = "<?php 
        echo  admin_url( 'admin-ajax.php' ) ;
        ?>"; // get ajaxurl
      });
      </script> 
      <?php 
    }

}