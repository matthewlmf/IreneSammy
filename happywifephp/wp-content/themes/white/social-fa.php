<?php for ($i = 1; $i < 7; $i++) : 
	$social = get_theme_mod('white_social_'.$i);
	if ( ($social != 'none') && ($social != '') ) : ?>
	<a title="<?php echo ucfirst($social)?>" href="<?php echo esc_url(get_theme_mod('white_social_url'.$i)); ?>"><i class="fa fa-<?php echo $social; ?>"></i></a>
	<?php endif;

endfor; ?>