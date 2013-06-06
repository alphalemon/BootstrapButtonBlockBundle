<?php
/*
 * This file is part of the BootstrapAccordionBlockBundle and it is distributed
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
use AlphaLemon\Block\BootstrapButtonBlockBundle\Core\Block\AlBlockManagerBootstrapButtonsGroupBlock;


/**
 * AlBlockManagerBootstrapAccordionBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapButtonsGroupBlockTest extends AlBlockManagerContainerBase
{  
    public function testDefaultValue()
    {
        $expectedValue = array(
            array(
                "type" => "BootstrapButtonBlock",
            ),
            array(
                "type" => "BootstrapButtonBlock",
            ),
            array(
                "type" => "BootstrapButtonBlock",
            ),
        );
            
        $this->initContainer(); 
        $blockManager = new AlBlockManagerBootstrapButtonsGroupBlock($this->container, $this->validator);
        $defaultValue = $blockManager->getDefaultValue();
        $this->assertEquals($expectedValue, json_decode($defaultValue["Content"], true));
    }
    
    public function testGetHtml()
    {
        $value = '
        {
            "0" : {
                "type": "BootstrapButtonBlock"
            },
            "1" : {
                "type": "BootstrapButtonBlock"
            },
            "2" : {
                "type": "BootstrapButtonBlock"
            }
        }';
            
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $blockManager = new AlBlockManagerBootstrapButtonsGroupBlock($this->container, $this->validator);
        $blockManager->set($block);
        
        $expectedResult = array('RenderView' => array(
            'view' => 'BootstrapButtonBlockBundle:Button:buttons_group.html.twig',
            'options' => array(
                'buttons' => array(
                    array(
                        "type" => "BootstrapButtonBlock",
                    ),
                    array(
                        "type" => "BootstrapButtonBlock",
                    ),
                    array(
                        "type" => "BootstrapButtonBlock",
                    ),
                ),
                'block_manager' => $blockManager,
            ),
        ));
        
        $this->assertEquals($expectedResult, $blockManager->getHtml());
    }
    
    protected function initBlock($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
              ->method('getContent')
              ->will($this->returnValue($value));

        return $block;
    }
}
