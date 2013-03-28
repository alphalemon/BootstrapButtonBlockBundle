<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapDropdownButtonBlock;

/**
 * Description of AlBlockManagerBootstrapSplitDropdownButtonBlock
 */
class AlBlockManagerBootstrapSplitDropdownButtonBlock extends AlBlockManagerBootstrapDropdownButtonBlock
{
    protected $blockTemplate = 'BootstrapButtonBlockBundle:Button:split_dropdown_button.html.twig';  
    
    public function getDefaultValue()
    {
        $value = '
                {
                    "0": {
                        "button_text": "Split Dropdown Button 1",
                        "button_type": "",
                        "button_attribute": "",
                        "button_dropup" : "none",
                        "items": [
                            {
                                "data" : "Item 1", 
                                "metadata" : {  
                                    "type": "link",
                                    "href": "#",
                                    "attributes": {}
                                }
                            },
                            { 
                                "data" : "Item 2", 
                                "metadata" : {  
                                    "type": "link",
                                    "href": "#",
                                    "attributes": {}
                                }
                            },
                            { 
                                "data" : "Item 3", 
                                "metadata" : {  
                                    "type": "link",
                                    "href": "#",
                                    "attributes": {}
                                }
                            }
                        ]
                    }
                }
            ';
        
        return array('Content' => $value);
    }
}
