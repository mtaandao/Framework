<?php
/**
 * Mtaandao Role Manager
 *
 * Create, edit or delete Users from your Mtaandao site.
 *
 * @package Mtaandao
 * @subpackage Users
 * @since 16.07.1
 */

if (!function_exists('get_option')) {
  header('HTTP/1.0 403 Forbidden');
  die;  // Silence is golden, direct call is prohibited
}
    
define('RM_VERSION', '4.25.1');
define('RM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('RM_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
define('RM_PLUGIN_FILE', basename(__FILE__));
define('RM_PLUGIN_FULL_PATH', __FILE__);

require_once( ABSPATH . RES .'/role-manager/classes/base-lib.php');
require_once( ABSPATH . RES .'/role-manager/classes/rm-lib.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/rm-lib-admn.php');

require_once( ABSPATH . RES .'/role-manager/loader.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/loader.php');

$GLOBALS['role_manager'] = new Role_Manager_Mn();

