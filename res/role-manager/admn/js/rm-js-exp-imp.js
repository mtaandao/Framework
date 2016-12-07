// change color of apply to all check box - for multi-site setup only - overrides the same function from the standard RM
function rm_applyToAllOnClick(cb) {
  el = document.getElementById('rm_apply_to_all_div');
  el_1 = document.getElementById('rm_import_to_all_div');
  if (cb.checked) {
    el.style.color = '#FF0000';
    el_1.style.color = '#FF0000';
    document.getElementById('rm_import_to_all').checked = true;
  } else {
    el.style.color = '#000000';
    el_1.style.color = '#000000';
    document.getElementById('rm_import_to_all').checked = false;
  }
}


// change color of apply to all check box - for multi-site setup only - overrides the same function from the standard RM
function rm_importToAllOnClick(cb) {
  el = document.getElementById('rm_import_to_all_div');
  if (cb.checked) {
    el.style.color = '#FF0000';
  } else {
    el.style.color = '#000000';
  }
}


function rm_import_roles_dialog() {
    jQuery(function ($) {
        $info = $('#rm_import_roles_dialog');
        $info.dialog({
            dialogClass: 'mn-dialog',
            modal: true,
            autoOpen: true,
            closeOnEscape: true,
            width: 550,
            height: 190,
            resizable: false,
            title: rm_data_exp_imp.import_roles_title,
            'buttons': {
                'Import': function () {
                    var file_name = $('#roles_file').val();
                    if (file_name == '') {
                        alert(rm_data_exp_imp.select_file_with_roles);
                        return false;
                    }
                    var form = $('#rm_import_roles_form');
                    form.attr('action', rm_data.page_url);
                    $("<input type='hidden'>")
                            .attr("name", 'rm_nonce')
                            .attr("value", rm_data.mn_nonce)
                            .appendTo(form);
                    form.submit();
                    $(this).dialog('close');
                },
                'Cancel': function () {
                    $(this).dialog('close');
                    return false;
                }
            }
        });
        $('.ui-dialog-buttonpane button:contains("Import")').attr("id", "dialog-import-roles-button");
        $('#dialog-import-roles-button').html(rm_data_exp_imp.import_roles);
        $('.ui-dialog-buttonpane button:contains("Cancel")').attr("id", "dialog-cancel-button");
        $('#dialog-cancel-button').html(rm_data.cancel);
    });                                    
}

jQuery(function() {

    jQuery("#rm_export_roles_button").button({
        label: rm_data_exp_imp.export_roles
    }).click(function(event) {
        event.preventDefault();
        jQuery.rm_postGo( rm_data.page_url, 
                      { action: 'export-roles', 
                        rm_nonce: rm_data.mn_nonce} );
    });

    jQuery("#rm_import_roles_button").button({
        label: rm_data_exp_imp.import_roles
    }).click(function(event) {
        event.preventDefault();
        rm_import_roles_dialog();
    });


});
