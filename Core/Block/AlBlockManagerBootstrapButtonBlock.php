<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlockContainer;

/**
 * Description of AlBlockManagerBootstrapButtonBlock
 */
class AlBlockManagerBootstrapButtonBlock extends AlBlockManagerJsonBlockContainer
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
    
    protected function replaceHtmlCmsActive()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        
        $formClass = $this->container->get('bootstrapbuttonblock.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass, $item);
        
        return array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Editor:bootstrapbuttonblock_editor.html.twig',
            'options' => array(
                'data' => $item, 
                'form' => $buttonForm->createView(), 
                'parent' => $this->alBlock,
            ),
        ));
    }
}
