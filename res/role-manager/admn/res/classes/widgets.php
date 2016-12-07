<?php

/*
 * Role Manager Mtaandao plugin
 * Class RM_Widgets - support stuff for Widgets Access add-on
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+ 
 */

class RM_Widgets {

    private $lib = null;
    const ACCESS_DATA_KEY = 'rm_widgets_access_data';
    
    
    public function __construct($lib) {
        
        $this->lib = $lib;
        
    }
    // end of __construct()
    
        
    /**
     * Load widgets access data for role
     * @param string $role_id
     * @return array
     */
    public function load_access_data_for_role($role_id) {
        
        $access_data = get_option(self::ACCESS_DATA_KEY);
        if (is_array($access_data) && array_key_exists($role_id, $access_data)) {
            $result =  $access_data[$role_id];
        } else {
            $result = array();
        }
        
        return $result;
    }
    // end of load_access_data_for_role()
    
    
    public function load_access_data_for_user($user) {
    
        if (is_object($user)) {
            $id = $user->ID;
        } else if (is_int($user)) {
            $id = $user;
            $user = get_user_by('id', $user);
        } else {
            $user = get_user_by('login', $user);
            $id = $user->ID;
        }
        
        $blocked = get_user_meta($user->ID, self::ACCESS_DATA_KEY, true);
        if (!is_array($blocked)) {
            $blocked = array();
        }
        
        $access_data = get_option(self::ACCESS_DATA_KEY);
        if (empty($access_data)) {
            $access_data = array();
        }
        
        foreach ($user->roles as $role) {
            if (isset($access_data[$role])) {
                $blocked = array_merge($blocked, $access_data[$role]);
            }
        }
        
        $blocked = array_unique ($blocked);
        
        return $blocked;
    }
    // end of load_access_data_for_user()

    
    protected function get_access_data_from_post() {
        
        $keys_to_skip = array('action', 'rm_nonce', '_mn_http_referer', 'rm_object_type', 'rm_object_name', 'user_role');
        $access_data = array();
        foreach ($_POST as $key=>$value) {
            if (in_array($key, $keys_to_skip)) {
                continue;
            }
            $access_data[] = $key;
        }
        
        return $access_data;
    }
    // end of get_access_data_from_post()
        
    
    public function save_access_data_for_role($role_id) {
        $access_for_role = $this->get_access_data_from_post();
        $access_data = get_option(self::ACCESS_DATA_KEY);        
        if (!is_array($access_data)) {
            $access_data = array();
        }
        if (count($access_for_role)>0) {
            $access_data[$role_id] = $access_for_role;
        } else {
            unset($access_data[$role_id]);
        }
        update_option(self::ACCESS_DATA_KEY, $access_data);
    }
    // end of save_access_data_for_role()
    
    
    public function save_access_data_for_user($user_login) {
        //$access_for_user = $this->get_access_data_from_post();
        // TODO ...
    }
    // end of save_menu_access_data_for_role()   
                    
    
    protected function get_allowed_roles($user) {
        $allowed_roles = array();
        if (empty($user)) {   // request for Role Editor - work with currently selected role
            $current_role = filter_input(INPUT_POST, 'current_role', FILTER_SANITIZE_STRING);
            $allowed_roles[] = $current_role;
        } else {    // request from user capabilities editor - work with that user roles
            $allowed_roles = $user->roles;
        }
        
        return $allowed_roles;
    }
    // end of get_allowed_roles()
                    
    
    public function get_all_widgets() {
        global $mn_widget_factory;
	
        if ( is_object( $mn_widget_factory ) ) {
            return $mn_widget_factory->widgets;
        } else {
            return array();
        }
    }
    // end of get_all_widgets()
    
    
    public function get_html($user=null) {
                
        $allowed_roles = $this->get_allowed_roles($user);        
        $widgets_list = $this->get_all_widgets();
        
        if (empty($user)) {
            $rm_object_type = 'role';
            $rm_object_name = $allowed_roles[0];
            $blocked_items = $this->load_access_data_for_role($rm_object_name);
        } else {
            $rm_object_type = 'user';
            $rm_object_name = $user->user_login;
            $blocked_items = $this->load_access_data_for_user($rm_object_name);
        }
        
        $readonly_mode = (!$this->lib->multisite && $allowed_roles[0]=='administrator') || 
                         ($this->lib->multisite && !is_super_admin()); 
        
        ob_start();
?>
<form name="rm_widgets_access_form" id="rm_widgets_access_form" method="POST"
      action="<?php echo RM_MN_ADMIN_URL . RM_PARENT.'?page=users-'.RM_PLUGIN_FILE;?>" >
<table id="rm_widgets_access_table">
    <th style="color:red;"><?php esc_html_e('Block', 'role-manager');?></th>
    <th><?php esc_html_e('Widget', 'role-manager');?></th>
    <th><?php esc_html_e('Class','role-manager');?></th>
<?php
        foreach($widgets_list as $widget_class=>$widget) {            
?>
    <tr>
        <td>   
<?php 
    if (!$readonly_mode) {
        $checked = in_array($widget_class, $blocked_items) ? 'checked' : '';
?>
            <input type="checkbox" name="<?php echo $widget_class;?>" id="<?php echo $widget_class;?>" <?php echo $checked;?> />
<?php
    }
?>
        </td>
        <td><?php echo $widget->name;?></td>
        <td style="color:#cccccc;"><?php echo $widget_class;?></td>
    </tr>        
<?php
        }   // foreach($widgets_list)
?>
</table> 
    <input type="hidden" name="action" id="action" value="rm_update_widgets_access" />
    <input type="hidden" name="rm_object_type" id="rm_object_type" value="<?php echo $rm_object_type;?>" />
    <input type="hidden" name="rm_object_name" id="rm_object_name" value="<?php echo $rm_object_name;?>" />
<?php
    if ($rm_object_type=='role') {
?>
    <input type="hidden" name="user_role" id="rm_role" value="<?php echo $rm_object_name;?>" />
<?php
    }
?>
    <?php mn_nonce_field('role-manager', 'rm_nonce'); ?>
</form>    
<?php    
        $html = ob_get_contents();
        ob_end_clean();
        
        if (!empty($user)) {
            $current_object = $user->user_login;
        } else {
            $current_object = $allowed_roles[0];
        }
     
        return array('result'=>'success', 'message'=>'Widgets permissions for '+ $current_object, 'html'=>$html);
    }
    // end of get_html()

}
// end of RM_Widgets class
