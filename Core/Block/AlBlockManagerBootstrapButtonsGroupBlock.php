<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

/**
 * Description of AlBlockManagerBootstrapButtonsGroupBlock
 */
class AlBlockManagerBootstrapButtonsGroupBlock extends AlBlockManagerContainer
{
    private $visibleColumns = array('button_text');
    
    public function getDefaultValue()
    {
        $value =
        '{            
            "0" : {
                "button_text": "Button 1",
                "button_type": "",
                "button_attribute": "",
                "button_block": "",
                "button_enabled": ""
            },
            "1" : {
                "button_text": "Button 2",
                "button_type": "",
                "button_attribute": "",
                "button_block": "",
                "button_enabled": ""
            },
            "2" : {
                "button_text": "Button 3",
                "button_type": "",
                "button_attribute": "",
                "button_block": "",
                "button_enabled": ""
            }
        }';
        
        return array('Content' => $value);
    }
    
    public function isColumnVisible($columnName)
    {
        return in_array($columnName, $this->visibleColumns);
    }
    
    public function getHtml()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $buttons = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent(), true);
        
        return array(
            "RenderView" => array(
                "view" => "BootstrapButtonBlockBundle:Button:buttons_group.html.twig",
                "options" => array(
                    "buttons" => $buttons,
                )
            )
        );
    }
    
    protected function replaceHtmlCmsActive()
    {
        $buttons = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        $formClass = $this->container->get('bootstrapbuttonblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass);
        
        return array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Editor:buttons_group_editor.html.twig',
            'options' => array(
                'items' => $buttons, 
                'block_manager' => $this,
                'form' => $buttonForm->createView(), 
                'parent' => $this->alBlock,
            ),
        ));
    }
    
    protected function edit(array $values)
    {
        $formClass = $this->container->get('bootstrapbuttonblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass);
        
        $formName = $buttonForm->getName() . "_";
        $values["Content"] = str_replace($formName, "", $values["Content"]);
        
        return parent::edit($values);
    }
}
