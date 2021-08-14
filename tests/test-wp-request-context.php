<?php

use PHPUnit\Framework\TestCase;
use WildWolf\WordPress\WP_Request_Context;

class Test_WP_Request_Context extends TestCase {
	/**
	 * @dataProvider context_data_provider
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function test_context( ?string $method, ?string $constant, bool $value, bool $is_api, bool $is_web ): void {
		if ( null !== $constant ) {
			define( $constant, $value );
		}

		if ( null !== $method ) {
			self::assertTrue( WP_Request_Context::$method() );
		}

		self::assertSame( $is_api, WP_Request_Context::is_api_request() );
		self::assertSame( $is_web, WP_Request_Context::is_web_request() );
	}

	/**
	 * @psalm-return iterable<array-key,array{?string, ?string, bool, bool, bool}>
	 */
	public function context_data_provider(): iterable {
		return [
			'web'        => [ null, null, false, false, true ],
			'ajax'       => [ 'is_ajax', 'DOING_AJAX', true, false, false ],
			'cron'       => [ 'is_cron', 'DOING_CRON', true, false, false ],
			'installing' => [ 'is_installing', 'WP_INSTALLING', true, false, false ],
			'rest'       => [ 'is_rest', 'REST_REQUEST', true, true, false ],
			'xmlrpc'     => [ 'is_xmlrpc', 'XMLRPC_REQUEST', true, true, false ],
			'wp-cli'     => [ 'is_wp_cli', 'WP_CLI', true, false, false ],
		];
	}
}
