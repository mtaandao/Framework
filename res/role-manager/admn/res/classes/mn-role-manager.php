<?php
/*
 * Mtaandao Role Manager Mtaandao plugin - main class
 * Author: Mtaandao
 * Author email: dev@mtaandao.co.ke
 * Author URI: https://www.mtaandao.co.ke
 * License: GPL v3
 * 
*/

class Role_Manager_Mn extends Role_Manager {
       
    public $screen_help = null;

    
    public function __construct() {
        $this->lib = RM_Lib_Mn::get_instance('role_manager');
        
        add_action('rm_on_activation', array($this, 'execute_once'));
        parent::__construct();                                        
        add_action('plugins_loaded', array($this, 'load_addons'));                        
        new RM_Shortcodes($this->lib);                 
        $this->allow_unfiltered_html(); 
                
    }
    // end of __construct()

    
    public function execute_once() {
                                        
        RM_Admin_Menu_Hashes::require_data_conversion();
                
    }
    // end of update_on_activation()

    

    public function plugin_init() {
        parent::plugin_init();

        add_action('rm_settings_update1', array($this, 'settings_update1'));
        add_action('rm_settings_update2', array($this, 'settings_update2'));
        add_action('rm_settings_show1', array($this, 'settings_show1'));
        add_action('rm_settings_show2', array($this, 'settings_show2'));
        
        if ($this->lib->multisite) {
            add_action('rm_settings_ms_show', array($this, 'settings_ms_show'));
            add_action('rm_settings_ms_update', array($this, 'settings_ms_update'));
        }
        
        add_action('rm_load_js', array($this, 'add_js'));             
        
        if ($this->lib->multisite && is_network_admin()) {
            if (!$this->lib->active_for_network) {
                add_filter('network_admin_plugin_action_links_'. RM_PLUGIN_BASE_NAME, 
                           array($this, 'network_admin_plugin_action_links'), 10, 1);
            }
            add_action('ms_user_row_actions', array( $this, 'user_row'), 10, 2);
            add_action('rm_role_edit_toolbar_update', 'RM_Mn_View::add_role_update_network_button');
            add_action('rm_user_edit_toolbar_update', 'RM_Mn_View::add_user_update_network_button');
            add_action('rm_dialogs_html', 'RM_Mn_View::network_update_dialog_html');
        }
                
        if (!$this->lib->multisite) {
            $count_users_without_role = $this->lib->get_option('count_users_without_role', 0);
            if ($count_users_without_role) {
                add_action(RM_Assign_Role_Mn::CRON_ACTION_HOOK, array($this, 'assign_role_to_users_without_role'));
            }
        }
        
        $this->screen_help = new RM_Screen_Help_Mn();
    }
    // end of plugin_init()
    
    
    /**
     * Modify plugin action links
     * 
     * @param array $links
     * @param string $file
     * @return array
     */
    public function network_admin_plugin_action_links($links) {
/*
        $settings_link = "<a href='settings.php?page=settings-" . RM_PLUGIN_FILE . "'>" . esc_html__('Settings', 'role-manager') . "</a>";
        $links = array_merge($links, array($settings_link));
*/
        return $links;
    }
    // end of network_admin_plugin_action_links()

    
    /**
     * It is fully overriden version of the parent method
     */
    public function admin_css_action() {

        mn_enqueue_style('mn-jquery-ui-dialog');
        if (stripos($_SERVER['REQUEST_URI'], 'settings-role-manager')!==false) {
            $use_jquery_cdn_for_ui_css = $this->lib->get_option('use_jquery_cdn_for_ui_css', false);
            if ($use_jquery_cdn_for_ui_css) {
                mn_enqueue_style('rm-jquery-ui-tabs', '//code.jquery.com/ui/1.10.4/designs/smoothness/jquery-ui.css', array(), false, 'screen');
            } else {
                mn_enqueue_style( 'rm-jquery-ui-tabs', admin_url( '/css/jquery-ui-1.10.4.custom.min.css', RM_PLUGIN_FULL_PATH ) );
            }            
        }
        mn_enqueue_style( 'rm-admin-css', admin_url( '/css/rm-admin.css', RM_PLUGIN_FULL_PATH ) );
        
                        
    }
    // end of admin_css_action()    
    
    
    protected function is_user_profile_extention_allowed() {
        // no limits for the Pro version
        return true;
    }
    // end of is_user_profile_extention_allowed()

    
    protected function load_admin_menu_access_module() {
        
        if (is_network_admin()) {
            return;
        }
        $activate_admin_menu_access_module = $this->lib->get_option('activate_admin_menu_access_module', false);
        if (!empty($activate_admin_menu_access_module)) {            
            new RM_Admin_Menu_Access();
        }
                
    }
    // end of load_admin_menu_access_module()
    
    
    protected function load_widgets_access_module() {
        
        /*
        if (is_network_admin()) {
            return;
        }
         * 
         */
        if (!is_admin()) {
            return;
        }
        $activate_widgets_access_module = $this->lib->get_option('activate_widgets_access_module', false);
        if (!empty($activate_widgets_access_module)) {                        
            new RM_Widgets_Access($this->lib);
        }
                
    }
    // end of load_widgets_access_module()
    
    
protected function load_meta_boxes_access_module() {
        
        if (!is_admin()) {
            return;
        }
        $activate_meta_boxes_access_module = $this->lib->get_option('activate_meta_boxes_access_module', false);
        if (!empty($activate_meta_boxes_access_module)) {
            new RM_Meta_Boxes_Access($this->lib);
        }
                
    }
    // end of load_widgets_access_module()    
    
    
    protected function load_other_roles_access_module() {
        
        if (is_network_admin()) {
            return;
        }
        if (!is_admin()) {
            return;
        }
        $activate_other_roles_access_module = $this->lib->get_option('activate_other_roles_access_module', false);
        if (!empty($activate_other_roles_access_module)) {            
            new RM_Other_Roles_Access($this->lib);
        }
                
    }
    // end of load_widgets_access_module()

    
    protected function load_post_edit_access_module() {
        if (is_network_admin()) {
            return;
        }
        
        $manage_posts_edit_access = $this->lib->get_option('manage_posts_edit_access', false);
        if (!empty($manage_posts_edit_access)) {            
            new RM_Posts_Edit_Access();
        }
    }
    // end of load_post_edit_access_module()

    
    protected function load_plugin_activation_access_module() {
        if (is_network_admin()) {
            return;
        }
        if (!is_admin()) {
            return;
        }
        $manage_plugin_activation_access = $this->lib->get_option('manage_plugin_activation_access', false);
        if (!empty($manage_plugin_activation_access)) {                                    
            new RM_Plugins_Activation_Access($this->lib);
        }
    }
    // end of load_plugin_activation_access_module()
    
    
    protected function load_designs_access_module() {
        if (!$this->lib->multisite) {
            return;
        }
        if (is_network_admin()) {
            return;
        }        
        if (!is_admin()) {
            return;
        }
        $manage_designs_access = $this->lib->get_option('manage_designs_access', false);
        if (!empty($manage_designs_access)) {            
            new RM_Themes_Access($this->lib);
        }

    }
    // end of load_designs_access_module()
    

