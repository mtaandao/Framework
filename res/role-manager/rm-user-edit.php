<?php

/*
 * 
 * Role Manager plugin: user capabilities editor page
 * 
 */

if (!defined('RES')) {
  die;  // Silence is golden, direct call is prohibited
}

$edit_user_caps_mode = $this->get_edit_user_caps_mode();
?>

<div class="has-sidebar-content">
<?php
    $switch_to_user = '';
	if (!is_multisite() || current_user_can('manage_network_users')) {
		$anchor_start = '<a href="' . mn_nonce_url("user-edit.php?user_id={$this->user_to_edit->ID}", 
          "rm_user_{$this->user_to_edit->ID}") .'" >';
		$anchor_end = '</a>';
  if (class_exists('user_switching') && current_user_can('switch_to_user', $this->user_to_edit->ID)) {
      $switch_to_user_link = user_switching::switch_to_url($this->user_to_edit);
      $switch_to_user = '<a href="'. esc_url($switch_to_user_link) .'">'. esc_html__('Switch&nbsp;To', 'user-switching') .'</a>';
  }
	} else {
		$anchor_start = '';
		$anchor_end = '';  
	}
  $user_info = ' <span style="font-weight: bold;">'.$anchor_start. $this->user_to_edit->user_login; 
  if ($this->user_to_edit->display_name!==$this->user_to_edit->user_login) {
    $user_info .= ' ('.$this->user_to_edit->display_name.')';
  }
  $user_info .= $anchor_end.'</span>';
 if (is_multisite() && is_super_admin($this->user_to_edit->ID)) {
   $user_info .= '  <span style="font-weight: bold; color:red;">'. esc_html__('Network Super Admin', 'role-manager') .'</span>';
 }
 
 if (!empty($switch_to_user)) {
     $user_info .= '&nbsp;&nbsp;&nbsp;&nbsp;'. $switch_to_user; 
 }
 
  
	 $this->display_box_start(esc_html__('Change capabilities for user', 'role-manager'). $user_info, 'min-width:1100px;');
 
?>
<table cellpadding="0" cellspacing="0" style="width: 100%;">
	<tr>
		<td>&nbsp;</td>		
		<td style="padding-left: 10px; padding-bottom: 5px;">
  <?php
    $caps_access_restrict_for_simple_admin = $this->get_option('caps_access_restrict_for_simple_admin', 0);
    if (is_super_admin() || !$this->multisite || !class_exists('Role_Manager_Mn') || !$caps_access_restrict_for_simple_admin) {  
        if ($this->caps_readable) {
            $checked = 'checked="checked"';
        } else {
            $checked = '';
        }
?>
  
		<input type="checkbox" name="rm_caps_readable" id="rm_caps_readable" value="1" 
      <?php echo $checked; ?> onclick="rm_turn_caps_readable(<?php echo $this->user_to_edit->ID; ?>);"  />
    <label for="rm_caps_readable"><?php esc_html_e('Show capabilities in human readable form', 'role-manager'); ?></label>&nbsp;&nbsp;&nbsp;
<?php
    if ($this->show_deprecated_caps) {
      $checked = 'checked="checked"';
    } else {
      $checked = '';
    }
?>
    <input type="checkbox" name="rm_show_deprecated_caps" id="rm_show_deprecated_caps" value="1" 
        <?php echo $checked; ?> onclick="rm_turn_deprecated_caps(<?php echo $this->user_to_edit->ID; ?>);"/>
    <label for="rm_show_deprecated_caps"><?php esc_html_e('Show deprecated capabilities', 'role-manager'); ?></label>      
<?php
    }
?>
		</td>
	</tr>	
	<tr>
		<td class="rm-user-roles">
			<div style="margin-bottom: 5px; font-weight: bold;"><?php esc_html_e('Primary Role:', 'role-manager'); ?></div>
<?php 
$show_admin_role = $this->show_admin_role_allowed();
// output primary role selection dropdown list
$this->user_primary_role_dropdown_list($this->user_to_edit->roles);

$values = array_values($this->user_to_edit->roles);
$primary_role = array_shift($values);  // get 1st element from roles array
if (function_exists('bbp_filter_blog_editable_roles') ) {  // bbPress plugin is active
?>	
	<div style="margin-top: 5px;margin-bottom: 5px; font-weight: bold;"><?php esc_html_e('bbPress Role:', 'role-manager'); ?></div>
<?php
	// Get the roles
	$dynamic_roles = bbp_get_dynamic_roles();
	$bbp_user_role = bbp_get_user_role($this->user_to_edit->ID);
	if (!empty($bbp_user_role)) {
		echo $dynamic_roles[$bbp_user_role]['name']; 
	}
}
?>
			<div style="margin-top: 5px;margin-bottom: 5px; font-weight: bold;"><?php esc_html_e('Other Roles:', 'role-manager'); ?></div>
<?php 	

	foreach ($this->roles as $role_id => $role) {
		if ( ($show_admin_role || $role_id!='administrator') && ($role_id!==$primary_role) ) {			
			if ( $this->user_can( $role_id ) ) {
				$checked = 'checked="checked"';
			} else {
				$checked = '';
			}
			echo '<label for="mn_role_' . $role_id .'"><input type="checkbox"	id="mn_role_' . $role_id . 
        '" name="mn_role_' . $role_id . '" value="' . $role_id . '"' . $checked .' />&nbsp;' . 
        esc_html__($role['name'], 'role-manager') . '</label><br />';
		}		
	}
 ?>
		</td>
		<td style="padding-left: 5px; padding-top: 5px; border-top: 1px solid #ccc;">  
	<span style="font-weight: bold;"><?php esc_html_e('Core capabilities:', 'role-manager'); ?></span>		
	<div style="display:table-inline; float: right; margin-right: 12px;">
		<?php esc_html_e('Quick filter:', 'role-manager'); ?>&nbsp;
		<input type="text" id="quick_filter" name="quick_filter" value="" size="20" onkeyup="rm_filter_capabilities(this.value);" />
	</div>		
	
  <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
    <tr>
      <td style="vertical-align:top;">
				<?php $this->show_capabilities( true, false, $edit_user_caps_mode ); ?>
      </td>
			<td>
				<?php $this->toolbar();?>
			</td>
    </tr>
  </table>
<?php 
	$quant = count( $this->full_capabilities ) - count( $this->get_built_in_mn_caps() );
	if ($quant>0) {		
     echo '<hr />';
?> 
	<span style="font-weight: bold;"><?php esc_html_e('Custom capabilities:', 'role-manager'); ?></span> 
  <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
    <tr>
      <td style="vertical-align:top;">
				<?php $this->show_capabilities( false, false, $edit_user_caps_mode ); ?>
      </td>
    </tr>
  </table>	
<?php
	}  // if ($quant>0)
?>
		</td>
	</tr>
</table>
  <input type="hidden" name="object" value="user" />
  <input type="hidden" name="user_id" value="<?php echo $this->user_to_edit->ID; ?>" />
<?php
  $this->display_box_end();
?>
  
</div>