<?php

/*
 * 
 * Role Manager plugin: role editor page
 * 
 */

if (!defined('RES')) {
  die;  // Silence is golden, direct call is prohibited
}

?>

<div class="has-sidebar-content">
  			<div class="postbox" style="float: left; min-width:850px;">
        	<h3>&nbsp;<?php esc_html_e('Select Role and change its capabilities:', 'role-manager'); ?> <?php echo $this->role_select_html; ?></h3>         
        	<div class="inside">        
<?php
  if ($this->caps_readable) {
    $checked = 'checked="checked"';
  } else {
    $checked = '';
  }
  $caps_access_restrict_for_simple_admin = $this->get_option('caps_access_restrict_for_simple_admin', 0);
  if (is_super_admin() || !$this->multisite || !$this->is_pro() || !$caps_access_restrict_for_simple_admin) {
?>              
            <input type="checkbox" name="rm_caps_readable" id="rm_caps_readable" value="1" 
                <?php echo $checked; ?> onclick="rm_turn_caps_readable(0);"/>
            <label for="rm_caps_readable"><?php esc_html_e('Show capabilities in human readable form', 'role-manager'); ?></label>&nbsp;&nbsp;
<?php
    if ($this->show_deprecated_caps) {
      $checked = 'checked="checked"';
    } else {
      $checked = '';
    }
?>
            <input type="checkbox" name="rm_show_deprecated_caps" id="rm_show_deprecated_caps" value="1" 
                <?php echo $checked; ?> onclick="rm_turn_deprecated_caps(0);"/>
            <label for="rm_show_deprecated_caps"><?php esc_html_e('Show deprecated capabilities', 'role-manager'); ?></label>              
<?php
  }
if ($this->multisite && $this->active_for_network && !is_network_admin() && is_main_site( get_current_blog_id() ) && is_super_admin()) {
  $hint = esc_html__('If checked, then apply action to ALL sites of this Network');
  if ($this->apply_to_all) {
    $checked = 'checked="checked"';
    $fontColor = 'color:#FF0000;';
  } else {
    $checked = '';
    $fontColor = '';
  }
?>
              <div style="float: right; margin-left:10px; margin-right: 20px; <?php echo $fontColor;?>" id="rm_apply_to_all_div">
                  <input type="checkbox" name="rm_apply_to_all" id="rm_apply_to_all" value="1" 
                      <?php echo $checked; ?> title="<?php echo $hint;?>" onclick="rm_applyToAllOnClick(this)"/>
                  <label for="rm_apply_to_all" title="<?php echo $hint;?>"><?php esc_html_e('Apply to All Sites', 'role-manager');?></label>
              </div>
<?php
}
?>
<br /><br />
<hr />
<?php esc_html_e('Core capabilities:', 'role-manager'); ?>
    <div style="display:table-inline; float: right; margin-right: 12px;">
		 <?php esc_html_e('Quick filter:', 'role-manager'); ?>&nbsp;
	     <input type="text" id="quick_filter" name="quick_filter" value="" size="20" onkeyup="rm_filter_capabilities(this.value);" />
    </div>	

        <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
          <tr>
            <td style="vertical-align:top;">
<?php $this->show_capabilities( true, true ); ?>
            </td>
						<td>
<?php $this->toolbar(!empty($this->role_delete_html), !empty($this->capability_remove_html));?>
						</td>
          </tr>
       </table>
<?php 
	$quant = count( $this->full_capabilities ) - count( $this->get_built_in_mn_caps() );
	if ($quant>0) {
		echo '<hr />';
		esc_html_e('Custom capabilities:', 'role-manager'); 
?>
        <table class="form-table" style="clear:none;" cellpadding="0" cellspacing="0">
          <tr>
            <td style="vertical-align:top;">
<?php $this->show_capabilities( false, true );	?>
            </td>
            <td></td>
          </tr>
      </table>
<?php
	}  // if ($quant>0)
 
 $this->role_additional_options->show($this->current_role);
 
?>
    <input type="hidden" name="object" value="role" />
<?php
  $this->display_box_end();
?>  
    <div style="clear: left; float: left; width: 800px;"></div>    
</div>
