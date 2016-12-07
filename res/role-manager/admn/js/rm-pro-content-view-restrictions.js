/* 
 * Content View Restrictions
 * Mtaandao Role Manager Mtaandao plugin
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */


jQuery(document).ready(function(){
    rm_post_view_roles_button();
    rm_post_access_error_action_select();
    jQuery('#rm_return_http_error_404').click(function(){
        rm_post_access_error_action_select();
    });
    jQuery('#rm_show_post_access_error_message').click(function(){
        rm_post_access_error_action_select();
    });
});    


function rm_post_access_error_action_select() {
    
    if (jQuery('input[name=rm_post_access_error_action]:checked', '#post').val()==1) { // return 404 HTTP error
        jQuery('#rm_post_access_error_message_container').hide();
    } else {    // show custom error message
        jQuery('#rm_post_access_error_message_container').show();
    }
}


//----------------------------
// Post editor metabox support

function rm_post_view_roles_button() {
    if (jQuery('#edit_content_for_roles').length==0) {
        return;
    }
    
    jQuery("#edit_content_for_roles").button({
        label: rm_data_pro.edit_content_for_roles
    }).click(function (event) {
        event.preventDefault();
        jQuery('#edit_roles_list_dialog').dialog({
            dialogClass: 'mn-dialog',
            modal: true,
            autoOpen: true,
            closeOnEscape: true,
            width: 450,
            height: 400,
            resizable: false,
            title: rm_data_pro.edit_content_for_roles,
            'buttons': {
                'Save': function () {
                    rm_post_view_save_roles_list();
                    jQuery(this).dialog('close');
                },
                'Close': function () {
                    jQuery(this).dialog('close');
                    return false;
                }
            }
        });
    });
    jQuery('.ui-dialog-buttonpane button:contains("Save")').attr("id", "save-roles-list-button");
    jQuery('#save-roles-list-button').html(rm_data_pro.save_roles_list);
    jQuery('.ui-dialog-buttonpane button:contains("Cancel")').attr("id", "dialog-close-button");
    jQuery('#dialog-close-button').html(rm_data_pro.close);
    jQuery('#rm_roles_auto_select').click(rm_post_view_roles_auto_select);
}


function rm_post_view_save_roles_list() {
    
    var selected_roles = new Array();
    jQuery('#edit_roles_list_dialog_content input:checked').each(function() {
        if (jQuery(this).attr('id')!='rm_roles_auto_select') {
            selected_roles.push(jQuery(this).attr('name'));
        }
    });
        
    var to_save = '';
    for (i=0; i<selected_roles.length; i++) {
        if (to_save!=='') {
            to_save = to_save + ', ';
        }
        to_save = to_save + selected_roles[i];
    }
    jQuery('#rm_content_for_roles').html(to_save);
        
}


function rm_post_view_roles_auto_select(event) {
    jQuery(function($) {
        if (event.shiftKey) {
            $('.rm_role_cb').each(function () {   // reverse selection
                $(this).prop('checked', !$(this).prop('checked'));
            });
        } else {    // switch On/Off all checkboxes
            $('.rm_role_cb').prop('checked', $('#rm_roles_auto_select').prop('checked'));
        }
    });
}

// end of Post editor metabox support
//-----------------------------------
