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
    
define('UR_VERSION', '4.25.1');
define('UR_PLUGIN_URL', ABSPATH . RES .'/user-roles');
define('UR_PLUGIN_DIR', ABSPATH . RES .'/user-roles');
define('UR_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
define('UR_PLUGIN_FILE', basename(__FILE__));
define('UR_PLUGIN_FULL_PATH', ABSPATH . RES .'/user-roles');

require_once( ABSPATH . RES .'/user-roles/classes/base-lib.php');
require_once( ABSPATH . RES .'/user-roles/classes/rm-lib.php');
require_once( ABSPATH . RES .'/user-roles/admin/classes/rm-lib-admin.php');

require_once( ABSPATH . RES .'/user-roles/loader.php');
require_once( ABSPATH . RES .'/user-roles/admin/loader.php');

$GLOBALS['role_manager'] = new User_Roles_Wp();

