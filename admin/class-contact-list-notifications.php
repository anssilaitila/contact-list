<?php

class ContactListNotifications {

  public function notifications_html() {

  	$cl_rating_show_notice = get_option('contact_list_rating_show_notice');

  	$cl_rating_notice_option = get_option('contact_list_rating_notice');
  	$cl_rating_notice_waiting = get_transient('contact_list_rating_notice_waiting');

  	$should_show_rating_notice = ($cl_rating_show_notice && $cl_rating_notice_waiting !== 'waiting' && $cl_rating_notice_option !== 'dismissed');

  	if ($should_show_rating_notice) {

  		$dismiss_url = add_query_arg('cl_ignore_rating_notice_notify', '1');
  		$later_url = add_query_arg('cl_ignore_rating_notice_notify', 'later');

  		echo "
        <div class='cl_notice cl_review_notice'>
            <img src='". CONTACT_LIST_URI . 'img/cl-sunrise.jpg' ."' alt='" . __('Contact List', 'contact-list') . "'>
            <div class='contact-list-notice-text'>
                <p style='padding-top: 4px;'>" . sprintf( __( "It's great to see that you've been using the %sContact List%s plugin for a while now. Hopefully you're happy with it!&nbsp; If so, would you consider leaving a positive review? It really helps to support the plugin and helps others to discover it too!", 'contact-list' ), '<strong style=\'font-weight: 700;\'>', '</strong>' ) . "</p>
                <p class='links'>
                    <a class='cl_notice_dismiss' href='https://wordpress.org/support/plugin/contact-list/reviews/' target='_blank'>" . __('Sure, I\'d love to!', 'contact-list') . "</a>
                    &middot;
                    <a class='cl_notice_dismiss' href='" . esc_url($dismiss_url) . "'>" . __('No thanks', 'contact-list') . "</a>
                    &middot;
                    <a class='cl_notice_dismiss' href='" . esc_url($dismiss_url) . "'>" . __('I\'ve already given a review', 'contact-list') . "</a>
                    &middot;
                    <a class='cl_notice_dismiss' href='" . esc_url($later_url) . "'>" . __('Ask Me Later', 'contact-list') . "</a>
                </p>
            </div>
            <a class='cl_notice_close' href='" . esc_url($dismiss_url) . "'>x</a>
        </div>";
  
    }
  }

  public function process_notifications() {

    /*
    if (0) {
      delete_transient('contact_list_rating_notice_waiting');
  		delete_option('contact_list_rating_notice');
  		delete_option('contact_list_rating_notice_date');
  		delete_option('contact_list_rating_show_notice');
    }
    */
    
  	global $current_user;
  	$user_id = $current_user->ID;
  	$cl_statuses_option = get_option('cl_statuses', array());

    if (!get_option('contact_list_rating_notice_date')) {

      $dt = new DateTime('+2 weeks');

      if ($dt !== false && !array_sum($dt::getLastErrors())) {
        $notify_date = $dt;
        update_option('contact_list_rating_notice_date', $notify_date, false);
      }

    } else {

      $notify_date = get_option('contact_list_rating_notice_date');

      if ($notify_date instanceof DateTime) {
        $dt_now = new DateTime('now');
        
        if ($notify_date <= $dt_now) {
          update_option('contact_list_rating_show_notice', 1, false);
        }

      }
      
    }
  
  	if (isset($_GET['cl_ignore_rating_notice_notify'])) {
    	
  		if ((int) $_GET['cl_ignore_rating_notice_notify'] === 1) {
    		
  			update_option('contact_list_rating_notice', 'dismissed', false);
  			$cl_statuses_option['rating_notice_dismissed'] = $this->cl_get_current_time();
  			update_option('cl_statuses', $cl_statuses_option, false);
  
  		} elseif ($_GET['cl_ignore_rating_notice_notify'] === 'later') {

  			set_transient('contact_list_rating_notice_waiting', 'waiting', 2 * WEEK_IN_SECONDS);
  			update_option('contact_list_rating_notice', 'pending', false);

  		}
  	}
    
  }

  public function cl_get_current_time() {
  	$current_time = time();
  
  	// $current_time = strtotime( 'November 25, 2022' ) + 1;
  
  	return $current_time;
  }

}
