<?php
/**
 * WooCommerce Uninstall
 *
 * Uninstalling WooCommerce deletes user roles, pages, tables, and options.
 *
 * @author      WooThemes
 * @category    Core
 * @package     WooCommerce/Uninstaller
 * @version     2.3.0
 */

if ( ! defined( 'MN_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $mndb, $mn_version;

mn_clear_scheduled_hook( 'woocommerce_scheduled_sales' );
mn_clear_scheduled_hook( 'woocommerce_cancel_unpaid_orders' );
mn_clear_scheduled_hook( 'woocommerce_cleanup_sessions' );
mn_clear_scheduled_hook( 'woocommerce_geoip_updater' );
mn_clear_scheduled_hook( 'woocommerce_tracker_send_event' );

$status_options = get_option( 'woocommerce_status_options', array() );

if ( ! empty( $status_options['uninstall_data'] ) ) {
	// Roles + caps.
	include_once( 'includes/class-wc-install.php' );
	WC_Install::remove_roles();

	// Pages.
	mn_trash_post( get_option( 'woocommerce_shop_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_cart_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_checkout_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_myaccount_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_edit_address_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_view_order_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_change_password_page_id' ) );
	mn_trash_post( get_option( 'woocommerce_logout_page_id' ) );

	if ( $mndb->get_var( "SHOW TABLES LIKE '{$mndb->prefix}woocommerce_attribute_taxonomies';" ) ) {
		$wc_attributes = array_filter( (array) $mndb->get_col( "SELECT attribute_name FROM {$mndb->prefix}woocommerce_attribute_taxonomies;" ) );
	} else {
		$wc_attributes = array();
	}

	// Tables.
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_api_keys" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_attribute_taxonomies" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_downloadable_product_permissions" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_termmeta" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_tax_rates" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_tax_rate_locations" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_shipping_zone_methods" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_shipping_zone_locations" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_shipping_zones" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_sessions" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_payment_tokens" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_payment_tokenmeta" );

	// Delete options.
	$mndb->query("DELETE FROM $mndb->options WHERE option_name LIKE 'woocommerce\_%';");

	// Delete posts + data.
	$mndb->query( "DELETE FROM {$mndb->posts} WHERE post_type IN ( 'product', 'product_variation', 'shop_coupon', 'shop_order', 'shop_order_refund' );" );
	$mndb->query( "DELETE meta FROM {$mndb->postmeta} meta LEFT JOIN {$mndb->posts} posts ON posts.ID = meta.post_id WHERE posts.ID IS NULL;" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_order_items" );
	$mndb->query( "DROP TABLE IF EXISTS {$mndb->prefix}woocommerce_order_itemmeta" );

	// Delete terms if > MN 4.2 (term splitting was added in 4.2)
	if ( version_compare( $mn_version, '4.2', '>=' ) ) {
		// Delete term taxonomies
		foreach ( array( 'product_cat', 'product_tag', 'product_shipping_class', 'product_type' ) as $taxonomy ) {
			$mndb->delete(
				$mndb->term_taxonomy,
				array(
					'taxonomy' => $taxonomy,
				)
			);
		}

		// Delete term attributes
		foreach ( $wc_attributes as $taxonomy ) {
			$mndb->delete(
				$mndb->term_taxonomy,
				array(
					'taxonomy' => 'pa_' . $taxonomy,
				)
			);
		}

		// Delete orphan relationships
		$mndb->query( "DELETE tr FROM {$mndb->term_relationships} tr LEFT JOIN {$mndb->posts} posts ON posts.ID = tr.object_id WHERE posts.ID IS NULL;" );

		// Delete orphan terms
		$mndb->query( "DELETE t FROM {$mndb->terms} t LEFT JOIN {$mndb->term_taxonomy} tt ON t.term_id = tt.term_id WHERE tt.term_id IS NULL;" );

		// Delete orphan term meta
		if ( ! empty( $mndb->termmeta ) ) {
			$mndb->query( "DELETE tm FROM {$mndb->termmeta} tm LEFT JOIN {$mndb->term_taxonomy} tt ON tm.term_id = tt.term_id WHERE tt.term_id IS NULL;" );
		}
	}

	// Clear any cached data that has been removed
	mn_cache_flush();
}
