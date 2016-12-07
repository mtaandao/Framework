<?php
/*
Plugin Name: Branding
Plugin URI: http://sevenbold.com/mtaandao/custom-branding/
Description: Custom Branding is a powerful Mtaandao admin theme plugin that reimagines Mtaandao with a clean and simplified design. White label your Mtaandao install with custom colors, a custom login screen, custom admin branding, and more.
Author: Seven Bold
Version: 1.1.1
Author URI: http://sevenbold.com/
*/

if ( ! defined( 'CUSTOM_BRANDING_VERSION' ) ) {
	define( 'CUSTOM_BRANDING_VERSION', '1.1.1' );
}
if ( ! defined( 'CUSTOM_BRANDING_DB' ) ) {
	define( 'CUSTOM_BRANDING_DB', '8' );
}

// Import
if ( is_admin() && isset( $GLOBALS['_GET']['page'] ) && 'custom_branding_import_export' == $GLOBALS['_GET']['page'] ) {

	if ( isset( $_POST['custom_branding_import'] ) ) {

		global $custom_branding_import_success;

		$import = esc_sql( @unserialize( stripslashes( $_POST['custom_branding_import_settings'] ) ) );

		if ( false !== $import && is_array( $import ) ) {
			if ( is_multisite() && is_main_site() ) {
				update_site_option( 'custom_branding_settings', $import );
			} else {
				update_option( 'custom_branding_settings', $import );
			}
			$custom_branding_import_success = true;
		} else {
			$custom_branding_import_success = false;
		}
	}
}

// Global Settings
if ( is_admin() || custom_branding_is_login_page() ) {
	$custom_branding_settings = custom_branding_get_settings();
}
function custom_branding_get_settings() {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once( ABSPATH . '/admin/includes/plugin.php' );

	}

	if ( is_multisite() && is_plugin_active_for_network( 'custom-branding-admin/custom-branding-admin.php' ) ) {
		return $custom_branding_settings = get_site_option( 'custom_branding_settings' );
	} else {
		return $custom_branding_settings = get_option( 'custom_branding_settings' );
	}
}
function custom_branding_is_login_page() {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once( ABSPATH . '/admin/includes/plugin.php' );
	}

	if ( is_multisite() && is_plugin_active_for_network( 'custom-branding-admin/custom-branding-admin.php' ) ) {

		$custom_branding_settings = get_site_option( 'custom_branding_settings' );

		if ( 'on' === $custom_branding_settings['customLogin'] ) {
			if ( preg_match( $custom_branding_settings['customLoginURL'] . '/', $GLOBALS['path'] ) ) {
				return true;
			}
		} else {
			if ( preg_match( '/login.php/', $GLOBALS['path'] ) || preg_match( '/mn-register.php/', $GLOBALS['path'] ) ) {
				return true;
			}
		}
	} else {

		$custom_branding_settings = get_option( 'custom_branding_settings' );

		if ( 'on' === $custom_branding_settings['customLogin'] ) {
			if ( $custom_branding_settings['customLoginURL'] === $_SERVER['REQUEST_URI'] || $custom_branding_settings['customLoginURL'] . '?loggedout=true' === $_SERVER['REQUEST_URI'] || $custom_branding_settings['customLoginURL'] . '/?loggedout=true' === $_SERVER['REQUEST_URI'] ) {
				return true;
			}
		} else {
			return in_array( $GLOBALS['pagenow'], array( 'login.php', 'mn-register.php' ) );
		}
	}
}

// Setup the Settings Menu and Page
if ( is_admin() ) {
	if ( is_multisite() && is_plugin_active_for_network( 'custom-branding-admin/custom-branding-admin.php' ) ) {
		add_action( 'network_admin_menu', 'custom_branding_admin_branding' );
		add_action( 'network_admin_menu', 'custom_branding_plugin_menu' );
		add_action( 'admin_menu', 'custom_branding_admin_branding' );
	} else {
		add_action( 'admin_menu', 'custom_branding_admin_branding' );
		add_action( 'admin_menu', 'custom_branding_plugin_menu' );
	}
}
function custom_branding_admin_branding() {
	global $custom_branding_settings;

	// Override Jetpack trying to be above Dashboard
	if ( '' !== $custom_branding_settings['adminLogo'] && '' !== $custom_branding_settings['adminLogoFolded'] ) {
		add_filter( 'custom_menu_order', '__return_true', 11 );
		add_filter( 'menu_order', 'custom_branding_menu_order', 11 );
	}
}

function custom_branding_plugin_menu() {
	add_menu_page(
		'Custom Branding Settings',
		'Branding',
		'manage_options',
		'custom_branding_color_schemes',
		'custom_branding_color_schemes',
		'dashicons-admin-appearance',
		'98.2481'
	);
	add_submenu_page(
		'custom_branding_color_schemes',
		'Color Schemes',
		'Color Schemes',
		'manage_options',
		'custom_branding_color_schemes',
		'custom_branding_color_schemes'
	);/*
	add_submenu_page(
		'custom_branding_color_schemes',
		'Branding',
		'Branding',
		'manage_options',
		'custom_branding_branding',
		'custom_branding_branding'
	);*/
	add_submenu_page(
		'custom_branding_color_schemes',
		'Dashboard',
		'Dashboard',
		'manage_options',
		'custom_branding_dashboard',
		'custom_branding_dashboard'
	);
	if ( is_multisite() && is_main_site() ) {

	} else {
		add_submenu_page(
			'custom_branding_color_schemes',
			'Admin Menu',
			'Admin Menu',
			'manage_options',
			'custom_branding_admin_menu',
			'custom_branding_admin_menu'
		);
	}
	add_submenu_page(
		'custom_branding_color_schemes',
		'Admin Bar &amp; Footer',
		'Admin Bar &amp; Footer',
		'manage_options',
		'custom_branding_admin_bar_footer',
		'custom_branding_admin_bar_footer'
	);

	add_submenu_page(
		'custom_branding_color_schemes',
		'Content &amp; Notices',
		'Content &amp; Notices',
		'manage_options',
		'custom_branding_content_notices',
		'custom_branding_content_notices'
	);
	add_submenu_page(
		'custom_branding_color_schemes',
		'Permissions',
		'Permissions',
		'manage_options',
		'custom_branding_permissions',
		'custom_branding_permissions'
	);
	add_submenu_page(
		'custom_branding_color_schemes',
		'Settings',
		'Settings',
		'manage_options',
		'custom_branding_settings',
		'custom_branding_settings'
	);
	add_submenu_page(
		'custom_branding_color_schemes',
		'Import / Export',
		'Import / Export',
		'manage_options',
		'custom_branding_import_export',
		'custom_branding_import_export'
	);
}

