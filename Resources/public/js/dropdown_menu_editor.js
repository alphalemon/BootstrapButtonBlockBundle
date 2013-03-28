$(document).ready(function() {
    $(document).on("popoverShow", function(event, element){
        blockType = element.attr('data-type');
        if (blockType != 'BootstrapDropdownButtonBlock' && blockType != 'BootstrapSplitDropdownButtonBlock' && blockType != 'BootstrapNavbarDropdownBlock') {
            return;
        }
        
        $(".al-editor-items").on('click', function(){
           if ( ! $('#al-dropdown-menu-items').is(":visible") && $('#al-dropdown-menu-items').html().trim() == "" ) {
                $.ajax({
                      type: 'POST',
                      url: frontController + 'backend/' + $('#al_available_languages option:selected').val() + '/al_show_jstree',
                      data: {
                          'page' :  $('#al_pages_navigator').html(),
                          'language' : $('#al_languages_navigator').html(),                    
                          'idBlock' : element.attr('data-block-id')
                      },
                      beforeSend: function()
                      {
                          $('body').AddAjaxLoader();
                      },
                      success: function(html)
                      {
                          $('#al-dropdown-menu-items').html(html);
                      },
                      error: function(err)
                      {
                          $('body').showDialog(err.responseText);
                      },
                      complete: function()
                      {
                          $('body').RemoveAjaxLoader();
                      }
                });
            }

            $("#al-dropdown-menu-items").toggle();

            return false;
        });
                 
        $('.al_editor_save').unbind().on('click', function()
        {
            var value = $('#al_item_form').serialize();
            if ($("#jstree").length > 0) {
                value += '&items=' + JSON.stringify($("#jstree").jstree("get_json", $("#jstree").jstree("select_node", -1)))
            }
            $('#al_item_form').EditBlock('Content', value);

            return false;
        });
    });
}); 
