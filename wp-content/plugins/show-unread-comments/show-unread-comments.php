<?php

/*

Plugin Name: Show Unread Comments

Version: 1.1

Plugin URI: http://www.ryanjparker.net/wordpress-plugins/show-unread-comments/

Description: Shows a status indicator next to comments that let the user know if they've read this comment before.  Also can be used to display a list of posts with unread comments.  Based on Brett Taylor's Smart Unread Comments.

Author: Ryan J. Parker / nevermoor

Author URI: http://www.ryanjparker.net/

*/



$TEST_MODE = false; 
$LOG_MODE = false; 
gc_enable ();

if ($LOG_MODE)
	include 'ChromePhp.php';

//$wpdb->show_errors();



// template_redirect hooks specify that the code be executed before determining which template file is going to be used;

// These hooks make sure the user gets the cookies before template files

add_action('template_redirect', 'rjp_suc_mark_comments_read', 9);



// Incorporates CSS into the Wordpress header

add_action("wp_head", "rjp_suc_header", 1);

add_action("wp_head", "set_unread_comments_globals");



// Calls function to add visit time to database

add_action("shutdown", "setPageVisitDate");



$unread_posts_global;

//Logging function
function VUC_log ($str)
{
	global $LOG_MODE;
	
	/*
	ChromePhp::log('Hello console!');
	ChromePhp::log($_SERVER);
	ChromePhp::warn('something went wrong!');
	*/
	
	if ($LOG_MODE)
		ChromePhp::log ("[UNREAD COMMENTS] $str");
}

//This function is run once to prevent having to run all the queries on every comment

function set_unread_comments_globals()

{

	global $unread_posts_global;

	global $wpdb;

	global $current_user;

	VUC_log ("set_unread_comments_globals called");
	
	//must test for logged in.  Non logged in users don't get unread comments

	if (!is_user_logged_in()) {return;}



	//echo ("called<br>");



	

	$last_check = simpleSessionGet('suc_last_test', -1);

	$now = time();

	$uID = $current_user->ID;

	simpleSessionSet('suc_last_test', $now);



	if ($last_check != -1)

	{
		VUC_log ("Cookie found");

		$sql = "SELECT MAX(comment_date_gmt) as m from {$wpdb->prefix}comments WHERE user_id != $uID"; 

		//echo "1: $sql<br>";

		$results = $wpdb->get_results($sql);

		$new_comment_time = strtotime ($results[0]->m);



		//echo "Last check: $last_check<br>Now: $now<br>SQL: $sql<br>New time:$new_comment_time<br>";

		//echo "Date test: " . date("Y-m-d H:i:s", $last_check);



		if ($new_comment_time > $last_check)

		{
			VUC_log ("Cookie being refreshed");

			$unread_posts_global = rjp_suc_get_recent_posts();

			simpleSessionSet('suc_unread_posts', $unread_posts_global);

		}

		else 
			VUC_log ("Cookie is sufficient");

			$unread_posts_global = simpleSessionGet('suc_unread_posts', NULL);

	}

	else

	{
		VUC_log ("Cookie not found");

		$unread_posts_global = rjp_suc_get_recent_posts();

		simpleSessionSet('suc_unread_posts', $unread_posts_global);

	}

	



	$unread_posts_global = rjp_suc_get_recent_posts();

}



//This includes the CSS from the admin page

function rjp_suc_header() {

	echo '<link rel="stylesheet" href="'.get_option('siteurl').'/wp-content/plugins/show-unread-comments/style.css" type="text/css" media="screen" />'."\n";

}



//This should calculate a time comparable to the comment time (but not necessarily the user's time)

function getLocalTime($offset_hours = 0)

{

	return gmdate('Y-m-d H:i:s', time() + get_option('gmt_offset') * 3600 - $offset_hours * 3600);

}



function set_users_mark_read ($user, $time)

{

	global $wpdb;

	//$wpdb->show_errors();



	//echo "Called<br>";

	//Post "-1" is a special row setting a visit floor for each user

	$sql = "insert into fk_unreadcomments (userid, postid, lastvisit)

    		values ($user, -1, '$time')

    		on duplicate key update lastvisit = '$time'";

	

	//echo "1: $sql<br>";

	$wpdb->query($sql);

	

	$look_back = getLocalTime ( 24 * 7 ); //Delete individual page visits more than a week old.

	

	//We don't need to remember any older visits

	

	$sql = "DELETE FROM fk_unreadcomments WHERE userid = $user AND lastvisit < '$look_back' AND is_done = 0";



	//echo "2: $sql<br>";

	$wpdb->query($sql);

	//die('finished');

}



