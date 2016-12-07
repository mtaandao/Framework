<?php
/*
 * Class: Edit access to posts/pages for role data controller
 * Project: Mtaandao Role Manager Mtaandao plugin
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

class RM_Posts_Edit_Access_Role_Controller {
 

    private static function load_data($role_id) {
            
        $access_data = get_option(RM_Posts_Edit_Access_Role::ACCESS_DATA_KEY);
        if (is_array($access_data) && array_key_exists($role_id, $access_data)) {
            $result =  $access_data[$role_id];            
        } else {
            $result = array(
                'restriction_type'=>1,
                'own_data_only'=>0,
                'data'=>array(
                    'posts'=>array(),
                    'terms'=>array(),
                    'authors'=>array()                    
            ));
        }
        
        return $result;
        
    }
    // end of load_data()
    
    
    /**
     * Prepare data for show via RM_Posts_Edit_Access_View::get_html()
     * @global MN_Roles $mn_roles
     * @param string $role_id
     * @return boolean
     */
    public static function prepare_form_data($role_id) {
        global $mn_roles;
                
        $data = self::load_data($role_id);
        $result = array();
        $result['restriction_type'] = $data['restriction_type'];
        $result['own_data_only'] = $data['own_data_only'];
        $result['posts_list'] = implode(', ', $data['data']['posts']);
        $result['post_authors_list'] = implode(', ', $data['data']['authors']);
        $result['categories_list'] = implode(', ', $data['data']['terms']);
        
        $result['show_authors'] = false;
        if (!empty($role_id) && isset($mn_roles->roles[$role_id])) {
            $caps_to_check = array('edit_others_posts', 'edit_others_pages');
            foreach($caps_to_check as $cap) {
                if (!empty($mn_roles->roles[$role_id]['capabilities'][$cap])) {
                    $result['show_authors'] = true;
                    break;
                }
            }
        }
        $result['object_type'] = 'role';
        $result['object_name'] = $role_id;
                
        return $result;
    }
    // end of prepare_form_data()
    
        
    private static function get_data_from_post() {
        
        $lib = RM_Lib_Mn::get_instance();
        $restriction_type = $lib->get_request_var('rm_posts_restriction_type', 'post', 'int');
        if ($restriction_type!=1 && $restriction_type!=2) { // got invalid value
            $restriction_type = 1;  // use 'Allow' as default value
        }        
        $own_data_only = $lib->get_request_var('rm_own_data_only', 'post', 'int');
        
        $data = array(
            'restriction_type'=>$restriction_type, 
            'own_data_only'=>$own_data_only,
            'data'=>array(
                'posts'=>RM_Utils::filter_int_list_from_post('rm_posts_list'),
                'authors'=>RM_Utils::filter_int_list_from_post('rm_post_authors_list'),
                'terms'=>RM_Utils::filter_int_list_from_post('rm_categories_list')
                    )
                );         
        
        return $data;
    }
    // end of get_data_from_post()
    
    
    private static function save_data($role_id) {
        global $mn_roles;
        
        $access_for_role = self::get_data_from_post();
        $access_data = get_option(RM_Posts_Edit_Access_Role::ACCESS_DATA_KEY);        
        if (!is_array($access_data)) {
            $access_data = array();
        }

        $role_exists = isset($mn_roles->roles[$role_id]);

        if (count($access_for_role)>0) {
            if ($role_exists) {
                $access_data[$role_id] = $access_for_role;
            } elseif (isset($access_data[$role_id])) {
                unset($access_data[$role_id]);
            }
        } elseif (isset($access_data[$role_id])) {            
            unset($access_data[$role_id]);
        }
        
        update_option(RM_Posts_Edit_Access_Role::ACCESS_DATA_KEY, $access_data);
        
        do_action('rm_save_user_edit_content_restrictions', $role_id);
    }
    // end of save_data()    
    

    public static function update_data() {
    
        if (!isset($_POST['action']) || $_POST['action']!=='rm_update_posts_edit_access') {
            return false;
        }
        
        $lib = RM_Lib_Mn::get_instance();
        if (!current_user_can(RM_Posts_Edit_Access_Role::EDIT_POSTS_ACCESS_CAP)) {
            $lib->notification = esc_html__('RM: you have not enough permissions to use this add-on.', 'role-manager');
            return false;
        }
        $object_type = $lib->get_request_var('rm_object_type', 'post');
        if ($object_type!=='role') {
            $lib->notification = esc_html__('RM: posts edit access: Wrong object type. Data was not updated.', 'role-manager');
            return false;
        }
        $object_name = $lib->get_request_var('rm_object_name', 'post');
        if (empty($object_name)) {
            $lib->notification = esc_html__('RM: posts edit access: Empty object name. Data was not updated', 'role-manager');
            return false;
        }
                        
        self::save_data($object_name);        
        $lib->notification = esc_html__('Posts edit access data was updated successfully', 'role-manager');
        
        return true;
    }
    // end of update_data()        
    
}
// end of RM_Posts_Edit_Access_Role_Controller