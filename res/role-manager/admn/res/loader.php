<?php
/**
 * Load related files
 * Project: Mtaandao Role Manager Mtaandao plugin
 * 
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 *
**/

require_once( ABSPATH . RES .'/role-manager/admn/res/classes/ajax-processor.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/utils.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/mutex.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/plugin-presence.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/bbpress.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/wc-bookings.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/assign-role-admn.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/screen-help-admn.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/access-ui-controller.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/create-posts-cap.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/post-types-own-caps.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/export-import.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/shortcodes.php');

// Additional modules:

// Admin menu access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/admin-menu-copy.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/admin-menu-hashes.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/admin-menu.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/admin-menu-view.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/admin-menu-access.php');

// Widgets access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/widgets.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/widgets-access.php');

// Metaboxes access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/meta-boxes.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/meta-boxes-access.php');

// Other Roles access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/other-roles.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/other-roles-access.php');

// Posts edit access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-view.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-role-controller.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-role.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-user-meta.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-user.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access-bulk-action.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-edit-access.php');            

// Plugins activation access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/plugins-activation-access.php');

// Themes activation access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/designs-access.php');

// Gravity Forms Access
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/gf-access.php');

// Content view restricitons
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/content-view-restrictions-controller.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-view.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/posts-view-access.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/content-view-restrictions-posts-list.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/content-view-restrictions.php');


require_once( ABSPATH . RES .'/role-manager/admn/res/classes/mn-role-manager-view.php');
require_once( ABSPATH . RES .'/role-manager/admn/res/classes/mn-role-manager.php');