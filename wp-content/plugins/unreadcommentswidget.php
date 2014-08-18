<?php
/*
Plugin Name: Display Unread Comments
Plugin URI: http://lonewolf-online.net/
Description: Sample Hello World Plugin
Author: Tim Trott
Version: 1
Author URI: http://lonewolf-online.net/
*/

function sampleHelloWorld()
{
  echo "<ul>";
  echo show_unread_comments();
  echo "</ul>";
}

function widget_myHelloWorld($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Unread Comments<?php echo $after_title;
  sampleHelloWorld();
  echo $after_widget;
}

function myHelloWorld_init()
{
  register_sidebar_widget(__('Hello World'), 'widget_myHelloWorld');    
}
add_action("plugins_loaded", "myHelloWorld_init");

 
function showDLDs()
{	
query_posts('cat=3&showposts=2');
echo '<ul class="list-cat">';

if (have_posts()) {
while (have_posts()) { the_post();
?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
} // end while loop
}
else {
echo "<li>No DLDs in System</li>";
} // end if
echo "<li><a href='/?cat=3'>View all DLDs</a></li>";
echo '</ul>';
wp_reset_query();

}

function widget_showDLDs($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Most Recent DLD<?php echo $after_title;
  showDLDs();
  echo $after_widget;
}

function showDLDs_init()
{
  register_sidebar_widget(__('Show DLDs'), 'widget_showDLDs');    
}
add_action("plugins_loaded", "showDLDs_init");

function showGTs()
{
query_posts('cat=4&showposts=2');
echo '<ul class="list-cat">';

if (have_posts()) {
while (have_posts()) { the_post();
?><li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
} // end while loop
}
else {
echo "<li>No Game Threads in System</li>";
} // end if
echo "<li><a href='/?cat=4'>View all Game Threads</a></li>";
echo '</ul>';
wp_reset_query();
}

function widget_showGTs($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>Most Recent Game Thread<?php echo $after_title;
  showGTs();
  echo $after_widget;
}

function showGTs_init()
{
  register_sidebar_widget(__('Show GTs'), 'widget_showGTs');    
}
add_action("plugins_loaded", "showGTs_init");
?>
 