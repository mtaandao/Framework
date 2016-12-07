<?php
/**
 * Install plugin network administration panel.
 *
 * @package Mtaandao
 * @subpackage Multisite
 * @since 3.1.0
 */

if ( isset( $_GET['tab'] ) && ( 'plugin-information' == $_GET['tab'] ) )
	define( 'IFRAME_REQUEST', true );

/** Load Mtaandao Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( ! is_multisite() )
	mn_die( __( 'Multisite support is not enabled.' ) );

require( ABSPATH . 'admin/plugin-install.php' );
