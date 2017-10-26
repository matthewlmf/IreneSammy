<?php
if ( is_array( $value ) ) {
	$image = $value;

	// vars
	$url	 = $image[ 'url' ];
	$title	 = $image[ 'title' ];
	$alt	 = $image[ 'alt' ];
	$caption = $image[ 'caption' ];

	// Get a size
	$size	 = '';
	$sizes	 = array( 'large', 'medium', 'thumbnail' );
	foreach ( $sizes as $s ) {
		if ( !empty( $image[ 'sizes' ][ $s ] ) ) {
			$size = $s;
			break;
		}
	}
	$size = apply_filters( PT_CV_PREFIX_ . 'acf_image_size', $size );

	$thumb	 = $image[ 'sizes' ][ $size ];
	$width	 = $image[ 'sizes' ][ $size . '-width' ];
	$height	 = $image[ 'sizes' ][ $size . '-height' ];

	$img_data = sprintf( "alt='%s' width='%s' height='%s'", esc_attr( $alt ), esc_attr( $width ), esc_attr( $height ) );
} else {
	$attachment	 = wp_get_attachment_url( $value );
	$thumb		 = $attachment ? $attachment : $value;
}


if ( isset( $caption ) ) {
	echo '<div class="wp-caption">';
}
?>

<img src="<?php echo esc_url( $thumb ); ?>" <?php echo isset( $img_data ) ? $img_data : ''; ?> />

<?php
if ( isset( $caption ) ) {
	printf( '<p class="wp-caption-text">%s</p></div>', $caption );
}
