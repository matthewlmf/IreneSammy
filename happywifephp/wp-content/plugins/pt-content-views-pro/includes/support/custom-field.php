<?php
/**
 * Custom handles for custom fields
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */
if ( !class_exists( 'PT_CV_CustomField' ) ) {

	/**
	 * @name PT_CV_CustomField
	 * @todo Utility functions
	 */
	class PT_CV_CustomField {

		/**
		 * Generate final output for csutom field
		 *
		 * @param array $field_value
		 * @param bool $use_oembed
		 *
		 * @return string
		 */
		public static function display_output( $value, $key, $use_oembed ) {
			$output = false;

			if ( $use_oembed && !filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
				$output = wp_oembed_get( $value );
			}

			if ( !$output && is_string( $value ) ) {
				$pathinfo	 = pathinfo( $value );
				$extension	 = isset( $pathinfo[ 'extension' ] ) ? strtolower( $pathinfo[ 'extension' ] ) : '';

				if ( is_email( $value ) ) {
					$output = sprintf( '<a target="_blank" href="mailto:%1$s">%1$s</a>', antispambot( $value ) );
				} else if ( preg_match( '/(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)/i', $extension ) ) {
					$output = self::image( $value, $pathinfo[ 'filename' ] );
				} else if ( $extension == 'mp3' ) {
					$output = self::embed_audio( $value );
				} else if ( $extension == 'mp4' ) {
					$output = self::embed_video( $value );
				} else if ( !filter_var( $value, FILTER_VALIDATE_URL ) === false ) {
					$html	 = apply_filters( PT_CV_PREFIX_ . 'ctf_url_text', $value, $key );
					$output	 = sprintf( '<a target="_blank" href="%s">%s</a>', esc_url( $value ), esc_html( $html ) );
				}
			}

			return $output ? $output : $value;
		}

		public static function image( $value, $name ) {
			return sprintf( '<img class="%s" src="%s" title="%s" style="width: 100%%">', PT_CV_PREFIX . 'ctf-image', esc_url( $value ), esc_attr( $name ) );
		}

		public static function embed_audio( $value ) {
			return '<audio controls>
					<source src="' . esc_url( $value ) . '" type="audio/mpeg">
					Your browser does not support the audio element.
					</audio>';
		}

		public static function embed_video( $value ) {
			return '<video controls>
					<source src="' . esc_url( $value ) . '" type="video/mp4">
					Your browser does not support HTML5 video.
					</video>';
		}

	}

}