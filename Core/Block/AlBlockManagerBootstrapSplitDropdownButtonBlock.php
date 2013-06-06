<?php
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

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapDropdownButtonBlock;

/**
 * Defines the Block Manager to handle a Bootstrap Split Dropdown Button
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapSplitDropdownButtonBlock extends AlBlockManagerBootstrapDropdownButtonBlock
{
    protected $blockTemplate = 'BootstrapButtonBlockBundle:Button:split_dropdown_button.html.twig';  
    
    /**
     * {@inheritdoc}
     */
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
