<?php

/*
 * Constant definitions for use in Role Manager Mtaandao plugin
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: http://mtaandao.co.ke
 * 
*/

define('RM_MN_ADMIN_URL', admin_url());
define('RM_ERROR', 'Error is encountered');
define('RM_SPACE_REPLACER', '_RM-SR_');
define('RM_PARENT', is_network_admin() ? 'network/users.php':'users.php');
define('RM_KEY_CAPABILITY', 'rm_edit_roles');