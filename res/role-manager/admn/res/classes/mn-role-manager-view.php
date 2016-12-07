<?php
/*
 * Mtaandao Role Manager Mtaandao plugin - HTML output
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3
 * 
 */

class RM_Mn_View {

    public static function add_role_update_network_button() {
?>        
    <div style="margin-top:10px;">
        <button id="rm_update_all_network" class="rm_toolbar_button" title="Update roles for all network">Update Network</button>
    </div>
<?php        
    }
    // end of add_role_update_network_button()

    
    public static function add_user_update_network_button() {
?>        
    <div style="margin-top:10px;">
        <button id="rm_update_all_network" class="rm_toolbar_button" title="Update user roles and capabilities for all network">Update Network</button>
    </div>
<?php        
    }
    // end of add_user_update_network_button()

    
    private static function network_update_dialog_html_role() {
        $lib = RM_Lib_Mn::get_instance();
        $activate_widgets_access_module = $lib->get_option('activate_widgets_access_module', false);

?>    
        <div id="rm_network_update_dialog" class="rm-modal-dialog">
            <div id="rm_network_update_dialog_container">
                <?php echo esc_html__('After confirmation all sites of the network will get permissions from the main site. Are you srm?', 'role-manager');?><br><br>
<?php 
        if (!empty($activate_widgets_access_module)) {
?>              
                <?php echo esc_html__('It is possible to replicate also:', 'role-manager'); ?><br>
                <input type="checkbox" id="rm_replicate_widgets_access_restrictions0" name="rm_replicate_widgets_access_restrictions0" value="1">
                <label for="rm_replicate_widgets_access_restrictions0"><?php echo esc_html__('Widgets access restrictions', 'role-manager');?></label>
<?php
        }
?>
                
            </div>    
        </div>    

<?php            
    }
    // end of network_update_dialog_html_role()
    
    
    private static function network_update_dialog_html_user() {

?>    
        <div id="rm_network_update_dialog" class="rm-modal-dialog">
            <div id="rm_network_update_dialog_container">
                <?php echo esc_html__('After confirmation this user will be added to all sites with the same permissions as he has at the main site. Are you srm?', 'role-manager');?><br><br>
                
            </div>    
        </div>    

<?php            
        
    }
    // end of network_update_dialog_html_user()
    
    
    public static function network_update_dialog_html() {
        $lib = RM_Lib_Mn::get_instance();
        if ($lib->rm_object=='role') {
            self::network_update_dialog_html_role();
        } else {
            self::network_update_dialog_html_user();
        }            
    }
    // end of network_update_dialog_html()

    
}
// end of RM_Mn_View class