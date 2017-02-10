<?php
/**
 * Plugin Uninstall
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
new Frequently_Searched_Words_Uninstall();

class Frequently_Searched_Words_Uninstall {

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		$this->drop_table();
	}

	/**
	 * Drop Table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private function drop_table () {
		global $wpdb;
		$table_name = $wpdb->prefix . 'frequently_searched_words';
		$wpdb->query( "DROP TABLE IF EXISTS " . $table_name );
	}
}