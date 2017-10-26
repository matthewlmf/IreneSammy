<?php
/**
 * Define settings for options
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !class_exists( 'PT_CV_Settings_Pro' ) ) {

	/**
	 * @name PT_CV_Settings_Pro
	 * @todo Define settings for options
	 */
	class PT_CV_Settings_Pro {

		/**
		 * Advanced Order by options
		 *
		 * @return array
		 */
		static function orderby() {
			$result = array();

			$advanced_post_types = PT_CV_Values::post_types();

			foreach ( array_keys( $advanced_post_types ) as $post_type ) {
				// Get list of available order by attributes
				$post_type_filters = array();
				if ( $post_type == 'product' ) {
					$post_type_filters = array( '_price' => __( 'Price', 'woocommerce' ) );
				}

				$options = $post_type_filters ? $post_type_filters : array();
				array_unshift( $options, sprintf( '- %s -', __( 'Select' ) ) );

				$result[ $post_type ] = array(
					array(
						'label'			 => array(
							'text' => '',
						),
						'extra_setting'	 => array(
							'params' => array(
								'width' => 12,
							),
						),
						'params'		 => array(
							array(
								'type'		 => 'select',
								'name'		 => $post_type . '-orderby',
								'options'	 => $options,
								'std'		 => '',
							),
						),
					),
				);
			}

			return $result;
		}

		/**
		 * Settings of View type = One and others
		 *
		 * @return array
		 */
		static function view_type_settings_one_and_others() {

			$prefix = 'one_others-';

			$result = array(
				// View format
				array(
					'label'	 => array(
						'text' => __( 'View format', 'content-views-pro' ),
					),
					'params' => array(
						array(
							'type'		 => 'radio',
							'name'		 => $prefix . 'number-columns',
							'options'	 => PT_CV_Values_Pro::view_format_one_and_others(),
							'std'		 => '2',
						),
					),
				),
				// Width proportion
				array(
					'label'		 => array(
						'text' => __( 'Width proportion <br> (one : others)', 'content-views-pro' ),
					),
					'params'	 => array(
						array(
							'type'		 => 'radio',
							'name'		 => $prefix . 'width-prop',
							'options'	 => PT_CV_Values_Pro::width_prop_one_and_others(),
							'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::width_prop_one_and_others() ),
						),
					),
					'dependence' => array( $prefix . 'number-columns', '2' ),
				),
				array(
					'label'	 => array(
						'text' => __( 'Other posts', 'content-views-pro' ),
					),
					'params' => array(
						array(
							'type'	 => 'group',
							'params' => array(
								// Number of other posts per row
								array(
									'label'	 => array(
										'text' => __( 'Items per row', 'content-views-query-and-display-post-page' ),
									),
									'params' => array(
										array(
											'type'			 => 'number',
											'name'			 => $prefix . 'number-columns-others',
											'std'			 => '1',
											'append_text'	 => '1 &rarr; 12',
										),
									),
								),
								// Display what fields
								array(
									'label'	 => array(
										'text' => __( 'Fields to show', 'content-views-pro' ),
									),
									'params' => array(
										array(
											'type'		 => 'select',
											'name'		 => $prefix . 'show-fields',
											'options'	 => PT_CV_Values_Pro::one_others_fields(),
											'std'		 => 'thumbnail,title,meta-fields',
											'class'		 => 'select2',
											'multiple'	 => '1',
										),
									),
								),
								// Dimensions for thumbnail of other posts
								array(
									'label'	 => array(
										'text' => __( 'Thumbnail size', 'content-views-pro' ),
									),
									'params' => array(
										array(
											'type'	 => 'group',
											'params' => array(
												// Width
												array(
													'label'	 => array(
														'text' => __( 'Width' ),
													),
													'params' => array(
														array(
															'type'			 => 'number',
															'name'			 => $prefix . 'thumbnail-width-others',
															'std'			 => '150',
															'append_text'	 => 'px',
														),
													),
												),
												// Height
												array(
													'label'	 => array(
														'text' => __( 'Height' ),
													),
													'params' => array(
														array(
															'type'			 => 'number',
															'name'			 => $prefix . 'thumbnail-height-others',
															'std'			 => '100',
															'append_text'	 => 'px',
														),
													),
												),
											),
										),
									),
								),
							),
						),
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_one_others', $result );

			return $result;
		}

		/**
		 * Settings of View type = Pinterest
		 *
		 * @return array
		 */
		static function view_type_settings_pinterest() {

			$prefix = 'pinterest-';

			$result = array(
				// Number of columns
				array(
					'label'	 => array(
						'text' => __( 'Items per row', 'content-views-query-and-display-post-page' ),
					),
					'params' => array(
						array(
							'type'			 => 'number',
							'name'			 => $prefix . 'number-columns',
							'std'			 => '3',
							'append_text'	 => '1 &rarr; 12',
						),
					),
				),
				array(
					'label'	 => array(
						'text' => __( 'Options', 'content-views-pro' ),
					),
					'params' => array(
						array(
							'type'	 => 'group',
							'params' => array(
								// Use Shadow box or just Border
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'width' => 12,
										),
									),
									'params'		 => array(
										array(
											'type'		 => 'checkbox',
											'name'		 => $prefix . 'box-style',
											'options'	 => PT_CV_Values::yes_no( 'border', __( 'Remove the box shadow', 'content-views-pro' ) ),
											'std'		 => '',
										),
									),
								),
								// Don't display bottom border
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'width' => 12,
										),
									),
									'params'		 => array(
										array(
											'type'		 => 'checkbox',
											'name'		 => $prefix . 'no-bb',
											'options'	 => PT_CV_Values::yes_no( 'no-bb', __( 'Remove bottom border of fields', 'content-views-pro' ) ),
											'std'		 => '',
										),
									),
								),
							),
						)
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_pinterest', $result );

			return $result;
		}

		/**
		 * Settings of View type = Masonry
		 *
		 * @return array
		 */
		static function view_type_settings_masonry() {

			//$prefix = 'masonry-';

			$result = array(
				PT_CV_Settings::setting_no_option(),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_masonry', $result );

			return $result;
		}

		/**
		 * Settings of View type = Timeline
		 *
		 * @return array
		 */
		static function view_type_settings_timeline() {

			$prefix = 'timeline-';

			$result = array(
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'checkbox',
							'name'		 => $prefix . 'long-distance',
							'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show posts separately to ensure they are displayed in correct order', 'content-views-pro' ) ),
							'std'		 => '',
							'desc'		 => __( 'Check this option if showing full post content, or height of thumbnails are not equal', 'content-views-pro' ),
						),
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_timeline', $result );

			return $result;
		}

		/**
		 * Settings of View type = Glossary
		 *
		 * @return array
		 */
		static function view_type_settings_glossary() {

			$prefix = 'glossary-';

			$result = array(
				array(
					'label'	 => array(
						'text' => __( 'Items per row', 'content-views-query-and-display-post-page' ),
					),
					'params' => array(
						array(
							'type'			 => 'number',
							'name'			 => $prefix . 'number-columns',
							'std'			 => '3',
							'append_text'	 => '1 &rarr; 12',
						),
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_glossary', $result );

			return $result;
		}

		/**
		 * Font setting group
		 *
		 * @param array $prefix2 The prefix string for Meta fields option name
		 *
		 * @return array
		 */
		static function field_font_settings_group( $prefix2 ) {

			$result = array(
				'label'			 => array(
					'text' => __( 'Color & Font', 'content-views-pro' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-id' => PT_CV_Html::html_group_id( 'color-font' ),
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							self::field_settings_font(
								array(
									'label'			 => __( 'Each item', 'content-views-pro' ),
									'name'			 => 'content-item',
									'skip_all'		 => 1,
									'skip_depend'	 => 1,
									'bgcolor'		 => '',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Shuffle filters', 'content-views-pro' ),
									'name'		 => 'filter-bar',
									'depend'	 => array( 'enable-taxonomy-filter' ),
									'font-size'	 => '',
									'color'		 => '',
									'bgcolor'	 => '',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => sprintf( '%s (%s)', __( 'Shuffle filters', 'content-views-pro' ), __( 'active', 'content-views-pro' ) ),
									'name'		 => 'filter-bar-active',
									'depend'	 => array( 'enable-taxonomy-filter' ),
									'font-size'	 => '',
									'color'		 => '#fff',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
									'label'			 => sprintf( '%s (%s)', __( 'Shuffle filters', 'content-views-pro' ), __( 'heading', 'content-views-pro' ) ),
									'name'			 => 'filter-bar-heading',
									'depend_multi'	 => array( array( 'enable-taxonomy-filter' ), array( 'taxonomy-filter-type', 'group_by_taxonomy' ) ),
									'font-size'		 => '',
									'color'			 => '#fff',
									'bgcolor'		 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Glossary header', 'content-views-pro' ),
									'name'		 => 'gls-header',
									'depend'	 => array( 'view-type', 'glossary' ),
									'font-size'	 => '',
									'color'		 => '',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
								'label'		 => __( 'Title' ),
								'name'		 => 'title',
								'font-size'	 => '',
								'color'		 => '',
								'bgcolor'	 => '',
								), $prefix2
							),
							self::field_settings_font(
								array(
								'label'		 => sprintf( '%s (%s)', __( 'Title' ), __( 'on hover', 'content-views-pro' ) ),
								'name'		 => 'title-hover',
								'depend'	 => array( 'title' ),
								'font-size'	 => '',
								'color'		 => '',
								'bgcolor'	 => '',
								), $prefix2
							),
							self::field_settings_font(
								array(
								'label'		 => __( 'Content' ),
								'name'		 => 'content',
								'font-size'	 => '',
								'color'		 => '',
								'bgcolor'	 => '',
								), $prefix2
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Caption (Scrollable list)', 'content-views-pro' ),
									'name'		 => 'carousel-caption',
									'depend'	 => array( 'view-type', 'scrollable' ),
									'skip_all'	 => 1,
									'bgcolor'	 => 'rgba(51,51,51,.6)',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Overlay', 'content-views-pro' ),
									'name'		 => 'mask',
									'depend'	 => array( 'anm-overlay-enable', '', '!=' ),
									'skip_all'	 => 1,
									'bgcolor'	 => 'rgba(51,51,51,.6)',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => '',
									'name'		 => 'mask-text',
									'depend'	 => array( 'anm-overlay-enable', '', '!=' ),
									'skip_all'	 => 1,
									'color'		 => '#fff',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Read More', 'content-views-query-and-display-post-page' ),
									'name'		 => 'readmore',
									'depend'	 => array( 'field-excerpt-readmore' ),
									'font-size'	 => '',
									'color'		 => '#ffffff',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => sprintf( '%s (%s)', __( 'Read More', 'content-views-query-and-display-post-page' ), __( 'on hover', 'content-views-pro' ) ),
									'name'		 => 'readmore:hover',
									'depend'	 => array( 'field-excerpt-readmore' ),
									'font-size'	 => '',
									'color'		 => '#ffffff',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
								'label'		 => __( 'Meta fields', 'content-views-query-and-display-post-page' ),
								'name'		 => 'meta-fields',
								'font-size'	 => '',
								'color'		 => '',
								), $prefix2
							),
							self::field_settings_font(
								array(
								'label'		 => __( 'Custom Fields' ),
								'name'		 => 'custom-fields',
								'font-size'	 => '',
								'color'		 => '',
								), $prefix2
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Taxonomy as output', 'content-views-pro' ),
									'name'		 => 'tao',
									'depend'	 => array( 'taxonomy-term-info', 'as_output' ),
									'font-size'	 => '',
									'color'		 => '',
									'bgcolor'	 => '',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Taxonomy in special place', 'content-views-pro' ),
									'name'		 => 'specialp',
									'depend'	 => array( 'meta-fields-taxonomy-special-place' ),
									'font-size'	 => '',
									'font-style' => '',
									'color'		 => '#fff',
									'bgcolor'	 => '#CC3333',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Pagination', 'content-views-query-and-display-post-page' ),
									'name'		 => 'more',
									'depend'	 => array( 'enable-pagination' ),
									'font-size'	 => '',
									'color'		 => '#ffffff',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Post format icon', 'content-views-pro' ),
									'name'		 => 'pficon',
									'depend'	 => array( 'show-field-format-icon' ),
									'skip_all'	 => 1,
									'color'		 => '#bbb',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Add to cart', 'content-views-pro' ),
									'name'		 => 'price',
									'depend'	 => array( 'content-type', 'product' ),
									'font-size'	 => '',
									'color'		 => '#ffffff',
									'bgcolor'	 => '#00aeef',
								)
							),
							self::field_settings_font(
								array(
									'label'		 => __( 'Sale badge', 'content-views-pro' ),
									'name'		 => 'woosale',
									'depend'	 => array( 'content-type', 'product' ),
									'font-size'	 => '',
									'color'		 => '#ffffff',
									'bgcolor'	 => '#ff5a5f',
								)
							),
						),
					),
				),
			);

			return $result;
		}

		/**
		 * Font setting options
		 *
		 * @param array  $args    Array of information
		 * @param string $prefix2 The prefix of parameters
		 *
		 * @return array
		 */
		static function field_settings_font( $args, $prefix2 = '' ) {

			// Span of setting value
			$setting_width = 12;

			$result = array(
				'label'			 => array(
					'text' => $args[ 'label' ],
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => PT_CV_PREFIX . 'font-' . $args[ 'name' ],
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'group',
						'params' => array(
							// Color
							isset( $args[ 'color' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'text-color',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'color_picker',
										'options'	 => array(
											'type'	 => 'color',
											'name'	 => 'font-color-' . $args[ 'name' ],
											'std'	 => $args[ 'color' ],
										),
									),
								)
								) : '',
							// Background color
							isset( $args[ 'bgcolor' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => 12,
										'group-class'	 => PT_CV_PREFIX . 'bg-color',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'color_picker',
										'options'	 => array(
											'type'	 => 'color',
											'name'	 => 'font-bgcolor-' . $args[ 'name' ],
											'std'	 => $args[ 'bgcolor' ],
										),
									),
								)
								) : '',
							// Font family
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'font-family',
									),
								),
								'params'		 => array(
									array(
										'type'					 => 'select',
										'name'					 => 'font-family-' . $args[ 'name' ],
										'options'				 => PT_CV_Values_Pro::font_families(),
										'std'					 => '',
										'option_class_prefix'	 => PT_CV_PREFIX . 'font-',
									),
								),
								) : '',
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'font-family-text',
									),
								),
								'params'		 => array(
									array(
										'type'	 => 'text',
										'name'	 => 'font-family-text-' . $args[ 'name' ],
										'std'	 => '',
									),
								),
								'dependence'	 => array( 'font-family-' . $args[ 'name' ], 'custom-font' ),
								) : '',
							// Font size
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'font-size',
									),
								),
								'params'		 => array(
									array(
										'type'			 => 'number',
										'name'			 => 'font-size-' . $args[ 'name' ],
										'std'			 => $args[ 'font-size' ],
										'append_text'	 => 'px',
										'placeholder'	 => 'font size',
									),
								),
								) : '',
							// Font weight
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'style-toggle',
										'wrap-class'	 => 'data-toggle-buttons',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'checkbox',
										'name'		 => 'font-weight-' . $args[ 'name' ],
										'options'	 => PT_CV_Values::yes_no( 'bold', '<span class="dashicons dashicons-editor-bold"></span>' ),
										'std'		 => ($args[ 'name' ] === 'title') ? 'bold' : '',
									),
								),
								) : '',
							// Font style
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'style-toggle',
										'wrap-class'	 => 'data-toggle-buttons',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'checkbox',
										'name'		 => 'font-style-' . $args[ 'name' ],
										'options'	 => PT_CV_Values::yes_no( 'italic', '<span class="dashicons dashicons-editor-italic"></span>' ),
										'std'		 => '',
									),
								),
								) : '',
							// Decoration
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'style-toggle',
										'wrap-class'	 => 'data-toggle-buttons',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'checkbox',
										'name'		 => 'font-decoration-' . $args[ 'name' ],
										'options'	 => PT_CV_Values::yes_no( 'underline', '<span class="dashicons dashicons-editor-underline"></span>' ),
										'std'		 => '',
									),
								),
								) : '',
							// Text transform
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'transform',
									),
								),
								'params'		 => array(
									array(
										'type'		 => 'select',
										'name'		 => 'font-transform-' . $args[ 'name' ],
										'options'	 => PT_CV_Values_Pro::text_transform(),
										'std'		 => '',
									),
								),
								) : '',
							// Line height
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'numfield',
									),
								),
								'params'		 => array(
									array(
										'type'			 => 'text',
										'name'			 => 'font-lineheight-' . $args[ 'name' ],
										'std'			 => '',
										'prepend_text'	 => sprintf( '<span class="input-group-addon">%s</span>', __( 'Line height', 'content-views-pro' ) ),
									),
								),
								) : '',
							// Letter spacing
							!isset( $args[ 'skip_all' ] ) ? array(
								'label'			 => array(
									'text' => '',
								),
								'extra_setting'	 => array(
									'params' => array(
										'width'			 => $setting_width,
										'group-class'	 => PT_CV_PREFIX . 'numfield',
									),
								),
								'params'		 => array(
									array(
										'type'			 => 'text',
										'name'			 => 'font-letterspacing-' . $args[ 'name' ],
										'std'			 => '',
										'prepend_text'	 => sprintf( '<span class="input-group-addon">%s</span>', __( 'Letter spacing', 'content-views-pro' ) ),
									),
								),
								) : '',
						),
					),
				),
			);

			// Dependence
			if ( !isset( $args[ 'skip_depend' ] ) ) {
				if ( isset( $args[ 'depend_multi' ] ) ) {
					$result[ 'dependence' ] = $args[ 'depend_multi' ];
				} else {
					$result[ 'dependence' ] = array(
						$prefix2 . (!empty( $args[ 'depend' ][ 0 ] ) ? $args[ 'depend' ][ 0 ] : $args[ 'name' ] ), isset( $args[ 'depend' ][ 1 ] ) ? $args[ 'depend' ][ 1 ] : 'yes', !empty( $args[ 'depend' ][ 2 ] ) ? $args[ 'depend' ][ 2 ] : '=',
					);
				}
			}

			return $result;
		}

		static function view_style_settings( $setting ) {

			switch ( $setting ) {
				case 'view':
					$result = array(
						'label'			 => array(
							'text' => '',
						),
						'extra_setting'	 => array(
							'params' => array(
								'width'			 => 12,
								'group-class'	 => PT_CV_PREFIX . 'fbold',
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									self::_padding_margin_settings( 'margin-value-', __( 'View Margin', 'content-views-pro' ) ),
								),
							),
						),
					);
					break;

				case 'item':
					$result = array(
						'label'			 => array(
							'text' => '',
						),
						'extra_setting'	 => array(
							'params' => array(
								'width'			 => 12,
								'group-class'	 => PT_CV_PREFIX . 'fbold',
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									self::_padding_margin_settings( 'item-padding-value-', __( 'Item Padding', 'content-views-pro' ) ),
									self::_padding_margin_settings( 'item-margin-value-', __( 'Item Margin', 'content-views-pro' ) ),
								),
							),
						),
					);
					break;

				case 'common':
					$result = array(
						'label'	 => array(
							'text' => __( 'Others', 'content-views-query-and-display-post-page' ),
						),
						'params' => array(
							array(
								'type'	 => 'group',
								'params' => array(
									self::_text_align_settings(),
									self::_text_direction_settings(),
									self::_button_border_radius(),
								),
							),
						),
					);
					break;
			}

			return $result;
		}

		/**
		 * Animation & Effect setting options
		 *
		 * @return array
		 */
		static function animation_settings() {

			$prefix = 'anm-';

			$result = array(
				array(
					'label'	 => array(
						'text' => __( 'Overlay thumbnail with text', 'content-views-pro' ),
					),
					'params' => array(
						array(
							'type'		 => 'radio',
							'name'		 => $prefix . 'overlay-enable',
							'options'	 => array( '' => __( 'None' ), 'always' => __( 'Always', 'content-views-pro' ), 'onhover' => __( 'On hover', 'content-views-pro' ), ),
							'std'		 => '',
						),
					),
				),
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'group',
							'params' => array(
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'wrap-class' => PT_CV_PREFIX . 'w200',
										),
									),
									'params'		 => array(
										array(
											'type'		 => 'select',
											'name'		 => $prefix . 'content-animation',
											'options'	 => PT_CV_Values_Pro::content_animation(),
											'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::content_animation() ),
											'desc'		 => __( 'Hover effect', 'content-views-pro' ),
										),
									),
								),
								array(
									'label'	 => array(
										'text' => '',
									),
									'params' => array(
										array(
											'type'		 => 'checkbox',
											'name'		 => $prefix . 'exclude-title',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Title is always visible', 'content-views-pro' ) ),
											'std'		 => '',
										),
									),
								),
							),
						),
					),
					'dependence'	 => array( $prefix . 'overlay-enable', 'onhover' ),
				),
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'group',
							'params' => array(
								array(
									'label'	 => array(
										'text' => '',
									),
									'params' => array(
										array(
											'type'		 => 'checkbox',
											'name'		 => $prefix . 'box-clickable',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Open post on click the overlay', 'content-views-pro' ) ),
											'std'		 => '',
										),
									),
								),
								array(
									'label'	 => array(
										'text' => '',
									),
									'params' => array(
										array(
											'type'		 => 'checkbox',
											'name'		 => $prefix . 'disable-onmobile',
											'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Disable overlay on small screens (less than 481 pixels)', 'content-views-pro' ) ),
											'std'		 => '',
											'desc'		 => __( 'Check this option if you have long content', 'content-views-pro' ),
										),
									),
								),
							),
						),
					),
					'dependence'	 => array( $prefix . 'overlay-enable', '', '!=' ),
				),
				array(
					'label'			 => array(
						'text' => __( 'Overlay position', 'content-views-pro' ),
					),
					'extra_setting'	 => array(
						'params' => array(
							'wrap-class' => PT_CV_PREFIX . 'w200',
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'select',
							'name'		 => $prefix . 'overlay-position',
							'options'	 => array(
								'top'	 => __( 'Top', 'content-views-pro' ),
								''		 => __( 'Middle', 'content-views-pro' ),
								'bottom' => __( 'Bottom', 'content-views-pro' ),
							),
							'std'		 => '',
						),
					),
					'dependence'	 => array( $prefix . 'overlay-enable', '', '!=' ),
				),
			);

			return $result;
		}

		/**
		 * Advertisement setting options
		 */
		static function content_ads_settings( $prefix ) {
			$this_enable = $prefix . 'enable';
			$ads_list	 = array();
			for ( $i = 0; $i < 10; $i++ ) {
				$ads_list[] = array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'group-class' => PT_CV_PREFIX . 'ad-item',
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'textarea',
							'name'	 => $prefix . 'content' . $i,
							'std'	 => '',
						),
					),
					'dependence'	 => array( $this_enable, 'yes' ),
				);
			}

			// Sort array of params by saved order
			$ads_list = apply_filters( PT_CV_PREFIX_ . 'settings_sort', $ads_list, PT_CV_PREFIX . $prefix );

			$result = array_merge( array(
				// Enable
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'		 => 'checkbox',
							'name'		 => $this_enable,
							'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Show ads in output', PT_CV_DOMAIN_PRO ) ),
							'std'		 => '',
							'desc'		 => __( 'Ads are shown in order of appearance. Drag & drop ads to change their positions (in relation to each other)', PT_CV_DOMAIN_PRO ),
						),
					),
				),
				array(
					'label'		 => array(
						'text' => __( 'Ads positions', PT_CV_DOMAIN_PRO ),
					),
					'params'	 => array(
						array(
							'type'	 => 'group',
							'params' => array(
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'width' => 12,
										),
									),
									'params'		 => array(
										array(
											'type'		 => 'radio',
											'name'		 => $prefix . 'position',
											'options'	 => array(
												''		 => __( 'Random', 'content-views-pro' ),
												'manual' => __( 'Manual', 'content-views-pro' ),
											),
											'std'		 => '',
										),
									),
								),
								array(
									'label'			 => array(
										'text' => '',
									),
									'extra_setting'	 => array(
										'params' => array(
											'width'		 => 12,
											'wrap-class' => PT_CV_PREFIX . 'w200',
										),
									),
									'params'		 => array(
										array(
											'type'	 => 'text',
											'name'	 => $prefix . 'position-manual',
											'std'	 => '',
											'desc'	 => __( 'Set positions (numeric values, separate by comma, in increasing order) to show ads on each page', 'content-views-pro' ),
										),
									),
									'dependence'	 => array( $prefix . 'position', 'manual' ),
								),
							),
						),
					),
					'dependence' => array( $this_enable, 'yes' ),
				),
				/**
				  array(
				  'label'		 => array(
				  'text' => __( 'Always show 1 ad at', PT_CV_DOMAIN_PRO ),
				  ),
				  'params'	 => array(
				  array(
				  'type'		 => 'checkbox',
				  'name'		 => $prefix . 'showfirst',
				  'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Beginning of View', PT_CV_DOMAIN_PRO ) ),
				  'std'		 => '',
				  ),
				  array(
				  'type'		 => 'checkbox',
				  'name'		 => $prefix . 'showlast',
				  'options'	 => PT_CV_Values::yes_no( 'yes', __( 'End of View', PT_CV_DOMAIN_PRO ) ),
				  'std'		 => '',
				  ),
				  ),
				  'dependence' => array( $this_enable, 'yes' ),
				  ),
				 *
				 */
				array(
					'label'		 => array(
						'text' => __( 'Execute shortcode', 'content-views-pro' ),
					),
					'params'	 => array(
						array(
							'type'		 => 'checkbox',
							'name'		 => $prefix . 'enable-shortcode',
							'options'	 => PT_CV_Values::yes_no( 'yes', __( 'Yes', 'content-views-query-and-display-post-page' ) ),
							'std'		 => '',
							'desc'		 => __( 'Check this option if ad content is shortcode', 'content-views-pro' ),
						),
					),
					'dependence' => array( $this_enable, 'yes' ),
				),
				array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'	 => 'group',
							'params' => array(
								array(
									'label'			 => array(
										'text' => __( 'Number of ads per page', PT_CV_DOMAIN_PRO ),
									),
									'extra_setting'	 => array(
										'params' => array(
											'wrap-class' => PT_CV_PREFIX . 'w200',
										),
									),
									'params'		 => array(
										array(
											'type'	 => 'number',
											'name'	 => $prefix . 'per-page',
											'std'	 => '1',
										),
									),
									'dependence'	 => array( $this_enable, 'yes' ),
								),
							),
						),
					),
					'dependence'	 => array( 'enable-pagination', 'yes' ),
				),
				), $ads_list );


			return $result;
		}

		/**
		 * Margin setting for whole View
		 *
		 * @return array
		 */
		static function _padding_margin_settings( $prefix, $text, $options = '', $desc = '' ) {
			$settings	 = array();
			$options	 = is_array( $options ) ? $options : array( 'top', 'right', 'left', 'bottom' );

			foreach ( $options as $option ) {
				$label = ucfirst( $option );

				$settings[] = array(
					'label'			 => array(
						'text' => '',
					),
					'extra_setting'	 => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'		 => array(
						array(
							'type'			 => 'number',
							'name'			 => $prefix . $option,
							'std'			 => '',
							'prepend_text'	 => sprintf( '<span class="input-group-addon">%s</span>', ucfirst( $label ) ),
							'append_text'	 => 'px',
							'desc'			 => !empty( $desc ) ? $desc : '',
							'min'			 => '0',
						),
					),
				);
			}

			$result = array(
				'label'			 => array(
					'text' => $text,
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => 'cv-padding-margin',
					),
				),
				'params'		 => array(
					array(
						'type'	 => 'group',
						'params' => $settings,
					),
				),
			);

			return $result;
		}

		/**
		 * Text align
		 */
		static function _text_align_settings() {
			$prefix = 'style-';

			return array(
				'label'			 => array(
					'text' => __( 'Text align', 'content-views-pro' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => PT_CV_PREFIX . 'w200',
					),
				),
				'params'		 => array(
					array(
						'type'		 => 'select',
						'name'		 => $prefix . 'text-align',
						'options'	 => PT_CV_Values_Pro::text_align(),
						'std'		 => '',
					),
				),
			);
		}

		/**
		 * Text direction
		 */
		static function _text_direction_settings() {
			return array(
				'label'			 => array(
					'text' => __( 'Text direction', 'content-views-pro' ),
				),
				'extra_setting'	 => array(
					'params' => array(
						'wrap-class' => PT_CV_PREFIX . 'w200',
					),
				),
				'params'		 => array(
					array(
						'type'		 => 'select',
						'name'		 => 'text-direction',
						'options'	 => PT_CV_Values_Pro::text_direction(),
						'std'		 => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::text_direction() ),
					),
				),
			);
		}

		/**
		 * Button border radius
		 */
		static function _button_border_radius() {
			$prefix = 'style-';

			return array(
				'label'	 => array(
					'text' => __( 'Border radius', 'content-views-pro' ),
				),
				'params' => array(
					array(
						'type'			 => 'number',
						'name'			 => $prefix . 'button-border-radius',
						'std'			 => '0',
						'append_text'	 => 'px',
						'desc'			 => __( 'Border radius of buttons (Read-more...)', 'content-views-pro' ),
					),
				),
			);
		}

		/**
		 * Advanced filters by Date
		 * @return array
		 */
		static function filter_date_settings() {

			$prefix = 'post_date_';

			// Date options
			$date = array(
				'date' => array(
					'parent_label' => sprintf( __( 'Filter by %s', 'content-views-query-and-display-post-page' ), __( 'Date' ) ),
					// Select date
					array(
						'label'	 => array(
							'text' => __( 'Get posts', 'content-views-pro' ),
						),
						'params' => array(
							array(
								'type'		 => 'radio',
								'name'		 => $prefix . 'value',
								'options'	 => PT_CV_Values_Pro::post_date(),
								'std'		 => 'today',
							),
						),
					),
					// Date value custom
					array(
						'label'	 => array(
							'text' => '',
						),
						'params' => array(
							array(
								'type'	 => 'group',
								'params' => array(
									// Custom Date
									array(
										'label'			 => array(
											'text' => __( 'Select date', 'content-views-pro' ),
										),
										'extra_setting'	 => array(
											'params' => array(
												'wrap-class' => PT_CV_PREFIX . 'w200',
											),
										),
										'params'		 => array(
											array(
												'type'	 => 'text',
												'name'	 => $prefix . 'custom_date',
												'std'	 => '',
												'class'	 => 'datepicker',
											),
										),
										'dependence'	 => array( $prefix . 'value', 'custom_date' ),
									),
									array(
										'label'			 => array(
											'text' => __( 'Select year', 'content-views-pro' ),
										),
										'extra_setting'	 => array(
											'params' => array(
												'wrap-class' => PT_CV_PREFIX . 'w200',
											),
										),
										'params'		 => array(
											array(
												'type'	 => 'number',
												'name'	 => $prefix . 'custom_year',
												'std'	 => current_time( 'Y' ),
											),
										),
										'dependence'	 => array( $prefix . 'value', 'custom_year' ),
									),
									// Custom Time (From - To)
									array(
										'label'			 => array(
											'text' => '',
										),
										'extra_setting'	 => array(
											'params' => array(
												'width' => 12,
											),
										),
										'params'		 => array(
											array(
												'type'	 => 'group',
												'params' => array(
													array(
														'label'			 => array(
															'text' => __( 'From', 'content-views-pro' ),
														),
														'extra_setting'	 => array(
															'params' => array(
																'wrap-class' => PT_CV_PREFIX . 'w200',
															),
														),
														'params'		 => array(
															array(
																'type'	 => 'text',
																'name'	 => $prefix . 'from',
																'std'	 => '',
																'class'	 => 'datepicker',
															),
														),
													),
													array(
														'label'			 => array(
															'text' => __( 'To', 'content-views-pro' ),
														),
														'extra_setting'	 => array(
															'params' => array(
																'wrap-class' => PT_CV_PREFIX . 'w200',
															),
														),
														'params'		 => array(
															array(
																'type'	 => 'text',
																'name'	 => $prefix . 'to',
																'std'	 => '',
																'class'	 => 'datepicker',
															),
														),
													),
												),
											),
										),
										'dependence'	 => array( $prefix . 'value', 'custom_time' ),
									),
								),
							),
						),
					),
				),
			);

			return $date;
		}

		/**
		 * Advanced filters by Custom Fields
		 * @return array
		 */
		static function filter_custom_field_settings() {

			$result = array(
				'custom_field' => array(
					'parent_label' => sprintf( __( 'Filter by %s', 'content-views-query-and-display-post-page' ), __( 'Custom Fields' ) ),
					array(
						'label'			 => array(
							'text' => '',
						),
						'extra_setting'	 => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
								'width'		 => 12,
							),
						),
						'params'		 => array(
							array(
								'type'	 => 'group',
								'params' => array(
									// Custom fields list
									array(
										'label'			 => array(
											'text' => '',
										),
										'extra_setting'	 => array(
											'params' => array(
												'wrap-class' => 'form-inline',
												'width'		 => 12,
											),
										),
										'params'		 => array(
											array(
												'type'		 => 'html',
												'content'	 => self::custom_field_settings_header(),
											),
											array(
												'type'		 => 'html',
												'content'	 => self::custom_field_settings_content(),
											),
											array(
												'type'		 => 'html',
												'content'	 => self::custom_field_settings_footer(),
											),
										),
									),
									// Relation of custom fields
									array(
										'label'	 => array(
											'text' => __( 'Relation', 'content-views-query-and-display-post-page' ),
										),
										'params' => array(
											array(
												'type'		 => 'select',
												'name'		 => 'ctf-filter-' . 'relation',
												'options'	 => PT_CV_Values::taxonomy_relation(),
												'std'		 => 'OR',
												'class'		 => 'ctf-relation',
											),
										),
									),
								),
							),
						),
					),
				),
			);

			return $result;
		}

		/**
		 * Header text for Custom Field filter
		 */
		private static function custom_field_settings_header() {
			ob_start();
			?>
			<div class="table-responsive">
				<table class="table table-bordered-1" id="<?php echo PT_CV_PREFIX; ?>ctf-list">
					<tr style="border-bottom: 1px solid #ddd">
						<th><?php _e( 'Field key', 'content-views-pro' ); ?></th>
						<th><?php _e( 'Value type', 'content-views-pro' ); ?></th>
						<th><?php _e( 'Operator to compare', 'content-views-pro' ); ?></th>
						<th width="350"><?php _e( 'Value to compare', 'content-views-pro' ); ?></th>
						<th></th>
					</tr>
					<?php
					return ob_get_clean();
				}

				/**
				 * Setting options for a Custom Field
				 * [Field key] [Field type] [Operator] [Value to compare]
				 */
				private static function custom_field_settings_content() {
					// Custom field data type
					$ctf_types = PT_CV_Values_Pro::custom_field_type();

					// Comparison operator
					$ctf_operator = array(
						'NOW_FUTURE'	 => 'Now & Future',
						'IN_PAST'		 => 'In the past',
						'='				 => 'Equal ( = )',
						'!='			 => 'Differ ( != )',
						'>'				 => 'Greater ( > )',
						'>='			 => 'Greater or Equal ( >= )',
						'<'				 => 'Less ( < )',
						'<='			 => 'Less or Equal ( <= )',
						'LIKE'			 => 'Like',
						'NOT LIKE'		 => 'Not Like',
						'IN'			 => 'In',
						'NOT IN'		 => 'Not in',
						'BETWEEN'		 => 'Between',
						'NOT BETWEEN'	 => 'Not Between',
						'EXISTS'		 => 'Exists',
						'NOT EXISTS'	 => 'Not Exists',
					);

					$prefix = 'ctf-filter-';

					// Setting options definition
					$setting_options = array(
						'key'		 => array(
							'type'		 => 'select',
							'name'		 => $prefix . 'key[]',
							'options'	 => PT_CV_Values_Pro::custom_fields( 'default empty' ),
							'class'		 => $prefix . 'key',
						),
						'type'		 => array(
							'type'		 => 'select',
							'name'		 => $prefix . 'type[]',
							'options'	 => $ctf_types,
						),
						'operator'	 => array(
							'type'		 => 'select',
							'name'		 => $prefix . 'operator[]',
							'options'	 => $ctf_operator,
						),
						'value'		 => array(
							'type'	 => 'text',
							'name'	 => $prefix . 'value[]',
							'class'	 => $prefix . 'value',
						),
					);

					// Get saved custom fields
					$saved_ctf = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $prefix, true );

					$number_of_fields = isset( $saved_ctf[ 'key' ] ) ? count( $saved_ctf[ 'key' ] ) : 0;

					$result = array();

					// Start from -1 to show the template row
					for ( $idx = - 1; $idx < $number_of_fields; $idx ++ ) {
						$options = array();

						foreach ( $setting_options as $key => $settings ) {
							$value		 = isset( $saved_ctf[ $key ][ $idx ] ) ? $saved_ctf[ $key ][ $idx ] : '';
							$options[]	 = sprintf( '<td>%s</td>', PT_Options_Framework::field_type( $settings, array(), $value ) );
						}

						$last_row	 = sprintf( '<td><a class="%s">x</a></td>', PT_CV_PREFIX . $prefix . 'delete' );
						$result[]	 = sprintf( '<tr class="%s">%s%s</tr>', esc_attr( $idx == - 1 ? 'hidden ctf-tpl' : ''  ), implode( '', $options ), $last_row );
					}

					return implode( '', $result );
				}

				/**
				 * Footer text for Custom Field filter
				 */
				private static function custom_field_settings_footer() {
					ob_start();
					?>
				</table>

				<a id="<?php echo PT_CV_PREFIX; ?>ctf-filter-add" class="btn btn-small btn-info"><?php _ex( 'Add New', 'post' ); ?></a>

				<div style='clear: both'></div>
				<br>
				<div class='text-muted hidden' id="<?php echo PT_CV_PREFIX; ?>date-guide" style='width: 100%;'><?php printf( __( "If value of Date custom field was not in %s format, please check %s.", 'content-views-pro' ), '<code>YYYY-MM-DD</code>', "<a href='http://docs.contentviewspro.com/filter-by-a-date-custom-field/' target='_blank'>" . __( 'this document', 'content-views-pro' ) . "</a>" ); ?></div>
				<br>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * Setting options for Field = Title
		 */
		static function field_title_settings( $prefix ) {

			$result = array(
				// Size
				array(
					'label'	 => array(
						'text' => __( 'Length' ),
					),
					'params' => array(
						array(
							'type'			 => 'number',
							'name'			 => $prefix . 'title-length',
							'std'			 => '',
							'append_text'	 => 'letters',
							'desc'			 => __( 'Leave empty to show full title', 'content-views-pro' ),
						),
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'field_title_settings', $result, $prefix );

			return $result;
		}

	}

}