<?php
/*
 * Mtaandao Role Manager Mtaandao plugin
 * Class RM_Admin_Menu_View - support stuff for MN admin dashboard menu show in Role Manager admin menu access add-on
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://mtaandao.co.ke
 * License: GPL v3+ 
 */
class RM_Admin_Menu_View {

    private $menu = null;   // menu copy to use during AJAX request
    private $submenu = null;    // submenu copy to use during AJAX request

    
    public static function add_toolbar_buttons() {
        
        if (!current_user_can('rm_admin_menu_access')) {
            return;
        }
        
?>
                
        <button id="rm_admin_menu_access_button" class="rm_toolbar_button" title="Prohibit access to selected menu items">User Menu</button> 
               
<?php

    }
    // end of add_toolbar_buttons()

    
    public static function add_js() {
        
        mn_register_script('rm-admin-menu-access', admin_url( '/js/admn/rm-admn-admin-menu-access.js', RM_PLUGIN_FULL_PATH));
        mn_enqueue_script ('rm-admin-menu-access');
        mn_localize_script('rm-admin-menu-access', 'rm_data_admin_menu_access', 
                array(
                    'admin_menu' => esc_html__('Admin Menu', 'role-manager'),
                    'dialog_title' => esc_html__('Admin menu', 'role-manager'),
                    'update_button' => esc_html__('Update', 'role-manager')                    
                ));
        
    }
    // end of add_js()
    
    
    public static function dialog_html() {
        
?>
        <div id="rm_admin_menu_access_dialog" class="rm-modal-dialog">
            <div id="rm_admin_menu_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()

    
    
    /**
     * 
     * @param array $current_menu
     * @param array $current_submenu
     */     
    private function update_profile_menu($allowed_caps) {
    
        $this->menu[70] = array( __('Profile'), 'read', 'profile.php', 'profile.php');
        unset($this->submenu['users.php']);
        $this->submenu['profile.php'][5] = array(__('Your Profile'), 'read', 'profile.php', 'profile.php');
        if (array_key_exists('create_users', $allowed_caps)) {
            $this->submenu['profile.php'][10] = array(__('Add New User'), 'create_users', 'user-new.php', 'user-new.php');
        } else {
            $this->submenu['profile.php'][10] = array(__('Add New User'), 'promote_users', 'user-new.php', 'user-new.php');
        }        
        
    }
    // end of update_profile_menu()
    

    /**
     * Update Gravity Forms menu permissions as it may has gf_full_access got for the superadmin user under MN multisite
     * @param array $current_menu
     * @param array $current_submenu
     */
    private function update_gravity_forms_menu($allowed_caps) {
                
        $min_cap = RM_Admin_Menu::min_cap($allowed_caps, GFCommon::all_caps());
        $gf_caps_map = array(
            'gf_edit_forms'=>'gravityforms_edit_forms',
            'gf_new_form'=>'gravityforms_create_form',
            'gf_entries'=>'gravityforms_view_entries',
            'gf_settings'=>'gravityforms_view_settings',
            'gf_export'=>'gravityforms_export_entries',
            'gf_update'=>'gravityforms_view_updates',
            'gf_addons'=>'gravityforms_view_addons',
            'gf_help'=>$min_cap            
        );
        $addon_menus = apply_filters("gform_addon_navigation", array());
        if (count($addon_menus)>0) {
            foreach($addon_menus as $addon_menu) {
                $gf_caps_map[esc_html($addon_menu['name'])] = $addon_menu['permission'];
            }
        }
        $this->menu['16.9'][1] = $min_cap;
        foreach($this->submenu['gf_edit_forms'] as $key=>$item) {
            $this->submenu['gf_edit_forms'][$key][1] = $gf_caps_map[$item[2]];
        }
    }
    // end of update_gravity_forms_menu()    

    
    private function is_read_only($current_role) {
        if ($current_role!=='administrator') {  // make read-only the MN built-in admininstrator role only
            return false;
        }
        
        $lib = RM_Lib_Mn::get_instance();
        if ($lib->multisite && is_super_admin()) {
            return false;
        }
        
        return true;        
    }
    // end of is_read_only()
    

    public function get_html($user=null) {   
                
        if (!current_user_can('rm_admin_menu_access')) {
            $answer = array('result'=>'error', 'message'=>esc_html__('RM: Insufficient permissions to use this add-on','role-manager'));
            return $answer;
        }
                
        $allowed_roles = RM_Admin_Menu::get_allowed_roles($user);
        $allowed_caps = RM_Admin_Menu::get_allowed_caps($allowed_roles, $user);
        $this->menu = get_option(RM_Admin_Menu::ADMIN_MENU_COPY_KEY);
        $this->submenu = get_option(RM_Admin_Menu::ADMIN_SUBMENU_COPY_KEY);
        if (!array_key_exists('list_users', $allowed_caps)) {
            $this->update_profile_menu($allowed_caps);
        }
        if (/*is_multisite() && */array_key_exists('16.9', $this->menu) && 
            !array_key_exists('gform_full_access', $allowed_caps)) {  // Gravity Forms
            $this->update_gravity_forms_menu($allowed_caps);
        }
                
        $readonly_mode = $this->is_read_only($allowed_roles[0]);
        if (empty($user)) {
            $rm_object_type = 'role';
            $rm_object_name = $allowed_roles[0];
            $blocked_items = RM_Admin_Menu::load_menu_access_data_for_role($rm_object_name);
        } else {
            $rm_object_type = 'user';
            $rm_object_name = $user->user_login;
            $blocked_items = RM_Admin_Menu::load_menu_access_data_for_user($rm_object_name);
        }
        
        ob_start();
?>
<form name="rm_admin_menu_access_form" id="rm_admin_menu_access_form" method="POST"
      action="<?php echo RM_MN_ADMIN_URL . RM_PARENT.'?page=users-'.RM_PLUGIN_FILE;?>" >
    <span style="font-weight: bold;"><?php echo esc_html_e('Block menu items:', 'role-manager');?></span>&nbsp;&nbsp;
    <input type="radio" name="rm_admin_menu_access_model" id="rm_admin_menu_access_model_selected" value="1" 
        <?php echo ($blocked_items['access_model']==1) ? 'checked="checked"' : '';?> > <label for="rm_admin_menu_access_model_selected"><?php esc_html_e('Selected', 'role-manager');?></label> 
    <input type="radio" name="rm_admin_menu_access_model" id="rm_admin_menu_access_model_not_selected" value="2" 
        <?php echo ($blocked_items['access_model']==2) ? 'checked="checked"' : '';?> > <label for="rm_admin_menu_access_model_not_selected"><?php esc_html_e('Not Selected', 'role-manager');?></label>
    <hr/>
<table id="rm_admin_menu_access_table">    
    <th>
<?php
    if (!$readonly_mode) {
?>        
        <input type="checkbox" id="rm_admin_menu_select_all">
<?php
    }
?>
    </th>
    <th><?php esc_html_e('Menu', 'role-manager');?></th>
    <th><?php esc_html_e('Submenu','role-manager');?></th>
    <th><?php esc_html_e('User capability', 'role-manager');?></th>
    <th><?php esc_html_e('URL', 'role-manager');?></th>
<?php
        foreach($this->menu as $menu_item) {            
            if (!RM_Admin_Menu::has_permission($menu_item[1], $allowed_roles, $allowed_caps)) {
                continue;   // user has no access to this menu item - skip it
            }            
            $item_id = RM_Admin_Menu::calc_menu_item_id('menu', $menu_item[3]);
            $key_pos = strpos($menu_item[0], '<span');
            $menu_title = ($key_pos===false) ? $menu_item[0] : substr($menu_item[0], 0, $key_pos);
?>
    <tr>
        <td>   
<?php 
    if (!$readonly_mode) {
        $checked = in_array($item_id, $blocked_items['data']) ? 'checked' : '';
?>
            <input type="checkbox" name="<?php echo $item_id;?>" id="<?php echo $item_id;?>" class="rm-cb-column" <?php echo $checked;?> />
<?php
    }
?>
        </td>
        <td><?php echo $menu_title;?></td>
        <td></td>
        <td style="color:#cccccc;"><?php echo $menu_item[1];?></td>
        <td style="color:#cccccc; padding-left:10px;"><?php echo $menu_item[3];?></td>
    </tr>        
<?php
            if (!isset($this->submenu[$menu_item[2]])) {
                continue;
            }
            
            foreach($this->submenu[$menu_item[2]] as $submenu_item) {
                if (!RM_Admin_Menu::has_permission($submenu_item[1], $allowed_roles, $allowed_caps)) {
                    continue;   // user has not access to this submenu item- skip it
                }                    
                $item_id = RM_Admin_Menu::calc_menu_item_id('submenu', $submenu_item[3]);
                $key_pos = strpos($submenu_item[0], '<span');
                $menu_title = ($key_pos===false) ? $submenu_item[0] : substr($submenu_item[0], 0, $key_pos);
?> 
    <tr>        
        <td>   
<?php 
                    if (!$readonly_mode) {
                        $checked = in_array($item_id, $blocked_items['data']) ? 'checked' : '';
?>                      
            <input type="checkbox" name="<?php echo $item_id;?>" id="<?php echo $item_id;?>" class="rm-cb-column" <?php echo $checked;?> />
<?php
    }
?>
        </td>
        <td></td>
        <td><?php echo $menu_title;?></td>
        <td style="color:#cccccc;"><?php echo $submenu_item[1];?></td>
        <td style="color:#cccccc; padding-left:10px;"><?php echo $submenu_item[3];?></td>
    </tr>    
<?php    
            }   // foreach($this->submenu            
        }   // foreach($this->menu)
?>
</table> 
    <input type="hidden" name="action" id="action" value="rm_update_admin_menu_access" />
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
        
        $this->menu = null;
        $this->submenu = null;
        
        if (!empty($user)) {
            $current_object = $user->user_login;
        } else {
            $current_object = $allowed_roles[0];
        }
     
        return array('result'=>'success', 'message'=>'Admin menu permissions for '+ $current_object, 'html'=>$html);
    }
    // end of get_menu_html()

}
// end of RM_Admin_Menu_View class