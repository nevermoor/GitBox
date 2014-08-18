<?php
/*Template Name: Rotating Tagline*/

global $current_user;

get_template_part( 'head' ); ?>
</head>
<body <?php body_class(); ?>>
<?php get_header(); ?>
<div id="main" class="row">

	<div id="content" class="col10">

		<nav class="singlenav cf">
			<div class="older"><?php previous_post_link(); ?></div>
			<div class="newer"><?php next_post_link(); ?></div>
		</nav>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?>>

			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php bfa_comments_number(); ?>
			</h1>

			<div class="post-footer">
				<?php the_time( 'j M Y' ); ?> &nbsp;&nbsp;| <?php the_category( ' &middot; ' ); ?>
				<?php the_tags( __( '<p class="post-tags">Tags: ', 'montezuma' ), ' &middot; ', '</p>' ); ?>
			</div>

			<div class="post-bodycopy cf">
			<?php $taglines = get_option('tagline_rotator_taglines');
			/* Post Container starts here */		
			foreach($taglines as $key => $tagline){							$sanitized_tagline = preg_replace('/"/','&quot;',$tagline);
				?>				
				<li><?php echo stripslashes ($sanitized_tagline);?></li>
			<?php }	?>		
			</ol><? $userID = $current_user->ID;
			if (user_can($userID,'manage_tagline')); 	
				echo "<a href='".site_url('/wp-admin/options-general.php?page=taglineoptions')."'>Click here</a> to manage taglines";?>
			</div>

			<?php edit_post_link( __( "Edit", 'montezuma' ) ); ?>
			


		</div>

		<?php comments_template( '', true ); ?>

		<nav class="singlenav cf">
			<div class="older"><?php previous_post_link(); ?></div>
			<div class="newer"><?php next_post_link(); ?></div>
		</nav>
		
	</div>
	
	<div id="widgetarea-one" class="col2">
		<?php dynamic_sidebar( 'Widget Area ONE' ); ?>
	</div>
	
</div>
<?php get_footer(); ?>