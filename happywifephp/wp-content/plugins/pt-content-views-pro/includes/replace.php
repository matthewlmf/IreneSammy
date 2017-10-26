<?php

class CVP_Replace_Layout {

	private static $instance;
	private $origin_query;
	private $which_page;
	private $which_view		 = false;
	private $done			 = false;
	private $container_class = CVP_REPLAYOUT;
	private $extra_class;

	public static function get_instance() {
		if ( !CVP_Replace_Layout::$instance ) {
			CVP_Replace_Layout::$instance = new CVP_Replace_Layout();
		}

		return CVP_Replace_Layout::$instance;
	}

	public function __construct() {
		if ( !is_admin() ) {
			add_action( 'get_header', array( $this, 'hook_header' ) );
			add_action( 'loop_start', array( $this, 'start_buffer' ), 0 );
			add_action( 'loop_end', array( $this, 'do_replace' ), 0 );
			#add_action( 'pre_get_posts', array( $this, 'set_query_params' ) );
		} else {

		}
	}

	function hook_header() {
		global $wp_query;
		$this->origin_query = $wp_query;

		$this->get_page( $wp_query );
		$this->get_view();
	}

	function get_page( $wp_query ) {
		$arr = array(
//			'is_single',
//			'is_preview',
//			'is_page',
//			'is_archive',
			'is_date',
			'is_year',
			'is_month',
			'is_day',
			'is_time',
			'is_author',
			'is_category',
			'is_tag',
			'is_tax',
			'is_search',
//			'is_feed',
//			'is_comment_feed',
//			'is_trackback',
			'is_home',
//			'is_404',
//			'is_embed',
//			'is_paged',
//			'is_admin',
//			'is_attachment',
//			'is_singular',
//			'is_robots',
//			'is_posts_page',
			'is_post_type_archive',
		);
		foreach ( $arr as $which ) {
			if ( !empty( $wp_query->$which ) ) {
				$page = str_replace( 'is_', '', $which );

				switch ( $which ):
					case 'is_date':
					case 'is_year':
					case 'is_month':
					case 'is_day':
					case 'is_time':
						$page	 = 'time';
						break;
					case 'is_category':
						$page	 = "tax-$page";
						break;
					case 'is_tag':
						$page	 = "tax-post_tag";
						break;
					case 'is_tax':
						$detail	 = $wp_query->query_vars[ 'taxonomy' ];
						$page	 = "tax-$detail";
						break;
					case 'is_post_type_archive':
						$detail	 = $wp_query->query_vars[ 'post_type' ];
						$page	 = "post_type-$detail";
						break;
				endswitch;

				$this->which_page = $page;
				break;
			}
		}
	}

	function get_view() {
		if ( !$this->which_page ) {
			return;
		}

		$settings	 = get_option( CVP_REPLAYOUT );
		$page		 = $this->which_page;
		if ( !empty( $settings[ $page ][ 'rep_status' ] ) && !empty( $settings[ $page ][ 'selected_view' ] ) ) {
			$this->which_view = $settings[ $page ][ 'selected_view' ];
		}
	}

	function start_buffer( $query ) {
		if ( $this->is_right_place( $query ) ) {
			ob_start();
		}
	}

	function is_right_place( $query ) {
		if ( PT_CV_Functions_Pro::user_can_manage_view() ) {
			if ( defined( 'PT_CV_VIEW_OVERWRITE' ) && $query->is_main_query() && current_filter() === 'loop_start' ) {
				printf( '<div class="alert" style="background: #FFEB3B;padding: 10px;">%s</div>', __( 'For Administrator only: You already replaced layout by using method', 'content-views-pro' ) . ' <code>PT_CV_Functions_Pro::view_overwrite_tpl</code>' );
			}
		}

		return !is_admin() && $query->is_main_query() && $this->which_view && !$this->done && !defined( 'PT_CV_VIEW_OVERWRITE' );
	}

	function do_replace( $query ) {
		if ( $this->is_right_place( $query ) ) {
			do_action( PT_CV_PREFIX_ . 'do_replace_layout' );
			$this->clean_old_html();
			$this->get_new_html();
			$this->finished();
		}
	}

	function clean_old_html() {
		$old_layout = ob_get_clean();

		# Extract class from theme, to maintain style
		$matches = array();
		preg_match( '/class="([^"]+)"/', $old_layout, $matches );
		if ( !empty( $matches[ 1 ] ) ) {
			$this->extra_class = preg_replace( '/\d/', '0', $matches[ 1 ] );
		}
	}

	function get_new_html() {
		if ( !$this->which_view ) {
			return;
		}

		$view_id								 = $this->which_view;
		$wp_query								 = $this->origin_query;
		$wp_query->query_vars[ 'post_status' ]	 = 'publish';

		$view_settings								 = PT_CV_Functions::view_get_settings( $view_id );
		$view_settings[ PT_CV_PREFIX . 'rebuild' ]	 = $wp_query->query_vars;
		$view_settings[ PT_CV_PREFIX . 'limit' ]	 = '-1';

		$view_html	 = PT_CV_Functions::view_process_settings( $view_id, $view_settings );
		$view_output = PT_CV_Functions::view_final_output( $view_html );

		$html	 = sprintf( '<div class="%s">%s</div>', $this->container_class . ' ' . $this->extra_class, $view_output );
		$style	 = '<style>.woocommerce-pagination, .pagination:not(.pt-cv-pagination) {display:none!important}</style>';

		echo $style . $html;
	}

	function finished() {
		$this->done			 = true;
		$this->which_view	 = null;
	}

}

CVP_Replace_Layout::get_instance();
