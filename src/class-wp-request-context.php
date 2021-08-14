<?php

namespace WildWolf\WordPress;

abstract class WP_Request_Context {
	public static function is_ajax(): bool {
		return self::check( 'DOING_AJAX' );
	}

	public static function is_cron(): bool {
		return self::check( 'DOING_CRON' );
	}

	public static function is_installing(): bool {
		return self::check( 'WP_INSTALLING' );
	}

	public static function is_rest(): bool {
		return self::check( 'REST_REQUEST' );
	}

	public static function is_xmlrpc(): bool {
		return self::check( 'XMLRPC_REQUEST' );
	}

	public static function is_wp_cli(): bool {
		return self::check( 'WP_CLI' );
	}

	public static function is_api_request(): bool {
		return self::is_rest() || self::is_xmlrpc();
	}

	public static function is_web_request(): bool {
		return ! ( self::is_ajax() || self::is_cron() || self::is_installing() || self::is_api_request() || self::is_wp_cli() );
	}

	private static function check( string $constant ): bool {
		return defined( $constant ) && true === constant( $constant );
	}
}
