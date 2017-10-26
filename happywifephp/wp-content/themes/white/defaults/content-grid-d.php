<?php
/**
 * @package White
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 col-sm-4 grid'); ?>>

		<div class="featured-thumb col-md-12">
			
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/defaults/images/dimg".mt_rand(1,7).".jpg"; ?>"></a>
			
			
			<div class="in-thumb col-md-12">
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo (strlen(get_the_title()) > 60 ? substr(get_the_title(),0,60)."..." : get_the_title() ); ?></a></h1>
				</header><!-- .entry-header -->
			</div><!--.in-thumb-->
			
		</div><!--.featured-thumb-->
		
</article><!-- #post-## -->