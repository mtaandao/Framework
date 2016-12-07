/* 
 * Role Manager Mtaandao plugin Pro
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

jQuery(function() {
    jQuery("#rm_update_all_network").button({
        label: rm_data_pro.update_network
    }).click(function(event) {
        event.preventDefault();
        show_update_network_dialog();
                
    });
});


function show_update_network_dialog() {
    jQuery('#rm_network_update_dialog').dialog({                   
        dialogClass: 'mn-dialog',           
        modal: true,
        autoOpen: true, 
        closeOnEscape: true,      
        width: 400,
        height: 230,
        resizable: false,
        title: rm_data_pro.update_network,
        'buttons'       : {
            'Update': function (event) {
                event.preventDefault();
                
                var apply_to_all = document.createElement("input");
                apply_to_all.setAttribute("type", "hidden");
                apply_to_all.setAttribute("id", "rm_apply_to_all");
                apply_to_all.setAttribute("name", "rm_apply_to_all");
                apply_to_all.setAttribute("value", '1');
                document.getElementById("rm_form").appendChild(apply_to_all);
                
                if (jQuery('#rm_replicate_widgets_access_restrictions0').length>0) {
                    var checked = jQuery('#rm_replicate_widgets_access_restrictions0').is(':checked');                
                    if (checked) {
                        var rwar = document.createElement("input");
                        rwar.setAttribute("type", "hidden");
                        rwar.setAttribute("id", "rm_replicate_widgets_access_restrictions");
                        rwar.setAttribute("name", "rm_replicate_widgets_access_restrictions");
                        rwar.setAttribute('value', 1);
                        document.getElementById("rm_form").appendChild(rwar);
                    }
                }
                                
                jQuery('#rm_form').submit();
                jQuery(this).dialog('close');
            },
            Cancel: function() {
                jQuery(this).dialog('close');
                return false;
            }
          }
      });
}

