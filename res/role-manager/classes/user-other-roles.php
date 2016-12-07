<?php
/*
 * Project: Role Manager Mtaandao plugin 
 * Class for Assigning to a user multiple roles
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+
 * 
*/

class RM_User_Other_Roles {

    protected $lib = null;
    
    
    function __construct() {
    
        $this->lib = RM_Lib::get_instance();
        $this->set_hooks();
    }
    // end of $lib
    
    
    public function set_hooks() {
        
        if (is_admin()) {
            add_filter( 'additional_capabilities_display', array($this, 'additional_capabilities_display'), 10, 1);        
            add_action( 'admin_print_styles-user-edit.php', array($this, 'load_css') );
            add_action( 'admin_print_styles-user-new.php', array($this, 'load_css') );
            add_action( 'admin_enqueue_scripts', array($this, 'load_js' ) );
            add_action( 'edit_user_profile', array($this, 'edit_user_profile_html'), 10, 1 );
            add_action( 'user_new_form', array($this, 'user_new_form'), 10, 1 );
            add_action( 'profile_update', array($this, 'update'), 10 );
        }
        if ($this->lib->multisite) {          
            add_action( 'mnmu_activate_user', array($this, 'add_other_roles'), 10, 1 );
        }
        add_action( 'user_register', array($this, 'add_other_roles'), 10, 1 );
            
    }
    // end of set_hooks()
    
    
    public function additional_capabilities_display($display) {
        
        $display = false;
        
        return $display;
        
    }
    // end of additional_capabilities_display()    
    
    
    /*
     * Load CSS for the user profile edit page
     */
    public function load_css() {
        
        mn_enqueue_style('mn-jquery-ui-dialog');
        mn_enqueue_style('rm-jquery-multiple-select', admin_url('/css/multiple-select.css', RM_PLUGIN_FULL_PATH), array(), false, 'screen');
        
    }
    // end of load_css()                


    public function load_js($hook_suffix)  {
        
        if (!in_array($hook_suffix, array('user-edit.php', 'user-new.php'))) {
            return;
        }
        
        mn_enqueue_script('jquery-ui-dialog', false, array('jquery-ui-core', 'jquery-ui-button', 'jquery'));
        mn_register_script('rm-jquery-multiple-select', admin_url('/js/jquery.multiple.select.js', RM_PLUGIN_FULL_PATH));
        mn_enqueue_script('rm-jquery-multiple-select');
        mn_register_script('rm-user-admnfile-other-roles', admin_url('/js/rm-user-admnfile-other-roles.js', RM_PLUGIN_FULL_PATH));
        mn_enqueue_script('rm-user-admnfile-other-roles');
        mn_localize_script('rm-user-admnfile-other-roles', 'rm_data_user_profile_other_roles', array(
            'mn_nonce' => mn_create_nonce('role-manager'),
            'other_roles' => esc_html__('Other Roles', 'role-manager'),
            'select_roles' => esc_html__('Select additional roles for this user', 'role-manager')
        ));
    }
    // end of load_js()
    
    
    /**
     * Returns list of user roles, except 1st one, and bbPress assigned as they are shown by Mtaandao and bbPress theirselves.
     * 
     * @param type $user MN_User from res/capabilities.php
     * @return array
     */
    public function get_roles_array($user) {

        if (!is_array($user->roles) || count($user->roles) <= 1) {
            return array();
        }

        // get bbPress assigned user role
        if (function_exists('bbp_filter_blog_editable_roles')) {
            $bb_press_role = bbp_get_user_role($user->ID);
        } else {
            $bb_press_role = '';
        }

        $roles = array();
        foreach ($user->roles as $key => $value) {
            if (!empty($bb_press_role) && $bb_press_role === $value) {
                // exclude bbPress assigned role
                continue;
            }
            $roles[] = $value;
        }
        array_shift($roles); // exclude primary role which is shown by Mtaandao itself

        return $roles;
    }
    // end of get_roles_array()    
    

