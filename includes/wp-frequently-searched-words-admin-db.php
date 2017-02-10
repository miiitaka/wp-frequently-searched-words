<?php
/**
 * Admin DB Connection
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Frequently_Searched_Words_Admin_Db {

	/**
	 * Variable definition: table name
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $table_name;

	/**
	 * Constructor Define.
	 *
	 * @since 1.0.0
	 */
	public function __construct () {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'frequently_searched_words';
	}

	/**
	 * Create Table.
	 *
	 * @since 1.0.0
	 */
	public function create_table () {
		global $wpdb;

		$prepared     = $wpdb->prepare( "SHOW TABLES LIKE %s", $this->table_name );
		$is_db_exists = $wpdb->get_var( $prepared );

		if ( is_null( $is_db_exists ) ) {
			$charset_collate = $wpdb->get_charset_collate();

			$query  = " CREATE TABLE " . $this->table_name;
			$query .= " (id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY";
			$query .= ",search_word text NOT NULL";
			$query .= ",search_count int DEFAULT 1";
			$query .= ",register_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL";
			$query .= ",update_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL";
			$query .= ",UNIQUE KEY id (id)) " . $charset_collate;

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $query );
		}
	}

	/**
	 * Get Data.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   string $search_word
	 * @return  array  $args
	 */
	public function get_options ( $search_word ) {
		global $wpdb;

		$query    = "SELECT * FROM " . $this->table_name . " WHERE search_word = %s";
		$data     = array( $search_word );
		$prepared = $wpdb->prepare( $query, $data );

		return (array) $wpdb->get_row( $prepared );
	}

	/**
	 * Get Search Count SUM.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  array  $args
	 */
	public function get_search_count_sum () {
		global $wpdb;

		$prepared = "SELECT SUM(search_count) AS SCOUNT FROM " . $this->table_name;

		return (array) $wpdb->get_row( $prepared );
	}

	/**
	 * Get All Data.
	 *
	 * @vesion 1.0.0
	 * @since  1.0.0
	 * @param  integer $limit
	 * @return array   $results
	 */
	public function get_list_options ( $limit = 0 ) {
		global $wpdb;

		if ( $limit > 0 ) {
			$query    = "SELECT * FROM " . $this->table_name . " ORDER BY search_count DESC, search_word ASC LIMIT %d";
			$data     = (int) $limit;
			$prepared = $wpdb->prepare( $query, $data );
		} else {
			$prepared = "SELECT * FROM " . $this->table_name . " ORDER BY search_count DESC, search_word ASC";
		}
		return (array) $wpdb->get_results( $prepared );
	}

	/**
	 * Insert Data.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   string  $search_word
	 * @return  integer $id
	 */
	public function insert_options ( $search_word ) {
		global $wpdb;

		$data = array(
			'search_word'   => $search_word,
			'register_date' => date( "Y-m-d H:i:s" ),
			'update_date'   => date( "Y-m-d H:i:s" )
		);
		$prepared = array(
			'%s',
			'%s',
			'%s'
		);

		$wpdb->insert( $this->table_name, $data, $prepared );
		return (int) $wpdb->insert_id;
	}

	/**
	 * Update Data.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array $args
	 */
	public function update_options ( $args ) {
		global $wpdb;

		$data = array(
			'search_word'   => $args['search_word'],
			'search_count'  => (int) $args['search_count'] + 1,
			'register_date' => date( "Y-m-d H:i:s" ),
			'update_date'   => date( "Y-m-d H:i:s" )
		);
		$key = array( 'id' => $args['id'] );
		$prepared = array(
			'%s',
			'%d',
			'%s',
			'%s'
		);
		$key_prepared = array( '%d' );

		$wpdb->update( $this->table_name, $data, $key, $prepared, $key_prepared );
	}

	/**
	 * Delete Data.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   integer $id
	 */
	public function delete_options ( $id ) {
		global $wpdb;

		$key = array( 'id' => esc_html( $id ) );
		$key_prepared = array( '%d' );

		$wpdb->delete( $this->table_name, $key, $key_prepared );
	}
}