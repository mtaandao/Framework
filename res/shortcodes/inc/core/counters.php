<?php

class Sm_Counter_Extra_Addon {

	static $option = 'sm_counter_extra_addon';

	function __construct() {
		add_filter( 'sm/menu/shortcodes',  array( __CLASS__, 'display' ) );
		add_filter( 'sm/menu/addons',      array( __CLASS__, 'display' ) );
		add_action( 'sunrise/page/before', array( __CLASS__, 'disable' ) );
	}

	public static function display( $title ) {
		if ( get_option( self::$option ) ) return $title;
		return sprintf(
			'%s <span class="update-plugins count-1" title="%s"><span class="update-count">%s</span></span>',
			$title,
			__( '1 new add-on for Mtaandao Shortcodes', 'shortcodes' ),
			'1'
		);
	}

	public static function disable() {
		if ( $_GET['page'] === 'shortcodes-addons' ) update_option( self::$option, true );
	}
}

// new Sm_Counter_Extra_Addon;

class Sm_Counter_Bundle {

	static $option = 'sm_counter_bundle';

	function __construct() {
		add_filter( 'sm/menu/shortcodes',  array( __CLASS__, 'display' ) );
		add_filter( 'sm/menu/addons',      array( __CLASS__, 'display' ) );
		add_action( 'sunrise/page/before', array( __CLASS__, 'disable' ) );
	}

	public static function display( $title ) {
		if ( get_option( self::$option ) ) return $title;
		return sprintf(
			'%s <span class="update-plugins count-1" title="%s"><span class="update-count">%s</span></span>',
			$title,
			__( '1 new add-on for Mtaandao Shortcodes', 'shortcodes' ),
			'1'
		);
	}

	public static function disable() {
		if ( $_GET['page'] === 'shortcodes-addons' ) update_option( self::$option, true );
	}
}

// new Sm_Counter_Bundle;