function custom_branding_menu_order( $menu_order ) {
	$sp_menu_order = array();
	foreach ( $menu_order as $index => $item ) {
		if ( 'custom_branding_admin_logo_folded' !== $item ) {
			$sp_menu_order[] = $item;
		}

		if ( 0 === $index ) {
			$sp_menu_order[] = 'custom_branding_admin_logo_folded';
		}
	}

	return $sp_menu_order;
}

// admin_init
add_action( 'admin_init', 'custom_branding_admin_init' );
function custom_branding_admin_init() {

	if ( is_multisite() && is_plugin_active_for_network( 'custom-branding-admin/custom-branding-admin.php' ) ) {
		add_action( 'network_admin_edit_custom_branding_network', 'custom_branding_save_settings_network', 10, 0 );
	} else {
		register_setting(
			'custom_branding_settings',
			'custom_branding_settings',
			'custom_branding_sanitize'
		);
	}

}

// Add Settings Link on Plugin Page
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'custom_branding_plugin_link' );
function custom_branding_plugin_link( $links ) {
	$settings_link = '<a href="admin.php?page=custom_branding_color_schemes">Settings</a>';
	array_push( $links, $settings_link );
	return $links;
}

// DB Updates
function custom_branding_check_db() {
	if ( is_multisite() && is_main_site() ) {
		if ( get_site_option( 'custom_branding_db' ) >= CUSTOM_BRANDING_DB ) {
			return;
		}
	} else {
		if ( get_option( 'custom_branding_db' ) >= CUSTOM_BRANDING_DB ) {
			return;
		}
	}

	require_once( ABSPATH . RES . '/branding' .'/inc/update_db.php' );
	custom_branding_update_db();
}

// Version Check
function custom_branding_check_version() {
	if ( is_multisite() && is_main_site() ) {
		if ( get_site_option( 'custom_branding_version' ) >= CUSTOM_BRANDING_VERSION ) {
			return;
		} else {
			update_site_option( 'custom_branding_version', CUSTOM_BRANDING_VERSION );
		}
	} else {
		if ( get_option( 'custom_branding_version' ) >= CUSTOM_BRANDING_VERSION ) {
			return;
		} else {
			update_option( 'custom_branding_version', CUSTOM_BRANDING_VERSION );
		}
	}

	// Update info on License server
	custom_branding_initial_license();
}

// Licensing
function custom_branding_initial_license() {
	global $mn_version;
	if ( is_multisite() ) {
		$multisite = '1';
	} else {
		$multisite = '0';
	}
	$server = 'http://licenses.sevenbold.com/license.php';
	$args = array(
		'useragent' => $mn_version,
		'email'     => get_bloginfo( 'admin_email' ),
		'website'   => home_url(),
		'version'   => CUSTOM_BRANDING_VERSION,
		'multisite' => $multisite,
	);
	$response = mn_remote_post( $server, array(
			'method'   => 'POST',
			'timeout'  => 5,
			'blocking' => false,
			'body'     => $args,
		)
	);
}

function custom_branding_licensing( $key, $remove ) {
	global $mn_version;
	if ( is_multisite() ) {
		$multisite = '1';
	} else {
		$multisite = '0';
	}
	$server = 'http://licenses.sevenbold.com/license.php';
	$args = array(
		'useragent' => $mn_version,
		'email'     => get_bloginfo( 'admin_email' ),
		'website'   => home_url(),
		'key'       => $key,
		'version'   => CUSTOM_BRANDING_VERSION,
		'remove'    => $remove,
		'multisite' => $multisite,
	);
	$response = mn_remote_post( $server, array(
			'method'      => 'POST',
			'timeout'     => 30,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'body'        => $args,
			'cookies'     => array()
		)
	);

	if ( is_mn_error( $response ) || mn_remote_retrieve_response_code( $response ) !== 200 ) {
		$licenseReply = array( 'body' => 'server' );

		return $licenseReply;
	} else {
		$licenseReply = $response;

		return $licenseReply;
	}
}

