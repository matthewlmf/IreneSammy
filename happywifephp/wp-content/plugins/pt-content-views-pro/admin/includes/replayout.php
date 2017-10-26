
<?php

class CVP_Replace_Setting {

	private static $instance;
	protected $archives_list;
	protected $views_list;
	protected $field_archive;
	protected $saved_data;

	public static function get_instance() {
		if ( !CVP_Replace_Setting::$instance ) {
			CVP_Replace_Setting::$instance = new CVP_Replace_Setting();
		}

		return CVP_Replace_Setting::$instance;
	}

	public function __construct() {
		$this->field_archive = CVP_REPLAYOUT;

		$this->get_archives();
		$this->get_views_list();
		$this->show_form();
	}

	function get_archives() {
		$taxes	 = array();
		$arr	 = get_taxonomies( array( 'public' => true ), 'objects' );
		foreach ( $arr as $taxonomy ) {
			if ( $taxonomy->name === 'post_format' ) {
				continue;
			}

			$taxes[ $taxonomy->name ] = $taxonomy->labels->singular_name;
		}

		$post_types	 = array();
		$arr		 = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
		foreach ( $arr as $post_type ) {
			$post_types[ $post_type->name ] = $post_type->labels->singular_name;
		}

		$this->archives_list = array(
			0			 => array( __( 'Standard Archives', 'content-views-pro' ), array(
					'home'	 => __( 'Blog' ),
					'search' => __( 'Search results', 'content-views-pro' ),
					'author' => __( 'Author' ),
					'time'	 => __( 'Date, Month, Year', 'content-views-pro' ),
				) ),
			'tax'		 => array( __( 'Taxonomy Archives', 'content-views-pro' ), $taxes ),
			'post_type'	 => array( __( 'Post Type Archives', 'content-views-pro' ), $post_types ),
		);
	}

	function get_views_list() {
		$result = array( '' => __( 'Select View', 'content-views-pro' ) );

		$query1 = new WP_Query( array(
			'post_type'		 => PT_CV_POST_TYPE,
			'posts_per_page' => -1
			) );

		if ( $query1->have_posts() ) {
			while ( $query1->have_posts() ) {
				$query1->the_post();

				$view_id = get_post_meta( get_the_ID(), PT_CV_META_ID, true );
				if ( $view_id ) {
					$result[ $view_id ] = get_the_title();
				}
			}
		}

		wp_reset_postdata();

		$this->views_list = $result;
	}