// Marks all comments as read (inserts a time entry for post -1)

function rjp_suc_mark_comments_read() {

	if (isset($_GET['posts_timeout'])) {

		global $current_user;

		global $wpdb;

      		get_currentuserinfo();

		

		if (! is_user_logged_in()) {return;} //only display to logged in users		



		$userID = $current_user->ID;

		$time = getLocalTime();



		set_users_mark_read ($userID, $time);

		simpleSessionSet('suc_unread_posts', NULL);  //Destroy session array if it exists.

		

		//die();	



		// go back to the referer

		if($_SERVER['HTTP_REFERER']) {

			header("Location: ".$_SERVER['HTTP_REFERER']);

			exit();

		}

	}

}



//Post ID = -1 is set by "Mark All Comments Read" link, this gets it for comparison in other functions

function getOverrideDate ($userID)

{

	global $wpdb;

      		

	$sql = "SELECT lastvisit FROM fk_unreadcomments WHERE postid = -1 AND (userid = $userID OR userid = -1)

		ORDER BY lastvisit DESC";

	$rs = $wpdb->get_results($sql);



	if ($rs === false) {

		die( $wpdb->ErrorMsg());

	}

	//echo $rs[0]->lastvisit; 

	return $rs[0]->lastvisit; 

}



// Gets the recent posts with comments that have yet to be read (no longer over-inclusive);

// Returns a 2D array

function rjp_suc_get_recent_posts() {

	global $wpdb;

	global $current_user;

	

      	get_currentuserinfo();

	$recent_posts_new = array();

	VUC_log ("rjp_suc_get_recent_posts() called");

	//Give new users an ~1 day lookback (and solve time zone issue)

	$regDate = date("Y-m-d H:i:s", strtotime ($current_user->user_registered) - 86400); 

	//var_dump ($regDate);

	$overrideDate = getOverrideDate ($current_user->ID);

	$stopDate = max ($regDate, $overrideDate);

	$uID = $current_user->ID;

	//echo $regDate." and ".$overrideDate."<br>";
			

	$sql = "SELECT ID, post_date, lastvisit, is_done, comment_count, post_title, count(ID) as newcomments from {$wpdb->prefix}posts 

		LEFT OUTER JOIN (select * from fk_unreadcomments WHERE userid = {$current_user->ID}) as filterTable ON ID = postid 

		LEFT OUTER JOIN (select comment_date, comment_post_ID from {$wpdb->prefix}comments WHERE {$wpdb->prefix}comments.comment_date > '$stopDate' 

		AND user_id <> {$current_user->ID}) as filterTableTwo 

		ON filterTableTwo.comment_post_ID = {$wpdb->prefix}posts.ID AND filterTableTwo.comment_date > COALESCE(lastvisit,'$stopDate')

		WHERE post_type = 'post' and post_status = 'publish' and (is_done IS NULL OR is_done = 0) 

		AND filterTableTwo.comment_date > COALESCE(lastvisit,'$stopDate')  GROUP BY ID



		UNION



		SELECT DISTINCT ID, post_date, lastvisit, is_done, comment_count, post_title, 0 as newcomments from {$wpdb->prefix}posts 

		LEFT OUTER JOIN (select * from fk_unreadcomments WHERE userid = {$current_user->ID}) as filterTable ON ID = postid

		WHERE lastvisit IS NULL and post_date > '$stopDate' 

		AND post_type = 'post' and post_status = 'publish'and comment_count=0";



		

			//$wpdb->show_errors();

			//$wpdb->query ("SET SQL_BIG_SELECTS=1;" );

			$recent_posts = $wpdb->get_results($sql);

			//$wpdb->query ("SET SQL_BIG_SELECTS=0;" );

			//$wpdb->hide_errors();

			//echo $sql."<br>";

			//print_r ($recent_posts);

			//echo max ($regDate, $overrideDate);

		

	foreach ($recent_posts as $row) {

		$loopDate = max ($regDate, $overrideDate, $row->lastvisit);

		
		if (!$row->comment_count) //In other words, if it is a post with no comments

			$recent_posts_new[$row->ID] = array("date" => -1, "title" => $row->post_title, 

				"count" => $row->newcomments);

		else

			$recent_posts_new[$row->ID] = array("date" => $loopDate, "title" => $row->post_title, 

				"count" => $row->newcomments);

	}



	$debug = Print_r ($recent_posts_new, true);

	//die();

	VUC_log ("Recent postss: $debug");
	

	return $recent_posts_new;

}



