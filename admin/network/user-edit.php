<?php
/**
 * Edit user network administration panel.
 *
 * @package Mtaandao
 * @subpackage Multisite
 * @since 3.1.0
 */

/** Load Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! is_multisite() )
	mn_die( __( 'Multisite support is not enabled.' ) );

require( ABSPATH . 'admin/user-edit.php' );
