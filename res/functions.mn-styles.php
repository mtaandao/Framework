<?php
/**
 * Dependencies API: Styles functions
 *
 * @since 2.6.0
 *
 * @package Mtaandao
 * @subpackage Dependencies
 */

/**
 * Initialize $mn_styles if it has not been set.
 *
 * @global MN_Styles $mn_styles
 *
 * @since 4.2.0
 *
 * @return MN_Styles MN_Styles instance.
 */
function mn_styles() {
	global $mn_styles;
	if ( ! ( $mn_styles instanceof MN_Styles ) ) {
		$mn_styles = new MN_Styles();
	}
	return $mn_styles;
}

/**
 * Display styles that are in the $handles queue.
 *
 * Passing an empty array to $handles prints the queue,
 * passing an array with one string prints that style,
 * and passing an array of strings prints those styles.
 *
 * @global MN_Styles $mn_styles The MN_Styles object for printing styles.
 *
 * @since 2.6.0
 *
 * @param string|bool|array $handles Styles to be printed. Default 'false'.
 * @return array On success, a processed array of MN_Dependencies items; otherwise, an empty array.
 */
function mn_print_styles( $handles = false ) {
	if ( '' === $handles ) { // for mn_head
		$handles = false;
	}
	/**
	 * Fires before styles in the $handles queue are printed.
	 *
	 * @since 2.6.0
	 */
	if ( ! $handles ) {
		do_action( 'mn_print_styles' );
	}

	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	global $mn_styles;
	if ( ! ( $mn_styles instanceof MN_Styles ) ) {
		if ( ! $handles ) {
			return array(); // No need to instantiate if nothing is there.
		}
	}

	return mn_styles()->do_items( $handles );
}

/**
 * Add extra CSS styles to a registered stylesheet.
 *
 * Styles will only be added if the stylesheet in already in the queue.
 * Accepts a string $data containing the CSS. If two or more CSS code blocks
 * are added to the same stylesheet $handle, they will be printed in the order
 * they were added, i.e. the latter added styles can redeclare the previous.
 *
 * @see MN_Styles::add_inline_style()
 *
 * @since 3.3.0
 *
 * @param string $handle Name of the stylesheet to add the extra styles to.
 * @param string $data   String containing the CSS styles to be added.
 * @return bool True on success, false on failure.
 */
function mn_add_inline_style( $handle, $data ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	if ( false !== stripos( $data, '</style>' ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf(
			/* translators: 1: <style>, 2: mn_add_inline_style() */
			__( 'Do not pass %1$s tags to %2$s.' ),
			'<code>&lt;style&gt;</code>',
			'<code>mn_add_inline_style()</code>'
		), '3.7.0' );
		$data = trim( preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $data ) );
	}

	return mn_styles()->add_inline_style( $handle, $data );
}

/**
 * Register a CSS stylesheet.
 *
 * @see MN_Dependencies::add()
 * @link https://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
 *
 * @since 2.6.0
 * @since 4.3.0 A return value was added.
 *
 * @param string           $handle Name of the stylesheet. Should be unique.
 * @param string           $src    Full URL of the stylesheet, or path of the stylesheet relative to the Mtaandao root directory.
 * @param array            $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
 * @param string|bool|null $ver    Optional. String specifying stylesheet version number, if it has one, which is added to the URL
 *                                 as a query string for cache busting purposes. If version is set to false, a version
 *                                 number is automatically added equal to current installed Mtaandao version.
 *                                 If set to null, no version is added.
 * @param string           $media  Optional. The media for which this stylesheet has been defined.
 *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
 *                                 '(orientation: portrait)' and '(max-width: 640px)'.
 * @return bool Whether the style has been registered. True on success, false on failure.
 */
function mn_register_style( $handle, $src, $deps = array(), $ver = false, $media = 'all' ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	return mn_styles()->add( $handle, $src, $deps, $ver, $media );
}

/**
 * Remove a registered stylesheet.
 *
 * @see MN_Dependencies::remove()
 *
 * @since 2.1.0
 *
 * @param string $handle Name of the stylesheet to be removed.
 */
function mn_deregister_style( $handle ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	mn_styles()->remove( $handle );
}

/**
 * Enqueue a CSS stylesheet.
 *
 * Registers the style if source provided (does NOT overwrite) and enqueues.
 *
 * @see MN_Dependencies::add()
 * @see MN_Dependencies::enqueue()
 * @link https://www.w3.org/TR/CSS2/media.html#media-types List of CSS media types.
 *
 * @since 2.6.0
 *
 * @param string           $handle Name of the stylesheet. Should be unique.
 * @param string           $src    Full URL of the stylesheet, or path of the stylesheet relative to the Mtaandao root directory.
 *                                 Default empty.
 * @param array            $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
 * @param string|bool|null $ver    Optional. String specifying stylesheet version number, if it has one, which is added to the URL
 *                                 as a query string for cache busting purposes. If version is set to false, a version
 *                                 number is automatically added equal to current installed Mtaandao version.
 *                                 If set to null, no version is added.
 * @param string           $media  Optional. The media for which this stylesheet has been defined.
 *                                 Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
 *                                 '(orientation: portrait)' and '(max-width: 640px)'.
 */
function mn_enqueue_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	$mn_styles = mn_styles();

	if ( $src ) {
		$_handle = explode('?', $handle);
		$mn_styles->add( $_handle[0], $src, $deps, $ver, $media );
	}
	$mn_styles->enqueue( $handle );
}

/**
 * Remove a previously enqueued CSS stylesheet.
 *
 * @see MN_Dependencies::dequeue()
 *
 * @since 3.1.0
 *
 * @param string $handle Name of the stylesheet to be removed.
 */
function mn_dequeue_style( $handle ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	mn_styles()->dequeue( $handle );
}

/**
 * Check whether a CSS stylesheet has been added to the queue.
 *
 * @since 2.8.0
 *
 * @param string $handle Name of the stylesheet.
 * @param string $list   Optional. Status of the stylesheet to check. Default 'enqueued'.
 *                       Accepts 'enqueued', 'registered', 'queue', 'to_do', and 'done'.
 * @return bool Whether style is queued.
 */
function mn_style_is( $handle, $list = 'enqueued' ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	return (bool) mn_styles()->query( $handle, $list );
}

/**
 * Add metadata to a CSS stylesheet.
 *
 * Works only if the stylesheet has already been added.
 *
 * Possible values for $key and $value:
 * 'conditional' string      Comments for IE 6, lte IE 7 etc.
 * 'rtl'         bool|string To declare an RTL stylesheet.
 * 'suffix'      string      Optional suffix, used in combination with RTL.
 * 'alt'         bool        For rel="alternate stylesheet".
 * 'title'       string      For preferred/alternate stylesheets.
 *
 * @see MN_Dependency::add_data()
 *
 * @since 3.6.0
 *
 * @param string $handle Name of the stylesheet.
 * @param string $key    Name of data point for which we're storing a value.
 *                       Accepts 'conditional', 'rtl' and 'suffix', 'alt' and 'title'.
 * @param mixed  $value  String containing the CSS data to be added.
 * @return bool True on success, false on failure.
 */
function mn_style_add_data( $handle, $key, $value ) {
	return mn_styles()->add_data( $handle, $key, $value );
}
