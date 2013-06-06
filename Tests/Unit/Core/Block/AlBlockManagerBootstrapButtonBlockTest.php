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
use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapButtonBlock;

/**
 * AlBlockManagerBootstrapButtonBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapButtonBlockTest extends AlBlockManagerContainerBase
{  
    public function testDefaultValue()
    {
        $expectedValue = array(
            "Content" =>    
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
        '
        );
            
        $this->initContainer(); 
        $blockManager = new AlBlockManagerBootstrapButtonBlock($this->container, $this->validator);
        $this->assertEquals($expectedValue, $blockManager->getDefaultValue());
    }
    
    public function testGetHtml()
    {
        $value = '{
            "0" : {
                "button_text": "Button 1",
                "button_type": "danger",
                "button_attribute": "large",
                "button_block": "block",
                "button_enabled": "true"
            }
        }';
        
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $blockManager = new AlBlockManagerBootstrapButtonBlock($this->container, $this->validator);
        $blockManager->set($block);
        
        $expectedResult = array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Button:button.html.twig',
            'options' => array(
                'data' => array(
                    'button_text' => 'Button 1',
                    'button_type' => 'danger',
                    'button_attribute' => 'large',
                    'button_block' => 'block',
                    'button_enabled' => 'true',
                ),
                'block_manager' => $blockManager,
            ),
        ));
        
        $this->assertEquals($expectedResult, $blockManager->getHtml());
    }
    
    public function testEditorParameters()
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
            }';
        
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $formFactory->expects($this->at(0))
                    ->method('create')
                    ->will($this->returnValue($this->initForm()))
        ;
        
        $formType = $this->getMock('Symfony\Component\Form\FormTypeInterface');
        $this->container->expects($this->at(2))
                        ->method('get')
                        ->with('bootstrap_button_block.form')
                        ->will($this->returnValue($formType))
        ;
        
        $this->container->expects($this->at(3))
                        ->method('get')
                        ->with('form.factory')
                        ->will($this->returnValue($formFactory))
        ;
        
        $blockManager = new AlBlockManagerBootstrapButtonBlock($this->container, $this->validator);
        $blockManager->set($block);
        $result = $blockManager->editorParameters();
        $this->assertEquals('BootstrapButtonBlockBundle:Editor:button_editor.html.twig', $result["template"]);
    }
    
    protected function initBlock($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
              ->method('getContent')
              ->will($this->returnValue($value));

        return $block;
    }
    
    protected function initForm()
    {
        $form = $this->getMockBuilder('Symfony\Component\Form\Form')
                    ->disableOriginalConstructor()
                    ->getMock();
        $form->expects($this->once())
            ->method('createView')
        ;
        
        return $form;
    }
}
