/* 
 * Role Manager Mtaandao plugin Pro
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

jQuery(document).ready(function(){
    if (jQuery('#rm_allow_plugins').length==0) {
        return;
    }
    jQuery('#rm_select_allowed_plugins').multipleSelect({
            filter: true,
            multiple: true,
            selectAll: false,
            multipleWidth: 600,            
            maxHeight: 300,
            placeholder: "Select plugins you permit activate/deactivate",
            onClick: function(view) {
                rm_update_linked_controls_plugins();
            }
    });
      
    var allowed_plugins = jQuery('#rm_allow_plugins').val();
    var selected_plugins = allowed_plugins.split(',');
    jQuery('#rm_select_allowed_plugins').multipleSelect('setSelects', selected_plugins);      
            
});    


function rm_update_linked_controls_plugins() {
    var data_value = jQuery('#rm_select_allowed_plugins').multipleSelect('getSelects');
    var to_save = '';
    for (i=0; i<data_value.length; i++) {
        if (to_save!=='') {
            to_save = to_save + ', ';
        }
        to_save = to_save + data_value[i];
    }
    jQuery('#rm_allow_plugins').val(to_save);
    
    var data_text = jQuery('#rm_select_allowed_plugins').multipleSelect('getSelects', 'text');
    var to_show = '';
    for (i=0; i<data_text.length; i++) {        
        if (to_show!=='') {
            to_show = to_show + '\n';
        }
        to_show = to_show + data_text[i];
    }    
    jQuery('#show_allowed_plugins').val(to_show);    
}
