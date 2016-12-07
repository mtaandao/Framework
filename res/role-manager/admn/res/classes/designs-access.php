<?php
/*
 * Access restriction to designs activation on per user basis
 * part of Mtaandao Role Manager plugin
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

class RM_Themes_Access {
    
    private $lib = null;
    private $user_meta_key = '';
    
    public function __construct(RM_Lib $lib) {
    
        global $mndb;
        
        $this->lib = $lib;
        $this->user_meta_key = $mndb->prefix . 'rm_allow_designs';
        
        add_action( 'edit_user_profile', array($this, 'edit_user_allowed_designs_list'), 10, 2);
        add_action( 'profile_update', array($this, 'save_user_allowed_designs_list'), 10);
        add_action( 'admin_head', array($this, 'prohibited_links_redirect'));        
        add_action('admin_init', array($this, 'set_final_hooks'));
        add_action( 'admin_enqueue_scripts', array($this, 'admin_load_js' ));
        add_action( 'admin_print_styles-user-edit.php', array($this, 'admin_css_action'));
    }
    // end of __construct()
    
    
    // checks if user can activate plugins
    protected function user_can_activate_designs($user) {
        
        $result = $this->lib->user_has_capability($user, 'switch_designs');        
        
        return $result;
    }
    // end of user_can_activate_plugins()
    
    
    public function set_final_hooks() {
        global $current_user;
        
        $rm_key_capability = $this->lib->get_key_capability();
        if ( $this->lib->user_has_capability($current_user, $rm_key_capability) ) {    // this is RM admin - no limits
            return;
        }
                
        if ( $this->user_can_activate_designs($current_user) ) {
            $allowed_designs_list = $this->get_allowed_designs_list();
            if (count($allowed_designs_list)>0) {
                add_filter('mn_prepare_designs_for_js', array(&$this, 'restrict_designs_list' ));
            }
        }
        
    }
    // end of set_final_hooks()
    
    
    protected function get_allowed_designs_names($allow_designs) {

        $allowed_designs_list = explode(',', $allow_designs);
        $designs = mn_prepare_designs_for_js();
        $allowed_designs_names = '';
        foreach ($designs as $design) {
          if (in_array($design['id'], $allowed_designs_list)) {
            if (!empty($allowed_designs_names)) {
                $allowed_designs_names .= "\n";
            }
            $allowed_designs_names = $allowed_designs_names .$design['name'];
          }
        }

        return $allowed_designs_names;
    }
    // end of get_allowed_designs_names()

    
    protected function user_profile_designs_select() {
                
        $all_designs = mn_prepare_designs_for_js();
        echo 'Open drop-down list and turn On/Off checkboxes:<br>'."\n";
        echo '<select multiple="multiple" id="rm_select_allowed_designs" name="rm_select_allowed_designs" style="width: 500px;" >'."\n";
        foreach($all_designs as $design) {
            echo '<option value="'. $design['id'] .'" >'. $design['name'] .'</option>'."\n";
        }   // foreach()
        echo '</select><br>'."\n";
        
    }
    // end of user_profile_designs_select()
    
    
    public function edit_user_allowed_designs_list($user) {

        global $current_user;

        $result = stripos($_SERVER['REQUEST_URI'], 'network/user-edit.php');
        if ($result !== false) {  // exit, this code just for single site user profile only, not for network admin center
            return;
        }
        
        $rm_key_capability = $this->lib->get_key_capability();        
        if (!$this->lib->user_has_capability($current_user, $rm_key_capability)) { // you can not edit allowed designs list
            return;
        }
        
        if ($this->lib->user_has_capability($user, $rm_key_capability)) {  // he can edit, do not restrict him
            return;
        }
        
        // if edited user can not activate designs, do not show allowed designs input field
        if ( !$this->user_can_activate_designs($user) ) {
            return;
        }
        
        $allow_designs = get_user_meta($user->ID, $this->user_meta_key, true);
        if (empty($allow_designs)) {
            $allow_designs = '';
        }
        $show_allowed_designs = $this->get_allowed_designs_names($allow_designs);
?>        
        <h3><?php _e('Themes available for activation', 'role-manager'); ?></h3>
        <?php $this->user_profile_designs_select();?>
        <textarea name="show_allowed_designs" id="show_allowed_designs" cols="80" rows="5" readonly="readonly" /><?php echo $show_allowed_designs; ?></textarea>
        <input type="hidden" name="rm_allow_designs" id="rm_allow_designs" value="<?php echo $allow_designs; ?>" />
        <input type="hidden" name="rm_user_id" id="rm_user_id" value="<?php echo $user->ID; ?>" />
<?php        
    }
    // end of edit_user_allowed_designs_list()

    
   /**
     * Load plugin javascript stuff
     * 
     * @param string $hook_suffix
     */
    public function admin_load_js($hook_suffix) {
        
        if ($hook_suffix === 'user-edit.php') {
            mn_enqueue_script('jquery-ui-dialog', false, array('jquery-ui-core', 'jquery-ui-button', 'jquery'));
            mn_register_script('rm-jquery-multiple-select', admin_url('/js/jquery.multiple.select.js', RM_PLUGIN_FULL_PATH));
            mn_enqueue_script('rm-jquery-multiple-select');
            mn_register_script('rm-user-admnfile-designs', admin_url('/js/admn/rm-admn-user-admnfile-designs.js', RM_PLUGIN_FULL_PATH));
            mn_enqueue_script('rm-user-admnfile-designs');
            mn_localize_script('rm-user-admnfile-designs', 'rm_pro_data_designs', array(
                'mn_nonce' => mn_create_nonce('role-manager'),
                'edit_allowed_designs' => __('Edit Themes List', 'role-manager'),
                'edit_allowed_designs_title' => __('Themes list you allow this user to activate/deactivate', 'role-manager'),
                'save_designs_list' => __('Save', 'role-manager'),
                'close' => __('Close', 'role-manager'),
            ));
        }
    }
    // end of admin_load_js()
    
    
    public function admin_css_action() {        
        mn_enqueue_style('mn-jquery-ui-dialog');
        mn_enqueue_style('rm-jquery-multiple-select', admin_url('/css/admn/multiple-select.css', RM_PLUGIN_FULL_PATH), array(), false, 'screen');
    }
    // end of admin_css_action()
                        
    
    // returns installed designs list in the form of associative array, indexed by design's slug
    protected function get_installed_designs_assoc() {
    
        $designs = mn_prepare_designs_for_js();
        $designs_assoc = array();
        foreach($designs as $design) {
            $designs_assoc[$design['id']] = 1;
        }
        
        return $designs_assoc;
    }
    // end of get_installed_design_assoc()
    
        
    // save additional allowed for activation designs list when user profile is updated, 
    // as Mtaandao itself doesn't know about them
    public function save_user_allowed_designs_list($user_id) {

        if (!current_user_can('switch_designs', $user_id)) {
            return;
        }
        
        $designs_list_str = '';                
        // update designs list access restriction: comma separated designs names list
        if (isset($_POST['rm_allow_designs'])) {
            $designs_list = explode(',', $_POST['rm_allow_designs']);
            if (count($designs_list)>0) {
                $installed_designs = $this->get_installed_designs_assoc();
                $validated_list = array();
                foreach($designs_list as $design) {
                    $slug = trim($design);
                    if (isset($installed_designs[$slug])) {
                        $validated_list[] = $slug;
                    }
                }
                $designs_list_str = implode(',', $validated_list);
            }            
        }
        update_user_meta($user_id, $this->user_meta_key, $designs_list_str);
    }
    // end of save_allowed_designs_list()    
    
    
    private function get_allowed_designs_list($user_id=0) {
        
        global $current_user;
    
        if (empty($user_id)) {  //  return data for current user
            $user_id = $current_user->ID;
        }
        $data = trim(get_user_meta($user_id, $this->user_meta_key, true));
        if (empty($data)) {
            $allowed_designs_list = array();
        } else {
            $allowed_designs_list = explode(',', $data);
        }
            
        return $allowed_designs_list;
    }
    // end of get_allowed_designs_list()
    
        
    public function prohibited_links_redirect() {
        
        global $current_user;
        
        if (!$this->user_can_activate_designs($current_user)) {        
            return;   
        }
            
        if ( stripos($_SERVER['REQUEST_URI'], 'admin/designs.php?action')===false ) {
            return;
        }    

        $allowed_designs_list = $this->get_allowed_designs_list($current_user);
        if (count($allowed_designs_list)==0) {
            return;
        }
        // extract design slug
        $args = mn_parse_args($_SERVER['REQUEST_URI'], array() );    
        if ( isset($args['stylesheet']) ) {            
            if ( !in_array($args['stylesheet'], $allowed_designs_list) ) {    // access to this designs is prohibited - redirect user back to the designs list
                // its late to use mn_redirect() as MN sent some headers already, so use JavaScript for redirection
?>
        <script>
            document.location.href = '<?php echo get_option('siteurl') . '/admin/designs.php'; ?>';
        </script>
<?php                    
                die;
            }
        }
                                    
    }
    // end of prohibited_links_redirect()

                
  /** 
   * Filter out RM plugin from not superadmin users
   * @param type array $plugins plugins list
   * @return type array $plugins updated plugins list
   */
  public function restrict_designs_list($designs) {
    global $current_user;

    $rm_key_capability = $this->lib->get_key_capability();
    // if multi-site, then allow plugin activation for network superadmins and, if that's specially defined, - for single site administrators too    
    if ($this->lib->user_has_capability($current_user, $rm_key_capability)) {    
      return $designs;
    }
    
    $allowed_designs_list = $this->get_allowed_designs_list();
    // exclude prohibited designs from designs list
    foreach ($designs as $key => $value) {
      if (!in_array($key, $allowed_designs_list)) {
        unset($designs[$key]);
      }
    }

    return $designs;
  }
  // end of restrict_designs_list()
  
}
// end of RM_Themes_Access