    /**
     * Load Gravity Forms Access Restriction module
     * @return void
     */
    protected function load_gf_access_module() {
        if (is_network_admin()) {
            return;
        }        
        if (!is_admin()) {
            return;
        }
        if ( !class_exists('GFForms') ) {
            return;        
        }
        $manage_gf_access = $this->lib->get_option('manage_gf_access', false);
        if ($manage_gf_access) {
            new RM_GF_Access($this->lib);
        }
    }
    // end of load_gf_access_module()
    
    
    protected function load_content_view_restrictions_module() {
        $activate_content_for_roles = $this->lib->get_option('activate_content_for_roles', false);
        if ($activate_content_for_roles) {            
            new RM_Content_View_Restrictions();
        }
    }
    // end of load_content_view_restrictions_module()
    
    
    protected function load_export_import_module() {
        if (!is_admin() && !is_network_admin()) {
            return;
        }
        
        new RM_Export_Import();

    }
    // end of load_export_import_module()
    
    
    /**
     * Conditionally load additional modules
     * 
     */
    public function load_addons() {
        
        $show_notices_to_admin_only = $this->lib->get_option('show_notices_to_admin_only', false);
        if ($show_notices_to_admin_only) {
            add_action('admin_head', array($this, 'show_notices_to_admin_only'));
        }
        
        $activate_create_post_capability = $this->lib->get_option('activate_create_post_capability', false);
        if ($activate_create_post_capability) {       
            new RM_Create_Posts_Cap($this->lib);
        }
        
        $force_custom_post_types_capabilities = $this->lib->get_option('force_custom_post_types_capabilities', false);
        if ($force_custom_post_types_capabilities) {
            new RM_Post_Types_Own_Caps();
        }
        
        $this->load_admin_menu_access_module();
        $this->load_widgets_access_module();
        $this->load_meta_boxes_access_module();
        $this->load_other_roles_access_module();
        $this->load_post_edit_access_module();
        $this->load_plugin_activation_access_module();
        $this->load_designs_access_module();
        $this->load_gf_access_module();
        $this->load_content_view_restrictions_module();                
        $this->load_export_import_module();

    }
    // end of load_extra_stuff()
    
            
    /*
     * General options tab update
     */
    public function settings_update1() {
                
        $show_notices_to_admin_only = $this->lib->get_request_var('show_notices_to_admin_only', 'checkbox');
        $this->lib->put_option('show_notices_to_admin_only', $show_notices_to_admin_only);
        
        $use_jquery_cdn_for_ui_css = $this->lib->get_request_var('use_jquery_cdn_for_ui_css', 'checkbox');
        $this->lib->put_option('use_jquery_cdn_for_ui_css', $use_jquery_cdn_for_ui_css);
    }
    // end of settings_update1()
    
    
    /*
     * Additional Modules options tab update
     */
    public function settings_update2() {
                            
        $activate_admin_menu_access_module = $this->lib->get_request_var('activate_admin_menu_access_module', 'checkbox');
        $this->lib->put_option('activate_admin_menu_access_module', $activate_admin_menu_access_module);
        
        $activate_widgets_access_module = $this->lib->get_request_var('activate_widgets_access_module', 'checkbox');
        $this->lib->put_option('activate_widgets_access_module', $activate_widgets_access_module);
        
        $activate_meta_boxes_access_module = $this->lib->get_request_var('activate_meta_boxes_access_module', 'checkbox');
        $this->lib->put_option('activate_meta_boxes_access_module', $activate_meta_boxes_access_module);
        
        $activate_other_roles_access_module = $this->lib->get_request_var('activate_other_roles_access_module', 'checkbox');
        $this->lib->put_option('activate_other_roles_access_module', $activate_other_roles_access_module);
        
        $manage_plugin_activation_access = $this->lib->get_request_var('manage_plugin_activation_access', 'checkbox');
        $this->lib->put_option('manage_plugin_activation_access', $manage_plugin_activation_access);
        
        $manage_posts_edit_access = $this->lib->get_request_var('manage_posts_edit_access', 'checkbox');
        $this->lib->put_option('manage_posts_edit_access', $manage_posts_edit_access);

        if ($manage_posts_edit_access) {
            $activate_create_post_capability = 1;
        } else {
            $activate_create_post_capability = $this->lib->get_request_var('activate_create_post_capability', 'checkbox');
        }
        $this->lib->put_option('activate_create_post_capability', $activate_create_post_capability);
        
        $force_custom_post_types_capabilities = $this->lib->get_request_var('force_custom_post_types_capabilities', 'checkbox');
        $this->lib->put_option('force_custom_post_types_capabilities', $force_custom_post_types_capabilities);
        
        if (class_exists('GFForms')) {
            $manage_gf_access = $this->lib->get_request_var('manage_gf_access', 'checkbox');
            $this->lib->put_option('manage_gf_access', $manage_gf_access);
        }

        $activate_content_for_roles_shortcode = $this->lib->get_request_var('activate_content_for_roles_shortcode', 'checkbox');
        $this->lib->put_option('activate_content_for_roles_shortcode', $activate_content_for_roles_shortcode);
        
        $activate_content_for_roles = $this->lib->get_request_var('activate_content_for_roles', 'checkbox');
        $this->lib->put_option('activate_content_for_roles', $activate_content_for_roles);
        
        $post_access_error_message = $_POST['post_access_error_message'];
        $this->lib->put_option('post_access_error_message', $post_access_error_message);
        
    }
    // end of settings_update2()
    

    
    // Update settings from Multisite tab
    public function settings_ms_update() {
        if (!$this->lib->multisite) {
            return;
        }
        
        if (defined('RM_ENABLE_SIMPLE_ADMIN_FOR_MULTISITE') && (RM_ENABLE_SIMPLE_ADMIN_FOR_MULTISITE == 1)) {
            $enable_simple_admin_for_multisite = 1;
        } else {
            $enable_simple_admin_for_multisite = $this->lib->get_request_var('enable_simple_admin_for_multisite', 'checkbox');
        }
        $this->lib->put_option('enable_simple_admin_for_multisite', $enable_simple_admin_for_multisite);
        
        $enable_unfiltered_html_ms = $this->lib->get_request_var('enable_unfiltered_html_ms', 'checkbox');
        $this->lib->put_option('enable_unfiltered_html_ms', $enable_unfiltered_html_ms);
        
        $enable_help_links_for_simple_admin_ms = $this->lib->get_request_var('enable_help_links_for_simple_admin_ms', 'checkbox');
        $this->lib->put_option('enable_help_links_for_simple_admin_ms', $enable_help_links_for_simple_admin_ms);
        
        $manage_designs_access = $this->lib->get_request_var('manage_designs_access', 'checkbox');
        $this->lib->put_option('manage_designs_access', $manage_designs_access);
        
        $caps_access_restrict_for_simple_admin = $this->lib->get_request_var('caps_access_restrict_for_simple_admin', 'checkbox');
        $this->lib->put_option('caps_access_restrict_for_simple_admin', $caps_access_restrict_for_simple_admin);
        if ($caps_access_restrict_for_simple_admin) {
            $add_del_role_for_simple_admin = $this->lib->get_request_var('add_del_role_for_simple_admin', 'checkbox');
            $caps_allowed_for_single_admin = $this->lib->filter_existing_caps_input('caps_allowed_for_single_admin');            
        } else {
            $add_del_role_for_simple_admin = 1;
            $caps_allowed_for_single_admin = array();            
        }
        $this->lib->put_option('add_del_role_for_simple_admin', $add_del_role_for_simple_admin);
        $this->lib->put_option('caps_allowed_for_single_admin', $caps_allowed_for_single_admin);
        
    }
    // end of settings_ms_update()

    
    /**
     * Show options at General tab
     * 
     */
    public function settings_show1() {
		                
        $show_notices_to_admin_only = $this->lib->get_option('show_notices_to_admin_only', false);
        $use_jquery_cdn_for_ui_css = $this->lib->get_option('use_jquery_cdn_for_ui_css', false);
        
        if ($this->lib->multisite) {
            $link = 'settings.php';
        } else {
            $link = 'options-general.php';
        }        
        
        require_once(ABSPATH . RES .'/role-manager/admn/res/settings-template1.php');
    }
    // end of settings_show1()
     

