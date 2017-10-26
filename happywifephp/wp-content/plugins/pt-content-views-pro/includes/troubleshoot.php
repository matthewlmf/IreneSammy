<?php
/**
 * Fix FB share wrong image
 * @since 3.9.4
 */
add_action( 'wp_head', 'cvp_troubleshoot_fb_share_wrong_img', 100 );
function cvp_troubleshoot_fb_share_wrong_img() {
	$fix_fb_share = PT_CV_Functions::get_option_value( 'fb_share_wrong_image' );
	if ( $fix_fb_share ) {
		global $post;
		$attachment_url = '';
		if ( is_singular() ) {
			$attachment_id	 = is_attachment() ? $post->ID : get_post_thumbnail_id( $post->ID );
			$attachment_url	 = wp_get_attachment_url( $attachment_id );

			if ( empty( $attachment_url ) ) {
				$attachment_url = PT_CV_Hooks_Pro::get_inside_image( $post, 'full', $post->post_content );
			}
		}

		if ( $attachment_url ) {
			printf( '<meta property="og:image" content="%s"/>', esc_url( $attachment_url ) );
		}
	}
}

/**
 * When Relevanssi plugin enabled:
 * Fix: Search by multiple keywords doesn't work
 * Fix: No posts found when replacing layout in Search results page
 */
add_filter( 'relevanssi_prevent_default_request', 'cvp_relevanssi_prevent_default_request', 100, 2 );
function cvp_relevanssi_prevent_default_request( $prevent, $query ) {
	if ( isset( $query->query[ 'cv_multi_keywords' ] ) || ($query->is_search && $query->get( 'by_contentviews' )) ) {
		$prevent = false;
	}

	return $prevent;
}

add_action( PT_CV_PREFIX_ . 'before_query', 'cvp_troubleshoot_action_before_query' );
function cvp_troubleshoot_action_before_query() {
	/* Fix: invalid output because of query was modified by plugin "Woocommerce Exclude Categories PRO"
	 * @since 4.2
	 */
	if ( function_exists( 'wctm_pre_get_posts_query' ) ) {
		remove_action( 'pre_get_posts', 'wctm_pre_get_posts_query' );
	}
}

add_action( PT_CV_PREFIX_ . 'do_replace_layout', 'cvp_troubleshoot_do_replace_layout' );
function cvp_troubleshoot_do_replace_layout() {
	/** Fix: SearchWP can't apply its order when use CVP to replace search results
	 * @since 4.2
	 */
	add_filter( 'searchwp_outside_main_query', '__return_true' );
}
