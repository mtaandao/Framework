<?php
/*
 * Mtaandao Role Manager Mtaandao plugin options page
 *
 * @Author: Mtaandao
 * @URL: http://mtaandao.co.ke
 * @package UserRoleEditor
 *
 */


?>
    <tr>
        <td>
            <input type="checkbox" name="show_notices_to_admin_only" id="show_notices_to_admin_only" value="1"
                   <?php echo ($show_notices_to_admin_only == 1) ? 'checked="checked"' : ''; ?> /> 
            <label for="show_notices_to_admin_only"><?php esc_html_e('Show plugins/designs notices to admin only', 'role-manager'); ?></label></td>
        <td>                        
        </td>
    </tr>