    /**
     * Show options at Additional Modules tab
     * 
     */
    public function settings_show2() {
		                
        
        $activate_admin_menu_access_module = $this->lib->get_option('activate_admin_menu_access_module', false);
        $activate_widgets_access_module = $this->lib->get_option('activate_widgets_access_module', false);
        $activate_meta_boxes_access_module = $this->lib->get_option('activate_meta_boxes_access_module', false);
        $activate_other_roles_access_module = $this->lib->get_option('activate_other_roles_access_module', false);
        $manage_plugin_activation_access = $this->lib->get_option('manage_plugin_activation_access', false);
        if (class_exists('GFForms')) {
            $manage_gf_access = $this->lib->get_option('manage_gf_access', false);
        }
        
// content editing restrictions        
        $activate_create_post_capability = $this->lib->get_option('activate_create_post_capability', false);
        $manage_posts_edit_access = $this->lib->get_option('manage_posts_edit_access', false);
        $force_custom_post_types_capabilities = $this->lib->get_option('force_custom_post_types_capabilities', false);

//content view restrictions
        $activate_content_for_roles_shortcode = $this->lib->get_option('activate_content_for_roles_shortcode', false);
        $activate_content_for_roles = $this->lib->get_option('activate_content_for_roles', false);
        $post_access_error_message = stripslashes($this->lib->get_option('post_access_error_message', 
                '<p class="restricted">Not enough permissions to view this content.</p>'));
            
        if ($this->lib->multisite) {
            $link = 'settings.php';
        } else {
            $link = 'options-general.php';
        }
		
        require_once(ABSPATH . RES .'/role-manager/admn/res/settings-template2.php');
    }
    // end of settings_show2()
    
    
    public function settings_ms_show() {
        if (!$this->lib->multisite) {
            return;
        }

        if (defined('RM_ENABLE_SIMPLE_ADMIN_FOR_MULTISITE') && (RM_ENABLE_SIMPLE_ADMIN_FOR_MULTISITE == 1)) {
            $enable_simple_admin_for_multisite = 1;
        } else {
            $enable_simple_admin_for_multisite = $this->lib->get_option('enable_simple_admin_for_multisite', 0);
        }
        $enable_help_links_for_simple_admin_ms = $this->lib->get_option('enable_help_links_for_simple_admin_ms', 1);
        $enable_unfiltered_html_ms = $this->lib->get_option('enable_unfiltered_html_ms', 0);
        $manage_designs_access = $this->lib->get_option('manage_designs_access', 0);
        $caps_access_restrict_for_simple_admin = $this->lib->get_option('caps_access_restrict_for_simple_admin', 0);
        if ($caps_access_restrict_for_simple_admin) {  
            $add_del_role_for_simple_admin = $this->lib->get_option('add_del_role_for_simple_admin', 1);
            $html_caps_blocked_for_single_admin = $this->lib->build_html_caps_blocked_for_single_admin();
            $html_caps_allowed_for_single_admin = $this->lib->build_html_caps_allowed_for_single_admin();
        }
        
        require_once( ABSPATH . RES . '/role-manager/admn/res/settings-template-ms.php');

    }
    // end of settings_ms_show()
            
 
    public function network_plugin_menu() {
        
        parent::network_plugin_menu();
        
        if ($this->lib->multisite) {
            $rm_page = add_submenu_page('users.php', esc_html__('Role Manager', 'role-manager'), esc_html__('Role Manager', 'role-manager'), 
            $this->key_capability, 'users-'.RM_PLUGIN_FILE, array($this, 'edit_roles'));
            add_action("admin_print_styles-$rm_page", array($this, 'admin_css_action'));        
        }
        
    } 
    // end of network_plugin_menu()
    
