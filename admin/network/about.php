<?php
/**
 * Network About administration panel.
 *
 * @package Mtaandao
 * @subpackage Multisite
 * @since 3.4.0
 */

/** Load Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! is_multisite() )
	mn_die( __( 'Multisite support is not enabled.' ) );

require( ABSPATH . 'admin/about.php' );
