<?php
/**
 * Locale API
 *
 * @package Mtaandao
 * @subpackage i18n
 * @since 1.2.0
 */

/** MN_Locale class */
require_once ABSPATH . RES . '/class-mn-locale.php';

/**
 * Checks if current locale is RTL.
 *
 * @since 3.0.0
 *
 * @global MN_Locale $mn_locale
 *
 * @return bool Whether locale is RTL.
 */
function is_rtl() {
	global $mn_locale;
	return $mn_locale->is_rtl();
}
