<?php

/*
 * Role Manager Mtaandao plugin
 * Class RM_Admin_Menu_Access - prohibit selected menu items for role or user
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+ 
 */

class RM_Widgets_Access {

// reference to the code library object
    private $lib = null;    
    private $objects = null;
    private $notice = '';
    private $unregistered_widgets = null;
    private $blocked = null;

    public function __construct($lib) {
        
        $this->lib = $lib;
        $this->objects = new RM_Widgets($this->lib);
        
        add_action('rm_role_edit_toolbar_service', array(&$this, 'add_toolbar_buttons'));
        add_action('rm_load_js', array($this, 'add_js'));
        add_action('rm_dialogs_html', array($this, 'dialog_html'));
        add_action('rm_process_user_request', array($this, 'update_data'));                        
        add_action('widgets_init', array($this, 'unregister_blocked_widgets'), 100);        
        add_action('mn_ajax_widgets-order', array($this, 'ajax_widgets_order'), 0);

    }
    // end of __construct()

    
    protected function get_blocked_widgets() {
        global $current_user;
        
        if ($this->blocked===null) {
            $this->blocked = $this->objects->load_access_data_for_user($current_user);
        }
        
        return $this->blocked;
    }
    // end of get_blocked()
    

    protected function is_restriction_aplicable() {
        if ($this->lib->multisite && is_super_admin()) {
            return false;
        }
        
        if (!$this->lib->multisite && current_user_can('administrator')) {
            return false;
        }
        
        $this->get_blocked_widgets();
        if (empty($this->blocked)) {            
            return false;            
        }
        
        return true;
    }
    // end of is_restriction_aplicable()

    
    public function add_toolbar_buttons() {
        if (current_user_can('rm_widgets_access')) {
?>                
        <button id="rm_widgets_access_button" class="rm_toolbar_button" 
                title="<?php esc_html_e('Prohibit access to selected widgets','role-manager');?>">
            <?php esc_html_e('Widgets', 'role-manager');?></button>                     
<?php

        }
    }
    // end of add_toolbar_buttons()


    public function add_js() {
        mn_register_script( 'rm-widgets-access', admin_url( '/js/admn/rm-admn-widgets-access.js', RM_PLUGIN_FULL_PATH ) );
        mn_enqueue_script ( 'rm-widgets-access' );
        mn_localize_script( 'rm-widgets-access', 'rm_data_widgets_access',
                array(
                    'widgets' => esc_html__('Widgets', 'role-manager'),
                    'dialog_title' => esc_html__('Widgets', 'role-manager'),
                    'update_button' => esc_html__('Update', 'role-manager'),
                    'edit_design_options_required' => esc_html__('Turn ON "edit_design_options" capability to manage widgets permissions', 'role-manager')
                ));
    }
    // end of add_js()    
    
    
    public function dialog_html() {
        
?>
        <div id="rm_widgets_access_dialog" class="rm-modal-dialog">
            <div id="rm_widgets_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()

            
    public function update_data() {
    
        if (!isset($_POST['action']) || $_POST['action']!=='rm_update_widgets_access') {
            return;
        }
        
        if (!current_user_can('rm_widgets_access')) {
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
        
        $this->lib->notification = esc_html__('Widgets access: data was updated successfully', 'role-manager');
    }
    // end of update_data()
                
    
    public function unregister_blocked_widgets() {
             
        if (!$this->is_restriction_aplicable()) {
            return;
        }
                        
        $widgets = $this->objects->get_all_widgets();
        $this->unregistered_widgets = array();
        foreach($this->blocked as $widget) {
            $this->unregistered_widgets[$widget] = $widgets[$widget]->id_base;
            unregister_widget($widget);            
        }        
        
    }
    // end of unregister_blocked_widgets()

    
    /* 
     * Widget list decoding code was written on the base of mn_ajax_widgets_order() from admin/ajax-actions.php
     * 
     */
    private function decode_widgets_list($widgets_list) {
        $widgets = array();
        $widgets_raw = explode(',', $widgets_list);
        foreach ($widgets_raw as $key => $widget_id_str) {
            if (strpos($widget_id_str, 'widget-') === false) {
                continue;
            }
            $widgets[$key] = substr($widget_id_str, strpos($widget_id_str, '_') + 1);
        }
        
        return $widgets;
    }
    // end of decode_widget_id_str()
    
    
    /**
     * Convert string from POST to the sidebars with widgets array     
     * @return array
     */
    private function get_sidebars_from_post() {
        if (!is_array($_POST['sidebars'])) {
            return array();
        }
        $sidebars = array();
        foreach ($_POST['sidebars'] as $key=>$widgets_list) {            
            if (empty($widgets_list)) {
                continue;
            }                                    
            $sidebars[$key] = $this->decode_widgets_list($widgets_list);
        }                
        
        return $sidebars;
    }
    // end of get_sidebars_from_post()
    
    
    private function get_id_base_from_str($widget_id_str) {
       
        $id_base = substr($widget_id_str, 0, strrpos($widget_id_str, '-'));
       
       return $id_base;
    }
    // get_id_base_from_str()
    
    
    private function is_widget_blocked($id_base) {
        
        $result = false;
        foreach($this->blocked as $widget_class) {
            if ($this->unregistered_widgets[$widget_class]===$id_base) {
                $result = true;
                break;
            }
        }
        
        return $result;
    }
    // end of is_widget_blocked()
    
    
    private function get_active_widgets_blocked_for_current_role() {
        
        $sidebars_to_save = array();            
        $sidebars = mn_get_sidebars_widgets();
        foreach ($sidebars as $key => $widgets_list) {
            if ($key == 'mn_inactive_widgets') {
                $sidebars_to_save[$key] = $widgets_list;
                continue;
            }
            $widgets_to_save = array();
            foreach ($widgets_list as $id_str) {
                $id_base = $this->get_id_base_from_str($id_str);
                if ($this->is_widget_blocked($id_base)) {
                    $ind = count($widgets_to_save);
                    $widgets_to_save[$ind] = 'widget-'. $ind .'_'. $id_str;
                }
            }
            $sidebars_to_save[$key] = $widgets_to_save;
        }
        
        return $sidebars_to_save;
    }
    // end of get_active_widgets_blocked_for_current_role()
    
    
    /**
     * Process situation, when user with restricted role updates sidebar, which has active widgets, to which role does not have access.
     * We should add those blocked active widgets back to the $POST['sidebars'] in order do not lose them after update
     * 
     */
    public function ajax_widgets_order() {
        
        if (!$this->is_restriction_aplicable()) {
            return;
        }                
        
        $sidebars_to_save = $this->get_active_widgets_blocked_for_current_role();                       
        $sidebars_from_post = $this->get_sidebars_from_post();
        foreach($sidebars_from_post as $key=>$widgets_list) {                
            foreach($widgets_list as $id_str) {
                $id_base = $this->get_id_base_from_str($id_str);
                if (!in_array($id_str, $sidebars_to_save[$key])) {
                    $ind = count($sidebars_to_save[$key]);
                    $sidebars_to_save[$key][$ind] = 'widget-'. $ind .'_'. $id_str;
                }
            }
            $_POST['sidebars'][$key] = implode(',', $sidebars_to_save[$key]);
        }            
        
        mn_ajax_widgets_order();
    }
    // end of ajax_widgets_order()
                        
}
// end of RM_Widgets_Access class
