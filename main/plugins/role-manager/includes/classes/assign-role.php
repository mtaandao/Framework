<?php
/**
 * Project: User Role Editor plugin
 * Author: Mtaandao
 * Author email: support@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * Greetings: some ideas and code samples for long runing cron job was taken from the "Broken Link Checker" plugin (Janis Elst).
 * License: GPL v2+
 * 
 * Assign role to the users without role stuff
 */
class URE_Assign_Role {
    
    const MAX_USERS_TO_PROCESS = 50;
    
    protected $lib = null;
    
    
    function __construct($lib) {
        
        $this->lib = $lib;
    }
    // end of __construct()


    public function create_no_rights_role() {
        global $mn_roles;
        
        $role_id = 'no_rights';
        $role_name = 'No rights';
        
        if (!isset($mn_roles)) {
            $mn_roles = new MN_Roles();
        }
        if (isset($mn_roles->roles[$role_id])) {
            return;
        }
        add_role($role_id, $role_name, array());
        
    }
    // end of create_no_rights_role()
        
    
    private function get_where_condition() {
        global $mndb;

        $usermeta = $this->lib->get_usermeta_table_name();
        $id = get_current_blog_id();
        $blog_prefix = $mndb->get_blog_prefix($id);
        $where = "where not exists (select user_id from {$usermeta}
                                          where user_id=users.ID and meta_key='{$blog_prefix}capabilities') or
                          exists (select user_id from {$usermeta}
                                    where user_id=users.ID and meta_key='{$blog_prefix}capabilities' and meta_value='a:0:{}')";
                                    
        return $where;                            
    }
    // end of get_where_condition()
    
    
    public function count_users_without_role() {
        
        global $mndb;
    
        $users_quant = get_transient('ure_users_without_role');
        if (empty($users_quant)) {
            $where = $this->get_where_condition();
            $query = "select count(ID) from {$mndb->users} users {$where}";
            $users_quant = $mndb->get_var($query);
            set_transient('ure_users_without_role', $users_quant, 15);
        }
        
        return $users_quant;
    }
    // end of count_users_without_role()
    
    
    public function get_users_without_role($new_role='') {
        
        global $mndb;
        
        $top_limit = self::MAX_USERS_TO_PROCESS;
        $where = $this->get_where_condition();
        $query = "select ID from {$mndb->users} users
                    {$where}
                    limit 0, {$top_limit}";
        $users0 = $mndb->get_col($query);        
        
        return $users0;        
    }
    // end of get_users_without_role()
       
}
// end of URE_Assign_Role class