// plugins_loaded
add_action( 'plugins_loaded', 'custom_branding_plugins_loaded' );
function custom_branding_plugins_loaded() {
	global $custom_branding_settings;

	// Translations
	load_plugin_textdomain( 'custom-branding', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	// Update DB
	custom_branding_check_db();

	// Update Version
	custom_branding_check_version();

	// Auto Update
	require( ABSPATH . RES . '/branding'  . '/inc/plugin-update-checker.php' );
	$slateUpdateCheck = PucFactory::buildUpdateChecker(
		'http://updates.sevenbold.com/update.php',
		__FILE__
	);
	function slate_license_key( $query ) {
		if ( is_multisite() && is_plugin_active_for_network( 'custom-branding-admin/custom-branding-admin.php' ) ) {
			$custom_branding_license = get_site_option( 'custom_branding_license' );
		} else {
			$custom_branding_license = get_option( 'custom_branding_license' );
		}
		$query['key'] = esc_attr( $custom_branding_license['licenseKey'] );
		$query['email'] = get_bloginfo( 'admin_email' );
		$query['website'] = home_url();

		return $query;
	}

	$slateUpdateCheck->addQueryArgFilter( 'slate_license_key' );

	// Admin Menu Permissions
	$menu_permission = custom_branding_get_user_permission();
	if ( ! empty( $menu_permission ) ) {
		if ( ! empty( $custom_branding_settings['adminMenuPermissions'][ $menu_permission ] ) && ( 'on' === $custom_branding_settings['adminMenuPermissions'][ $menu_permission ] ) ) {
			add_action( 'admin_menu', 'custom_branding_hide_admin_menus', 999 );
		}
	}

	// Custom Branding Plugin Permissions
	$plugin_permission = custom_branding_get_user_permission();
	if ( ! empty( $plugin_permission ) ) {
		if ( ! empty( $custom_branding_settings['userPermissions'][ $plugin_permission ] ) && ( 'on' === $custom_branding_settings['userPermissions'][ $plugin_permission ] ) ) {
			add_action( 'admin_menu', 'custom_branding_hide_plugin_menu' );
			add_action( 'admin_head', 'custom_branding_hide_plugin' );
		}
	}
}

// admin_enqueue_scripts
add_action( 'admin_enqueue_scripts', 'custom_branding_admin_enqueue' );
function custom_branding_admin_enqueue( $page ) {
	global $custom_branding_settings;

	mn_enqueue_style( 'custom-branding-admin', includes_url( 'branding/css/custom_branding.css', __FILE__ ) );
	mn_enqueue_script( 'custom-branding', includes_url( 'branding/js/custom_branding.js', __FILE__ ), array( 'jquery' ), CUSTOM_BRANDING_VERSION );

	// Branding Page
	if ( 'custom-branding_page_custom_branding_branding' === $page ) {
		mn_enqueue_media();
	}

	// Color Schemes Page
	if ( 'toplevel_page_custom_branding_color_schemes' === $page ) {
		mn_enqueue_style( 'spectrum-css', includes_url( 'branding/css/spectrum.css', __FILE__ ) );
		mn_enqueue_script( 'spectrum-js', includes_url( 'branding/js/spectrum.js', __FILE__ ), array( 'jquery' ), CUSTOM_BRANDING_VERSION );
	}

	// Admin Logo Present
	if ( $adminLogo = $custom_branding_settings['adminLogo'] ) {
		mn_localize_script( 'custom-branding', 'slate_adminLogo', esc_url( $custom_branding_settings['adminLogo'] ) );
	}

	// Hide User Profile Colors
	if ( 'on' === $custom_branding_settings['colorsHideUserProfileColors'] ) {
		mn_localize_script( 'custom-branding', 'slate_colorsHideUserProfileColors', esc_attr( $custom_branding_settings['colorsHideUserProfileColors'] ) );
	}

}

// login_enqueue_scripts
add_action( 'login_enqueue_scripts', 'custom_branding_login_enqueue' );
function custom_branding_login_enqueue() {
	mn_enqueue_style( 'custom-branding-admin', includes_url( 'branding/css/custom_branding.css', __FILE__ ) );
}

// mn_head
// Add Admin Bar styles to front end
add_action( 'mn_head', 'custom_branding_mn_head' );
function custom_branding_mn_head() {
	if ( is_admin_bar_showing() ) {
		$custom_branding_settings = custom_branding_get_settings();

		// Color Schemes and Options
		include( ABSPATH . RES . '/branding' . '/css/dynamic_css_adminbar.php' );

		// Hide Admin Bar
		if ( 'on' === $custom_branding_settings['adminBarHide'] ) { ?>
			<style type="text/css" media="screen">
				/* Admin Bar */
				#mnadminbar {
					display: none;
				}

				#mnbody,
				.folded #mnbody {
					padding-top: 0;
				}

				@media only screen and (max-width: 782px) {
					#mnadminbar {
						display: block;
						visibility: hidden;
					}

					#mn-admin-bar-menu-toggle {
						visibility: visible;
					}

					#mnadminbar #adminbarsearch:before, #mnadminbar .ab-icon:before, #mnadminbar .ab-item:before, #mnadminbar a.ab-item, #mnadminbar > #mn-toolbar span.ab-label, #mnadminbar > #mn-toolbar span.noticon {
						color: #333;
					}

					.mn-responsive-open #mnadminbar #mn-admin-bar-menu-toggle a {
						background: #fff;
					}

					#mnbody,
					.folded #mnbody {
						padding-top: 46px;
					}
				}
			</style>
		<?php }

		// Hide the MN Logo from the Admin Bar
		if ( 'on' === $custom_branding_settings['adminBarHideMN'] ) { ?>
			<style type="text/css" media="screen">
				/* Admin Bar Mtaandao Logo */
				#mnadminbar li#mn-admin-bar-mn-logo {
					display: none;
				}
			</style>
		<?php }
	}
}
// admin_head
add_action( 'admin_head', 'custom_branding_admin_head' );
function custom_branding_admin_head() {
	global $custom_branding_settings;

	// Color Schemes and Options
	include( ABSPATH . RES . '/branding' . '/css/dynamic_css.php' );
	include( ABSPATH . RES . '/branding' . '/css/dynamic_css_adminbar.php' );

	// Favicon
	if ( $adminFavicon = $custom_branding_settings['adminFavicon'] ) {
		echo '<link rel="shortcut icon" href="' . esc_url( $adminFavicon ) . '">';
	}

	// Admin Menu
	if ( '' !== $custom_branding_settings['adminLogo'] ) { ?>
		<style type="text/css" media="screen">
			/* Admin Bar Mtaandao Logo */
			#adminmenu {
				margin: 0 !important;
			}
		</style>
	<?php }
	if ( '' !== $custom_branding_settings['adminLogoFolded'] ) { ?>
		<style type="text/css" media="screen">
			/* Admin Bar Mtaandao Logo */
			#adminmenu .folded {
				margin: 0 0 12px 0 !important;
			}
		</style>
	<?php }

	// Hide User Profile Colors
	if ( 'on' === $custom_branding_settings['colorsHideUserProfileColors'] ) { ?>
		<style type="text/css" media="screen">
			/* User Profile Color Options */
			.profile-php #color-picker {
				display: none;
			}
		</style>
	<?php }

	// Hide Admin Bar
	if ( 'on' === $custom_branding_settings['adminBarHide'] ) { ?>
		<style type="text/css" media="screen">
			/* Admin Bar */
			#mnadminbar {
				display: none;
			}

			#mnbody,
			.folded #mnbody {
				padding-top: 0;
			}

			@media only screen and (max-width: 782px) {
				#mnadminbar {
					display: block;
					visibility: hidden;
				}

				#mn-admin-bar-menu-toggle {
					visibility: visible;
				}

				#mnadminbar #adminbarsearch:before, #mnadminbar .ab-icon:before, #mnadminbar .ab-item:before, #mnadminbar a.ab-item, #mnadminbar > #mn-toolbar span.ab-label, #mnadminbar > #mn-toolbar span.noticon {
					color: #333;
				}

				.mn-responsive-open #mnadminbar #mn-admin-bar-menu-toggle a {
					background: #fff;
				}

				#mnbody,
				.folded #mnbody {
					padding-top: 46px;
				}
			}
		</style>
	<?php }

	// Hide the MN Logo from the Admin Bar
	if ( 'on' === $custom_branding_settings['adminBarHideMN'] ) { ?>
		<style type="text/css" media="screen">
			/* Admin Bar Mtaandao Logo */
			#mnadminbar li#mn-admin-bar-mn-logo {
				display: none;
			}
		</style>
	<?php }

	// Hide Footer
	if ( 'on' === $custom_branding_settings['footerHide'] ) { ?>
		<style type="text/css" media="screen">
			/* Footer */
			#mnfooter {
				display: none;
			}
		</style>
	<?php }

	// Hide Help Tab
	if ( 'on' === $custom_branding_settings['contentHideHelp'] ) { ?>
		<style type="text/css" media="screen">
			/* Help Tab */
			#contextual-help-link-wrap {
				display: none;
			}
		</style>
	<?php }

	// Hide Screen Options Tab
	if ( 'on' === $custom_branding_settings['contentHideScreenOptions'] ) { ?>
		<style type="text/css" media="screen">
			/* Screen Options Tab */
			#screen-options-link-wrap {
				display: none;
			}
		</style>
	<?php }

	// Hide Updates
	if ( 'on' === $custom_branding_settings['noticeHideAllUpdates'] ) { ?>
		<style type="text/css" media="screen">
			#mn-admin-bar-updates,
			.theme-update,
			.update-message,
			.update-nag,
			.update-plugins,
			#menu-update {
				display: none !important;
			}
		</style>
	<?php }
}

