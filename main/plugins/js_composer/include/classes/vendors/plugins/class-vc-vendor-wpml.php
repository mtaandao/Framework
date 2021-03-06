<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class Vc_Vendor_MNML
 * @since 4.9
 */
class Vc_Vendor_MNML implements Vc_Vendor_Interface {

	public function load() {
		add_filter( 'vc_object_id', array(
			$this,
			'filterMediaId',
		) );

		add_filter( 'vc_basic_grid_filter_query_suppress_filters', '__return_false' );

		add_filter( 'vc_frontend_editor_iframe_url', array(
			$this,
			'appendLangToUrl',
		) );
		add_filter( 'vc_grid_request_url', array(
			$this,
			'appendLangToUrl',
		) );
		add_filter( 'vc_admin_url', array(
			$this,
			'appendLangToUrl',
		) );
		if ( ! vc_is_frontend_editor() ) {
			add_filter( 'vc_get_inline_url', array(
				$this,
				'appendLangToUrl',
			) );
		}

		global $sitepress;
		$action = vc_post_param( 'action' );
		if ( vc_is_page_editable() && 'vc_frontend_load_template' === $action ) {
			// Fix Issue with loading template #135512264670405
			remove_action( 'mn_loaded', array( $sitepress, 'maybe_set_this_lang' ) );
		}
	}

	public function appendLangToUrl( $link ) {
		global $sitepress;
		if ( is_object( $sitepress ) ) {
			if ( is_string( $link ) && strpos( $link, 'lang' ) === false && ( strpos( $link, 'vc_inline' ) !== false || strpos( $link, 'vc_editable' ) !== false || strpos( $link, 'admin-ajax' ) !== false ) ) {
				return add_query_arg( array( 'lang' => $sitepress->get_current_language() ), $link );
			}
		}

		return $link;
	}

	public function filterMediaId( $id ) {
		return apply_filters( 'mnml_object_id', $id, 'post', true );
	}
}
