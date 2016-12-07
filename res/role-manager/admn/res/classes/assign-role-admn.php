<?php
/**
 * Project: Role Manager plugin
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * Greetings: some ideas and code samples for long runing cron job was taken from the "Broken Link Checker" plugin (Janis Elst).
 * License: GPL v3+
 * 
 * Assign role to the users without role stuff
 */
class RM_Assign_Role_Mn extends RM_Assign_Role {
    
    const CRON_ACTION_HOOK = 'rm_assign_role_to_users_without_role';
    const MAX_EXECUTION_TIME = 60000;    // 1 minute in milliseconds
    const TARGET_USAGE_FRACTION = 0.25;
       
    
    private function register_cron_job($new_role, $users) {
        
        if (count($users)>self::MAX_USERS_TO_PROCESS) {
            $users1 = array_slice($users, 0, self::MAX_USERS_TO_PROCESS);
            $users2 = array_slice($users, self::MAX_USERS_TO_PROCESS);
            $job_data = new stdClass();
            $job_data->users = $users2;
            $job_data->new_role = $new_role;
            $this->lib->put_option('rm_assign_role_job', $job_data, true);
            
            // register scheduled event to MN cron 
            if (!mn_next_scheduled(self::CRON_ACTION_HOOK)) {
                mn_schedule_event(time(), 'hourly', self::CRON_ACTION_HOOK);
            }
            
        } else {
            $users1 = $users;
        }

        return $users1;
                
    }
    // end of register_cron_job()

    
    public function get_users_without_role($new_role='') {
    
        $users = parent::get_users_without_role($new_role);        
        // $users = $this->register_cron_job($new_role, $users);
        
        
        return $users;
        
    }
    // end of get_users_without_role()

    
    public function get_users_queued() {
        if (!mn_next_scheduled(RM_Assign_Role::CRON_ACTION_HOOK)) {
            return 0;
        }
        $job_data = $this->lib->get_option('rm_assign_role_job');
        if (empty($job_data->users)) {
            return 0;
        }
        
        $users_queued = count($job_data->users);
        
        return $users_queued;
    }
    // end of get_users_queued()
        
        
    /**
     * Prepare to run job
     */
    private function job_init() {
        
        // Close the session to prevent lock-ups with other PHP threads.
        if (session_id()!='') {
            session_write_close();
        }
    
        if (!RM_Mutex::get(self::CRON_ACTION_HOOK)) {
        			 // Another instance of RM is working already
            return;
        }
        
        if (RM_Utils::server_too_busy()) {            
            return;
        }
        
        RM_Utils::start_timer();
        
        // As we will sleep sometime to minimize server load
        set_time_limit( self::MAX_EXECUTION_TIME * 2 );
        
        // Don't stop the script when the connection is closed
        ignore_user_abort( true );
        
        if (!headers_sent()
            && (defined('DOING_AJAX') && constant('DOING_AJAX'))
            && (!defined('MN_DEBUG') || !constant('MN_DEBUG')) ) {
            @ob_end_clean(); //Discard the existing buffer, if any
            header("Connection: close");
            ob_start();
            echo ('Connection closed'); // This could be anything
            $size = ob_get_length();
            header("Content-Length: $size");
            ob_end_flush(); // Strange behaviour, will not work
            flush();        // Unless both are called !
        }
        
    }
    // end of job_init()
    
    
    private function job_cleanup($job_data) {
        
        $this->lib->put_option('rm_assign_role_job', $job_data, true);
        RM_Mutex::release(self::CRON_ACTION_HOOK);
        
    }
    // end of job_cleanup()

    
    private function assign_role_to_user($user_id, $new_role) {
        
        $user = get_user_by('id', $user_id);
        if (!in_array($new_role, $user->caps)) {
            $user->add_role($new_role);        
        }
        
    }
    // end of assign_role_to_user()
    
    
    /**
     * Assign role to the users without role
     */
    public function make() {        
        
        $this->job_init();        
        
        $job_data = $this->lib->get_option('rm_assign_role_job');
        if (empty($job_data->users)) {
            return;
        }
                        
        $users_processed = 0;
        foreach($job_data->users as $key=>$user_id) {
            if (!$this->lib->debug) {
                RM_Utils::sleep_to_maintain_ratio(self::TARGET_USAGE_FRACTION);
            }
            
            $this->assign_role_to_user($user_id, $job_data->new_role);
            unset($job_data->users[$key]);
            $users_processed++;
 
            if (!$this->lib->debug) {
                // Check if we still have some execution time left
                if ( (RM_Utils::get_execution_time()>self::MAX_EXECUTION_TIME) ||
                     RM_Utils::server_too_busy() || 
                     ($users_processed>MAX_USERS_TO_PROCESS) ) {
                    // let's stop
                    $this->job_cleanup($job_data);
                    return;
                }                
            }
        }   // foreach()                
    
        $this->job_cleanup($job_data);
    }
    // end of assign_role_to_users_without_role()
    
}
// end of RM_Assign_Role class