<?php
class Mtaandao_Shortcodes {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'plugins_loaded',             array( __CLASS__, 'init' ) );
		add_action( 'init',                       array( __CLASS__, 'register' ) );
		add_action( 'init',                       array( __CLASS__, 'update' ), 20 );
		register_activation_hook( SM_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_activation_hook( SM_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Make plugin available for translation
		load_plugin_textdomain( 'shortcodes', false, ABSPATH . RES. '/shortcodes' . '/languages' . '/' );
		// Setup admin class
		$admin = new Sunrise4( array(
				'file'       => SM_PLUGIN_FILE,
				'slug'       => 'sm',
				'prefix'     => 'sm_option_',
				'textdomain' => 'sm'
			) );
		// Top-level menu
		$admin->add_menu( array(
				'page_title'  => __( 'Settings', 'shortcodes' ) . ' &lsaquo; ' . __( 'Mtaandao Shortcodes', 'shortcodes' ),
				'menu_title'  => apply_filters( 'sm/menu/shortcodes', __( 'Shortcodes', 'shortcodes' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'shortcodes',
				'icon_url'    => 'dashicons-editor-code',
				'position'    => '80.11',
				'options'     => array(
					array(
						'type' => 'opentab',
						'name' => __( 'About', 'shortcodes' )
					),
					array(
						'type'     => 'about',
						'callback' => array( 'Sm_Admin_Views', 'about' )
					),
					array(
						'type'    => 'closetab',
						'actions' => false
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Settings', 'shortcodes' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'custom-formatting',
						'name'    => __( 'Custom formatting', 'shortcodes' ),
						'desc'    => __( 'Disable this option if you have some problems with other plugins or content formatting', 'shortcodes' ) . '<br /><a href="http://mtaandao.co.ke/kb/custom-formatting/" target="_blank">' . __( 'Documentation article', 'shortcodes' ) . '</a>',
						'default' => 'on',
						'label'   => __( 'Enabled', 'shortcodes' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'skip',
						'name'    => __( 'Skip default values', 'shortcodes' ),
						'desc'    => __( 'Enable this option and the generator will insert a shortcode without default attribute values that you have not changed. As a result, the generated code will be shorter.', 'shortcodes' ),
						'default' => 'on',
						'label'   => __( 'Enabled', 'shortcodes' )
					),
					array(
						'type'    => 'text',
						'id'      => 'prefix',
						'name'    => __( 'Shortcodes prefix', 'shortcodes' ),
						'desc'    => sprintf( __( 'This prefix will be added to all shortcodes by this plugin. For example, type here %s and you\'ll get shortcodes like %s and %s. Please keep in mind: this option is not affects your already inserted shortcodes and if you\'ll change this value your old shortcodes will be broken', 'shortcodes' ), '<code>sm_</code>', '<code>[sm_button]</code>', '<code>[sm_column]</code>' ),
						'default' => 'sm_'
					),
					array(
						'type'    => 'text',
						'id'      => 'hotkey',
						'name'    => __( 'Insert shortcode Hotkey', 'shortcodes' ),
						'desc'    => sprintf( '%s<br><a href="https://rawgit.com/jeresig/jquery.hotkeys/master/test-static-01.html" target="_blank">%s</a> | <a href="https://github.com/jeresig/jquery.hotkeys#notes" target="_blank">%s</a>', __( 'Here you can define custom hotkey for the Insert shortcode popup window. Leave this field empty to disable hotkey', 'shortcodes' ), __( 'Hotkey examples', 'shortcodes' ), __( 'Additional notes', 'shortcodes' ) ),
						'default' => 'alt+i'
					),
					array(
						'type'    => 'hidden',
						'id'      => 'skin',
						'name'    => __( 'Skin', 'shortcodes' ),
						'desc'    => __( 'Choose global skin for shortcodes', 'shortcodes' ),
						'default' => 'default'
					),
					array(
						'type' => 'closetab'
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Custom CSS', 'shortcodes' )
					),
					array(
						'type'     => 'custom_css',
						'id'       => 'custom-css',
						'default'  => '',
						'callback' => array( 'Sm_Admin_Views', 'custom_css' )
					),
					array(
						'type' => 'closetab'
					)
				)
			) );
		// Settings submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes',
				'page_title'  => __( 'Settings', 'shortcodes' ) . ' &lsaquo; ' . __( 'Mtaandao Shortcodes', 'shortcodes' ),
				'menu_title'  => apply_filters( 'sm/menu/settings', __( 'Settings', 'shortcodes' ) ),
				'capability'  => 'manage_options',
				'slug'        => 'shortcodes',
				'options'     => array()
			) );
		// Examples submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes',
				'page_title'  => __( 'Examples', 'shortcodes' ) . ' &lsaquo; ' . __( 'Mtaandao Shortcodes', 'shortcodes' ),
				'menu_title'  => apply_filters( 'sm/menu/examples', __( 'Examples', 'shortcodes' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-examples',
				'options'     => array(
					array(
						'type' => 'examples',
						'callback' => array( 'Sm_Admin_Views', 'examples' )
					)
				)
			) );
		// Cheatsheet submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes',
				'page_title'  => __( 'Cheatsheet', 'shortcodes' ) . ' &lsaquo; ' . __( 'Mtaandao Shortcodes', 'shortcodes' ),
				'menu_title'  => apply_filters( 'sm/menu/examples', __( 'Cheatsheet', 'shortcodes' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-cheatsheet',
				'options'     => array(
					array(
						'type' => 'cheatsheet',
						'callback' => array( 'Sm_Admin_Views', 'cheatsheet' )
					)
				)
			) );
		// Add-ons submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes',
				'page_title'  => __( 'Add-ons', 'shortcodes' ) . ' &lsaquo; ' . __( 'Mtaandao Shortcodes', 'shortcodes' ),
				'menu_title'  => apply_filters( 'sm/menu/addons', __( 'Add-ons', 'shortcodes' ) ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-addons',
				'options'     => array(
					array(
						'type' => 'addons',
						'callback' => array( 'Sm_Admin_Views', 'addons' )
					)
				)
			) );
		// Translate plugin meta
		__( 'Mtaandao Shortcodes', 'shortcodes' );
		__( 'Mtaandao', 'shortcodes' );
		__( 'Supercharge your Mtaandao design with mega pack of shortcodes', 'shortcodes' );
		// Add plugin actions links
		add_filter( 'plugin_action_links_' . plugin_basename( SM_PLUGIN_FILE ), array( __CLASS__, 'actions_links' ), -10 );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
		// Mtaandao Shortcodes is ready
		do_action( 'sm/init' );
	}
	/**
	 * Register shortcodes
	 */
	public static function register() {
		// Prepare compatibility mode prefix
		$prefix = sm_cmpt();
		// Loop through shortcodes
		foreach ( ( array ) Sm_Data::shortcodes() as $id => $data ) {
			if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) $func = $data['function'];
			elseif ( is_callable( array( 'Sm_Shortcodes', $id ) ) ) $func = array( 'Sm_Shortcodes', $id );
			elseif ( is_callable( array( 'Sm_Shortcodes', 'sm_' . $id ) ) ) $func = array( 'Sm_Shortcodes', 'sm_' . $id );
			else continue;
			// Register shortcode
			add_shortcode( $prefix . $id, $func );
		}
		// Register [media] manually // 3.x
		add_shortcode( $prefix . 'media', array( 'Sm_Shortcodes', 'media' ) );
	}

	/**
	 * Add timestamp
	 */
	public static function timestamp() {
		if ( !get_option( 'sm_installed' ) ) update_option( 'sm_installed', time() );
	}

	/**
	 * Add plugin actions links
	 */
	public static function actions_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=shortcodes-examples' ) . '">' . __( 'Examples', 'shortcodes' ) . '</a>';
		$links[] = '<a href="' . admin_url( 'admin.php?page=shortcodes' ) . '#tab-0">' . __( 'Where to start?', 'shortcodes' ) . '</a>';
		return $links;
	}

	/**
	 * Add plugin meta links
	 */
	public static function meta_links( $links, $file ) {
		// Check plugin
		if ( $file === plugin_basename( SM_PLUGIN_FILE ) ) {
			unset( $links[2] );
			$links[] = '<a href="http://mtaandao.co.ke/plugins/shortcodes/" target="_blank">' . __( 'Project homepage', 'shortcodes' ) . '</a>';
			$links[] = '<a href="http://mtaandao.co.ke/support/plugin/shortcodes/" target="_blank">' . __( 'Support forum', 'shortcodes' ) . '</a>';
			$links[] = '<a href="http://mtaandao.co.ke/extend/plugins/shortcodes/changelog/" target="_blank">' . __( 'Changelog', 'shortcodes' ) . '</a>';
		}
		return $links;
	}
}

/**
 * Register plugin function to perform checks that plugin is installed
 */
function Mtaandao_Shortcodes() {
	return true;
}

new Mtaandao_Shortcodes;
