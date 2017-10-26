<?php
/**
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package White
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="top-bar">
	<div class="container">
		<header id="masthead" class="site-header col-md-6" role="banner">
			<div class="site-branding">
				<?php if( get_theme_mod('white_logo', '') ) : ?>
					<div id="site-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url(get_theme_mod('white_logo', '')) ?>"></a>
					</div>
				<?php else : ?>	
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>	
			</div>
		</header><!-- #masthead -->
		
		<div id="right-head" class="col-md-6">
			<?php get_template_part('searchform', 'top') ?>
			
			<div id="social-icons" class="col-md-12 col-sm-12">
				<?php get_template_part('social', 'fa'); ?>
			</div>
		</div>
		
	</div><!--.container-->
</div><!--#top-bar-->

<div id="page" class="hfeed site container">

	<div id="top-nav">
		<nav id="site-navigation" class="main-navigation col-md-12" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'white' ); ?></h1>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'white' ); ?></a>
			
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->	
	</div>
	
	<?php
	 	get_template_part('slider');
	?>

	<div id="content" class="site-content">