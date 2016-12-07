<?php

/*
 * Role Manager Mtaandao plugin
 * Prohibit/Allow view of selected posts (ID list, authors user ID list, categories ID list) for selected role - at Role Manager dialog
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+ 
 */

class RM_Posts_View_Access {
    
    // reference to the code library object
    private $lib = null;        
    private $objects = null;

    
    public function __construct() {
        
        $this->lib = RM_Lib_Mn::get_instance();
        $this->objects = new RM_Posts_View();
        
        add_action('rm_role_edit_toolbar_service', array($this, 'add_toolbar_buttons'));
        add_action('rm_load_js', array($this, 'add_js'));
        add_action('rm_dialogs_html', array($this, 'dialog_html'));
        add_action('rm_process_user_request', array($this, 'update_data'));

    }
    // end of __construct()

    
    public function add_toolbar_buttons() {
        if (current_user_can(RM_Content_View_Restrictions::view_posts_access_cap)) {
            $button_title = esc_html__('Prohibit view selected posts', 'role-manager');
            $button_label = esc_html__('Posts View', 'role-manager');
?>                
            <button id="rm_posts_view_access_button" class="rm_toolbar_button" title="<?php echo $button_title; ?>"><?php echo $button_label; ?></button>
<?php
        }
    }

    // end of add_toolbar_buttons()

    
    public function dialog_html() {
        
?>
        <div id="rm_posts_view_access_dialog" class="rm-modal-dialog">
            <div id="rm_posts_view_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()


    public function add_js() {
        mn_register_script( 'rm-posts-view-access', admin_url( '/js/admn/posts-view-access.js', RM_PLUGIN_FULL_PATH ) );
        mn_enqueue_script ( 'rm-posts-view-access' );
        mn_localize_script( 'rm-posts-view-access', 'rm_data_posts_view_access',
                array(
                    'posts_view' => esc_html__('Posts View', 'role-manager'),
                    'dialog_title' => esc_html__('Posts View Access', 'role-manager'),
                    'update_button' => esc_html__('Update', 'role-manager')
                ));
    }
    // end of add_js()    
        
            
    public function update_data() {
    
        if (!isset($_POST['action']) || $_POST['action']!=='rm_update_posts_view_access') {
            return;
        }
        
        if (!current_user_can(RM_Content_View_Restrictions::view_posts_access_cap)) {
            $this->lib->notification = esc_html__('RM: you have not enough permissions to use this add-on.', 'role-manager');
            return;
        }
        $rm_object_type = filter_input(INPUT_POST, 'rm_object_type', FILTER_SANITIZE_STRING);
        if ($rm_object_type!=='role' && $rm_object_type!=='user') {
            $this->lib->notification = esc_html__('RM: posts view access: Wrong object type. Data was not updated.', 'role-manager');
            return;
        }
        $rm_object_name = filter_input(INPUT_POST, 'rm_object_name', FILTER_SANITIZE_STRING);
        if (empty($rm_object_name)) {
            $this->lib->notification = esc_html__('RM: posts view access: Empty object name. Data was not updated', 'role-manager');
            return;
        }
                        
        if ($rm_object_type=='role') {
            RM_Content_View_Restrictions_Controller::save_access_data_for_role($rm_object_name);
        } else {
            RM_Content_View_Restrictions_Controller::save_access_data_for_user($rm_object_name);
        }
        
        $this->lib->notification = esc_html__('RM: posts view access: Data was updated successfully', 'role-manager');
    }
    // end of update_data()                                           
        
}
// end of RM_Posts_View_Access class