// admin_title
add_filter( 'admin_title', 'custom_branding_admin_title', 10, 2 );
function custom_branding_admin_title( $admin_title, $title ) {
	global $custom_branding_settings;

	if ( 'on' === $custom_branding_settings['contentHideMNTitle'] ) {
		return $title . ' &lsaquo; ' . get_bloginfo( 'name' );
	} else {
		return $admin_title;
	}
}

// login_head
add_action( 'login_head', 'custom_branding_login_head' );
function custom_branding_login_head() {
	global $custom_branding_settings;

	// Color Schemes and Options
	include( ABSPATH . RES . '/branding' . '/css/dynamic_css.php' );

	// Favicon
	if ( '' !== $custom_branding_settings['adminFavicon'] ) {
		echo '<link rel="shortcut icon" href="' . esc_url( $custom_branding_settings['adminFavicon'] ) . '">';
	}

	// Login Logo
	if ( '' !== $custom_branding_settings['loginLogo'] ) { ?>
		<style type="text/css" media="screen">
			/* Login Logo */
			body.login div#login h1 a {
				background-image: url('<?php echo esc_url( $custom_branding_settings['loginLogo'] ); ?>');
				background-size: contain;
				width: 100%;
			}
		</style>
	<?php }

	// Hide Login Logo
	if ( '' !== $custom_branding_settings['loginLogoHide'] ) { ?>
		<style type="text/css" media="screen">
			/* Login Logo */
			body.login div#login h1 {
				display: none;
			}
		</style>
	<?php }

	// Login Background
	if ( '' !== $custom_branding_settings['loginBgImage'] ) { ?>
		<style type="text/css" media="screen">
			/* Login Background Image */
			body.login {
				background-image: url('<?php echo esc_url( $custom_branding_settings['loginBgImage'] ); ?>');
				background-position: <?php echo esc_attr( $custom_branding_settings['loginBgPosition'] ); ?>;
				background-repeat: <?php echo esc_attr( $custom_branding_settings['loginBgRepeat'] ); ?>;
				width: 100%;
			<?php if ( 'on' === $custom_branding_settings['loginBgFull' ] ) { ?> background-attachment: fixed;
				background-size: cover;
			<?php } ?>
			}
		</style>
	<?php }
}

// Login Link Text and Address
add_filter( 'login_headerurl', 'custom_branding_login_url' );
function custom_branding_login_url() {
	global $custom_branding_settings;

	$loginUrl = $custom_branding_settings['loginLinkUrl'];

	return $loginUrl;
}
add_filter( 'login_headertitle', 'custom_branding_login_title' );
function custom_branding_login_title() {
	global $custom_branding_settings;

	$loginTitle = $custom_branding_settings['loginLinkTitle'];

	return $loginTitle;
}

// Get Current User Admin Color
function custom_branding_get_user_admin_color() {
	$user_id = get_current_user_id();
	$user_info = get_userdata( $user_id );
	if ( ! ( $user_info instanceof MN_User ) ) {
		return;
	}
	$user_admin_color = $user_info->admin_color;

	return $user_admin_color;
}

// Footer Options
add_filter( 'admin_footer_text', 'custom_branding_admin_footer_text' );
function custom_branding_admin_footer_text() {
	global $custom_branding_settings;

	if ( 'on' === $custom_branding_settings['footerTextShow'] ) {
		$footerText = ( $custom_branding_settings['footerText'] ) ? $custom_branding_settings['footerText'] : '';
		$footerText = mn_kses_post( force_balance_tags( $footerText ) );
	} else {
		$footerText = 'Powered by <a href="http://mtaandao.co.ke" target="_blank">Mtaandao</a> - <a href="about.php">About</a> | <a href="contribute.php">Contribute</a>';
	}

	return $footerText;
}

add_action( 'admin_menu', 'custom_branding_footer_hide_ver' );
function custom_branding_footer_hide_ver() {
	global $custom_branding_settings;

	if ( 'on' === $custom_branding_settings['footerVersionHide'] ) {
		remove_filter( 'update_footer', 'core_update_footer' );
	}
}

