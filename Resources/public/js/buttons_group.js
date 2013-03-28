$(document).ready(function() 
{
    $(document).on("blockEditing", function(event, element){
        if (element.attr('data-type') != 'BootstrapButtonsGroupBlock') {
            return;
        }
        
        element.inlinelist('start', { 
          target: 'button',
          addValue: '{"operation": "add", "value": { "type": "BootstrapButtonBlock" }}'
        });
    });
    
    $(document).on("blockStopEditing", function(event, element){ 
        if (element.attr('data-type') != 'BootstrapButtonsGroupBlock') {
            return;
        }
                
        element.inlinelist('stop');
    });
});
