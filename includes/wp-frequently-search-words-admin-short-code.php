<?php
/**
 * Admin ShortCode Settings
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 */
class Frequently_Searched_Words_ShortCode {

	/**
	 * ShortCode Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array  $args
	 * @return  string $html
	 */
	public function short_code_display ( $args ) {
		extract( shortcode_atts( array (
			'id'    => "",
			'class' => "",
			'limit' => 10
		), $args ) );

		$instance = array(
			'id'    => $id,
			'class' => $class,
			'limit' => $limit
		);

		/** DB Connect */
		$db      = new Frequently_Searched_Words_Admin_Db();
		$results = $db->get_list_options( $limit );
		$html    = '';

		if ( $results ) {
			if ( $id !== "" && $class !== "" ) {
				$html = '<ul id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">';
			} elseif ( $id !== "" && $class === "" ) {
				$html = '<ul id="' . esc_attr( $id ) . '">';
			} elseif ( $id === "" && $class !== "" ) {
				$html = '<ul class="' . esc_attr( $class ) . '">';
			} else {
				$html = "<ul>";
			}
			foreach ( $results as $row ) {
				$html .= '<li>' . esc_html( $row->search_word )  . '</li>';
			}
			$html .= "</ul>";
		}
		return (string) $html;
	}
}