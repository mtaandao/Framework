<?php
/**
 * Mtaandao Translation Install Administration API
 *
 * @package Mtaandao
 * @subpackage Administration
 */


/**
 * Retrieve translations from Mtaandao Translation API.
 *
 * @since 4.0.0
 *
 * @param string       $type Type of translations. Accepts 'plugins', 'themes', 'core'.
 * @param array|object $args Translation API arguments. Optional.
 * @return object|MN_Error On success an object of translations, MN_Error on failure.
 */
function translations_api( $type, $args = null ) {
	include( ABSPATH . RES . '/version.php' ); // include an unmodified $mn_version

	if ( ! in_array( $type, array( 'plugins', 'themes', 'core' ) ) ) {
		return	new MN_Error( 'invalid_type', __( 'Invalid translation type.' ) );
	}

	/**
	 * Allows a plugin to override the mtaandao.co.ke Translation Install API entirely.
	 *
	 * @since 4.0.0
	 *
	 * @param bool|array  $result The result object. Default false.
	 * @param string      $type   The type of translations being requested.
	 * @param object      $args   Translation API arguments.
	 */
	$res = apply_filters( 'translations_api', false, $type, $args );

	if ( false === $res ) {
		$url = $http_url = 'http://api.mtaandao.co.ke/translations/' . $type . '/1.0/';
		if ( $ssl = mn_http_supports( array( 'ssl' ) ) ) {
			$url = set_url_scheme( $url, 'https' );
		}

		$options = array(
			'timeout' => 3,
			'body' => array(
				'mn_version' => $mn_version,
				'locale'     => get_locale(),
				'version'    => $args['version'], // Version of plugin, theme or core
			),
		);

		if ( 'core' !== $type ) {
			$options['body']['slug'] = $args['slug']; // Plugin or theme slug
		}

		$request = mn_remote_post( $url, $options );

		if ( $ssl && is_mn_error( $request ) ) {
			trigger_error( __( 'An unexpected error occurred. Something may be wrong with mtaandao.co.ke or this server&#8217;s configuration. If you continue to have problems, please try the <a href="https://mtaandao.co.ke/support/">support forums</a>.' ) . ' ' . __( '(Mtaandao could not establish a secure connection to mtaandao.co.ke. Please contact your server administrator.)' ), headers_sent() || MN_DEBUG ? E_USER_WARNING : E_USER_NOTICE );

			$request = mn_remote_post( $http_url, $options );
		}

		if ( is_mn_error( $request ) ) {
			$res = new MN_Error( 'translations_api_failed', __( 'An unexpected error occurred. Something may be wrong with mtaandao.co.ke or this server&#8217;s configuration. If you continue to have problems, please try the <a href="https://mtaandao.co.ke/support/">support forums</a>.' ), $request->get_error_message() );
		} else {
			$res = json_decode( mn_remote_retrieve_body( $request ), true );
			if ( ! is_object( $res ) && ! is_array( $res ) ) {
				$res = new MN_Error( 'translations_api_failed', __( 'An unexpected error occurred. Something may be wrong with mtaandao.co.ke or this server&#8217;s configuration. If you continue to have problems, please try the <a href="https://mtaandao.co.ke/support/">support forums</a>.' ), mn_remote_retrieve_body( $request ) );
			}
		}
	}

	/**
	 * Filters the Translation Install API response results.
	 *
	 * @since 4.0.0
	 *
	 * @param object|MN_Error $res  Response object or MN_Error.
	 * @param string          $type The type of translations being requested.
	 * @param object          $args Translation API arguments.
	 */
	return apply_filters( 'translations_api_result', $res, $type, $args );
}

/**
 * Get available translations from the mtaandao.co.ke API.
 *
 * @since 4.0.0
 *
 * @see translations_api()
 *
 * @return array Array of translations, each an array of data. If the API response results
 *               in an error, an empty array will be returned.
 */
