<?php
/**
 * Dependencies API: Scripts functions
 *
 * @since 2.6.0
 *
 * @package Mtaandao
 * @subpackage Dependencies
 */

/**
 * Initialize $mn_scripts if it has not been set.
 *
 * @global MN_Scripts $mn_scripts
 *
 * @since 4.2.0
 *
 * @return MN_Scripts MN_Scripts instance.
 */
function mn_scripts() {
	global $mn_scripts;
	if ( ! ( $mn_scripts instanceof MN_Scripts ) ) {
		$mn_scripts = new MN_Scripts();
	}
	return $mn_scripts;
}

/**
 * Helper function to output a _doing_it_wrong message when applicable.
 *
 * @ignore
 * @since 4.2.0
 *
 * @param string $function Function name.
 */
function _mn_scripts_maybe_doing_it_wrong( $function ) {
	if ( did_action( 'init' ) ) {
		return;
	}

	_doing_it_wrong( $function, sprintf(
		__( 'Scripts and styles should not be registered or enqueued until the %1$s, %2$s, or %3$s hooks.' ),
		'<code>mn_enqueue_scripts</code>',
		'<code>admin_enqueue_scripts</code>',
		'<code>login_enqueue_scripts</code>'
	), '3.3.0' );
}

/**
 * Prints scripts in document head that are in the $handles queue.
 *
 * Called by admin-header.php and {@see 'mn_head'} hook. Since it is called by mn_head on every page load,
 * the function does not instantiate the MN_Scripts object unless script names are explicitly passed.
 * Makes use of already-instantiated $mn_scripts global if present. Use provided {@see 'mn_print_scripts'}
 * hook to register/enqueue new scripts.
 *
 * @see MN_Scripts::do_items()
 * @global MN_Scripts $mn_scripts The MN_Scripts object for printing scripts.
 *
 * @since 2.1.0
 *
 * @param string|bool|array $handles Optional. Scripts to be printed. Default 'false'.
 * @return array On success, a processed array of MN_Dependencies items; otherwise, an empty array.
 */
function mn_print_scripts( $handles = false ) {
	/**
	 * Fires before scripts in the $handles queue are printed.
	 *
	 * @since 2.1.0
	 */
	do_action( 'mn_print_scripts' );
	if ( '' === $handles ) { // for mn_head
		$handles = false;
	}

	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	global $mn_scripts;
	if ( ! ( $mn_scripts instanceof MN_Scripts ) ) {
		if ( ! $handles ) {
			return array(); // No need to instantiate if nothing is there.
		}
	}

	return mn_scripts()->do_items( $handles );
}

/**
 * Adds extra code to a registered script.
 *
 * Code will only be added if the script in already in the queue.
 * Accepts a string $data containing the Code. If two or more code blocks
 * are added to the same script $handle, they will be printed in the order
 * they were added, i.e. the latter added code can redeclare the previous.
 *
 * @since 4.5.0
 *
 * @see MN_Scripts::add_inline_script()
 *
 * @param string $handle   Name of the script to add the inline script to.
 * @param string $data     String containing the javascript to be added.
 * @param string $position Optional. Whether to add the inline script before the handle
 *                         or after. Default 'after'.
 * @return bool True on success, false on failure.
 */
function mn_add_inline_script( $handle, $data, $position = 'after' ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	if ( false !== stripos( $data, '</script>' ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf(
			/* translators: 1: <script>, 2: mn_add_inline_script() */
			__( 'Do not pass %1$s tags to %2$s.' ),
			'<code>&lt;script&gt;</code>',
			'<code>mn_add_inline_script()</code>'
		), '4.5.0' );
		$data = trim( preg_replace( '#<script[^>]*>(.*)</script>#is', '$1', $data ) );
	}

	return mn_scripts()->add_inline_script( $handle, $data, $position );
}

/**
 * Register a new script.
 *
 * Registers a script to be enqueued later using the mn_enqueue_script() function.
 *
 * @see MN_Dependencies::add()
 * @see MN_Dependencies::add_data()
 *
 * @since 2.1.0
 * @since 4.3.0 A return value was added.
 *
 * @param string           $handle    Name of the script. Should be unique.
 * @param string           $src       Full URL of the script, or path of the script relative to the Mtaandao root directory.
 * @param array            $deps      Optional. An array of registered script handles this script depends on. Default empty array.
 * @param string|bool|null $ver       Optional. String specifying script version number, if it has one, which is added to the URL
 *                                    as a query string for cache busting purposes. If version is set to false, a version
 *                                    number is automatically added equal to current installed Mtaandao version.
 *                                    If set to null, no version is added.
 * @param bool             $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
 *                                    Default 'false'.
 * @return bool Whether the script has been registered. True on success, false on failure.
 */
function mn_register_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
	$mn_scripts = mn_scripts();
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	$registered = $mn_scripts->add( $handle, $src, $deps, $ver );
	if ( $in_footer ) {
		$mn_scripts->add_data( $handle, 'group', 1 );
	}

	return $registered;
}

/**
 * Localize a script.
 *
 * Works only if the script has already been added.
 *
 * Accepts an associative array $l10n and creates a JavaScript object:
 *
 *     "$object_name" = {
 *         key: value,
 *         key: value,
 *         ...
 *     }
 *
 *
 * @see MN_Dependencies::localize()
 * @link https://core.trac.mtaandao.co.ke/ticket/11520
 * @global MN_Scripts $mn_scripts The MN_Scripts object for printing scripts.
 *
 * @since 2.2.0
 *
 * @todo Documentation cleanup
 *
 * @param string $handle      Script handle the data will be attached to.
 * @param string $object_name Name for the JavaScript object. Passed directly, so it should be qualified JS variable.
 *                            Example: '/[a-zA-Z0-9_]+/'.
 * @param array $l10n         The data itself. The data can be either a single or multi-dimensional array.
 * @return bool True if the script was successfully localized, false otherwise.
 */