// Admin Menu
function custom_branding_admin_menus() {
	global $menu;

	$i = 1;
	foreach ( $menu as $menuOrder => $menuItem ) {
		if ( 'Custom Branding Admin Logo' !== $menuItem[0] && 'Custom Branding Admin Logo Folded' !== $menuItem[0] ) {
			if ( ! empty( $menuItem[0] ) ) {
				$getJustName = explode( ' ', $menuItem[0] );
				if ( ( 'Plugins' == $getJustName[0] ) || ( 'Comments' == $getJustName[0] ) || ( 'Themes' === $getJustName[0] ) || ( 'Updates' === $getJustName[0] ) ) {
					$menuTitle = $getJustName[0];
				} else {
					$menuTitle = $menuItem[0];
				}
			} else {
				$menuTitle = 'Menu Separator ' . $i;
				$i ++;
			}
			$theMenu[] = array(
				'Sort'  => $menuOrder,
				'Title' => $menuTitle,
				'Slug'  => $menuItem[2],
				'Hide'  => '0',
			);
		}
	}

	return $theMenu;
}

function custom_branding_hide_admin_menus() {
	global $custom_branding_settings;
	if ( ! isset( $custom_branding_settings['adminMenu'] ) ) {
		return;
	} else {
		foreach ( $custom_branding_settings['adminMenu'] as $menuItem => $menuHide ) {

			$menuItem = unserialize( base64_decode( $menuItem ) );

			if ( 'on' === $menuHide ) {
				remove_menu_page( $menuItem['Slug'] );
			}
		}
	}
}

// User Permissions
function custom_branding_get_user_permission() {
	$user_id = get_current_user_id();
	$user_info = get_userdata( $user_id );
	if ( ! ( $user_info instanceof MN_User ) ) {
		return;
	}
	$username = $user_info->user_login;

	return $username;
}

function custom_branding_hide_plugin_menu() {
	remove_menu_page( 'custom_branding_color_schemes' );
}

function custom_branding_hide_plugin() { ?>
	<style type="text/css" media="screen">
		/* Admin Bar */
		#custom-branding-admin {
			display: none;
		}
	</style>
<?php }

// Dashboard
// Display Custom Widget
add_action( 'mn_dashboard_setup', 'custom_branding_dashboard_setup' );
function custom_branding_dashboard_setup() {
	global $mn_meta_boxes;
	global $custom_branding_settings;

	// Dashboard Welcome Message
	if ( 'on' === $custom_branding_settings['dashboardHideWelcome'] ) {
		remove_action( 'welcome_panel', 'mn_welcome_panel' );
	}

	if ( 'on' === $custom_branding_settings['dashboardCustomWidget'] ) {
		$widgetTitle = $custom_branding_settings['dashboardCustomWidgetTitle'];
		mn_add_dashboard_widget( 'custom_branding_dashboard_widget', esc_attr( $widgetTitle ), 'custom_branding_dashboard_widget_display' );

		// Move custom widget to top
		$normal_dashboard = $mn_meta_boxes['dashboard']['normal']['core'];
		$example_widget_backup = array( 'custom_branding_dashboard_widget' => $normal_dashboard['custom_branding_dashboard_widget'] );
		unset( $normal_dashboard['custom_branding_dashboard_widget'] );
		$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
		$mn_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}
function custom_branding_dashboard_widget_display() {
	global $custom_branding_settings;
	$widgetText = $custom_branding_settings['dashboardCustomWidgetText'];
	echo '<div class="slate__customWidget">' . mn_kses_post( force_balance_tags( $widgetText ) ) . '</div>';
}

// Disabled Dashboard Widgets
add_action( 'admin_init', 'custom_branding_disabled_widgets' );
function custom_branding_disabled_widgets() {
	global $custom_branding_settings;

	if ( isset( $custom_branding_settings['dashboardWidgets'] ) ) {
		foreach ( $custom_branding_settings['dashboardWidgets'] as $key => $value ) {
			if ( 'on' === $value ) {
				add_action( 'mn_dashboard_setup', 'custom_branding_' . $key );
			}
		}
	}
}

function custom_branding_dashboardHideActivity() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
}

function custom_branding_dashboardHideNews() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $mn_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
}

function custom_branding_dashboardRightNow() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
}

function custom_branding_dashboardRecentComments() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
}

function custom_branding_dashboardQuickPress() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
}

function custom_branding_dashboardRecentDrafts() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
}

function custom_branding_dashboardIncomingLinks() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
}

