jQuery(function() {

    jQuery("#rm_admin_menu_access_button").button({
        label: rm_data_admin_menu_access.admin_menu
    }).click(function(event) {
        event.preventDefault();
        rm_admin_menu_access_dialog_prepare();
    });        

});



function rm_admin_menu_access_dialog_prepare() {
    
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
            action: 'rm_ajax',
            sub_action: 'get_admin_menu',
            current_role: rm_current_role,
            mn_nonce: rm_data.mn_nonce
        },
        success: function(response) {
            var data = jQuery.parseJSON(response);
            if (typeof data.result !== 'undefined') {
                if (data.result === 'success') {                    
                    rm_admin_menu_access_dialog(data);
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
            alert("Ajax failrm\n" + exception);
        },
        async: true
    });    
    
}




function rm_admin_menu_access_dialog(data) {
    jQuery(function($) {      
        $('#rm_admin_menu_access_dialog').dialog({                   
            dialogClass: 'mn-dialog',           
            modal: true,
            autoOpen: true, 
            closeOnEscape: true,      
            width: 760,
            height: 700,
            resizable: false,
            title: rm_data_admin_menu_access.dialog_title +' for "'+ rm_current_role +'"',
            'buttons'       : {
            'Update': function () {                                  
                    var form = $('#rm_admin_menu_access_form');                    
                    form.submit();
                    $(this).dialog('close');
            },
            'Cancel': function() {
                $(this).dialog('close');
                return false;
            }
          }
      });    
      $('.ui-dialog-buttonpane button:contains("Update")').attr("id", "dialog-update-button");
      $('#dialog-update-button').html(rm_data_admin_menu_access.update_button);
      $('.ui-dialog-buttonpane button:contains("Cancel")').attr("id", "dialog-cancel-button");
      $('#dialog-cancel-button').html(rm_data.cancel);      
      $('#rm_admin_menu_access_container').html(data.html);
      $('#rm_admin_menu_select_all').click(rm_admin_menu_auto_select);
    });                                
    
}


function rm_admin_menu_auto_select(event) {
    jQuery(function($) {
        if (event.shiftKey) {
            $('.rm-cb-column').each(function () {   // reverse selection
                $(this).prop('checked', !$(this).prop('checked'));
            });
        } else {    // switch On/Off all checkboxes
            $('.rm-cb-column').prop('checked', $('#rm_admin_menu_select_all').prop('checked'));

        }
    });
}