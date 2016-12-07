<?php
/*
 * Role Manager Mtaandao plugin options page
 *
 * @Author: Mtaandao
 * @URL: http://mtaandao.co.ke
 * @package UserRoleEditor
 *
 */


?>
<div class="wrap">
    <a href="http://mtaandao.co.ke">
        <div id="rm-icon" class="icon32"><br></div>        
    </a>    
    <h1><?php esc_html_e('Role Manager Options', 'role-manager'); ?></h1>

    <h1 id="rm_tabs" style="clear: left" class="nav-tab-wrapper mn-clearfix">
            <a href="#rm_tabs-1" class="nav-tab nav-tab-active"><?php _e( 'General Settings' ); ?></a>
            <a href="#rm_tabs-2" class="nav-tab"><?php _e( 'Additional Modules' ); ?></a>
            <a href="#rm_tabs-3" class="nav-tab"><?php _e( 'Default Roles' ); ?></a>

            <?php
    if ( $this->lib->multisite && ($this->lib->is_pro() || is_super_admin()) ) {
?>
            <a href="#rm_tabs-4" class="nav-tab"><?php _e( 'Multisite' ); ?></a>
<?php
}
?>
</h1></div>
<div>
    <div id="rm_tabs-1" class="clear">
    <div id="rm-settings-form">
        <form method="post" action="<?php echo $link; ?>?page=settings-<?php echo RM_PLUGIN_FILE; ?>" >   
            <table id="rm_settings">
<?php
if (!$license_key_only) {
?>
                <tr>
                    <td>
                        <input type="checkbox" name="show_admin_role" id="show_admin_role" value="1" 
                        <?php echo ($show_admin_role == 1) ? 'checked="checked"' : ''; ?>
                               <?php echo defined('RM_SHOW_ADMIN_ROLE') ? 'disabled="disabled" title="Predefined by \'RM_SHOW_ADMIN_ROLE\' constant at config.php"' : ''; ?> />
                        <label for="show_admin_role"><?php esc_html_e('Show Administrator role at Role Manager', 'role-manager'); ?></label></td>
                    <td> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="caps_readable" id="caps_readable" value="1" 
                               <?php echo ($caps_readable == 1) ? 'checked="checked"' : ''; ?> />
                        <label for="caps_readable"><?php esc_html_e('Show capabilities in the human readable form', 'role-manager'); ?></label></td>
                    <td>                         
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="show_deprecated_caps" id="show_deprecated_caps" value="1" 
                               <?php echo ($show_deprecated_caps == 1) ? 'checked="checked"' : ''; ?> /> 
                        <label for="show_deprecated_caps"><?php esc_html_e('Show deprecated capabilities', 'role-manager'); ?></label></td>
                    <td>                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="confirm_role_update" id="confirm_role_update" value="1" 
                               <?php echo ($confirm_role_update == 1) ? 'checked="checked"' : ''; ?> /> 
                        <label for="confirm_role_update"><?php esc_html_e('Confirm role update', 'role-manager'); ?></label></td>
                    <td>                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="edit_user_caps" id="edit_user_caps" value="1" 
                               <?php echo ($edit_user_caps == 1) ? 'checked="checked"' : ''; ?> /> 
                        <label for="edit_user_caps"><?php esc_html_e('Edit user capabilities', 'role-manager'); ?></label></td>
                    <td>                        
                    </td>
                </tr>
                
<?php
}
    do_action('rm_settings_show1');
?>
            </table>
    <?php mn_nonce_field('role-manager'); ?>   
            <input type="hidden" name="rm_tab_idx" value="0" />
            <p class="submit">
                <input type="submit" class="button-primary" name="rm_settings_update" value="<?php _e('Save', 'role-manager') ?>" />
            </p>  

        </form>  
    </div>   
    </div> <!-- rm_tabs-1 -->
