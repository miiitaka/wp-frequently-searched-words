<?php
/*
Plugin Name: Frequently Searched Words
Plugin URI: https://github.com/miiitaka/wp-frequently-searched-words
Description: It is possible to register and display frequently searched words in site search.
Version: 1.1.2
Author: Kazuya Takami
Author URI: https://www.terakoya.work/
License: GPLv2 or later
Text Domain: wp-frequently-searched-words
Domain Path: /languages
*/
require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-frequently-searched-words-admin-db.php' );

new Frequently_Searched_Words();

/**
 * Frequently Searched Words Basic Class
 *
 * @author  Kazuya Takami
 * @version 2.0.0
 * @since   1.0.0
 */
class Frequently_Searched_Words {

	/**
	 * Variable definition: text domain
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-frequently-searched-words';

	/**
	 * Variable definition: plugin version
	 *
	 * @version 1.1.2
	 * @since   1.0.0
	 */
	private $version = '1.1.2';

	/**
	 * Constructor Define.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	public function __construct () {
		register_activation_hook( __FILE__, array( $this, 'create_table' ) );
		add_shortcode( $this->text_domain, array( $this, 'short_code_init' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_action_links' ) );
		} else {
			add_action( 'wp_footer', array( $this, 'search_post_update' ) );
		}
	}

	/**
	 * Create table.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function create_table () {
		$db = new Frequently_Searched_Words_Admin_Db();
		$db->create_table();
	}

	/**
	 * ShortCode Register.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   array  $args short code params
	 * @return  string
	 */
	public function short_code_init ( $args ) {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-frequently-search-words-admin-short-code.php' );
		$obj = new Frequently_Searched_Words_ShortCode();
		return $obj->short_code_display( $args );
	}

	/**
	 * i18n.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function plugins_loaded () {
		load_plugin_textdomain( $this->text_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * admin init.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function admin_init () {
		wp_register_style( 'wp-frequently-search-words-admin-style', plugins_url( 'css/style.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Add Menu to the Admin Screen.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function admin_menu () {
		$list_page = add_menu_page(
			esc_html__( 'Frequently Searched Words', $this->text_domain ),
			esc_html__( 'Search Words',              $this->text_domain ),
			'manage_options',
			plugin_basename( __FILE__ ),
			array( $this, 'list_page_render' ),
			'dashicons-search'
		);
		add_action( 'admin_print_styles-' . $list_page, array( $this, 'add_style' ) );
	}

	/**
	 * Add Menu to the Admin Screen.
	 *
	 * @version 1.0.6
	 * @since   1.0.6
	 * @param   array  $links
	 * @return  array  $links
	 */
	public function plugin_action_links( $links ) {
		$url = admin_url( 'admin.php?page=' . $this->text_domain . '/' . $this->text_domain . '.php' );
		$url = '<a href="' . esc_url( $url ) . '">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $url );
		return $links;
	}

	/**
	 * CSS admin add.
	 *
	 * @since 1.0.0
	 */
	public function add_style () {
		wp_enqueue_style( 'wp-frequently-search-words-admin-style' );
	}

	/**
	 * Admin List Page Template Require.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	public function list_page_render () {
		require_once( plugin_dir_path( __FILE__ ) . 'includes/wp-frequently-searched-words-admin-list.php' );
		new Frequently_Searched_Words_List( $this->text_domain );
	}

	/**
	 * Search Post Update.
	 *
	 * @version 2.0.0
	 * @since   1.0.0
	 */
	public function search_post_update () {
		if ( is_search() ) {
			$search_word = mb_convert_kana( get_search_query(), "as", "UTF-8" );
			$search_word = esc_html( trim( $search_word ) );

			$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

			if ( have_posts() && !empty( $search_word ) && $paged === 1 ) {
				$db = new Frequently_Searched_Words_Admin_Db();

				$args = explode( " ", $search_word );

				foreach ( $args as $value ) {
					$result = $db->get_options( urldecode( $value ) );

					if ( empty( $result ) ) {
						$db->insert_options( urldecode( $value ) );
					} else {
						$db->update_options( $result );
					}
				}
			}
			wp_reset_query();
		}
	}
}