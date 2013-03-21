<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\AlphaLemonCmsBundle\Core\Form\ModelChoiceValues\ChoiceValues;

/**
 * Description of AlBlockManagerBootstrapButtonBlock
 */
class AlBlockManagerBootstrapDropdownButtonBlock extends AlBlockManagerContainer
{
    protected $blockTemplate = 'BootstrapButtonBlockBundle:Button:dropdown_button.html.twig';  
    protected $editorTemplate = 'BootstrapButtonBlockBundle:Editor:dropdown_button_editor.html.twig';
    
    public function getDefaultValue()
    {
        $value = '
                {
                    "0": {
                        "button_text": "Dropdown Button 1",
                        "button_type": "",
                        "button_attribute": "",
                        "button_gropup" : "none",
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
    
    public function getHtml()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => $this->blockTemplate,
            'options' => array('data' => $items[0]),
        ));
    }
    
    protected function replaceHtmlCmsActive()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        $attributes = $item["items"];  
        unset($item["items"]);
        
        $imagesFormClass = $this->container->get('bootstrapbuttonblock.form');
        $buttonForm = $this->container->get('form.factory')->create($imagesFormClass, $item);
        
        $pagesRepository = $this->container->get('alpha_lemon_cms.factory_repository')->createRepository('Page');
        
        return array('RenderView' => array(
            'view' => $this->editorTemplate,
            'options' => array(                 
                'block_id' => $this->alBlock->getId(), 
                'data' => $item, 
                'attributes' => $attributes,                 
                'json_attributes' => json_encode($attributes), 
                'form' => $buttonForm->createView(),
                'pages' => ChoiceValues::getPages($pagesRepository)
            ),
        ));
    }
    
    protected function edit(array $values)
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
                $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
                $v += array('items' => $items[0]["items"]);
            }
            
            $values['Content'] = json_encode(array($v));
        }

        return parent::edit($values); 
    }
}
