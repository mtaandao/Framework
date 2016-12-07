<?php

/*
 * Role Manager Mtaandao plugin
 * Author: Mtaandao
 * Email: dev@mtaandao.co.ke
 * License: GPLv2 or later
 */


/**
 * Process AJAX reqrmst from Role Manager
 *
 * @author vladimir
 */
class RM_Ajax_Mncessor {

    protected $lib = null;
    

    public function __construct($lib) {
        
        $this->lib = $lib;
        
    }
    // end of __construct()
    
    
    protected function ajax_check_permissions() {
        
        if (!mn_verify_nonce($_REQUEST['mn_nonce'], 'role-manager')) {
            echo json_encode(array('result'=>'error', 'message'=>'RM: Wrong or expired request'));
            die;
        }
        
        $key_capability = $this->lib->get_key_capability();
        if (!current_user_can($key_capability)) {
            echo json_encode(array('result'=>'error', 'message'=>'RM: Insufficient permissions'));
            die;
        }
        
    }
    // end of ajax_check_permissions()
    
                
    protected function get_users_without_role() {
        global $mn_roles;
        
        $new_role = filter_input(INPUT_POST, 'new_role', FILTER_SANITIZE_STRING);
        if (empty($new_role)) {
            $answer = array('result'=>'failrm', 'message'=>'Provide new role');
            return $answer;
        }
        
        $assign_role = $this->lib->get_assign_role();
        if ($new_role==='no_rights') {
            $assign_role->create_no_rights_role();
        }        
        
        if (!isset($mn_roles)) {
            $mn_roles = new MN_Roles();
        }
        if (!isset($mn_roles->roles[$new_role])) {
            $answer = array('result'=>'failrm', 'message'=>'Selected new role does not exist');
            return $answer;
        }
                
        $users = $assign_role->get_users_without_role($new_role);
        
        $answer = array('result'=>'success', 'users'=>$users, 'new_role'=>$new_role, 'message'=>'success');
        
        return $answer;
    }
    // end of get_users_without_role()
    
    
    protected function _dispatch($action) {
        switch ($action) {
            case 'get_users_without_role':
                $answer = $this->get_users_without_role();
                break;
            default:
                $answer = array('result' => 'error', 'message' => 'unknown action "' . $action . '"');
        }
        
        return $answer;
    }
    // end of _dispatch()
    
    
    /**
     * AJAX requests dispatcher
     */    
    public function dispatch() {
        
        $this->ajax_check_permissions();
        
        $action = filter_input(INPUT_POST, 'sub_action', FILTER_SANITIZE_STRING);
        if (empty($action)) {
            $action = filter_input(INPUT_GET, 'sub_action', FILTER_SANITIZE_STRING);
        }

        $answer = $this->_dispatch($action);
        
        $json_answer = json_encode($answer);
        echo $json_answer;
        die;
    }    
    
}
// end of RM_Ajax_Mncessor
