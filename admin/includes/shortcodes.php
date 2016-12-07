<?php
/**
 * Mtaandao Shortcodes
 *
 * Plugin for shortcodes 
 *
 * @package Mtaandao
 * @subpackage Shortcodes
 * @since 16.07.1
 */

// Define plugin constants
define( 'SM_PLUGIN_FILE', __FILE__ );
define( 'SM_PLUGIN_VERSION', '16.07.1' );
define( 'SM_ENABLE_CACHE', true );

// Includes
require_once ( ABSPATH . RES . '/shortcodes/inc/vendor/sunrise.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/admin-views.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/requirements.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/load.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/assets.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/shortcodes.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/tools.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/data.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/generator-views.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/generator.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/widget.php');
require_once ( ABSPATH . RES . '/shortcodes/inc/core/counters.php');