function mn_get_available_translations() {
	if ( ! mn_installing() && false !== ( $translations = get_site_transient( 'available_translations' ) ) ) {
		return $translations;
	}

	include( ABSPATH . RES . '/version.php' ); // include an unmodified $mn_version

	$api = translations_api( 'core', array( 'version' => $mn_version ) );

	if ( is_mn_error( $api ) || empty( $api['translations'] ) ) {
		return array();
	}

	$translations = array();
	// Key the array with the language code for now.
	foreach ( $api['translations'] as $translation ) {
		$translations[ $translation['language'] ] = $translation;
	}

	if ( ! defined( 'MN_INSTALLING' ) ) {
		set_site_transient( 'available_translations', $translations, 3 * HOUR_IN_SECONDS );
	}

	return $translations;
}

/**
 * Output the select form for the language selection on the installation screen.
 *
 * @since 4.0.0
 *
 * @global string $mn_local_package
 *
 * @param array $languages Array of available languages (populated via the Translation API).
 */
function mn_install_language_form( $languages ) {
	global $mn_local_package;

	$installed_languages = get_available_languages();

	echo "<label class='screen-reader-text' for='language'>Select a default language</label>\n";
	echo "<select size='14' name='language' id='language'>\n";
	echo '<option value="" lang="en" selected="selected" data-continue="Continue" data-installed="1">English (United States)</option>';
	echo "\n";

	if ( ! empty( $mn_local_package ) && isset( $languages[ $mn_local_package ] ) ) {
		if ( isset( $languages[ $mn_local_package ] ) ) {
			$language = $languages[ $mn_local_package ];
			printf( '<option value="%s" lang="%s" data-continue="%s"%s>%s</option>' . "\n",
				esc_attr( $language['language'] ),
				esc_attr( current( $language['iso'] ) ),
				esc_attr( $language['strings']['continue'] ),
				in_array( $language['language'], $installed_languages ) ? ' data-installed="1"' : '',
				esc_html( $language['native_name'] ) );

			unset( $languages[ $mn_local_package ] );
		}
	}

	foreach ( $languages as $language ) {
		printf( '<option value="%s" lang="%s" data-continue="%s"%s>%s</option>' . "\n",
			esc_attr( $language['language'] ),
			esc_attr( current( $language['iso'] ) ),
			esc_attr( $language['strings']['continue'] ),
			in_array( $language['language'], $installed_languages ) ? ' data-installed="1"' : '',
			esc_html( $language['native_name'] ) );
	}
	echo "</select>\n";
	echo '<p class="step"><span class="spinner"></span><input id="language-continue" type="submit" class="button button-primary button-large" value="Continue" /></p>';
}

/**
 * Download a language pack.
 *
 * @since 4.0.0
 *
 * @see mn_get_available_translations()
 *
 * @param string $download Language code to download.
 * @return string|bool Returns the language code if successfully downloaded
 *                     (or already installed), or false on failure.
 */
function mn_download_language_pack( $download ) {
	// Check if the translation is already installed.
	if ( in_array( $download, get_available_languages() ) ) {
		return $download;
	}

	if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS ) {
		return false;
	}

	// Confirm the translation is one we can download.
	$translations = mn_get_available_translations();
	if ( ! $translations ) {
		return false;
	}
	foreach ( $translations as $translation ) {
		if ( $translation['language'] === $download ) {
			$translation_to_load = true;
			break;
		}
	}

	if ( empty( $translation_to_load ) ) {
		return false;
	}
	$translation = (object) $translation;

	require_once ABSPATH . 'admin/includes/class-mn-upgrader.php';
	$skin = new Automatic_Upgrader_Skin;
	$upgrader = new Language_Pack_Upgrader( $skin );
	$translation->type = 'core';
	$result = $upgrader->upgrade( $translation, array( 'clear_update_cache' => false ) );

	if ( ! $result || is_mn_error( $result ) ) {
		return false;
	}

	return $translation->language;
}

/**
 * Check if Mtaandao has access to the filesystem without asking for
 * credentials.
 *
 * @since 4.0.0
 *
 * @return bool Returns true on success, false on failure.
 */
function mn_can_install_language_pack() {
	if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS ) {
		return false;
	}

	require_once ABSPATH . 'admin/includes/class-mn-upgrader.php';
	$skin = new Automatic_Upgrader_Skin;
	$upgrader = new Language_Pack_Upgrader( $skin );
	$upgrader->init();

	$check = $upgrader->fs_connect( array( MAIN, MN_LANG_DIR ) );

	if ( ! $check || is_mn_error( $check ) ) {
		return false;
	}

	return true;
}
