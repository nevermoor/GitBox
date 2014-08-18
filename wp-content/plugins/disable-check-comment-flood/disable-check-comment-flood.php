<?php
/*
Plugin Name: Disable Check Comment Flood
Plugin URI: http://wordpress.org/extend/plugins/disable-check-comment-flood/
Description: Disables the Check Comment Flood feature so comments can be post-dated.
Version: 1.0
Author: Bangbay Siboliban
Author URI: http://siboliban.org/
*/

remove_filter('check_comment_flood', 'check_comment_flood_db');

?>