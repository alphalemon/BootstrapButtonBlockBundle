$(document).ready(function() {
    $(document).on("popoverShow", function(event, idBlock, blockType){
        if (blockType != 'BootstrapButtonsGroupBlock') {
            return;
        }
        
        $('#al_add_item').list('addItem');
        $('.al_edit_item').list('editItem');
        $('.al_delete_item').list('deleteItem');
        $('#al_save_item').list('save');
        $('.al_form_item').list('saveAttributes');
    });
});
