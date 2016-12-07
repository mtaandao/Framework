<?php
/*
 * Class: Edit access restrict to posts/pages for role - user interface
 * Project: Mtaandao Role Manager Mtaandao plugin
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

class RM_Posts_Edit_Access_Role {

    const ACCESS_DATA_KEY = 'rm_posts_edit_access_data';
    const EDIT_POSTS_ACCESS_CAP = 'rm_edit_posts_access';
    
    // reference to the code library object
    private $lib = null;        


    public function __construct() {
        
        $this->lib = RM_Lib_Mn::get_instance();
        
        if (!(defined('DOING_AJAX') && DOING_AJAX)) {
            add_action('rm_role_edit_toolbar_service', array($this, 'add_toolbar_button'));
            add_action('rm_load_js', array($this, 'add_js'));
            add_action('rm_dialogs_html', 'RM_Posts_Edit_Access_View::dialog_html');
            add_action('rm_process_user_request', 'RM_Posts_Edit_Access_Role_Controller::update_data');
        }

    }
    // end of __construct()

    
    public function add_toolbar_button() {
        if (!current_user_can(self::EDIT_POSTS_ACCESS_CAP)) {
            return;
        }
            
        RM_Posts_Edit_Access_View::add_toolbar_button();
        
    }
    // end of add_toolbar_buttons()

    
    public function add_js() {
        mn_register_script('rm-posts-edit-access', admin_url('/js/admn/posts-edit-access.js', RM_PLUGIN_FULL_PATH));
        mn_enqueue_script ('rm-posts-edit-access');
        mn_localize_script('rm-posts-edit-access', 'rm_data_posts_edit_access',
                array(
                    'posts_edit' => esc_html__('Posts Edit', 'role-manager'),
                    'dialog_title' => esc_html__('Posts Edit Access', 'role-manager'),
                    'update_button' => esc_html__('Update', 'role-manager')
                ));
    }
    // end of add_js()    
                                   
    /**
     * returns JSON with form data as the response for AJAX request from RM's main page
     * 
     * @return array
     */
    public static function get_html() {
        
        if (!current_user_can(self::EDIT_POSTS_ACCESS_CAP)) {
            return array('result'=>'error', 'message'=>'Not enough permissions');
        }
        
        $role_id = filter_input(INPUT_POST, 'current_role', FILTER_SANITIZE_STRING);
        $args = RM_Posts_Edit_Access_Role_Controller::prepare_form_data($role_id);                        
        $html = RM_Posts_Edit_Access_View::get_html($args);
        
        return array('result'=>'success', 'message'=>'Posts edit permissions for role:'+ $role_id, 'html'=>$html);
    }
    // end of get_html()
    
}
// end of RM_Posts_Edit_Access_Role class