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
 
namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Tests\Unit\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Tests\Unit\Core\Content\Block\Base\AlBlockManagerContainerBase;
use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapDropdownButtonBlock;

/**
 * AlBlockManagerBootstrapDropdownButtonBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapDropdownButtonBlockTest extends AlBlockManagerBootstrapDropdownTestBase
{  
    protected function getBlockManager()
    {
        return new AlBlockManagerBootstrapDropdownButtonBlock($this->container, $this->validator);
    }
    
    public function testDefaultValue()
    {
        $expectedValue = array(
            "Content" =>    
            '
            {
                "0": {
                    "button_text": "Dropdown Button 1",
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
            '
        );
            
        $this->defaultValueTest($expectedValue);
    }
    
    public function testGetHtml()
    {
        $value = '{
            "0": {
                "button_text": "Dropdown Button 1",
                "button_type": "danger",
                "button_attribute": "large",
                "button_gropup" : "none",
                "items": [
                    {
                        "data" : "Item 1", 
                        "metadata" : {  
                            "type": "link",
                            "href": "#",
                            "attributes": {}
                        }
                    }
                ]
            }
        }';
        
        $items = array(
            array(
                "data" => "Item 1", 
                "metadata" => array(
                    "type" => "link",
                    "href" => "#",
                    "attributes" => array(),
                ),
            ),
        );
        
        $this->getHtmlTest($value, $items, 'BootstrapButtonBlockBundle:Button:dropdown_button.html.twig');        
    }
    
    public function testEditorParameters()
    {
        $value = '{
            "0": {
                "button_text": "Dropdown Button 1",
                "button_type": "danger",
                "button_attribute": "large",
                "button_gropup" : "none",
                "items": [
                    {
                        "data" : "Item 1", 
                        "metadata" : {  
                            "type": "link",
                            "href": "#",
                            "attributes": {}
                        }
                    }
                ]
            }
        }';
        
        $this->editorParametersTest($value, 'BootstrapButtonBlockBundle:Editor:_dropdown_editor.html.twig');
    }
}