    private function roles_select_html($user) {
        
        global $mn_roles;
                
        $user_roles = $user->roles;
        $primary_role = array_shift($user_roles);
        $roles = apply_filters('editable_roles', $mn_roles->roles);    // exclude restricted roles if any        
        if (isset($roles[$primary_role])) { // exclude role assigned to the user as a primary role
            unset($roles[$primary_role]);
        }
        $other_roles = $this->get_roles_array($user);
                
        echo '<select multiple="multiple" id="rm_select_other_roles" name="rm_select_other_roles" style="width: 500px;" >'."\n";
        foreach($roles as $key=>$role) {
            echo '<option value="'.$key.'" >'.$role['name'].'</option>'."\n";
        }   // foreach()
        echo '</select><br>'."\n";
                
        if (is_array($other_roles) && count($other_roles) > 0) {
            $other_roles_str = implode(',', $other_roles);
        } else {
            $other_roles_str = '';
        }
            echo '<input type="hidden" name="rm_other_roles" id="rm_other_roles" value="' . $other_roles_str . '" />';
        
        
        $output = $this->lib->roles_text($other_roles);        
        echo '<span id="rm_other_roles_list">'. $output .'</span>';
    }
    // end of roles_select()    
    
    
    private function user_profile_capabilities($user) {
        global $current_user;
        
        $user_caps = $this->lib->get_edited_user_caps($user);
?>
          <tr>
              <th>
                  <?php esc_html_e('Capabilities', 'role-manager'); ?>
              </th>    
              <td>
<?php 
                echo $user_caps .'<br/>'; 
      if ($this->lib->user_is_admin($current_user->ID)) {
            echo '<a href="' . mn_nonce_url("users.php?page=users-".RM_PLUGIN_FILE."&object=user&amp;user_id={$user->ID}", "rm_user_{$user->ID}") . '">' . 
                 esc_html__('Edit', 'role-manager') . '</a>';
      }                      
?>
              </td>
          </tr>    
<?php                
    }
    // end of user_profile_capabilities()
    
    
    private function display($user, $context) {
?>
        <table class="form-table">
        		<tr>
        			<th scope="row"><?php esc_html_e('Other Roles', 'role-manager'); ?></th>
        			<td>
<?php
            $this->roles_select_html($user);            
?>
        			</td>
        		</tr>
<?php
    if ($context=='user-edit') {
        $this->user_profile_capabilities($user);
    }
?>
        </table>		
        <?php
        
    }
    // end of display()
    
    
    /**
     * Add RM stuff to the edit user profile page
     * 
     * @global object $current_user
     * @param object $user
     * @return void
     */
    public function edit_user_profile_html($user) {
                
        if (!$this->lib->is_user_profile_extention_allowed()) {  
            return;
        }
        $show = apply_filters('rm_show_additional_capabilities_section', true);
        if (empty($show)) {
            return;
        }
?>
        <h3><?php esc_html_e('Additional Capabilities', 'role-manager'); ?></h3>
<?php
        $this->display($user, 'user-edit');
    }
    // end of edit_user_profile()

    
    public function user_new_form($context) {
        $show = apply_filters('rm_show_additional_capabilities_section', true);
        if (empty($show)) {
            return;
        }
        
        $user = new MN_User();
?>
        <table>
<?php            
        $this->display($user, $context);
?>            
        </table>
<?php        
    }
    // end of edit_user_profile_html()
    
    
    // save additional user roles when user profile is updated, as Mtaandao itself doesn't know about them
    public function update($user_id) {

        global $mn_roles;
        
        if (!current_user_can('edit_users')) {
            return false;
        }
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }
        $user = get_userdata($user_id);

        if (empty($_POST['rm_other_roles'])) {
            return false;
        }
        
        $data = explode(',', str_replace(' ', '', $_POST['rm_other_roles']));
        $rm_other_roles = array();
        foreach($data as $role_id) {
            if (!isset($mn_roles->roles[$role_id])) {   // skip unexisted roles
                continue;
            }
            if (is_array($user->roles) && !in_array($role_id, $user->roles)) {
                $rm_other_roles[] = $role_id;
            }
        }
        foreach ($rm_other_roles as $role) {
            $user->add_role($role);
        }
        
        return true;        
    }
    // end of update()

    
    private function add_default_other_roles($user_id) {
        $user = get_user_by('id', $user_id);
        if (empty($user->ID)) {
            return;
        }

        // Get default roles if any
        $other_default_roles = $this->lib->get_option('other_default_roles', array());
        if (count($other_default_roles) == 0) {
            return;
        }
        foreach ($other_default_roles as $role) {
            if (!isset($user->caps[$role])) {
                $user->add_role($role);
            }
        }
    }

    // end of add_default_other_roles()


    public function add_other_roles($user_id) {

        if (empty($user_id)) {
            return;
        }

        $result = $this->update($user_id);
        if ($result) {    // roles were assigned manually
            return;
        }

        $this->add_default_other_roles($user_id);
    }
    // end of add_other_roles()    
    
    
    
}
// end of RM_User_Other_Roles class
