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
    
    protected function renderHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Button:button.html.twig',
            'options' => array('data' => $items[0]),
        ));
    }
    
    public function editorParameters()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        
        $formClass = $this->container->get('bootstrap_button_block.form');
        $buttonForm = $this->container->get('form.factory')->create($formClass, $item);
        
        return array(
            "template" => "BootstrapButtonBlockBundle:Editor:button_editor.html.twig",
            "title" => "Button editor",
            "form" => $buttonForm->createView(),
        );
    }
}
