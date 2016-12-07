<?php
function custom_branding_update_db() {

	set_time_limit( 0 );

	// This sets the original db version. Multisite was introduced later, so it starts at 4.
	if ( is_multisite() && is_main_site() ) {
		if ( ! get_site_option( 'custom_branding_db' ) ) {
			$current_db_ver = '4';
		} else {
			$current_db_ver = get_site_option( 'custom_branding_db' );
		}
	} else {
		if ( ! get_option( 'custom_branding_db' ) ) {
			$current_db_ver = '1';
		} else {
			$current_db_ver = get_option( 'custom_branding_db' );
		}
	}

	$target_db_ver = CUSTOM_BRANDING_DB;

	while ( $current_db_ver < $target_db_ver ) {

		$current_db_ver ++;

		$function = "custom_branding_update_{$current_db_ver}";
		if ( function_exists( $function ) ) {
			call_user_func( $function );
		}

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_db', $current_db_ver );
		} else {
			update_option( 'custom_branding_db', $current_db_ver );
		}
	}

}

function custom_branding_update_2() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {
		date_default_timezone_set( 'America/Los_Angeles' );
		$date = date( 'Y-m-d H:i:s' );

		$custom_branding_settings['licenseDate'] = $date;
		$custom_branding_settings['contentHideScreenOptions'] = '';

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );

		}
	}
}

function custom_branding_update_3() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {

		$custom_branding_settings['loginLinkTitle'] = '';
		$custom_branding_settings['loginLinkUrl'] = '';

		if ( isset( $custom_branding_settings['adminMenu'] ) ) {
			foreach ( $custom_branding_settings['adminMenu'] as $menuOrder => $menuItem ) {
				foreach ( $menuItem as $menuTitle => $menuSlugArray ) {
					foreach ( $menuSlugArray as $menuSlug => $menuHide ) {
						if ( '0' !== $menuHide ) {
							$theMenuItem = base64_encode( serialize( array(
								'Sort'  => esc_attr( $menuOrder ),
								'Title' => esc_attr( $menuTitle ),
								'Slug'  => esc_attr( $menuSlug )
							) ) );
							$theMenu[ $theMenuItem ] = 'on';
						}
					}
				}
			}
			$custom_branding_settings['adminMenu'] = '';
			if ( isset( $theMenu ) ) {
				$custom_branding_settings['adminMenu'] = $theMenu;
			}
		}

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );
		}
	}
}

function custom_branding_update_4() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {

		$custom_branding_settings['loginLogoHide'] = '';

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );
		}
	}
}

function custom_branding_update_5() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {

		$custom_branding_settings['noticeHideAllUpdates'] = '';

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );
		}
	}
}

function custom_branding_update_6() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {

		$custom_branding_settings['customLogin'] = '';
		$custom_branding_settings['customLoginURL'] = '';

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );
		}
	}
}

function custom_branding_update_7() {
	global $custom_branding_settings;
	if ( is_array( $custom_branding_settings ) ) {

		$custom_branding_settings['contentHideMNTitle'] = '';

		if ( is_multisite() && is_main_site() ) {
			update_site_option( 'custom_branding_settings', $custom_branding_settings );
		} else {
			update_option( 'custom_branding_settings', $custom_branding_settings );
		}
	}
}

function custom_branding_update_8() {
	if ( is_multisite() && is_main_site() ) {
		add_site_option( 'custom_branding_version', '1.1' );
	} else {
		add_option( 'custom_branding_version', '1.1' );
	}
}