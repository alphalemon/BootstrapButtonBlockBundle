/*
 * This file is part of the BootstrapButtonBlockBundle and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright 
 * notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    MIT LICENSE
 * 
 */
 
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
