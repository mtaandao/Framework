<?php

/**
 * Class for managing plugin assets
 */
class Sm_Assets {

	/**
	 * Set of queried assets
	 *
	 * @var array
	 */
	static $assets = array( 'css' => array(), 'js' => array() );

	/**
	 * Constructor
	 */
	function __construct() {
		// Register
		add_action( 'mn_head',                     array( __CLASS__, 'register' ) );
		add_action( 'admin_head',                  array( __CLASS__, 'register' ) );
		add_action( 'sm/generator/preview/before', array( __CLASS__, 'register' ) );
		add_action( 'sm/examples/preview/before',  array( __CLASS__, 'register' ) );
		// Enqueue
		add_action( 'mn_footer',                   array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_footer',                array( __CLASS__, 'enqueue' ) );
		// Print
		add_action( 'sm/generator/preview/after',  array( __CLASS__, 'prnt' ) );
		add_action( 'sm/examples/preview/after',   array( __CLASS__, 'prnt' ) );
		// Custom CSS
		add_action( 'mn_footer',                   array( __CLASS__, 'custom_css' ), 99 );
		add_action( 'sm/generator/preview/after',  array( __CLASS__, 'custom_css' ), 99 );
		add_action( 'sm/examples/preview/after',   array( __CLASS__, 'custom_css' ), 99 );
		// RTL support
		add_action( 'sm/assets/custom_css/after',        array( __CLASS__, 'rtl_shortcodes' ) );
		// Custom TinyMCE CSS and JS
		// add_filter( 'mce_css',                     array( __CLASS__, 'mce_css' ) );
		// add_filter( 'mce_external_plugins',        array( __CLASS__, 'mce_js' ) );
	}

	/**
	 * Register assets
	 */
	public static function register() {
		// Chart.js
		mn_register_script( 'chartjs', ( '/' .  RES . '/shortcodes/assets/js/chart.js'), false, '0.2', true );
		// SimpleSlider
		mn_register_script( 'simpleslider', ( '/' .  RES . '/shortcodes/assets/js/simpleslider.js' ), array( 'jquery' ), '1.0.0', true );
		mn_register_style( 'simpleslider', ( '/' .  RES . '/shortcodes/assets/css/simpleslider.css' ), false, '1.0.0', 'all' );
		// Owl Carousel
		mn_register_script( 'owl-carousel', ( '/' .  RES . '/shortcodes/assets/js/owl-carousel.js' ), array( 'jquery' ), '1.3.2', true );
		mn_register_style( 'owl-carousel', ( '/' .  RES . '/shortcodes/assets/css/owl-carousel.css' ), false, '1.3.2', 'all' );
		mn_register_style( 'owl-carousel-transitions', ( '/' .  RES . '/shortcodes/assets/css/owl-carousel-transitions.css' ), false, '1.3.2', 'all' );
		// Font Awesome
		mn_register_style( 'font-awesome', ( '/' .  RES . '/css/font-awesome.min.css'), false, '4.4.0', 'all' );
		// Animate.css
		mn_register_style( 'animate', ( '/' .  RES . '/shortcodes/assets/css/animate.css' ), false, '3.1.1', 'all' );
		// InView
		mn_register_script( 'inview', ( '/' .  RES . '/shortcodes/assets/js/inview.js' ), array( 'jquery' ), '2.1.1', true );
		// qTip
		mn_register_style( 'qtip', ( '/' .  RES . '/shortcodes/assets/css/qtip.css' ), false, '2.1.1', 'all' );
		mn_register_script( 'qtip', ( '/' .  RES . '/shortcodes/assets/js/qtip.js' ), array( 'jquery' ), '2.1.1', true );
		// jsRender
		mn_register_script( 'jsrender', ( '/' .  RES . '/shortcodes/assets/js/jsrender.js' ), array( 'jquery' ), '1.0.0-beta', true );
		// Magnific Popup
		mn_register_style( 'magnific-popup', ( '/' .  RES . '/shortcodes/assets/css/magnific-popup.css' ), false, '0.9.9', 'all' );
		mn_register_script( 'magnific-popup', ( '/' .  RES . '/shortcodes/assets/js/magnific-popup.js' ), array( 'jquery' ), '0.9.9', true );
		mn_localize_script( 'magnific-popup', 'sm_magnific_popup', array(
				'close'   => __( 'Close (Esc)', 'shortcodes' ),
				'loading' => __( 'Loading...', 'shortcodes' ),
				'prev'    => __( 'Previous (Left arrow key)', 'shortcodes' ),
				'next'    => __( 'Next (Right arrow key)', 'shortcodes' ),
				'counter' => sprintf( __( '%s of %s', 'shortcodes' ), '%curr%', '%total%' ),
				'error'   => sprintf( __( 'Failed to load this link. %sOpen link%s.', 'shortcodes' ), '<a href="%url%" target="_blank"><u>', '</u></a>' )
			) );
		// Ace
		mn_register_script( 'ace', ( '/' .  RES . '/shortcodes/assets/js/ace/ace.js' ), false, '1.1.3', true );
		// Swiper
		mn_register_script( 'swiper', ( '/' .  RES . '/shortcodes/assets/js/swiper.js' ), array( 'jquery' ), '2.6.1', true );
		// jPlayer
		mn_register_script( 'jplayer', ( '/' .  RES . '/shortcodes/assets/js/jplayer.js' ), array( 'jquery' ), '2.4.0', true );
		// Options page
		mn_register_style( 'sm-options-page', ( '/' .  RES . '/shortcodes/assets/css/options-page.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_script( 'sm-options-page', ( '/' .  RES . '/shortcodes/assets/js/options-page.js' ), array( 'magnific-popup', 'jquery-ui-sortable', 'ace', 'jsrender' ), SM_PLUGIN_VERSION, true );
		mn_localize_script( 'sm-options-page', 'sm_options_page', array(
				'upload_title'  => __( 'Choose files', 'shortcodes' ),
				'upload_insert' => __( 'Add selected files', 'shortcodes' ),
				'not_clickable' => __( 'This button is not clickable', 'shortcodes' )
			) );
		// Cheatsheet
		mn_register_style( 'sm-cheatsheet', ( '/' .  RES . '/shortcodes/assets/css/cheatsheet.css' ), false, SM_PLUGIN_VERSION, 'all' );
		// Generator
		mn_register_style( 'sm-generator', ( '/' .  RES . '/shortcodes/assets/css/generator.css' ), array( 'farbtastic', 'magnific-popup' ), SM_PLUGIN_VERSION, 'all' );
		mn_register_script( 'sm-generator', ( '/' .  RES . '/shortcodes/assets/js/generator.js' ), array( 'farbtastic', 'magnific-popup', 'qtip' ), SM_PLUGIN_VERSION, true );
		mn_localize_script( 'sm-generator', 'sm_generator', array(
				'upload_title'         => __( 'Choose file', 'shortcodes' ),
				'upload_insert'        => __( 'Insert', 'shortcodes' ),
				'isp_media_title'      => __( 'Select images', 'shortcodes' ),
				'isp_media_insert'     => __( 'Add selected images', 'shortcodes' ),
				'presets_prompt_msg'   => __( 'Please enter a name for new preset', 'shortcodes' ),
				'presets_prompt_value' => __( 'New preset', 'shortcodes' ),
				'last_used'            => __( 'Last used settings', 'shortcodes' ),
				'hotkey'               => get_option( 'sm_option_hotkey' )
			) );
		// Shortcodes stylesheets
		mn_register_style( 'sm-content-shortcodes', self::skin_url( 'content-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-box-shortcodes', self::skin_url( 'box-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-media-shortcodes', self::skin_url( 'media-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-other-shortcodes', self::skin_url( 'other-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-galleries-shortcodes', self::skin_url( 'galleries-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-players-shortcodes', self::skin_url( 'players-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		// RTL stylesheets
		mn_register_style( 'sm-rtl-shortcodes', self::skin_url( 'rtl-shortcodes.css' ), false, SM_PLUGIN_VERSION, 'all' );
		mn_register_style( 'sm-rtl-admin', self::skin_url( 'rtl-admin.css' ), false, SM_PLUGIN_VERSION, 'all' );
		// Shortcodes scripts
		mn_register_script( 'sm-galleries-shortcodes', ( '/' .  RES . '/shortcodes/assets/js/galleries-shortcodes.js' ), array( 'jquery', 'swiper' ), SM_PLUGIN_VERSION, true );
		mn_register_script( 'sm-players-shortcodes', ( '/' .  RES . '/shortcodes/assets/js/players-shortcodes.js' ), array( 'jquery', 'jplayer' ), SM_PLUGIN_VERSION, true );
		mn_register_script( 'sm-other-shortcodes', ( '/' .  RES . '/shortcodes/assets/js/other-shortcodes.js' ), array( 'jquery' ), SM_PLUGIN_VERSION, true );
		mn_localize_script( 'sm-other-shortcodes', 'sm_other_shortcodes', array( 'no_preview' => __( 'This shortcode doesn\'t work in live preview. Please insert it into editor and preview on the site.', 'shortcodes' ) ) );
		// Hook to deregister assets or add custom
		do_action( 'sm/assets/register' );
	}

	/**
	 * Enqueue assets
	 */
	public static function enqueue() {
		// Get assets query and plugin object
		$assets = self::assets();
		// Enqueue stylesheets
		foreach ( $assets['css'] as $style ) mn_enqueue_style( $style );
		// Enqueue scripts
		foreach ( $assets['js'] as $script ) mn_enqueue_script( $script );
		// Hook to dequeue assets or add custom
		do_action( 'sm/assets/enqueue', $assets );
	}

	/**
	 * Print assets without enqueuing
	 */
	public static function prnt() {
		// Prepare assets set
		$assets = self::assets();
		// Enqueue stylesheets
		mn_print_styles( $assets['css'] );
		// Enqueue scripts
		mn_print_scripts( $assets['js'] );
		// Hook
		do_action( 'sm/assets/print', $assets );
	}

	/**
	 * Print custom CSS
	 */
	public static function custom_css() {
		// Get custom CSS and apply filters to it
		$custom_css = apply_filters( 'sm/assets/custom_css', str_replace( '&#039;', '\'', html_entity_decode( (string) get_option( 'sm_option_custom-css' ) ) ) );
		// Print CSS if exists
		if ( $custom_css ) echo "\n\n<!-- Mtaandao Shortcodes custom CSS - begin -->\n<style type='text/css'>\n" . stripslashes( str_replace( array( '%design_url%', '%home_url%', '%plugin_url%' ), array( trailingslashit( get_stylesheet_directory_uri() ), trailingslashit( get_option( 'home' ) ), trailingslashit( ( '/' .  RES . '/shortcodes/' ) ) ), $custom_css ) ) . "\n</style>\n<!-- Mtaandao Shortcodes custom CSS - end -->\n\n";
		// Hook
		do_action( 'sm/assets/custom_css/after' );
	}

	/**
	 * Styles for visualised shortcodes
	 */
	public static function mce_css( $mce_css ) {
		if ( ! empty( $mce_css ) ) $mce_css .= ',';
		$mce_css .= ( '/' .  RES . '/shortcodes/assets/css/tinymce.css' );
		return $mce_css;
	}

	/**
	 * TinyMCE plugin for visualised shortcodes
	 */
	public static function mce_js( $plugins ) {
		$plugins['shortcodes'] = ( '/' .  RES . '/shortcodes/assets/js/tinymce.js' );
		return $plugins;
	}

	/**
	 * RTL support for shortcodes
	 */
	public static function rtl_shortcodes( $assets ) {
		// Check RTL
		if ( !is_rtl() ) return;
		// Add RTL stylesheets
		mn_print_styles( array( 'sm-rtl-shortcodes' ) );
	}

	/**
	 * RTL support for admin
	 */
	public static function rtl_admin( $assets ) {
		// Check RTL
		if ( !is_rtl() ) return;
		// Add RTL stylesheets
		self::add( 'css', 'sm-rtl-admin' );
	}

	/**
	 * Add asset to the query
	 */
	public static function add( $type, $handle ) {
		// Array with handles
		if ( is_array( $handle ) ) { foreach ( $handle as $h ) self::$assets[$type][$h] = $h; }
		// Single handle
		else self::$assets[$type][$handle] = $handle;
	}

	/**
	 * Get queried assets
	 */
	public static function assets() {
		// Get assets query
		$assets = self::$assets;
		// Apply filters to assets set
		$assets['css'] = array_unique( ( array ) apply_filters( 'sm/assets/css', ( array ) array_unique( $assets['css'] ) ) );
		$assets['js'] = array_unique( ( array ) apply_filters( 'sm/assets/js', ( array ) array_unique( $assets['js'] ) ) );
		// Return set
		return $assets;
	}

	/**
	 * Helper to get full URL of a skin file
	 */
	public static function skin_url( $file = '' ) {
		$shult = Mtaandao_Shortcodes();
		$skin = get_option( 'sm_option_skin' );
		$uploads = mn_upload_dir(); $uploads = $uploads['baseurl'];
		// Prepare url to skin directory
		$url = ( !$skin || $skin === 'default' ) ? ( '/' .  RES . '/shortcodes/assets/css/' ) : $uploads . '/shortcodes-skins/' . $skin;
		return trailingslashit( apply_filters( 'sm/assets/skin', $url ) ) . $file;
	}
}

new Sm_Assets;

/**
 * Helper function to add asset to the query
 *
 * @param string  $type   Asset type (css|js)
 * @param mixed   $handle Asset handle or array with handles
 */
function sm_query_asset( $type, $handle ) {
	Sm_Assets::add( $type, $handle );
}

/**
 * Helper function to get current skin url
 *
 * @param string  $file Asset file name. Example value: box-shortcodes.css
 */
function sm_skin_url( $file ) {
	return Sm_Assets::skin_url( $file );
}
