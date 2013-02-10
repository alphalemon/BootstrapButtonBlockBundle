<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

/**
 * Description of AlBlockManagerBootstrapButtonBlock
 */
class AlBlockManagerBootstrapButtonBlock extends AlBlockManagerJsonBlock
{
    public function getDefaultValue()
    {
        $value = 
            '
                {
                    "0" : {
                        "button_text": "Button 1",
                        "button_type": "",
                        "button_attribute": "",
                        "button_block": "",
                        "button_enabled": ""
                    }
                }
            ';
        
        return array('Content' => $value);
    }
    
    public function getHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Button:button.html.twig',
            'options' => array('data' => $items[0]),
        ));
    }
    
    protected function getEditorWidth() 
    {
        return 400;
    }
}