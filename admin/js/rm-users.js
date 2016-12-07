/* Role Manager for users.php */

jQuery(document).ready(function() {        
    jQuery('#move_from_no_role_content').append(rm_users_data.to +' <select id="rm_new_role" name="rm_new_role"></select>');
    var rm_new_role = jQuery('#rm_new_role');
    var options = jQuery("#new_role > option").clone();
    jQuery('#rm_new_role').empty().append(options);
    if (jQuery('#rm_new_role option[value="no_rights"]').length === 0) {
        jQuery('#rm_new_role').append('<option value="no_rights">' + rm_users_data.no_rights_caption + '</option>');
    }

    // Exclude change role to
    jQuery('#rm_new_role option[value=""]').remove();
    var new_role = jQuery('#new_role').find(":selected").val();
    if (new_role.length > 0) {
        rm_new_role.val(new_role);
    }
    rm_new_role.trigger('updated');    
});



function rm_move_users_from_no_role_dialog() {    
    
    jQuery('#move_from_no_role_dialog').dialog({
        dialogClass: 'mn-dialog',
        modal: true,
        autoOpen: true,
        closeOnEscape: true,
        width: 400,
        height: 200,
        resizable: false,
        title: rm_users_data.move_from_no_role_title,
        'buttons': {
            'OK': function () {
                rm_move_users_from_no_role();
                jQuery(this).dialog('close');
            },
            Cancel: function () {
                jQuery(this).dialog('close');
                return false;
            }
        }
    });
        
}
  
  
function rm_move_users_from_no_role() {
    var new_role = jQuery('#rm_new_role').find(":selected").val();
    if (new_role.length==0) {
        alert(rm_users_data.provide_new_role_caption);
        return;
    }
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
            action: 'rm_ajax',
            sub_action: 'get_users_without_role',
            mn_nonce: rm_users_data.mn_nonce,
            new_role: new_role
        },
        success: function(response) {
            var data = jQuery.parseJSON(response);
            if (typeof data.result !== 'undefined') {
                if (data.result === 'success') {                    
                    rm_post_move_users_command(data);
                } else if (data.result === 'failrm') {
                    alert(data.message);
                } else {
                    alert('Wrong response: ' + response)
                }
            } else {
                alert('Wrong response: ' + response)
            }
        },
        error: function(XMLHttpRequest, textStatus, exception) {
            alert("Ajax failrm\n" + errortext);
        },
        async: true
    });

}


function rm_post_move_users_command(data) {
    var options = jQuery("#rm_new_role > option").clone();
    jQuery('#new_role').empty().append(options);
    jQuery("#new_role").val(data.new_role);
    var el = jQuery('.bulkactions').append();
    for(var i=0; i<data.users.length; i++) {
        if (jQuery('#user_'+ data.users[i]).length>0) {
            jQuery('#user_'+ data.users[i]).prop('checked', true);
        } else {
            var html = '<input type="checkbox" name="users[]" id="user_'+ data.users[i] +'" value="'+ data.users[i] +'" checked="checked" style="display: none;">';
            el.append(html);
        }
    }
    
    // submit form
    jQuery('#changeit').click();
}