//This is the function that adds or changes the visit date for an individual page.  It is called by wp_footer.

function setPageVisitDate()

{

	global $wpdb;

	global $current_user;

	global $is_mobile_device;

	global $wp_query;

	global $TEST_MODE;

	global $unread_posts_global;


	$comment_array = simpleSessionGet('suc_unread_posts', NULL);

	unset($unread_posts_global); //Is this going to fix the memory leak?
	unset($GLOBALS['unread_posts_global']);
	
	if ($TEST_MODE) 

		return;



	//visiting pages from a mobile device does not mark them read

	if ($is_mobile_device)

		return;


	get_currentuserinfo();

	$postID = $wp_query->queried_object_id;

	$userID = $current_user->ID;



	//echo "Post ID: $postID and User ID: $userID.";

	//die();



	//If not logged in, no page visit

	if (!is_user_logged_in()) {return;}



	if (is_single()) //Only "visit" single pages

	{

		$time = getLocalTime();



		$sql = "insert into fk_unreadcomments (userid, postid, lastvisit)

    			values ($userID, $postID, '$time')

    			on duplicate key update lastvisit = '$time'";



		unset ($comment_array[$postID]);

		simpleSessionSet('suc_unread_posts', $comment_array);



		

		If ($wpdb->query($sql) === false)

		{

			echo $sql."<br>";

			die();

		}	

	}

}



// Show the unread comments in a list on the sidebar

//  - $limit: Specifies the number of posts with unread comments to show

//  - $sort: Specifies how to sort the list; default is 'comment' to sort by comment date; alternative is 'post' to sort by post date

//  - $output_when_none: If true, when no unread comments exist $no_unread_text is shown

//  - $mark_as_read_text: Text of the link to mark all comments as read

//  - $no_unread_text: Text shown when there are no unread comments (if $output_when_none is true)

function show_unread_comments($limit = 100, $sort = 'comment', $output_when_none = true, $mark_as_read_text = "Mark all comments as read", $no_unread_text = "There are no unread comments, only unwritten ones") {

	global $wpdb;

	global $wp_query;

	global $current_user;

      	global $unread_posts_global;



	get_currentuserinfo();



	//if not logged in, display login link

	if (!is_user_logged_in())

	{

		return "<li><a href='../wp-login.php?redirect_to=".get_bloginfo('home')."'>Log in</a> to view unread comments</li>";



	}



	// get the recent posts

	$recent_posts = $unread_posts_global;



	$output = "";

	$posts = array();

	$postID = 0;

	$counter = 0;



	//echo "Pre-loop<br>";

	//print_r ($recent_posts);

	//die();



	//Loop through the posts with potentially unread comments.  Reversed so it looks at newest posts first.

	foreach (array_reverse  ($recent_posts, true) as $key=>$row)

	{

	 // echo "Top-loop<br>";



		if ($counter <= $limit) //allows admin to limit the number of posts displayed in the widget

		{

			$is_even = " class = 'even_row'";

	  		if ($counter % 2 == 0)

				$is_even = '';





			//Collect unvisited posts without comments

	  		if ($row['date'] == -1){



				$output .= "\n\t<li $is_even><a href='".get_permalink($key)."'>".$row['title'];

				$output .= "</a>&nbsp;(New)</li>";



				$counter++;	  		

	  		}

	  		else {

		  		$output .= "\n\t<li $is_even><a href='".get_permalink($key)."'>".$row['title'];

				$output .= "</a>&nbsp;(".$row['count'].")</li>";



				$counter++;	  		


			}

		}

	}



	if ($counter > 0) {

		$output .= "\n\t<li class='mark_all'><a href='#' onclick='confirm_all_read()'>".$mark_as_read_text."</a></li>";

	} elseif ($output_when_none) {

		$output = "<li>".$no_unread_text."</li>";

		set_users_mark_read ($current_user->ID, getLocalTime());

	}



	return stripslashes($output);

}



