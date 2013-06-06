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

class AlBlockManagerBootstrapDropdownButtonBlockTester extends AlBlockManagerBootstrapDropdownButtonBlock
{
    public function saveDropdownItemsTester($values)
    {
        return $this->saveDropdownItems($values);
    }
}

/**
 * AlBlockManagerBootstrapDropdownButtonBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
abstract class AlBlockManagerBootstrapDropdownTestBase extends AlBlockManagerContainerBase
{  
    abstract protected function getBlockManager();
    
    protected function defaultValueTest($expectedValue)
    {    
        $this->initContainer(); 
        $blockManager = $this->getBlockManager();
        $this->assertEquals($expectedValue, $blockManager->getDefaultValue());
    }
    
    public function getHtmlTest($value, $items, $template)
    {
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $blockManager = $this->getBlockManager();
        $blockManager->set($block);
        
        $expectedResult = array('RenderView' => array(
            'view' => $template,
            'options' => array(
                'data' => array(
                    'button_text' => 'Dropdown Button 1',
                    'button_type' => 'danger',
                    'button_attribute' => 'large',
                    'button_gropup' => 'none',
                    'items' => $items,
                ),
                'block_manager' => $blockManager,
            ),
        ));
        
        $this->assertEquals($expectedResult, $blockManager->getHtml());
    }
    
    public function editorParametersTest($value, $template)
    {
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
                        ->with('bootstrapbuttonblock.form')
                        ->will($this->returnValue($formType))
        ;
        
        $this->container->expects($this->at(3))
                        ->method('get')
                        ->with('form.factory')
                        ->will($this->returnValue($formFactory))
        ;
        
        $blockManager = $this->getBlockManager();
        $blockManager->set($block);
        $result = $blockManager->editorParameters();
        $this->assertEquals($template, $result["template"]);
    }
    
    
    public function testManageJsonCollection()
    {
        //$this->markTestSkipped('TODO');
        
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
        
        
        $values["Content"] = 'al_json_block%5Bbutton_text%5D=Dropdown+Button+1&al_json_block%5Bbutton_type%5D=&al_json_block%5Bbutton_attribute%5D=&al_json_block%5Bbutton_block%5D=&al_json_block%5Bbutton_enabled%5D=&items=[{"data":"Menu","attr":{"id":"menu","class":""},"state":"open","metadata":{},"children":[{"data":"Item 1","attr":{},"metadata":{"type":"link","href":"add-a-custom-theme-to-alphalemon-cms","attributes":[]}},{"data":"Item 2","attr":{},"metadata":{"type":"link","href":"#","attributes":[]}},{"data":"Item 3","attr":{"class":""},"metadata":{"type":"link","href":"#","attributes":[]}}]}]';
                
        $blockManager = new AlBlockManagerBootstrapDropdownButtonBlockTester($this->container, $this->validator);
        $block = $this->initBlock($value);        
        $blockManager->set($block); 
        
        $result = $blockManager->saveDropdownItemsTester($values);
        $expectedResult = array('Content' => '[{"button_text":"Dropdown Button 1","button_type":"","button_attribute":"","button_block":"","button_enabled":"","items":[{"data":"Item 1","attr":[],"metadata":{"type":"link","href":"add-a-custom-theme-to-alphalemon-cms","attributes":[]}},{"data":"Item 2","attr":[],"metadata":{"type":"link","href":"#","attributes":[]}},{"data":"Item 3","attr":{"class":""},"metadata":{"type":"link","href":"#","attributes":[]}}]}]');
        $this->assertEquals($expectedResult, $result);
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
