<?php
/**
 * Frequently Searched Words List
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Frequently_Searched_Words_List {

	/**
	 * Variable definition: text domain
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain;

	/**
	 * Constructor Define.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   String $text_domain
	 */
	public function __construct ( $text_domain ) {
		$this->text_domain = $text_domain;

		$db = new Frequently_Searched_Words_Admin_Db();
		$mode = "";

		if ( isset( $_GET['mode'] ) && $_GET['mode'] === 'delete' ) {
			if ( isset( $_GET['frequently_searched_words_id'] ) && is_numeric( $_GET['frequently_searched_words_id'] ) ) {
				$db->delete_options( $_GET['frequently_searched_words_id'] );
				$mode = "delete";
			}
		}

		$this->page_render( $db, $mode );
	}

	/**
	 * Settings Page HTML Render.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @param   Frequently_Searched_Words_Admin_Db $db
	 * @param   String $mode
	 */
	private function page_render ( Frequently_Searched_Words_Admin_Db $db, $mode = "" ) {
		$self_url = $_SERVER['PHP_SELF'] . '?' . esc_html( $_SERVER['QUERY_STRING'] );

		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>' . esc_html__( 'Frequently Searched Words List', $this->text_domain ) . '</h1>';
		echo $html;

		if ( $mode === "delete" ) {
			$this->information_render();
		}

		$html  = '<hr>';
		$html .= '<table class="wp-list-table widefat fixed striped posts">';
		$html .= '<tr>';
		$html .= '<th scope="row">' . esc_html__( 'Search Word',  $this->text_domain ) . '</th>';
		$html .= '<th scope="row">' . esc_html__( 'Search Count', $this->text_domain ) . '</th>';
		$html .= '<th scope="row">&nbsp;</th>';
		$html .= '<th scope="row">&nbsp;</th>';
		$html .= '</tr>';
		echo $html;

		/** DB table get list */
		$results = $db->get_list_options();

		if ( $results ) {
			foreach ( $results as $row ) {
				$html  = '';
				$html .= '<tr>';
				$html .= '<td>' . esc_html( $row->search_word )  . '</td>';
				$html .= '<td>' . esc_html( $row->search_count ) . '</td>';
				$html .= '<td>';
				$html .= '<a href="' . $self_url . '&mode=delete&frequently_searched_words_id=' . esc_html( $row->id ) . '">';
				$html .= esc_html__( 'Delete', $this->text_domain );
				$html .= '</a>';
				$html .= '</td>';
				$html .= '<td>&nbsp;</td>';
				$html .= '</tr>';
				echo $html;
			}
		} else {
			echo '<td colspan="4">' . esc_html__( 'Without registration.', $this->text_domain ) . '</td>';
		}

		$html  = '</table>';
		$html .= '</div>';
		echo $html;
	}


	/**
	 * Information Message Render
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>Deletion succeeds.</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">Dismiss this notice.</span>';
		$html .= '</button>';
		$html .= '</div>';

		echo $html;
	}
}