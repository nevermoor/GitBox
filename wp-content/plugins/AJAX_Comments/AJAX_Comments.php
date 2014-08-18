<?php
/*
Plugin Name: AJAX New Comments
Description: Someday this might work
Author: nevermoor
Version: 1
*/


function widget_myNewComments($args) {

	global $current_user;
      	get_currentuserinfo();


	$timer_zero = $timer_thirty = $timer_oneM = $timer_fiveM = "";
	$insert2 = " CHECKED";

	switch ( get_the_author_meta( 'ajax_timer', $current_user->ID ) )
	{
		case 30: 
			$timer_thirty = $insert2;
			break;
		case 60: 
			$timer_oneM = $insert2;
			break;
		case 0:
			$timer_zero = $insert2;
			break;
		default:
			$timer_fiveM = $insert2;
			break;
	}		

  extract($args);
  echo $before_widget;
  echo $before_title;?>Unread Comments<?php echo $after_title;
  echo "<ul id='AJAX_List'>... loading ...</ul>
        <form onchange = 'refreshList()'><input type='radio' name='rate' value='0' $timer_zero/>Off
	<input type='radio' name='rate' value='30' $timer_thirty/>30s
	<input type='radio' name='rate' value='60' $timer_oneM/>1m
	<input type='radio' name='rate' value='300' $timer_fiveM/>5m</form>";
  echo $after_widget;
}

function myNewComments_init()
{
	//wp_register_sidebar_widget(__('AJAX New Comments'), 'widget_myNewComments');    

	wp_register_sidebar_widget(
    	'AJAX_New_Comments_1',        // your unique widget id
   	 	'AJAX New Comments',          // widget name
   	 	'widget_myNewComments',  // callback function
    	array(                  // options
        	'description' => 'Adds Unread Comments Slider'
    	)
	);

}

add_action("plugins_loaded", "myNewComments_init");

function script_init()
{
	if ( !is_admin() ) { // instruction to only load if it is not the admin area
	   // register your script location, dependencies and version
	   wp_register_script('ajaxer',
	       get_bloginfo('wpurl') . '/wp-content/plugins/AJAX_Comments/ajaxer.js',
	       array('jquery'),
	       '1.0' );
	   // enqueue the script
	   wp_enqueue_script('ajaxer');
	   wp_register_script('jquery-timer',
	       get_bloginfo('wpurl') . '/wp-content/plugins/AJAX_Comments/jquery.timers-1.2.js',
	       array('jquery'),
	       '1.0' );
	   // enqueue the script
	   wp_enqueue_script('jquery-timer');
	}
}

add_action("init", "script_init");

function ajax_timer_option($user)
{
	$sticky_yes = $sticky_no = "";
	$timer_zero = $timer_thirty = $timer_oneM = $timer_fiveM = "";
	$insert = " SELECTED";
	$insert2 = " CHECKED";

	if (get_the_author_meta( 'sticky_radio', $user->ID ) > 0) {$sticky_yes = $insert;}
	else {$sticky_no = $insert;}

	switch ( get_the_author_meta( 'ajax_timer', $user->ID ) )
	{
		case 30: 
			$timer_thirty = $insert2;
			break;
		case 60: 
			$timer_oneM = $insert2;
			break;
		case 300:
			$timer_fiveM = $insert2;
			break;
		default:
			$timer_zero = $insert2;
			break;
	}		
?>
<h3><?php _e("AJAXED Unread Comments Options", "blank"); ?></h3>
 
<table class="form-table">
<tr>
<th><label for="ajax_timer"><?php _e("Refresh Time"); ?></label></th>
<td>
<input type="radio" name="ajax_timer" id="ajax_timer" value="0" class="regular-text" <?=$timer_zero ?>/>Off <br>
<input type="radio" name="ajax_timer" id="ajax_timer" value="30" class="regular-text" <?=$timer_thirty ?>/>30 seconds <br>
<input type="radio" name="ajax_timer" id="ajax_timer" value="60" class="regular-text" <?=$timer_oneM ?>/>1 minute <br>
<input type="radio" name="ajax_timer" id="ajax_timer" value="300" class="regular-text" <?=$timer_fiveM ?>/>5 minutes
</td>
</tr>
</table>
<?
}

function save_ajax_timer_option ( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
update_usermeta( $user_id, 'ajax_timer', $_POST['ajax_timer'] );

}

add_action( 'personal_options_update', 'save_ajax_timer_option' );
add_action( 'edit_user_profile_update', 'save_ajax_timer_option' );
add_action('show_user_profile', 'ajax_timer_option');
add_action( 'edit_user_profile', 'ajax_timer_option' );
?>