// Shows a status indicator for unread comments

// Valid types are: image, text, bin

function show_unread_comment_status($type = 'image', $img_read = 'suc_read.jpg', $img_unread = 'suc_unread.jpg') {

	global $wp_query;

	global $current_user;

	global $comment;

	global $unread_posts_global;



      	get_currentuserinfo();



	//print_r ($unread_posts_global);

	//die();


	// if this is not a single post or a page then we don't want to be here anyway

	if (!is_single() && !is_page()) { return; }



	// if not logged in, comment is unread

	if (!is_user_logged_in()) { return; }

// get the ID of this post

	$currentpostid = $postid = $wp_query->post->ID;

	// get recent posts (from global variable)

	$recent_posts = $unread_posts_global;

	VUC_log ("Checking recent posts");

	if ($type == "image") {

		$read = "<img class='suc_read' src='".get_option('siteurl')."/wp-content/plugins/show-unread-comments/".$img_read."' title='Read Comment'>";

		$unread = "<img class='suc_unread' src='".get_option('siteurl')."/wp-content/plugins/show-unread-comments/".$img_unread."' title='Unread Comment'>";

	} else if ($type == "bin") {

		$read = true;

		$unread = false;

	} else {

		$read = "READ";

		$unread = "UNREAD";

	}



	// if there are no recent posts in the cookie and/or there is not a timestamp for this post then this comment is read

	if (!$recent_posts || !$recent_posts[$currentpostid]) {

		//print_r ($recent_posts);

		//die();
		
		VUC_log ("Post does not exist");

		if ($type == "bin") { return($read); }

		echo $read;

		return;

	}

	VUC_log ("Post does exist");


	// grab the comment time in a format we can compare with what's in the cookie

	$comment_time = get_comment_time('Y-m-d H:i:s', false);



	//DEBUG

	//echo $recent_posts[$currentpostid]." ($currentpostid, $comment_time)";
	
	VUC_log ("Comment time is $comment_time and last visit is {$recent_posts[$currentpostid]['date']}");


	//Unread comments are those posted after the lastvisit time and NOT by the current user

	if ($comment_time > $recent_posts[$currentpostid]['date'] && $current_user->ID != $comment->user_id) {

		// the comment time is greater than what is in the cookie so this is unread

		if ($type == "bin") { return($unread); }

		echo $unread;

	} else {

		// the comment time is less than (or equal to) what is in the cookie so this is read

		if ($type == "bin") { return($read); }

		echo $read;

	}

}



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~Admin Bar Functions~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



add_action('admin_bar_menu', 'unread_comments_ignore_admin_bar', 500);

add_action('wp_head', 'unread_comments_inject_ignore_javascript');

add_action('template_redirect', 'unread_comments_do_ignore', 9);



//Adds the appropriate button to the admin bar

function unread_comments_ignore_admin_bar()

{

	global $wp_admin_bar;

	global $wpdb;

	global $current_user;

	global $wp_query;



	if (!is_single() && !is_page())

		return; //only add inside pages where we track visits

	

	if (!is_user_logged_in()) {return;} //only display to logged in users

	$userID = $current_user->ID;

	$postID = $wp_query->queried_object_id;



	$to_ignore = array(

		'title' => 'Ignore this Post',

		'href' => '#',

		'id' => 'ignore_post', // defaults to a sanitized title value.

		'meta' => array( 'onclick' => "confirm_ignore_toggle(1,$postID)")

	);

	$to_unignore = array(

		'title' => 'Track this Post',

		'href' => '#',

		'id' => 'unignore_post', // defaults to a sanitized title value.

		'meta' => array( 'onclick' => "confirm_ignore_toggle(0,$postID)")

	);

	$is_ignored = $wpdb->get_var("SELECT is_done FROM fk_unreadcomments WHERE userid = $userID AND postid = $postID");



	if ($is_ignored)

		$wp_admin_bar->add_menu($to_unignore);

	else

		$wp_admin_bar->add_menu($to_ignore);





}



