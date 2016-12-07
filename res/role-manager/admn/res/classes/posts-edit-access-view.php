<?php
/*
 * Class: Edit access to posts/pages for role data views support
 * Project: Mtaandao Role Manager Mtaandao plugin
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

class RM_Posts_Edit_Access_View {
 

    /**
     * echo HTML for modal dialog window
     */
    static public function dialog_html() {
        
?>
        <div id="rm_posts_edit_access_dialog" class="rm-modal-dialog">
            <div id="rm_posts_edit_access_container">
            </div>    
        </div>
<?php        
        
    }
    // end of dialog_html()

    
    static public function add_toolbar_button() {
        
        $button_title = esc_html__('Allow/Prohibit editing selected posts', 'role-manager');
        $button_label = esc_html__('Posts Edit', 'role-manager');
?>                
        <button id="rm_posts_edit_access_button" class="rm_toolbar_button" title="<?php echo $button_title; ?>"><?php echo $button_label; ?></button>
<?php

    }
    // end of add_toolbar_button()
    
    /**
     * Build and return the string with HTML form for input/update posts edit access data 
     * 
     * @param array $args
     * @return string
     */
    static public function get_html($args) {
        global $pagenow;
        
        extract($args);
        $checked0 = ($restriction_type==0) ? 'checked' : '';
        $checked1 = ($restriction_type==1) ? 'checked' : '';
        $checked2 = ($restriction_type==2) ? 'checked' : '';
        $checked3 = ($own_data_only==1) ? 'checked':'';
        
        ob_start();
        if (isset($user_profile)) { // show section at user profile
            echo '<h3>'. esc_html__('Posts/Pages/Custom Post Types Editor Restrictions', 'role-manager') .'</h3>'.PHP_EOL;
        } else {    // show form with data for currently selected role at Role Manager dialog window
?>
<form name="rm_posts_edit_access_form" id="rm_posts_edit_access_form" method="POST"
      action="<?php echo RM_MN_ADMIN_URL . RM_PARENT .'?page=users-'. RM_PLUGIN_FILE;?>" >
<?php
        }
?>        
        <table class="form-table">
            <tr>
                <th scope="role">
                    <?php esc_html_e('What to do', 'role-manager'); ?>
                </th>    
                <td>
                    <input type="radio" name="rm_posts_restriction_type" id="rm_posts_restriction_type1" value="1" <?php  echo $checked1;?> >
                    <label for="rm_posts_restriction_type1"><?php esc_html_e('Allow', 'role-manager'); ?></label>&nbsp;
                    <input type="radio" name="rm_posts_restriction_type" id="rm_posts_restriction_type2" value="2" <?php  echo $checked2;?> >
                    <label for="rm_posts_restriction_type2"><?php esc_html_e('Prohibit', 'role-manager'); ?></label>&nbsp;
<?php
    if ($pagenow=='user-edit.php') {
?>
                    <input type="radio" name="rm_posts_restriction_type" id="rm_posts_restriction_type0" value="0" <?php  echo $checked0;?> >
                    <label for="rm_posts_restriction_type0"><?php esc_html_e('Look at roles', 'role-manager'); ?></label>
<?php
    }
?>
                </td>
            </tr>    
            <tr>
        			<th scope="row">               
               <?php esc_html_e('Own data only', 'role-manager'); ?>
           </th>
        			<td>
               <input type="checkbox" name="rm_own_data_only" id="rm_own_data_only" <?php echo $checked3;?> value="1"/>
        			</td>
        		</tr>
        		<tr>
        			<th scope="row">               
               <?php esc_html_e('with post ID (comma separated)', 'role-manager'); ?>
           </th>
        			<td>
               <input type="text" name="rm_posts_list" id="rm_posts_list" value="<?php echo $posts_list; ?>" size="40" />
        			</td>
        		</tr>    
          <tr>
        			<th scope="row">               
               <?php esc_html_e('with category/taxonomy ID (comma separated)', 'role-manager'); ?>
           </th>
        			<td>
               <input type="text" name="rm_categories_list" id="rm_categories_list" value="<?php echo $categories_list; ?>" size="40" />
        			</td>
        		</tr>
<?php
            if ($show_authors) {
?>
          <tr>
        			<th scope="row">
               <?php esc_html_e('with author user ID (comma separated)', 'role-manager'); ?>
           </th>
        			<td>
               <input type="text" name="rm_post_authors_list" id="rm_post_authors_list" value="<?php echo $post_authors_list; ?>" size="40" />
        			</td>
        		</tr>
<?php
            }
?>
        </table>		                
<?php
if (!isset($user_profile)) {
?>
    <input type="hidden" name="action" id="action" value="rm_update_posts_edit_access" />
    <input type="hidden" name="rm_object_type" id="rm_object_type" value="<?php echo $object_type;?>" />
    <input type="hidden" name="rm_object_name" id="rm_object_name" value="<?php echo $object_name;?>" />
<?php    
    if ($object_type=='role') {
?>
    <input type="hidden" name="user_role" id="rm_role" value="<?php echo $object_name;?>" />
<?php
    }
    mn_nonce_field('role-manager', 'rm_nonce'); 
?>
</form>
<?php    
}
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
    }
    // end of get_html()
    
}
// end of RM_Posts_Edit_Access_View class