<?php
if (!$license_key_only) {
    if ($this->lib->is_pro() || !$this->lib->multisite) {
?>
    
    <div id="rm_tabs-2">
        <form name="rm_additional_modules" method="post" action="<?php echo $link; ?>?page=settings-<?php echo RM_PLUGIN_FILE; ?>" >
            <table id="rm_addons">
<?php
if (!$this->lib->multisite) {
?>
                <tr>
                    <td>
                        <input type="checkbox" name="count_users_without_role" id="count_users_without_role" value="1" 
                               <?php echo ($count_users_without_role == 1) ? 'checked="checked"' : ''; ?> /> 
                        <label for="count_users_without_role"><?php esc_html_e('Count users without role', 'role-manager'); ?></label></td>
                    <td>                        
                    </td>
                </tr>
<?php      
}
?>
                
<?php                
    do_action('rm_settings_show2');
?>
            </table>    
<?php mn_nonce_field('role-manager'); ?>   
            <input type="hidden" name="rm_tab_idx" value="1" />
            <p class="submit">
                <input type="submit" class="button-primary" name="rm_addons_settings_update" value="<?php _e('Save', 'role-manager') ?>" />
                
        </form>    
    </div>    
<?php
    }
?>
    
    <div id="rm_tabs-3">
        <form name="rm_default_roles" method="post" action="<?php echo $link; ?>?page=settings-<?php echo RM_PLUGIN_FILE; ?>" >
<?php 
    if (!$this->lib->multisite) {
        esc_html_e('Primary default role: ', 'role-manager');
        echo $this->lib->role_default_html;
?>
        <hr>
<?php
    } 
?>
        <?php esc_html_e('Other default roles for new registered user: ', 'role-manager'); ?>
        <div id="other_default_roles">
            <?php $this->lib->show_other_default_roles(); ?>
        </div>
<?php 
    if ($this->lib->multisite) {
        echo '<p>'. esc_html__('Note for multisite environment: take into account that other default roles should exist at the site, in order to be assigned to the new registered users.', 'role-manager') .'</p>';
    }
?>
        <hr>
        <?php mn_nonce_field('role-manager'); ?>   
            <input type="hidden" name="rm_tab_idx" value="2" />
            <p class="submit">
                <input type="submit" class="button-primary" name="rm_default_roles_update" value="<?php _e('Save', 'role-manager') ?>" />
            </p>
        </form>      
    </div> <!-- rm_tabs-3 -->   
    
<?php
    if ( $this->lib->multisite && ($this->lib->is_pro() || is_super_admin())) {
?>
    <div id="rm_tabs-4">
        <div id="rm-settings-form-ms">
            <form name="rm_settings_ms" method="post" action="<?php echo $link; ?>?page=settings-<?php echo RM_PLUGIN_FILE; ?>" >
                <table id="rm_settings_ms">
<?php
    if (is_super_admin()) {
?>
                    <tr>
                         <td>
                             <input type="checkbox" name="allow_edit_users_to_not_super_admin" id="allow_edit_users_to_not_super_admin" value="1" 
                                  <?php echo ($allow_edit_users_to_not_super_admin == 1) ? 'checked="checked"' : ''; ?> /> 
                             <label for="allow_edit_users_to_not_super_admin"><?php esc_html_e('Allow non super administrators to create, edit, and delete users', 'role-manager'); ?></label>
                         </td>
                         <td>
                         </td>
                    </tr>                          
<?php
    }
                    do_action('rm_settings_ms_show');                    
?>                    
                </table>
<?php mn_nonce_field('role-manager'); ?>   
                <input type="hidden" name="rm_tab_idx" value="3" />
            <p class="submit">
                <input type="submit" class="button-primary" name="rm_settings_ms_update" value="<?php _e('Save', 'role-manager') ?>" />
            </p>                  
            </form>
        </div>   <!-- rm-settings-form-ms --> 
    </div>  <!-- rm_tabs-4 -->
<?php
    }
}   // if (!$license_key_only) {
?>
    </div> <!-- rm_tabs -->
</div></div></div>
<script>
    jQuery(function() {
        jQuery('#rm_tabs').tabs();
<?php
    if ($rm_tab_idx>0) {
?>
        jQuery("#rm_tabs").tabs("option", "active", <?php echo $rm_tab_idx; ?>);    
<?php
    }
?>
    });    
</script>
