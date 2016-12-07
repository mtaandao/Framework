<?php

/*
 * Role Manager Mtaandao plugin
 * Force post types to use their own capabilities set
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3+ 
 */

class RM_Post_Types_Own_Caps {
    
    private $lib = null;
    
    public function __construct() {        
        
        $this->lib = RM_Lib_Mn::get_instance();
        add_action('init', array($this, 'set_own_caps'), 11, 2);    // execute before RM_Create_Posts_Cap        
    }
    // end of __construct()
    
    
    /**
     * 
     * Divi design does not create custom post type at admin/users.php page | Divi/res/builder/framework.php::et_builder_should_load_framework()
     * So it's not available by default at Role Manager
     * 
     */     
    private function fake_divi_post_type_load() {
        global $pagenow;

        if (!function_exists( 'ed_builder_should_load_framework' )) {        
            return;
        }
        // Make it for Role Manager pages only
        if (!($pagenow=='users.php' && $_GET['page']=='users-mn-role-manager.php')) {
            return;
        }
        
        require ET_BUILDER_DIR . 'layouts.php';
    }
    // end of fake_divi_post_type_load()

    
    public function set_own_caps() {
        global $mn_post_types;

        $this->fake_divi_post_type_load();
        
        $post_types = get_post_types(array(), 'objects');
        $_post_types = $this->lib->_get_post_types();
        foreach ($post_types as $post_type) {
            if (!in_array($post_type->name, $_post_types)) {
                continue;
            }
            if ($post_type->name == 'post' || $post_type->capability_type != 'post') {
                continue;
            }

            $mn_post_types[$post_type->name]->capability_type = $post_type->name;
            $mn_post_types[$post_type->name]->map_meta_cap = true;
            $cap_object = new stdClass();
            $cap_object->capability_type = $mn_post_types[$post_type->name]->capability_type;
            $cap_object->map_meta_cap = true;
            $cap_object->capabilities = array();
            $create_posts0 = $mn_post_types[$post_type->name]->cap->create_posts;
            $mn_post_types[$post_type->name]->cap = get_post_type_capabilities($cap_object);
            if ($post_type->name=='attachment') {
                $mn_post_types[$post_type->name]->cap->create_posts = $create_posts0;   // restore initial 'upload_files'
            }
        }
        
    }
    // end of set_own_caps
        
}
// end of RM_Post_Types_Own_Caps class