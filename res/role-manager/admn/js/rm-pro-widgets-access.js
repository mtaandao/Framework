jQuery(function() {

    jQuery("#rm_widgets_access_button").button({
        label: rm_data_widgets_access.widgets
    }).click(function(event) {
        event.preventDefault();
        rm_widgets_access_dialog_prepare();
    });

});



function rm_widgets_access_dialog_prepare() {
    if (!jQuery('#edit_design_options').is(':checked')) {
        alert(rm_data_widgets_access.edit_design_options_required);
        return;
    }
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
            action: 'rm_ajax',
            sub_action: 'get_widgets_list',
            current_role: rm_current_role,
            mn_nonce: rm_data.mn_nonce
        },
        success: function(response) {
            var data = jQuery.parseJSON(response);
            if (typeof data.result !== 'undefined') {
                if (data.result === 'success') {                    
                    rm_widgets_access_dialog(data);
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


function rm_widgets_access_dialog(data) {
    jQuery(function($) {      
        $('#rm_widgets_access_dialog').dialog({                   
            dialogClass: 'mn-dialog',           
            modal: true,
            autoOpen: true, 
            closeOnEscape: true,      
            width: 650,
            height: 600,
            resizable: false,
            title: rm_data_widgets_access.dialog_title +' for "'+ rm_current_role +'"',
            'buttons'       : {
            'Update': function () {                                  
                    var form = $('#rm_widgets_access_form');
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
      $('#dialog-update-button').html(rm_data_widgets_access.update_button);
      $('.ui-dialog-buttonpane button:contains("Cancel")').attr("id", "dialog-cancel-button");
      $('#dialog-cancel-button').html(rm_data.cancel);
      
      $('#rm_widgets_access_container').html(data.html);
    });                                
    
}