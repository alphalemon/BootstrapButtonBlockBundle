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

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBase;

/**
 * Defines the Block Manager to handle a Bootstrap Dropdown Button
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapDropdownButtonBlock extends AlBlockManagerContainer
{
    protected $blockTemplate = 'BootstrapButtonBlockBundle:Button:dropdown_button.html.twig';  
    protected $editorTemplate = 'BootstrapButtonBlockBundle:Editor:_dropdown_editor.html.twig';
    
    /**
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {
        $value = '
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
            ';
        
        return array('Content' => $value);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderHtml()
    {
        $items = AlBlockManagerJsonBase::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => $this->blockTemplate,
            'options' => array('data' => $items[0]),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function editorParameters()
    {
        $items = AlBlockManagerJsonBase::decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        $attributes = $item["items"];  
        unset($item["items"]);
        
        $formClass = $this->container->get('bootstrapbuttonblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass, $item);
        
        return array(
            "template" => $this->editorTemplate,
            "title" => "Button editor",
            "form" => $buttonForm->createView(),
            'attributes' => $attributes,  
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function edit(array $values)
    {
        $values = $this->saveDropdownItems($values);

        return parent::edit($values); 
    }
    
    /**
     * Saves the dropdown items
     *
     * @param array
     * @return array
     */
    protected function saveDropdownItems(array $values)
    {
        if (array_key_exists('Content', $values)) {
            $unserializedData = array();
            $serializedData = $values['Content'];
            parse_str($serializedData, $unserializedData);
            
            $v = $unserializedData["al_json_block"];          
            if (array_key_exists("items", $unserializedData)) {
                unset($unserializedData["al_json_block"]);
                $menuItems = json_decode($unserializedData["items"], true);
                $v += array('items' => $menuItems[0]["children"]); // Excludes the root node "Menu"
            } else {
                $items = AlBlockManagerJsonBase::decodeJsonContent($this->alBlock->getContent());
                $v += array('items' => $items[0]["items"]);
            }
            
            $values['Content'] = json_encode(array($v));
        }
        
        return $values;
    }
}