	function show_form() {
		$this->save_form();
		?>
		<style>
			.wrap h4{margin-top:0;margin-bottom:5px}
			input[type=checkbox]{opacity:.5}
			input[type=checkbox]:checked{opacity:1}
			.cvp-showmore{color:#ff5a5f;font-weight:600}
			.cvp-showmore + p{display:none}
			.cvp-notice, .cvp-notice *{font-size:16px}
		</style>
		<script>
			( function ( $ ) {
				$( document ).ready( function () {
					$( 'select', '.cvp-admin' ).select2();

					$( '.cvp-showmore' ).click( function ( e ) {
						e.preventDefault();
						$( this ).next().toggle();
					} );
				} );
			} )( jQuery );
		</script>
		<div class="wrap">
			<h2><?php _e( 'Replace Theme Layout with Content Views Pro', 'content-views-pro' ) ?></h2>
			<br>
			<?php $this->show_notice(); ?>
			<br>
			<div class="pt-wrap cvp-admin">
				<form action="" method="POST">
					<input type="submit" class="btn btn-primary pull-right" value="<?php _e( 'Save' ); ?>" style="margin-top: -40px;">
					<div class="clearfix"></div>
					<?php
					wp_nonce_field( PT_CV_PREFIX_ . 'view_submit', PT_CV_PREFIX_ . 'form_nonce' );

					foreach ( $this->archives_list as $idx => $archive_type ) {
						$heading = $archive_type[ 0 ];
						$pages	 = $archive_type[ 1 ];

						printf( '%s<h4># %s</h4>', $idx === 0 ? '' : '<br><hr class="clear">', $heading );
						foreach ( $pages as $page => $title ) {
							$name		 = ( $idx ? $idx . '-' : '') . $page;
							$field_name	 = esc_attr( $this->field_archive . "[$name]" );
							$page_data	 = !empty( $this->saved_data[ $name ] ) ? $this->saved_data[ $name ] : null;

							echo '<div class="clear">';

							# Page name
							printf( '<div class="col-md-4">
									<div class="checkbox">
										<label for="%1$s">
											<input type="checkbox" id="%1$s" name="%1$s" value="%2$s" %3$s>%4$s
										</label>
									</div>
								</div>', $field_name . '[rep_status]', 'enable', !empty( $page_data[ 'rep_status' ] ) ? 'checked' : '', $title );

							# View
							$options		 = array();
							$selected_view	 = !empty( $page_data[ 'selected_view' ] ) ? $page_data[ 'selected_view' ] : '';
							foreach ( $this->views_list as $view_id => $title ) {
								$options[] = sprintf( '<option value="%s" %s>%s</option>', esc_attr( $view_id ), selected( $selected_view, $view_id, false ), esc_html( $title ) );
							}
							printf( '<div class="col-md-6">
									<select name="%s" class="form-control">%s</select>
								</div>', $field_name . '[selected_view]', implode( '', $options ) );

							# Preview
//							printf( '<div class="col-md-2">
//									<a href="%s" class="btn btn-success">%s</a>
//								</div>', 1, __( 'Preview' ) );

							echo '</div>';
						}
					}
					?>

					<div class="clearfix"></div>
					<hr>
					<input type="submit" class="btn btn-primary pull-right" value="<?php _e( 'Save' ); ?>">
				</form>
			</div>
		</div>
		<?php
	}

	function show_notice() {
		$msg	 = $more	 = array();
		$msg[]	 = __( 'When you select each checkbox below, Content Views Pro will replace posts layout of selected page by layout of selected View.', 'content-views-pro' );
		$msg[]	 = sprintf( '<a href="#" class="cvp-showmore">%s &#187;</a>', __( 'Tell me more', 'content-views-pro' ) );
		$more[]	 = __( 'So you can:', 'content-views-pro' );
		$more[]	 = __( '- change posts layout completely: use any layout (grid/pinterest...); show any field (title, thumbnail...); enable overlay; change font, color...', 'content-views-pro' );
		$more[]	 = __( '- change pagination settings: show more posts per page; enable infinite/load-more pagination', 'content-views-pro' );
		$more[]	 = __( 'by modifying settings of selected View.', 'content-views-pro' );
		$more[]	 = __( 'Please remember:', 'content-views-pro' );
		$more[]	 = sprintf( __( '- You should %s create a new View %s for replacing layout only.', 'content-views-pro' ), '<strong>', '</strong>' );
		$more[]	 = sprintf( __( '- You should %s enable pagination %s for the selected View.', 'content-views-pro' ), '<strong>', '</strong>' );
		$more[]	 = sprintf( __( '- Settings in "%s" of selected View %s will not be applied %s.', 'content-views-pro' ), __( 'Filter Settings', 'content-views-query-and-display-post-page' ) . ', ' . __( 'Shuffle Filter', 'content-views-pro' ) . ', ' . __( 'Advertisement', 'content-views-pro' ), '<strong>', '</strong>' );
		$msg[]	 = sprintf( '<p>%s</p>', implode( '<br>', $more ) );

		printf( '<div class="cvp-notice">%s</div>', implode( ' ', $msg ) );
	}

	function save_form() {
		if ( !empty( $_POST[ $this->field_archive ] ) ) {
			$this->saved_data = $_POST[ $this->field_archive ];

			update_option( $this->field_archive, $this->saved_data, false );
		} else {
			$this->saved_data = get_option( $this->field_archive );
		}
	}

}

CVP_Replace_Setting::get_instance();
