/* 
 * Role Manager Mtaandao plugin Pro
 * Available Themes list edit
 * Author: Mtaandao
 * email: dev@mtaandao.co.ke
 * 
 */

jQuery(document).ready(function(){
    if (jQuery('#rm_allow_designs').length==0) {
        return;
    }
    jQuery('#rm_select_allowed_designs').multipleSelect({
            filter: true,
            multiple: true,
            selectAll: false,
            multipleWidth: 600,
            maxHeight: 300,
            placeholder: "Select designs you permit to activate",
            onClick: function(view) {
                rm_update_linked_controls_designs();
            }
    });
      
    var allowed_designs = jQuery('#rm_allow_designs').val();
    var selected_designs = allowed_designs.split(',');
    jQuery('#rm_select_allowed_designs').multipleSelect('setSelects', selected_designs);
      
});    


function rm_update_linked_controls_designs() {
    var data_value = jQuery('#rm_select_allowed_designs').multipleSelect('getSelects');
    var to_save = '';
    for (i=0; i<data_value.length; i++) {
        if (to_save!=='') {
            to_save = to_save + ', ';
        }
        to_save = to_save + data_value[i];
    }
    jQuery('#rm_allow_designs').val(to_save);
    
    var data_text = jQuery('#rm_select_allowed_designs').multipleSelect('getSelects', 'text');
    var to_show = '';
    for (i=0; i<data_text.length; i++) {        
        if (to_show!=='') {
            to_show = to_show + '\n';
        }
        to_show = to_show + data_text[i];
    }    
    jQuery('#show_allowed_designs').val(to_show);
}
