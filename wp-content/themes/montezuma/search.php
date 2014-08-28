<?php 
function doHighlight ($text, $stop, $len)
{
	$left = substr ($text, 0, $stop);
	$right = substr ($text, $stop+$len);	
	$inside = substr ($text, $stop, $len);
	
	//echo "Highlight Vars: $text, $stop, $len<br>";
	//echo "Highlight Results: $left / $inside / $right<br>";	

	return $left."<span style='background-color:yellow;'>".$inside."</span>".$right;
}

function excerpt($text, $phrase, $radius = 100, $ending = "...") 
{ 
$HIGHLIGHT_LEN = strlen ("<span style='background-color:yellow;'></span>");
     //No HTML in results
     $text = strip_tags($text);

     //Blank results if search string is not found
     if (strpos(strtolower($text), strtolower($phrase)) === false) {
     	return "";
     }

//Prepare variables for While Loop
$main_offset = 0;
$main_excerpt = "";
$phraseLen = strlen($phrase); 
if ($radius < $phraseLen) { 
	$radius = $phraseLen;
} 
//$phrases = explode (' ',$phrase);
$textLen = strlen($text); 

     
     //Set $pos to the first hit on any of the phrases
     //foreach ($phrases as $p) {
     //        $pos = strpos(strtolower($text), strtolower($p), $main_offset); 
     //        if ($pos !== false) break;
     // }

     $startPos = $main_offset;
     //Don't understand in pass 1 
     if ($pos > $radius) { 
         $startPos = $pos - $radius; 
     } 
     
     //Number for end of excerpt
     $endPos = $pos + $phraseLen + $radius; 
     if ($endPos >= $textLen) { 
         $endPos = $textLen; 
     } 

     $excerpt = substr($text, $startPos, $endPos - $startPos); 
     
     //Add ...
     if ($startPos != 0) { 
         $excerpt = $ending . $excerpt;
	 $startPos -= 3;
     } 

     if ($endPos != $textLen) { 
         $excerpt = $excerpt . $ending; 
     } 

     $main_excerpt .=doHighlight($excerpt,$pos-$startPos,$phraseLen)."<br><br>";
     $main_offset = $endPos+$HIGHLIGHT_LEN;
}
     return $main_excerpt; 
}

function doSearchPage()
{
	global $wp_query;
	global $query_string;
	global $wpdb;


	//HEADER STUFF
	$search = new WP_Query();
	$total_results = $wp_query->found_posts;

	echo "<H1>Search: $total_results Results</H1>";

	//RESULTS DISPLAY (Modified version of The Loop)?>

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>

			<? //print_r ($wp_query); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>
				//Pass post content through function
				$content = get_the_content();
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);

				if (strlen($found_in_post) > 0)
				//Comment code
				$querySTR = "SELECT $wpdb->comments.comment_ID FROM $wpdb->comments WHERE ".
					  "$wpdb->comments.comment_content LIKE '%{$_GET['s']}%' AND $wpdb->comments.comment_post_ID = ".get_the_ID();
				//echo $querySTR;
				
				$query1 = $wpdb->get_results($querySTR); // or die("DB ERROR: ". mysql_error()); 
				
				//print_r($query1);

				if($query1){
					echo "<h4>Comments Containing Search String:</h4>
					foreach($query1 as $commentID)
					{	
						$c = get_comment($commentID->comment_ID);
						  <div>
						</li>
					<?}
					echo "</ol>";
				}
				else {echo "<div class ='post-bodycopy'>No Comments Found In This Post</div>";}
				?>
		<?php endwhile; ?>

	<?php else : ?>

		<h2 class="center">No results found. Try a different search.</h2>

	<?php endif; ?>


<?
}

global $options; 
foreach ($options as $value) { 
	if (get_option( $value['id'] ) === FALSE) { 
		$$value['id'] = $value['std']; 
	} else { 
		$$value['id'] = get_option( $value['id'] ); 
	} 
}
if ( is_page() ) { global $wp_query; $current_page_id = $wp_query->get_queried_object_id(); }