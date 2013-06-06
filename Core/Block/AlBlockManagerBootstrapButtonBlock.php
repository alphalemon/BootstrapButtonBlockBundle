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

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlockContainer;

/**
 * Defines the Block Manager to handle a Bootstrap Button
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapButtonBlock extends AlBlockManagerJsonBlockContainer
{
    /**
     * {@inheritdoc}
     */
    public function getDefaultValue()
    {
        $value = '
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
    
    /**
     * {@inheritdoc}
     */
    protected function renderHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Button:button.html.twig',
            'options' => array('data' => $items[0]),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
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
