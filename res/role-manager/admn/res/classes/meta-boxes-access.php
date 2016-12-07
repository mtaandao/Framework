<?php

/*
 * Role Manager Mtaandao plugin
 * Prohibit/Allow view of posts of selected categories for selected role - at Role Manager dialog
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+ 
 */

class RM_Meta_Boxes_Access {

    const meta_boxes_access_cap = 'rm_meta_boxes_access';
    
    // reference to the code library object
    private $lib = null;        
    private $objects = null;

    public function __construct($lib) {
        
        $this->lib = $lib;
        $this->objects = new RM_Meta_Boxes($this->lib);
        
        add_action('rm_role_edit_toolbar_service', array($this, 'add_toolbar_buttons'));
        add_action('rm_load_js', array($this, 'add_js'));
        add_action('rm_dialogs_html', array($this, 'dialog_html'));
        add_action('rm_process_user_request', array($this, 'update_access'));

    }
    // end of __construct()


    public function add_toolbar_buttons() {
        if (!current_user_can('rm_meta_boxes_access')) {
            return;
        }
        // get full meta_boxes list copy from superadmin user
        $this->objects->update_meta_boxes_list_copy();        
?>                
        <button id="rm_meta_boxes_access_button" class="rm_toolbar_button" 
                title="<?php esc_html_e('Prohibit access to selected meta_boxes', 'role-manager');?>">
                    <?php esc_html_e('Meta Boxes', 'role-manager');?></button>
<?php

    }
    // end of add_toolbar_buttons()
    
    
    public function add_js() {
        mn_register_script( 'rm-meta_boxes-access', admin_url( '/js/admn/meta-boxes-access.js', RM_PLUGIN_FULL_PATH ) );
        mn_enqueue_script ( 'rm-meta_boxes-access' );
        mn_localize_script( 'rm-meta_boxes-access', 'rm_data_meta_boxes_access',
                array(
                    'meta_boxes' => esc_html__('Meta Boxes', 'role-manager'),
                    'dialog_title' => esc_html__('Meta Boxes', 'role-manager'),
                    'update_button' => esc_html__('Update', 'role-manager'),
                    'edit_posts_required' => esc_html__('Turn ON at least "edit_posts" capability to manage access to meta_boxes for this role', 'role-manager')
                ));
    }
    // end of add_js()    
    
    
    public function dialog_html() {
        
?>
        <div id="rm_meta_boxes_access_dialog" class="rm-modal-dialog">
            <div id="rm_meta_boxes_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()

    
    public function update_access() {
    
        if (!isset($_POST['action']) || $_POST['action']!=='rm_update_meta_boxes_access') {
            return;
        }
        
        if (!current_user_can('rm_meta_boxes_access')) {
            $this->lib->notification = esc_html__('RM: you do not have enough permissions to access this module.', 'role-manager');
            return;
        }
        
        $rm_object_type = filter_input(INPUT_POST, 'rm_object_type', FILTER_SANITIZE_STRING);
        if ($rm_object_type!=='role' && $rm_object_type!=='user') {
            $this->lib->notification = esc_html__('RM: widgets access: Wrong object type. Data was not updated.', 'role-manager');
            return;
        }
        $rm_object_name = filter_input(INPUT_POST, 'rm_object_name', FILTER_SANITIZE_STRING);
        if (empty($rm_object_name)) {
            $this->lib->notification = esc_html__('RM: widgets access: Empty object name. Data was not updated', 'role-manager');
            return;
        }
                        
        if ($rm_object_type=='role') {
            $this->objects->save_access_data_for_role($rm_object_name);
        } else {
            $this->objects->save_access_data_for_user($rm_object_name);
        }
        $this->lib->notification = esc_html__('Widgets access data was updated successfully', 'role-manager');
        
    }
    // end of update_access()
        
    
}	// end of RM_Metaboxes_Access class