    public function add_js() {
        mn_register_script( 'rm-jquery-dual-listbox', admin_url( '/js/admn/jquery.dualListBox-1.3.js', RM_PLUGIN_FULL_PATH ) );
        mn_enqueue_script ( 'rm-jquery-dual-listbox' );
        mn_register_script( 'rm-js-admn', admin_url( '/js/admn/rm-js-admn.js', RM_PLUGIN_FULL_PATH ) );
        mn_enqueue_script ( 'rm-js-admn' );
        mn_localize_script( 'rm-js-admn', 'rm_data_pro', 
                array(
                    'update_network' => esc_html__('Update Network', 'role-manager')
                ));
    }
    // end of add_js()

    
    public function edit_user_profile($user) {

        global $current_user;
    
        if (!is_network_admin()) {
            parent::edit_user_profile($user);
            return;
        }
        
        if (!$this->lib->user_is_admin($current_user->ID)) {
            return;
        }
?>
        <h3><?php _e('Role Manager', 'role-manager'); ?></h3>
        <table class="form-table">
        		<tr>
        			<th scope="row"><?php _e('Roles', 'role-manager'); ?></th>
        			<td>
        <?php        
        $output = $this->lib->roles_text($user->roles);
        echo $output . '&nbsp;&nbsp;&gt;&gt;&nbsp;<a href="' . mn_nonce_url("users.php?page=users-".RM_PLUGIN_FILE."&object=user&amp;user_id={$user->ID}", "rm_user_{$user->ID}") . '">' . esc_html__('Edit', 'role-manager') . '</a>';
        ?>
        			</td>
        		</tr>
        </table>		
        <?php
    }
    // end of edit_user_profile()

    
    protected function allow_unfiltered_html() {
        
        if ( !$this->lib->multisite || !is_admin() ||  
             ((defined( 'DISALLOW_UNFILTERED_HTML' ) && DISALLOW_UNFILTERED_HTML)) ) {
            return;
        }
        
        $enable_unfiltered_html_ms = $this->lib->get_option('enable_unfiltered_html_ms', 0);
        if ($enable_unfiltered_html_ms) {
            add_filter('map_meta_cap', array($this, 'allow_unfiltered_html_filter'), 10, 2);
        }
        
    }
    // end of allow_unfiltered_html()
    
    
    public function allow_unfiltered_html_filter($caps, $cap='') {

        global $current_user;

        if ($cap=='unfiltered_html') {
            if (isset($current_user->allcaps['unfiltered_html']) && 
                $current_user->allcaps['unfiltered_html'] && $caps[0]=='do_not_allow') {
                $caps[0] = 'unfiltered_html';
                return $caps;
            }        
        }

        return $caps;

    }
    // end of allow_unfiltered_html_for_simple_admin()

    
    public function rm_ajax() {
                
        $ajax_processor = new RM_Mn_Ajax_Mncessor($this->lib);
        $ajax_processor->dispatch();
        
    }
    // end of rm_ajax()

    
    /**
     * Returns object with data about view access restrictions applied to the post with ID $post_id or
     * false in case there are not any view access restrictions for this post
     * 
     * @param int $post_id  Post ID
     * @return \stdClass|boolean
     */
    public function get_post_view_access_users($post_id) {
                    
        $activate_content_for_roles = $this->lib->get_option('activate_content_for_roles', false);
        if (!$activate_content_for_roles) {
            return false;
        }
        
        $result = RM_Content_View_Restrictions::get_post_view_access_users($post_id);
                        
        return $result;
    }
    // end of get_post_view_access_users($)
    
    
    // job to execute by MN Cron scheduler
    public function assign_role_to_users_without_role() {
        
        $assign_role = new RM_Assign_Role($this->lib);
        $assign_role->make();
    }
    // end of assign_role_to_users_without_role()

    
    public function show_notices_to_admin_only() {
        
        if (current_user_can('install_plugins')) {
            return;
        }
        echo '
<style>
    .update-nag, .notice { 
        display: none; 
    }
    #message.notice {
        display: block;
    }
</style>
';
    }
    // end of show_notices_to_admin_only()
    
}
// end of class Role_Manager_Mn