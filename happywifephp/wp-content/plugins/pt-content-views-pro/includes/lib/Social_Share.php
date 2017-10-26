<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PT_CV_Social_Share_Count {

	public $shareUrl;
	public $socialCounts		 = array();
	public $facebookShareCount	 = 0;
	public $facebookLikeCount	 = 0;
	public $twitterShareCount	 = 0;
	public $bufferShareCount	 = 0;
	public $pinterestShareCount	 = 0;
	public $linkedInShareCount	 = 0;
	public $googlePlusOnesCount	 = 0;

	public function __construct( $options ) {

		if ( is_array( $options ) ) {
			if ( array_key_exists( 'url', $options ) && $options[ 'url' ] != '' ) {
				$this->shareUrl = $options[ 'url' ];
			} else {
				die( 'URL must be set in constructor parameter array!' );
			}

			if ( array_key_exists( 'facebook', $options ) ) {
				$this->getFacebookShares();
				#$this->getFacebookLikes();
			}

			if ( array_key_exists( 'twitter', $options ) ) {
				$this->getTwitterShares();
			}

			if ( array_key_exists( 'pinterest', $options ) ) {
				$this->getPinterestShares();
			}

			if ( array_key_exists( 'linkedin', $options ) ) {
				$this->getLinkedInShares();
			}

			if ( array_key_exists( 'googleplus', $options ) ) {
				$this->getGooglePlusOnes();
			}

			if ( array_key_exists( 'buffer', $options ) ) {
				$this->getBufferShares();
			}
		} elseif ( is_string( $options ) && $options != '' ) {
			$this->shareUrl = $options;

			$this->getFacebookShares();
			$this->getFacebookLikes();
			$this->getTwitterShares();
			$this->getPinterestShares();
			$this->getLinkedInShares();
			$this->getGooglePlusOnes();
			$this->getBufferShares();
		} else {
			die( 'URL must be set in constructor parameter!' );
		}
	}

	static function _cache( $url, $value = null ) {
		$uid = 'cvp_sharecount_' . md5( $url );
		if ( $value ) {
			set_transient( $uid, $value, 2 * HOUR_IN_SECONDS );
		} else {
			return get_transient( $uid );
		}
	}

	static function _get_response( $url, $decode = true, $service = '' ) {
		$cached = self::_cache( $url );
		if ( $cached ) {
			return $cached;
		}

		$response = wp_remote_get( $url );
		if ( is_array( $response ) ) {
			$body = $response[ 'body' ];

			if ( $service === 'pinterest' ) {
				$body = preg_replace( '/^receiveCount\((.*)\)$/', '\\1', $body );
			}

			$result = $decode ? json_decode( $body ) : $body;

			self::_cache( $url, $result );

			return $result;
		} else {
			return false;
		}
	}

	public function getFacebookShares() {
		$count = self::_get_response( 'http://graph.facebook.com/?id=' . $this->shareUrl );
		if ( isset( $count->share->share_count ) ) {
			$this->socialCounts[ 'facebook' ] = $count->share->share_count;
		}
	}

	public function getFacebookLikes() {
		$count = self::_get_response( 'http://graph.facebook.com/?id=' . $this->shareUrl );
		if ( isset( $count->likes ) ) {
			$this->socialCounts[ 'facebooklikes' ] = $count->likes;
		}
	}

	public function getTwitterShares() {
		/**
		 * @since 3.6
		 */
		$from	 = 'Twitter share count provided by NewShareCounts.com';
		$count	 = self::_get_response( 'http://public.newsharecounts.com/count.json?from=' . $from . '&url=' . $this->shareUrl );
		if ( isset( $count->count ) ) {
			$this->socialCounts[ 'twitter' ] = $count->count;
		}

		/**
		 * Twitter removed Count API since 2015 Oct.
		 * https://blog.twitter.com/2015/hard-decisions-for-a-sustainable-platform
		 */
		/*
		  $api	 = @file_get_contents( 'https://cdn.api.twitter.com/1/urls/count.json?url=' . $this->shareUrl );
		  $count	 = json_decode( $api );
		  if ( isset( $count->count )  ) {
		  $this->twitterShareCount = $count->count;
		  }
		  $this->socialCounts[ 'twitter' ] = $this->twitterShareCount;
		  return $this->twitterShareCount;
		 */
	}

	public function getBufferShares() {
		$count = self::_get_response( 'https://api.bufferapp.com/1/links/shares.json?url=' . $this->shareUrl );
		if ( isset( $count->shares ) && $count->shares != '0' ) {
			$this->socialCounts[ 'buffer' ] = $count->shares;
		}
	}

	public function getPinterestShares() {
		$count = self::_get_response( 'http://api.pinterest.com/v1/urls/count.json?callback%20&url=' . $this->shareUrl, true, 'pinterest' );
		if ( isset( $count->count ) ) {
			$this->socialCounts[ 'pinterest' ] = $count->count;
		}
	}

	public function getLinkedInShares() {
		$count = self::_get_response( 'https://www.linkedin.com/countserv/count/share?url=' . $this->shareUrl . '&format=json' );
		if ( isset( $count->count ) ) {
			$this->socialCounts[ 'linkedin' ] = $count->count;
		}
	}

	public function getGooglePlusOnes() {
		$plus_count = 0;
		if ( function_exists( 'curl_version' ) ) {
			$curl			 = curl_init();
			curl_setopt( $curl, CURLOPT_URL, "https://clients6.google.com/rpc" );
			curl_setopt( $curl, CURLOPT_POST, 1 );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $this->shareUrl . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]' );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-type: application/json' ) );
			$curl_results	 = curl_exec( $curl );
			curl_close( $curl );
			$json			 = json_decode( $curl_results, true );
			$plus_count		 = intval( $json[ 0 ][ 'result' ][ 'metadata' ][ 'globalCounts' ][ 'count' ] );
		} else {
			$content = self::_get_response( "https://plusone.google.com/u/0/_/+1/fastbutton?url=" . urlencode( $this->shareUrl ) . "&count=true", false );

			$doc = new DOMdocument();
			libxml_use_internal_errors( true );
			$doc->loadHTML( $content );
			$doc->saveHTML();
			$num = $doc->getElementById( 'aggregateCount' )->textContent;

			if ( $num ) {
				$plus_count = intval( $num );
			}
		}

		$this->socialCounts[ 'googleplus' ] = $plus_count;
	}

}
