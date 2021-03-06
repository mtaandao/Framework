<?php
/*
 * User Role Editor Mtaandao plugin
 * Class URE_Widgets_Show_Controller - data controller for Widgets Show Access add-on
 * Author: Mtaandao
 * Author email: support@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v2+ 
 */

class URE_Widgets_Show_Controller {

    const ACCESS_DATA_KEY = 'ure_widgets_show_access_data';
    const NO_ROLE = 'no_role_for_this_site';
            

    // load data
    public static function load($widget_id='') {
        
        $template = array('widget_id'=>'', 'access_model'=>1, 'roles'=>array());        
        if (empty($widget_id)) {
            return $template;
        }
        $template['widget_id'] = $widget_id;
        
        $data = get_option(self::ACCESS_DATA_KEY);
        
        if (empty($data) || !isset($data[$widget_id])) {
            return $template;
        }
        
        $result = $data[$widget_id];
        
        return $result;        
    }
    // end of load()

    
    private static function get_roles_from_post() {
        global $mn_roles;
        
        $roles = array();
        foreach($_POST as $key=>$value) {
            $pos = strpos($key, 'ure_role_');
            if ($pos===false) {
                continue;
            }
            $role_id = substr($key, 9);
            if (isset($mn_roles->roles[$role_id]) || $role_id==self::NO_ROLE) {
                $roles[] = $role_id;
            }
        }
        
        return $roles;
    }
    // end of get_roles_from_posts()
    
    
    // save data
    public static function save() {
        if ( stripos($_SERVER['REQUEST_URI'], 'admin/widgets.php')===false ) {
            return;
        }
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        if ($action!=='ure_update_widgets_show_access_data') {
            return;
        }
        if (empty($_POST['ure_nonce']) || !mn_verify_nonce($_POST['ure_nonce'], 'user-role-editor')) {
            mn_die('Wrong nonce value. Action prohibited', 'Access error', 403);
        }
        
        $widget_id = filter_input(INPUT_POST, 'ure_widget_id', FILTER_SANITIZE_STRING);
        if (empty($widget_id)) {
            mn_die('Wrong widget ID. Action prohibited', 'Access error', 403);
        }
        
        $access_model = filter_input(INPUT_POST, 'ure_access_model', FILTER_SANITIZE_NUMBER_INT);
        if (empty($access_model)) {
            $access_model = 1;  // Do not show for selected roles
        }
        
        $roles = self::get_roles_from_post();
                        
        $data = get_option(self::ACCESS_DATA_KEY, array());
        $data[$widget_id] = array('access_model'=>$access_model, 'roles'=>$roles);
        update_option(self::ACCESS_DATA_KEY, $data);
        
    }
    // end of save()
    
    
}
// end of class URE_Widgets_Show_Controller