function custom_branding_dashboardPlugins() {
	global $mn_meta_boxes;
	unset( $mn_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
}

// Content
// Remove the hyphen before the post state
add_filter( 'display_post_states', 'custom_branding_post_state' );
function custom_branding_post_state( $post_states ) {
	if ( ! empty( $post_states ) ) {
		$state_count = count( $post_states );
		$i = 0;
		foreach ( $post_states as $state ) {
			++ $i;
			( $i === $state_count ) ? $sep = '' : $sep = '';
			echo '<span class="post-state">' . esc_attr( $state ) . esc_attr( $sep ) . '</span>';
		}
	}
}

// Notices
add_action( 'after_setup_theme', 'custom_branding_mn_notices' );
function custom_branding_mn_notices() {
	global $custom_branding_settings;

	$custom_branding_remove_notices = function ( $a ) {
		global $mn_version;
		return (object) array(
			'last_checked' => time(),
			'version_checked' => $mn_version,
			);
	};

	// Disable Core Updates
	if ( 'on' === $custom_branding_settings['noticeMNUpdate'] ) {
		add_filter( 'pre_site_transient_update_core', $custom_branding_remove_notices );
	}

	// Disable Theme Updates
	if ( 'on' === $custom_branding_settings['noticeThemeUpdate'] ) {
		add_filter( 'pre_site_transient_update_themes', $custom_branding_remove_notices );
	}

	// Disable Plugin Updates
	if ( 'on' === $custom_branding_settings['noticePluginUpdate'] ) {
		add_filter( 'pre_site_transient_update_plugins', $custom_branding_remove_notices );
	}
}
// Hide All Updates (Alternative to Disabling)
add_action( 'admin_menu', 'custom_branding_hide_all_updates' );
function custom_branding_hide_all_updates() {
	global $custom_branding_settings;
	global $menu;
	global $submenu;

	if ( 'on' === $custom_branding_settings['noticeHideAllUpdates'] ) {
		if ( is_multisite() && is_main_site() ) {
			remove_action( 'network_admin_notices', 'update_nag', 3 );
			remove_filter( 'update_footer', 'core_update_footer' );
			$menu[65][0] = 'Plugins';
			$submenu['index.php'][10][0] = 'Updates';
		} else {
			remove_action( 'admin_notices', 'update_nag', 3 );
			remove_filter( 'update_footer', 'core_update_footer' );
			$menu[65][0] = 'Plugins';
			$submenu['index.php'][10][0] = 'Updates';
		}
	}
}

// After Setup
add_action( 'after_setup_theme', 'custom_branding_add_editor_styles' );
function custom_branding_add_editor_styles() {
	add_editor_style( includes_url( 'branding/css/editor-style.css', __FILE__ ) );
}

// Activate Plugin
register_activation_hook( __FILE__, 'custom_branding_activate' );
register_activation_hook( __FILE__, 'custom_branding_initial_license' );
register_activation_hook( __FILE__, 'custom_branding_check_db' );
register_activation_hook( __FILE__, 'custom_branding_check_version' );
function custom_branding_activate() {

	date_default_timezone_set( 'America/Los_Angeles' );
	$date = date( 'Y-m-d H:i:s' );

	if ( is_multisite() ) {
		global $blog_id;
		$current_blog_details = get_blog_details( array( 'blog_id' => $blog_id ) );
		$loginLinkTitle = $current_blog_details->blogname;
		$loginLinkUrl = $current_blog_details->siteurl;
	} else {
		$loginLinkTitle = get_bloginfo( 'name' );
		$loginLinkUrl = get_bloginfo( 'url' );
	}

	$default_option = array(
		// Color Schemes
		'colorScheme'                 => 'default',
		'colorSchemeCustomColors'     => array(
			'loginBgColor'                                => '#444343',
			'loginFormBgColor'                            => '#eeecec',
			'loginFormTextColor'                          => '#777777',
			'loginFormInputBgColor'                       => '#fbfbfb',
			'loginFormInputTextColor'                     => '#333333',
			'loginFormInputFocusColor'                    => '#5b9dd9',
			'loginButtonBgColor'                          => '#21b68e',
			'loginButtonTextColor'                        => '#ffffff',
			'loginButtonHoverBgColor'                     => '#ffffff',
			'loginButtonHoverTextColor'                   => '#21b68e',
			'loginFormLinkColor'                          => '#eeebeb',
			'loginFormLinkHoverColor'                     => '#ffffff',
			'adminMenuBgColor'                            => '#302d2d',
			'adminMenuDividerColor'                       => '#262323',
			'adminNoticeColor'                            => '#ffffff',
			'adminNoticeBgColor'                          => '#d54e21',
			'adminTopLevelTextColor'                      => '#888888',
			'adminTopLevelTextHoverColor'                 => '#21b68e',
			'adminTopLevelSelectedTextColor'              => '#21b68e',
			'adminFloatingSubmenuBgColor'                 => '#21b68e',
			'adminFloatingSubmenuTextColor'               => '#ffffff',
			'adminFloatingSubmenuTextHoverColor'          => '#b9ecff',
			'adminOpenSubmenuTextColor'                   => '#bbbbbb',
			'adminOpenSubmenuTextHoverColor'              => '#ffffff',
			'adminOpenSubmenuTextSelectedColor'           => '#ffffff',
			'adminTopLevelSelectedFoldedBg'               => '#21b68e',
			'adminTopLevelFoldedTextColor'                => '#ffffff',
			'adminTopLevelSelectedFoldedTextColor'        => '#ffffff',
			'adminTopLevelSelectedFoldedIconColor'        => '#ffffff',
			'adminFoldedFloatingSubmenuTextColor'         => '#ffffff',
			'adminFoldedFloatingSubmenuTextHoverColor'    => '#ffd8d3',
			'adminFoldedFloatingSubmenuSelectedTextColor' => '#ffffff',
			'adminBarBgColor'                             => '#444343',
			'adminBarBgHoverColor'                        => '#333333',
			'adminBarTopLevelColor'                       => '#888888',
			'adminBarTopLevelHoverColor'                  => '#21b68e',
			'adminBarSubmenuTextColor'                    => '#eeeeee',
			'adminBarSubmenuTextHoverColor'               => '#21b68e',
			'footerBgColor'                               => '#444343',
			'footerTextColor'                             => '#999999',
			'footerLinkColor'                             => '#ffffff',
			'footerLinkHoverColor'                        => '#ffffff',
			'contentTextColor'                            => '#555555',
			'contentHeadingTextColor'                     => '#222222',
			'contentLinkColor'                            => '#21b68e',
			'contentLinkHoverColor'                       => '#21b68e',
			'contentTableRowBgHoverColor'                 => '#eeecec',
			'contentDividerColor'                         => '#eeecec',
			'contentPrimaryButtonBgColor'                 => '#21b68e',
			'contentPrimaryButtonTextColor'               => '#ffffff',
			'contentPrimaryButtonBgHoverColor'            => '#1e8cbe',
			'contentPrimaryButtonTextHoverColor'          => '#ffffff',
			'contentStandardButtonBgColor'                => '#dcd7d7',
			'contentStandardButtonTextColor'              => '#555555',
			'contentStandardButtonBgHoverColor'           => '#7d7878',
			'contentStandardButtonTextHoverColor'         => '#ffffff',
			'contentMetaBgColor'                          => '#eeecec',
			'contentMetaTextColor'                        => '#777777',
			'contentMetaBgHoverColor'                     => '#eeecec',
			'contentMetaTextHoverColor'                   => '#333333',
			'sidebarBgColor'                              => '#eeecec',
			'sidebarTextColor'                            => '#555555',
			'sidebarHeadingColor'                         => '#222222',
			'sidebarLinkColor'                            => '#21b68e',
			'sidebarLinkHoverColor'                       => '#21b68e',
			'sidebarIconColor'                            => '#555555',
			'sidebarDividerColor'                         => '#dad8d8',
			'sidebarPrimaryButtonBgColor'                 => '#21b68e',
			'sidebarPrimaryButtonTextColor'               => '#ffffff',
			'sidebarPrimaryButtonBgHoverColor'            => '#1e8cbe',
			'sidebarPrimaryButtonTextHoverColor'          => '#ffffff',
			'sidebarStandardButtonBgColor'                => '#dcd7d7',
			'sidebarStandardButtonTextColor'              => '#555555',
			'sidebarStandardButtonBgHoverColor'           => '#7d7878',
			'sidebarStandardButtonTextHoverColor'         => '#ffffff',
		),
		'colorsHideUserProfileColors' => '',
		'colorsHideShadows'           => '',
		// Login Page
		'loginLinkTitle'              => $loginLinkTitle,
		'loginLinkUrl'                => $loginLinkUrl,
		'loginLogoHide'               => '',
		'loginLogo'                   => includes_url( '/branding/images/custom_branding_login_logo.png', __FILE__ ),
		'loginBgImage'                => includes_url( '/branding/images/custom_branding_background.jpg', __FILE__ ),
		'loginBgPosition'             => 'center top',
		'loginBgRepeat'               => 'no-repeat',
		'loginBgFull'                 => 'on',
		// Admin Branding
		'adminLogo'                   => includes_url( '/branding/images/custom_branding_admin_logo.png', __FILE__ ),
		'adminLogoFolded'             => includes_url( '/branding/images/custom_branding_admin_logo_folded.png', __FILE__ ),
		'adminFavicon'                => includes_url( '/branding/images/custom_branding_favicon.png', __FILE__ ),
		// Admin Menu
		'adminMenu'                   => array(),
		'adminMenuPermissions'        => array(),
		// Admin Bar
		'adminBarHide'                => '',
		'adminBarHideMN'              => '',
		// Footer
		'footerTextShow'              => '',
		'footerVersionHide'           => '',
		'footerText'                  => '',
		'footerHide'                  => '',
		// Dashboard
		'dashboardHideWelcome'        => '',
		'dashboardWidgets'            => array(
			'dashboardHideActivity'   => '0',
			'dashboardHideNews'       => '0',
			'dashboardRightNow'       => '0',
			'dashboardRecentComments' => '0',
			'dashboardQuickPress'     => '0',
			'dashboardRecentDrafts'   => '0',
			'dashboardIncomingLinks'  => '0',
			'dashboardPlugins'        => '0',
		),
		'dashboardCustomWidget'       => '',
		'dashboardCustomWidgetTitle'  => '',
		'dashboardCustomWidgetText'   => '',
		// Content and Notices
		'noticeMNUpdate'              => '',
		'noticeThemeUpdate'           => '',
		'noticePluginUpdate'          => '',
		'noticeHideAllUpdates'        => '',
		'contentHideHelp'             => '',
		'contentHideScreenOptions'    => '',
		'contentHideMNTitle'          => '',
		// Permissions
		'userPermissions'             => array(),
		// Settings
		'customLogin'                 => '',
		'customLoginURL'              => '',
		// License
		'licenseDate'                 => $date,
	);

	if ( is_multisite() && is_main_site() ) {
		add_site_option( 'custom_branding_settings', $default_option );
	} else {
		add_option( 'custom_branding_settings', $default_option );
	}

	$license_options = array(
		'licenseKey'    => '',
		'licenseStatus' => '',
	);
	if ( is_multisite() && is_main_site() ) {
		add_site_option( 'custom_branding_license', $license_options );
	} else {
		add_option( 'custom_branding_license', $license_options );
	}

	if ( is_multisite() && is_main_site() ) {
		add_site_option( 'custom_branding_db', CUSTOM_BRANDING_DB );
	} else {
		add_option( 'custom_branding_db', CUSTOM_BRANDING_DB );
	}

	if ( is_multisite() && is_main_site() ) {
		add_site_option( 'custom_branding_version', CUSTOM_BRANDING_VERSION );
	} else {
		add_option( 'custom_branding_version', CUSTOM_BRANDING_VERSION );
	}
}

// Deactivate Plugin
register_deactivation_hook( __FILE__, 'custom_branding_deactivate' );
function custom_branding_deactivate() {

	if ( is_multisite() && is_main_site() ) {
		delete_site_option( 'custom_branding_settings' );
		delete_site_option( 'custom_branding_license' );
		delete_site_option( 'custom_branding_version' );
		delete_site_option( 'custom_branding_db' );
	} else {
		delete_option( 'custom_branding_settings' );
		delete_option( 'custom_branding_license' );
		delete_option( 'custom_branding_version' );
		delete_option( 'custom_branding_db' );
	}
}

// Sanitization
function custom_branding_save_settings_network() {
	$option = custom_branding_sanitize( $_POST['custom_branding_settings'] );

	if ( ! empty( $option ) ) {
		update_site_option( 'custom_branding_settings', $option );
	}

	mn_redirect( esc_url_raw( add_query_arg( array(
		'page'    => $option['currentPage'],
		'updated' => 'true',
		), network_admin_url( 'admin.php' ) ) ) );
	exit();
}
function custom_branding_sanitize( $input ) {

	// Color Schemes
	$input['colorScheme'] = ( empty( $input['colorScheme'] ) ) ? '' : esc_attr( $input['colorScheme'] );
	$input['colorsHideUserProfileColors'] = ( empty( $input['colorsHideUserProfileColors'] ) ) ? '' : 'on';
	$input['colorsHideShadows'] = ( empty( $input['colorsHideShadows'] ) ) ? '' : 'on';
	foreach ( $input['colorSchemeCustomColors'] as $key => $value ) {
		$input['colorSchemeCustomColors'][ $key ] = ( empty( $input['colorSchemeCustomColors'][ $key ] ) ) ? '' : custom_branding_sanitize_hex( $input['colorSchemeCustomColors'][ $key ] );
	}

	// Login Page
	$input['loginLinkTitle'] = ( empty( $input['loginLinkTitle'] ) ) ? '' : esc_attr( $input['loginLinkTitle'] );
	$input['loginLinkUrl'] = ( empty( $input['loginLinkUrl'] ) ) ? '' : esc_url( $input['loginLinkUrl'] );
	$input['loginLogo'] = ( empty( $input['loginLogo'] ) ) ? '' : esc_url( $input['loginLogo'] );
	$input['loginLogoHide'] = ( empty( $input['loginLogoHide'] ) ) ? '' : 'on';
	$input['loginBgPosition'] = ( empty( $input['loginBgPosition'] ) ) ? '' : esc_attr( $input['loginBgPosition'] );
	$input['loginBgRepeat'] = ( empty( $input['loginBgRepeat'] ) ) ? '' : esc_attr( $input['loginBgRepeat'] );
	$input['loginBgImage'] = ( empty( $input['loginBgImage'] ) ) ? '' : esc_url( $input['loginBgImage'] );
	$input['loginBgFull'] = ( empty( $input['loginBgFull'] ) ) ? '' : 'on';

	// Admin Branding
	$input['adminLogo'] = ( empty( $input['adminLogo'] ) ) ? '' : esc_url( $input['adminLogo'] );
	$input['adminLogoFolded'] = ( empty( $input['adminLogoFolded'] ) ) ? '' : esc_url( $input['adminLogoFolded'] );
	$input['adminFavicon'] = ( empty( $input['adminFavicon'] ) ) ? '' : esc_url( $input['adminFavicon'] );

	// Dashboard
	$input['dashboardHideWelcome'] = ( empty( $input['dashboardHideWelcome'] ) ) ? '' : 'on';
	$input['dashboardCustomWidget'] = ( empty( $input['dashboardCustomWidget'] ) ) ? '' : 'on';
	$input['dashboardCustomWidgetTitle'] = ( empty( $input['dashboardCustomWidgetTitle'] ) ) ? '' : esc_attr( $input['dashboardCustomWidgetTitle'] );
	$input['dashboardCustomWidgetText'] = ( empty( $input['dashboardCustomWidgetText'] ) ) ? '' : mn_kses_post( force_balance_tags( $input['dashboardCustomWidgetText'] ) );
	foreach ( $input['dashboardWidgets'] as $key => $value ) {
		$input['dashboardWidgets'][ $key ] = ( '0' == $input['dashboardWidgets'][ $key ] ) ? '' : 'on';
	}

	// Footer Settings
	$input['footerTextShow'] = ( empty( $input['footerTextShow'] ) ) ? '' : 'on';
	$input['footerVersionHide'] = ( empty( $input['footerVersionHide'] ) ) ? '' : 'on';
	$input['footerText'] = ( empty( $input['footerText'] ) ) ? '' : mn_kses_post( force_balance_tags( $input['footerText'] ) );
	$input['footerHide'] = ( empty( $input['footerHide'] ) ) ? '' : 'on';

	// Admin Bar Settings
	$input['adminBarHide'] = ( empty( $input['adminBarHide'] ) ) ? '' : 'on';
	$input['adminBarHideMN'] = ( empty( $input['adminBarHideMN'] ) ) ? '' : 'on';

	// Permission Settings
	foreach ( $input['userPermissions'] as $key => $value ) {
		$input['userPermissions'][ $key ] = ( '0' == $input['userPermissions'][ $key ] ) ? '' : 'on';
	}

	// Admin Menu
	if ( isset( $input['adminMenu'] ) ) {
		foreach ( $input['adminMenu'] as $menuItem => $menuHide ) {
			$menuHide = ( '0' === $value ) ? '' : 'on';
			$menuItem = unserialize( base64_decode( $menuItem ) );
			foreach ( $menuItem as $key => $value ) {
				$key = ( empty( $key ) ) ? '' : esc_attr( $key );
				$value = ( empty( $value ) ) ? '' : esc_attr( $value );
			}
		}
	}

	foreach ( $input['adminMenuPermissions'] as $key => $value ) {
		$input['adminMenuPermissions'][ $key ] = ( '0' === $input['adminMenuPermissions'][ $key ] ) ? '' : 'on';
	}

	// Notices
	$input['noticeMNUpdate'] = ( empty( $input['noticeMNUpdate'] ) ) ? '' : 'on';
	$input['noticeThemeUpdate'] = ( empty( $input['noticeThemeUpdate'] ) ) ? '' : 'on';
	$input['noticePluginUpdate'] = ( empty( $input['noticePluginUpdate'] ) ) ? '' : 'on';
	$input['noticeHideAllUpdates'] = ( empty( $input['noticeHideAllUpdates'] ) ) ? '' : 'on';
	$input['contentHideHelp'] = ( empty( $input['contentHideHelp'] ) ) ? '' : 'on';
	$input['contentHideScreenOptions'] = ( empty( $input['contentHideScreenOptions'] ) ) ? '' : 'on';
	$input['contentHideMNTitle'] = ( empty( $input['contentHideMNTitle'] ) ) ? '' : 'on';

	// Settings
	$input['customLogin'] = ( empty( $input['customLogin'] ) ) ? '' : 'on';
	$input['customLoginURL'] = ( empty( $input['customLoginURL'] ) ) ? '' : esc_url( $input['customLoginURL'] );

	// Hidden Inputs
	$input['licenseDate'] = ( empty( $input['licenseDate'] ) ) ? '' : esc_attr( $input['licenseDate'] );
	$input['currentPage'] = ( empty( $input['currentPage'] ) ) ? '' : esc_attr( $input['currentPage'] );

	return $input;

}

// Sanitize Hex Colors
function custom_branding_sanitize_hex( $color ) {
	if ( '' === $color ) {
		return '';
	}

	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

// Settings Pages
function custom_branding_color_schemes() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_color_schemes';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );

}

function custom_branding_branding() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_branding';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );

}

function custom_branding_dashboard() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_dashboard';
	include( ABSPATH . RES . '/branding'  . '/inc/content.php' );
}

function custom_branding_admin_menu() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_admin_menu';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}

function custom_branding_admin_bar_footer() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_admin_bar_footer';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}

function custom_branding_content_notices() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_content_notices';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}

function custom_branding_permissions() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_permissions';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}

function custom_branding_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_settings';
	include( ABSPATH . RES . '/branding'  . '/inc/content.php' );
}

function custom_branding_about() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_about';
	include( ABSPATH . RES . '/branding'  . '/inc/content.php' );
}

function custom_branding_license() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_license';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}

function custom_branding_import_export() {
	if ( ! current_user_can( 'manage_options' ) ) {
		mn_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'custom-branding' ) );
	}

	$page = 'custom_branding_import_export';
	include( ABSPATH . RES . '/branding' . '/inc/content.php' );
}
