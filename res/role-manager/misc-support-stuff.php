<?php

/*
 * Miscellaneous support stuff, which should still be defined beyond of classes
 * 
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: http://mtaandao.co.ke
 * License: GPL v3
 * 
*/

if (class_exists('GFForms') ) {    // if Gravity Forms is installed
// Support for Gravity Forms capabilities
// As Gravity Form has integrated support for the Members plugin - let's imitate its presense,
// so GF code, like
// self::has_members_plugin())
// considers that it is has_members_plugin()   
    if (!function_exists('members_get_capabilities')) { 
        include_once( ABSPATH . 'admin/res/plugin.php' );
        if (!is_plugin_active('members/members.php')) {            
            // define stub function to say "Gravity Forms" plugin: 'Hey! While I'm not the "Members" plugin, but I'm "Role Manager" and 
            // I'm  capable to manage your roles and capabilities too        
            function members_get_capabilities() {
        
            }
        }
    }
}


if (!function_exists('rm_get_post_view_access_users')) {
    function rm_get_post_view_access_users($post_id) {
        if (!$GLOBALS['role_manager']->is_pro()) {
            return false;
        }
        
        $result = $GLOBALS['role_manager']->get_post_view_access_users($post_id); 
        
        return $result;
    }   
    // end of rm_get_post_view_users()
    
}   


if (!function_exists('rm_hide_admin_bar')) {
    function rm_hide_admin_bar() {
        
        show_admin_bar(false);
        
    }
    // end of hide_admin_bar()
}