function mn_localize_script( $handle, $object_name, $l10n ) {
	global $mn_scripts;
	if ( ! ( $mn_scripts instanceof MN_Scripts ) ) {
		_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );
		return false;
	}

	return $mn_scripts->localize( $handle, $object_name, $l10n );
}

/**
 * Remove a registered script.
 *
 * Note: there are intentional safeguards in place to prevent critical admin scripts,
 * such as jQuery core, from being unregistered.
 *
 * @see MN_Dependencies::remove()
 *
 * @since 2.1.0
 *
 * @param string $handle Name of the script to be removed.
 */
function mn_deregister_script( $handle ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	/**
	 * Do not allow accidental or negligent de-registering of critical scripts in the admin.
	 * Show minimal remorse if the correct hook is used.
	 */
	$current_filter = current_filter();
	if ( ( is_admin() && 'admin_enqueue_scripts' !== $current_filter ) ||
		( 'login.php' === $GLOBALS['pagenow'] && 'login_enqueue_scripts' !== $current_filter )
	) {
		$no = array(
			'jquery', 'jquery-core', 'jquery-migrate', 'jquery-ui-core', 'jquery-ui-accordion',
			'jquery-ui-autocomplete', 'jquery-ui-button', 'jquery-ui-datepicker', 'jquery-ui-dialog',
			'jquery-ui-draggable', 'jquery-ui-droppable', 'jquery-ui-menu', 'jquery-ui-mouse',
			'jquery-ui-position', 'jquery-ui-progressbar', 'jquery-ui-resizable', 'jquery-ui-selectable',
			'jquery-ui-slider', 'jquery-ui-sortable', 'jquery-ui-spinner', 'jquery-ui-tabs',
			'jquery-ui-tooltip', 'jquery-ui-widget', 'underscore', 'backbone',
		);

		if ( in_array( $handle, $no ) ) {
			$message = sprintf( __( 'Do not deregister the %1$s script in the administration area. To target the front-end theme, use the %2$s hook.' ),
				"<code>$handle</code>", '<code>mn_enqueue_scripts</code>' );
			_doing_it_wrong( __FUNCTION__, $message, '3.6.0' );
			return;
		}
	}

	mn_scripts()->remove( $handle );
}

/**
 * Enqueue a script.
 *
 * Registers the script if $src provided (does NOT overwrite), and enqueues it.
 *
 * @see MN_Dependencies::add()
 * @see MN_Dependencies::add_data()
 * @see MN_Dependencies::enqueue()
 *
 * @since 2.1.0
 *
 * @param string           $handle    Name of the script. Should be unique.
 * @param string           $src       Full URL of the script, or path of the script relative to the Mtaandao root directory.
 * @param array            $deps      Optional. An array of registered script handles this script depends on. Default empty array.
 * @param string|bool|null $ver       Optional. String specifying script version number, if it has one, which is added to the URL
 *                                    as a query string for cache busting purposes. If version is set to false, a version
 *                                    number is automatically added equal to current installed Mtaandao version.
 *                                    If set to null, no version is added.
 * @param bool             $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
 *                                    Default 'false'.
 */
function mn_enqueue_script( $handle, $src = false, $deps = array(), $ver = false, $in_footer = false ) {
	$mn_scripts = mn_scripts();

	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );


	if ( $src || $in_footer ) {
		$_handle = explode( '?', $handle );

		if ( $src ) {
			$mn_scripts->add( $_handle[0], $src, $deps, $ver );
		}

		if ( $in_footer ) {
			$mn_scripts->add_data( $_handle[0], 'group', 1 );
		}
	}

	$mn_scripts->enqueue( $handle );
}

/**
 * Remove a previously enqueued script.
 *
 * @see MN_Dependencies::dequeue()
 *
 * @since 3.1.0
 *
 * @param string $handle Name of the script to be removed.
 */
function mn_dequeue_script( $handle ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	mn_scripts()->dequeue( $handle );
}

/**
 * Check whether a script has been added to the queue.
 *
 * @since 2.8.0
 * @since 3.5.0 'enqueued' added as an alias of the 'queue' list.
 *
 * @param string $handle Name of the script.
 * @param string $list   Optional. Status of the script to check. Default 'enqueued'.
 *                       Accepts 'enqueued', 'registered', 'queue', 'to_do', and 'done'.
 * @return bool Whether the script is queued.
 */
function mn_script_is( $handle, $list = 'enqueued' ) {
	_mn_scripts_maybe_doing_it_wrong( __FUNCTION__ );

	return (bool) mn_scripts()->query( $handle, $list );
}

/**
 * Add metadata to a script.
 *
 * Works only if the script has already been added.
 *
 * Possible values for $key and $value:
 * 'conditional' string Comments for IE 6, lte IE 7, etc.
 *
 * @since 4.2.0
 *
 * @see MN_Dependency::add_data()
 *
 * @param string $handle Name of the script.
 * @param string $key    Name of data point for which we're storing a value.
 * @param mixed  $value  String containing the data to be added.
 * @return bool True on success, false on failure.
 */
function mn_script_add_data( $handle, $key, $value ){
	return mn_scripts()->add_data( $handle, $key, $value );
}