//Adds the confirm prompts to the page header

function unread_comments_inject_ignore_javascript()

{

	$url = site_url();

	echo "<script type='text/javascript'>

		function confirm_ignore_toggle (ignore, post)

		{

			if (ignore)

			{

				if (confirm('Sure, it hurts to be rejected – but it hurts far more to be ignored.\\n\\nAre you sure you want to ignore this page?\\n\\nNote: you will lose any unread comments on the page, so read \'em first!'))

					window.location = '$url?do_ignore='+post;

			}

			else

			{

				if (confirm('Caught your eye did it?\\n\\nAre you sure you want to stop ignoring this page?\\n\\nNote: you will lose any unread comments on the page, so read \'em first!'))

					window.location = '$url?do_unignore='+post;

			}

		}

		function confirm_all_read()

		{

			if (confirm('Are you sure you want to mark all those posts read?\\n\\nY U NO TRY?'))

					window.location = '$url?posts_timeout=1';

		}

		</script>";

}



//Flips the appropriate bit in the database

function unread_comments_do_ignore()

{

	if (!isset($_GET['do_ignore']) && !isset($_GET['do_unignore']))

		return;



	global $wpdb;

	global $current_user;



	if (!is_user_logged_in()) {return;} //only display to logged in users

	$userID = $current_user->ID;

	$ignoring = (int) isset($_GET['do_ignore']);

	//var_dump($ignoring);

	$postID = absint (($ignoring) ? $_GET['do_ignore'] : $_GET['do_unignore']); //no injections possible



	if (!$postID) //Only happens if non-posint is passed

		die ('Invalid Post ID.  Try again.');



	$sql = "UPDATE fk_unreadcomments SET is_done = $ignoring WHERE userid = $userID and postid = $postID";

	//die ($sql);

	if ($wpdb->query($sql) === false)

	{

		echo $sql."<br>";

	}		

		

	// go back to the referer

	if($_SERVER['HTTP_REFERER']) {

		header("Location: ".$_SERVER['HTTP_REFERER']);

		exit();

	}



}

add_action('admin_bar_menu', 'VUC_Admin_Bar_Keypress', 400);

function VUC_Admin_Bar_Keypress()
{
	global $wp_admin_bar;
	
	if (!is_user_logged_in() || !is_single()) {return;} //only display to logged in users on single pages

	$z_key = array(

		'title' => 'Mark and Next (z)',

		'href' => '#',

		'id' => 'VUC_shortcut_Z', // defaults to a sanitized title value.

		'meta' => array( 'onclick' => "shortcut_Z()")

	);

	$wp_admin_bar->add_menu($z_key);
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~Montezuma Functions~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function comment_parent_link ()
{
	global $comment;
    
	if ($comment->comment_parent) {
        $parent_comment = get_comment($comment->comment_parent);
        echo " || <a href='".get_permalink( $parent_comment->comment_post_ID ). '#unread-' . $parent_comment->comment_ID . "'>Up</a>";
    }
}

function VUC_comment_top ()
{
	global $comment;
	
	//This is the code that applies proper css to unread comments
	$openDiv ="<div id='unread-{$comment->comment_ID}'>";
	if (!show_unread_comment_status('bin'))
		{ //If the comment is unread, add a nested DIV
			$openDiv ="<div class='unreadComment' id='unread-{$comment->comment_ID}'>" ;
			echo "<script>if (new_unread_comment({$comment->comment_ID})) {UnreadCommentsArray[UnreadCommentsCounter] = {$comment->comment_ID};  UnreadCommentsCounter += 1;}</script>";
	} 
	echo $openDiv;
}

function VUC_comment_bottom ()
{
	echo "<div class='CommentFooter'>".ft_signature_manager_add_comment_signature( )."</div>";
	echo "</div>";  //Needed to keep signatures within the comment box.  Need to kill a div in the Montezuma virtual template.
	echo "</div>";  //Used to be closeDiv, but now always opening an unread div for AJAX reasons. 
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~Signature Functions~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function ft_signature_manager_add_comment_signature()
{
	global $comment;

		//return "FUNCTION CALLED for ".$comment->comment_author;
		return get_user_meta( $comment->user_id , 'ft_signature_01', true );
}

?>